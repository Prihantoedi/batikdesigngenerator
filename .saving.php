<?php
    require '_functions.php';
    require 'colortranslate.php';
    echo 'Saving... <br>';
    session_start();
    

    // Where the file should be saved to
    date_default_timezone_set('Asia/Jakarta');
    $filename ="hbatik_".date('mdY_His').".svg";
    $filenameHp = "hbatik_Hp_".date('mdY_His').".svg";
    $path = "hasilbatik/".$filename; //hbatik_".date('mdY_His').".svg"; 
    $pathHp = "hasilbatik/".$filenameHp;
    // Download link
    $link = $_SESSION['svgBatik'];

    // Download link hitam putih
    $linkHp = $_SESSION['svgBatikHp'];

    // Save SVG
    file_put_contents($path, file_get_contents($link));

    // Save SVG Hitam putih
    file_put_contents($pathHp, file_get_contents($linkHp));
    $karakter_id = '';
    $tanggal     = date('Y-m-d H:i:s');
    $kreator     = $_SESSION['nama_customer'];
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
    $member      = $_SESSION['jenis_customer'];
    $jumlah      = $_SESSION['jumlah'];
    $teknik      = $_SESSION['teknik'];
    $warna1      = hexToColor($_SESSION['warna1']);
    $warna2      = hexToColor($_SESSION['warna2']);
    $warna3      = hexToColor($_SESSION['warna3']);
    $warnabg     = hexToColor($_SESSION['warnabg']);

    $gambarPanjang = 0;
    $gambarLebar = 0;
    $totalGambar = 0;
    $durasi      = 0;
    $hargaWarna  = 0;
    $hargaDurasi = 0;
    $hargaTeknik = 0;
    $hargaLuas   = 0;
    $harga       = 0;


    
    $kelilingString    = explode("," , $_SESSION['keliling']);
    $totalMotifString = explode("," , $_SESSION['totalmotif']);
    // die(print_r($kelilingString));

    // String to Number
    $keliling = [];
    for($k = 0; $k < count($kelilingString); $k++){
        $kelilingToCm = (float)$kelilingString[$k] * 0.02645833; 
        array_push($keliling, $kelilingToCm);
    }

  
    $totalMotif = [];
    for($tm = 0; $tm < count($totalMotifString); $tm++){
        array_push($totalMotif, (float)$totalMotifString[$tm]);
    }

    $durasi = 0;


    if ($teknik == "Colet"){
        // die("Colet");
        for($d = 0; $d < count($keliling); $d++){
            $durasi = $durasi + (($keliling[$d] * 2) * $totalMotif[$d]);
        }
    } else{
        for($d = 0; $d < count($keliling); $d++){
            $durasi = $durasi + $keliling[$d] * $totalMotif[$d];
        }
    }

    // die($durasi. "   <-");


    // 1000 mm per menit = 100 cm per menit 
    // dibagi 10

    $durasi = $durasi / 10;

    // Jumlah durasi = durasi x jumlah pembelian
    $durasiMenit = $durasi * $jumlah;

    $durasiJam = $durasiMenit / 60; 
    $durasiHari = ceil($durasiJam / 8); // roundup
    

    // die($durasiHari . " durasi Hari");

    $conn = mysqli_connect("localhost", "root", "", "database_batik_galih");

    $query = "SELECT * FROM harga_mesin WHERE id = 1";
    $sql = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $memberBaru = mysqli_fetch_assoc($sql);
    $hargaMemberBaru = $memberBaru['harga'];

    $query = "SELECT * FROM harga_mesin WHERE id = 2";
    $sql = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $memberLama = mysqli_fetch_assoc($sql);
    $hargaMemberLama = $memberLama['harga'];

    // Cari hargaDurasi  // per menit satuannya
    if ($member == "lama") {
        $hargaDurasi = ceil($durasiMenit * $hargaMemberLama);
    }
    if ($member == "baru") {
        $hargaDurasi = ceil($durasiMenit * $hargaMemberBaru);
    }

    // CARI HARGA WARNA

    // die($_SESSION['datawarna']);
    $datawarnasession = explode("," , $_SESSION['datawarna']);
    // die(print_r($datawarnasession));
    $checkingWarna = [$warnabg];
    $checkingWarna2 = [$warnabg];

    
    for($c = 0; $c < count($datawarnasession); $c++){
        array_push($checkingWarna, hexToColor($datawarnasession[$c]));
        array_push($checkingWarna2, hexToColor($datawarnasession[$c]));
    }
    // die(print_r($checkingWarna));

    $jenisWarna1 = $warna1;
    $jenisWarna2 = $warna2;
    $jenisWarna3 = $warna3;
    $jenisWarnabg = $warnabg;
  
    // Perhitungan Harga Warna

    $hargaWarna = 0;
    $dihitung = 0;
    
    for($checking = 0; $checking < count($checkingWarna); $checking++ ){    
        if($checking == 0 ){
            $durasi = $durasi + 24;
            $color = $checkingWarna[$checking];
            $query = "SELECT harga FROM harga_warna WHERE jenis = '$color'";
            $sql = mysqli_query($conn, $query);
            $data_warna_n = mysqli_fetch_assoc($sql);
            $harga_warna_n = $data_warna_n['harga'];
            $hargaWarna = $hargaWarna + $harga_warna_n;
            $dihitung = $dihitung + 1;
        } else{
            
            for($checking2 = 0; $checking2 < count($checkingWarna2); $checking2++){
                if($checking2 == $checking){
                    $durasi = $durasi + 24;
                    $color = $checkingWarna[$checking];
                    $query = "SELECT harga FROM harga_warna WHERE jenis = '$color'";
                    $sql = mysqli_query($conn, $query);
                    $data_warna_n = mysqli_fetch_assoc($sql);
                    $harga_warna_n = $data_warna_n['harga'];
                    $hargaWarna = $hargaWarna + $harga_warna_n;
                    $dihitung = $dihitung + 1;
                    break;
                }
                if($checkingWarna[$checking] == $checkingWarna2[$checking2]){break;}   
            }
        }    
    }

    

    


    // Cari hargaTeknik
    if ($teknik == "Celup") {
        $id = "1";
        $query = "SELECT * FROM harga_teknik WHERE id = $id";
        $sql = mysqli_query($conn, $query) or die(mysqli_error($conn));
        $dataHargaTeknik = mysqli_fetch_assoc($sql);
        
        $hargaTeknik1 = $dataHargaTeknik['harga'];
        
        $hargaTeknik = $hargaTeknik + $hargaTeknik1;
        $jenisTeknik = $dataHargaTeknik['jenis'];
    }
    else if ($teknik == "Colet") {
        $id = "2";
        $query = "SELECT * FROM harga_teknik WHERE id = $id";
        $sql = mysqli_query($conn, $query) or die(mysqli_error($conn));
        $dataHargaTeknik = mysqli_fetch_assoc($sql);
        $hargaTeknik2 = $dataHargaTeknik['harga'];

        $hargaTeknik = $hargaTeknik + $hargaTeknik2;
        $jenisTeknik = $dataHargaTeknik['jenis'];
    }

    // Cari luas untuk menghitung harga berdasarkan luas (Rp. 1.5/cm2)
    $luas = $widthCanv * $heightCanv;
    $luas = $luas / 10000;
    $luas = round($luas * 2) / 2;
    $luas = $luas * 10000;

    // Cari hargaLuas
    $hargaLuas = $hargaLuas + (1.5 * $luas);
    $hargaLuas = $hargaLuas * $jumlah;

    // Cari Harga Total
    $harga = $hargaWarna + $hargaTeknik + $hargaDurasi + $hargaLuas;

    $_SESSION['totalHarga'] = $harga;
    $_SESSION['hargaWarna'] = $hargaWarna;
    $_SESSION['hargaTeknik'] = $hargaTeknik;
    $_SESSION['hargaDurasi'] = $hargaDurasi;
    $_SESSION['hargaLuas'] = $hargaLuas;
    $_SESSION['hasilbatik'] = "0";

    // Cari processing time
    $query = "SELECT * FROM tbl_hasilbatik WHERE status = 'process' ORDER BY hasilbatik_id DESC LIMIT 1";
    $sql = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $dataSebelumnya = mysqli_fetch_assoc($sql);
    $tanggalSebelumnya = $dataSebelumnya['hasilbatik_tanggal'];
    $durasiSebelumnya = $dataSebelumnya['durasi'];
    

    $tanggalSebelumnya = date_create($tanggalSebelumnya);
    $tanggalFormat = date_create($tanggal);

    $interval = $tanggalFormat->diff($tanggalSebelumnya)->days;

    if($interval <= $durasiSebelumnya){
        $durasiHari= $durasiHari + ($durasiSebelumnya - $interval);
    }

    // die($durasiHari. " hari");
    
    // tambahan durasi untuk teknik
    if($teknik == "Celup"){
        $durasiHari = $durasiHari + $dihitung;
    } 

    // die($durasiHari . " dihitung");

    $_SESSION['durasi'] = $durasiHari . " hari";

    // Cari delivery time
    $asalDaerah = $_SESSION['daerah_customer'];

    $query = "SELECT * FROM harga_kirim WHERE asal_daerah = '$asalDaerah'";
    $sql = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $dataDaerah = mysqli_fetch_assoc($sql);
    $delTime = $dataDaerah['delivery_time'];
    $ongkosKirim = $dataDaerah['harga'];

    $harga = $harga + $ongkosKirim;


    $idCustomer = $_SESSION['id_customer'];


    $query = "INSERT INTO tbl_hasilbatik VALUES (
        '$karakter_id', '$filename', '$filenameHp', '$tanggal', '$kreator', '$namakarya', 
        '$algoritma', '$jmlmotif', '$widthCanv', '$heightCanv', 
        '$paddingTop', '$paddingSide', '$gap', '$gapX', '$gapY', 
        '$jumlah', '$jenisTeknik', '$jenisWarna1', '$jenisWarna2', '$jenisWarna3', '$jenisWarnabg', $durasiHari, $harga, 'process', 'belum', $idCustomer, $delTime
    )";

    mysqli_query($conn, $query);
    $karakter_id = mysqli_insert_id($conn);


    $i = 1;
    $_SESSION['obj1'] = $_SESSION['obj'];
    
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
    
    

    // session_destroy();
    header('location:hasilbatik.php?id=' . $idCustomer);
    exit;  

 ?>