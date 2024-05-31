<?php
$title = "ລາຍລະອຽດກະທູ້";
require_once "db/config.php";
require_once "layout/header.php";
if (isset($_GET['id'])) {
    $id = $_GET['id']; //question_id
    $questionDetail = $question->questionDetail($id);
    $comments = $question->showComment($id);
    $commentNr = $question->commentNumRows($id);
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
    <!-- Comment session -->
    <?php if ($commentNr > 0) { ?>
        <div class="border p-2 my-3 rounded-1">
            <?php if (isset($_SESSION['warning'])) { ?>
                <p class="alert alert-warning text-center" role="alert">
                    <?php
                    echo $_SESSION['warning'];
                    unset($_SESSION['warning']);
                    ?>
                </p>
            <?php } ?>
            <h5 class="fw-bold ms-2"><?php echo $commentNr ?> ຄຳຄິດເຫັນ</h5>
            <div id="comments-section">
                <?php
                $commentsArray = [];
                $repliesArray = [];

                // Organize comments and replies
                while ($comment = $comments->fetch(PDO::FETCH_ASSOC)) {
                    if ($comment['r_id'] == 0) {
                        // It's a main comment
                        $commentsArray[$comment['c_id']] = $comment;
                    } else {
                        // It's a reply
                        $repliesArray[$comment['r_id']][] = $comment;
                    }
                }

                // Display comments and their replies
                foreach ($commentsArray as $comment) {
                    $ct = $comment['content'];
                    $contents = nl2br(htmlspecialchars($ct, ENT_QUOTES, 'UTF-8'));
                    $content = str_replace('<br />', '', $contents);
                    $commentId = $comment['c_id'];
                    $replyCount = isset($repliesArray[$commentId]) ? count($repliesArray[$commentId]) : 0;
                    ?>
                    <div class="mt-2 comment-box">
                        <div class="comment-header dropdown">
                            <p class="fw-bold username text-primary"><?php echo $comment['username'] ?></p>
                        </div>
                        <div class="comment-body">
                                <p class="comment-content"><?php echo $content ?></p>
                        </div>
                        <div class="comment-actions">
                            <span class="text-muted">ເວລາ: </span>
                            <span class="text-muted time" data-time=" <?php echo $comment['create_at']; ?>"></span>
                        </div>
                    </div>
                    <!-- Display replies for this comment -->
                    <div class="ms-4 replies" id="replies-<?php echo $comment['c_id']; ?>">
                        <?php if (isset($repliesArray[$comment['c_id']])) {
                            foreach ($repliesArray[$comment['c_id']] as $reply) {
                                $rt = $reply['content'];
                                $replyContents = nl2br(htmlspecialchars($rt, ENT_QUOTES, 'UTF-8'));
                                $replyContent = str_replace('<br />', '', $replyContents);
                                ?>
                                <div class="mt-2 reply-box">
                                    <div class="comment-header dropdown">
                                        <p class="fw-bold username fw-bold"><?php echo $reply['username']; ?></p>
                                    </div>
                                    <div class="comment">
                                        <p class="comment-content"><?php echo $replyContent; ?></p>
                                    </div>
                                    <div class="comment-actions">
                                        <span class="text-muted">ເວລາ: </span>
                                        <span class="text-muted time" data-time="<?php echo $reply['create_at']; ?>"></span>
                                    </div>
                                </div>
                                <?php
                            }
                        } ?>
                    </div>
                    <?php if ($replyCount > 0) { ?>
                        <button class="toggle-replies"
                            onclick="toggleReplies(<?php echo $comment['c_id']; ?>, <?php echo $replyCount; ?>)">View
                            <?php echo $replyCount; ?> replies</button>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

    <script>
         //Set format time
    function timeSince(date) {
        const now = new Date();
        const past = new Date(date);
        const secondsPast = Math.floor((now - past) / 1000);

        if (secondsPast < 60) {
            return `${secondsPast}ວິນາທີກ່ອນ`;
        }
        if (secondsPast < 3600) {
            const minutes = Math.floor(secondsPast / 60);
            return `${minutes}ນາທີກ່ອນ`;
        }
        if (secondsPast < 86400) {
            const hours = Math.floor(secondsPast / 3600);
            return `${hours} ຊົ່ວໂມງກ່ອນ`;
        }
        const days = Math.floor(secondsPast / 86400);
        return `${days}ມື້ກ່ອນ`;
    }

    document.addEventListener('DOMContentLoaded', (event) => {
        document.querySelectorAll('.time').forEach(span => {
            const time = span.getAttribute('data-time');
            span.textContent = timeSince(time);
        });
    });

        //toggle reply box
        function toggleReplies(commentId, replyCount) {
        const replies = document.getElementById(`replies-${commentId}`);
        const toggleButton = document.querySelector(`button[onclick="toggleReplies(${commentId}, ${replyCount})"]`);
        if (replies.style.display === 'none' || replies.style.display === '') {
            replies.style.display = 'block';
            toggleButton.textContent = 'Hide replies';
        } else {
            replies.style.display = 'none';
            toggleButton.textContent = `View ${replyCount} replies`;
        }
    }
    </script>
</main>
</body>

</html>