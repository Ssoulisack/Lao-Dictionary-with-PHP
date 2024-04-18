<?php
$title = "Lao Dictionary";
require_once "../db/config.php";
require_once "../layout/headerLogin2.php";
$characters = $controller->infoCharacter();
$result = $controller->infoPos();
if (isset($_POST['v_add'])) {
    $user_id = $_SESSION['id'];
    $vocabulary = $_POST['vocabulary'];
    $character_id = $_POST['character_id'];
    $pos_id = $_POST['pos_id'];
    $definition = $_POST['definition'];
    $example = $_POST['example'];

    if (empty($vocabulary) || empty($definition)) {
        $_SESSION['error'] = 'ກະລຸນາປ້ອນຂໍ້ມູນຄຳສັບ';
    } else {
        $status = $controller->insert($user_id, $vocabulary,$character_id, $pos_id, $definition, $example);
        $_SESSION['success'] = 'ເພີ່ມຄຳສັບສຳເລັດ';
    }
}

?>
<div class="container-md shadow p-4 mt-4 rounded-3">
    <form action="manage_vocab.php" method="POST">
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger" role="alert">
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php } ?>
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success" role="alert">
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php } ?>
        <h1 class="h3 text-center mb-3">ຟອມແກ້ໄຂຄຳສັບ</h1>
        <input type="hidden" class="mb-3 rounded-3" value="<?php echo $_SESSION['id']; ?>" name="id">

        <div class="form-floating mb-2">
            <input type="text" class="form-control" value="" name="vocabulary" placeholder="vocabulary">
            <label for="vocabulary">Vocabulary</label>
        </div>
        <div class="form-floating mb-2">
            <textarea name="definition" class="form-control" id="" cols="30" rows="10"></textarea>
            <label for="definition">ນິຍາມຄຳສັບ</label>
        </div>
        <div class="form-floating mb-2">
            <textarea name="example" class="form-control" id="" cols="30" rows="10"></textarea>
            <label for="example">ຕົວຢ່າງປະໂຫຍກ</label>
        </div>
        <div class="form-group mb-3">
            <label for="department">ໝວດໝູ່ພະຍັນຊະນະ</label>
            <select name="character_id" class="form-control">
                <?php foreach($characters as $row) { ?>
                    <option value="<?php echo $row["character_id"] ?>">
                        <?php echo $row["characters"] ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="department">ປະເພດຄຳສັບ</label>
            <select name="pos_id" class="form-control">
                <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
                    <option value="<?php echo $row["pos_id"]?>">
                        <?php echo $row["pos_name2"] ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="d-flex justify-content-end">
                <input class="btn btn-primary mx-2 py-2 " value="ເພີ່ມຄຳສັບ" type="submit" name="v_add">
                <input class="btn btn-secondary  py-2" value="ຍົກເລີກ" type="submit" name="v_delete">
        </div>
    </form>
</div>