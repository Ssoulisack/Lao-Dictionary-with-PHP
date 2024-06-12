<?php
$title = "ຂໍ້ມູນຜູ້ຊ່ຽວຊານພາສາ";
require_once "layout/headerLogin.php";
require_once "db/config.php";
require_once "layout/checkLogin.php";
$epl = $user->epLanguage();
$index = 1;
?>

<div class="container">
    <?php if (isset($_SESSION['success'])) { ?>
        <div class="alert alert-success" role="alert">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </div>
    <?php } ?>
    <?php if (isset($_SESSION['warning'])) { ?>
        <div class="alert alert-warning" role="alert">
            <?php
            echo $_SESSION['warning'];
            unset($_SESSION['warning']);
            ?>
        </div>
    <?php } ?>
    <h1 class="text-center">
        <?php echo "ຂໍ້ມູນຜູ້ຊ່ຽວຊານພາສາ" ?>
    </h1>
    <hr>
    <div class="row">
        <?php while ($row = $epl->fetch(PDO::FETCH_ASSOC)) { ?>
            <div class="col-6">
                <div>
                    <h5 class="bg-primary text-white rounded-5 text-center"><?php echo $index++; ?></h5>
                </div>
                <div class="my-3 d-flex justify-content-between">
                    <div>
                        <h4 class="text-secondary">ຊື່ ແລະ ນາມສະກຸນ</h4>
                        <h5 class=" fw-bold">
                            <?php echo $row['firstname'] ?>
                            <?php echo $row['lastname'] ?>
                        </h5>
                        <p class="m-0 text-secondary fs-5"><i class="fs-5 bi bi-person-check"></i> ຊື່ຜູ້ໃຊ້: <span
                                class="fw-bold text-dark"><?php echo $row['username'] ?></span></p>
                        <p class="m-0 text-secondary fs-5"><i class="fs-5 bi bi-envelope-at"></i> ອີເມວ: <span
                                class="fw-bold text-dark"><?php echo $row['email'] ?></span></p>
                        <p class="m-0 text-secondary fs-5"><i class="fs-5 bi bi-telephone"></i> ເບີໂທ: <span
                                class="fw-bold text-dark"><?php echo $row['telephone'] ?></span></p>
                        <p class="m-0 text-secondary fs-5"><i class="fs-5 bi bi-geo-alt"></i> ທີ່ຢູ່: <span
                                class="fw-bold text-dark"><?php echo $row['address'] ?></span></p>
                    </div>
                    <div class="btn-delete align-self-end">
                        <a onclick="return confirm('Do you want to delete this information')"
                            href="deleteEpl.php?id=<?php echo $row["e_id"] ?> " class="btn btn-outline-danger btn-sm mt-2"><i
                                class="bi bi-x-circle"></i> ລົບບັນຊິ</a>
                    </div>
                </div>
            </div>
            <div class="col-6 text-end">
                <img class="img-thumbnail mb-3"
                    src="data:image/jpeg;base64,<?php echo base64_encode($row['credentials']) ?>" alt="Uploaded image"
                    style="width: 60%; " />
            </div>
            <hr>
        <?php } ?>
    </div>
</div>
</body>

</html>