<?php
session_start();
require_once "../db/config.php";
if (isset($_POST['deletePost'])) {
    $id = $_POST['q_id'];
    $deletePost = $question->deletePost($id);
    if ($deletePost) {
        $_SESSION['warning'] = "ສ້າງກະທູ້ສຳເລັດ";
        header("location:questions_page.php");
    }
}