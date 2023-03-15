<?php
  $title="Laporan";
  $judul=$title;
  $url='Laporan';
  $fileJs='leaflet-laporanJs';
  if ($session->get('level')!='Admin'){
	redirect(url('beranda'));
}
if(isset($_POST['simpan'])){
	$file=upload('foto','foto');
	if($file!=false){
		$data['marker']=$file;
		if($_POST['id']!=''){
			// hapus file di dalam folder
			$db->where('id_pengaduan',$_GET['id']);
			$get=$db->ObjectBuilder()->getOne('pengaduan');
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
	if($_POST['id_pengaduan']==""){
		$exec=$db->insert("pengaduan",$data);
		$info='<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Sukses!</h4> Data Sukses Ditambah </div>';
		
	}
	if(isset($_POST['simpan'])){
		$db->where('id_pengaduan',$_POST['id_pengaduan']);
		$exec=$db->update("pengaduan",$data);
		$info='<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Sukses!</h4> Data Sukses dikonfirmasi </div>';
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
	$db->where("id_pengaduan",$_GET['id']);
	$exec=$db->delete("pengaduan");
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

elseif(isset($_GET['tambah']) OR isset($_GET['ubah'])){
  $id_pengaduan="";
  $id_jalan="";
  $lokasi="";
  $keterangan="";
  $tanggal=date('Y-m-d');
  if(isset($_GET['ubah']) AND isset($_GET['id'])){
  	$id=$_GET['id'];
  	$db->where('id_pengaduan',$id);
	$row=$db->ObjectBuilder()->getOne('pengaduan');
	if($db->count>0){
		$id_pengaduan=$row->id_pengaduan;
		$id_jalan=$row->id_jalan;
		$nama=$row->nama_masyarakat;
		$lokasi=$row->lokasi;
		$lat=$row->lat;
		$lng=$row->lng;
		$nik=$row->nik;
		$foto=$row->foto;
		$keterangan=$row->keterangan;
		$gambar=$row->foto;
		$tanggal=$row->tanggal;
	}
  }
?>
<?=content_open('Form Laporan')?>
   <form method="post" enctype="multipart/form-data">
    	<?=input_hidden('id_pengaduan',$id_pengaduan)?>
		
		<div class="form-group">
    		<label>Nik</label>
    		<div class="row">
	    		<div class="col-md-4">
	    			<?=input_text('nik',$nik)?>
		    	</div>
	    	</div>
    	</div>
		<div class="form-group">
    		<label>Nama</label>
    		<div class="row">
	    		<div class="col-md-4">
	    			<?=input_text('nama',$nama)?>
		    	</div>
	    	</div>
    	</div>
		<div class="form-group">
    		<label>Keterangan</label>
    		<div class="row">
	    		<div class="col-md-4">
	    			<?=input_text('keterangan',$keterangan)?>
		    	</div>
	    	</div>
    	</div>
		<div class="form-group">
    		<label>Gambar Kerusakan</label>
    		<div class="row">
	    		<div class="col-md-4">
				<?=($gambar==''?'-':'<img src="'.assets('unggah/foto/'.$gambar).'" width="500px">')?>
		    	</div>
	    	</div>
    	</div>
		<div class="form-group">
    		<label>Lokasi/Jalan</label>
    		<div class="row">
	    		<div class="col-md-4">
	    			<?=input_text('lokasi',$lokasi)?>
		    	</div>
	    	</div>
    	</div>
		<div class="form-group">
    		<label>Lokasi/Jalan</label>
    		<div class="row">
	    		<div class="col-md-2">
	    			<?=input_text('lat',$lat)?>
		    	</div>
				<div class="col-md-2">
	    			<?=input_text('lng',$lng)?>
					<?=input_hidden('tanggal',$tanggal)?>
		    	</div>
	    	</div>
    	</div>
		<div class="form-group">
    		<label>Maps</label>
    		<div class="row">
	    		<div class="col-md-8">
					<div id="mapid"></div>
		    	</div>
	    	</div>
    	</div>
		<div class="form-group">
    		<button type="submit" name="simpan" class="btn btn-info"><i class="fa fa-save"></i> Konfirmasi</button>
			<a href="<?=url($url)?>" class="btn btn-danger" ><i class="fa fa-reply"></i> Kembali</a>
    	</div>
    </form>
<?=content_close()?>

<?php  } else { ?>
<?=content_open('Data Laporan')?>
<hr>
<?=$session->pull("info")?>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Nik</th>
			<th>Nama Melapor</th>
			<th>Lokasi</th>
			<th>Latitude</th>
			<th>Longitude</th>
			<th>Keterangan</th>
			<th>Tanggal</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$no=1;
			$db->join('tbl_jalan b','a.id_jalan=b.id_jalan','LEFT');
			$getdata=$db->ObjectBuilder()->get('pengaduan a');
			foreach ($getdata as $row) {
				?>
					<tr>
						<td><?=$no?></td>
						<td><?=$row->nik?></td>
						<td><?=$row->nama_masyarakat?></td>
						<td><?=$row->lokasi?></td>
						<td><?=$row->lat?></td>
						<td><?=$row->lng?></td>
						<td><?=$row->keterangan?></td>
						<td><?=$row->tanggal?></td>
						<!-- <td class="text-center"><?=($row->marker==''?'-':'<img src="'.assets('unggah/marker/'.$row->marker).'" width="40px">')?></td> -->
						<td>
							<a href="<?=url($url.'&ubah&id='.$row->id_pengaduan)?>" class="btn btn-info"><i class="fa fa-edit"></i> Detail</a>
							<a href="<?=url($url.'&hapus&id='.$row->id_pengaduan)?>" class="btn btn-danger" onclick="return confirm('Hapus data?')"><i class="fa fa-trash"></i> Hapus</a>
						</td>
					</tr>
				<?php
				$no++;
			}

		?>
	</tbody>
</table>
<?=content_close()?>
<?php } ?>
