<?php
require_once "../../db/config.php";

if(!isset($_GET["id"])){
    header("location:../registration_Request.php");
}else{
    $id=$_GET["id"];
    $result= $user->cancelStatus($id);
    if($result){
        $_SESSION["warning"] = "ປະຕິເສດການລົງທະບຽນ";
        header("location:../registration_Request.php");
        exit();
    }  
}