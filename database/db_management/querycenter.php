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
            $username = $this->queryValue[0]; $user_password = $this->queryValue[1];

            $sql_login = mysqli_query($conn, "SELECT * FROM customers WHERE username = '$username' AND password = '$user_password'") or die(mysqli_error($conn));
            $get_data = array();
            if(mysqli_num_rows($sql_login) != 0){
                $fetch_data = mysqli_fetch_assoc($sql_login);
    
                $get_data = ["id_customer" => $fetch_data['id'], "nama_customer" => $fetch_data['nama'], "no_telp" => $fetch_data['no_telp'],
                            'pekerjaan_customer' => $fetch_data['pekerjaan'], "daerah_customer" => $fetch_data['daerah'], "username_customer" => $fetch_data['username'],
                             'password_customer' => $fetch_data['password'], "jenis_customer" => $fetch_data['jenis'], "role_customer" => $fetch_data['role']];
                return $get_data;
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
            $result_select = mysqli_query($conn_for_select, $this->queryComment);
            $rows = [];
            while($row = mysqli_fetch_assoc($result_select)){
                $rows [] = $row;
            }

            return (count($rows) == 1) ? $rows[0] : $rows;

        }


    }


        //select what? ,table name, nilai yang mau diambil, order?, limit?

    


?>