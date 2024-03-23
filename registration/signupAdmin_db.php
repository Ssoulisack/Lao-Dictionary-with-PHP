<?php
require_once "../db/config.php";
require_once "../db/session.php";

//ADD Admin
if(isset($_POST['submit'])){
    $values = ["username", "email", "password", "c_password", "fname", "lname", "address", "tel"];
    $names = ["username", "email", "password", "Confirm password", "firstname", "Lastname", "Address", "Phone number"];
    foreach ($values as $index => $value) {
        if (empty ($_POST[$value])) {
            $fieldName = isset ($names[$index]) ? $names[$index] : $value;
            $_SESSION["error"] = "Please fill in the " . ucfirst($fieldName);
            header("location:../signupAdminForm.php");
            exit();
        }

    }
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $c_password = $_POST["c_password"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $address = $_POST["address"];
    $tel = $_POST["tel"];
    $urole = 'admin';

    if (strlen($password) > 20 || strlen($password) < 5) {
        $_SESSION['error'] = "The password must be 5 to 20 characters long.";
        header("location:../signupAdminForm.php");
        exit();
    }

    if ($password != $c_password) {
        $_SESSION["error"] = "Passwords do not match! Try again";
        header("location:../signupAdminForm.php");
        exit();
    }
    $result = $user->checkUserData($username, $email);
    if ($result['num'] > 0) {
        $_SESSION["error"] = "Email or username has already exits";
        header("location:../signupAdminForm.php");
        exit();
    } else {
        $result = $user->insertAdmin($username, $email, $password, $fname, $lname, $address, $tel, $urole);
        if ($result) {
            $_SESSION["success"] = "Registration successful";
            header("location:../login.php");
            exit();
        }
    }
}