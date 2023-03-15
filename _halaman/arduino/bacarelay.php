<?php 
//include koneksi
    $db = mysqli_connect("localhost","root","","webgis_php");
    $sql = mysqli_query($db, "SELECT * FROM tbl_hotspot");
    $data = mysqli_fetch_array($sql);
    $id = $data['id_hotspot'];
    $relay = $data['relay'];
    // response balik dari nodeMCU
    echo $relay;
    // dikonver ke codeigniter jalan_c -> bacarelay();
?>