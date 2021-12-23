<?php 

    // Koneksi ke database

    require('conn_information.php');

    class setUpConnection{
        private $serverName;
        private $rootAccess;
        private $passAccess;
        private $dbName;

        public function __construct(){
            $this->serverName = DB_SERVER;
            $this->rootAccess = DB_ROOT;
            $this->passAccess = DB_PASSWORD;
            $this->dbName = DB_NAME;
        }

        public function makeConnection(){
            return mysqli_connect($this->serverName, $this->rootAccess, $this->passAccess, $this->dbName);
        }

    }



    class UserCommand extends setUpConnection{
        private $queryValue;
        private $queryComment;

        public function __construct(){         
            $this->queryValue = null;
            $this->queryComment = null;

        }


        // validasi login user
        public function loginValidation($anyQueryValue){   
            $build = new setUpConnection();
            $this->queryValue = $anyQueryValue;
            $conn = $build->makeConnection(); // mysqli_connect
            $user_email = $this->queryValue[0]; 
            $user_password = $this->queryValue[1];
            
            $to_sha256 = hash("sha256", $user_password);
            $to_bcrypt = password_hash($to_sha256, PASSWORD_DEFAULT);
            
            $take_user_email = mysqli_query($conn, "SELECT * FROM customers WHERE email = '$user_email'") or die(mysqli_error($conn));
            $fetch_data = mysqli_fetch_assoc($take_user_email);
            $take_pass = $fetch_data["password"];
            
            if(!empty($take_user_email)){
                $verifying = password_verify($to_sha256, $take_pass);
                if($verifying){
                    $get_data = array();
                    $get_data = ["id_customer" => $fetch_data['id'], "nama_customer" => $fetch_data['nama'], "no_telp" => $fetch_data['no_telp'],
                            'pekerjaan_customer' => $fetch_data['pekerjaan'], "daerah_customer" => $fetch_data['daerah'], "username_customer" => $fetch_data['username'],
                             "jenis_customer" => $fetch_data['jenis'], "role_customer" => $fetch_data['role']];
                    return $get_data;
                } else{
                    echo '<script language="javascript">';
                    echo 'alert("Password Salah!!!")';
                    echo '</script>';
                    echo "<script>window.location = 'login.php'</script>";
                }
            } else{
                echo '<script language="javascript">';
                echo 'alert("Username atau Password Salah!!!")';
                echo '</script>';
                echo "<script>window.location = 'login.php'</script>";
            }
        }

        public function selectQuery($anyComment){
            $this->queryComment = $anyComment;
            $build_for_select = new setUpConnection();
            $conn_for_select = $build_for_select->makeConnection();
            $result_select = mysqli_query($conn_for_select, $this->queryComment) or die(mysqli_error($conn_for_select));
            $rows = [];
            while($row = mysqli_fetch_assoc($result_select)){
                $rows [] = $row;
            }

            return (count($rows) == 1) ? $rows[0] : $rows;

        }

        public function updateQuery($updateComment){
            $this->queryComment = $updateComment;
            $build_for_update = new setUpConnection();
            $conn_for_update = $build_for_update->makeConnection();
            return mysqli_query($conn_for_update, $this->queryComment) or die(mysqli_error($conn_for_update));
        }

        public function insertQuery ($insertComment, $regInfo = null, $register = True){
            $this->queryComment = $insertComment;
            $build_for_insert = new setUpConnection();
            $conn_for_insert = $build_for_insert->makeConnection();
            
            $nama = $_POST['nama'];

            if($register){
                $no_telp = $regInfo['telepon'];
                $email = $regInfo['email'];
                $pekerjaan = $regInfo['pekerjaan'];
                $daerah = $regInfo['daerah'];
                $username = $regInfo['username'];
                $password = $regInfo['password'];
                $jenis = "baru";
                $role = "member";
                
                $query_for_register = $this->queryComment." INTO customers (nama, no_telp, email, pekerjaan, daerah, username, password, jenis, role) 
                                    VALUES ('$nama', '$no_telp', '$email', '$pekerjaan', '$daerah', '$username', '$password', '$jenis', '$role')";
                return mysqli_query($conn_for_insert, $query_for_register);

            } else{
                return mysqli_query($conn_for_insert, $this->queryComment) or die(mysqli_error($conn_for_insert));
            }
            
        }


    }


    


?>