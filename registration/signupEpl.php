<?php
$title = "Lao Dictionary";
session_start();
require_once "../layout/header2.php";
?>


<main class="form-signin shadow p-3 w-75 m-auto">
<div class="container">
    <form action="signupEpl_db.php" method="POST" enctype="multipart/form-data">
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
            <h1 class="h3 text-center mb-3">ແບບຟອມລົງທະບຽນຜູ້ຊ່ຽວຊານພາສາ</h1>

            <div class="form-floating mb-2">
                <input type="text" class="form-control" name="username" id="" placeholder="username">
                <label for="username">ຊື່ຜູ້ໃຊ້ (Username)</label>
            </div>
            <div class="form-floating mb-2">
                <input type="email" class="form-control" name="email" id="" placeholder="name@example.com">
                <label for="email">ອີເມວ (Email)</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password" id="" placeholder="Password">
                <label for="password">ລະຫັດຜ່ານ (Password)</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" name="c_password" id="" placeholder="Confirm password">
                <label for="c_password">ຢືນຢັນລະຫັດຜ່ານ (Confirm password)</label>
            </div>
            <br>
            <h4 class="text-center">ຂໍ້ມູນສ່ວນບຸກຄົນ</h4>
            <hr>
            <div class="form-floating mb-2">
                <input type="firstname" class="form-control" name="fname" id="" placeholder="firstname">
                <label for="firstname">ຊື່ແທ້ (Firstname)</label>
            </div>
            <div class="form-floating mb-2">
                <input type="lastname" class="form-control" name="lname" id="" placeholder="lastname">
                <label for="lastname">ນາມສະກຸນ (Lastname)</label>
            </div>
            <div class="form-floating mb-2">
                <input type="address" class="form-control" name="address" id="" placeholder="address">
                <label for="address">ທີ່ຢູ່ (address)</label>
            </div>
            <div class="form-floating mb-2">
                <input type="tel" class="form-control" name="tel" id="" placeholder="telephone">
                <label for="tel">ເບີໂທ (Phone number)</label>
            </div>
            <br>
            <h4 for="upload">ເອກກະສານທີ່ກ່ຽວຂ້ອງ</h4>
            <hr>
            <div class="form-group mb-2">
                <label for="credentials">ເອກກະສານຮັບຮອງ</label>
                <input type="file" name="image" placeholder="ໃບຮັບຮອງ" class="form-control">
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