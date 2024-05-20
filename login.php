<?php
$title = "Lao Dictionary";
require_once "layout/header.php";
require_once "db/config.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $new_password= md5($password.$username);

    $loginAdmin = $user->loginAdmin($username, $new_password);
    $loginMember = $user->loginMembers($username, $new_password);
    $loginEpl= $user->loginExpertLanguage($username, $new_password);

    if (!$loginMember && !$loginAdmin && !$loginEpl) {
        $_SESSION["error"] = "Username or password incorrect";
        header("Location: login.php");
        exit();
    } else {
        if ($loginMember) {
            $_SESSION["username"] = $loginMember["username"];
            $_SESSION["id"] = $loginMember["m_id"];
            $_SESSION["urole"] = $loginMember["urole"];
        } else if ($loginAdmin) {
            $_SESSION["username"] = $loginAdmin["username"];
            $_SESSION["id"] = $loginAdmin["admin_id"];
            $_SESSION["urole"] = $loginAdmin["urole"];
        } else if ($loginEpl["status"] == "pending") {
            $_SESSION["warning"] = "ສະຖານະບັນຊີຂອງທ່ານຢູ່ໃນຂັ້ນຕອນການກວດສອບ";
            header("Location: login.php");
            exit();
        }else if ($loginEpl["status"] == "approve") {
            $_SESSION["username"] = $loginEpl["username"];
            $_SESSION["id"] = $loginEpl["e_id"];
            $_SESSION["urole"] = $loginEpl["urole"];
        }
        header("Location:homePage.php");
    }
    
}
?>

<main class="form-signin shadow p-5 w-75 m-auto">
<div class="container-md">
    <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]) ?>" method="POST">
        <?php if (isset ($_SESSION['error'])) { ?>
        <div class="alert alert-danger" role="alert">
            <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
        </div>
        <?php } ?>
        <?php if (isset ($_SESSION['success'])) { ?>
        <div class="alert alert-success" role="alert">
            <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
        </div>
        <?php } ?>
        <?php if (isset ($_SESSION['warning'])) { ?>
        <div class="alert alert-warning" role="alert">
            <?php
                echo $_SESSION['warning'];
                unset($_SESSION['warning']);
                ?>
        </div>
        <?php } ?>
            <h4 class=" text-center mb-3">ເຂົ້າສູ່ລະບົບ</h4>

            <div class="form-floating mb-2">
                <input type="text" class="form-control" name="username" value="<?php if($_SERVER["REQUEST_METHOD"]=="POST") echo $_POST["username"];?>" placeholder="Username">
                <label for="username">ຊື່ຜູ້ໃຊ້ (Username)</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password" value="" placeholder="Password">
                <label for="password">ລະຫັດຜ່ານ (Password)</label>
            </div>
            <div class="form-group">
            <input type="submit" name="submit" value="Login" class="btn btn-primary w-100 p-2 ">
            </div>
        </form>
    </div>
</main>
</body>

</html>