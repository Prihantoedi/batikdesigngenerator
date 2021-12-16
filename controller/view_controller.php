<?php 
    require('_functions.php');
    require('database/db_management/querycenter.php');


    class ViewController{
        public function indexController($customer_id){ // passing customer id
            $queryComment = "SELECT status FROM tbl_hasilbatik WHERE id_customer = '$customer_id' ORDER BY hasilbatik_id DESC LIMIT 1 ";
            $query = new UserCommand();
            $get_status_data = $query->selectQuery($queryComment); 
            $status_data = array_key_exists('status', $get_status_data) ? $get_status_data['status'] : null;
            return $status_data;
        }

        public function desainController($sesi_desain, $motif_jml, $motif_id, $algorithm){

            if(is_null($sesi_desain)){ // cek sesi desain
                header("Location: index.php");
                exit;
            }
            $query = new UserCommand();
            
            if($motif_jml > 0){
                foreach($motif_id as $id){
                    $dataMotif = $query->selectQuery("SELECT * FROM tbl_motif WHERE motif_id = ".$id);
                    $motif_file[] = $dataMotif['motif_file'];
                    $motif_nama[] = $dataMotif['motif_nama'];
                }

                $motif_svg  = cetakMotif($motif_file, 65);
                $algoritma_file = algorithmSwitch($algorithm,$motif_jml);
                
            } 
            
            else{
                $motif_file = null; $motif_nama = null; $motif_svg = null; $algoritma_file = null;
            }
            return ["motif_file" => $motif_file, "motif_nama" => $motif_nama, "motif_svg" => $motif_svg, "algoritma_file" => $algoritma_file ];
        }

        public function simpanBatikController($motif_id, $warna_bg, $warna_1, $warna_2, $warna_3, $algoritma){
           
            // mendeteksi jumlah warna yang digunakan user saat ini
            $motif_jml = count($motif_id);
            $color_design = [];

            array_push($color_design, $warna_bg, $warna_1);
            
        
            if($motif_jml == 1 ){
                $warna_2 = null;
                $warna_3 = null;
            } elseif($motif_jml == 2){
                array_push($color_design, $warna_2);
                $warna_3 = null;
            } else{
                array_push($color_design, $warna_2, $warna_3);
            }
            
            // pengaturan motif dan tampilan motif
            $query = new UserCommand();

            if($motif_jml > 0){
                foreach($motif_id as $mtf){
                    $get_query_file = $query->selectQuery("SELECT * FROM tbl_motif WHERE motif_id = ".$mtf);
                    $motif_file[] = $get_query_file['motif_file'];
                }
                $motif_svg = ambilSatu($motif_file, 65);
                $algoritma_file = algorithmSwitch($algoritma, $motif_jml); 
            } else{
                $motif_svg = null;
                $algoritma_file = null;
            }

            // Mencari user yang memiliki status daftar tunggu, dan menghitung akumulasi warna yang sama digunakan

            $waiting_list = $query->selectQuery("SELECT * FROM tbl_hasilbatik WHERE status = 'daftar tunggu' ");

            $color_count = array();
            $user_in_waiting = array();
            
            // untuk status user yang masih di daftar tunggu, data yang dibutuhkan adalah:
            // hasilbatik_id, warna1, jumlah warna1, warna2, jumlah warna2, warna3, jumlah warna3, warna background, jumlah warna background-
            // dan id orderan terakhir yang sudah masuk dalam process (last_id_in_process);
            // setiap id yang masih dalam daftar tunggu akan memegang id terakhir yang on process;
            
            foreach($waiting_list as $waiting){
        
                $color1_hex = colorToHex($waiting["warna1"]);
                $color2_hex = colorToHex($waiting["warna2"]);
                $color3_hex = colorToHex($waiting["warna3"]);
                $colorbg_hex = colorToHex($waiting["warnaBg"]);
                        
                
                if(array_key_exists($color1_hex, $color_count)){ $color_count[$color1_hex] = $color_count[$color1_hex] + $waiting["jumlah_warna1"];}
                else $color_count[$color1_hex] = $waiting["jumlah_warna1"];
        
                if(array_key_exists($color2_hex, $color_count)){ $color_count[$color2_hex] = $color_count[$color2_hex] + $waiting["jumlah_warna2"];}
                else $color_count[$color2_hex] = $waiting["jumlah_warna2"];
                
                if(array_key_exists($color3_hex, $color_count)){ $color_count[$color3_hex] = $color_count[$color3_hex] + $waiting["jumlah_warna3"];}
                else $color_count[$color3_hex] = $waiting["jumlah_warna3"];
        
                if(array_key_exists($colorbg_hex, $color_count)){ $color_count[$colorbg_hex] = $color_count[$colorbg_hex] + $waiting["jumlah_warnabg"];}
                else $color_count[$colorbg_hex] = $waiting["jumlah_warnabg"];
        
                // proses menampung semua user yang masih status tunggu:
                $user_wait_obj = new stdClass();
                $user_wait_obj->id_order= $waiting['hasilbatik_id'];
                $count_color_used = [];
        
                $user_wait_obj->warna1 = $waiting['warna1'];
                $user_wait_obj->warna1_hex = $color1_hex;
                $user_wait_obj->jumlah_warna1 = $waiting['jumlah_warna1'];
                if($user_wait_obj->warna1 != "" && !in_array($user_wait_obj->warna1, $count_color_used)){array_push($count_color_used, $user_wait_obj->warna1);}
        
                $user_wait_obj->warna2 = $waiting['warna2'];
                $user_wait_obj->warna2_hex = $color2_hex;
                $user_wait_obj->jumlah_warna2 = $waiting['jumlah_warna2'];
                if($user_wait_obj->warna2 != "" && !in_array($user_wait_obj->warna2, $count_color_used)){array_push($count_color_used, $user_wait_obj->warna2);}
        
                $user_wait_obj->warna3 = $waiting['warna3'];
                $user_wait_obj->warna3_hex = $color3_hex;
                $user_wait_obj->jumlah_warna3 = $waiting['jumlah_warna3'];
                if($user_wait_obj->warna3 != "" && !in_array($user_wait_obj->warna3, $count_color_used)){array_push($count_color_used, $user_wait_obj->warna3);}
        
                $user_wait_obj->warna_bg = $waiting['warnaBg'];
                $user_wait_obj->warnabg_hex = $colorbg_hex;
                $user_wait_obj->jumlah_warnaBg = $waiting['jumlah_warnabg'];
                if($user_wait_obj->warna_bg != "" && !in_array($user_wait_obj->warna_bg, $count_color_used)){array_push($count_color_used, $user_wait_obj->warna_bg);}
        
                $user_wait_obj->manufact_duration = $waiting['manufacturing_duration'];
                $user_wait_obj->manufact_date = $waiting['manufacturing_date'];
                $user_wait_obj->status = $waiting['status'];
        
                $user_wait_obj->last_id_process = $waiting['last_id_in_process']; // id order terakrhi dengan status dalam proses
                $user_wait_obj->coloring_method = $waiting['teknik_pewarnaan'];
                // Untuk mentrace berapa macam warna yang digunakan oleh pembeli:
                $user_wait_obj->num_of_color = count($count_color_used);
        
        
            
                $make_json =  json_encode($user_wait_obj);
        
                array_push($user_in_waiting, $make_json);
            }

            $color_count_length = count($color_count);


            return ["motif_jumlah" => $motif_jml, "motif_svg" => $motif_svg, "algoritma_file" => $algoritma_file, "warna_1" => $warna_1, "warna_2" => $warna_2, "warna_3" => $warna_3, "color_count" => $color_count,  "color_count_length" => $color_count_length, "color_design" => $color_design, "user_in_waiting" => $user_in_waiting];
        }

        public function hasilBatikController($customer_id, $customer_type){
            $query = new UserCommand();
            $total_data_comment = "SELECT COUNT(*) as total FROM tbl_hasilbatik WHERE id_customer = $customer_id";
            $get_total_data = $query->selectQuery($total_data_comment);
            $total = $get_total_data['total'];
            
            if($customer_type == "baru"){
                $total_order_comment = "SELECT COUNT(*) as total FROM tbl_hasilbatik WHERE id_customer = $customer_id";
                $get_total_order = $query->selectQuery($total_order_comment);
                $total = $get_total_order['total'];

                if($total >= 10){
                    $update_total_comment = "UPDATE customers SET jenis = 'lama' WHERE id = $customer_id";
                    $update_customer_type =  $query->updateQuery($update_total_comment);
                    echo '<script language="javascript">';
                    echo 'alert("Selamat! Anda menjadi member lama dan mendapat potongan harga!")';
                    echo '</script>';
                    $customer_type = "lama";
                }
            }

            $hasil_batik_comment = "SELECT tbl_hasilbatik.hasilbatik_id, hasilbatik_file, hasilbatik_filehp, hasilbatik_tanggal,
                                hasilbatik_kreator, hasilbatik_namakarya, jumlahPembelian, teknik_pewarnaan, warna1, warna2, warna3, warnaBg, durasi, harga, status, status_bayar,
                                delivery_time,
                                tbl_algoritma.algoritma_nama 
                                FROM tbl_hasilbatik
                                INNER JOIN tbl_algoritma ON tbl_hasilbatik.algoritma_id = tbl_algoritma.algoritma_id
                                WHERE id_customer = $customer_id
                                ORDER BY hasilbatik_tanggal DESC
                                LIMIT 10
                                ";

            $hasil_batik = $query->selectQuery($hasil_batik_comment);

            foreach($hasil_batik as $tbl){
                $hasilbatikId[]  = $tbl['hasilbatik_id'];
                $file_names[]    = $tbl['hasilbatik_file'];
                $file_names_hp[] = $tbl['hasilbatik_filehp'];
                $tanggals  []    = $tbl['hasilbatik_tanggal'];
                $kreators  []    = $tbl['hasilbatik_kreator'];
                $namakaryas[]    = $tbl['hasilbatik_namakarya'];
                $algoritmas[]    = ucwords($tbl['algoritma_nama']);
                $motifId[]       = cariIdMotifdariHasil($tbl['hasilbatik_id']);

                $jumlah[] = $tbl['jumlahPembelian'];
                $teknik[] = $tbl['teknik_pewarnaan'];
                $warna1[] = $tbl['warna1'];
                $warna2[] = $tbl['warna2'];
                $warna3[] = $tbl['warna3'];
                $warnaBg[] = $tbl['warnaBg'];
                $durasi[] = $tbl['durasi'];
                $harga[] = $tbl['harga'];
                $status[] = $tbl['status'];
                $statusBayar[] = $tbl['status_bayar'];
                $deliveryTime[] = $tbl['delivery_time'];
            }
            $hasil_batik_num = count($hasil_batik);
            if($hasil_batik_num > 0){
                $order_data = ["hasilbatik_id" => $hasilbatikId, "file_name" => $file_names, "file_name_hp" => $file_names_hp, "tanggal" => $tanggals, "kreator" => $kreators, "nama_karya" => $namakaryas,
                            "algoritma" => $algoritmas, "motif_id" => $motifId, "jumlah" => $jumlah, "teknik" => $teknik, "warna_1" => $warna1, "warna_2" => $warna2, "warna_3" => $warna3, "warna_bg" => $warnaBg, "durasi" => $durasi, "harga" => $harga,
                            "status" => $status, "status_bayar" =>  $statusBayar, "delivery_time" => $deliveryTime];
                foreach($motifId as $mtfId){
                    $karakter[] = cariKarakterMotifBanyak($mtfId);
                }

                $order_data["karakter"]= $karakter;
            } else{
                $order_data = null;
            }


            return ["customer_type" => $customer_type, "order_data" => $order_data, "hasil_batik_jum" => $hasil_batik_num];
           
            
        }


    }

    class AdminController{
        public function hargaKainController(){
            $query = new UserCommand();
            $get_clothes_price = $query->selectQuery("SELECT * FROM harga_kain WHERE id = 1");
            $clothes_price = $get_clothes_price['harga'];
            return $clothes_price;
        }

        public function hargaMesinController(){
            $query = new UserCommand();
            
            $query_new_member = $query->selectQuery("SELECT * FROM harga_mesin WHERE id = 1");
            $query_old_member = $query->selectQuery("SELECT * FROM harga_mesin WHERE id = 2");

            $new_member_price = $query_new_member['harga'];
            $old_member_price = $query_old_member['harga'];
            
            return ["harga_new_member" => $new_member_price, "harga_old_member" => $old_member_price];
        }

        public function hargaTeknikController(){
            $query = new UserCommand();

            $query_teknik_celup = $query->selectQuery("SELECT * FROM harga_teknik WHERE id = 1");
            $query_teknik_colet = $query->selectQuery("SELECT * FROM harga_teknik WHERE id = 2");

            $price_celup = $query_teknik_celup['harga'];
            $price_colet = $query_teknik_colet['harga'];

            return ["celup" => $price_celup, "colet" => $price_colet];
        }

        public function hargaWarnaController(){
            $query = new UserCommand();
            $price_list_color = array();
            for($i = 0; $i < 10; $i++){
                $id = $i+1;
                $query_color_price = $query->selectQuery("SELECT * FROM harga_warna WHERE id = $id");
                array_push($price_list_color, $query_color_price['harga']);
            }

            return ["yellow_igk" => $price_list_color[0], "yellow_irk" => $price_list_color[1], 
                    "orange_hr" => $price_list_color[2], "brown_irrd" => $price_list_color[3], 
                    "blue_04b" => $price_list_color[4], "grey_irl" => $price_list_color[5],
                    "violet_14r" => $price_list_color[6], "rose_ir" => $price_list_color[7], "green_ib" => $price_list_color[8],
                    "putih" => $price_list_color[9]];

        }

        public function hargaUpdateController($id, $new_price, $price_type){
            $query = new UserCommand();

            $query_version = $query->selectQuery("SELECT * FROM $price_type WHERE id = $id");
            if($price_type != 'harga_kain'){$new_version = $query_version['version'] + 1;}
            
            $update_comment = ($price_type == 'harga_kain' ? "UPDATE harga_kain set harga = $new_price WHERE id = $id" : "UPDATE $price_type set harga = $new_price, version = $new_version WHERE id = $id");
            $update_price = $query->updateQuery($update_comment);
            $price_type = str_replace('_', '', $price_type);
            
            if(!$update_price){
                echo '<script language="javascript">';
                echo 'alert("Update harga gagal!!!")';
                echo '</script>';
                echo "<script>window.location = '$price_type.php'</script>";
            }
            
            echo '<script language="javascript">';
            echo 'alert("Update Berhasil!!!")';
            echo '</script>';
            echo "<script>window.location = '$price_type.php'</script>";
            
        }

    }
?>