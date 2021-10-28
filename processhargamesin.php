<?php

    require 'controller/view_controller.php';
    if(isset($_POST['hargaBaru'])){
        $get_update = new AdminController();
        $update_machine_price = $get_update->hargaUpdateController($_GET['id'], $_POST['hargaBaru'], 'harga_mesin');
    }

    else{
        echo "<script>window.location = 'hargamesin.php'</script>";
    }

?>