<?php
$title = "Registration";
require_once "../db/config.php";
require_once "headerQA.php";
?>
<div class="container-md shadow p-4 mt-4 rounded-3">
    <form action="addQuestion.php" method="POST">
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php } ?>
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success text-center" role="alert">
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php } ?>
        <h1 class="h3 text-center mb-3">ຟອມຕັ້ງກະທູ້ຄຳຖາມ</h1>
        <div class="d-flex align-items-center mb-2">
            <h5 class="text-center">ຫົວຂໍ້:</h5>
            <input type="text" class="form-control ms-4 " value="" name="title" placeholder="ຫົວຂໍ້ກະທູ້ຄຳຖາມ">
        </div>
        <hr>
        <h4 class="text-center">ເນື້ອໃນ</h4>
        <div class="d-flex align-items-center mb-2">
            <textarea id="content" name="content" class="form-control ms-4" id="" cols="20" rows="10"></textarea>
        </div>
        <div class="d-flex justify-content-end">
            <input class="btn btn-primary mx-2 py-2 " value="ຢືນຍັນ" type="submit" name="submit">
            <input class="btn btn-secondary  py-2" value="ຍົກເລີກ" type="submit" name="cancel">
        </div>
    </form>
</div>
<script>
    //function Tab textarea
document.getElementById('content').addEventListener('keydown', function(e) {
    if (e.key === 'Tab') {
        e.preventDefault(); // Prevent the default tab behavior

        // Get the cursor position
        let start = this.selectionStart;
        let end = this.selectionEnd;

        // Set the textarea value to: text before cursor + tab + text after cursor
        this.value = this.value.substring(0, start) + '\t' + this.value.substring(end);

        // Move the cursor to the right place after inserting the tab
        this.selectionStart = this.selectionEnd = start + 1;
    }
});
</script>

</body>

</html>