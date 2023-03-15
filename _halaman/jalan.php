<?php
  $title="Data Jalan";
  $judul=$title;
  $url='jalan';
  if ($session->get('level')!='Admin'){
  	redirect(url('beranda'));
  }

if(isset($_POST['simpan'])){
	$file = upload('geojson_jalan','geojson');
	if($file!=false){
		$data['geojson_jalan']=$file;
		if($_POST['id_jalan']!=''){
			// hapus file di dalam folder
			$db->where('id_jalan',$_GET['id']);
			$get=$db->ObjectBuilder()->getOne('tbl_jalan');
			$geojson_jalan=$get->geojson_jalan;
			unlink('assets/unggah/geojson/'.$geojson_jalan);
			// end hapus file di dalam folder
		}
	}


	// cek validasi
	$validation=null;
	// cek kode apakah sudah ada
	if($_POST['id_jalan']!=""){
		$db->where('id_jalan !='.$_POST['id_jalan']);
	}
	$db->where('kd_wilayah',$_POST['kd_wilayah']);
	$db->get('tbl_jalan');
	if($db->count>0){
		$validation[]='Kode Jalan Sudah Ada';
	}
	//tidak boleh kosong
	if($_POST['nm_jalan']==''){
		$validation[]='Nama Jalan Tidak Boleh Kosong';
	}

	if($validation!=null){
		$setTemplate=false;
		$session->set('error_validation',$validation);
		$session->set('error_value',$_POST);
		redirect($_SERVER['HTTP_REFERER']);
		return false;
	}
	// cek validasi



	if($_POST['id_jalan']==""){
		$data['kd_wilayah']=$_POST['kd_wilayah'];
		$data['nm_jalan']=$_POST['nm_jalan'];
		$exec=$db->insert("tbl_jalan",$data);
		$info='<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Sukses!</h4> Data Sukses Ditambah </div>';
		
	}
	else{
		$data['kd_wilayah']=$_POST['kd_wilayah'];
		$data['nm_jalan']=$_POST['nm_jalan'];
		$db->where('id_jalan',$_POST['id_jalan']);
		$exec=$db->update("tbl_jalan",$data);
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
	// hapus file di dalam folder
	$db->where('id_jalan',$_GET['id']);
	$get=$db->ObjectBuilder()->getOne('tbl_jalan');
	$geojson_jalan=$get->geojson_jalan;
	unlink('assets/unggah/geojson/'.$geojson_jalan);
	// end hapus file di dalam folder
	$db->where("id_jalan",$_GET['id']);
	$exec=$db->delete("tbl_jalan");
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
  $id_jalan="";
  $kd_wilayah="";
  $nm_jalan="";
  $keterangan="";
//   $geojson_jalan="";
//   $warna_jalan="";
  if(isset($_GET['ubah']) AND isset($_GET['id'])){
  	$id=$_GET['id'];
  	$db->where('id_jalan',$id);
	$row=$db->ObjectBuilder()->getOne('tbl_jalan');
	if($db->count>0){
		$id_jalan=$row->id_jalan;
		$kd_wilayah=$row->kd_wilayah;
		$nm_jalan=$row->nm_jalan;
		// $keterangan=$row->keterangan;
		// $geojson_jalan=$row->geojson_jalan;
		// $warna_jalan=$row->warna_jalan;
	}
  }
  // value ketika validasi
  if($session->get('error_value')){
  	extract($session->pull('error_value'));
  }
?>
<?=content_open('Form Jalan')?>
    <form method="post" enctype="multipart/form-data">
    	<?php
    		// menampilkan error validasi
  			if($session->get('error_validation')){
  				foreach ($session->pull('error_validation') as $key => $value) {
  					echo '<div class="alert alert-danger">'.$value.'</div>';
  				}
  			}
    	?>
    	<?=input_hidden('id_jalan',$id_jalan)?>
    	<div class="form-group">
    		<label>Kode Jalan</label>
    		<div class="row">
	    		<div class="col-md-4">
	    			<?=input_text('kd_wilayah',$kd_wilayah)?>
		    	</div>
	    	</div>
    	</div>
    	<div class="form-group">
    		<label>Nama Jalan</label>
    		<div class="row">
	    		<div class="col-md-6">
	    			<?=input_text('nm_jalan',$nm_jalan)?>
	    		</div>
    		</div>
    	</div>
    	<!-- <div class="form-group">
    		<label>Keterangan</label>
    		<div class="row">
	    		<div class="col-md-6">
	    			<?=textarea('keterangan',$keterangan)?>
	    		</div>
    		</div>
    	</div> -->
    	<!-- <div class="form-group">
    		<label>GeoJSON</label>
    		<div class="row">
	    		<div class="col-md-4">
    				<?=input_file('geojson_jalan',$geojson_jalan)?>
    			</div>
    		</div>
    	</div>
    	<div class="form-group">
    		<label>Warna</label> 
    		<div class="row">
	    		<div class="col-md-3">
	    			<?=input_color('warna_jalan',$warna_jalan)?>
	    		</div>
    		</div>
    	</div> -->
    	<div class="form-group">
    		<button type="submit" name="simpan" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
			<a href="<?=url($url)?>" class="btn btn-danger" ><i class="fa fa-reply"></i> Kembali</a>
    	</div>
    </form>
<?=content_close()?>

<?php  } else { ?>
<?=content_open('Data Jalan')?>

<a href="<?=url($url.'&tambah')?>" class="btn btn-success" ><i class="fa fa-plus"></i> Tambah</a>
<hr>
<?=$session->pull("info")?>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Kode Wilayah</th>
			<th>Nama Jalan</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$no=1;
			$getdata=$db->ObjectBuilder()->get('tbl_jalan');
			foreach ($getdata as $row) {
				
				?>
					<tr>
						<td><?=$no?></td>
						<td><?=$row->kd_wilayah?></td>
						<td><?=$row->nm_jalan?></td>
						<!-- <td><?=$row->keterangan?></td> -->
						<!-- <td><a href="<?=assets('unggah/geojson/'.$row->geojson_jalan)?>" target="_BLANK"><?=$row->geojson_jalan?></a></td> -->
						<!-- <td style="background: <?=$row->warna_jalan?>"></td> -->
						<td>
							<a href="<?=url($url.'&ubah&id='.$row->id_jalan)?>" class="btn btn-info"><i class="fa fa-edit"></i> Ubah</a>
							<a href="<?=url($url.'&hapus&id='.$row->id_jalan)?>" class="btn btn-danger" onclick="return confirm('Hapus data?')"><i class="fa fa-trash"></i> Hapus</a>
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