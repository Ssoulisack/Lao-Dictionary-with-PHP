<?php
$title = "Lao Dictionary";
require_once "layout/header.php";
require_once "layout/search.php";
require_once "db/config.php";
$result = $controller->infoCharacter();
if (isset($_POST["search"])) {
  $vocab = $_POST["vocab"];
  echo $vocab;

}

?>

<!-- SEARCH WITH ALPHABET AND RESULT -->
<section id="search">
  <div class="container">
    <div class="row my-3">
      <hr>
      <h5 class="text-center">ຄົ້ນຫາຕາມໝວດໝູ່ພະຍັນຊະນະ</h5>
      <div class="row my-2 mx-auto">
        <?php while($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
          <div class="col-2 col-md-1 col-lg-1  fs-4 ">
            <a href="#" class="nav-link">
              <?php echo $row["characters"] ?>
            </a>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</section>
<hr>
<!-- All Vocabulary -->
<section id="show-vocab">

</section>
</body>

</html>