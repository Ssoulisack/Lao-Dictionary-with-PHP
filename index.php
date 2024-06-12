<?php
$title = "Lao Dictionary";
require_once "layout/header.php";
require_once "layout/search.php";
require_once "db/config.php";
$result = $controller->infoCharacter();
$getPos = $controller->getPos();
if (isset($_POST["search"])) {
  $vocab = $_POST["vocab"];
  $detail = $controller->searchVocab($vocab);
}
$nr_of_rows = $question->questionNumRows();
// Setting the number of rows to display in a page.
$rows_per_page = 5;

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

<!-- SEARCH WITH ALPHABET AND RESULT -->
<main class="container">
  <nav id="search ">
    <div class="row my-3">
      <hr>
      <form action="" method="GET">
        <h5 class="text-center">ຄົ້ນຫາຕາມໝວດໝູ່ພະຍັນຊະນະ</h5>
        <div class="row my-2 mx-auto">
          <?php foreach ($result as $row) { ?>
            <div class="col-2 col-md-1 col-lg-1  fs-4 ">
              <a href="character_info.php?id=<?php echo $row['character_id'] ?>"
                class="nav-link"><?php echo $row['characters']; ?></a>
            </div>
          <?php } ?>
        </div>
    </div>
    </form>
  </nav>

  <section id="allVocab">
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="question-tab" data-bs-toggle="tab" data-bs-target="#question" type="button"
          role="tab" aria-controls="question" aria-selected="true">ກະທູ້</button>
        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button"
          role="tab" aria-controls="nav-profile" aria-selected="false">ປະເພດຄຳສັບ</button>
        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button"
          role="tab" aria-controls="nav-contact" aria-selected="false">ອັບເດດຄຳສັບ</button>
      </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane fade show active" id="question" role="tabpanel" aria-labelledby="question-tab" tabindex="0">
        <div class="mt-2 rounded-2 d-flex justify-content-center  align-items-center" style="background-color: #458ae4">
          <h1><i class="bi bi-caret-right text-light h3">ກະທູ້ຄຳຖາມ</i></h1>
        </div>
        <hr>
        <?php while ($result = $results->fetch(PDO::FETCH_ASSOC)) { ?>
          <div class="border rounded-2 p-2 my-3">
            <a class="nav-link fs-5"
              href="questionDetail.php?id=<?php echo $result['q_id'] ?>"><?php echo $result['title']; ?></a>
          </div>
        <?php } ?>
        <!-- pagination -->
        <?php if($pages == 0){ ?>
          <h3 class="text-center text-warning">No question</h3>
        <?php }else{?>
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
          <?php }?>
      </div>
    </div>
    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
      <!-- show part of speech -->
      <div class="bg-secondary d-flex justify-content-center align-items-center rounded-2 p-1 my-3">
        <h3 class="mt-2 text-light">ປະເພດຄຳສັບໃນພາສາລາວ</h3>
      </div>
      <table class="table">
        <thead>
          <tr class="ps-2">
            <th class="fw-bold fs-5" scope="col">ປະເພດຄຳສັບ</th>
            <th class="fw-bold fs-5" scope="col">ຕົວອັກສອນຫຍໍ້</th>
            <th class="fw-bold fs-5" scope="col">ຄຳອະທິບາຍ</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $getPos->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr class="">
              <th class="" scope="row"><?php echo '-' . $row['pos_name2'] . ', ' . $row['pos_name1'] . '.' ?></th>
              <td class="text-center"><?php echo $row['short_name'] ?></td>
              <td class=""><?php echo $row['description'] ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
      <!-- Show edit vocab -->
    </div>
  </section>
</main>
<!-- RESULT -->

</body>

</html>