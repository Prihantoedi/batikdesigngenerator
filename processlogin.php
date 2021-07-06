<?php

    session_start();

    $conn = mysqli_connect("localhost", "root", "", "database_batik_galih");

    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = mysqli_query($conn, "SELECT * FROM customers WHERE username = '$username' AND password = '$password'") or die(mysqli_error($conn));

        if (mysqli_num_rows($sql) != 0) {

            $dataCustomer = mysqli_fetch_assoc($sql);

            $_SESSION['id_customer'] = $dataCustomer['id'];
            $_SESSION['nama_customer'] = $dataCustomer['nama'];
            $_SESSION['no_telp_customer'] = $dataCustomer['no_telp'];
            $_SESSION['email_customer'] = $dataCustomer['email'];
            $_SESSION['pekerjaan_customer'] = $dataCustomer['pekerjaan'];
            $_SESSION['daerah_customer'] = $dataCustomer['daerah'];
            $_SESSION['username_customer'] = $dataCustomer['username'];
            $_SESSION['password_customer'] = $dataCustomer['password'];
            $_SESSION['jenis_customer'] = $dataCustomer['jenis'];
            $_SESSION['role_customer'] = $dataCustomer['role'];
        
            echo '<script language="javascript">';
            echo 'alert("Login Berhasil")';
            echo '</script>';

        }
        else{
            echo '<script language="javascript">';
            echo 'alert("Username atau Password Salah!!!")';
            echo '</script>';
            echo "<script>window.location = 'login.php'</script>";
        }

        if ($_SESSION['role_customer'] == "member") {
            echo "<script>window.location = 'index.php'</script>";
        }
        else{
            echo "<script>window.location = 'admindex.php'</script>";
        }
    }
    else{
        echo '<script language="javascript">';
        echo 'alert("apa ini")';
        echo '</script>';
        echo "<script>window.location = 'login.php'</script>";
    }

?>