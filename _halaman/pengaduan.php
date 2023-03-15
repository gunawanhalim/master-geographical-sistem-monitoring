<?php
$setTemplate = false;
$judul = 'Laporan masyarakat';
$url = 'pengaduan';
$session->set("awal",true);
if(isset($_POST['simpan'])){
	
	$file=upload('foto','foto');
	$options = array(
		'cluster' => 'ap1',
		'useTLS' => true
	  );
	  $pusher = new Pusher\Pusher(
		'585e11cdd7cfcddfc780',
		'0db63b3183f2de87f604',
		'1352991',
		$options
	  );
	if($file!=false){
		$data['foto']=$file;
		if($_POST['id_pengaduan']!=''){
			// hapus file di dalam folder
			$db->where('id_pengaduan',$_GET['id_pengaduan']);
			$get=$db->ObjectBuilder()->getOne('pengaduan');
			$foto=$get->foto;
			unlink('assets/unggah/pengaduan/'.$foto);
			// end hapus file di dalam folder
		}
	}
	$data['id_jalan']=$_POST['id_jalan'];
	$data['nik']=$_POST['nik'];
	$data['nama_masyarakat']=$_POST['nama'];
	$data['keterangan']=$_POST['keterangan'];
	$data['lokasi']=$_POST['lokasi'];
	$data['latitude']=$_POST['latitude'];
	$data['longitude']=$_POST['longitude'];
	$data['tanggal']=$_POST['tanggal'];
	if($_POST['id_pengaduan']==""){
		$exec=$db->insert("pengaduan",$data);
		$data['message'] =$_POST['tanggal'].' '.$_POST['keterangan'];
		$pusher->trigger('my-channel', 'my-event', $data);
		$info='<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Sukses!</h4> Laporan anda telah dikirim, terima kasih atas pengaduannya </div>';
		}

	if($exec){
		$session->set('info',$info);
	}
	else{
      $session->set("info",'<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4> Laporan anda telah gagal,silahkan coba lagi <br>'.$db->getLastError().'
              </div>');
	}
	redirect(url('pengaduan'));
    //tidak boleh kosong
	if($_POST['nik']==''){
		$validation[]='Nik anda Tidak Boleh Kosong';
	}
    if($_POST['nama_masyarakat']==''){
		$validation[]='Nama anda Tidak Boleh Kosong';
	}

	if($validation!=null){
		$setTemplate=false;
		$session->set('error_validation',$validation);
		$session->set('error_value',$_POST);
		redirect($_SERVER['HTTP_REFERER']);
		return false;
	}
}

?>
<!DOCTYPE html>
<html>
<head>
<?php include '_layouts/head.php'?>
</head>
<body class="hold-transition skin-dark-light blank-page">
<div class="container">
    <header class="main-header">
    <!-- Logo -->
    <a href="<?php url('beranda')?>" class="logo">
    <span class="logo-lg"><b>SLPJU</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        <li class=>
        </ul>
      </div>
    </nav>
  </header>
<div class="container-fluid">
    <section class="content-header">
    </section>
    <section class="content">
<?=content_open('Form Laporan')?>
   <form method="post" enctype="multipart/form-data">
    	<div class="form-group">
    		<label>Nik</label>
    		<div class="row">
	    		<div class="col-md-4">
	    			<input type="text" name="nik" class="form-control" placeholder="NIK Wajib di isi" >
		    	</div>
	    	</div>
    	</div>
        <div class="form-group">
    		<label>Nama</label>
    		<div class="row">
	    		<div class="col-md-4">
	    			<input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Anda" >
		    	</div>
	    	</div>
    	</div>
    	<div class="form-group">
    		<label></label> 
    		<div class="row">
	    		<div class="col-md-4">
                <label for="lokasi">Lokasi</label>
                <input type="text" id="lokasi" name="lokasi" class="form-control" placeholder="Lokasi/Kec." >
	    		</div>
	    		<div class="col-md-3">
                <!-- <input type="text" name="nik" class="form-control" placeholder="" > -->
	    		</div>
    		</div>
    	</div>
		<div class="form-group">
    		<label></label> 
    		<div class="row">
	    		<div class="col-md-2">
                <label for="lokasi">Latitude</label>
                <input type="text" id="latitude" name="latitude" class="form-control" placeholder="Latitude" >
	    		</div>
				<div class="col-md-2">
                <label for="lokasi">Longitude</label>
                <input type="text" id="longitude" name="longitude" class="form-control" placeholder="Longitude" >
	    		</div>
    		</div>
    	</div>
        <div class="form-group">
    		<label>Nama Jalan</label>
    		<div class="row">
	    		<div class="col-md-4">
	    			<?php
	    				$op['']='Pilih Jalan';
	    				foreach ($db->ObjectBuilder()->get('tbl_jalan') as $row) {
	    					$op[$row->id_jalan]=$row->nm_jalan;
	    				}
	    			?>
	    			<?=select('id_jalan',$op)?>
	    		</div>
    		</div>
    	</div>
    	<div class="form-group">
    		<label>Tanggal</label>
    		<div class="row">
	    		<div class="col-md-4">
    				<input type="date" name="tanggal" id="">
    			</div>
    		</div>
    	</div>
        <div class="form-group">
    		<label>Keterangan</label>
    		<div class="row">
	    		<div class="col-md-4">
                <textarea name="keterangan" id="" cols="50" rows="5"></textarea>
    			</div>
    		</div>
    	</div>
    	<div class="form-group">
    		<label>Masukkan Gambar</label>
    		<div class="row">
	    		<div class="col-md-4">
    				<input type="file" name="foto" id="">
    			</div>
    		</div>
    	</div>
    	<div class="form-group">
    		<button type="submit" name="simpan" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
			<a href="<?=url('beranda')?>" class="btn btn-danger" ><i class="fa fa-reply"></i> Kembali</a>
    	</div>
    </form>
    <?=content_close()?>
        <div class="box-footer">
         <span>Untuk darurat penting silahkan hubungi kami :</span> <br>
          Gunawan Halim : 085155306661 (CS)
        </div>
    </section>
  </div>
  <footer class="container-fluid">
    <div class="pull-right hidden-xs">
    </div>
  </footer>
  <?php 
  include '_layouts/javascript.php' ?>
  <script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>

  </body>
</html>