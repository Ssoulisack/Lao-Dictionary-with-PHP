<?php
require_once "../db/config.php";
require_once "header_vocab_manage.php";
if (isset($_POST['submit'])) {
    $definition_id = $_POST['definition_id'];
    $v_id = $_POST['v_id'];
    $pos_id = $_POST['pos_id'];
    $new_definition = $_POST['new_definition'];
    $new_example = $_POST['new_example'];
    $username = $_SESSION['username'];
    $user_id = $_SESSION['id'];
    $urole = $_SESSION['urole'];
    $status = 'pending';
    $addDefinition = $controller->addDefinition($pos_id, $definition_id, $new_definition, $new_example, $v_id, $user_id, $username, $urole, $status);
    if ($addDefinition) {
        $_SESSION["warning"] = "ຄຳຂໍແກ້ໄຂຄຳສັບຢູ່ໃນຂັ້ນຕອນການກວດສອບ";
        header("location:../homePage.php");
        exit();
    } else {
        $_SESSION["error"] = "ຂໍ້ມູນບໍ່ຖືກຕ້ອງ";
        header('location:../homePage.php');
        exit();
    }
}