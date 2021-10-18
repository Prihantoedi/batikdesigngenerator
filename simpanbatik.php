<?php 
    session_start();
    
    // Functions
    require '_functions.php';
    require 'colortranslate.php';

    // koneksi ke hasilbatik database untuk menghitung warna yang masuk sesuai minimal batch
    $conn = mysqli_connect("localhost", "root", "", "database_batik_galih");
    
    
    // Mencari user yang memiliki status daftar tunggu, dan menghitung akumulasi warna yang sama digunakan

    $waitingList = query("SELECT * FROM tbl_hasilbatik WHERE status = 'daftar tunggu' ");
    $colorCount = array();
    $user_in_waiting = array(); // menampung semua user yang masih di status tunggu

    // untuk status user yang masih di daftar tunggu, data yang dibutuhkan adalah:
    // hasilbatik_id, warna1, jumlah warna1, warna2, jumlah warna2, warna3, jumlah warna3, warna background, jumlah warna background-
    // dan id orderan terakhir yang sudah masuk dalam process (last_id_in_process);
    // setiap id yang masih dalam daftar tunggu akan memegang id terakhir yang on process;

    foreach($waitingList as $waiting){
        
        $color1_hex = colorToHex($waiting["warna1"]);
        $color2_hex = colorToHex($waiting["warna2"]);
        $color3_hex = colorToHex($waiting["warna3"]);
        $colorbg_hex = colorToHex($waiting["warnaBg"]);
                
        
        if(array_key_exists($color1_hex, $colorCount)){ $colorCount[$color1_hex] = $colorCount[$color1_hex] + $waiting["jumlah_warna1"];}
        else $colorCount[$color1_hex] = $waiting["jumlah_warna1"];

        if(array_key_exists($color2_hex, $colorCount)){ $colorCount[$color2_hex] = $colorCount[$color2_hex] + $waiting["jumlah_warna2"];}
        else $colorCount[$color2_hex] = $waiting["jumlah_warna2"];
        
        if(array_key_exists($color3_hex, $colorCount)){ $colorCount[$color3_hex] = $colorCount[$color3_hex] + $waiting["jumlah_warna3"];}
        else $colorCount[$color3_hex] = $waiting["jumlah_warna3"];

        if(array_key_exists($colorbg_hex, $colorCount)){ $colorCount[$colorbg_hex] = $colorCount[$colorbg_hex] + $waiting["jumlah_warnabg"];}
        else $colorCount[$colorbg_hex] = $waiting["jumlah_warnabg"];

        // proses menampung semua user yang masih status tunggu:
        $user_wait_obj = new stdClass();
        $user_wait_obj->id_order= $waiting['hasilbatik_id'];
        $count_color_used = 0;

        $user_wait_obj->warna1 = $waiting['warna1'];
        $user_wait_obj->warna1_hex = $color1_hex;
        $user_wait_obj->jumlah_warna1 = $waiting['jumlah_warna1'];
        if($user_wait_obj->warna1 != ""){$count_color_used++;}

        $user_wait_obj->warna2 = $waiting['warna2'];
        $user_wait_obj->warna2_hex = $color2_hex;
        $user_wait_obj->jumlah_warna2 = $waiting['jumlah_warna2'];
        if($user_wait_obj->warna2 != ""){$count_color_used++;}

        $user_wait_obj->warna3 = $waiting['warna3'];
        $user_wait_obj->warna3_hex = $color3_hex;
        $user_wait_obj->jumlah_warna3 = $waiting['jumlah_warna3'];
        if($user_wait_obj->warna3 != ""){$count_color_used++;}

        $user_wait_obj->warna_bg = $waiting['warnaBg'];
        $user_wait_obj->warnabg_hex = $colorbg_hex;
        $user_wait_obj->jumlah_warnaBg = $waiting['jumlah_warnabg'];
        if($user_wait_obj->warna_bg != ""){$count_color_used++;}

        $user_wait_obj->manufact_duration = $waiting['manufacturing_duration'];
        $user_wait_obj->manufact_date = $waiting['manufacturing_date'];
        $user_wait_obj->status = $waiting['status'];

        $user_wait_obj->last_id_process = $waiting['last_id_in_process']; // id order terakrhi dengan status dalam proses
        $user_wait_obj->coloring_method = $waiting['teknik_pewarnaan'];
        // Untuk mentrace berapa macam warna yang digunakan oleh pembeli:
        $user_wait_obj->num_of_color = $count_color_used;


    
        $make_json =  json_encode($user_wait_obj);

        array_push($user_in_waiting, $make_json);
    }

    $colorCountLength = count($colorCount); // for javascript
    
    if(isset($_POST['submitsimpan'])){
        
        $_SESSION['svgBatik']  = $_POST['svgBatik'];
        $_SESSION['svgBatikHp']  = $_POST['svgBatikHp'];
        $_SESSION['namakarya'] = htmlspecialchars($_POST['namakarya']);
        $_SESSION['motifJml'] = htmlspecialchars($_POST['motifJml']);
        $_SESSION['jumlah'] = htmlspecialchars($_POST['jumlah']);
        $_SESSION['teknik'] = htmlspecialchars($_POST['teknik']);
        $_SESSION['warna1'] = htmlspecialchars($_POST['warna1']);
        $_SESSION['warna2'] = htmlspecialchars($_POST['warna2']);
        $_SESSION['warna3'] = htmlspecialchars($_POST['warna3']);
        $_SESSION['warnabg'] = htmlspecialchars($_POST['warnabg']);
        $_SESSION['keliling'] = ($_POST['keliling']);
        $_SESSION['totalmotif'] = ($_POST['totalmotif']);
        $_SESSION['datawarna'] = ($_POST['datawarna']);
        $_SESSION['addcost'] = ($_POST['add-cost']);
        $_SESSION['add-cost-status'] = ($_POST['add-cost-status']);
        $_SESSION['process-status'] = ($_POST['process-status']);
        $_SESSION['user-waiting'] = $user_in_waiting;
        header('location:.saving.php');
        exit;
    }

    $motifJml = count($_SESSION['motif_id']);
    $colorDesign = [];
    $warnaBg = $_SESSION['colorBg'];
    $warna1 = $_SESSION['color1'];
    array_push($colorDesign, $warnaBg, $warna1);

    if($motifJml == 1 ){
        $warna2 = null;
        $warna3 = null;
    } elseif($motifJml == 2){
        $warna2 = $_SESSION['color2'];
        array_push($colorDesign, $warna2);
        $warna3 = null;
    } else{
        $warna2 = $_SESSION['color2'];
        $warna3 = $_SESSION['color3'];
        array_push($colorDesign, $warna2, $warna3);
    }

    if($motifJml>0){
        foreach($_SESSION['motif_id'] as $mtf){
            $motifFile[] = query("SELECT * FROM tbl_motif WHERE motif_id = ".$mtf)[0]['motif_file'];
        }
        // $motifSVG  = cetakMotif($motifFile, 65);
        $motifSVG  = ambilSatu($motifFile, 65);
        
        // file javascript algoritma
        $algoritmaFile = algorithmSwitch($_SESSION["algoritma"],$motifJml);
    }

    // penambahan harga jika jumlah pesanan tidak memenuhi batch, dan konsumen tidak mau menunggu:


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bikin Batik</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/simpanbatik.css">
</head>
<body >
    <!-- <a href="desain.php?widthCanv=<?php echo $_SESSION["widthCanv"]*0.02645833 ?>&heightCanv=<?php echo $_SESSION["heightCanv"]*0.02645833 ?>&algoritma=<?php echo $_SESSION["algoritma"] ?>&submit=">KEMBALI</a> -->
    <form action="" method="post">
        <table>
            <tr>
                <td><label for="namakarya">Judul Hasil Kreasi</label></td><td>:</td>
                <td><input type="text" name="namakarya" id="namakarya" maxlength="50" style="width:175px; text-align:left;" required></td>
            </tr>
            <tr>
                <td><label for="jumlah" >Jumlah Pembelian</label></td><td>:</td>
                <td><input type="number" name="jumlah" id="jumlah" min="1" style="width:175px; text-align:left;" required></td>
            </tr>
            <tr>
                <td><label for="teknik" >Teknik Pewarnaan</label></td><td>:</td>
                <!-- <td><input type="text" name="warnabg"   id="warnabg"   maxlength="50" style="width:175px; text-align:left;" required></td> -->
                <td>
                    <select id="teknik" name="teknik" style="width:183px; text-align:left;" required>
                        <option value="" selected>Pilih Teknik Pewarnaan</option>
                        <option value="Celup">Celup</option>
                        <option value="Colet">Colet</option>
                    </select>
                </td>
            </tr>
        </table>
        <button type="submit" name="submitsimpan" id="saveButton" onclick="return confirm('Apakah data yg anda inputkan sudah sesuai?')" hidden>Simpan Batik</button>
        <div name="dummySave" id="dummy-save">Simpan Batik</div>
        <input type="hidden" name="svgBatik"        id="var_svgBatik"        value="">

        <input type="hidden" name="svgBatikHp"      id="var_svgBatikHp"      value="">
        
        <input type="hidden" name="warna1"          id="warna-1"             value="<?php echo $warna1; ?>" >
        <input type="hidden" name="warna2"          id="warna-2"             value="<?php echo $warna2; ?>" >
        <input type="hidden" name="warna3"          id="warna-3"             value="<?php echo $warna3; ?>" >
        <input type="hidden" name="warnabg"         id="warna-bg"            value="<?php echo $warnaBg; ?>" >
        <input type="hidden" name="motifJml"        id="motif-jml"           value="<?php echo $motifJml; ?>">
        <input type="hidden" name="keliling"        id="collect-keliling">
        <input type="hidden" name="totalmotif"      id="total-motif">
        <input type="hidden" name="datawarna"      id="data-warna">
        <input type="hidden" name="add-cost"        id="add-cost" value=0>
        <input type="hidden" name="add-cost-status"        id="add-cost-status" value=0>
        <input type="hidden" name="process-status"          id="process-status" value="dalam proses">
    </form>

    
    <!-- MODAL UNTUK KONFIRMASI MENUNGGU PESANAN BARU MASUK HINGGA JUMLAH WARNA TERPENUHI -->

    <button type="button" class="btn btn-primary" id="btn-trigger" data-bs-toggle="modal" data-bs-target="#modalInfo" hidden>
    Launch
    </button>

    <!-- Modal -->
    
    <div class="modal fade" id="modalInfo" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            Pesanan anda masuk dalam daftar tunggu sebelum diproses. Apakah Anda bersedia menambah Rp. <span id="add-cost-desc">xxx</span> agar pesanan langsung diproses?
    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="onprocess">Ya</button>
                <button type="button" class="btn btn-dark" id="waiting">Tidak</button>
            </div>
            </div>
        </div>
    </div>

    <!-- END: MODAL UNTUK KONFIRMASI MENUNGGU PESANAN BARU MASUK HINGGA JUMLAH WARNA TERPENUHI -->

    <?php if (isset($_SESSION['warna1']) && !empty($_SESSION['warna1'])) {?>
        <div id="color-motif1-opt" value="<?php echo $_SESSION['warna1'];?>"> </div>
        <?php } else {?>
        <div id="color-motif1-opt" value="black"> </div>
    <?php } ?>

    <?php if (isset($_SESSION['warna2']) && !empty($_SESSION['warna2'])) {?>
            <div id="color-motif2-opt" value="<?php echo $_SESSION['warna2'];?>"> </div>
            <?php } else {?>
            <div id="color-motif2-opt" value="black"> </div>
    <?php } ?>

    <?php if (isset($_SESSION['warna3']) && !empty($_SESSION['warna3'])) {?>
        <div id="color-motif3-opt" value="<?php echo $_SESSION['warna3'];?>"> </div>
        <?php } else {?>
        <div id="color-motif3-opt" value="black"> </div>
    <?php } ?>

    <div id="hasilBatik"></div>
        
    <div id="download-color" style="margin-top: 30px; margin-bottom: 30px;"></div>
    
    <div id="hasilBatikHp"></div>

    <div id="download-hp" style="margin-top: 30px"></div>

    <div style="height:0px; visibility:hidden;">
        <?php for ($i=0; $i < $motifJml; $i++){ 
            echo $motifSVG[$i];
        } ?>
    </div>

    <script>
            var widthCanv, heightCanv, paddingTop, paddingSide, obj, obj2, obj3, gap, gapX, gapY,
                motifJml, motifTagHTML;
            
            // Variabel parameter
            widthCanv       = cmToPixel(<?php echo  $_SESSION['widthCanv'];?>);
            heightCanv      = cmToPixel(<?php echo  $_SESSION['heightCanv'];?>);
            paddingTop      = cmToPixel(<?php echo  $_SESSION['paddingTop'];?>);
            paddingSide     = cmToPixel(<?php echo  $_SESSION['paddingSide'];?>);
            obj             = cmToPixel(<?php echo  $_SESSION['obj'];?>);
            obj2            = cmToPixel(<?php echo  $_SESSION['obj2'];?>);
            obj3            = cmToPixel(<?php echo  $_SESSION['obj3'];?>);
            gap             = cmToPixel(<?php echo  $_SESSION['gap'];?>);
            gapX            = cmToPixel(<?php echo  $_SESSION['gapX'];?>);
            gapY            = cmToPixel(<?php echo  $_SESSION['gapY'];?>);

            // Variabel Motif 
            motifJml        = <?php echo $motifJml; ?>;
            motifTagHTML    = document.querySelectorAll("svg");

            // Variabel ukuran object asli
            var realObjSizex = [];
            var realObjSizey = [];

            // Variabel Path
            var motifPath = [];

            function cmToPixel(value){
                return value*37.795276;
            }
            function pixelToCm(value){
                return value*0.02645833;
            }

            clr1 = "<?php echo $_SESSION['color1'];  ?>";
            clr2 = "<?php echo $_SESSION['color2'];  ?>";
            clr3 = "<?php echo $_SESSION['color3'];  ?>";

            var colorChange = "<?php echo $_SESSION['colorchange'];  ?>";
            var clrChange = colorChange.split(",");
            var isSave = true;

    </script>

    <script type="text/javascript" src="javascript/<?php echo $algoritmaFile; ?>"></script>
    <script type="text/javascript" src="javascript/basic.js"></script>
    <script type="text/javascript" src="javascript/download.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvg/dist/browser/canvg.min.js"></script>
    
    <script>

        var isCanvasExist = document.getElementById("mycanv");
        if(isCanvasExist){
            isCanvasExist.style.fill = "<?php echo $_SESSION['colorBg']; ?>";
        } else{
            console.log("canvas not exist");
        }

        exporthasilbatik('hasilbatik');

         var urlSVG = document.getElementById("linkSVG").getAttribute('href');
        document.getElementById('var_svgBatik').value = urlSVG;
        var urlSVGHp = document.getElementsByTagName('a')[1].getAttribute('href');
        document.getElementById('var_svgBatikHp').value = urlSVGHp;
        
        
      

        // Save Event: kasus spesifik warna belum memenuhi batch 
        
    
        document.addEventListener("click", function(event){
           var btnClicked = event.target;
            
            if(btnClicked["id"] == "dummy-save"){
                var user_waiting = <?php echo json_encode($user_in_waiting); ?>;
                
                var color_count_db = <?php echo json_encode($colorCount); ?>; // warna dari database
                var color_design = <?php echo json_encode($colorDesign); ?>; // warna dari user yg sedang mendesain 
                console.log(color_design.length);

                var color_count_db_len = <?php echo json_encode($colorCountLength); ?>;
                color_count_db_len = parseInt(color_count_db_len);
                            
                // Pengecekkan Batch
                var num_ordered = document.getElementById("jumlah").value;
                var from_color_design = num_ordered === "" ? 0 : parseInt(num_ordered); // jumlah orderan yang diinputkan current_user
                if(num_ordered < 6){ // Apabila jumlah yang dipesan kurang dari 6 , maka dicek akumulasi warna
                    
                    
                    if(color_count_db_len > 0){
                        var continue_process = true;
                        var count_continue_process = 0;
                        
                        var accumulation_color = {}; // menampung warna jumlah warna dari user yang sedang mendesain
                        for(const c in  color_design){
                            accumulation_color[color_design[c]] = from_color_design;
                        }

                        // mengiterasi seluruh user waiting untuk dilihat penggunaan warnanya, kemudian dicocokkan jumlahnya dengan user yang sedang mendesain
                        for(const element in user_waiting){
                            var json_colnum = JSON.parse(user_waiting[element]);
                            var get_color_num = json_colnum['num_of_color'];
                            var hex_color_user_waiting = [json_colnum['warna1_hex'], json_colnum['warna2_hex'], json_colnum['warna3_hex'], json_colnum['warnabg_hex'] ]
                            // console.log(hex_color_user_waiting);

                            var dictionary = {"warna1_hex" : "jumlah_warna1", "warna2_hex" : "jumlah_warna2", "warna3_hex" : "jumlah_warna3", "warnabg_hex": "jumlah_warnaBg"};
                            // console.log(Object.keys(dictionary).find(key => dictionary[key] === "jumlah_warna1"));
                            
                            if(get_color_num == color_design.length){ // jumlah warna yang digunakan user waiting sama current user sama?

                                for(const hex_ele in hex_color_user_waiting){
                                    if(color_design.includes(hex_color_user_waiting[hex_ele]) && hex_color_user_waiting[hex_ele] != null){
                                        var get_key_color = Object.keys(json_colnum).find(key=>json_colnum[key] === hex_color_user_waiting[hex_ele]); // mengambil key dari jsoncolnunm : warna heksadesimal
                                        var what_color =  dictionary[get_key_color]; // ambil nilai dari dictionary berdasarkan key
                                        var get_num_color = json_colnum[what_color];
                                        get_num_color = parseInt(get_num_color); 
                                        accumulation_color[hex_color_user_waiting[hex_ele]] = accumulation_color[hex_color_user_waiting[hex_ele]] + get_num_color;  // menghitung akumulasi warna yang sama digunakan
                                    }
                                }
                            }
                        }
                        // console.log(accumulation_color);
                        for(const property in accumulation_color){
                            if(accumulation_color[property] < 6){continue_process = false; break;}
                        }

                        // cek apakah ada total penggunaan warna kurang dari 6 ? 
                        if(!continue_process){
                            var add_cost = document.getElementById("add-cost-desc");
                            if(from_color_design == 1) {add_cost.innerHTML = "75.000";}
                            else if(from_color_design == 2){add_cost.innerHTML = "37.500";}
                            else if(from_color_design == 3){add_cost.innerHTML = "25.000";}
                            else if(from_color_design == 4){add_cost.innerHTML = "18.750";}
                            else if(from_color_design == 5){add_cost.innerHTML = "15.000";}
                            else {add_cost.innerHTML = 0;}

                            var specialCaseModal = document.getElementById("btn-trigger");
                            specialCaseModal.click(); // asking confirmation
                            $continue_process = false;
                        } else{
                            var saveBtn = document.getElementById("saveButton");
                            saveBtn.click();
                        }
    
                        // for(var[key, value] of Object.entries(color_count_db)){
                        //     color_count_db[key] = parseInt(value);
                            
                            
                        //     // apabila ada warna yang sama antara user waiting dan user sekarang sedang mendesain:
                        //     if(color_design.includes(key)){ 
   
                        //         color_count_db[key] = color_count_db[key] + from_color_design;


                        //         if(color_count_db[key] < 6){
                        //             var add_cost = document.getElementById("add-cost-desc");
        
                        //             if(from_color_design == 1) {add_cost.innerHTML = "75.000";}
                        //             else if(from_color_design == 2){add_cost.innerHTML = "37.500";}
                        //             else if(from_color_design == 3){add_cost.innerHTML = "25.000";}
                        //             else if(from_color_design == 4){add_cost.innerHTML = "18.750";}
                        //             else if(from_color_design == 5){add_cost.innerHTML = "15.000";}
                        //             else {add_cost.innerHTML = 0;}

                        //             var specialCaseModal = document.getElementById("btn-trigger");
                        //             specialCaseModal.click(); // asking confirmation
                        //             $continue_process = false;
                        //         }
                        //     }
                            
                        // } 

                        // // process langsung berlanjut apabila jumlah pesanan < 6 namun sudah memenuhi batch
                        // if($continue_process){ 
                        //     var saveBtn = document.getElementById("saveButton");
                        //     saveBtn.click();
                        // }

                    }   else{
                        var add_cost = document.getElementById("add-cost-desc");
                        if(from_color_design == 1) {add_cost.innerHTML = "75.000";}
                        else if(from_color_design == 2){add_cost.innerHTML = "37.500";}
                        else if(from_color_design == 3){add_cost.innerHTML = "25.000";}
                        else if(from_color_design == 4){add_cost.innerHTML = "18.750";}
                        else if(from_color_design == 5){add_cost.innerHTML = "15.000";}
                        else {add_cost.innerHTML = 0;}

                        var specialCaseModal = document.getElementById("btn-trigger");
                        specialCaseModal.click(); // asking confirmation => diarahkan ke pertanyaan biaya tambahan
                    }
                    

                    
                } 

                else {  // Bila order lebih dari 5
                    var saveBtn = document.getElementById("saveButton");
                    saveBtn.click();
                }
                

            }

            // Event jika pembeli setuju membayar biaya tambahan

            if(btnClicked["id"] == "onprocess"){
                var add_cost_html = document.getElementById("add-cost-desc");
                var add_cost = add_cost_html.innerHTML;
                add_cost = add_cost.replace(".", "");
                
                var add_cost_session = document.getElementById("add-cost");
                add_cost_session.setAttribute("value", add_cost);

                var add_cost_session_status = document.getElementById("add-cost-status");
                add_cost_session_status.setAttribute("value", 1);

                // klik save
                var saveBtn = document.getElementById("saveButton");
                saveBtn.click();
            }

            // Event jika pembeli tidak setuju membayar biaya tambahan

            if(btnClicked["id"] == "waiting"){
                var process_status = document.getElementById("process-status");
                process_status.setAttribute("value", "daftar tunggu");

                 // klik save
                 var saveBtn = document.getElementById("saveButton");
                saveBtn.click();
            }

            
        });


        // End : Save Event
        
        var allMotifClass = ["first-motif", "second-motif", "third-motif"];
        var collectKeliling = [];
        var numOfMotif = [];

        for (i = 0 ; i < motifJml; i++){
            
            // jlh motif
            var motifClass = document.getElementsByClassName(allMotifClass[i]);
            numOfMotif.push(motifClass.length);
            
            // sample motif
            var motifSample = document.getElementsByClassName(allMotifClass[i])[0];

            // keliling motif
            var getPath = motifSample.getElementsByTagName("path")[0];
            var bboxWidth = motifSample.getBBox().width;
            var bcWidth = getPath.getBoundingClientRect().width;

            var scaleNum = bcWidth / bboxWidth;

            var keliling = getPath.getTotalLength() * scaleNum;
            collectKeliling.push(keliling);
           
        }
        

        // input ke form
        var inKeliling = document.getElementById("collect-keliling");
        inKeliling.setAttribute("value", collectKeliling);

        var inTotalMotif = document.getElementById("total-motif");
        inTotalMotif.setAttribute("value", numOfMotif);
        
        var dataWarna = [clr1];
        var sisaWarna = [clr2, clr3]
        for(var d = 0; d < clrChange.length; d++){
            if(clrChange[d] == "0"){break;}
            else{
                dataWarna.push(sisaWarna[d]);
            }
        }
        
        var dataWarnaId = document.getElementById("data-warna");

        dataWarnaId.setAttribute("value", dataWarna);
        
        
    </script>    
</body>
</html>