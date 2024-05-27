<?php
$title = "ລາຍລະອຽດກະທູ້";
require_once "db/config.php";
require_once "layout/header.php";
if (isset($_GET['id'])) {
    $id = $_GET['id']; //question_id
    $questionDetail = $question->questionDetail($id);
    // print_r($questionDetail);
}
?>
<main class="container-fluid px-5">
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="bi bi-caret-right h3"> ກະທູ້ຄຳຖາມກ່ຽວກັບພາສາລາວ</i></h1>
    </div>
    <hr>
    <div class=" text-center bg-light rounded-3 p-2 my-3">
        <h2 class="lh-sm fw-bolder text-wrap"><?php echo $questionDetail['title']; ?></h2>
    </div>
    <div class="border p-2 my-3 rounded-1">
        <h5 class="lh-lg text-wrap"><span class="me-3"
                style='font-size:30px;'>&#9755;</span><?php echo $questionDetail['content']; ?>
        </h5>
        <hr>
        <span class="">ເຈົ້າຂອງກະທູ້: <?php echo $questionDetail['username'] ?></span>
        <br>
        <span class="">ເວລາ: <?php echo $questionDetail['create_at'] ?></span>
    </div>
</main>
</body>

</html>