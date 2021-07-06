<?php
    require '_functions.php';
    echo 'Saving... <br>';
    session_start();
    
    // Where the file should be saved to
    date_default_timezone_set('Asia/Jakarta');
    $filename ="hbatik_".date('mdY_His').".svg";
    $path = "hasilbatik/".$filename; //hbatik_".date('mdY_His').".svg"; 
    // Download link
    $link = $_SESSION['svgBatik'];
    // Save SVG
    file_put_contents($path, file_get_contents($link));

    $karakter_id = '';	
    $tanggal     = date('Y-m-d H:i:s');
    $kreator     = $_SESSION['kreator'];	
    $namakarya   = $_SESSION['namakarya'];	
    $algoritma   = cariAlgoritma($_SESSION['algoritma'])[0]["algoritma_id"];	
    $jmlmotif    = $_SESSION['motifJml'];	
    $widthCanv   = $_SESSION['widthCanv'];	
    $heightCanv  = $_SESSION['heightCanv'];	
    $paddingTop  = $_SESSION['paddingTop'];	
    $paddingSide = $_SESSION['paddingSide'];	
    $gap         = $_SESSION['gap'];	
    $gapX        = $_SESSION['gapX'];	
    $gapY        = $_SESSION['gapY'];

    $query = "INSERT INTO tbl_hasilbatik VALUES (
                    '$karakter_id', '$filename', '$tanggal', '$kreator', '$namakarya', 
                    '$algoritma', '$jmlmotif', '$widthCanv', '$heightCanv', 
                    '$paddingTop', '$paddingSide', '$gap', '$gapX', '$gapY'        
            )";
    mysqli_query($conn, $query);
    $karakter_id = mysqli_insert_id($conn);


    $i = 1;
    foreach($_SESSION['motif_id'] as $mtf){
        $motif_id = $mtf;
        $urutan_motif = $i;
        $ukuran_motif = $_SESSION['obj'.$i++];

    $query = "INSERT INTO jtbl_hasilbatik_motif VALUES (
                    '$karakter_id', '$motif_id', '$urutan_motif', '$ukuran_motif'       
            )";

    mysqli_query($conn, $query);
    }


    if (mysqli_affected_rows($conn)) {
        echo "New record created successfully.";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }


    session_destroy();
    header('location:hasilbatik.php');
    exit;    
 ?>