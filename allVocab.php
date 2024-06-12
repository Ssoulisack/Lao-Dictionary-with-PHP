<?php
$title = "Registration";
require_once "layout/header.php";
require_once "layout/search.php";
require_once "db/config.php";
$nr_of_rows = $controller->vocabNumrow();
// Setting the number of rows to display in a page.
$rows_per_page = 100;

// calculating the nr of pages.
$pages = ceil($nr_of_rows / $rows_per_page);
// Setting the start from, value.
$start = 0;
// If the user clicks on the pagination buttons.
if (isset($_GET['page_nr'])) {
    $page = $_GET['page_nr'] - 1;
    $start = $page * $rows_per_page;
}
$allVocab = $controller->allVocab($start, $rows_per_page);
?>
<main class="container-fluid px-5">
        <!-- All Vocabulary -->
<section id="show-vocab">
    <div class="">
        <form action="" method="POST">
            <div class="row my-2 mx-auto">
                <h4 class="text-center text-primary"> <?php echo "ຄຳສັບທັງໝົດ: " . $nr_of_rows ." (ຄຳສັບ)"; ?></h4>
                <?php while ($row = $allVocab->fetch(PDO::FETCH_ASSOC)) { ?>
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