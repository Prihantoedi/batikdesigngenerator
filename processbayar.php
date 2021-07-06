<?php

    session_start();

    $conn = mysqli_connect("localhost", "root", "", "database_batik_galih");
    $idBatik = $_GET['id'];
    $idUser = $_SESSION['id_customer'];

    $sql = mysqli_query($conn, "UPDATE tbl_hasilbatik SET status_bayar = 'lunas' WHERE hasilbatik_id = $idBatik") or die(mysqli_error($conn));

    if ($sql) {
        echo '<script language="javascript">';
        echo 'alert("Pembayaran Berhasil!!!")';
        echo '</script>';
    }
    else{
        echo '<script language="javascript">';
        echo 'alert("Pembayaran Gagal!!!")';
        echo '</script>';
    }

    echo "<script>window.location = 'hasilbatik.php?id=" . $idUser . "'</script>";

?>