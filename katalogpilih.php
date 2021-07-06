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

    if ( isset($_GET['submitmotif'])){
        $_SESSION['motif_id'][$_GET['motif_indeks']] = $_GET['motif_id'];
        unset($_SESSION['motif_indeks']);

        header('location:desain.php');
        exit;
    }
    
    // if (!empty($motifTbl)) {
        // Assign hasil query
        foreach($motifTbl as $mtf){
            $motifFile[]       = $mtf['motif_file'];
            $motifId[]         = $mtf['motif_id'];
            $motifKarakter[]   = karakterCetak(cariKarakterMotif($mtf['motif_id']));
        }  

        // Variabel pendukung KHUSUS HALAMAN INI
        $motifJml          = count($motifTbl);        //Jumlah Motif 
        $motifCounter       = 0;                       //Counter buat nampilin gambar
        $motifCounterRow    = ceil($motifJml/3);       //Jumlah Row
    // }

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Katalog Motif</title>
    <link rel="stylesheet" href="css/katalogpilih.css">
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
        <a href="desain.php">Kembali ke halaman desain</a>
    </div>

    <div class="motif-container">
    <?php for($i = 0; $i < $motifCounterRow; $i++){ ?>
        <div class="motif-row">
        <?php for ($j=0; $j < 3; $j++){ if($motifCounter >= $motifJml){continue;} ?>
            <div class="column">
                <div class="motif-gambar">
                            <a href="katalogpilih.php?motif_id=<?php echo $motifId[$motifCounter];?>&motif_indeks=<?php echo $_SESSION['motif_indeks']; ?>&submitmotif=">
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