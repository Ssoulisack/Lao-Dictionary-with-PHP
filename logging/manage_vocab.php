<?php
$title = "Lao Dictionary";
require_once "../db/config.php";
require_once "../layout/headerLogin2.php";
$result = $controller->selectPos();
if (isset($_POST['v_add'])) {
    $vocabulary = $_POST['vocabulary'];
    $pos_id = $_POST['pos_id'];
    $user_id = $_SESSION['id'];
    $insert = $controller->insert($vocabulary, $pos_id, $user_id);

    if ($insert) {
        $result = $controller->selectVocab();
        // $definition = $_POST['definition'];
        // $example = $_POST['example'];
        // $v_id = $result['v_id'];
        // $vocab = $result['vocabulary'];
        // $pos_id = $result['pos_id'];
        // $admin_id = $result['admin_id'];
        // $e_id = $result['e_id'];
        // print_r($result);
        // echo $v_id;
        // echo "<br>";
        // echo $vocab;
        // echo "<br>";
        // echo $admin_id;
        // echo "<br>";
        // echo $pos_id;
        // echo "<br>";
        // echo $e_id;
    }
}




?>
<div class="container-md shadow p-4 mt-4 rounded-3">
    <form action="manage_vocab.php" method="POST">
        <h1 class="h3 text-center mb-3">ຟອມແກ້ໄຂຄຳສັບ</h1>
        <input type="hidden" class="mb-3 rounded-3" value="" name="id">

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
            <label for="department">Parts Of Speech</label>
            <select name="pos_id" class="form-control">
                <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
                    <option value="<?php echo $row["pos_id"] ?>">
                        <?php echo $row["pos_name2"] ?>
                    </option>
                <?php } ?>
            </select>
            </select>
        </div>

        <div class="d-flex justify-content-end">
            <button class="btn btn-outline-primary py-2" type="submit" name="v_edit">ແກ້ໄຂຂໍ້ມູນຄຳສັບ</button>
            <?php if ($_SESSION["urole"] == "admin" || $_SESSION["urole"] == "languageExpert") { ?>
                <button class="btn btn-primary mx-2 py-2 " type="submit" name="v_add">ເພີ່ມຄຳສັບ</button>
                <button class="btn btn-secondary  py-2" type="submit" name="v_delete">ລົບຄຳສັບ</button>
            <?php } ?>
        </div>
    </form>
</div>