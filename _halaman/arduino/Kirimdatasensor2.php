<?php 
//include koneksi
    $db = mysqli_connect("localhost","root","","webgis_php");
    $sensor2 = $_GET["sensor2"];
    // $nilai_2 = $_GET["nilaiarus_2"];
    // response balik dari nodeMCU
    mysqli_query($db,"UPDATE sensor SET sensor_arus2='$sensor2'");
    // mysqli_query($db,"UPDATE sensor SET sensor_arus2='$sensor2'");
// dikonver ke codeigniter jalan_c -> bacarelay();
?>