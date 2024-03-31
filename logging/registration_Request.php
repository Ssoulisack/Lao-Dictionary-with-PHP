<?php
$title = "Registration";
require_once "../db/config.php";
require_once "../layout/headerLogin2.php";
$status = 'pending';
$result = $user->eplRequest($status);
?>
<section>
    <div class="container">
        <?php if (isset ($_SESSION['success'])) { ?>
            <div class="alert alert-success" role="alert">
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
        <?php } ?>
        <?php if (isset ($_SESSION['warning'])) { ?>
            <div class="alert alert-warning" role="alert">
                <?php
                echo $_SESSION['warning'];
                unset($_SESSION['warning']);
                ?>
            </div>
        <?php } ?>
        <h1 class="text-center">
            <?php echo "Request Registration" ?>
        </h1>
        <hr>
            <div class="row">
            <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="col-md-4 col-lg-4">
                    <img class="img-thumbnail mb-3" src="data:image/jpeg;base64,<?php echo base64_encode($row['credentials'])?>" alt="Uploaded image" style="width: 100%;"/>
                    <h4 class="text-secondary">ຊື່ ແລະ ນາມສະກຸນ</h4>
                    <h5 class=" fw-bold">
                        <?php echo $row['firstname'] ?>
                        <?php echo $row['lastname'] ?>
                    </h5>
                    <p><i class="bi bi-envelope-at"> Email:</i>
                    <b class="fw-bold"><?php echo $row['email']?></b>
                    </p>

                    <div class="d-flex justify-content-end">
                        <a href="admin/acceptEpl.php?id=<?php echo $row["e_id"] ?>" class="btn btn-primary mx-1 py-1 px-4"><i
                        class="bi bi-check-lg fs-6"></i></a>
                        <a onclick="return confirm('Do you want to delete this information')"
                        href="admin/cancelEpl.php?id=<?php echo $row["e_id"] ?> " class="btn btn-secondary mx-1 py-1 px-4"><i
                        class="bi bi-x-lg"></i></a>
                    </div>
                </div>
                <?php } ?>
            </div>
    </div>
</section>
</body>

</html>