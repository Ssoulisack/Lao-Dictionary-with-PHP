<?php
$title = "Lao Dictionary";
require_once "db/session.php";
require_once "layout/header.php";
?>

<main class="form-signin shadow p-5 w-50 m-auto">
    <form action="login_db.php" method="POST">
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
        <div class="container">
            <h4 class=" text-center mb-3">ເຂົ້າສູ່ລະບົບ</h4>

            <div class="form-floating mb-2">
                <input type="text" class="form-control" name="username" id="" placeholder="Username">
                <label for="username">ຊື່ຜູ້ໃຊ້ (Username)</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password" id="" placeholder="Password">
                <label for="password">ລະຫັດຜ່ານ (Password)</label>
            </div>
            <div class="form-group">
            <input type="submit" name="submit" value="Login" class="btn btn-primary w-100 p-2 ">
            </div>
        </div>
    </form>
</main>
</body>

</html>