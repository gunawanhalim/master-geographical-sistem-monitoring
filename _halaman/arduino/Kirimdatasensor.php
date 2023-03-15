<?php 
//include koneksi
    $db = mysqli_connect("localhost","root","","webgis_php");
    $sensor1 = $_GET["sensor1"];
    // $nilai_2 = $_GET["nilaiarus_2"];
    // response balik dari nodeMCU
    mysqli_query($db,"update sensor set sensor_arus1='$sensor1'");
    // mysqli_query($db,"UPDATE sensor SET sensor_arus2='$sensor2'");
// dikonver ke codeigniter jalan_c -> bacarelay();
?>