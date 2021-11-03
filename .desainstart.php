<?php 
    require '_functions.php';

    session_start();
    
    $_SESSION['start'] = '';


    $_SESSION['algoritma']    = $_GET['algoritma'];
    $_SESSION['member']    = $_GET['member'];
    $_SESSION['maksSubmotif'] = cariAlgoritma($_GET["algoritma"])[0]['algoritma_maksmotif'];

    $_SESSION['widthCanv']  = $_GET['widthCanv'] ;
    $_SESSION['heightCanv'] = $_GET['heightCanv'];

    $motifSize = ceil($_SESSION['heightCanv']/10);


    $_SESSION['paddingTop'] = 1;
    $_SESSION['paddingSide']= 1;
    $_SESSION['obj']        = $motifSize;
    $_SESSION['obj2']       = $motifSize;
    $_SESSION['obj3']       = $motifSize;
    $_SESSION['gap']        = 0;
    $_SESSION['gapX']       = 0;
    $_SESSION['gapY']       = 0;

    $_SESSION['color1']     = '#cc8621';
    $_SESSION['color2']     = '#cc8621';
    $_SESSION['color3']     = '#cc8621';
    $_SESSION['colorBg']    = '#fcfcfc';

    $_SESSION['colorchange'] = '0,0';

    // $_SESSION['colorBg']    = 'red';

    
    $_SESSION['motif_id'] = [];

    
    header("Location: desain.php");      
    exit;
?>