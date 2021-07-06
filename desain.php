<?php 
    // Start session
    session_start();
    
    // Functions
    require '_functions.php';
    require '_parameter.php';
    
    // Cek sesi desain
    sesiDesain();
    // die(gettype($_SESSION['colorchange']));

    $motifJml = count($_SESSION['motif_id']);

    if($motifJml>0){
        foreach($_SESSION['motif_id'] as $mtf){
            $dataMotif = query("SELECT * FROM tbl_motif WHERE motif_id = ".$mtf)[0];
            $motifFile[] = $dataMotif['motif_file'];
            $motifNama[] = $dataMotif['motif_nama'];
        }
        $motifSVG  = cetakMotif($motifFile, 65);
        
        // file javascript algoritma
        $algoritmaFile = algorithmSwitch($_SESSION["algoritma"],$motifJml);
    }

    // die(print_r($_SESSION));
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Batik Web App</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&family=Varela+Round&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="css/desain.css">
</head>
<body id="body">

        <!-- Side navigation -->
        <div class="sidebar-container">
        <div class="sidebar">
            <a href="index.php"><h3 id="header-web-app">Batik Design <br>Creator</h3></a>
            <p style="color:#ff985c; font-size:85%; margin:0; margin-top:15px;"><i>(tekan gambar untuk ganti motif)</i></p>

            <div class="head-sidebar-row">
                <?php for ($i=0; $i < $motifJml ; $i++): ?>
                    <div class="head-sidebar-column">
                        <div class="motifterpilih" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)">
                        <form action="" method="POST">
                            <input type="hidden" name="paddingTop"  class="var_padding-top"  value="<?php echo $_SESSION['paddingTop']; ?>">
                            <input type="hidden" name="paddingSide" class="var_padding-side" value="<?php echo $_SESSION['paddingSide']; ?>">
                            <input type="hidden" name="obj"         class="var_obj"          value="<?php echo $_SESSION['obj']; ?>">
                            <input type="hidden" name="obj2"        class="var_obj2"         value="<?php echo $_SESSION['obj2']; ?>">
                            <input type="hidden" name="obj3"        class="var_obj3"         value="<?php echo $_SESSION['obj3']; ?>">
                            <input type="hidden" name="gap"         class="var_gap"          value="<?php echo $_SESSION['gap']; ?>">
                            <input type="hidden" name="gapX"        class="var_gapX"         value="<?php echo $_SESSION['gapX']; ?>">
                            <input type="hidden" name="gapY"        class="var_gapY"         value="<?php echo $_SESSION['gapY']; ?>">

                            <input type="hidden" name="colorBg" id="colorbg" class="var_colorBg" value="<?php echo $_SESSION['colorBg']; ?>">
                            <input type="hidden" name="color1"  id="varcolor1" class="var_color1" value="<?php echo $_SESSION['color1']; ?>">
                            <input type="hidden" name="color2"  class="var_color2" value="<?php echo $_SESSION['color2']; ?>">
                            <input type="hidden" name="color3"  class="var_color3" value="<?php echo $_SESSION['color3']; ?>">
                            <input type="hidden" name="colorchange"  class="color_change" value="<?php echo $_SESSION['colorchange']; ?>"> 
                        <!-- Motif Terpilih -->
                                <label class="labelmotifterpilih">
                                    <input class="inputhidden" type="submit" name="submit" value="0">
                                    <input class="inputhidden" type="hidden" name="motif_indeks" value="<?php echo $i ?>">
                                        <?php echo $motifSVG[$i]; ?>
                                </label>
                        </form>
                        </div>

                        <div class="hapusmotifterpilih btnHapus">
                            <form action="" method="POST" class="formhapusmotifterpilih">
                                <input type="hidden" name="paddingTop"  class="var_padding-top"  value="<?php echo $_SESSION['paddingTop']; ?>">
                                <input type="hidden" name="paddingSide" class="var_padding-side" value="<?php echo $_SESSION['paddingSide']; ?>">
                                <input type="hidden" name="obj"         class="var_obj"          value="<?php echo $_SESSION['obj']; ?>">
                                <input type="hidden" name="obj2"        class="var_obj2"         value="<?php echo $_SESSION['obj2']; ?>">
                                <input type="hidden" name="obj3"        class="var_obj3"         value="<?php echo $_SESSION['obj3']; ?>">
                                <input type="hidden" name="gap"         class="var_gap"          value="<?php echo $_SESSION['gap']; ?>">
                                <input type="hidden" name="gapX"        class="var_gapX"         value="<?php echo $_SESSION['gapX']; ?>">
                                <input type="hidden" name="gapY"        class="var_gapY"         value="<?php echo $_SESSION['gapY']; ?>">
                            
                                <input type="hidden" name="colorBg" id="colorbg" class="var_colorBg" value="<?php echo $_SESSION['colorBg']; ?>">
                                <input type="hidden" name="color1"  id="varcolor1" class="var_color1" value="<?php echo $_SESSION['color1']; ?>">
                                <input type="hidden" name="color2"  class="var_color2" value="<?php echo $_SESSION['color2']; ?>">
                                <input type="hidden" name="color3"  class="var_color3" value="<?php echo $_SESSION['color3']; ?>">
                                <input type="hidden" name="colorchange"  class="color_change" value="<?php echo $_SESSION['colorchange']; ?>">
                            <!-- Hapus Motif Terpilih -->
                                    <label class="labelhapusmotifterpilih">
                                        <input class="inputhidden" type="submit" name="submit" value="1">
                                        <input class="inputhidden" type="hidden" name="motif_indeks" value="<?php echo $i ?>">
                                        <span style="font-size:75%;">(<?php echo $motifNama[$i] ?>)   
                                        </span> 
                                            <p style="font-size:85%; margin:0;" class="phapusmotifterpilih"><b>-HAPUS-</b></p> 
                                    </label>
                            </form>
                        </div>
                    </div>
                <?php endfor; ?>

                <div class="head-sidebar-column">
                    <?php if($_SESSION['maksSubmotif'] - $motifJml > 0){ ?>
                        <form action="" method="POST">
                            <input type="hidden" name="paddingTop"  class="var_padding-top"  value="<?php echo $_SESSION['paddingTop']; ?>">
                            <input type="hidden" name="paddingSide" class="var_padding-side" value="<?php echo $_SESSION['paddingSide']; ?>">
                            <input type="hidden" name="obj"         class="var_obj"          value="<?php echo $_SESSION['obj']; ?>">
                            <input type="hidden" name="obj2"        class="var_obj2"         value="<?php echo $_SESSION['obj2']; ?>">
                            <input type="hidden" name="obj3"        class="var_obj3"         value="<?php echo $_SESSION['obj3']; ?>">
                            <input type="hidden" name="gap"         class="var_gap"          value="<?php echo $_SESSION['gap']; ?>">
                            <input type="hidden" name="gapX"        class="var_gapX"         value="<?php echo $_SESSION['gapX']; ?>">
                            <input type="hidden" name="gapY"        class="var_gapY"         value="<?php echo $_SESSION['gapY']; ?>">

                            <input type="hidden" name="colorBg" id="colorbg" class="var_colorBg" value="<?php echo $_SESSION['colorBg']; ?>">
                            <input type="hidden" name="color1"  id="varcolor1" class="var_color1" value="<?php echo $_SESSION['color1']; ?>">
                            <input type="hidden" name="color2"  class="var_color2" value="<?php echo $_SESSION['color2']; ?>">
                            <input type="hidden" name="color3"  class="var_color3" value="<?php echo $_SESSION['color3']; ?>">
                            <input type="hidden" name="colorchange"  class="color_change" value="<?php echo $_SESSION['colorchange']; ?>">
                        <!-- Tambah Motif -->
                                <label style="padding-top:15px;">
                                    <input class="inputhidden" type="submit" name="submit" value="2">
                                    <input class="inputhidden" type="hidden" name="motif_indeks" value="<?php echo $i ?>">
                                        <img src="img/new-button-plus.svg" > 
                                </label>
                        </form>
                    <?php } ?>
                </div>
            </div>

            <!-- Tombol Penyimpanan -->
            <?php if($motifJml > 0 ){ ?>
            <form action="" method="POST">
                <input type="hidden" name="paddingTop"  class="var_padding-top"  value="<?php echo $_SESSION['paddingTop']; ?>">
                <input type="hidden" name="paddingSide" class="var_padding-side" value="<?php echo $_SESSION['paddingSide']; ?>">
                <input type="hidden" name="obj"         class="var_obj"          value="<?php echo $_SESSION['obj']; ?>">
                <input type="hidden" name="obj2"        class="var_obj2"         value="<?php echo $_SESSION['obj2']; ?>">
                <input type="hidden" name="obj3"        class="var_obj3"         value="<?php echo $_SESSION['obj3']; ?>">
                <input type="hidden" name="gap"         class="var_gap"          value="<?php echo $_SESSION['gap']; ?>">
                <input type="hidden" name="gapX"        class="var_gapX"         value="<?php echo $_SESSION['gapX']; ?>">
                <input type="hidden" name="gapY"        class="var_gapY"         value="<?php echo $_SESSION['gapY']; ?>">
                
                <input type="hidden" name="colorBg"  class="var_colorBg" value="<?php echo $_SESSION['colorBg']; ?>">
                <input type="hidden" name="color1"  class="var_color1" value="<?php echo $_SESSION['color1']; ?>">
                <input type="hidden" name="color2"  class="var_color2" value="<?php echo $_SESSION['color2']; ?>">
                <input type="hidden" name="color3"  class="var_color3" value="<?php echo $_SESSION['color3']; ?>">
                <input type="hidden" name="colorchange"  class="color_change" value="<?php echo $_SESSION['colorchange']; ?>">
                
                <button class="myButton" type="submit" name="submit" id="saveButton" value="3">Simpan Batik</button>
            </form>
            <?php } ?>

            <div style="padding: 10px;">
                <p>Berikut ini menggunakan ukuran dalam satuan centimeter</p>
            </div>
            
            <hr>
            
            <?php if($motifJml > 0){ ?>

            <div class="option-pw" style="display:inline-block; width: 20em; margin-top: 20px; margin-bottom: 30px;">
                <div id="psession" style=" display: inline;border: 1px #000 solid; cursor:pointer; padding: 10px;margin-left: -60px; border-radius: 10px;" onclick="positionTab()">Posisi</div>
                <div id="colorsession" style="display: inline;border: 1px #000 solid;padding: 10px;margin-left: 10px; border-radius: 10px; cursor:pointer" onclick="colorTab()">Warna</div>
            </div>

            <div id="position-tab">
                <!-- Pengaturan Batas Atas-Bawah Kanvas -->
                <p><span id="value-padding-top"><?php echo $_SESSION['paddingTop']; ?></span> cm | Batas Atas-Bawah Kanvas</p>
                <input id="padding-top" <?php echo $param_paddingTop ?> type="range" oninput="moveSlider(this,'padding-top')">
                            
                <!-- Pengaturan Batas Kanan-Kiri Kanvas -->
                <p><span id="value-padding-side"><?php echo $_SESSION['paddingSide']; ?></span> cm | Batas Kanan-Kiri Kanvas</p>
                <input id="padding-side" <?php echo $param_paddingSide ?> type="range" oninput="moveSlider(this,'padding-side')">
                            
                <!-- Pengaturan Ukuran Motif Utama -->
                <p><span id="value-obj"><?php echo $_SESSION['obj']; ?></span> cm | Ukuran Motif <b><?php echo $motifNama[0] ?></b></p>
                <input id="obj" <?php echo $param_obj ?> type="range" oninput="moveSlider(this,'obj')">
                
                <!-- Pengaturan Ukuran Motif Selanjutnya -->
                <?php for ($i=0; $i < $motifJml-1 ; $i++): ?>
                    <p><span id="value-obj<?php echo $i+2 ?>"><?php echo $_SESSION['obj'.($i+2)]; ?></span> cm | Ukuran Motif <b><?php echo $motifNama[$i+1] ?></b></p>
                    <input id="obj<?php echo $i+2 ?>" type="range" oninput="moveSlider(this,'obj<?php echo $i+2 ?>')" <?php echo $param_objn[$i] ?> >
                <?php endfor; ?>       
                
                <!-- Pengaturan Jarak Antar Motif -->
                <p><span id="value-gap"><?php echo $_SESSION['gap']; ?></span> cm | Jarak Motif Utama</p>
                <input id="gap"  type="range" oninput="moveSlider(this,'gap')" <?php echo $param_gap ?>  >
                
                <p><span id="value-gapX"><?php echo $_SESSION['gapX']; ?></span> cm | Jarak Horizontal Motif</p>
                <input id="gapX" type="range" oninput="moveSlider(this,'gapX')" <?php echo $param_gapX ?>  >
                
                <p><span id="value-gapY"><?php echo $_SESSION['gapY']; ?></span> cm | Jarak Vertikal Motif</p>
                <input id="gapY" type="range" oninput="moveSlider(this,'gapY')" <?php echo $param_gapY ?>  >
                <h5 style="header-bottom: 50px; padding-bottom: 25px"></h5>
            </div>

            <div class="colortab" id="color-tab">
                <div id="color-canvas">
                    <div id="color-canvas-txt" style="text-align:left; padding-left: 10px;">Warna Kain</div>
                    <select name="colorcanvas" id="color-canvas-opt" style="margin-left: -50px; margin-top: 10px;width: 120px;" onchange="changeCanvasColor(this.value)">
                        <option value="#fcfcfc" selected="selected">Putih</option>
                        <option value="#cc8621">Yellow IGK</option>
                        <option value="#7f732a">Yellow IRK</option>
                        <option value="#b23424">Orange HR</option>
                        <option value="#7a5844">Brown IRRD</option>
                        <option value="#2e4c66">Blue 04B</option>
                        <option value="#434f5b">Grey IRL</option>
                        <option value="#2e1836">Violet 14R</option>
                        <option value="#d3547b">Rose IR</option>
                        <option value="#143d30">Green IB</option>
                    </select>
                </div>

                <div id="color-motif1" style="margin-top: 20px;">
                    <div id="color-motif1-txt" style="text-align:left; padding-left: 10px;">Warna Motif 1</div>
                    <!-- <div style="background-color: black;width: 120px; color: white;">Hitam</div> -->
                    <select id="color-motif1-opt" style="margin-left: -50px; margin-top: 10px;width: 120px;" onchange="firstMotifColor(this.value)">
                        <option value="#cc8621">Yellow IGK</option>
                        <option value="#7f732a">Yellow IRK</option>
                        <option value="#b23424">Orange HR</option>
                        <option value="#7a5844">Brown IRRD</option>
                        <option value="#2e4c66">Blue 04B</option>
                        <option value="#434f5b">Grey IRL</option>
                        <option value="#2e1836">Violet 14R</option>
                        <option value="#d3547b">Rose IR</option>
                        <option value="#143d30">Green IB</option>
                    </select>

                </div>
                
                <div id="color-motif2" style="margin-top: 20px;">
                    <div id="color-motif2-txt" style="text-align:left; padding-left: 10px;">Warna Motif 2</div>
                    <!-- <div style="background-color: black;width: 120px; color: white;">Hitam</div> -->
                    <select id="color-motif2-opt" style="margin-left: -50px; margin-top: 10px;width: 120px;" onchange="secondMotifColor(this.value)">
                    <option value="#cc8621">Yellow IGK</option>
                        <option value="#7f732a">Yellow IRK</option>
                        <option value="#b23424">Orange HR</option>
                        <option value="#7a5844">Brown IRRD</option>
                        <option value="#2e4c66">Blue 04B</option>
                        <option value="#434f5b">Grey IRL</option>
                        <option value="#2e1836">Violet 14R</option>
                        <option value="#d3547b">Rose IR</option>
                        <option value="#143d30">Green IB</option>
                    </select>
                </div>
            
                <div id="color-motif3" style="margin-top: 20px;">
                    <div id="color-motif3-txt" style="text-align:left; padding-left: 10px;">Warna Motif 3</div>
                    <!-- <div style="background-color: black;width: 120px; color: white;">Hitam</div> -->
                    <select id="color-motif3-opt" style="margin-left: -50px; margin-top: 10px; margin-bottom: 30px; width: 120px;" onchange="thirdMotifColor(this.value)">
                        <option value="#cc8621">Yellow IGK</option>
                        <option value="#7f732a">Yellow IRK</option>
                        <option value="#b23424">Orange HR</option>
                        <option value="#7a5844">Brown IRRD</option>
                        <option value="#2e4c66">Blue 04B</option>
                        <option value="#434f5b">Grey IRL</option>
                        <option value="#2e1836">Violet 14R</option>
                        <option value="#d3547b">Rose IR</option>
                        <option value="#143d30">Green IB</option>
                    </select>
                </div>                
            </div>
           
            <?php } ?>
        </div>
        </div>


        <!-- Page content -->
        <div class="main">
            <?php if($motifJml <= 0){ ?>
            <div id="panduanpenggunaan">
                <h2 style="color:#333;">Panduan Penggunaan</h2>
                <ol>
                    <li>Pilihlah submotif yang anda inginkan</li>
                    <ul>
                        <li>Untuk memulai memilih silakan tekan gambar tambah motif di panel kiri.</li>
                        <li>Setiap submotif memiliki <b>kata kunci karakter</b> untuk membantu anda 
                            <br>menyesuaikan ide yang di miliki dengan makna dari submotif.</li>
                        <li>Perhatikan jumlah maksimal submotif yang dapat dipilih.</li>
                        <ul>
                            <li>Pola "berderet" maksimal <b>3</b> submotif</li>
                            <li>Pola "kotak" maksimal <b>2</b> submotif</li>
                            <li>Pola "spiral" maksimal <b>2</b> submotif</li>
                        </ul>
                    </ul>
                    <li>Atur parameter sesuai keinginan pada panel kiri</li>
                    <ul>
                        <li>Pengaturan parameter hanya bisa dilakukan setelah memilih submotif</li>
                    </ul>
                    <li>Simpan hasil desain anda apabila sudah puas dengan desain</li>
                    <ul>
                        <li>Tekan tombol <b>simpan batik</b> di panel kiri</li>
                        <li>Anda akan dialihkan ke halaman penyimpanan dan <br>
                            anda akan diminta memberi judul karya dan menuliskan nama anda</li>
                    </ul>
                </ol>
            </div>
            <?php }else{ ?>
                <div id="hasilBatik"></div>
            <?php } ?>
        </div>

        
    <script>
    
        var widthCanv, heightCanv, paddingTop, paddingSide, obj, obj2, obj3, gap, gapX, gapY,
            motifJml, motifTagHTML;

        // Variabel parameter
        widthCanv       = cmToPixel(<?php echo $_SESSION['widthCanv']; ?>);
        heightCanv      = cmToPixel(<?php echo $_SESSION['heightCanv']; ?>);
        paddingTop      = cmToPixel(<?php echo $_SESSION['paddingTop']; ?>);
        paddingSide     = cmToPixel(<?php echo $_SESSION['paddingSide']; ?>);
        obj             = cmToPixel(<?php echo $_SESSION['obj']; ?>);
        obj2            = cmToPixel(<?php echo $_SESSION['obj2']; ?>);
        obj3            = cmToPixel(<?php echo $_SESSION['obj3']; ?>);
        gap             = cmToPixel(<?php echo $_SESSION['gap']; ?>);
        gapX            = cmToPixel(<?php echo $_SESSION['gapX']; ?>);
        gapY            = cmToPixel(<?php echo $_SESSION['gapY']; ?>);
        
        // Variabel Motif
        motifJml        = <?php echo $motifJml ?>;
        motifTagHTML    = document.querySelectorAll("svg");

        // Variabel ukuran object asli
        var realObjSizex = [];
        var realObjSizey = [];
            
                // Variabel Warna
        
        // handling default warna apabila nilai warna di session berubah
        // terjadi pada saat scaling position jika motif ditambah
        
        // document.getElementById("hasilBatik").style.backgroundColor = ; 
        
        document.getElementById("color-motif1-opt").value = "<?php echo $_SESSION['color1'];  ?>";
        document.getElementById("color-motif2-opt").value = "<?php echo $_SESSION['color2'];  ?>";
        document.getElementById("color-motif3-opt").value = "<?php echo $_SESSION['color3'];  ?>";
        


        
        // handling nilai warna saat halaman berpindah

        clrBg = "<?php echo $_SESSION['colorBg'];  ?>"; 
        
        clr1 = "<?php echo $_SESSION['color1'];  ?>";
        clr2 = "<?php echo $_SESSION['color2'];  ?>";
        clr3 = "<?php echo $_SESSION['color3'];  ?>";
        var colorChange = "<?php echo $_SESSION['colorchange'];  ?>";
        var clrChange = colorChange.split(",");
        
        // console.log("hello");
        // let isSave = false; 
        var isSave = false;
        


        // Variabel Path
        var motifPath = [];

        function cmToPixel(value){
            return value*37.795276;
        }
        function pixelToCm(value){
            return value*0.02645833;
        }
    </script>

    <script type="text/javascript" src="javascript/<?php echo $algoritmaFile ?>"></script>
    <script type="text/javascript" src="javascript/basic.js"></script>    
    <script>

        
        
        var labelMotif = document.getElementsByClassName("labelmotifterpilih");

        for (let i = 0; i < labelMotif.length; i++){
            var getClass = labelMotif[i].children;
            var getSvgId = getClass[2].getAttribute("id");
            var svgTarget = document.getElementById(getSvgId);
            var theChild = svgTarget.childNodes;

            // console.log(theChild[5].getAttribute("id"));
            var getPathId = theChild[5].getAttribute("id");
            document.getElementById(getPathId).style.fill = "white";
        
        }

        // Opsi Warna

        var jmlmotif = "<?php echo $motifJml ?>";
        var jlhToInt = parseInt(jmlmotif);

        if (jlhToInt == 1){
            document.getElementById("color-motif1").style.display = "block";
            document.getElementById("color-motif2").style.display = "none";
            document.getElementById("color-motif3").style.display = "none";
        }

        else if (jlhToInt == 2){
            document.getElementById("color-motif1").style.display = "block";
            document.getElementById("color-motif2").style.display = "block";
            document.getElementById("color-motif3").style.display = "none";
        } 

        else if (jlhToInt == 3){
            document.getElementById("color-motif1").style.display = "block";
            document.getElementById("color-motif2").style.display = "block";
            document.getElementById("color-motif3").style.display = "block";
        } 



        // canvas ada?
        var isCanvasExist = document.getElementById("mycanv");
        if(isCanvasExist){
            isCanvasExist.style.fill = "<?php echo $_SESSION['colorBg']; ?>";
        } else{
            console.log("canvas not exist");
        }

        function colorTab(){
            document.getElementById("position-tab").style.display = "none";
            document.getElementById("psession").style.backgroundColor = "#282c33";
            document.getElementById("color-tab").style.display = "block";
            document.getElementById("colorsession").style.backgroundColor = "#1c1f24";
        }

        function positionTab(){
            document.getElementById("position-tab").style.display = "block";
            document.getElementById("psession").style.backgroundColor = "#1c1f24";
            document.getElementById("color-tab").style.display = "none";
            document.getElementById("colorsession").style.backgroundColor = "#282c33";
            
        }



        function changeCanvasColor(color){         
            // document.getElementById("hasilBatik").style.backgroundColor = color;
            document.getElementById("mycanv").style.fill = color;
            var bgColor = document.getElementsByClassName("var_colorBg");
            var bgColorLength = bgColor.length;
            for (let i = 0; i < bgColorLength; i++){
                bgColor[i].value = color;
            }
        }

        function firstMotifColor(color){
            var x = document.getElementById("svgBatik").childElementCount; 
            var firstColor = document.getElementsByClassName("var_color1");
            var firstColorLength = firstColor.length;
            for (let i = 0; i < firstColorLength; i++){
                firstColor[i].value = color;
            }

            for ( var i = 0; i < x-1; i++){
                var iString = "mtf" + i.toString();
                var getById = document.getElementById(iString);

                if (getById.className.baseVal == "first-motif"){
                    getById.style.fill = color;
                }
            }

        }

        function secondMotifColor(color){
            var x = document.getElementById("svgBatik").childElementCount; 
            var secondColor = document.getElementsByClassName("var_color2");
            var secondColorLength = secondColor.length;

            for (let i = 0; i < secondColorLength; i++){
                secondColor[i].value = color;
            }

            // document.getElementById("warna-dua").value = color;
            for ( var i = 0; i < x-1; i++){
                var iString = "mtf" + i.toString();
                var getById = document.getElementById(iString);
                if (getById.className.baseVal == "second-motif"){
                    getById.style.fill = color;
                }   
            }
            
            // handling perubahan warna
            clrChange[0] = "1";
            var ccClass = document.getElementsByClassName("color_change");
            for(var c = 0; c < ccClass.length ; c++){
                ccClass[c].setAttribute("value", clrChange);

            }
           

        }

        function thirdMotifColor(color){
            var x = document.getElementById("svgBatik").childElementCount; 
            var thirdColor = document.getElementsByClassName("var_color3");
            var thirdColorLength = thirdColor.length;

            for (let i = 0; i < thirdColorLength; i++){
                thirdColor[i].value = color;
            }

            for ( var i = 0; i < x-1; i++){
                var iString = "mtf" + i.toString();
                var getById = document.getElementById(iString);
                if (getById.className.baseVal == "third-motif"){
                    getById.style.fill = color;
                }
            
            }

            // handling perubahan warna
            clrChange[1] = "1";
            var ccClass = document.getElementsByClassName("color_change");
            for(var c = 0; c < ccClass.length ; c++){
                ccClass[c].setAttribute("value", clrChange);
                // console.log(ccClass[z]);
            }

        }
        

    </script>


</body>
</html>