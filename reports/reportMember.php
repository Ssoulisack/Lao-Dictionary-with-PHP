<?php
$title = "reportVocab";
require_once "../db/config.php";
require_once "header_report.php";
require_once __DIR__ . "/../vendor/autoload.php";

$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/tmp',
    ]),
    'fontdata' => $fontData + [
        'NotoSerifLao' => [
            'th' => 'NotoSerifLao-Thin.ttf',
            'R' => 'NotoSerifLao-Regular.ttf',
            'B' => 'NotoSerifLao-Bold.ttf',
            'L' => 'NotoSerifLao-Light.ttf',
        ]
    ],
    'default_font' => 'NotoSerifLao-Thin'
]);
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
$vocabInfo = $reports->reportMember($start, $end);
$vocabInfo->execute();
$index = 1;
?>
<main class="container">
    <section id="date">
        <div>
            <div class="text-end my-2">
                <a href="reportVocab.pdf" target="_blank" class="btn btn-primary rounded-3">ດາວໂຫຼດລາຍງານ</a>
            </div>
            <form action="" method="POST" class="text-end">
                <input type="date" class="border border-dark-subtle text-secondary p-1 rounded-3" name="date-start"
                    id="start" value="<?php echo $start; ?>">
                <input type="date" class="border border-dark-subtle text-secondary p-1 rounded-3" name="date-end"
                    id="end" value="<?php echo $end; ?>">
                <input type="submit" class="btn btn-secondary btn-sm rounded-4" value="ເລືອກວັນທີ">
            </form>
        </div>

    </section>
    <?php ob_start(); ?>
    <style>
        .header{
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            font-style: normal;
            font-weight: normal;
        }
        table, td, th {
            border: 1px solid #ddd;
            text-align: center;
        }
        table{
            border-collapse: collapse;
            width: 100%;
        }
        .th-title{
            font-weight: 400;
            font-style: light;
            padding: 8px;
        }
        .content-row{
            font-weight: 300;
            padding: 0 5px 0 5px;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
    <div class="header">
        <div class="title-header">
            <p class="title-header">ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ</p>
            <p class="title-header">ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດຖະນາຖາວອນ</p>
        </div>
        <div class="title-header">
            <div class="title-header">
                <img src="../asset/image/SIT-LOGO.png" alt="logo" width="100px">
                <p class="">ສະຖາບັນ ເຕັກໂນໂລຊີ ສຸດສະກະ</p>
                <p class="report" style="font-size: 20px;">ລາຍງານຄຳສັບ</p>
            </div>
        </div>
    </div>
        <div class="body">
            <table class="table-vocab">
                <thead>
                    <tr class="table-row " style="font-family: 'NotoSerifLao-Light normal';">
                        <th class="th-title">ລຳດັບ</th>
                        <th class="th-title">ຊື່ຜູ້ໃຊ້</th>
                        <th class="th-title">ອີເມວ</th>
                        <th class="th-title">ຊື່ ແລະ ນາມສະກຸນ</th>
                        <th class="th-title">ເບີໂທ</th>
                        <th class="th-title">ທີ່ຢູ່</th>
                        <th class="th-title">ວັນທີລົງທະບຽນ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $vocabInfo->fetch(PDO::FETCH_ASSOC)) {
                        $time = $row['date'];
                        $date = explode(' ', $time)[0]; // Extract the date part
                        $uppercaseLastname = strtoupper($row['lastname']);
                        ?>
                        <tr class="content">
                            <th class="number-row" style="font-family: 'Times New Roman, Times, serif'; font-weight: 400;"><?php echo $index++; ?></th>
                            <td class="content-row" style="font-family: 'Times New Roman, Times, serif'; font-weight: 100;"><?php echo $row['username']?></td>
                            <td class="content-row" style="font-family: 'Times New Roman, Times, serif'; font-weight: 100;"><?php echo $row['email'] ?></td>
                            <td class="content-row"><?php echo $row['firstname'] .' '. $uppercaseLastname; ?></td>
                            <td class="content-row" style="font-family: 'Times New Roman, Times, serif'; font-weight: 100;"><?php echo $row['telephone'] ?></td>
                            <td class="content-row"><?php echo $row['address'] ?></td>
                            <td class="content-row" style="font-family: 'Times New Roman, Times, serif'; font-weight: 400;"><?php echo $date; // Output the date only ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php
    $html = ob_get_contents();
    $mpdf->WriteHTML($html);
    $mpdf->Output("reportVocab.pdf");
    ob_end_flush();
    ?>
    </body>

    </html>
</main>
</body>

</html>