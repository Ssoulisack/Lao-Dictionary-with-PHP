<?php
$title = "ຂໍ້ມູນສ່ວນໂຕ";
require_once "layout/headerLogin.php";
require_once "db/config.php";
require_once "layout/checkLogin.php";
$user_id = $_SESSION['id'];
$username = $_SESSION['username'];
$urole = $_SESSION['urole'];

// Fetch current user information for comparison
$currentUser = $user->infoUser($user_id, $username, $urole);

$currentUsername = $currentUser['username'];
$currentEmail = $currentUser['email'];
//edit information
if (isset($_POST['editInfo'])) { //Method edit vocab =.

    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $tel = $_POST['tel'];
    $address = $_POST['address'];
    $urole = $_SESSION['urole'];
    $shouldCheck = false;
    // Check if username or email has changed
    if ($username !== $currentUsername && $email !== $currentEmail) {
        $shouldCheck = true;
    }
    if ($shouldCheck) {
        $result = $user->checkUserData($username, $email);
        if ($result['num'] > 0) {
            $_SESSION["error"] = "Email or username has already exists";
        } else {
            $edit = $user->editInfo($user_id, $username, $email, $fname, $lname, $tel, $address, $urole);
            if ($edit) {
                // Update session variables with new data
                $_SESSION['username'] = $username;

                $_SESSION["success"] = "ແກ້ໄຂຂໍ້ມູນສຳເລັດ";
            } else {
                $_SESSION["error"] = "ຂໍ້ມູນບໍ່ຖືກຕ້ອງ";
            }
        }
    }else {
        // If no changes to username or email, proceed with the update
        $edit = $user->editInfo($user_id, $username, $email, $fname, $lname, $tel, $address, $urole);
        if ($edit) {
            // Update session variables with new data
            $_SESSION['username'] = $username;

            $_SESSION["success"] = "ແກ້ໄຂຂໍ້ມູນສຳເລັດ";
        } else {
            $_SESSION["error"] = "ຂໍ້ມູນບໍ່ຖືກຕ້ອງ";
        }
    }
}
$result = $user->infoUser($user_id, $username, $urole);
// print_r($result);
$time = $result['date'];
$date = explode(' ', $time)[0]; // Extract the date part
switch ($urole) {
    case 'admin':
        $id = $result['admin_id'];
        break;
    case 'member':
        $id = $result['m_id'];
        break;
    case 'languageExpert':
        $id = $result['e_id'];
        break;
    default:
        $id = null;
        break;
}
?>
<div class="container">
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex my-5 justify-content-between">
                <?php if (isset($_SESSION['error'])) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                        ?>
                    </div>
                <?php } ?>
                <?php if (isset($_SESSION['success'])) { ?>
                    <div class="alert alert-success" role="alert">
                        <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                        ?>
                    </div>
                <?php } ?>
                <h3 class="text-primary">ຂໍ້ມູນສ່ວນໂຕ</h3>
                <a href="#edit<?php echo $id; ?>" data-bs-toggle="modal">
                    <button type="button" class="btn btn-outline-secondary btn-sm border border-none"><i
                            class="bi bi-pencil-square"></i> </button>
                </a>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <p class="mb-0 fw-bold">ຊື່ຜູ້ໃຊ້</p>
                </div>
                <div class="col-sm-9">
                    <p class="text-muted mb-0"><?php echo htmlspecialchars($result['username']) ?></p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <p class="mb-0 fw-bold">ຊື່ ແລະ ນາມສະກຸນ</p>
                </div>
                <div class="col-sm-9">
                    <p class="text-muted mb-0"><?php echo htmlspecialchars($result['firstname']) . ' ' . htmlspecialchars($result['lastname']) ?></p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <p class="mb-0 fw-bold">ອີເມວ</p>
                </div>
                <div class="col-sm-9">
                    <p class="text-muted mb-0"><?php echo htmlspecialchars($result['email']) ?></p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <p class="mb-0 fw-bold">ເບີໂທ</p>
                </div>
                <div class="col-sm-9">
                    <p class="text-muted mb-0"><?php echo htmlspecialchars($result['telephone']) ?></p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <p class="mb-0 fw-bold">ທີ່ຢູ່</p>
                </div>
                <div class="col-sm-9">
                    <p class="text-muted mb-0"><?php echo htmlspecialchars($result['address']) ?></p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <p class="mb-0 fw-bold">ວັນທີລົງທະບຽນ</p>
                </div>
                <div class="col-sm-9">
                    <p class="text-muted mb-0"><?php echo htmlspecialchars($date) ?></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Edit VOCAB -->
    <div id="edit<?php echo $id; ?>" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" class="form-horizontal" role="form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ແກ້ໄຂຂໍ້ມູນສ່ວນໂຕ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="username" class="fw-bold">ຊື່ຜູ້ໃຊ້</label>
                            <div class="">
                                <input type="hidden" class="form-control" id="user_id" name="user_id"
                                    value="<?php echo $id; ?>">
                                <input type="text" class="form-control" id="username" name="username"
                                    value="<?php echo htmlspecialchars($result['username']); ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="email" class="fw-bold">ອີເມວ</label>
                            <div class="">
                                <input type="text" class="form-control" id="email" name="email"
                                    value="<?php echo htmlspecialchars($result['email']); ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="fname" class="fw-bold">ຊື່</label>
                            <div class="">
                                <input type="text" class="form-control" id="fname" name="fname"
                                    value="<?php echo htmlspecialchars($result['firstname']); ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="lname" class="fw-bold">ນາມສະກຸນ</label>
                            <div class="">
                                <input type="text" class="form-control" id="lname" name="lname"
                                    value="<?php echo htmlspecialchars($result['lastname']); ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="tel" class="fw-bold">ເບີໂທ</label>
                            <div class="">
                                <input type="text" class="form-control" id="tel" name="tel"
                                    value="<?php echo htmlspecialchars($result['telephone']); ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="address" class="fw-bold">ທີ່ຢູ່</label>
                            <div class="">
                                <input type="text" class="form-control" id="address" name="address"
                                    value="<?php echo htmlspecialchars($result['address']); ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ຍົກເລີກ</button>
                            <button type="submit" class="btn btn-primary" name="editInfo">ແກ້ໄຂ</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>

</html>