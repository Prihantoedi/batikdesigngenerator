<?php 

    session_start();

    require ('controller/view_controller.php');

    $viewController = new ViewController();
    $result_order_data =  $viewController->hasilBatikController($_GET['id'], $_SESSION['jenis_customer']);
    
    $_SESSION['jenis_customer'] = $result_order_data['customer_type'];

    $order_data = $result_order_data['order_data'];
    $hasilbatikJml = $result_order_data['hasil_batik_jum'];

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
                        Harga Kain = <?php echo "Rp. " . number_format($_SESSION['hargaKain'],2,",",".");?>
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
            <?php } unset($_SESSION["hasilbatik"]);?>


        
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
                <td><?php echo $order_data['file_name'][$i] ?></td>
                <td style="text-align:center;" rowspan="16">
                <h4>Model Warna</h4>
                    <object data="hasilbatik/<?php echo $order_data['file_name'][$i] ?>" type="image/svg+xml">Hasil</object>
                    <br>
                    <a href="hasilbatik/<?php echo $order_data['file_name'][$i] ?>" download>Unduh Batik</a> <b> / </b>
                    <a href=".desainhasil.php?hasilbatik_id=<?php echo $order_data['hasilbatik_id'][$i] ?>">Edit Batik</a>
                    <div style="margin-top: 30px;"></div>
                    <h4>Model Hitam Putih</h4>
                    <object data="hasilbatik/<?php echo $order_data['file_name_hp'][$i] ?>" type="image/svg+xml">Hasil</object>
                    <br>
                    <a href="hasilbatik/<?php echo $order_data['file_name_hp'][$i] ?>" download>Unduh Batik</a>
                </td>
            </tr>
            <tr>
                <td>Judul Karya</td>
                <td><?php echo $order_data['nama_karya'][$i] ?></td>
            </tr>
            <tr>
                <td>Kreator</td>
                <td><?php echo $order_data['kreator'][$i] ?></td>
            </tr>
            <tr>
                <td>Tanggal dibuat</td>
                <td><?php echo $order_data['tanggal'][$i] ?></td>
            </tr>
            <tr>
                <td>Pola</td>
                <td><?php echo $order_data['algoritma'][$i] ?></td>
            </tr>
            <tr>
                <td>Karakter</td>
                <td class="cetakkarakter">
                    <?php echo karakterCetak($order_data['karakter'][$i]) ?>
                </td>
            </tr>
            <tr>
                <td>Jumlah Pembelian</td>
                <td>
                    <?php echo $order_data['jumlah'][$i] ?>
                </td>
            </tr>
            <tr>
                <td>Teknik Pewarnaan</td>
                <td>
                    <?php echo $order_data['teknik'][$i] ?>
                </td>
            </tr>
            <tr>
                <td>Warna Motif 1</td>
                <td>
                    <?php
                        if ($order_data['warna_1'][$i] == "") {
                            echo " - ";
                        } else {
                            echo $order_data['warna_1'][$i];
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Warna Motif 2</td>
                <td>
                    <?php
                        if ($order_data['warna_2'][$i] == "") {
                            echo " - ";
                        } else {
                            echo $order_data['warna_2'][$i];
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Warna Motif 3</td>
                <td>
                    <?php
                        if ($order_data['warna_3'][$i] == "") {
                            echo " - ";
                        } else {
                            echo $order_data['warna_3'][$i];
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Warna Background</td>
                <td>
                    <?php
                        if ($order_data['warna_bg'][$i] == "") {
                            echo " - ";
                        } else {
                            echo $order_data['warna_bg'][$i];
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Processing Time (PT) + Delivery Time (DT)</td>
                <td>
                    <?php 
                        echo ($order_data['status'][$i] == "dalam proses") ? $order_data['durasi'][$i]. " hari PT + " . $order_data['delivery_time'][$i] . " hari DT" : "menunggu order selanjutnya";
                    ?>

                </td>
            </tr>
            <tr>
                <td>Harga</td>
                <td>
                    <?php echo "Rp. " . number_format($order_data['harga'][$i],2,",",".");?>
                </td>
            </tr>
            <tr>
                <td>Status Process</td>
                <td>
                    <?php echo $order_data['status'][$i];?>
                </td>
            </tr>
            <tr style="padding: 20px;">
                <td>Status Bayar</td>
                <td>
                    <?php 
                        if ($order_data['status_bayar'][$i] == "belum") {
                            echo "<a class='button button1' href='processbayar.php?id=" . $order_data['hasilbatik_id'][$i] . "'>Bayar</a>";
                        }
                        else{
                            echo $order_data['status_bayar'][$i];
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
