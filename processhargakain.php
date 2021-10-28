<?php

    require 'controller/view_controller.php';
    
    if(isset($_POST['hargaBaru'])){
        $get_update = new AdminController();
        $update_color_price = $get_update->hargaUpdateController($_GET['id'], $_POST['hargaBaru'], 'harga_kain');

    }
    else{
        echo "<script>window.location = 'hargakain.php'</script>";
    }

?>