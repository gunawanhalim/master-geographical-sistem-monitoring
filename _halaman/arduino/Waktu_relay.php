<?php 
date_default_timezone_set("Asia/Makassar");
    $jam = date('H:i');
//include koneksi
    $db = mysqli_connect("localhost","root","","webgis_php");

    //  baca status jam
    $sql = mysqli_query($db, "SELECT * from set_wakturelay ORDER BY id ASC ");
    // jika data ada,maka di infokan ke nodemcu
    while($data = mysqli_fetch_array($sql)){
        $id = $data['id'];
        $jamDb = $data['jam'];
        $status = $data['status'];
        if($jam == $jamDb && $status == 1){
        //    $sql =  mysqli_query($db, "SELECT * from set_wakturelay where status=1");
            echo "Nyalakan";
        }
        if($jam == $jamDb && $status == 0){
            //    $sql =  mysqli_query($db, "SELECT * from set_wakturelay where status=0");
                echo "Matikan";
            }
        
    }

    // $data = mysqli_fetch_array($sql);
    // $status = $data['status'];
    // // response balik dari nodeMCU
    // echo $status;
?>