<?php
header('Content-Type: application/json');

include dirname(dirname(__FILE__)).'/api/db/Db.class.php';

$db = new Db();

$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 0;
$name = isset($_GET['name']) ? $_GET['name'] : '';

$sql_limit = '';
if (!empty($limit)) {
    $sql_limit = ' LIMIT 0,'.$limit;
}
$sql_name = '';
if (!empty($name)) {
    $sql_name = ' where cat_name LIKE \'%'.$name.'%\' ';
}

$testing = $db->query("SELECT * FROM customers WHERE id = 1 ". $sql_name." ".$sql_limit);

$arr = array();


$arr = array();
$arr["info"] = "success";
$arr["num"] = count($testing);
$arr["result"] = $testing;

echo json_encode($arr);