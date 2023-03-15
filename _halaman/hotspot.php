<script type="text/javascript">
		// $(document).ready(function(){
        //     setInterval(function(){
        //         $("#ceksensor").load('_halaman/arduino/bacasensor.php');
        //     },1000);
        // });
		$(document).ready(function(){
            setInterval(function(){
                $("#datajam").load('_halaman/arduino/cekjam.php');
            },1000);
        });
	    function ubahStatus(value){
            if(value== true) value = "ON";
            else value = "OFF";
            document.getElementById('status').innerHTML = value;

            // ajax untuk merubah status nilai relay
            var xmlhtpp = new XMLHttpRequest();

            xmlhtpp.onreadystatechange = function(){
                if(xmlhtpp.readyState == 4 && xmlhtpp.status == 200)
                {
                    document.getElementById('status').innerHTML = xmlhtpp.
                    responseText;
                }
            }
            // xmlhtpp.open("GET","relay/?stat=" + value, true); // Codeigniter
            xmlhtpp.open("GET","_halaman/arduino/relay.php?stat=" + value, true); //php
            xmlhtpp.send();
        }
        // function ubahposisiservo(value){
        //     document.getElementById('posisi').innerHTML = value;
        // }
</script>
<style type="text/css">
	.tengah{
		display : flex;
		flex-direction: column;
		justify-content: center;
		align-items:center;
		text-align:center;
	}

</style>
<?php
  $title="Hotspot";
  $judul=$title;
  $url='hotspot';
