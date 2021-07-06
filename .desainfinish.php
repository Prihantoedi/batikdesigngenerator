<?php    
        // Start session
        session_start();

        // Cek sesi desain
        sesiDesain();

        $_SESSION['submit']     = $_POST["submit-pict"] ;
        $_SESSION['paddingTop'] = $_POST['paddingTop']  ;
        $_SESSION['paddingSide']= $_POST['paddingSide'] ;
        $_SESSION['obj1']       = $_POST['obj'] ; 
        $_SESSION['obj2']       = $_POST['obj2']; 
        $_SESSION['obj3']       = $_POST['obj3']; 
        $_SESSION['gap']        = $_POST['gap'] ; 
        $_SESSION['gapX']       = $_POST['gapX']; 
        $_SESSION['gapY']       = $_POST['gapY'];

        header("Location: simpanbatik.php");      
        exit;
?>