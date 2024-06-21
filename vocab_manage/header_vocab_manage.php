<?php
session_start();
require_once "../layout/loginCheck.php";
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
        <a href="../homePage.php"
          class="text-primary fs-6 fw-bold nav-link text-center">ເວັບໄຊທ໌ວັດຈະນານຸກົມ<br>ພາສາລາວ</a>
      </div>
      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navToggle">
        <span class=navbar-toggler-icon></span>
      </button>

      <div class="collapse navbar-collapse" id="navToggle">
        <ul class="navbar-nav ms-auto me-auto">
          <li class="nav-item"><a href="../homePage.php" class="text-dark nav-link">ໜ້າທຳອິດ</a></li>
          <li class="nav-item"><a href="all_vocab.php" class="text-dark nav-link">ຄຳສັບທັງໝົດ</a></li>
          <li class="nav-item"><a href="#" class="text-dark nav-link">ກ່ຽວກັບ</a></li>
          <?php if ($_SESSION["urole"] == "admin") { ?>
            <li class="nav-item dropdown">
              <a href="#" class="text-dark nav-link dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false">ການລົງທະບຽນ</a>
              <ul class="dropdown-menu">
                <li class="dropdown-item"><a href="../logging/registration_Request.php"
                    class="nav-link">ຄຳຂໍລົງທະບຽນຜູ້ຊ່ຽວຊານ</a>
                </li>
                <li class="dropdown-item"><a href="../logging/signupAdminForm.php" class="nav-link">ເພີ່ມຜູ້ດູແລລະບົບ</a>
                </li>
              </ul>
            </li>
          <?php } ?>
          <?php if ($_SESSION["urole"] == "admin") { ?>
            <li class="nav-item dropdown">
              <a href="#" class="text-dark nav-link dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false">ລາຍງານ</a>
              <ul class="dropdown-menu">
                <li class="dropdown-item"><a href="../reports/reportVocab.php" class="nav-link">ລາຍງານຄຳສັບ</a>
                </li>
                <li class="dropdown-item"><a href="../reports/reportEditVocab.php"
                    class="nav-link">ລາຍງານການແກ້ໄຂຄຳສັບ</a></li>
                <li class="dropdown-item"><a href="../reports/reportEditDefinition.php"
                    class="nav-link">ລາຍງານການແກ້ໄຂຄຳອະທິບາຍສັບ</a></li>
                <li class="dropdown-item"><a href="../reports/reportEpl.php" class="nav-link">ລາຍງານຜູ້ຊ່ຽວຊານ</a></li>
                <li class="dropdown-item"><a href="../reports/reportMember.php" class="nav-link">ລາຍງານສະມາຊິກ</a></li>
              </ul>
            </li>
          <?php } elseif ($_SESSION["urole"] == "languageExpert") { ?>
            <li class="nav-item dropdown">
              <a href="#" class="text-dark nav-link dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false">ລາຍງານ</a>
              <ul class="dropdown-menu">
                <li class="dropdown-item"><a href="../reports/reportVocab.php" class="nav-link">ລາຍງານຄຳສັບ</a>
                </li>
                <li class="dropdown-item"><a href="../reports/reportEditVocab.php"
                    class="nav-link">ລາຍງານການແກ້ໄຂຄຳສັບ</a></li>
                <li class="dropdown-item"><a href="../reports/reportEditDefinition.php"
                    class="nav-link">ລາຍງານການແກ້ໄຂຄຳອະທິບາຍສັບ</a></li>
                <li class="dropdown-item"><a href="../reports/reportEpl.php" class="nav-link">ລາຍງານຜູ້ຊ່ຽວຊານ</a></li>
              </ul>
            </li>
          <?php } elseif ($_SESSION["urole"] == "member") { ?>
            <li class="nav-item dropdown">
              <a href="#" class="text-dark nav-link dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false">ລາຍງານ</a>
              <ul class="dropdown-menu">
                <li class="dropdown-item"><a href="../reports/reportVocab.php" class="nav-link">ລາຍງານຄຳສັບ</a>
                </li>
                <li class="dropdown-item"><a href="../reports/reportEditVocab.php"
                    class="nav-link">ລາຍງານການແກ້ໄຂຄຳສັບ</a></li>
                <li class="dropdown-item"><a href="../reports/reportEditDefinition.php"
                    class="nav-link">ລາຍງານການແກ້ໄຂຄຳອະທິບາຍສັບ</a></li>
              </ul>
            </li>
          <?php } ?>
          <?php if (isset($_SESSION["id"])) { ?>
            <li class="nav-item dropdown">
              <a href="#" class="text-dark nav-link dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false">Hello,
                <?php echo $_SESSION["username"] ?>
              </a>
              <?php if ($_SESSION["urole"] == "member") { ?>
                <ul class="dropdown-menu">
                  <li class="dropdown-item"><a href="../profile.php" class="nav-link">ຂໍ້ມູນສ່ວນໂຕ</a></li>
                  <li class="dropdown-item"><a href="../logout.php" class="nav-link">ອອກຈາກລະບົບ</a></li>
                </ul>
              <?php } elseif ($_SESSION["urole"] == "languageExpert") { ?>
                <ul class="dropdown-menu">
                  <li class="dropdown-item"><a href="../profile.php" class="nav-link">ຂໍ້ມູນສ່ວນໂຕ</a></li>
                  <li class="dropdown-item"><a href="../vocab_manage/listVocab_req.php" class="nav-link">ຄຳຂໍແກ້ໄຂຄຳສັບ</a>
                  </li>
                  <li class="dropdown-item"><a href="../vocab_manage/listEdit_req.php"
                      class="nav-link">ຄຳຂໍແກ້ໄຂຄຳອະທິບາຍສັບ</a></li>
                  <li class="dropdown-item"><a href="../logging/add_vocab.php" class="nav-link">ເພີ່ມຄຳສັບ</a>
                  </li>
                  <li class="dropdown-item"><a href="../logout.php" class="nav-link">ອອກຈາກລະບົບ</a></li>
                </ul>
              <?php } elseif ($_SESSION["urole"] == "admin") { ?>
                <ul class="dropdown-menu">
                  <li class="dropdown-item"><a href="../profile.php" class="nav-link">ຂໍ້ມູນສ່ວນໂຕ</a></li>
                  <li class="dropdown-item"><a href="../members.php" class="nav-link">ສະມາຊິກ</a></li>
                  <li class="dropdown-item"><a href="../ep_languages.php" class="nav-link">ຜູ້ຊ່ຽວຊານ</a></li>
                  <li class="dropdown-item"><a href="../logging/add_vocab.php" class="nav-link">ເພີ່ມຄຳສັບ</a>
                  </li>
                  <li class="dropdown-item"><a href="../logout.php" class="nav-link">ອອກຈາກລະບົບ</a></li>
                </ul>
              <?php } ?>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>