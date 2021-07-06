<?php

    session_start();
    session_destroy();

    echo '<script language="javascript">';
    echo 'alert("Logout Berhasil")';
    echo '</script>';
    echo "<script>window.location = 'login.php'</script>";

?>