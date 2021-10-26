<?php

session_start();
require('database/db_management/querycenter.php');


$object = new TryLogin(["Freehahn", "saka"]);



$get_val =$object->loginValidation();

foreach($get_val as $key => $value){
    $_SESSION[$key] = $value;
}

print_r($_SESSION);

?>