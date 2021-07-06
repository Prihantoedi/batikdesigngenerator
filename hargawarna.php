<?php

    session_start();

    if(!isset($_SESSION['username_customer'])){
        echo "<script>window.location = 'login.php'</script>";
    }

    if (isset($_SESSION['harga_yellowigk'])) {
        unset($_SESSION['harga_yellowigk']);
    }

    if (isset($_SESSION['harga_yellowirk'])) {
        unset($_SESSION['harga_yellowirk']);
    }

    if (isset($_SESSION['harga_orangehr'])) {
        unset($_SESSION['harga_orangehr']);
    }

    if (isset($_SESSION['harga_brownirrd'])) {
        unset($_SESSION['harga_brownirrd']);
    }

    if (isset($_SESSION['harga_blue04b'])) {
        unset($_SESSION['harga_blue04b']);
    }

    if (isset($_SESSION['harga_greyirl'])) {
        unset($_SESSION['harga_greyirl']);
    }

    if (isset($_SESSION['harga_violet14r'])) {
        unset($_SESSION['harga_violet14r']);
    }

    if (isset($_SESSION['harga_roseir'])) {
        unset($_SESSION['harga_roseir']);
    }

    if (isset($_SESSION['harga_greenib'])) {
        unset($_SESSION['harga_greenib']);
    }

    if (isset($_SESSION['harga_putih'])) {
        unset($_SESSION['harga_putih']);
    }

    $conn = mysqli_connect("localhost", "root", "", "database_batik_galih");
    
    // Yellow IGK
    $sql = mysqli_query($conn, "SELECT * FROM harga_warna WHERE id = 1") or die(mysqli_error($conn));
    $hargaYellowIGK = mysqli_fetch_assoc($sql);
    $_SESSION['harga_yellowigk'] = $hargaYellowIGK['harga'];

    // Yellow IRK
    $sql = mysqli_query($conn, "SELECT * FROM harga_warna WHERE id = 2") or die(mysqli_error($conn));
    $hargaYellowIRK = mysqli_fetch_assoc($sql);
    $_SESSION['harga_yellowirk'] = $hargaYellowIRK['harga'];

    // ORange HR
    $sql = mysqli_query($conn, "SELECT * FROM harga_warna WHERE id = 3") or die(mysqli_error($conn));
    $hargaOrangeHR = mysqli_fetch_assoc($sql);
    $_SESSION['harga_orangehr'] = $hargaOrangeHR['harga'];

    //Brown IRRD
    $sql = mysqli_query($conn, "SELECT * FROM harga_warna WHERE id = 4") or die(mysqli_error($conn));
    $hargaBrownIRRD = mysqli_fetch_assoc($sql);
    $_SESSION['harga_brownirrd'] = $hargaBrownIRRD['harga'];

    // Blue 04B
    $sql = mysqli_query($conn, "SELECT * FROM harga_warna WHERE id = 5") or die(mysqli_error($conn));
    $hargaBlue048 = mysqli_fetch_assoc($sql);
    $_SESSION['harga_blue048'] = $hargaBlue048['harga'];

    // Grey IRL
    $sql = mysqli_query($conn, "SELECT * FROM harga_warna WHERE id = 6") or die(mysqli_error($conn));
    $hargaGreyIRL = mysqli_fetch_assoc($sql);
    $_SESSION['harga_greyirl'] = $hargaGreyIRL['harga'];

    // Violet 14R
    $sql = mysqli_query($conn, "SELECT * FROM harga_warna WHERE id = 7") or die(mysqli_error($conn));
    $hargaViolet14R = mysqli_fetch_assoc($sql);
    $_SESSION['harga_violet14r'] = $hargaViolet14R['harga'];

    // Rose IR
    $sql = mysqli_query($conn, "SELECT * FROM harga_warna WHERE id = 8") or die(mysqli_error($conn));
    $hargaRoseIR = mysqli_fetch_assoc($sql);
    $_SESSION['harga_roseir'] = $hargaRoseIR['harga'];

    // Green IB
    $sql = mysqli_query($conn, "SELECT * FROM harga_warna WHERE id = 9") or die(mysqli_error($conn));
    $hargaGreenIB = mysqli_fetch_assoc($sql);
    $_SESSION['harga_greenib'] = $hargaGreenIB['harga'];

     // Putih
    $sql = mysqli_query($conn, "SELECT * FROM harga_warna WHERE id = 10") or die(mysqli_error($conn));
    $hargaPutih = mysqli_fetch_assoc($sql);
    $_SESSION['harga_putih'] = $hargaPutih['harga'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Harga Mesin - Batik Web App</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admindex.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="admindex.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Kelola Data
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseHarga"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-dollar-sign"></i>
                    <span>Data Harga</span>
                </a>
                <div id="collapseHarga" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="hargamesin.php">Harga Mesin</a>
                        <a class="collapse-item active" href="hargawarna.php">Harga Warna</a>
                        <a class="collapse-item" href="hargateknik.php">Harga Teknik</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <!-- <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> -->

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['nama_customer']?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile_2.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-5 text-gray-800">Kelola Harga Warna</h1>

                    <div class="row" style="margin-top: 30px;">
                        <div class="col-3">
                            <!-- Ungu -->
                            <h2 class="h5">Harga Warna <span class="h5" style="color: #cc8621;">Yellow IGK</span></h2>

                            <form method="post" action="processhargawarna.php?id=1">
                                <div class="form-group w-100">
                                    <label for="exampleInputEmail1">Harga Lama</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $_SESSION['harga_yellowigk']?>" readonly>
                                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                </div>
                                <div class="form-group w-100">
                                    <label for="exampleInputPassword1">Harga Baru</label>
                                    <input type="number" class="form-control" id="exampleInputPassword1" min="1" name="hargaBaru" placeholder="Masukkan Harga Baru" required>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                        <div class="col-3">
                            <!-- Merah -->
                            <h2 class="h5">Harga Warna <span class="h5" style="color: #7f732a;">Yellow IRK</span></h2>

                            <form method="post" action="processhargawarna.php?id=2">
                                <div class="form-group w-100">
                                    <label for="exampleInputEmail1">Harga Lama</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $_SESSION['harga_yellowirk']?>" readonly>
                                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                </div>
                                <div class="form-group w-100">
                                    <label for="exampleInputPassword1">Harga Baru</label>
                                    <input type="number" class="form-control" id="exampleInputPassword1" min="1" name="hargaBaru" placeholder="Masukkan Harga Baru" required>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                        <div class="col-3">
                            <!-- Hijau -->
                            <h2 class="h5">Harga Warna <span class="h5" style="color: #b23424;">Orange HR</span></h2>

                            <form method="post" action="processhargawarna.php?id=3">
                                <div class="form-group w-100">
                                    <label for="exampleInputEmail1">Harga Lama</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $_SESSION['harga_orangehr']?>" readonly>
                                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                </div>
                                <div class="form-group w-100">
                                    <label for="exampleInputPassword1">Harga Baru</label>
                                    <input type="number" class="form-control" id="exampleInputPassword1" min="1" name="hargaBaru" placeholder="Masukkan Harga Baru" required>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                        <div class="col-3">
                            <!-- Kuning -->
                            <h2 class="h5">Harga Warna <span class="h5" style="color: #7a5844;">Brown IRRD</span></h2>

                            <form method="post" action="processhargawarna.php?id=4">
                                <div class="form-group w-100">
                                    <label for="exampleInputEmail1">Harga Lama</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $_SESSION['harga_brownirrd']?>" readonly>
                                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                </div>
                                <div class="form-group w-100">
                                    <label for="exampleInputPassword1">Harga Baru</label>
                                    <input type="number" class="form-control" id="exampleInputPassword1" min="1" name="hargaBaru" placeholder="Masukkan Harga Baru" required>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>


                    <div class="row" style="margin-top: 30px;">
                        <div class="col-3">
                            <!-- coklat -->
                            <h2 class="h5">Harga Warna <span class="h5" style="color: #2e4c66;">Blue 04B</span></h2>

                            <form method="post" action="processhargawarna.php?id=5">
                                <div class="form-group w-100">
                                    <label for="exampleInputEmail1">Harga Lama</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $_SESSION['harga_blue04b']?>" readonly>
                                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                </div>
                                <div class="form-group w-100">
                                    <label for="exampleInputPassword1">Harga Baru</label>
                                    <input type="number" class="form-control" id="exampleInputPassword1" min="1" name="hargaBaru" placeholder="Masukkan Harga Baru" required>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                        <div class="col-3">
                            <!-- Biru -->
                            <h2 class="h5">Harga Warna <span class="h5" style="color: #434f5b;">Grey IRL</span></h2>

                            <form method="post" action="processhargawarna.php?id=6">
                                <div class="form-group w-100">
                                    <label for="exampleInputEmail1">Harga Lama</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $_SESSION['harga_greyirl']?>" readonly>
                                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                </div>
                                <div class="form-group w-100">
                                    <label for="exampleInputPassword1">Harga Baru</label>
                                    <input type="number" class="form-control" id="exampleInputPassword1" min="1" name="hargaBaru" placeholder="Masukkan Harga Baru" required>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                        <div class="col-3">
                            <!-- Orange -->
                            <h2 class="h5">Harga Warna <span class="h5" style="color: #2e1836;">Violet 14R</span></h2>

                            <form method="post" action="processhargawarna.php?id=7">
                                <div class="form-group w-100">
                                    <label for="exampleInputEmail1">Harga Lama</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $_SESSION['harga_violet14r']?>" readonly>
                                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                </div>
                                <div class="form-group w-100">
                                    <label for="exampleInputPassword1">Harga Baru</label>
                                    <input type="number" class="form-control" id="exampleInputPassword1" min="1" name="hargaBaru" placeholder="Masukkan Harga Baru" required>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                        <div class="col-3">
                            <!-- Abu-abu -->
                            <h2 class="h5">Harga Warna <span class="h5" style="color: #d3547b;">Rose IR</span></h2>

                            <form method="post" action="processhargawarna.php?id=8">
                                <div class="form-group w-100">
                                    <label for="exampleInputEmail1">Harga Lama</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $_SESSION['harga_roseir']?>" readonly>
                                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                </div>
                                <div class="form-group w-100">
                                    <label for="exampleInputPassword1">Harga Baru</label>
                                    <input type="number" class="form-control" id="exampleInputPassword1" min="1" name="hargaBaru" placeholder="Masukkan Harga Baru" required>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                        
                    </div>
                    
                    <div class="row" style="margin-top: 30px;">
                        <div class="col-3">
                                <!-- Abu-abu -->
                            <h2 class="h5">Harga Warna <span class="h5" style="color: #143d30;">Green IB</span></h2>

                            <form method="post" action="processhargawarna.php?id=8">
                                <div class="form-group w-100">
                                    <label for="exampleInputEmail1">Harga Lama</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $_SESSION['harga_greenib']?>" readonly>
                                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                </div>
                                <div class="form-group w-100">
                                    <label for="exampleInputPassword1">Harga Baru</label>
                                    <input type="number" class="form-control" id="exampleInputPassword1" min="1" name="hargaBaru" placeholder="Masukkan Harga Baru" required>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="processlogout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>