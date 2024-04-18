<?php
$title = "Lao Dictionary";
require_once "layout/headerLogin.php";
require_once "layout/search.php";
require_once "db/config.php";
$result = $controller->infoCharacter();
if (!isset($_GET['id'])) {
    header('location:index.php');
} else {
    $vocab_id = $_GET['id'];
    $vocabulary = $controller->showDetail($vocab_id);
}

?>

<!-- Information Vocabulary -->
<section id="Information">
  <div class="container my-3">
    <div class="row">
      <h4 class="text-center">ສະແດງຜົນການຄົ້ນຫາ</h4>
      <div id="vocab_info" class="alert alert-secondary d-flex flex-column">
        <?php if (empty($vocabulary)) { ?>
          <?php if (isset ($_SESSION['error'])) { ?>
        <div class="alert alert-danger" role="alert">
            <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
        </div>
        <?php } ?>
        <?php } else { ?>
          <?php foreach ($vocabulary as $row) { ?>
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