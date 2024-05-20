<?php $title = "ຄຳຂໍແກ້ໄຂຄຳສັບຄຳສັບ";

require_once "../db/config.php";
require_once "header_vocab_manage.php";
$status = 'pending';
$definition = $controller->definitionReq($status);
$index = 1;
?>
<div class="container-fluid">
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
    <h4 class="text-center">
        <?php echo "ຄຳຂໍແກ້ໄຂ ຫຼື ເພີ່ມຄຳອະທິບາຍສັບ" ?>
    </h4>
    <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr class="text-center">
                <th scope="col">ລຳດັບ</th>
                <th scope="col">ຄຳສັບ</th>
                <th scope="col">ປະເພດຄຳສັບ</th>
                <th scope="col">ຄຳອະທິບາຍໃໝ່</th>
                <th scope="col">ຕົວຢ່າງໃໝ່</th>
                <th scope="col">ຊື່ຜູ້ໃຊ້</th>
                <th scope="col">ຈັດການແກ້ໄຂ</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($detail = $definition->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <th scope=""><?php echo $index++; ?></th>
                    <td><?php echo $detail['vocabulary'] ?></td>
                    <td><?php echo $detail['pos_name2'] ?></td>
                    <td><?php echo $detail['new_definition'] ?></td>
                    <td><?php echo $detail['new_example'] ?></td>
                    <td><?php echo $detail['username'] ?></td>
                    <td class="text-center">
                        <a href="editReq_detail.php?id=<?php echo $detail["edit_id"] ?>"
                            class="btn btn-primary btn-sm">ເບິ່ງລາຍລະອຽດ</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>

</html>