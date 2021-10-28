<?php

    session_start();
    require('database/db_management/querycenter.php');


    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user_enter_act = new UserCommand();
        
        $user_info = $user_enter_act->loginValidation([$username, $password]);

        foreach($user_info as $name => $val){
            $_SESSION[$name] = $val;
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