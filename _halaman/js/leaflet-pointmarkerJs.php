<!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js" integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA=="
   crossorigin=""></script>

 <script src="assets/js/leaflet-panel-layers-master/src/leaflet-panel-layers.js"></script>
 <script src="assets/js/leaflet.ajax.js"></script>

   <script type="text/javascript">

	var map = L.map('mapid').setView([-5.1499967,119.4309084],16);

   	var LayerKita=L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox.streets',
    accessToken: 'pk.eyJ1IjoiZ3VuYXdhbmhhbGltMTciLCJhIjoiY2t6cjF2c3ByM3hwbDJ5bnIzdXI2ajQwcyJ9.o6vsXU_V-XzWQBZCKKZgYQ',
});
	map.addLayer(LayerKita);

	var myStyle2 = {
	    "color": "#ffff00",
	    "weight": 1,
	    "opacity": 0.9
	};

	function popUp(f,l){
	    var out = [];
	    if (f.properties){
	        // for(key in f.properties){
	        // 	console.log(key);

	        // }
			out.push("Provinsi: "+f.properties['PROVINSI']);
			out.push("Jalan: "+f.properties['JALAN']);
	        l.bindPopup(out.join("<br />"));
	    }
	}

	// legend

	function iconByName(name) {
		return '<i class="icon" style="background-color:'+name+';border-radius:50%"></i>';
	}

	function featureToMarker(feature, latlng) {
		return L.marker(latlng, {
			icon: L.divIcon({
				className: 'marker-'+feature.properties.amenity,
				html: iconByName(feature.properties.amenity),
				iconUrl: '../images/markers/'+feature.properties.amenity+'.png',
				iconSize: [25, 41],
				iconAnchor: [12, 41],
				popupAnchor: [1, -34],
				shadowSize: [41, 41]
			})
		});
	}

	var baseLayers = [
		// {
		// 	name: "OpenStreetMap",
		// 	layer: LayerKita
		// },
		{	
			name: "OpenCycleMap",
			layer: L.tileLayer('http://{s}.tile.opencyclemap.org/cycle/{z}/{x}/{y}.png')
		},
		{
			name: "Outdoors",
			layer: L.tileLayer('http://{s}.tile.thunderforest.com/outdoors/{z}/{x}/{y}.png')
		}
	];

	<?php
		$getJalan=$db->ObjectBuilder()->get('tbl_jalan');
		foreach ($getJalan as $row) {
			?>

			var myStyle<?=$row->id_jalan?> = {
			    "color": "<?=$row->warna_jalan?>",
			    "weight": 1,
			    "opacity": 1
			};

			<?php
			// icon: iconByName("'.$row->warna_jalan.'"),
			$arrayKec[]='{
			name: "'.$row->nm_jalan.'",
			
			layer: new L.GeoJSON.AJAX(["assets/unggah/geojson/'.$row->geojson_jalan.'"],{onEachFeature:popUp,style: myStyle'.$row->id_jalan.',pointToLayer: featureToMarker }).addTo(map)
			}';
		}
	?>

	var overLayers = [{
		group: "Layer Jalan",
		layers: [
		<?=implode(',', $arrayKec);?>
		]
	}
	];

	var panelLayers = new L.Control.PanelLayers(baseLayers, overLayers,{
		collapsibleGroups: true
	});

	map.addControl(panelLayers);

	// marker
	var myIcon = L.Icon.extend({
	    options: {
	    	iconSize: [38, 45]
	    }
	});

	<?php
	$db->join('tbl_jalan b','a.id_jalan=b.id_jalan','LEFT');
	$getdata=$db->ObjectBuilder()->get('tbl_hotspot a');
	foreach ($getdata as $row) {
		?>
		L.marker([<?=$row->lat?>,<?=$row->lng?>],{icon: new myIcon({iconUrl: '<?=($row->marker=='')?assets('icons/marker.png'):assets('unggah/marker/'.$row->marker)?>'})}).addTo(map)
				.bindPopup("Lokasi : <?=$row->lokasi?>,Jalan: <?=$row->nm_jalan?><br>Keterangan : <?=$row->keterangan?><br>Tanggal : <?=$row->tanggal?>");
		<?php
	}
	?>

   </script>