<?php
session_start();
require_once "../db/config.php";

if(isset($_POST['submit'])){
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['id'];
    if(empty($title)){
        $_SESSION['error'] = "ກະລຸນາປ້ອນຫົວຂໍ້ກະທູ້ຄຳຖາມ";
        header("location:addQuestion_form.php");
        exit();
    }else if(empty($content)){
        $_SESSION['error'] = "ກະລຸນາປ້ອນລາຍລະອຽດເນຶ້ອຫາ";
        header("location:addQuestion_form.php");
        exit();
    }else{
        if (strlen($title) > 300) {
            $_SESSION['error'] = "The title is long.";
            header("location:addQuestion_form.php");
            exit();
        }else{
            $addQuestion = $question->addQuestion($title, $content, $user_id);
        if($addQuestion){
            $_SESSION['success'] = "ສ້າງກະທູ້ສຳເລັດ";
            header("location:questions_page.php");
            exit();
        }
        }
        
    }
}?>
