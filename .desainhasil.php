<?php 
    require '_functions.php';
    
    session_start();
    
    $_SESSION['start'] = '';



    $hasilId = $_GET['hasilbatik_id'];

    $hasilbatik = query("SELECT * FROM tbl_hasilbatik WHERE hasilbatik_id = '$hasilId'")[0];
    
    $algoritmaId    = $hasilbatik['algoritma_id'];
    $_SESSION['algoritma']      = query("SELECT algoritma_nama FROM tbl_algoritma
                                    WHERE algoritma_id = '$algoritmaId' ")[0]["algoritma_nama"];
        
    $_SESSION['maksSubmotif']   = query("SELECT algoritma_maksmotif FROM tbl_algoritma
                                    WHERE algoritma_id = '$algoritmaId' ")[0]["algoritma_maksmotif"];

    $query = "SELECT jtbl_hasilbatik_motif.* FROM jtbl_hasilbatik_motif
                INNER JOIN tbl_hasilbatik ON jtbl_hasilbatik_motif.hasilbatik_id = tbl_hasilbatik.hasilbatik_id
                WHERE jtbl_hasilbatik_motif.hasilbatik_id = '$hasilId'
                ";

    $lists = query($query);
    $ukuran = [0,0,0];
    foreach($lists as $list){
        $motif[]                = $list['motif_id'];
        $ukuran[$list['urutan']-1]= $list['ukuran'];
    }

    $_SESSION['widthCanv']      = $hasilbatik['hasilbatik_widthCanv'];
    $_SESSION['heightCanv']     = $hasilbatik['hasilbatik_heightCanv'];
    $_SESSION['paddingTop']     = $hasilbatik['hasilbatik_paddingTop'];
    $_SESSION['paddingSide']    = $hasilbatik['hasilbatik_paddingSide'];
    $_SESSION['obj']            = $ukuran[0];
    $_SESSION['obj2']           = $ukuran[1];
    $_SESSION['obj3']           = $ukuran[2];
    $_SESSION['gap']            = $hasilbatik['hasilbatik_gap'];
    $_SESSION['gapX']           = $hasilbatik['hasilbatik_gapX'];
    $_SESSION['gapY']           = $hasilbatik['hasilbatik_gapY'];

    $_SESSION['motif_id'] = $motif;

    // var_dump($_SESSION);
    header("Location: desain.php");      
    exit;
?>