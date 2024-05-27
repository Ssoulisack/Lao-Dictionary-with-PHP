<?php
$title = "Registration";
require_once "db/config.php";
require_once "layout/header.php";
$nr_of_rows = $question->questionNumRows();
// Setting the number of rows to display in a page.
$rows_per_page = 4;

// calculating the nr of pages.
$pages = ceil($nr_of_rows / $rows_per_page);
// Setting the start from, value.
$start = 0;
// If the user clicks on the pagination buttons.
if (isset($_GET['page_nr'])) {
    $page = $_GET['page_nr'] - 1;
    $start = $page * $rows_per_page;
}
$results = $question->showQuestions($start, $rows_per_page);
?>
<main class="container-fluid px-5">
            <div class="d-flex justify-content-between align-items-center">
            <h1><i class="bi bi-caret-right h3"> ກະທູ້ຄຳຖາມກ່ຽວກັບພາສາລາວ</i></h1>
        </div>
        <hr>
        <?php while ($result = $results->fetch(PDO::FETCH_ASSOC)) { ?>
            <div class="border rounded-2 p-2 my-3">
                <a class="nav-link fs-5" href="questionDetail.php?id=<?php echo $result['q_id'] ?>"><?php echo $result['title']; ?></a>
            </div>
        <?php } ?>
        <!-- pagination -->
        <nav aria-label="Page navigation">
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
                        <li class="page-item"><a class="page-link active"
                                href="?page_nr=<?php echo $num; ?>"><?php echo $num; ?></a></li>
                    <?php } else { ?>
                        <li class="page-item"><a class="page-link " href="?page_nr=<?php echo $num; ?>"><?php echo $num; ?></a></li>
                    <?php } ?>
                <?php } ?>

                <!-- Go to the next page -->
                <?php
                if (isset($_GET['page_nr'])) { ?>
                    <?php if ($_GET['page_nr'] >= $pages) { ?>
                        <li class="page-item"><a class="page-link" href="">Next</a></li>
                    <?php } else { ?>
                        <li class="page-item"><a class="page-link" href="?page_nr=<?php echo $_GET['page_nr'] + 1; ?>">Next</a></li>
                    <?php } ?>
                <?php } else { ?>
                    <li class="page-item"><a class="page-link" href="?page_nr=2">Next</a></li>
                <?php } ?>
                <!-- Go to the Last page -->
                <li class="page-item"><a class="page-link" href="?page_nr=<?php echo $pages; ?>">Last</a></li>
            </ul>
        </nav>
</main>
</body>

</html>