<?php
$title = "homePage";
require_once "layout/headerLogin.php";
require_once "db/config.php";
require_once "layout/checkLogin.php";
require_once "layout/searchLogin.php";
$result = $controller->infoCharacter();
if (isset($_POST["search"])) {
  $vocab = $_POST["vocab"];
  $detail = $controller->getVocabInfo($vocab);
}

?>

<!-- SEARCH WITH ALPHABET AND RESULT -->
<main id="search">
  <div class="container">
    <div class="row my-3">
      <hr>
      <form action="" method="GET">
        <h5 class="text-center">ຄົ້ນຫາຕາມໝວດໝູ່ພະຍັນຊະນະ</h5>
        <div class="row my-2 mx-auto">
          <?php foreach ($result as $row) { ?>
            <div class="col-2 col-md-1 col-lg-1  fs-4 ">
              <a href="character_info_login.php?id=<?php echo $row['character_id'] ?>"
                class="nav-link"><?php echo $row['characters']; ?></a>
            </div>
          <?php } ?>
        </div>
    </div>
    </form>
  </div>
</main>

</body>

</html>