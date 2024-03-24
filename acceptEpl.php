<?php
require_once "db/config.php";

if(!isset($_GET["id"])){
    header("location:registration_Request.php");
}else{
    $id=$_GET["id"];
    $status = 'approve';
    $result= $controller->updateStatus($id, $status);
    if($result){
        $_SESSION["success"] = "ຢືນຢັນການລົງທະບຽນສຳເລັດ";
        header("location:registration_Request.php");
        exit();
    }
}