<?php
if(!isset($_SESSION["admin"]) || !isset($_SESSION["member"]) || !isset($_SESSION["expert_language"])){
    header("location:login.php");
}else{
    header("location:index.php");
}
?>