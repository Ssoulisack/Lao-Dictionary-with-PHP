<?php
$title = "ເພີ່ມຄຳອະທິບາຍສັບ";
require_once "../db/config.php";
require_once "header_vocab_manage.php";
$result_pos = $controller->infoPos();
if (!isset($_GET['id'])) {
    header('location:homePage.php');
  } else {
    $definition_id = $_GET['id'];
    $details = $controller->showDetails($definition_id);
  }
?>
<div class="container-md shadow p-4 mt-4 rounded-3">
    <form action="add_info.php" method="POST">
        <h1 class="text-center"><?php echo "ເພີ່ມຄຳອະທິບາຍ"; ?></h1>
        <div class="from-group">
            <label for="vocab">ຄຳສັບ</label>
            <input type="hidden" name="definition_id" class="form-control" value="<?php echo $details["definition_id"] ?>">
            <input type="hidden" name="v_id" class="form-control" value="<?php echo $details["v_id"] ?>">
            <input type="text" name="vocabulary" class="form-control" readonly value="<?php echo $details["vocabulary"] ?>">
        </div>
        <div class="from-group">
            <label for="definition">ຄຳອະທິບາຍສັບ</label>
            <textarea name="new_definition" class="form-control" placeholder="ປ້ອນຄຳອະທິບາຍທີ່ທ່ານຕ້ອງການເພີ່ມ"></textarea></textarea>
        </div>
        <div class="from-group">
            <label for="example">ຕົວຢ່າງປະໂຫຍກ</label>
            <textarea name="new_example" class="form-control" placeholder="ປ້ອນຕົວຢ່າງທີ່ທ່ານຕ້ອງການເພີ່ມ"></textarea>
        </div>
        <div class="from-group">
            <label for="pos">ປະເພດຄຳສັບ</label>
            <select name="pos_id" class="form-control">
                <?php while ($row = $result_pos->fetch(PDO::FETCH_ASSOC)) { ?>
                    <option value="<?php echo $row["pos_id"] ?>"><?php echo $row["pos_name2"] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="d-flex justify-content-end">
            <a href="vocab_info_login.php?id=<?php echo $details["v_id"] ?>" name="cancel" class="btn btn-secondary btn-sm my-2 mx-2">Cancel</a>
            <input type="submit" name="submit" value="add" class="btn btn-primary btn-sm my-2">
        </div>
    </form>
</div>
</body>

</html>