<?php
session_start();
require_once "../db/config.php";

if (isset($_POST['delete'])) {
    $q_id = $_POST['q_id'];
    $c_id = $_POST['c_id'];
    $deleteComment = $question->deleteComment($c_id);
    if ($deleteComment) {
        header("Location: question_detail.php?id=".$q_id); // Redirect with question ID
        exit;
    }
}