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
        for($d = 0; $d < count($keliling); $d++){
            $durasi = $durasi + (($keliling[$d] * 2) * $totalMotif[$d]);
        }
    } else{
        for($d = 0; $d < count($keliling); $d++){
            $durasi = $durasi + $keliling[$d] * $totalMotif[$d];
        }
    }

    // perhitungan durasi

    // 1000 mm per menit = 100 cm per menit 
    // dibagi 10

    $durasi = $durasi / 10;

    // Jumlah durasi = durasi x jumlah pembelian
    $durasiMenit = $durasi * $jumlah;

    $durasiJam = $durasiMenit / 60; 
    $durasiHari = ceil($durasiJam / 8); // roundup
    
    $manufacturing_duration = $durasiHari; // durasi mentah proses pengerjaan batik
    // die("man dur = ". $manufacturing_duration);
    $manufacturing_date = $tanggal;



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


    $datawarnasession = explode("," , $_SESSION['datawarna']);

    $checkingWarna = [$warnabg];
    $checkingWarna2 = [$warnabg];

    
    for($c = 0; $c < count($datawarnasession); $c++){
        array_push($checkingWarna, hexToColor($datawarnasession[$c]));
        array_push($checkingWarna2, hexToColor($datawarnasession[$c]));
    }

    $jenisWarna1 = $warna1;
    $jenisWarna2 = $warna2;
    $jenisWarna3 = $warna3;
    $jenisWarnabg = $warnabg;
  
    // Perhitungan Harga Warna

    $hargaWarna = 0;
    $dihitung = 0;
    
    // Melihat apakah ada penggunaan warna yang sama dalam satu desain kain batik
    // Apabila ada warna yang sama dalam satu desain, maka warna yang sama akan terhitung satu kali penggunaan saja,
    // Selain dari itu, warna akan dihitung lebih dari satu.

    for($checking = 0; $checking < count($checkingWarna); $checking++ ){    
        if($checking == 0 ){ // warna background
            $durasi = $durasi + 24;
            $color = $checkingWarna[$checking];
            $query = "SELECT harga FROM harga_warna WHERE jenis = '$color'";
            $sql = mysqli_query($conn, $query);
            $data_warna_n = mysqli_fetch_assoc($sql);
            $harga_warna_n = $data_warna_n['harga'];
            $hargaWarna = $hargaWarna + $harga_warna_n;
            $dihitung = $dihitung + 1;
        } else{ // selain background
            
            for($checking2 = 0; $checking2 < count($checkingWarna2); $checking2++){
                if($checking2 == $checking){  // Jika telah mencapai di indeks yang sama, maka break berlaku, warna yang dihitung ditambahkan 1
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

                // Jika ada warna yang sama, dan indeks checking belum sama dengan checking2
                // maka looping di break tanpa ada penambahan hitungan.
                if($checkingWarna[$checking] == $checkingWarna2[$checking2]){break;}   
            }
        }    
    }

    
    // Persiapan hitungan jumlah warna 1, 2, dan 3 sebelum masuk ke dalam database 
    // Perhitungan berdasarkan jumlah kain yang di order
    $jumlah_warna1 = $warna1 != null ?  $jumlah : 0;
    $jumlah_warna2 = $warna2 != null ?  $jumlah : 0;
    $jumlah_warna3 = $warna3 != null ?  $jumlah : 0;
    $jumlah_warnabg = $warnabg != null ?  $jumlah : 0;


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

        $hargaTeknik = $hargaDurasi /2;
        $hargaDurasi = $hargaDurasi /2;

        $jenisTeknik = $teknik;
    }

    // Cari luas untuk menghitung harga berdasarkan luas (Rp. 1.5/cm2)
   
    $luas = $widthCanv * $heightCanv;


    // Cari hargaLuas
    $sql = mysqli_query($conn, "SELECT * FROM harga_kain WHERE id = 1") or die(mysqli_error($conn));
    $harga_kain_per_meter = mysqli_fetch_assoc($sql)['harga'];

    $hargaKain = $luas * $harga_kain_per_meter * $jumlah;

    // Cari Harga Total
    $harga = $hargaWarna + $hargaTeknik + $hargaDurasi + $hargaKain;

    $_SESSION['totalHarga'] = $harga;
    $_SESSION['hargaWarna'] = $hargaWarna;
    $_SESSION['hargaTeknik'] = $hargaTeknik;
    $_SESSION['hargaDurasi'] = $hargaDurasi;
    $_SESSION['hargaKain'] = $hargaKain;
    $_SESSION['hasilbatik'] = "0";

    // CARI PROCESSING TIME

    // Waktu processing time dihitung berdasarkan orderan sebelumnya. Bila orderan sebelumnya.
    // Bila Orderan sebelumnya belum selesai, maka order saat ini masih akan berada dalam proses menunggu
    // Apabila orderan masuk ketika proses orderan sebelumnya sudah selesai, maka waktu proses akan lebih cepat, karena tidak memerlukan waktu tunggu
    
    //                                           === SPECIAL CASE ===
    // adalah:
    // Kasus tanpa biaya tambahan karena pembeli memesan dibawah jumlah minimal batch kain, yang mengakibatkan penggunaan warna tidak mencapai batch mininimal kain:
    // Durasi akan bertambah lebih lama bagi pembeli apabila jumlah ordernya belum mencapai batch untuk di proses.
    // Proses akan dipending hingga orderan baru yang masuk hingga bisa memenuhi. 
    // Kasus ini tidak akan mempengaruhi harga durasi, hanya mempengaruhi durasi proses pemenuhan pesanan

    // Variabel process_status  = menentukan status langsung di proses atau masuk dalam daftar tunggu:
    $process_status = $_SESSION['process-status'];
   



    
    // === SPECIAL CASE ===
    $user_in_waiting = $_SESSION['user-waiting'];

    // mendapatkan data nomer id untuk pesanan saat ini :

    $get_previous_id = "SELECT hasilbatik_id FROM tbl_hasilbatik ORDER BY hasilbatik_id DESC LIMIT 1";
    $sql = mysqli_query($conn, $get_previous_id) or die(mysqli_error($conn));
    $previous_id_data = mysqli_fetch_assoc($sql);
    $current_id = $previous_id_data['hasilbatik_id'] + 1;

    // Mengambil dari database id order terakhir yang dalam status "dalam proses"
    $get_last_id_process = "SELECT hasilbatik_id FROM tbl_hasilbatik WHERE status = 'dalam proses' ORDER BY hasilbatik_id DESC LIMIT 1";
    $sql_last_id_process = mysqli_query($conn, $get_last_id_process) or die(mysqli_error($conn));
    $fetch_last_id_process = mysqli_fetch_assoc($sql_last_id_process);
    $last_id_process = $fetch_last_id_process['hasilbatik_id'];
    if($_SESSION['add-cost-status'] == 0){ // bila tidak ada biaya tambahan, cek apakah pesanan memenuhi batch atau tidak
        // bila memenuhi, maka update status dari setiap user pada waiting list

        // $last_id_process = $process_status == "dalam proses" ? $current_id : $dataSebelumnya['hasilbatik_id'];
        
        $color_used = [$warna1, $warna2, $warna3, $warnabg];
        $color_used_count = [$warna1 != "" ? $jumlah : 0, $warna2 != "" ? $jumlah : 0, $warna3 != "" ? $jumlah : 0, $warnabg != "" ? $jumlah : 0];
        
        // Proses akumulasi jumlah warna dari user yang masih menunggu,
        // Ditambah dengan jumlah warna yang digunakan user saat ini.
        foreach($user_in_waiting as $user){
            $user_data = json_decode($user);
            if(in_array($user_data->warna1, $color_used) && $user_data->warna1 != ""){
                $find_color_key = array_search($user_data->warna1, $color_used);
                $color_used_count[$find_color_key] = $color_used_count[$find_color_key] + $user_data->jumlah_warna1;               
            }
            
            if(in_array($user_data->warna2, $color_used) && $user_data->warna2 != ""){
                $find_color_key = array_search($user_data->warna2, $color_used);
                $color_used_count[$find_color_key] = $color_used_count[$find_color_key] + $user_data->jumlah_warna2;              
            }

            if(in_array($user_data->warna3, $color_used) && $user_data->warna3 != ""){
                $find_color_key = array_search($user_data->warna3, $color_used);
                $color_used_count[$find_color_key] = $color_used_count[$find_color_key] + $user_data->jumlah_warna3;
            }

            if(in_array($user_data->warna_bg, $color_used) && $user_data->warna_bg != ""){
                $find_color_key = array_search($user_data->warna_bg, $color_used);
                $color_used_count[$find_color_key] = $color_used_count[$find_color_key] + $user_data->jumlah_warnaBg;
            }
        }

        

        // Update jumlah warna akumulasi pembeli yang masih ada dalam daftar tunggu
        
        foreach($user_in_waiting as $user_update){
            $user_data = json_decode($user_update);
            $count_color_used = 0;

            if(in_array($user_data->warna1, $color_used) && $user_data->warna1 != ""){
                $find_color_key = array_search($user_data->warna1, $color_used);
                $user_data->jumlah_warna1 = $color_used_count[$find_color_key];
                
                if($user_data->jumlah_warna1 > 5){$count_color_used++;}
            } 

            if(in_array($user_data->warna2, $color_used) && $user_data->warna2 != ""){
                $find_color_key = array_search($user_data->warna2, $color_used);
                $user_data->jumlah_warna2 = $color_used_count[$find_color_key];
                if($user_data->jumlah_warna2 > 5){$count_color_used++;} 
            } 

            if(in_array($user_data->warna3, $color_used) && $user_data->warna3 != ""){
                $find_color_key = array_search($user_data->warna3, $color_used);
                $user_data->jumlah_warna3 = $color_used_count[$find_color_key];
                if($user_data->jumlah_warna3 > 5){$count_color_used++;}
            } 

            if(in_array($user_data->warna_bg, $color_used) && $user_data->warna_bg != ""){
                $find_color_key = array_search($user_data->warna_bg, $color_used);
                $user_data->jumlah_warnaBg = $color_used_count[$find_color_key];

                if($user_data->jumlah_warnaBg > 5){$count_color_used++;}
            }
            
            if($count_color_used == $user_data->num_of_color){ // bila jumlah pesanan telah mencapai syarat batch penggunaan warna
                $user_data->status = "dalam proses";
                
                $user_data->last_id_process = $last_id_process; // user memegang id_order dengan status "dalam proses" sebelum dia
        
                $last_id_process = $user_data->id_order; // update id order terakhir yang siap di proses 

                //  *** Disini data-data pembeli yang berganti status dalam database akan di update lewat perintah sql ***// 

                // menghitung dahulu jarak hari antara order dgn status dalam proses yang paling terakhir dan orderan yang akan di-update
                $last_order_in_process = "SELECT manufacturing_date, durasi FROM tbl_hasilbatik WHERE hasilbatik_id = $user_data->last_id_process"; 
                $sql_data = mysqli_query($conn, $last_order_in_process) or die(mysqli_error($conn));
                $previous_data_special_case = mysqli_fetch_assoc($sql_data);
                

                $previous_date = $previous_data_special_case['manufacturing_date']; 
                // fungsi manufacturing_date agar data tanggal yang dibuat pada order dalam status daftar tunggu tidak berubah,
                // Hal ini juga untuk menghitung jarak interval antara waktu pembuatan order in process dan order yang baru berubah status dari- 
                // waiting list ke in process.

                // Sehingga ketika hanya menggunakan data hasilbatik_tanggal sebagai data dinamis dan digunakan untuk menghitung jarak interval,
                // maka data asli tanggal order dibuat akan berubah.
                
                $previous_duration = $previous_data_special_case['durasi'];
                
            
                $previous_date = date_create($previous_date);
                $user_update_date = date_create($tanggal); // 
            
                $interval_user_waiting = $user_update_date->diff($previous_date)->days;
                $duration_in_day = $user_data->manufact_duration;

                if($interval_user_waiting <= $previous_duration){
                    $duration_in_day= $duration_in_day + ($previous_duration - $interval_user_waiting);
                }
                
                // Pengecekkan apakah ada warna yang sama dalam desain yang sama
                // Apabila ada warna yang sama, maka akan mempengaruh durasi pengerjaan (update durasi),
                // Dengan catatan teknik pewarnaanya celup.

    
                $checking_color = array();
                $color_user_waiting = [$user_data->warna1, $user_data->warna2, $user_data->warna3, $user_data->warna_bg];
            
                for($i = 0; $i < count($color_user_waiting); $i++){
                    if(!in_array($color_user_waiting[$i], $checking_color) && $color_user_waiting[$i] != ""){
                        array_push($checking_color, $color_user_waiting[$i]);
                    } 
                }



                $num_of_color = count($checking_color);

                // tambahan durasi untuk teknik celup
                if($user_data->coloring_method == "celup"){
                    $duration_in_day = $duration_in_day + $num_of_color; // == Perhitungan durasi sampai disini ==
                } 

                // update ke database
                $query_update = "UPDATE tbl_hasilbatik SET durasi = $duration_in_day, manufacturing_date  = '$tanggal', status = 'dalam proses', last_id_in_process=$user_data->last_id_process WHERE hasilbatik_id = $user_data->id_order";
                mysqli_query($conn, $query_update) or die(mysqli_error($conn));

            }
        }

        

        

        // Setelah ini, order yang sekarang harus di update pengerjaannya sesuai dengan id terakhir in process

        $query = "SELECT * FROM tbl_hasilbatik WHERE status = 'dalam proses' ORDER BY hasilbatik_id DESC LIMIT 1"; // ini harus sesudah order sebelumnya yang masih status tunggu update ke "dalam proses"
        $sql = mysqli_query($conn, $query) or die(mysqli_error($conn));


        $previous_data = mysqli_fetch_assoc($sql);
    
        // process_status == dalam proses adalah melanjutkan perhitungan durasiHari bila orderan langsung diproses
        // bila orderan masih dalam status daftar tunggu, maka perhitungan durasiHari tidak akan dilanjutkan
       
        if($process_status == "dalam proses"){
            
            // p_dat = previous_date , p_dur = previous_duration 
            $p_dat = $previous_data['hasilbatik_tanggal'];
            $p_dur = $previous_data['durasi'];
            
        
            $p_dat = date_create($p_dat);
            // $tanggalFormat = date_create($tanggal);
            $current_date = date_create($tanggal);
        
            $interval = $current_date->diff($p_dat)->days;
        
            if($interval <= $p_dur){
                $durasiHari= $durasiHari + ($p_dur - $interval);
            }
        
            
            // tambahan durasi untuk teknik celup
            if($teknik == "Celup"){
                $durasiHari = $durasiHari + $dihitung; // == Perhitungan durasi sampai disini ==
            } 
        }
    
        
    } else{ 
        // Bila ada biaya tambahan
        // cukup update last_id_process json pada setiap user yang punya status daftar tunggu
       
        foreach($user_in_waiting as $user){
            $user_data = json_decode($user);
            $query_update = "UPDATE tbl_hasilbatik SET last_id_in_process=$current_id WHERE hasilbatik_id = $user_data->id_order";
            mysqli_query($conn, $query_update) or die(mysqli_error($conn));
        }

        

        // Mengambil id order terakhir dengan status dalam proses
        $query = "SELECT * FROM tbl_hasilbatik WHERE status = 'dalam proses' ORDER BY hasilbatik_id DESC LIMIT 1"; // ini harus sesudah order sebelumnya yang masih status tunggu update ke "dalam proses"
        
        $sql = mysqli_query($conn, $query) or die(mysqli_error($conn));
        
        $dataSebelumnya = mysqli_fetch_assoc($sql);
    
        // process_status == dalam proses adalah melanjutkan perhitungan durasiHari bila orderan langsung diproses
        // bila orderan masih dalam status daftar tunggu, maka perhitungan durasiHari tidak akan dilanjutkan
       

           
        $tanggalSebelumnya = $dataSebelumnya['hasilbatik_tanggal'];
        $durasiSebelumnya = $dataSebelumnya['durasi'];
        
    
        $tanggalSebelumnya = date_create($tanggalSebelumnya);
        $tanggalFormat = date_create($tanggal);
    
        $interval = $tanggalFormat->diff($tanggalSebelumnya)->days;
    
        if($interval <= $durasiSebelumnya){
            $durasiHari= $durasiHari + ($durasiSebelumnya - $interval);
        }
    
        
        // tambahan durasi untuk teknik celup
        if($teknik == "Celup"){
            $durasiHari = $durasiHari + $dihitung; // == Perhitungan durasi sampai disini ==
        } 
    

    }
    

    $_SESSION['durasi'] = $process_status == "dalam proses" ? $durasi. " hari" : "menunggu order selanjutnya";
    // $_SESSION['durasi'] = $durasiHari . " hari"; 

    // PENTING! : Yang di update pada pembeli yang sudah berganti status menjadi dalam proses adalah status, durasi, dan last_id_process

    



    // Cari delivery time
    $asalDaerah = $_SESSION['daerah_customer'];

    $query = "SELECT * FROM harga_kirim WHERE asal_daerah = '$asalDaerah'";
    $sql = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $dataDaerah = mysqli_fetch_assoc($sql);
    $delTime = $dataDaerah['delivery_time'];
    $ongkosKirim = $dataDaerah['harga'];


    // Penambahan biaya apabila pembeli tidak mau menunggu
    $add_cost = $_SESSION['addcost'];
    
    $harga = $harga + $ongkosKirim + $add_cost;
    

    $idCustomer = $_SESSION['id_customer'];


    
    

    // Menginputkan seluruh data ke tbl_hatilbatik database
    $query = "INSERT INTO tbl_hasilbatik VALUES (
        '$karakter_id', '$filename', '$filenameHp', '$tanggal', '$kreator', '$namakarya', 
        '$algoritma', '$jmlmotif', '$widthCanv', '$heightCanv', 
        '$paddingTop', '$paddingSide', '$gap', '$gapX', '$gapY', 
        '$jumlah', '$jenisTeknik', '$jenisWarna1', $jumlah_warna1, '$jenisWarna2', 
        $jumlah_warna2, '$jenisWarna3', $jumlah_warna3, '$jenisWarnabg', $jumlah_warnabg, 
        $durasiHari, $manufacturing_duration, '$manufacturing_date', $harga, '$process_status', 'belum', $idCustomer, $delTime,
        $last_id_process
    )";


    mysqli_query($conn, $query) or die(mysqli_error($conn));
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
    
    header('location:hasilbatik.php?id=' . $idCustomer);
    exit;  

 ?>