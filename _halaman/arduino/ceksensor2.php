<?php 
//include koneksi
    $db = mysqli_connect("localhost", "root", "", "webgis_php");
    $sql = mysqli_query($db, "SELECT * FROM sensor");
    $data = mysqli_fetch_array($sql);
    $sensor2 = $data["sensor_arus2"];
    // response balik dari nodeMCU
    echo $sensor2;
    // dikonver ke codeigniter jalan_c -> bacarelay();
?>