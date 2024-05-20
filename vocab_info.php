<?php
$title = "Lao Dictionary";
require_once "layout/header.php";
require_once "layout/search.php";
require_once "db/config.php";
$result = $controller->infoCharacter();
if (!isset($_GET['id'])) {
  header('location:index.php');
} else {
  $v_id = $_GET['id'];
  $detail = $controller->showDetail($v_id);
  // var_dump($definition_info);
  $infoVocab = $controller->showVocabDetail($v_id);
  $index = 1;
}

?>

<!-- Information Vocabulary -->
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
      <?php if (empty($definition_info) && empty($infoVocab)) { ?>
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
              <div class="me-auto">
                <h5 class="fst-italic text-black-50">ຄຳສັບ:</h5>
                <p class="fw-bold fs-5">
                  <?php echo $infoVocab["vocabulary"]; ?>
                </p>
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
                <p class="fw-bold me-auto">
                  <?php echo ($key + 1) . ": " . $definition["definition"]; ?>
                </p>
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