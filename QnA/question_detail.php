<?php
$title = "ລາຍລະອຽດກະທູ້";
require_once "../db/config.php";
require_once "headerQA.php";

if (isset($_GET['id'])) {
    $id = $_GET['id']; // question_id
} elseif (isset($_POST['q_id'])) {
    $id = $_POST['q_id']; // question_id from POST request
}
if ($id) {
    $questionDetail = $question->questionDetail($id);
    $content = $questionDetail['content'];
    $content = nl2br(htmlspecialchars($content, ENT_QUOTES, 'UTF-8'));
    $comments = $question->showComment($id);
    $commentNr = $question->commentNumRows($id);
}
?>

<main class="container-fluid px-5">
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="bi bi-caret-right h3"> ກະທູ້ຄຳຖາມກ່ຽວກັບພາສາລາວ</i></h1>
    </div>
    <div class="bg-light p-2 my-3 rounded-2">
        <form action="deletePost.php" method="post">
            <div class=" text-center bg-light rounded-3 p-2 my-3">
                <h2 class="lh-sm fw-bolder text-wrap text-primary"><?php echo $questionDetail['title']; ?></h2>
            </div>
            <h5 id="content" class="lh-lg text-wrap"><span class="me-3"
                    style='font-size:30px;'>&#9755;</span><?php echo $content; ?>
            </h5>
            <?php if ($questionDetail['user_id'] == $_SESSION['id'] || $_SESSION['urole'] == 'admin' || $_SESSION['urole'] == 'languageExpert') { ?>
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-column border-top p-2 rounded-3">
                        <span class="">ເຈົ້າຂອງກະທູ້: <?php echo $questionDetail['username'] ?></span>
                        <span class="text-muted time" data-time="<?php echo $questionDetail['create_at'] ?>"></span>
                    </div>
                    <div class="align-self-end">
                        <input type="hidden" name="q_id" value="<?php echo $questionDetail['q_id'] ?>">
                        <input onclick="return confirm('ທ່ານຕ້ອງການລົບກະທູ້ນີ້ຫຼືບໍ່')" type="submit" name="deletePost"
                            class="btn btn-secondary btn-sm" value="ລົບກະທູ້">
                    </div>
                </div>
            <?php } else { ?>
                <div class="d-flex flex-column">
                    <span class="">ເຈົ້າຂອງກະທູ້: <?php echo $questionDetail['username'] ?></span>
                    <div class="">
                        <span class="text-muted">ເວລາ:</span>
                        <span class="text-muted time" data-time="<?php echo $questionDetail['create_at'] ?>"></span>
                    </div>
                </div>
            <?php } ?>
        </form>
    </div>

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
                            <?php if ($comment['user_id'] == $_SESSION['id'] && $comment['username'] == $_SESSION['username']) { ?>
                                <button class="button dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><button class="dropdown-item edit-button" href="#">ແກ້ໄຂ</button></li>
                                    <form action="deleteComment.php" method="POST">
                                        <input type="hidden" name="c_id" value="<?php echo $comment['c_id']; ?>">
                                        <input type="hidden" name="q_id" value="<?php echo $comment['q_id']; ?>">
                                        <li><input type="submit" class="dropdown-item" name="delete" value="ລົບຄຳຄິດເຫັນ"></li>
                                    </form>
                                </ul>
                            <?php } ?>
                        </div>
                        <div class="comment-body">
                            <form id="edit-comment-form" action="edit_comment.php" method="post">
                                <!-- Specify action attribute -->
                                <p class="comment-content"><?php echo $content ?></p>
                                <input type="hidden" name="c_id" value="<?php echo $comment['c_id']; ?>">
                                <input type="hidden" name="q_id" value="<?php echo $comment['q_id']; ?>">
                                <textarea class="form-control mb-1 comment-edit-content d-none"
                                    name="content"><?php echo $content ?></textarea>
                                <div class="d-flex justify-content-end">
                                    <!-- Cancel button -->
                                    <button type="button" class="mx-1 btn-cancel buttons d-none cancel-button">ຍົກເລີກ</button>
                                    <!-- Submit button -->
                                    <input type="submit" class="mx-1 btn-submit buttons d-none submit-button" name="editComment"
                                        value="ແກ້ໄຂ">
                                </div>
                            </form>
                        </div>
                        <div class="comment-actions">
                            <span class="text-muted">ເວລາ: </span>
                            <span class="text-muted time" data-time="<?php echo $comment['create_at']; ?>"></span>
                            <span class="action reply-link">ຕອບກັບ</span>
                        </div>
                        <!-- Reply comment form -->
                        <div class="reply-form" style="display:none;">
                            <form action="reply.php" method="post">
                                <input type="hidden" name="c_id" value="<?php echo $comment['c_id']; ?>">
                                <input type="hidden" name="q_id" value="<?php echo $comment['q_id']; ?>">
                                <div class="form-group d-flex flex-column">
                                    <textarea id="reply-content" name="content" class="form-control" rows="1"
                                        placeholder="ຕອບກັບ <?php echo $comment['username']; ?>" required></textarea>
                                    <button type="submit" name="reply" class="btn-reply mt-2">ຕອບກັບ</button>
                                </div>
                            </form>
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
                        <button class="toggle-replies" onclick="toggleReplies(<?php echo $comment['c_id']; ?>)">View
                            <?php echo $replyCount; ?> replies</button>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    <?php } ?>


    <!-- Comment -->
    <div class="comment">
        <form action="addComment.php" method="post">
            <div class="d-flex flex-column">
                <label for="comment" class="fs-5">comment:</label>
                <input type="hidden" name="q_id" value="<?php echo $questionDetail['q_id']; ?>">
                <textarea name="comment" id="comment" class="form-control" oninput="checkComment()"></textarea>
            </div>
            <div class="d-flex justify-content-end">
                <input type="submit" name="submit" id="submitBtn" class="btn btn-primary my-2" value="ສະແດງຄຳຄິດເຫັນ"
                    disabled>
            </div>
        </form>
    </div>
