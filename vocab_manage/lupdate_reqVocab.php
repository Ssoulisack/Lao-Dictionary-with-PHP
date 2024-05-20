<?php 
require_once "../db/config.php";
require_once "header_vocab_manage.php";
if(isset($_POST['submit'])){
$e_id = $_POST['id'];
$v_id = $_POST['v_id'];
$user_id = $_SESSION['id'];
$new_vocab = $_POST['new_vocab'];
$status = 'approve';
$statusVocab = 'modifies';
$updateStt = $controller->updateStt($user_id, $e_id, $status);
if($updateStt){
    $updateVocab = $controller->confirmVocab($v_id, $new_vocab, $statusVocab);
    if($updateVocab){
        $_SESSION["success"] = "ຢືນຍັນການແກ້ໄຂຄຳສັບສຳເລັັດ";
            header("location:listVocab_req.php");
            exit();
    }else{
        $_SESSION["error"] = "ຂໍ້ມູນບໍ່ຖືກຕ້ອງ";
        header('location:listVocab_req.php');
        exit();
    }
}
}