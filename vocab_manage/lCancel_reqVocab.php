<?php
session_start();
require_once "../db/config.php";
if (!isset($_GET['id'])) {
    $_SESSION["error"] = "ຂໍ້ມູນບໍ່ຖືກຕ້ອງ";
    header('location:listVocab_req.php');
    exit();
} else {
    $id = $_GET['id'];
    $status = 'rejected';
    $verify_id = $_SESSION['id'];
    $cancelVocab = $controller->cancelVocab($id, $status, $verify_id);
    if ($cancelVocab) {
        $_SESSION["warning"] = "ປະຕິເສດການແກ້ໄຂ";
        header('location:listVocab_req.php');
        exit();
    }
}