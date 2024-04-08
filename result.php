<?php
$title = "ຜົນການຄົ້ນຫາຄຳສັບ";

require_once "db/config.php";
require_once "layout/header.php";
require_once "layout/search.php";

if (isset($_POST["search"])) {
  $vocab = $_POST['vocab'];
  if (empty($vocab)) {
    $_SESSION['error'] = 'ກະລຸນາປ້ອນຄຳສັບທີ່ຕ້ອງການຄົ້ນຫາ';
  } else {
    $result = $controller->getVocabInfo($vocab);
    $count = count($result);
    echo $count;
  }
}

?>
<!-- RESULT -->
<section id="result">
  <div class="container my-3">
    <div class="row">
      <h4 class="text-center">ສະແດງຜົນການຄົ້ນຫາ</h4>
      <div id="vocab_info" class="alert alert-secondary d-flex flex-column">
        <?php if (empty($vocab)) { ?>
          <?php if (isset ($_SESSION['error'])) { ?>
        <div class="alert alert-danger" role="alert">
            <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
        </div>
        <?php } ?>
        <?php } else { ?>
          <?php foreach ($result as $row) { ?>
            <label for="">ຄຳສັບ: <p class="">
                <?php echo $row['vocabulary'] ?>
              </p></label>
            <label for="">ປະເພດ: <p class="">
                <?php echo $row['pos_name2'] ?>
              </p></label>
            <label for="">ນິຍາມຄວາມໝາຍຂອງຄຳສັບ: <p class="">
                <?php echo $row['definition'] ?>
              </p></label>
            <label for="">ຕົວຢ່າງປະໂຫຍກ:</label>
            <p class="alert alert-warning">
              <?php echo $row['example'] ?>
            </p>
          <?php } ?>
        <?php } ?>
      </div>
    </div>
  </div>
</section>
</body>

</html>