<?php

    require 'controller/view_controller.php';
    if(isset($_POST['hargaBaru'])){
        $get_update = new AdminController();
        $update_color_price = $get_update->hargaUpdateController($_GET['id'], $_POST['hargaBaru'], 'harga_warna');

    }
    else{
        echo "<script>window.location = 'hargawarna.php'</script>";
    }

?>