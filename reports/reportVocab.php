<?php
$title = "reportVocab";
require_once "../db/config.php";
require_once "header_report.php";

// Set default date values
$defaultStart = '2024-05-10';
$defaultEnd = '2024-05-24';

// Check if form is submitted and get the dates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['date-start']) && isset($_POST['date-end'])) {
    $start = $_POST['date-start'];
    $end = $_POST['date-end'];
} else {
    // Use default dates if no dates are selected
    $start = $defaultStart;
    $end = $defaultEnd;
}

// Fetch vocabulary information
$vocabInfo = $reports->reportVocab($start, $end);
$vocabInfo->execute();
$index = 1;
?>
<main class="container">
    <section id="date">
        <form action="" method="POST" class="text-end">
            <input type="date" class="border border-dark-subtle text-secondary p-1 rounded-3" name="date-start" id="start" value="<?php echo $start; ?>">
            <input type="date" class="border border-dark-subtle text-secondary p-1 rounded-3" name="date-end" id="end" value="<?php echo $end; ?>">
            <input type="submit" class="btn btn-secondary btn-sm rounded-4" value="ເລືອກວັນທີ">
        </form>
    </section>
    <div class="header my-4">
        <div>
        </div>
        <div class="text-center">
            <p>ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ</p>
            <p>ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດຖະນາຖາວອນ</p>
        </div>
        <div class="d-flex justify-content-center">
            <div class="text-center">
                <img src="../asset/image/SIT-LOGO.png" alt="logo" width="100px">
                <p class="fw-bold" style="font-size: 15px;">ສະຖາບັນ ເຕັກໂນໂລຊີ ສຸດສະກະ</p>
            </div>
        </div>
        <div id="title" class="mt-4 text-center">
            <h3 class="fw-bold">ລາຍງານຄຳສັບ</h3>
        </div>
        <div class="body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th scope="col">ລຳດັບ</th>
                        <th scope="col">ຄຳສັບ</th>
                        <th scope="col">ປະເພດ</th>
                        <th scope="col">ຄຳອະທິບາຍ</th>
                        <th scope="col">ຕົວຢ່າງປະໂຫຍກ</th>
                        <th scope="col">ເວລາ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $vocabInfo->fetch(PDO::FETCH_ASSOC)) {
                        $time = $row['date'];
                        $date = explode(' ', $time)[0]; // Extract the date part
                        ?>
                        <tr class="">
                            <th class="align-middle text-center" scope="row"><?php echo $index++; ?></th>
                            <td class="col-1 align-middle text-center"><?php echo $row['vocabulary'] ?></td>
                            <td class="col-2 align-middle text-center"><?php echo $row['pos_name2'] ?></td>
                            <td class="col-4"><?php echo $row['definition'] ?></td>
                            <td class="col-3"><?php echo $row['example'] ?></td>
                            <td class="col-2 align-middle text-center"><?php echo $date; // Output the date only ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
</body>
</html>