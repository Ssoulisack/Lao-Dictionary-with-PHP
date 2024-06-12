<?php
$title = "Registration";
require_once "../db/config.php";
require_once "headerLogging.php";
$status = 'pending';
$result = $user->eplRequest($status);
?>
<section>
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
            <?php echo "ຄຳຂໍລົງທະບຽນຜູ້ຊ່ຽວຊານ" ?>
        </h1>
        <hr>
        <div class="row">
            <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="col-md-4 col-lg-4">
                    <img class="img-thumbnail mb-3"
                        src="data:image/jpeg;base64,<?php echo base64_encode($row['credentials']) ?>" alt="Uploaded image"
                        style="width: 100%;" />
                    <div>
                        <h4 class="text-secondary">ຊື່ ແລະ ນາມສະກຸນ</h4>
                        <h5 class=" fw-bold">
                            <?php echo $row['firstname'] ?>
                            <?php echo $row['lastname'] ?>
                        </h5>
                    </div>
                    <div>
                        <p class="m-0 text-secondary fs-5"><i class="fs-5 bi bi-person-check"></i> ຊື່ຜູ້ໃຊ້: <span class="fw-bold text-dark"><?php echo $row['username'] ?></span></p>
                        <p class="m-0 text-secondary fs-5"><i class="fs-5 bi bi-envelope-at"></i> ອີເມວ: <span class="fw-bold text-dark"><?php echo $row['email'] ?></span></p>
                        <p class="m-0 text-secondary fs-5"><i class="fs-5 bi bi-telephone"></i> ເບີໂທ: <span class="fw-bold text-dark"><?php echo $row['telephone'] ?></span></p>
                        <p class="m-0 text-secondary fs-5"><i class="fs-5 bi bi-geo-alt"></i> ທີ່ຢູ່: <span class="fw-bold text-dark"><?php echo $row['address'] ?></span></p>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="admin/acceptEpl.php?id=<?php echo $row["e_id"] ?>"
                            class="btn btn-primary mx-1 py-1 px-4"><i class="bi bi-check-lg fs-6"></i></a>
                        <a onclick="return confirm('Do you want to delete this information')"
                            href="admin/cancelEpl.php?id=<?php echo $row["e_id"] ?> "
                            class="btn btn-secondary mx-1 py-1 px-4"><i class="bi bi-x-lg"></i></a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
</body>

</html>