<?php
session_start();
require_once "../../db/config.php";
if (isset($_POST['add_definition'])) {
    // edit_definition table
    $edit_id = $_POST['edit_id'];
    $verify_id = $_SESSION['id'];
    $status = 'approve';
    // definition table
    $urole = $_POST['urole'];
    $new_definition = $_POST['newD'];
    $new_example = $_POST['newE'];
    $pos_id = $_POST['pos_id'];
    $v_id = $_POST['v_id'];
    $user_id = $_POST['user_id'];
    $verify_id = $_SESSION['id'];
    $statusDefinition = 'approve';
    $updateStt = $controller->updateStatus($edit_id, $verify_id, $status);
    if ($updateStt) {
        $confirmAdd_definition = $controller->confirmAdd_definition($pos_id, $new_definition, $new_example, $v_id, $user_id, $verify_id, $statusDefinition, $urole);
        if ($confirmAdd_definition) {
            $_SESSION["success"] = "ຢືນຍັນການແກ້ໄຂຄຳສັບສຳເລັັດ";
            header("location:../listEdit_req.php");
            exit();
        } else {
            $_SESSION["error"] = "ຂໍ້ມູນບໍ່ຖືກຕ້ອງ";
            header('location:../listEdit_req.php');
            exit();
        }
    }
} 
if(isset($_POST['reject'])){
    $edit_id = $_POST['edit_id'];
    $statusReject = 'rejected';
    $reject_definition = $controller->reject_req($edit_id, $statusReject);
    if($reject_definition){
        $_SESSION["warning"] = "ປະຕິເສດການແກ້ໄຂ";
        header('location:../listEdit_req.php');
        exit();
    }

}
