<?php
session_start();
require_once "../db/config.php";

if (isset($_POST['reply'])) {
    $user_id = $_SESSION['id'];
    $username = $_SESSION['username'];
    $q_id = $_POST['q_id'];
    $c_id = $_POST['c_id'];
    $content = $_POST['content'];
    $reply = $question->reply($c_id, $q_id, $user_id, $username, $content);
    if($reply){
        header("Location: question_detail.php?id=".$q_id); // Redirect with question ID
        exit;
    }
}