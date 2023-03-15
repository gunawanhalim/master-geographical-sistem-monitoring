<?php 
//include koneksi
    $db = mysqli_connect("localhost", "root", "", "webgis_php");
    $sql = mysqli_query($db, "select * from sensor");
    $data = mysqli_fetch_array($sql);
    $sensor1 = $data["sensor_arus1"];
    // response balik dari nodeMCU
    echo $sensor1;
    // dikonver ke codeigniter jalan_c -> bacarelay();
?>