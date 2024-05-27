<?php
session_start();
require_once "../db/config.php";

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['id'];
    $urole = $_SESSION['username'];
    $q_id = $_POST['q_id'];
    $content = $_POST['comment'];
    $commented = $question->addComment($q_id, $user_id, $urole, $content);
    if ($commented) {
        header("Location: question_detail.php?id=".$q_id); // Redirect with question ID
        exit;
    }
}