</main>
<script>
    const editButtons = document.querySelectorAll('.edit-button')
    // Add event listener to each edit button
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Find the parent comment box
            const commentBox = button.closest('.comment-box');

            const commentContent = commentBox.querySelector('.comment-content');
            const commentEditContent = commentBox.querySelector('.comment-edit-content');
            const submitButton = commentBox.querySelector('.submit-button');
            const cancelButton = commentBox.querySelector('.cancel-button');
            const commentActions = commentBox.querySelector('.comment-actions');

            commentContent.classList.toggle('d-none');
            commentEditContent.classList.toggle('d-none');
            submitButton.classList.toggle('d-none');
            cancelButton.classList.toggle('d-none');
            commentActions.classList.toggle('d-none');

            // Add a global click listener to cancel editing when clicking outside the comment box
            setTimeout(() => {
                document.addEventListener('click', function handleClickOutside(event) {
                    if (!commentBox.contains(event.target)) {
                        // Hide edit fields and show original content
                        commentContent.classList.remove('d-none');
                        commentEditContent.classList.add('d-none');
                        submitButton.classList.add('d-none');
                        cancelButton.classList.add('d-none');
                        commentActions.classList.remove('d-none');

                        // Remove this event listener after it runs once
                        document.removeEventListener('click', handleClickOutside);
                    }
                }, { once: true }); // Ensure the event listener is removed after the first invocation
            }, 0); // Delay to ensure the listener is added after this event
        });
    });
    // Add event listener to each cancel button
    const cancelButtons = document.querySelectorAll('.cancel-button');
    cancelButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.stopPropagation(); // Prevent the immediate trigger of the global click event
            // Find the parent comment box
            const commentBox = button.closest('.comment-box');

            const commentContent = commentBox.querySelector('.comment-content');
            const commentEditContent = commentBox.querySelector('.comment-edit-content');
            const submitButton = commentBox.querySelector('.submit-button');
            const cancelButton = commentBox.querySelector('.cancel-button');
            const commentActions = commentBox.querySelector('.comment-actions');

            // Hide edit fields and show original content
            commentContent.classList.remove('d-none');
            commentEditContent.classList.add('d-none');
            submitButton.classList.add('d-none');
            cancelButton.classList.add('d-none');
            commentActions.classList.remove('d-none');
        });
    });
    //validation comment
    function checkComment() {
        let comment = document.getElementById('comment').value;
        let submitBtn = document.getElementById('submitBtn');
        if (comment.trim() === "") {
            submitBtn.disabled = true;
        } else {
            submitBtn.disabled = false;
        }
    }
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
    //Display reply
    document.addEventListener("DOMContentLoaded", function () {
        const replyLinks = document.querySelectorAll('.reply-link');

        replyLinks.forEach(function (link) {
            link.addEventListener('click', function (event) {
                event.preventDefault();
                const replyForm = this.parentElement.nextElementSibling;
                if (replyForm.style.display === 'none' || replyForm.style.display === '') {
                    replyForm.style.display = 'block';
                } else {
                    replyForm.style.display = 'none';
                }
            });
        });
    });
    // JavaScript to handle cancel button click
    document.querySelector('.cancel-button').addEventListener('click', function (event) {
        event.preventDefault(); // Prevent form submission
        document.getElementById('edit-comment-form').reset(); // Reset form fields if needed
        // Optionally, you can hide the form or perform any other actions here
    });
    
    function toggleReplies(commentId) {
        const replies = document.getElementById(`replies-${commentId}`);
        const toggleButton = document.querySelector(`button[onclick="toggleReplies(${commentId})"]`);
        if (replies.style.display === 'none' || replies.style.display === '') {
            replies.style.display = 'block';
            toggleButton.textContent = 'Hide replies';
        } else {
            replies.style.display = 'none';
            toggleButton.textContent = `View replies`;
        }
    }
</script>
</body>

</html>