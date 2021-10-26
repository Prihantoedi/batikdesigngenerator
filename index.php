<?php 
    session_start();
    require('_functions.php');
    require('database/db_management/querycenter.php');

    if(!isset($_SESSION['username_customer'])){
        // echo "<script>window.location = 'login.php'</script>";
        header("Location: ". "http://localhost/batikdesigngenerator/login.php");
    }
    $cust_id = $_SESSION['id_customer'];
    $queryComment = "SELECT status FROM tbl_hasilbatik WHERE id_customer = '$cust_id' ORDER BY hasilbatik_id DESC LIMIT 1 ";
    $query = new UserCommand();
    $get_status_data = $query->selectQuery($queryComment); 
    $status_data = $get_status_data['status'];
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Batik Web App</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&family=Varela+Round&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="main">
        <h1>SELAMAT DATANG!</h1>
        <h2><?php echo "Bapa/Ibu " . $_SESSION['nama_customer'] ?></h2>
        <p>Untuk memulai desain silakan tentukan ukuran kanvas dan pilih jenis pola yang tersedia</p>
        <form action=".desainstart.php" method="GET" >
            <table cellpadding="5" >
                <tr>
                    <td><label class="label-algoritma" for="input-algoritma">Ukuran Kanvas</label></td>
                    <td>:</td>
                    <td>
                        <select name="algoritma" id="input-algoritma" style="width:200px;"" value="" onchange="gantiUkuran(this)">
                            <option value="default">Default (200cm x 115cm)</option>
                            <option value="jarik">Kain Jarik (250cm x 100cm)</option>
                            <option value="sarung">Kain Sarung (180cm x 100cm)</option>
                            <option value="dodot">Kain Dodot (400cm x 200cm)</option>
                            <option value="selendang">Kain Selendang (140cm x 45cm)</option>
                            <option value="kembem">Kain Kembem (250cm x 50cm)</option>
                            <option value="costum">Costum</option>                            
                        </select>
                    </td>
                </tr>
                <tr id="inputpanjang" style="display:none;">
                    <td><label class="label-ukuran-kanvas" for="widthCanv" style="padding:15px">- panjang</label></td><td>:</td>
                    <td><input type="number" min="0" max="1000" style="width:75px; text-align:right;" name="widthCanv" id="widthCanv" value="200" autocomplete="off" required> cm</td>
                    
                </tr>
                <tr id="inputlebar" style="display:none;">
                    <td><label class="label-ukuran-kanvas" for="heightCanv" style="padding:15px">- lebar</label></td><td>:</td>
                    <td><input type="number" min="0" max="1000" style="width:75px; text-align:right;" name="heightCanv" id="heightCanv" value="115" autocomplete="off" required> cm</td>
                    
                </tr>
                <tr>
                    <td><label class="label-algoritma" for="member">Jenis Member</label></td>
                    <td>:</td>
                    <td>
                        <input type="text" style="width:75px; border: none;" name="member" id="member" value="<?php echo $_SESSION['jenis_customer'] ?>" readonly required>
                        <!-- <select name="member" id="member" style="width:200px;" required>
                            <option value="">Pilih Jenis Member</option>
                            <option value="member">Member</option>
                            <option value="new">New Customer</option>                  
                        </select> -->
                    </td>
                </tr>
                <tr>
                    <td><label class="label-algoritma" for="input-algoritma">Pola</label></td>
                    <td>:</td>
                    <td><select name="algoritma" id="input-algoritma" style="width:80px;"" value="" onchange="gantiIlustrasi(this)">
                            <option value="berderet">berderet</option>
                            <option value="kotak">kotak</option>
                            <option value="spiral">spiral</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="center">
                        [ <span id="jmlsubmotif">3</span> ] Pilihan Submotif Maksimal
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="center">
                        <button class="myButton" id="start-desain" type="submit" name="submit" value="1" style="width:150px;">Mulai desain</button>
                    </td>
                </tr>
            </table>
            <img id="ilustrasimotif" style="height:240px; margin-top:10px;margin-side: auto;" src="img/_Ilustrasi Berderet.png"></img>
            <br>
            <div id="order-status">Status pesanan : <?php echo  $status_data; ?></div>
            <div id="logoutBtn"><a href="processlogout.php">Log out</a></div> 
            
            
        </form>

        <p id="halamanlain"><a href="hasilbatik.php?id=<?php echo $_SESSION['id_customer'] ?>">Hasil desain</a> ||| <a href="katalog.php">Katalog Motif</a>
        </p>
    </div>

    <style>
    </style>
    <script>

        // change status background
        var checkProcessStatus = document.getElementById("order-status");
        console.log(checkProcessStatus.innerHTML);
        if(checkProcessStatus.innerHTML == "Status pesanan : daftar tunggu"){
            checkProcessStatus.style.background =  "#f79423";
        }

        function gantiUkuran(target){
            var kain = target.value;
            document.getElementById('inputpanjang').style   = "display:none;";
            document.getElementById('inputlebar').style     = "display:none;";
            switch (kain) {
                case "default":
                    panjang = 200;
                    lebar   = 115;
                    break;
                case "jarik":
                    panjang = 250;
                    lebar   = 100;
                    break;
                case "sarung":
                    panjang = 180;
                    lebar   = 100;
                    break;
                case "dodot":
                    panjang = 400;
                    lebar   = 200;
                    break;
                case "selendang":
                    panjang = 140;
                    lebar   = 45;
                    break;
                case "kembem":
                    panjang = 250;
                    lebar   = 50;
                    break;
                case "costum":
                    document.getElementById('inputpanjang').style  = "";
                    document.getElementById('inputlebar').style = "";
                    panjang = "";
                    lebar   = "";
                    break;
                default	: file = '_Ilustrasi Berderet';
            }
            document.getElementById('widthCanv').value  = panjang;
            document.getElementById('heightCanv').value = lebar;
        }


        function gantiIlustrasi(target){
            var ilustrasi = target.value;
            switch (ilustrasi) {
                case "berderet":
                    file = '_Ilustrasi Berderet';
                    jmlsubmotif = 3;
                    break;
                case "kotak":
                    file = '_Ilustrasi Kotak';
                    jmlsubmotif = 2;
                    break;
                case "spiral":
                    file = '_Ilustrasi Spiral';
                    jmlsubmotif = 2;
                    break;
                default	: file = '_Ilustrasi Berderet';
            }
            document.getElementById('ilustrasimotif').setAttribute("src", "img/"+file +".png");
            document.getElementById('jmlsubmotif').innerHTML = jmlsubmotif;
        }
    </script>
</body>
</html>