<?php
session_start();
if (!isset($_SESSION["acc_id"]) || $_SESSION["acc_id"] == "") {
    $resultNoSession = "เข้าสู่ระบบก่อนใช้งาน";
    $_SESSION['resultNoSession'] = $resultNoSession;
    echo "<script type='text/javascript'>";
    echo "window.location = '../login.php'; ";
    echo "</script>";
    exit();
    // ผู้ใช้งานทั่วไป
}
include "../server.php";
?>
<?php
ini_set('display_errors', 0);
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
   
</head>

<body>
    <div class="modal" id="cowdel<?php echo $row['cow_id']; ?>" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Label"><b>ยืนยันการลบข้อมูลโค</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    $del = mysqli_query($conn, "select * from cow where cow_id='" . $row['cow_id'] . "'");
                    $drow = mysqli_fetch_array($del);
                    ?>
                    <div class="container-fluid text-center">
                        คุณต้องการลบข้อมูลโค ชื่อ : <strong>
                            <?php echo $drow['cow_name']; ?>
                        </strong> ใช่หรือไม่
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <a href="del_cow.php?cow_id=<?php echo $row['cow_id']; ?>" class="btn btn-danger"><span
                            class="glyphicon glyphicon-trash"></span> ยืนยัน</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ลบข้อมูลวัคซีน -->
    <div class="modal" id="vaccinedel<?php echo $row['cow_vaccine_id']; ?>" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Label"><b>ยืนยันการลบข้อมูล</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    $vac = mysqli_query($conn, "select * from cow_vaccine where cow_vaccine_id='" . $row['cow_vaccine_id'] . "'");
                    $vrow = mysqli_fetch_array($vac);
                    ?>
                    <div class="container-fluid text-center">
                        คุณต้องการลบรายการ : <strong>
                            <?php echo $vrow['cow_vaccine_id']; ?>
                        </strong> ใช่หรือไม่
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <a href="del_vaccine.php?cow_vaccine_id=<?php echo $row['cow_vaccine_id']; ?>"
                        class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> ยืนยัน</a>
                </div>
            </div>
        </div>
    </div>

    <!-- ลบข้อมูลสุขภาพ -->
    <div class="modal" id="healthdel<?php echo $row['cow_health_id']; ?>" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Label"><b>ยืนยันการลบข้อมูล</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    $hea = mysqli_query($conn, "select * from cow_health where cow_health_id='" . $row['cow_health_id'] . "'");
                    $hrow = mysqli_fetch_array($hea);
                    ?>
                    <div class="container-fluid text-center">
                        คุณต้องการลบรายการ : <strong>
                            <?php echo $hrow['cow_health_id']; ?>
                        </strong> ใช่หรือไม่
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <a href="del_health.php?cow_health_id=<?php echo $row['cow_health_id']; ?>" class="btn btn-danger"><span
                            class="glyphicon glyphicon-trash"></span> ยืนยัน</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ลบข้อมูลโรค -->
    <div class="modal" id="dianosisdel<?php echo $row['cow_dianosis_id']; ?>" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Label"><b>ยืนยันการลบข้อมูล</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    $dia = mysqli_query($conn, "select * from cow_dianosis where cow_dianosis_id='" . $row['cow_dianosis_id'] . "'");
                    $cdrow = mysqli_fetch_array($dia);
                    ?>
                    <div class="container-fluid text-center">
                        คุณต้องการลบรายการ : <strong>
                            <?php echo $cdrow['cow_dianosis_id']; ?>
                        </strong> ใช่หรือไม่
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <a href="del_dianosis.php?cow_dianosis_id=<?php echo $row['cow_dianosis_id']; ?>"
                        class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> ยืนยัน</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ลบข้อมูลผลผลิต -->
    <div class="modal" id="milkdel<?php echo $row['cow_milk_id']; ?>" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Label"><b>ยืนยันการลบข้อมูล</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    $milk = mysqli_query($conn, "select * from cow_milk where cow_milk_id='" . $row['cow_milk_id'] . "'");
                    $milkrow = mysqli_fetch_array($milk);
                    ?>
                    <div class="container-fluid text-center">
                        คุณต้องการลบรายการ : <strong>
                            <?php echo $row['cow_milk_id']; ?>
                        </strong> ใช่หรือไม่
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <a href="del_milk.php?cow_milk_id=<?php echo $row['cow_milk_id']; ?>" class="btn btn-danger"><span
                            class="glyphicon glyphicon-trash"></span> ยืนยัน</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ลบข้อมูลผสมพันธุ์ -->
    <div class="modal" id="breeddel<?php echo $row['breed_id']; ?>" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Label"><b>ยืนยันการลบข้อมูล</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    $bre = mysqli_query($conn, "select * from cow_breed where breed_id='" . $row['breed_id'] . "'");
                    $brow = mysqli_fetch_array($bre);
                    ?>
                    <div class="container-fluid text-center">
                        คุณต้องการลบรายการ : <strong>
                            <?php echo $brow['breed_id']; ?>
                        </strong> ใช่หรือไม่
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <a href="del_breed.php?breed_id=<?php echo $row['breed_id']; ?>" class="btn btn-danger"><span
                            class="glyphicon glyphicon-trash"></span> ยืนยัน</a>
                </div>
            </div>
        </div>
    </div>
    
</body>

</html>