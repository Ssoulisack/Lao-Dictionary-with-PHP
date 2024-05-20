<?php
$title = "ຜົນການຄົ້ນຫາຄຳສັບ";

require_once "../db/config.php";
require_once "header_vocab_manage.php";
require_once "search_vocab_login.php";

if (isset($_POST["search"])) {
  $vocab = $_POST['vocab'];
  if (empty($vocab)) {
    $_SESSION['error'] = 'ກະລຸນາປ້ອນຄຳສັບທີ່ຕ້ອງການຄົ້ນຫາ';
  } else {
    $result = $controller->searchVocab($vocab);
    // var_dump($result);
  }
}
?>
<!-- RESULT -->
<section id="result">
  <div class="container my-3">
    <div class="row">
      <h4 class="text-center">ສະແດງຜົນການຄົ້ນຫາ</h4>
      <?php if (empty($vocab)) { ?>
        <?php if (isset($_SESSION['error'])) { ?>
          <div class="alert alert-danger" role="alert">
            <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
          </div>
        <?php } ?>
      <?php } else { ?>
        <?php foreach ($result as $row) { ?>
          <ul class="list-group col-4 col-lg-1">
            <li class="nav-link">
              <a href="vocab_info_login.php?id=<?php echo $row['v_id'] ?>"
              class="nav-link my-2"><h4><?php echo $row["vocabulary"];?></h4></a>
            </li>
          </ul>
        <?php } ?>
      <?php } ?>
    </div>
  </div>
</section>
</body>

</html>