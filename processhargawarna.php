<?php

    $conn = mysqli_connect("localhost", "root", "", "database_batik_galih");

    if(isset($_POST['hargaBaru'])){

        $hargaBaru = $_POST['hargaBaru'];
        $id = $_GET['id'];

        $query = "SELECT * FROM harga_warna WHERE id = $id";
        $sql = mysqli_query($conn, $query) or die(mysqli_error($conn));
        $version = mysqli_fetch_assoc($sql);
        $newVersion = $version['version'] + 1;

        $query = "UPDATE harga_warna set harga = $hargaBaru, version = $newVersion WHERE id = $id";
        $sql = mysqli_query($conn, $query) or die(mysqli_error($conn));

        if(!$sql){
            echo '<script language="javascript">';
            echo 'alert("Update harga gagal!!!")';
            echo '</script>';
            echo "<script>window.location = 'hargawarna.php'</script>";
        }
        
        echo '<script language="javascript">';
        echo 'alert("Update Berhasil!!!")';
        echo '</script>';
        echo "<script>window.location = 'hargawarna.php'</script>";
    }
    else{
        echo "<script>window.location = 'hargawarna.php'</script>";
    }

?>