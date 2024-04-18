<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    <?php echo $title; ?>
  </title>
  <link rel="stylesheet" href="../asset/bootstrap-5.2.3-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../asset/bootstrap-icons-1.11.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../asset/css/main.css">
  <script src="../asset/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-white mb-3 sticky-top">
    <div class="container-fluid border border-bottom">
      <div class="navbar-brand d-flex align-items-center">
        <a href="../index.php" class="text-primary fs-6 fw-bold nav-link text-center">ເວັບໄຊທ໌ວັດຈະນານຸກົມ<br>ພາສາລາວ</a>
        </div>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navToggle">
          <span class=navbar-toggler-icon></span>
        </button>

        <div class="collapse navbar-collapse" id="navToggle">
          <ul class="navbar-nav ms-auto me-auto">
            <li class="nav-item"><a href="../index.php" class="text-dark nav-link">ໜ້າທຳອິດ</a></li>
            <li class="nav-item"><a href="#" class="text-dark nav-link">ກະທູ້ຖາມ-ຕອບ</a></li>
            <li class="nav-item"><a href="#" class="text-dark nav-link">ກ່ຽວກັບ</a></li>
            <li class="nav-item dropdown">
              <a href="#" class="text-dark nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">ການລົງທະບຽນ</a>
              <ul class="dropdown-menu">
                <li class="dropdown-item"><a href="signupMember.php" class="nav-link">ລົງທະບຽນສະມາຊິກ</a></li>
                <li class="dropdown-item"><a href="signupEpl.php" class="nav-link">ລົງທະບຽນຜູ້ຊ່ຽວຊານ</a></li>
              </ul>
            </li>
          </ul>
        </div>
        <div class="collapse navbar-collapse" id="navToggle">
          <a href="../login.php" class="btn btn-primary px-3 py-2">ເຂົ້າສູ່ລະບົບ</a>
        </div>
      </div>
    </nav>