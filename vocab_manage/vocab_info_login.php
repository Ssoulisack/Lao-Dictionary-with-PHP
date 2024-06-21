<?php
$title = "Lao Dictionary";
require_once "header_vocab_manage.php";
require_once "search_vocab_login.php";
require_once "../db/config.php";
if (isset($_GET['id'])) {
  $v_id = $_GET['id']; // question_id
} elseif (isset($_POST['v_id'])) {
  $v_id = $_POST['v_id']; // question_id from POST request
}else{
  header('location:../homePage.php');
}
if ($v_id) {
  $detail = $controller->showDetail($v_id);
  // var_dump($definition_info);
  $infoVocab = $controller->showVocabDetail($v_id);
  $index = 1;
} 

if (isset($_POST['editVocab'])) { //Method edit vocab =.
  $old_vocab = $_POST['old_vocab'];
  $new_vocab = $_POST['new_vocab'];
  $v_id = $_POST['v_id'];
  $user_id = $_SESSION['id'];
  $username = $_SESSION['username'];
  $urole = $_SESSION['urole'];
  $status = 'pending';
  $editVocab = $controller->editVocab($old_vocab, $new_vocab, $v_id, $user_id, $username, $urole, $status);
  if ($editVocab) {
    $_SESSION["warning"] = "ຄຳຂໍແກ້ໄຂຄຳສັບຢູ່ໃນຂັ້ນຕອນການກວດສອບ";
  } else {
    $_SESSION["error"] = "ຂໍ້ມູນບໍ່ຖືກຕ້ອງ";
  }
}


?>

<!-- Information vocab -->
<section id="Information">
  <div class="container my-3">
    <div class="row">
      <h4 class="text-center">ສະແດງຜົນການຄົ້ນຫາ</h4>
      <?php if (isset($_SESSION['warning'])) { ?>
        <div class="alert alert-warning" role="alert">
          <?php
          echo $_SESSION['warning'];
          unset($_SESSION['warning']);
          ?>
        </div>
      <?php } ?>
      <?php if (isset($_SESSION['error'])) { ?>
        <div class="alert alert-danger" role="alert">
          <?php
          echo $_SESSION['error'];
          unset($_SESSION['error']);
          ?>
        </div>
      <?php } ?>
      <?php if (empty($detail) && empty($infoVocab)) { ?>
        <?php $_SESSION['error'] = 'ບໍ່ມີຂໍ້ມູນຄຳສັບນີ້'; ?>
        <div id="vocab_info" class="alert alert-secondary">
          <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger" role="alert">
              <?php
              echo $_SESSION['error'];
              unset($_SESSION['error']);
              ?>
            </div>
          </div>
        <?php } ?>
      <?php } else { ?>
        <div class="col">
          <div id="vocab_info" class="alert alert-secondary col">
            <div class="d-flex flex-row-reverse justify-content-between">
              <div class="">
                <a href="#edit_vocab<?php echo $infoVocab["v_id"]; ?>" data-bs-toggle="modal">
                  <button type="button" class="btn btn-primary"><i class="bi bi-pencil-square"></i> </button>
                </a>
              </div>
              <div class="">
                <h5 class="fst-italic text-black-50">ຄຳສັບ:</h5>
                <p class="fw-bold fs-5">
                  <?php echo $infoVocab["vocabulary"]; ?>
                </p>
              </div>
            </div>
            <!-- Modal Edit VOCAB -->
            <div id="edit_vocab<?php echo $infoVocab['v_id']; ?>" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                  <form method="post" class="form-horizontal" role="form">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">ແກ້ໄຂຄຳສັບ</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3 row">
                        <label for="vocab_name" class="">ຄຳສັບ:</label>
                        <div class="">
                          <input type="hidden" class="form-control" id="v_id" name="v_id"
                            value="<?php echo $infoVocab['v_id']; ?>">
                          <input type="hidden" class="form-control" id="old_vocab" name="old_vocab"
                            value="<?php echo $infoVocab['vocabulary']; ?>">
                          <input type="text" class="form-control" id="new_vocab" name="new_vocab"
                            value="<?php echo $infoVocab['vocabulary']; ?>">
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ຍົກເລີກ</button>
                      <button type="submit" class="btn btn-primary" name="editVocab">ແກ້ໄຂຄຳສັບ</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- ========DEFINITION & POS==========-->
            <hr>
            <h5 class="fst-italic text-black-50">ປະເພດ</h5>
            <div class="d-flex flex-row">
              <?php foreach ($detail as $key => $value) { ?>
                <p class="fw-bold">
                  <?php echo ($key + 1) . ": " . $value["pos_name2"] . "."; ?>
                </p>
              <?php } ?>
            </div>

            <h5 class="fst-italic text-black-50">ນິຍາມຄວາມໝາຍຂອງຄຳສັບ</h5>
            <?php foreach ($detail as $key => $definition) { ?>
              <div class="d-flex align-items-center">
                <p class="fw-bold me-auto">
                  <?php echo ($key + 1) . ": " . $definition["definition"]; ?>
                </p>
                <input type="hidden" name="id" value="<?php echo $definition['definition_id'] ?>">
                <input type="hidden" name="definition" value="<?php echo $definition['definition'] ?>">
                <input type="hidden" name="example" value="<?php echo $definition['example'] ?>">
                <input type="hidden" name="pos_id" value="<?php echo $definition['pos_id'] ?>">
                <input type="hidden" name="vocabulary" value="<?php echo $definition['vocabulary'] ?>">
                <a href="add_infoFrom.php?id=<?php echo $definition['definition_id'] ?>" class="btn btn-sm">
                  <i class="bi bi-plus-square"></i>
                </a>
                <a href="edit_infoForm.php?id=<?php echo $definition['definition_id'] ?>" class="btn btn-sm">
                  <i class="bi bi-pencil-square"></i>
                </a>
              </div>
            <?php } ?>

            <!--=========EXAMPLE===========-->
            <h5 class="fst-italic text-black-50">ຕົວຢ່າງປະໂຫຍກ</h5>
            <?php foreach ($detail as $key => $example) { ?>
              <?php if (empty($example['example'])) { ?>
                <div class="d-flex">
                  <p class='fw-bold text-danger fs-5 me-auto'>
                    <?php echo ($key + 1) . ": " .
                      "ບໍ່ມີຕົວຢ່າງປະໂຫຍກນີ້" ?>
                  </p>
                </div>
              <?php } else { ?>
                <div class="d-flex">
                  <p class="fw-bold fs-5 me-auto">
                    <?php echo ($key + 1) . ": " . $example["example"]; ?>
                  </p>
                </div>
              <?php } ?>
            <?php } ?>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</section>
</body>

</html>