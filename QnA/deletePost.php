<?php
session_start();
require_once "../db/config.php";
if (isset($_POST['deletePost'])) {
    $id = $_POST['q_id'];
    $deletePost = $question->deletePost($id);
    if ($deletePost) {
        $_SESSION['warning'] = "ກະທູ້ຖືກລົບແລ້ວ";
        header("location:../homePage.php");
    }
}