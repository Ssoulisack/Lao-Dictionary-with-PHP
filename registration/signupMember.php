<?php
$title = "Lao Dictionary";
require_once "../layout/header2.php";

?>
<main class="form-signup shadow p-2 w-75 m-auto">

    <div class="container-md">
        <form action="signupMember_db.php" method="POST">
            <?php if (isset ($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
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
            <h1 class="h3 text-center mb-3">ແບບຟອມລົງທະບຽນ</h1>

            <div class="form-floating mb-2">
                <input type="text" class="form-control" name="username" placeholder="username">
                <label for="username">ຊື່ຜູ້ໃຊ້ (Username)</label>
            </div>
            <div class="form-floating mb-2">
                <input type="email" class="form-control" name="email" placeholder="name@example.com">
                <label for="email">ອີເມວ (Email)</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password">
                <label for="password">ລະຫັດຜ່ານ (Password)</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" name="c_password" placeholder="Confirm password">
                <label for="c_password">ຢືນຢັນລະຫັດຜ່ານ (Confirm password)</label>
            </div>
            <br>
            <h4 class="text-center">ຂໍ້ມູນສ່ວນບຸກຄົນ</h4>
            <hr>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" name="fname" placeholder="firstname">
                <label for="firstname">ຊື່ແທ້ (Firstname)</label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" name="lname" placeholder="lastname">
                <label for="lastname">ນາມສະກຸນ (Lastname)</label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" name="address" placeholder="address">
                <label for="address">ທີ່ຢູ່ (address)</label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" name="tel" placeholder="telephone">
                <label for="tel">ເບີໂທ (Phone number)</label>
            </div>
            <div class="form-group">
                <button class="btn btn-primary w-100 py-2 mb-2 ms-auto" type="submit" name="submit">ລົງທະບຽນ</button>
                <p class="text-center">Have already an account? <a href="login.php">sign in</a></p>
            </div>
        </form>
    </div>
</main>
</body>

</html>