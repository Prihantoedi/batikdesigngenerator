<?php
    require('database/db_management/querycenter.php');
    $conn = mysqli_connect("localhost", "root", "", "database_batik_galih");
    $register_action = new UserCommand();

    if(isset($_POST['submit'])){

        $sql = $register_action->insertQuery("INSERT", $_POST);
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