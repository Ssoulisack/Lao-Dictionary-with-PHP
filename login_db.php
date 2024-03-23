<?php
require_once "db/session.php";
require_once "db/config.php";

// var_dump($loginAdmin);
// echo "<hr>";
// var_dump($loginEpl);
// echo "<hr>";
// var_dump($loginMember);
// echo "<hr>";

if(isset($_POST["submit"])){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $new_password= md5($password.$username);
    $loginAdmin = $user->loginAdmin($username, $new_password);
    $loginMember = $user->loginMembers($username, $new_password);
    $loginEpl= $user->loginExpertLanguage($username, $new_password);
    //Login member
    // if(!$loginMember){
    //     $_SESSION["error"] = "Username or password incorrect";
    //     header("Location:login.php");
    //     exit();
    // }else{
    //     $_SESSION["username"]=$username;
    //     $_SESSION["member"]=$loginMember["m_id"];
    //     $_SESSION["urole"]=$loginMember["member"];
    //     header("Location:index.php");
    // }
    // // Login admin
    // if(!$loginAdmin){
    //     $_SESSION["error"] = "Username or password incorrect";
    //     header("Location:login.php");
    //     exit();
    // }else{
    //     $_SESSION["username"]=$username;
    //     $_SESSION["admin"]=$loginAdmin["admin_id"];
    //     $_SESSION["urole"]=$loginAdmin["admin"];
    //     header("Location:index.php");
    // }
    // //Language Expert
    // if(!$loginEpl){
    //     $_SESSION["error"] = "Username or password incorrect";
    //     header("Location:login.php");
    //     exit();
    // }else{
    //     $_SESSION["username"]=$username;
    //     $_SESSION["admin"]=$loginEpl["e_id"];
    //     $_SESSION["urole"]=$loginEpl["admin"];
    //     header("Location:index.php");
    // }
    if (!$loginMember && !$loginAdmin && !$loginEpl) {
        $_SESSION["error"] = "Username or password incorrect";
        header("Location: login.php");
        exit();
    } else {
        if ($loginMember) {
            $_SESSION["member"] = $loginMember["username"];
            $_SESSION["member"] = $loginMember["m_id"];
            $_SESSION["urole"] = $loginMember["member"];
        } else if ($loginAdmin) {
            $_SESSION["admin"] = $loginAdmin["username"];
            $_SESSION["admin"] = $loginAdmin["admin_id"];
            $_SESSION["urole"] = $loginAdmin["admin"];
        } else if ($loginEpl["status"] == "pending") {
            $_SESSION["warning"] = "Your status is now pending for approval.";
            header("Location: login.php");
            exit();
        }else if ($loginEpl["status"] == "approve") {
            $_SESSION["epLanguage"] = $loginEpl["username"];
            $_SESSION["epLanguage"] = $loginEpl["e_id"];
            $_SESSION["urole"] = $loginEpl["languageExpert"];
        }
        header("Location: index.php");
    }
    
}
?>