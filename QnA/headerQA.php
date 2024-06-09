<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require_once "../layout/loginCheck.php";
?>

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
    <style>
        .comment-box {
            display: flex;
            flex-direction: column;
            padding: 10px 20px 10px 20px;
            background-color: #f0f2f5;
            border: 1px solid #f0f2f5;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            border-radius: 30px;
            width: fit-content;
            max-width: 100%;
            color: #1c1e21;
            margin-bottom: 10px;
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }

        .button {
            background-color: #f0f2f5;
            border: none;
        }

        .username {
            font-weight: bold;
            color: #1c1e21;
            margin: 0;
        }

        .comment-content {
            white-space: pre-wrap;
            word-wrap: break-word;
            margin-bottom: 5px;
            padding: 8px;
            border-radius: 10px;
        }

        .comment-actions {
            display: flex;
            align-items: center;
            font-size: 0.9em;
            color: #606770;
        }

        .comment-actions .time {
            margin-right: 10px;
            color: #606770;
        }

        .comment-actions .action {
            margin-right: 10px;
            cursor: pointer;
            text-decoration: none;
            color: #385898;
        }

        .comment-actions .action:hover {
            text-decoration: underline;
        }

        .reply-form {
            margin-top: 10px;
            padding: 5px;
            background-color: #f0f2f5;
            border-radius: 10px;
        }

        .reply-box {
            display: flex;
            flex-direction: column;
            padding: 10px 20px 10px 20px;
            background-color: #f0f2f5;
            border-radius: 30px;
            width: fit-content;
            max-width: 100%;
            color: #1c1e21;
            margin-bottom: 10px;
        }

        .replies {
            display: none;
        }

        .toggle-replies {
            border: none;
            background: none;
            color: gray;
            cursor: pointer;
            font-size: 18px;
            margin-left: 20px;
        }

        .reply-delete {
            border: none;
            background-color: #f0f2f5;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .btn {
            background-color: #1877f2;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            display: flex;
            align-items: center;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .buttons {
            font-size: 1rem;
            border: none;
            border-radius: 30px;
            padding: 10px 20px;
        }

        .btn-submit {
            color: #f0f2f5;
            background-color: #333;
        }

        .btn-can {
            color: #333;
            background-color: #f0f2f5;
        }

        .btn-reply {
            padding: 5px 10px 5px 10px;
            font-size: 1rem;
            border: none;
            border-radius: 15px;
            color: #333;
            background-color: #f0f2f5;
            width: fit-content;
            position: relative;
            margin-left: auto;
        }

        .btn-reply:hover {
            border-radius: 15px;
            color: #f0f2f5;
            background-color: #333;
        }
    </style>
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
                    <li class="nav-item"><a href="../QnA/questions_page.php" class="text-dark nav-link">ກະທູ້ຖາມ-ຕອບ</a>
                    </li>
                    <li class="nav-item"><a href="#" class="text-dark nav-link">ກ່ຽວກັບ</a></li>
                    <?php if ($_SESSION["urole"] == "admin") { ?>
                        <li class="nav-item dropdown">
                            <a href="#" class="text-dark nav-link dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false">ການລົງທະບຽນ</a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-item"><a href="../logging/registration_Request.php"
                                        class="nav-link">ຄຳຂໍລົງທະບຽນຜູ້ຊ່ຽວຊານ</a>
                                </li>
                                <li class="dropdown-item"><a href="../logging/signupAdminForm.php"
                                        class="nav-link">ເພີ່ມຜູ້ດູແລລະບົບ</a></li>
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
                                <li class="dropdown-item"><a href="../reports/reportEpl.php"
                                        class="nav-link">ລາຍງານຜູ້ຊ່ຽວຊານ</a></li>
                                <li class="dropdown-item"><a href="../reports/reportMember.php"
                                        class="nav-link">ລາຍງານສະມາຊິກ</a></li>
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
                                <li class="dropdown-item"><a href="../reports/reportEpl.php"
                                        class="nav-link">ລາຍງານຜູ້ຊ່ຽວຊານ</a></li>
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
                            </ul>
                        </li>
                    <?php } else {
                        header("Location: ../login.php");
                        exit();
                    } ?>
                    <?php if (isset($_SESSION["id"])) { ?>
                        <li class="nav-item dropdown">
                            <a href="#" class="text-dark nav-link dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false">Hello,
                                <?php echo $_SESSION["username"] ?>
                            </a>
                            <?php if ($_SESSION["urole"] == "member") { ?>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-item"><a href="" class="nav-link">ຂໍ້ມູນສ່ວນໂຕ</a></li>
                                    <li class="dropdown-item"><a href="../logout.php" class="nav-link">ອອກຈາກລະບົບ</a></li>
                                </ul>
                            <?php } elseif ($_SESSION["urole"] == "languageExpert") { ?>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-item"><a href="../vocab_manage/listVocab_req.php"
                                            class="nav-link">ຄຳຂໍແກ້ໄຂຄຳສັບ</a>
                                    </li>
                                    <li class="dropdown-item"><a href="../vocab_manage/listEdit_req.php"
                                            class="nav-link">ຄຳຂໍແກ້ໄຂຄຳອະທິບາຍສັບ</a>
                                    </li>
                                    <li class="dropdown-item"><a href="../logging/add_vocab.php" class="nav-link">ເພີ່ມຄຳສັບ</a>
                                    </li>
                                    <li class="dropdown-item"><a href="../logout.php" class="nav-link">ອອກຈາກລະບົບ</a></li>
                                </ul>
                            <?php } elseif ($_SESSION["urole"] == "admin") { ?>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-item"><a href="../logging/add_vocab.php" class="nav-link">ເພີ່ມຄຳສັບ</a>
                                    </li>
                                    <li class="dropdown-item"><a href="../logout.php" class="nav-link">ອອກຈາກລະບົບ</a></li>
                                </ul>
                            <?php } ?>
                        </li>
                    <?php } else {
                        header("Location: ../login.php");
                        exit();
                    } ?>
                </ul>
            </div>
        </div>
    </nav>