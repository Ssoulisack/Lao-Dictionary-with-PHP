<?php
$title = "ລາຍລະອຽດກະທູ້";
require_once "../db/config.php";
require_once "headerQA.php";
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
    <!-- Comment -->
    <hr>
    <div class="comment">
        <form action="" method="post">
            <div class="d-flex flex-column">
                <label for="comment" class="fs-5">ຕອບກະທູ້:</label>
                <textarea name="comment" id="" class="form-control"></textarea>
            </div>
            <div class="d-flex justify-content-end">
                <input type="submit" name="submit" class="btn btn-primary my-2" value="ສະແດງຄຳຄິດເຫັນ">
            </div>
        </form>
    </div>
</main>
</body>

</html>