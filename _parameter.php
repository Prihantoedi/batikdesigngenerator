<?php
    if(isset($_POST['submit'])){
        $_SESSION['paddingTop'] = $_POST['paddingTop']  ;
        $_SESSION['paddingSide']= $_POST['paddingSide'] ;
        $_SESSION['obj']        = $_POST['obj'] ; 
        $_SESSION['obj2']       = $_POST['obj2']; 
        $_SESSION['obj3']       = $_POST['obj3']; 
        $_SESSION['gap']        = $_POST['gap'] ; 
        $_SESSION['gapX']       = $_POST['gapX']; 
        $_SESSION['gapY']       = $_POST['gapY'];

          // * tambahan session color
          $_SESSION['colorBg']    = $_POST['colorBg'];
          $_SESSION['color1']     = $_POST['color1'];
          $_SESSION['color2']     = $_POST['color2'];
          $_SESSION['color3']     = $_POST['color3'];
          $_SESSION['colorchange']     = $_POST['colorchange'];

        if($_POST['submit'] == 0 || $_POST['submit'] == 2){
            // GANTI MOTIF
            $_SESSION['motif_indeks'] = $_POST['motif_indeks'];
            header("location: katalogpilih.php");
            exit;
        } elseif($_POST['submit'] == 1){
            // HAPUS MOTIF
            array_splice($_SESSION['motif_id'],$_POST['motif_indeks'],1);
        } elseif($_POST['submit'] == 3){
            // SIMPAN BATIK
            header("Location: simpanbatik.php");      
            exit;
        }
    }


    $p1 = $_SESSION['paddingTop'];
    $p2 = $_SESSION['paddingSide'];
    $p3 = $_SESSION['obj'];
    $p4 = $_SESSION['obj2'];
    $p5 = $_SESSION['obj3'];
    $p6 = $_SESSION['gap'];
    $p7 = $_SESSION['gapX'];
    $p8 = $_SESSION['gapY'];

    $param_paddingTop   = "min='1' max='150' step='10' value='$p1'";
    $param_paddingSide  = "min='1' max='100' step='1'  value='$p2'";
    $param_obj          = "min='5' max='100' step='1'  value='$p3'";
    $param_objn[0]      = "min='5' max='100' step='1'  value='$p4'";
    $param_objn[1]      = "min='5' max='100' step='1'  value='$p5'";
    $param_gap          = "min='-5' max='25' step='1'  value='$p6'";
    $param_gapX         = "min='-5' max='25' step='1'  value='$p7'";
    $param_gapY         = "min='-5' max='25' step='1'  value='$p8'";
?>