<?php 
    session_start();
    
    // Functions
    require '_functions.php';

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
        header('location:.saving.php');
        exit;
    }

    $motifJml = count($_SESSION['motif_id']);
    $warnaBg = $_SESSION['colorBg'];
    $warna1 = $_SESSION['color1'];

    if($motifJml == 1 ){
        // $warna2 = $_SESSION['color2'];
        $warna2 = null;
        $warna3 = null;
    } elseif($motifJml == 2){
        $warna2 = $_SESSION['color2'];
        $warna3 = null;
    } else{
        $warna2 = $_SESSION['color2'];
        $warna3 = $_SESSION['color3'];
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bikin Batik</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet"> 
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
        <button type="submit" name="submitsimpan" id="saveButton" onclick="return confirm('Apakah data yg anda inputkan sudah sesuai?')">Simpan Batik</button>
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
    </form>

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
        

        var allMotifClass = ["first-motif", "second-motif", "third-motif"];
        var collectKeliling = [];
        var numOfMotif = [];


        // var getWidth = document.getElementsByClassName("first-motif")[0];
        // // var getPath = getWidth.getElementsByTagName("path")[0].getTotalLength();
        // var getPath = getWidth.getElementsByTagName("path")[0];
        // var width = getWidth.getBBox().width;
        // console.log(width);
        // // var perimeter = getPath * width;
        // // console.log(perimeter);
        // var getRealWidth = getPath.getBoundingClientRect().width / getPath.getBBox().width;

        // var perimeter = getPath.getTotalLength() * getRealWidth;
        // console.log(perimeter * 0.02645833);

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
        
        console.log(collectKeliling);

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