if(isset($_POST['simpan'])){
	$file=upload('marker','marker');
	if($file!=false){
		$data['marker']=$file;
		if($_POST['id_hotspot']!=''){
			// hapus file di dalam folder
			$db->where('id_hotspot',$_GET['id']);
			$get=$db->ObjectBuilder()->getOne('tbl_hotspot');
			$marker=$get->marker;
			unlink('assets/unggah/marker/'.$marker);
			// end hapus file di dalam folder
		}
	}
	$data['id_jalan']=$_POST['id_jalan'];
	$data['keterangan']=$_POST['keterangan'];
	$data['lokasi']=$_POST['lokasi'];
	$data['lat']=$_POST['lat'];
	$data['lng']=$_POST['lng'];
	$data['tanggal']=$_POST['tanggal'];
	if($_POST['id_hotspot']==""){
		$exec=$db->insert("tbl_hotspot",$data);
		$info='<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Sukses!</h4> Data Sukses Ditambah </div>';
		
	}
	else{
		$db->where('id_hotspot',$_POST['id_hotspot']);
		$exec=$db->update("tbl_hotspot",$data);
		$info='<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Sukses!</h4> Data Sukses diubah </div>';
	}

	if($exec){
		$session->set('info',$info);
	}
	else{
      $session->set("info",'<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4> Proses gagal dilakukan <br>'.$db->getLastError().'
              </div>');
	}
	redirect(url($url));
}

if(isset($_GET['hapus'])){
	$setTemplate=false;
	$db->where("id_hotspot",$_GET['id']);
	$exec=$db->delete("tbl_hotspot");
	$info='<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Sukses!</h4> Data Sukses dihapus </div>';
	if($exec){
		$session->set('info',$info);
	}
	else{
      $session->set("info",'<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4> Proses gagal dilakukan
              </div>');
	}
	redirect(url($url));
}
if(isset($_POST['simpan_relay'])){
	$data['jam']=$_POST['jam_relay'];
	$data['status']= $_POST['status'];
	if($_POST['id']==""){
		$konek = mysqli_connect("localhost","root","","webgis_php");
		$alter_ai=mysqli_query($konek,"ALTER TABLE set_wakturelay AUTO_INCREMENT = 1;");
		$exec=$db->insert("set_wakturelay",$data);
		$info='<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Sukses!</h4> Data Sukses Ditambah </div>';
		
	}
	if($exec){
		$session->set('info',$info);
	}
	else{
      $session->set("info",'<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4> Proses gagal dilakukan <br>'.$db->getLastError().'
              </div>');
	}
	redirect(url($url.'&set_wakturelay'));
}
if(isset($_GET['hapus_relay'])){
	$setTemplate=false;
	$db->where("id",$_GET['id']);
	$exec=$db->delete("set_wakturelay");
	$info='<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Sukses!</h4> Data Sukses dihapus </div>';
	if($exec){
		$session->set('info',$info);
	}
	else{
      $session->set("info",'<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4> Proses gagal dilakukan
              </div>');
	}
	redirect(url($url.'&set_wakturelay'));
}

elseif(isset($_GET['tambah']) OR isset($_GET['ubah'])){
  $id_hotspot="";
  $id_jalan="";
  $lokasi="";
  $keterangan="";
  $lat="";
  $lng="";
  $tanggal=date('Y-m-d');
  if(isset($_GET['ubah']) AND isset($_GET['id'])){
  	$id=$_GET['id'];
  	$db->where('id_hotspot',$id);
	$row=$db->ObjectBuilder()->getOne('tbl_hotspot');
	if($db->count>0){
		$id_hotspot=$row->id_hotspot;
		$id_jalan=$row->id_jalan;
		$lokasi=$row->lokasi;
		$keterangan=$row->keterangan;
		$lat=$row->lat;
		$lng=$row->lng;
		$tanggal=$row->tanggal;
	}
  }
?>
<?=content_open('Form Hotspot')?>
   <form method="post" enctype="multipart/form-data">
    	<?=input_hidden('id_hotspot',$id_hotspot)?>
    	<div class="form-group">
    		<label>Lokasi</label>
    		<div class="row">
	    		<div class="col-md-4">
	    			<?=input_text('lokasi',$lokasi)?>
		    	</div>
	    	</div>
    	</div>
    	<div class="form-group">
    		<label>Nama Jalan</label>
    		<div class="row">
	    		<div class="col-md-6">
	    			<?php
	    				$op['']='Pilih Jalan';
	    				foreach ($db->ObjectBuilder()->get('tbl_jalan') as $row) {
	    					$op[$row->id_jalan]=$row->nm_jalan;
	    				}
	    			?>
	    			<?=select('id_jalan',$op,$id_jalan)?>
	    		</div>
    		</div>
    	</div>
    	<div class="form-group">
    		<label>Keterangan</label>
    		<div class="row">
	    		<div class="col-md-4">
    				<?=textarea('keterangan',$keterangan)?>
    			</div>
    		</div>
    	</div>
    	<div class="form-group">
    		<label>Titik Koordinat</label> 
    		<div class="row">
	    		<div class="col-md-3">
	    			<?=input_text('lat',$lat)?>
	    		</div>
	    		<div class="col-md-3">
	    			<?=input_text('lng',$lng)?>
	    		</div>
    		</div>
    	</div>
    	<div class="form-group">
    		<label>Tanggal</label>
    		<div class="row">
	    		<div class="col-md-4">
    				<?=input_date('tanggal',$tanggal)?>
    			</div>
    		</div>
    	</div>
    	<div class="form-group">
    		<label>Marker</label>
    		<div class="row">
	    		<div class="col-md-4">
    				<?=input_file('marker','')?>
    			</div>
    		</div>
    	</div>
    	<div class="form-group">
    		<button type="submit" name="simpan" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
			<a href="<?=url($url)?>" class="btn btn-danger" ><i class="fa fa-reply"></i> Kembali</a>
    	</div>
    </form>
<?=content_close()?>

<?php  }elseif(isset($_GET['set_wakturelay']) OR isset($_GET[''])){
	

?>
<?=content_open('Form Waktu Relay')?>
<div class="content">
	<div class="container-fluid tengah">
		<div style="text-align: center"> <h3>
		<i class="fa fa-clock"></i>	SET PENGATURAN WAKTU RELAY
		</h3></div>
		<div style="width: 500px">
			<div class="card card-cart" style="height: auto">
			<div class="card-header card-header-success">
				SET WAKTU RELAY
			</div>
			<div class="card-body">
				Jam Sekarang :
				<h2 style="font-weight: bold;">
				<div id="datajam"></div>
				</h2>
				<br>
				<div class="form-group">
					<form method="post">
						<div class="form-group">
							<input type="time" name="jam_relay" id="jam" class="form-control mt-2 mb-2">
						</div>
						<div class="form-group">
							<select name="status" id="status">
								<option>~ STATUS RELAY~</option>
								<option value="1">1</option>
								<option value="0">0</option>
							</select>
						</div>
						<div class="form-group">
							<button type="submit" name="simpan_relay" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
						</div>
					</form>
				</div>
				<table class="table table-bordered" style="text-align:center;">
				<tr style="background-color: grey; color:white;">
					<th>No</th>
					<th>List Jam</th>
					<th>Status</th>
					<th style="width: 100px;">Aksi</th>
				</tr>
				<?php 
				$no = 1;
				$getdata=$db->ObjectBuilder()->get('set_wakturelay');
				foreach ($getdata as $row) {
				?>
				<tr>
					<td style="text-align:left;"><?= $no;?></td>
					<td style="text-align:left;"><?= $row->jam?></td>
					<td style="text-align:left;"><?= $row->status?></td>
					<td>
						<a href="<?=url($url.'&hapus_relay&id='.$row->id)?>" class="btn btn-danger" onclick="return confirm('Hapus data?')"><i class="fa fa-trash"></i> </a>
					</td>
				</tr>
				<?php
				$no++;
				} ?>
				</table>
			</div>
			</div>
		</div>
	</div>
</div>
<?=content_close()?>
<?php
}else { ?>
<?=content_open('Data Hotspot')?>

<a href="<?=url($url.'&tambah')?>" class="btn btn-success" ><i class="fa fa-plus"></i> Tambah</a>
<a href="<?=url($url.'&set_wakturelay')?>" class="btn btn-info" ><i class="fa fa-clock"></i> Set Waktu Relay</a>
<hr>
<?=$session->pull("info")?>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Lokasi</th>
			<th>Nama Jalan</th>
			<th>Keterangan</th>
			<th>Lat</th>
			<th>Lng</th>
			<th>Tanggal</th>
			<th>Marker</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$no=1;
			$db->join('tbl_jalan b','a.id_jalan=b.id_jalan','LEFT');
			$getdata=$db->ObjectBuilder()->get('tbl_hotspot a');
			foreach ($getdata as $row) {
				?>
					<tr>
						<td><?=$no?></td>
						<td><?=$row->lokasi?></td>
						<td><?=$row->nm_jalan?></td>
						<!-- <td>
						<!-- <input name="relayInput" type="checkbox" <?php if($row->relay == 1) echo "checked"; ?> onchange='ubahStatus(this.checked)'>
						<label><span id="status"><?php 
						// if($row->relay == 1) echo "ON"; else echo "OFF"
						?></span>
						</label>
						</td> --> 
						<td><?=$row->keterangan?></td>
						<td><?=$row->lat?></td>
						<td><?=$row->lng?></td>
						<td><?=$row->tanggal?></td>
						
						<td class="text-center"><?=($row->marker==''?'-':'<img src="'.assets('unggah/marker/'.$row->marker).'" width="40px">')?></td>
						<td>
							<a href="<?=url($url.'&ubah&id='.$row->id_hotspot)?>" class="btn btn-info"><i class="fa fa-edit"></i> Ubah</a>
							<a href="<?=url($url.'&hapus&id='.$row->id_hotspot)?>" class="btn btn-danger" onclick="return confirm('Hapus data?')"><i class="fa fa-trash"></i> Hapus</a>
						</td>
					</tr>
			<?php
			$no ++;
			}
			?>
	</tbody>
</table>
<?=content_close()?>
<?php } ?>
	