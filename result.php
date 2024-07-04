<?php
$title = "ຜົນການຄົ້ນຫາຄຳສັບ";

require_once "db/config.php";
require_once "layout/header.php";
require_once "layout/search.php";

if (isset($_POST["search"])) {
  $vocab = $_POST['vocab'];
  $numRows = $controller->searchNumVocab($vocab);
  if (empty($vocab)) {
    $_SESSION['error'] = 'ກະລຸນາປ້ອນຄຳສັບທີ່ຕ້ອງການຄົ້ນຫາ';
  } elseif ($numRows == 0) {
    $_SESSION['warning'] = 'ຂໍອະໄພ, ບໍ່ພົບຄຳສັບນີ້ໃນລະບົບ';
  } else {
    $result = $controller->searchVocab($vocab);
  }
}

?>
<!-- RESULT -->
<section id="result">
  <div class="container my-3">
    <div class="row">
      <?php if (empty($vocab) || $numRows < 1) { ?>
        <?php if (isset($_SESSION['error'])) { ?>
          <div class="alert alert-danger" role="alert">
            <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
          </div>
        <?php } ?>
        <?php if (isset($_SESSION['warning'])) { ?>
          <div class="alert alert-warning" role="alert">
            <?php
            echo $_SESSION['warning'];
            unset($_SESSION['warning']);
            ?>
          </div>
        <?php } ?>
      <?php } else { ?>
        <h4 class="text-center text-primary">ສະແດງຜົນການຄົ້ນຫາ <?php echo $numRows . ' ຄຳສັບ' ?></h4>
        <?php foreach ($result as $row) { ?>
          <ul class="list-group col-4 col-lg-3">
            <li class="nav-link">
              <a href="vocab_info.php?id=<?php echo $row['v_id'] ?>" class="nav-link my-2">
                <h4><?php echo $row["vocabulary"] ?></h4>
              </a>
            </li>
          </ul>
        <?php } ?>
      <?php } ?>
    </div>
  </div>
</section>
</body>

</html>