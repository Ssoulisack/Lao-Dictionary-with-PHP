<?php
require_once "users.php";
require_once "question.php";
require_once "reports.php";
require_once "Controller.php";

$host = "localhost";
$username = "root";
$password = "";
$dbname = "laodictionary";

$dsn = "mysql:host=$host;dbname=$dbname; charset-utf8";

try{
    $conn = new PDO($dsn,$username,$password);
    //set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connect successfully";
}catch(PDOException $e){
    echo "Connection failed".$e->getMessage();
}
$user = new Users($conn);
$controller = new Controller($conn);
$question = new Question($conn);
$reports = new Report($conn);
?>