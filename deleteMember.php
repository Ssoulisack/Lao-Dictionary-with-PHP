<?php
require_once "db/config.php";

if(!isset($_GET["id"])){
    header("location:members.php");
}else{
    $id=$_GET["id"];
    $result= $user->deleteMember($id);
    if($result){
        header("location:members.php");
    }
}
?>