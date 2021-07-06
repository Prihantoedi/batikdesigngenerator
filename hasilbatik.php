<?php 

    session_start();

    require '_functions.php';

    $idCustomer = $_GET['id'];

    if ($_SESSION['jenis_customer'] == "baru") {

        $conn = mysqli_connect("localhost", "root", "", "database_batik_galih");
        $query = "SELECT COUNT(*) as total FROM tbl_hasilbatik WHERE id_customer = $idCustomer";
        $sql = mysqli_query($conn, $query) or die(mysqli_error($conn));
        $data = mysqli_fetch_assoc($sql);
        $total = $data['total'];

        if ($total >= 10) {
            $query = "UPDATE customers SET jenis = 'lama' WHERE id = $idCustomer";
            $sql = mysqli_query($conn, $query) or die(mysqli_error($conn));
            echo '<script language="javascript">';
            echo 'alert("Selamat! Anda menjadi member lama dan mendapat potongan harga!")';
            echo '</script>';
            $_SESSION['jenis_customer'] = "lama";
        }

    }

 
    
    // Query ke tabel
    $hasilbatikTbl = query("SELECT tbl_hasilbatik.hasilbatik_id, hasilbatik_file, hasilbatik_filehp, hasilbatik_tanggal,
                            hasilbatik_kreator, hasilbatik_namakarya, jumlahPembelian, teknik_pewarnaan, warna1, warna2, warna3, warnaBg, durasi, harga, status, status_bayar,
                            delivery_time,
                            tbl_algoritma.algoritma_nama 
                            FROM tbl_hasilbatik
                            INNER JOIN tbl_algoritma ON tbl_hasilbatik.algoritma_id = tbl_algoritma.algoritma_id
                            WHERE id_customer = $idCustomer
                            ORDER BY hasilbatik_tanggal DESC
                            LIMIT 10
                            ");

    foreach($hasilbatikTbl as $tbl){
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

    // // var_dump(cariKarakterMotif(1));
    // var_dump($motifId);

    $hasilbatikJml = count($hasilbatikTbl);
    
    if ($hasilbatikJml != 0) {
        foreach($motifId as $mtfId){
            // var_dump($mtfId);
            $karakterS[]   = cariKarakterMotifBanyak($mtfId);
        }
    }

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hasil Batik</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/hasilbatik.css">
</head>
<body>

    <div id="header">
        <h1>Hasil Batik</h1>
        <a href="index.php">Kembali ke halaman utama</a>
    </div>
        <?php 
        if (isset($_SESSION['hasilbatik'])){
        ?> 
                <!-- Button trigger modal info -->
            <button type="button" class="btn btn-primary" id="btn-trigger" data-bs-toggle="modal" data-bs-target="#modalInfo" hidden="hidden">
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

                    Harga Teknik = <?php  echo "Rp. " . number_format($_SESSION['hargaTeknik'],2,",",".");?> 
                    <br>
                    Harga Durasi = <?php echo "Rp. " . number_format($_SESSION['hargaDurasi'],2,",",".");?>
                    <br>
                    Harga Luas = <?php echo "Rp. " . number_format($_SESSION['hargaLuas'],2,",",".");?>
                    <br>
                    Durasi = <?php echo $_SESSION['durasi'];?> 
                    <br>
                    Total Harga = <?php echo "Rp. " . number_format($_SESSION['totalHarga'],2,",",".");?>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
            </div>
        <?php }?>


    
    <table class="table table-hover" border="1" cellpadding="20" cellspacing="0">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col" colspan = "2" style="text-align:center;">Keterangan</th>
                <th scope="col" style="text-align:center;">Gambar</th>
            </tr>
        </thead>
        <tbody>
    <?php if ($hasilbatikJml != 0) { ?>
    <?php for($i = 0; $i < $hasilbatikJml; $i++){ ?>
        <tr style="padding: 10px;">
            <td class="nomor-urut" rowspan="16"><?php echo $i+1 ?></td>
            <td>Nama File</td>
            <td><?php echo $file_names[$i] ?></td>
            <td style="text-align:center;" rowspan="16">
            <h4>Model Warna</h4>
                <object data="hasilbatik/<?php echo $file_names[$i] ?>" type="image/svg+xml">Hasil</object>
                <br>
                <a href="hasilbatik/<?php echo $file_names[$i] ?>" download>Unduh Batik</a> <b> / </b>
                <a href=".desainhasil.php?hasilbatik_id=<?php echo $hasilbatikId[$i] ?>">Edit Batik</a>
                <div style="margin-top: 30px;"></div>
                <h4>Model Hitam Putih</h4>
                <object data="hasilbatik/<?php echo $file_names_hp[$i] ?>" type="image/svg+xml">Hasil</object>
                <br>
                <a href="hasilbatik/<?php echo $file_names_hp[$i] ?>" download>Unduh Batik</a>
            </td>
        </tr>
        <tr>
            <td>Judul Karya</td>
            <td><?php echo $namakaryas[$i] ?></td>
        </tr>
        <tr>
            <td>Kreator</td>
            <td><?php echo $kreators[$i] ?></td>
        </tr>
        <tr>
            <td>Tanggal dibuat</td>
            <td><?php echo $tanggals[$i] ?></td>
        </tr>
        <tr>
            <td>Pola</td>
            <td><?php echo $algoritmas[$i] ?></td>
        </tr>
        <tr>
            <td>Karakter</td>
            <td class="cetakkarakter">
                <?php echo karakterCetak($karakterS[$i]) ?>
            </td>
        </tr>
        <tr>
            <td>Jumlah Pembelian</td>
            <td>
                <?php echo $jumlah[$i] ?>
            </td>
        </tr>
        <tr>
            <td>Teknik Pewarnaan</td>
            <td>
                <?php echo $teknik[$i] ?>
            </td>
        </tr>
        <tr>
            <td>Warna Motif 1</td>
            <td>
                <?php
                    if ($warna1[$i] == "") {
                        echo " - ";
                    } else {
                        echo $warna1[$i];
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td>Warna Motif 2</td>
            <td>
                <?php
                    if ($warna2[$i] == "") {
                        echo " - ";
                    } else {
                        echo $warna2[$i];
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td>Warna Motif 3</td>
            <td>
                <?php
                    if ($warna3[$i] == "") {
                        echo " - ";
                    } else {
                        echo $warna3[$i];
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td>Warna Background</td>
            <td>
                <?php
                    if ($warnaBg[$i] == "") {
                        echo " - ";
                    } else {
                        echo $warnaBg[$i];
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td>Processing Time (PT) + Delivery Time (DT)</td>
            <td>
                
                <?php echo $durasi[$i]. " hari PT + " . $deliveryTime[$i] . " hari DT" ?>
            </td>
        </tr>
        <tr>
            <td>Harga</td>
            <td>
                <?php echo "Rp. " . number_format($harga[$i],2,",",".");?>
            </td>
        </tr>
        <tr>
            <td>Status Process</td>
            <td>
                <?php echo $status[$i];?>
            </td>
        </tr>
        <tr style="padding: 20px;">
            <td>Status Bayar</td>
            <td>
                <?php 
                    if ($statusBayar[$i] == "belum") {
                        echo "<a class='button button1' href='processbayar.php?id=" . $hasilbatikId[$i] . "'>Bayar</a>";
                    }
                    else{
                        echo $statusBayar[$i];
                    }
                ?>
            </td>
        </tr>
    <?php } ?>
    <?php }
        else{
            echo '<td colspan="4" style="text-align: center">DATA KOSONG!!!</td>';
        }
    ?>
    </tbody>
    </table>

<script>
    
    var btn = document.getElementById("btn-trigger");
    btn.click();

</script>

</body>
</html>

<style>
.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 16px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  transition-duration: 0.4s;
  cursor: pointer;
}

.button1 {
  background-color: #4CAF50;
  color: white; 
  border: 2px solid #4CAF50;
}

.button1:hover {
  background-color: white; 
  color: black;
}
</style>