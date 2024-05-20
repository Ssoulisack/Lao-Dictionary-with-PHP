<?php
$title = "homePage";
require_once "layout/headerLogin.php";
require_once "db/config.php";
require_once "layout/checkLogin.php";
require_once "layout/searchLogin.php";
$result = $controller->infoCharacter();
if (isset($_POST["search"])) {
  $vocab = $_POST["vocab"];
  $detail = $controller->searchVocab($vocab);
}

?>

<!-- SEARCH WITH ALPHABET AND RESULT -->
<?php if (isset ($_SESSION['error'])) { ?>
        <div class="alert alert-danger text-center" role="alert">
            <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
        </div>
        <?php } ?>
        <?php if (isset ($_SESSION['success'])) { ?>
        <div class="alert alert-success text-center" role="alert">
            <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
        </div>
        <?php } ?>
        <?php if (isset ($_SESSION['warning'])) { ?>
        <div class="alert alert-warning text-center" role="alert">
            <?php
                echo $_SESSION['warning'];
                unset($_SESSION['warning']);
                ?>
        </div>
        <?php } ?>
<main id="search">
  <div class="container">
    <div class="row my-3">
      <hr>
      <form action="" method="GET">
        <h5 class="text-center">ຄົ້ນຫາຕາມໝວດໝູ່ພະຍັນຊະນະ</h5>
        <div class="row my-2 mx-auto">
          <?php foreach ($result as $row) { ?>
            <div class="col-2 col-md-1 col-lg-1  fs-4 ">
              <a href="vocab_manage/character_info_login.php?id=<?php echo $row['character_id'] ?>"
                class="nav-link"><?php echo $row['characters']; ?></a>
            </div>
          <?php } ?>
        </div>
    </div>
    </form>
  </div>
</main>
<!-- RESULT -->

</body>

</html>