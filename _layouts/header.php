<?php 
  $konek = mysqli_connect("localhost","root","","webgis_php");
  $data = mysqli_query($konek,"SELECT * FROM pengaduan"); 
  $jumlah = mysqli_num_rows($data);
?>
  <header class="main-header">
  <link rel="icon" type="image/x-icon" href="../assets/favicon/favicon.ico">
    <!-- Logo -->
    <a href="<?=templates()?>index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>W</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>SLPJU</b> WEB</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <?php if ($session->get('level')== 'Admin'): ?>
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success"><?php echo $jumlah; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Anda punya pesan</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <!-- <div class="pull-left">
                        <img src="<?=templates()?>dist/img/avatar.png" class="img-circle" alt="User Image">
                      </div> -->
                      <?php 
                        $no=1;
                        $getdata=$db->ObjectBuilder()->get('pengaduan');
                        foreach ($getdata as $row) {
                        ?>
                        <h4>
                          Nama Melapor : <?= $row->nama_masyarakat ?>
                        </h4>
                      <p><strong> Keterangan : </strong> <?= $row->keterangan?>
                      <small><i class="fa fa-clock-o"></i> 5 mins</small></p>
                      <hr>
                      <?php
                    } ?>
                    </a>
                    </li>
                  <!-- end message -->
                </ul>
              </li>
              <li class="footer"><a href="<?= url('laporan')?>">See All Messages</a></li>
            </ul>
          </li>
          <?php endif ?>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?=templates()?>dist/img/avatar.png" class="user-image" alt="User Image">
              <span class="hidden-xs"><?=$session->get("nm_pengguna")?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                <a href="<?=url('profile')?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                <a href="<?=url('logout')?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
