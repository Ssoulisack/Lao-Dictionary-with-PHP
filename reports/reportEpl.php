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
    'mode' => 'utf-8',
    'format' => [210, 297],
    'orientation' => 'P',
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
$defaultStart = '2024-04-01';
date_default_timezone_set('Asia/Vientiane'); // Set the timezone to Laos
$defaultEnd = date('Y-m-d');

// Check if form is submitted and get the dates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['date-start']) && isset($_POST['date-end'])) {
    $start = $_POST['date-start'];
    $end = $_POST['date-end'];
} else {
    // Use default dates if no dates are selected
    $start = $defaultStart;
    $end = $defaultEnd;
}

$eplNumRow = $reports->eplNumRows();
// Setting the number of rows to display in a page.
$rows_per_page = 30;

// calculating the number of pages.
$pages = ceil($eplNumRow / $rows_per_page);

// Setting the start from value.
$pageStart = 0;  // Use a different name to avoid confusion with the date variable $start

// If the user clicks on the pagination buttons.
if (isset($_GET['page_nr'])) {
    $page = $_GET['page_nr'] - 1;
    $pageStart = $page * $rows_per_page;
} else {
    $page = 1 - 1;
}

// Fetch vocabulary information
$eplReport = $reports->reportEpl($start, $end, $pageStart, $rows_per_page);

if ($eplReport) {
    $index = $page * $rows_per_page + 1;
} else {
    echo "Failed to retrieve vocabulary information.";
}
?>
<main class="container">
    <section id="date">
        <div>
            <div class="text-end my-2">
                <a href="report.pdf" target="_blank" class="btn btn-primary rounded-3">ດາວໂຫຼດລາຍງານ</a>
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
    <html>

    <head>
        <link href="styleMember.css" rel="stylesheet">
    </head>

    <body>
    <div class="header">
        <div class="slogan">
            <p class="text">ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ</p>
            <p class="text">ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດຖະນາຖາວອນ</p>
        </div>
        <div class="title">
            <div class="institute">
                <div class="logo-ins">
                    <img src="../asset/image/SIT-LOGO.png" alt="logo" width="100px">
                </div>
                <div class="ins">
                    <p class="name-ins text">ສະຖາບັນ ເຕັກໂນໂລຊີ ສຸດສະກະ</p>
                </div>
            </div>
            <div class="report-title">
                <p class="text-report">ລາຍງານຜູ້ຊ່ຽວຊານ</p>
            </div>
        </div>
    </div>
    <div class="body">
        <table class="table-report">
            <thead>
                <tr class="table-title">
                    <th class="head number">#</th>
                    <th class="head username">ຊື່ຜູ້ໃຊ້</th>
                    <th class="head email">ອີເມວ</th>
                    <th class="head name">ຊື່ ແລະ ນາມສະກຸນ</th>
                    <th class="head tel">ເບີໂທ</th>
                    <th class="head address">ທີ່ຢູ່</th>
                    <th class="head date">ວັນທີລົງທະບຽນ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 1;
                while ($row = $eplReport->fetch(PDO::FETCH_ASSOC)) {
                    $time = $row['date'];
                    $date = explode(' ', $time)[0]; // Extract the date part
                ?>
                    <tr class="content">
                        <th scope="row" class="number"><?php echo $index++; ?></th>
                        <td class="username"><?php echo $row['username'] ?></td>
                        <td class="email"><?php echo $row['email'] ?></td>
                        <td class="name"><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                        <td class="tel"><?php echo $row['telephone'] ?></td>
                        <td class="address"><?php echo $row['address'] ?></td>
                        <td class="date"><?php echo $date; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </body>

    </html>
    <?php
    $stylesheet = file_get_contents('styleMember.css');
    $html = ob_get_contents();
    // ob_end_clean();
    ob_end_flush();
    $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output("report.pdf");
    ?>
</main>

<!-- pagination -->
<nav aria-label="Page navigation" style="margin-top: 2rem;">
    <!-- Display the page info text -->
    <div class="d-flex justify-content-center">
        <?php if (!isset($_GET['page_nr'])) { ?>
            <?php $page = 1; ?>
        <?php } else { ?>
            <?php $page = $_GET['page_nr']; ?>
        <?php } ?>
        <p>showing <?php echo $page; ?> of <?php echo $pages; ?></p>
    </div>
    <ul class="pagination justify-content-center">
        <!-- Go to the first page -->
        <li class="page-item"><a class="page-link" href="?page_nr=1">First</a></li>
        <!-- Go to the previous page -->
        <li class="page-item">
            <?php if (isset($_GET['page_nr']) && $_GET['page_nr'] > 1) { ?>
                <a class="page-link" href="?page_nr=<?php echo $_GET['page_nr'] - 1 ?>">Previous</a>
                <?php
            } else { ?>
                <a class="page-link">Previous</a>
            <?php } ?>
        </li>
        <?php if (!isset($_GET['page_nr'])) { ?>
            <li class="page-item"><a class="page-link active" href="?page_nr=1">1</a>
                <?php $count_from = 2; ?></li>
        <?php } else { ?>
            <?php $count_from = 1; ?>
        <?php } ?>
        <?php for ($num = $count_from; $num <= $pages; $num++) { ?>
            <?php if ($num == @$_GET['page_nr']) { ?>
                <li class="page-item"><a class="page-link active" href="?page_nr=<?php echo $num; ?>"><?php echo $num; ?></a>
                </li>
            <?php } else { ?>
                <li class="page-item"><a class="page-link " href="?page_nr=<?php echo $num; ?>"><?php echo $num; ?></a>
                </li>
            <?php } ?>
        <?php } ?>

        <!-- Go to the next page -->
        <?php
        if (isset($_GET['page_nr'])) { ?>
            <?php if ($_GET['page_nr'] >= $pages) { ?>
                <li class="page-item"><a class="page-link" href="">Next</a></li>
            <?php } else { ?>
                <li class="page-item"><a class="page-link" href="?page_nr=<?php echo $_GET['page_nr'] + 1; ?>">Next</a>
                </li>
            <?php } ?>
        <?php } else { ?>
            <li class="page-item"><a class="page-link" href="?page_nr=2">Next</a></li>
        <?php } ?>
        <!-- Go to the Last page -->
        <li class="page-item"><a class="page-link" href="?page_nr=<?php echo $pages; ?>">Last</a></li>
    </ul>
</nav>
</body>

</html>
</main>
</body>

</html>