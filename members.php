<?php
$title = "ຂໍ້ມູນສະມາຊິກ";
require_once "layout/headerLogin.php";
require_once "db/config.php";
require_once "layout/checkLogin.php";
$members = $user->members();
$index = 1;
?>

<div class="container-fluid px-4">
    <?php if (isset($_SESSION['success'])) { ?>
        <div class="alert alert-success text-center" role="alert">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </div>
    <?php } ?>
    <?php if (isset($_SESSION['warning'])) { ?>
        <div class="alert alert-warning text-center" role="alert">
            <?php
            echo $_SESSION['warning'];
            unset($_SESSION['warning']);
            ?>
        </div>
    <?php } ?>
    <div class="my-5">
    <h3 class="text-center fw-bold">
        <?php echo "ຂໍ້ມູນສະມາຊິກ" ?>
    </h3>
    </div>
    <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr class="text-center">
                <th scope="col">ລຳດັບ</th>
                <th scope="col">username</th>
                <th scope="col">email</th>
                <th scope="col">firstname</th>
                <th scope="col">lastname</th>
                <th scope="col">tel</th>
                <th scope="col">address</th>
                <th scope="col">date</th>
                <th scope="col">manage</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($detail = $members->fetch(PDO::FETCH_ASSOC)) { 
                $time = $detail['date'];
                $date = explode(' ', $time)[0]; // Extract the date part?>
                <tr class="text-center">
                    <th scope=""><?php echo $index++; ?></th>
                    <td><?php echo $detail['username'] ?></td>
                    <td><?php echo $detail['email'] ?></td>
                    <td><?php echo $detail['firstname'] ?></td>
                    <td><?php echo $detail['lastname'] ?></td>
                    <td><?php echo $detail['telephone'] ?></td>
                    <td><?php echo $detail['address'] ?></td>
                    <td><?php echo $date ?></td>
                    <td><a onclick= "return confirm('Do you want to delete this information')" 
                    href="deleteMember.php?id=<?php echo $detail["m_id"]?> " class="btn btn-danger">Delete</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>

</html>