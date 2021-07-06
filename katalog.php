<?php 
    // Functions
    require '_functions.php';
    session_start();
    
    if ( !isset( $_POST["cari"] ) )  {
        // Tanpa search keyword
        $motifTbl = query("SELECT * FROM tbl_motif");
    }else{
        // Dengan search keyword
        $motifTbl = cariMotif($_POST["keyword"]);
    } 

    if (!empty($motifTbl)) {
        // Assign hasil query
        foreach($motifTbl as $mtf){
            $motifFile[]       = $mtf['motif_file'];
            $motifId[]         = $mtf['motif_id'];
            $motifKarakter[]   = karakterCetak(cariKarakterMotif($mtf['motif_id']));
        }  

        // Variabel pendukung KHUSUS HALAMAN INI
        $motifJml          = count($motifId);        //Jumlah Motif 
        $motifCounter       = 0;                       //Counter buat nampilin gambar
        $motifCounterRow    = ceil($motifJml/3);       //Jumlah Row
    }

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Katalog Motif</title>
    <link rel="stylesheet" href="css/katalog.css">
</head>
<body>
    <h1 id="header-choose-img">Pilihan Motif</h1>

    <div id="search">
        <form action="" method="POST">
            <input type="text" name="keyword" size="40" placeholder="masukkan keyword karakter pencarian!!" autofocus autocomplete="off">
            <button type="submit" name="cari">Cari!!</button>
        </form>
        <br>
        <?php if (empty($motifTbl)) {
            echo "Data Tidak Ada!!!";
            echo "<br>";
            echo "<br>";
        } ?>
        <a href="index.php">Kembali ke halaman utama</a>
    </div>

    <div class="motif-container">
    <?php if (!empty($motifTbl)) { ?>
    
        <?php for($i = 0; $i < $motifCounterRow; $i++){ ?>
            <div class="motif-row">
            <?php for ($j=0; $j < 3; $j++){ if($motifCounter >= $motifJml){continue;} ?>
                <div class="column">
                    <div class="motif-gambar">
                                <a href="#">
                                    <img class="gambarmotif" width="255" src="img/<?php echo $motifFile[$motifCounter] ?>" 
                                        alt="" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)">
                                </a>   

                            <p><?php echo ($motifCounter+1)." | ".$motifTbl[$motifCounter]['motif_nama'] ?></p>

                            <table>
                                <tr>
                                    <td class="karakter">Karakter</td>
                                    <td><?php echo $motifKarakter[$motifCounter] ?></td>
                                </tr>
                            </table>
                            <?php $motifCounter++ ;?>               
                    </div>
                </div>
            <?php } ?>
            </div>
        <?php } ?>
    <?php } ?>
    </div>


    <script>
        function mouseOver(target) {
            target.style.border = "thick solid lightgrey";
            target.style.backgroundColor = "#fafafa";
        }
        function mouseOut(target) {
            target.style.border = "";
            target.style.backgroundColor = "";
        }
    </script>
</body>
</html>