<?php
require_once "db/config.php";

if(!isset($_GET["id"])){
    header("location:ep_languages.php");
}else{
    $id=$_GET["id"];
    $result= $user->deleteEpl($id);
    if($result){
        header("location:ep_languages.php");
    }
}
?>