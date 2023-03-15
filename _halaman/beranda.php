<?php
  $title="Beranda";
  $judul=$title;
  // if ($session->get('level')!='Admin'){
  // 	redirect(url('beranda'));
  // }
?>
<?=content_open('Halaman Beranda')?>
    <?=$session->pull("info")?>
<?=content_close()?>
