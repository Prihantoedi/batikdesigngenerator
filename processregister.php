<?php

    $conn = mysqli_connect("localhost", "root", "", "database_batik_galih");

    if(isset($_POST['submit'])){
        $nama = $_POST['nama'];
        $no_telp = $_POST['telepon'];
        $email = $_POST['email'];
        $pekerjaan = $_POST['pekerjaan'];
        $daerah = $_POST['daerah'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $jenis = "baru";
        $role = "member";

        $query = "INSERT INTO customers (nama, no_telp, email, pekerjaan, daerah, username, password, jenis, role) 
                VALUES ('$nama', '$no_telp', '$email', '$pekerjaan', '$daerah', '$username', '$password', '$jenis', '$role')";
        $sql = mysqli_query($conn, $query) or die(mysqli_error($conn));

        if(!$sql){
            echo '<script language="javascript">';
            echo 'alert("Register Gagal!!!")';
            echo '</script>';
            echo "<script>window.location = 'register.php'</script>";
        }
        
        echo '<script language="javascript">';
        echo 'alert("Register Berhasil")';
        echo '</script>';
        echo "<script>window.location = 'login.php'</script>";
    }
    else{
        echo "<script>window.location = 'register.php'</script>";
    }

?>