<?php
session_start();
require_once "../db/config.php";

if (isset($_POST['editComment'])) {
    $dateTime = new DateTime("now", new DateTimeZone('Asia/Vientiane'));
    $c_id = $_POST['c_id'];
    $q_id = $_POST['q_id'];
    $content = $_POST['content'];
    $time = $dateTime->format("Y-m-d H:i:s"); // Outputs the current date and time in Laos
    $editComment = $question->editComment($c_id, $content, $time);
    if ($editComment) {
        header("Location: question_detail.php?id=" . $q_id); // Redirect with question ID
        exit;
    }
}