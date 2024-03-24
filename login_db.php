<?php
// require_once "db/session.php";
// require_once "db/config.php";

// var_dump($loginAdmin);
// echo "<hr>";
// var_dump($loginEpl);
// echo "<hr>";
// var_dump($loginMember);
// echo "<hr>";

// if(isset($_POST["submit"])){
//     $username = $_POST["username"];
//     $password = $_POST["password"];
//     $new_password= md5($password.$username);
//     $loginAdmin = $user->loginAdmin($username, $new_password);
//     $loginMember = $user->loginMembers($username, $new_password);
//     $loginEpl= $user->loginExpertLanguage($username, $new_password);
        
//     if (!$loginMember && !$loginAdmin && !$loginEpl) {
//         $_SESSION["error"] = "Username or password incorrect";
//         header("Location: login.php");
//         exit();
//     } else {
//         if ($loginMember) {
//             $_SESSION["username"] = $loginMember["username"];
//             $_SESSION["member"] = $loginMember["m_id"];
//             $_SESSION["uMember"] = $loginMember["urole"];
//         } else if ($loginAdmin) {
//             $_SESSION["username"] = $loginAdmin["username"];
//             $_SESSION["admin"] = $loginAdmin["admin_id"];
//             $_SESSION["uAdmin"] = $loginAdmin["urole"];
//         } else if ($loginEpl["status"] == "pending") {
//             $_SESSION["warning"] = "Your status is now pending for approval.";
//             header("Location: login.php");
//             exit();
//         }else if ($loginEpl["status"] == "approve") {
//             $_SESSION["username"] = $loginEpl["username"];
//             $_SESSION["epLanguage"] = $loginEpl["e_id"];
//             $_SESSION["uEpl"] = $loginEpl["urole"];
//         }
//         header("Location:homePage.php");
//     }
    
// }
?>