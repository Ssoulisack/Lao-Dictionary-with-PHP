<?php $title = "ຄຳຂໍແກ້ໄຂຄຳສັບຄຳສັບ";

require_once "../db/config.php";
require_once "header_vocab_manage.php";
$status = 'pending';
$vocabulary = $controller->vocabReq($status);
$index = 1;
?>
<div class="container">
    <?php if (isset($_SESSION['error'])) { ?>
        <div class="alert alert-danger text-center" role="alert">
            <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
        </div>
    <?php } ?>
    <?php if (isset($_SESSION['success'])) { ?>
        <div class="alert alert-success text-center" role="alert">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </div>
    <?php } ?>
    <?php if (isset($_SESSION['warning'])) { ?>
        <div class="alert alert-warning text-center" role="alert">
            <?php
            echo $_SESSION['warning'];
            unset($_SESSION['warning']);
            ?>
        </div>
    <?php } ?>
    <h1 class="text-center">
        <?php echo "ຄຳຂໍແກ້ໄຂຄຳສັບ" ?>
    </h1>
    <hr>
    <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr class="text-center fw-bold">
                <th scope="col">ລຳດັບ</th>
                <th scope="col">ຄຳສັບເກົ່າ</th>
                <th scope="col">ຄຳສັບໃໝ່</th>
                <th scope="col">ຊື່ຜູ້ໃຊ້</th>
                <th scope="col">ຈັດການແກ້ໄຂ</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($detail = $vocabulary->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr class="text-center">
                    <th scope=""><?php echo $index++; ?></th>
                    <td><?php echo $detail['old_vocab'] ?></td>
                    <td><?php echo $detail['new_vocab'] ?></td>
                    <td><?php echo $detail['username'] ?></td>
                    <td class="d-flex align-items-center justify-content-center">
                        <a onclick="return confirm('Do you want to delete this information')"
                            href="lCancel_reqVocab.php?id=<?php echo $detail["edit_id"] ?> "
                            class=" btn btn-dark btn-sm mx-2" style="padding: 3px 6px;"><i class="bi bi-x-lg"></i></a>
                        <form action="lUpdate_reqVocab.php" method="POST">
                            <input type="hidden" name="v_id" readonly value="<?php echo $detail['v_id'] ?>">
                            <input type="hidden" name="new_vocab" readonly value="<?php echo $detail['new_vocab'] ?>">
                            <input type="hidden" name="id" readonly value="<?php echo $detail['edit_id'] ?>">
                            <input type="submit" name="submit" class=" btn btn-success btn-sm mx-2" readonly value="ຢືນຍັນ">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>