<?php
$setTemplate = false;
$pengaduan = 'pengaduan';
?>
<?php include '_layouts_user/head.php'?>
  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="../../index2.html" class="navbar-brand"><b>SLPJU</b> SKRIPSI WEBGIS</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <!-- <li class="active"><a href="#"> <span class="sr-only">(current)</span></a></li> -->
            <li><a href="<?php url($pengaduan)?>">Beranda</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tentang <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="<?php url('pengaduan')?>">PENGADUAN</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li><a href="#">Separated link</a></li>
                <li class="divider"></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
            <a class="logout" href="<?=url('logout')?>">
            <i class="fa fa-sign-out"></i> <span>Keluar</span>
            </a>
          </ul>
          <!-- <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
              <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
            </div>
          </form> -->
        </div>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
           <a href="<?php url('login')?>" class="container"></a>
            </li>
          </ul>
        </div>
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
  <!-- Full Width Column -->
  <div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Dashboard SLPJU
        </h1>
       </section>

      <!-- Main content -->
      <section class="content">
        <!-- <div class="callout callout-info">
          <h4>Tip!</h4>

          <p>Add the layout-top-nav class to the body tag to get this layout. This feature can also be used with a
            sidebar! So use this class if you want to remove the custom dropdown menus from the navbar and use regular
            links instead.</p>
        </div> -->
        <!-- <div class="callout callout-danger">
          <h4>Warning!</h4>

          <p>The construction of this layout differs from the normal one. In other words, the HTML markup of the navbar
            and the content will slightly differ than that of the normal layout.</p>
        </div> -->
        <div class="box box-default">
          <div class="box-header with-border">
            <h3 class="box-title">Selamat datang di dashboard</h3>
          </div>
          <div class="box-body">
            
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  <!-- <footer class="main-footer">
    <div class="container">
      <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.0.0
      </div>
      <strong>Copyright &copy; 2022 <a href="https://pln.co.id">Kunjungi Kami</a>.</strong> All rights
      reserved.
    </div>
  </footer> -->
</div>
<?php include '_layouts_user/javascript.php'?>
</body>
</html>
