<?php $title = "ລາຍລະອຽດການແກ້ໄຂຄຳສັບຄຳສັບ";

require_once "../db/config.php";
require_once "header_vocab_manage.php";
if (!isset($_GET["id"])) {
    header:
    "location:definition_Request.php";
} else {
    $id = $_GET['id'];
    $edd = $controller->editDetail($id);//edd = Edit definition Detail   
    // var_dump($edd); 
}

?>
<div class="container">
    <?php if (isset($_SESSION['success'])) { ?>
        <div class="alert alert-success" role="alert">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </div>
    <?php } ?>
    <h1 class="text-center"><?php echo "ກວດສອບຄຳສັບ"; ?></h1>
    <?php if (empty($edd['old_definition']) && empty($old_example)) { ?>
        <form method="POST" action="update_info_vocab/add_definition.php">
            <div class="from-group mt-2">
                <h5 for="vocab">ຄຳສັບ</h5>
                <input type="hidden" name="urole" value="<?php echo $edd["urole"] ?>">
                <input type="hidden" name="user_id" value="<?php echo $edd["user_id"] ?>">
                <input type="hidden" name="edit_id" value="<?php echo $edd["edit_id"] ?>">
                <input type="hidden" name="definition_id" value="<?php echo $edd["definition_id"] ?>">
                <input type="hidden" name="v_id" class="form-control" readonly value="<?php echo $edd["v_id"] ?>">
                <input type="hidden" name="pos_id" class="form-control" readonly value="<?php echo $edd["pos_id"] ?>">
                <input type="text" name="vocab" class="form-control" readonly value="<?php echo $edd["vocabulary"] ?>">
            </div>
            <div class="from-group mt-2">
                <h5 for="pos_name2">ປະເພດຄຳສັບ</h5>
                <input type="text" name="pos_name2" class="form-control" readonly value="<?php echo $edd["pos_name2"] ?>">
            </div>
            <div class="from-group mt-2">
                <h5 for="newD">ຄຳອະທິບາຍໃໝ່</h5>
                <textarea name="newD" class="form-control" readonly><?php echo $edd["new_definition"] ?></textarea>
            </div>
            <div class="from-group mt-2">
                <h5 for="newE">ຕົວຢ່າງໃໝ່</h5>
                <textarea name="newE" class="form-control" readonly><?php echo $edd["new_example"] ?></textarea>
            </div>
            <div class="d-flex justify-content-end my-2">
                <input onclick="return confirm('Do you want to delete this information')" type="submit" name="reject"
                    value="ປະຕິເສດ" class="btn btn-danger btn-sm">
                <input type="submit" name="add_definition" value="ຢືນຍັນ" class="btn btn-success btn-sm mx-2"
                    style="width: 5rem;">
            </div>
        </form>
    <?php } else { ?>
        <form method="POST" action="update_info_vocab/update_definition.php">
            <div class="from-group mt-2">
                <h5 for="vocab">ຄຳສັບ</h5>
                <input type="hidden" name="edit_id" value="<?php echo $edd["edit_id"] ?>">
                <input type="hidden" name="definition_id" value="<?php echo $edd["definition_id"] ?>">
                <input type="hidden" name="v_id" class="form-control" readonly value="<?php echo $edd["v_id"] ?>">
                <input type="hidden" name="pos_id" class="form-control" readonly value="<?php echo $edd["pos_id"] ?>">
                <input type="text" name="old_definition" class="form-control" readonly
                    value="<?php echo $edd["vocabulary"] ?>">
            </div>
            <div class="from-group mt-2">
                <h5 for="pos_name2">ປະເພດຄຳສັບ</h5>
                <input type="text" name="pos_name2" class="form-control" readonly value="<?php echo $edd["pos_name2"] ?>">
            </div>
            <div class="from-group mt-2">
                <h5 for="oldD">ຄຳອະທິບາຍເກົ່າ</h5>
                <textarea name="oldD" class="form-control" readonly><?php echo $edd["old_definition"] ?></textarea>
            </div>
            <div class="from-group mt-2">
                <h5 for="oldE">ຕົວຢ່າງເກົ່າ</h5>
                <textarea name="oldE" class="form-control" readonly><?php echo $edd["old_example"] ?></textarea>
            </div>
            <div class="from-group mt-2">
                <h5 for="newD">ຄຳອະທິບາຍໃໝ່</h5>
                <textarea name="newD" class="form-control" readonly><?php echo $edd["new_definition"] ?></textarea>
            </div>
            <div class="from-group mt-2">
                <h5 for="newE">ຕົວຢ່າງໃໝ່</h5>
                <textarea name="newE" class="form-control" readonly><?php echo $edd["new_example"] ?></textarea>
            </div>
            <div class="d-flex justify-content-end my-2">
                <input onclick="return confirm('Do you want to delete this information')" type="submit" name="reject"
                    value="ປະຕິເສດ" class="btn btn-danger btn-sm">
                <input type="submit" name="update" value="ຢືນຍັນ" class="btn btn-success btn-sm mx-2" style="width: 5rem;">
            </div>
        </form>
    <?php } ?>
</div>
</div>
</body>

</html>