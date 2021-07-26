<?php

    $conn = mysqli_connect("localhost", "root", "", "database_batik_galih");

    if(isset($_POST['hargaBaru'])){

        $hargaBaru = $_POST['hargaBaru'];
        $id = $_GET['id'];

        $query = "SELECT * FROM harga_kain WHERE id = $id";
        $sql = mysqli_query($conn, $query) or die(mysqli_error($conn));

        $query = "UPDATE harga_kain set harga = $hargaBaru WHERE id = $id";
        $sql = mysqli_query($conn, $query) or die(mysqli_error($conn));

        if(!$sql){
            echo '<script language="javascript">';
            echo 'alert("Update harga gagal!!!")';
            echo '</script>';
            echo "<script>window.location = 'hargamesin.php'</script>";
        }
        
        echo '<script language="javascript">';
        echo 'alert("Update Berhasil!!!")';
        echo '</script>';
        echo "<script>window.location = 'hargamesin.php'</script>";
    }
    else{
        echo "<script>window.location = 'hargamesin.php'</script>";
    }

?>