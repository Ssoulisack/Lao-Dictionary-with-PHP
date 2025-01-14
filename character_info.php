<?php
$title = "ໝວດໝູ່ຄຳສັບ";
require_once "layout/header.php";
require_once "layout/search.php";
require_once "db/config.php";

$result = $controller->infoCharacter();
if (!isset($_GET['id'])) {
    header('location:index.php');
} else {
    $character_id = $_GET['id'];
    $vocabulary = $controller->showVocab($character_id);
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
                    <?php while ($row = $result->fetch(PDO::FETCH_ASSOC) ) { ?>
                        <div class="col-3 col-md-1 col-lg-1  fs-4 ">
                            <a href="character_info.php?id=<?php echo $row['character_id'] ?>"
                                class="nav-link"><?php echo $row['characters']; ?></a>
                        </div>
                    <?php } ?>
                </div>
        </div>
        </form>
    </div>
</main>
<hr>
<!-- All Vocabulary -->
<section id="show-vocab">
    <div class="container">
        <form action="" method="POST">
            <div class="row my-2 mx-auto">
                <h4 class="text-center">ຄຳສັບ:</h4>
                <?php while ($row = $vocabulary->fetch(PDO::FETCH_ASSOC)) { ?>
                    <ul class="list-group col-4 col-lg-2 ">
                        <li class="nav-link">
                            <a href="vocab_info.php?id=<?php echo $row['v_id'] ?>"
                                class="nav-link my-2"><h4><?php echo $row["vocabulary"] ?></h4></a>
                        </li>
                    </ul>
                <?php } ?>
            </div>
        </form>
    </div>
</section>
</body>

</html>