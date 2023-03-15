<?php
$konek = mysqli_connect("localhost","root","","webgis_php");
// $id = $_GET['id_jalan'];
$stat = $_GET['stat'];
// $bacarelay = mysqli_query($db, "SELECT * FROM tbl_hotspot WHERE id_jalan = '$id' ");
// $row = mysqli_fetch_array($bacarelay);
// echo "ID Relay:", $row["id_jalan"]," ", "Relay :", $row["relay"];
if($stat == "ON")
{
    mysqli_query($konek,"UPDATE tbl_hotspot SET relay = 1");
    echo "ON";
}
else{
    mysqli_query($konek,"UPDATE tbl_hotspot SET relay = 0");
    echo "OFF"; 
}
?>