<?php

    require 'controller/view_controller.php';

    if(isset($_POST['hargaBaru'])){
        $get_update = new AdminController();
        $update_technique_price = $get_update->hargaUpdateController($_GET['id'], $_POST['hargaBaru'], 'harga_teknik');
    }
    else{
        echo "<script>window.location = 'hargateknik.php'</script>";
    }

?>