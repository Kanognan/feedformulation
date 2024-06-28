<?php
session_start();
if (!isset ($_SESSION["acc_id"]) || $_SESSION["acc_id"] == "") {
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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <title>การผสมพันธุ์</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'kanit';
            /* color: black; */

        }

        .add .breed {
            background-color: #4F80C0;
            color: white;
            width: 8.8em;
            padding: 0.5em;
            border-radius: 20px;
            font-size: 1em;
            margin: 0em 0.2em 1em 0.2em;
            border: none !important;

        }

        .add .breed:hover,
        .add .breed:focus,
        button[type=submit]:hover {
            background-color: #AACCE2;
            color: black;
        }


        .title-detail {
            text-align: center;
            margin-bottom: 1.5em;
        }

        .detail {
            margin-top: 0em;
            background-color: #c6d9eb !important;
            /* padding: 1.2em; */
            border-radius: 15px;
            height: 30em;

        }

        .detail-topic {
            font-size: 1.2em;
            font-weight: 500;
            background-color: #6999C6;
            padding: 0.8em;
            border-radius: 15px;
            color: white;
        }

        .col-12-topic {
            padding: 0.3em;
        }

        .col-12-topic input {
            font-size: 16px;
            padding: 0.3em;
            width: 100%;

        }


        .btn-light,
        .btn-success,
        .btn-warning {
            width: 10em;
        }

        .breedsearch input {
            width: 60% !important;
            border-radius: 20px !important;

        }

        .flex {
            display: flex;
        }

        .g-2 {
            flex: 1;
        }

        .content {
            padding: 3em;
            padding-left: 16em !important;
            width: 100%;
        }

        .breed {
            text-align: center;
            padding: 0.2em 0.6em;
            width: 8.5em;
            margin: 0 auto;
            border-radius: 15px;
        }

        .btn-group>.btn-group:not(:last-child)>.btn,
        .btn-group>.btn.dropdown-toggle-split:first-child,
        .btn-group>.btn:not(:last-child):not(.dropdown-toggle) {
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        @media (max-width: 576px) {
            .content {
                padding-left: 4.5em !important;
                padding-right: 1.5em !important;

            }

            .g-2 {
                width: 92%;
            }

            .add {
                display: flex;
                justify-content: flex-end;
                padding-right: 8em !important;
            }

            .add .col-2 {
                text-align: right;
                padding-right: 1.5em !important;
            }
            .no-data-message {
                text-align: left !important;
                padding: 2em;
    }

        }
        @media (min-width: 768px) {
            .col-md-6{
                width:100% !important;
            }
            .g-2{
                width:92% !important;
            }
           
        }
    </style>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.3/dist/bootstrap-table.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.1/dist/bootstrap-table.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.2/dist/bootstrap-table-locale-all.min.js"></script>
</script>

<body>
    <?php
    $acc_id = $_SESSION['acc_id'];
    ?>
    <div class="flex">
        <div class="g-1">
            <?php include ('sidebar.php'); ?>
        </div>
        <div class="g-2">
            <div class="content">
                <div class="col-12 col-md-6 col-lg-12 mb-3" id="box">
                <h3 class="title-detail">การผสมพันธุ์</h3>
                    <!-- ---------------------------------------------------------------------------------------------------------- -->
                    <div class="row add">
                        <div class="col-2">
                            <button type="button" class="breed" data-bs-toggle="modal" data-bs-target="#addbreed">
                                เพิ่มรายการ
                            </button>
                        </div>
                    </div>

                    <!-- เพิ่มข้อมูลการผสมพันธุ์ -->
                    <div class="modal" id="addbreed" tabindex="-1" aria-labelledby="addbreed" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="addbreed">เพิ่มข้อมูลการผสมพันธุ์</h1><br>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="cow_breeding_db.php" method="post" class="form"
                                    enctype="multipart/form-data">
                                    <?php
                                    $sql = "SELECT DISTINCT cow.*, DATEDIFF(NOW(), cow_bday) AS age_in_days 
                                    FROM cow
                                    LEFT JOIN cow_breed ON cow.cow_id = cow_breed.cow_id
                                    WHERE cow.acc_id = $acc_id
                                    AND cow.deleteAt IS NULL
                                    AND cow_breed_status = 'ท้องว่าง'
                                    AND DATEDIFF(NOW(), cow_bday) >= 180 
                                    AND cow.cow_id NOT IN (
                                        SELECT cow_id
                                        FROM cow_breed
                                        WHERE breed_status IN ('รอตรวจท้อง', 'ตั้งท้อง')
                                    );

                                    ";
                                    
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        ?>
                                        <div class="modal-body">
                                            <div class="mb-3 was-validated">
                                                <label for="cow_id" class="form-label">รหัสโคที่รับการผสม</label><br>
                                                <div class="input-group">
                                                    <select class="form-select" id="cow_id"
                                                        aria-label="Example select with button addon" name="cow_id"
                                                        required>
                                                        <option value="" selected disabled>เลือกโค</option>
                                                        <?php
                                                        while ($raw = $result->fetch_assoc()):
                                                            ;
                                                            ?>
                                                            <option value="<?php echo $raw["cow_id"]; ?>">
                                                                <?php echo $raw["cow_id"]; ?>
                                                                <?php echo $raw["cow_name"]; ?>
                                                            </option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3 was-validated">
                                                <label for="date" class="form-label">วันที่ผสมพันธุ์</label>
                                                <input type="date" class="form-control" name="breed_date" id="breed_date"
                                                    required>
                                            </div>
                                            <div class="mb-3 was-validated">
                                                <label for="breeder" class="form-label">รหัสพ่อพันธุ์/น้ำเชื้อ</label>
                                                <input type="text" class="form-control" name="breed_breeder"
                                                    pattern="[^' '][a-zA-Zก-๙0-9]+" required>
                                            </div>
                                            <div class="mb-3 was-validated">
                                                <label for="cattle_breed_breeder"
                                                    class="form-label">พันธุ์ของพ่อพันธุ์/น้ำเชื้อ</label>
                                                <div class="input-group">
                                                    <select class="form-select" id="cattle_breed_breeder"
                                                        aria-label="Example select with button addon"
                                                        name="cattle_breed_breeder" required>
                                                        <option value="" selected disabled>เลือกพันธุ์โค</option>
                                                        <?php
                                                        $sql = "SELECT * FROM cattle_breed WHERE cb_id != 0";
                                                        $result = $conn->query($sql);
                                                        while ($raw = $result->fetch_assoc()):
                                                            ;
                                                            ?>
                                                            <option value="<?php echo $raw["cb_Thainame"]; ?>">
                                                                <?php echo $raw["cb_Thainame"]; ?>
                                                                <?php echo "(" . $raw["cb_Engname"] . ")"; ?>
                                                            </option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3 was-validated">
                                                <label for="officer" class="form-label">ผู้ผสมพันธุ์</label>
                                                <input type="text" class="form-control" name="cow_breed_officer"
                                                    pattern="[a-zA-Z]+([a-zA-Z0-9\s,\-\.\(/)]*)" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">ปิด</button>
                                                <button type="submit" class="btn btn-primary"
                                                    name="addbreed">เพิ่มข้อมูล</button>
                                            </div>
                                            <?php
                                    } else if ($result->num_rows === 0) {
                                        echo "<p style='text-align: center; color: gray; margin-top: 2em;'>คุณยังไม่มีข้อมูลโค?
                                                <span><a style='text-decoration: underline; color: #6999C6'
                                                        href='../cow/addcow.php'>เพิ่มข้อมูลโค</a></span><br>
                                                        <span style='color: red;'>*ต้องเป็นโคอายุ 6 เดือนขึ้นไป<span>
                                            </p>"; ?>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">ปิด</button>
                                                </div>
                                            <?php
                                    }
                                    ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- ---------------------------------------------------------------------------------------------------------- -->
                    <!-- ดึงข้อมูลจากดาต้าเบส -->
                    <?php
                    $sql1 = "SELECT * FROM cow_breed
                                INNER JOIN cow ON cow_breed.cow_id = cow.cow_id
                                WHERE cow.acc_id = $acc_id
                                ORDER BY cow_breed.createAt DESC";
                    $result1 = $conn->query($sql1);
                    ?>
                    <table class="table-responsive " id="table" data-filter-control="true" data-toggle="table"
                        data-pagination="true" data-locale="th-TH" data-flat="true" data-icons="icons"
                        data-toggle="table" data-search="true" data-search-highlight="true"
                        data-maintain-meta-data="true">

                        <thead>
                            <tr class='table table-primary' style='text-align:center;'>
                                <th data-field="breed_date">วัน/เดือน/ปี</th>
                                <th data-field="cow_id">รหัสโคที่รับการผสม</th>
                                <th data-field="cow_name">ชื่อโค</th>
                                <th data-field="breed_breeder">พ่อพันธุ์</th>
                                <th data-field="cattle_breed_breeder">พันธุ์ของพ่อพันธุ์</th>
                                <th data-field="cow_breed_officer">ผู้ผสม</th>
                                <th data-field="breed_status">สถานะ</th>
                                <th data-field="calf_day">วันที่คาดการณ์คลอด</th>
                                <th data-field="milk_day">วันที่เริ่มให้นม</th>
                                <th data-searchable="false">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="table-group text-center">
                            <?php
                            if ($result1 && $result1->num_rows > 0) {
                                while ($row = $result1->fetch_assoc()) {
                                    $cow_id = $row['cow_id'];
                                    ?>
                                    <tr>
                                        <td style="text-align:center" ;>
                                            <?php echo date("d-m-Y", strtotime($row["breed_date"])); ?>
                                        </td>
                                        <td style="text-align:center" ;>
                                            <?php echo $row["cow_id"]; ?>
                                        </td>
                                        <td style="text-align:center" ;>
                                            <?php echo $row["cow_name"]; ?>
                                        </td>
                                        <td style="text-align:center" ;>
                                            <?php echo $row["breed_breeder"], " "; ?>
                                        </td>
                                        <td style="text-align:center" ;>
                                            <?php echo $row["cattle_breed_breeder"], " "; ?>
                                        </td>
                                        <td style="text-align:center" ;>
                                            <?php echo $row["cow_breed_officer"]; ?>
                                        </td>
                                        <td>
                                            <div class='breed' style="text-align:center; 
                                        <?php
                                        if ($row["breed_status"] == "รอตรวจท้อง") {
                                            echo "background-color: #FBEDBE; color: black;";
                                        } else if ($row["breed_status"] == "ตั้งท้อง") {
                                            echo "background-color: #73C088; color: white;";
                                        } else if ($row["breed_status"] == "คลอดปกติ" || $row["breed_status"] == "คลอดก่อนกำหนด" || $row["breed_status"] == "คลอดหลังกำหนด") {
                                            echo "background-color: #9999CC; color: white;";
                                        } else if ($row["breed_status"] == "แท้ง" || $row["breed_status"] == "ผสมไม่ติด") {
                                            echo "background-color: #EA6D75; color: white;";
                                        }
                                        ?>;">
                                                <?php echo $row["breed_status"]; ?>
                                            </div>
                                        </td>
                                        <td style="text-align:center">
                                            <?php echo ($row["calf_day"] !== null) ? date("d-m-Y", strtotime($row["calf_day"])) : "-"; ?>
                                        </td>
                                        <td style="text-align:center">
                                            <?php echo ($row["milk_day"] !== null) ? date("d-m-Y", strtotime($row["milk_day"])) : "-"; ?>
                                        </td>
                                        <td style="text-align:center">
                                            <?php if ($row['breed_status'] == 'รอตรวจท้อง') { ?>
                                                <!-- เพิ่มข้อมูลตรวจท้อง -->
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                        data-bs-target="#pregnancycheck<?php echo $row['breed_id']; ?>">
                                                        เพิ่มการตรวจท้อง
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#breeddel<?php echo $row['breed_id']; ?>">
                                                        <span class="glyphicon glyphicon-trash"></span><img src="../pic/delete.png"
                                                            alt="" style="width:12px; height:12px; " title="ลบข้อมูลโค"></button>
                                                </div>
                                                <?php include ('cow_update_model.php'); ?>
                                            <?php } else if ($row['breed_status'] == 'ตั้งท้อง') { ?>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                            data-bs-target="#calfcheck<?php echo $row['breed_id']; ?>">
                                                            เพิ่มข้อมูลการคลอด
                                                        </button>
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                            data-bs-target="#breeddel<?php echo $row['breed_id']; ?>">
                                                            <span class="glyphicon glyphicon-trash"></span><img src="../pic/delete.png"
                                                                alt="" style="width:12px; height:12px; " title="ลบข้อมูลโค"></button>
                                                    </div>
                                                <?php include ('cow_update_model.php'); ?>
                                            <?php } else if ($row['breed_status'] == 'ผสมไม่ติด') { ?>
                                                        <!-- เพิ่มข้อมูลตรวจท้อง -->
                                                        <div class="btn-group">
                                                            <!-- <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                                                data-bs-target="#editbreed<?php echo $row['breed_id']; ?>">
                                                                แก้ไขข้อมูลผสมพันธุ์
                                                            </button> -->
                                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                                data-bs-target="#breeddel<?php echo $row['breed_id']; ?>">
                                                                <span class="glyphicon glyphicon-trash"></span><img src="../pic/delete.png"
                                                                    alt="" style="width:12px; height:12px; " title="ลบข้อมูลโค"></button>
                                                        </div>
                                                <?php include ('../cow/cow_update_model.php'); ?>
                                            <?php } else if ($row['breed_status'] == 'คลอดปกติ' || $row['breed_status'] == 'คลอดหลังกำหนด' || $row['breed_status'] == 'คลอดก่อนกำหนด'  ) { ?>
                                                            <div class="btn-group">
                                                            <button type="button" class="btn btn-light" data-bs-toggle="modal"
                                                                data-bs-target="#detailcalf<?php echo $row['breed_id']; ?>">
                                                                รายละเอียด
                                                            </button>
                                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                                data-bs-target="#breeddel<?php echo $row['breed_id']; ?>">
                                                                <span class="glyphicon glyphicon-trash"></span><img src="../pic/delete.png"
                                                                    alt="" style="width:12px; height:12px; " title="ลบข้อมูลโค"></button>
                                                            </div>
                                                <?php include ('cow_update_model.php'); ?>
                                            <?php } else if ($row['breed_status'] == 'แท้ง') { ?>
                                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                                    data-bs-target="#breeddel<?php echo $row['breed_id']; ?>">
                                                                    <span class="glyphicon glyphicon-trash"></span><img src="../pic/delete.png"
                                                                        alt="" style="width:12px; height:12px; " title="ลบข้อมูลโค"></button>
                                                <?php include ('cow_update_model.php'); ?>
                                            <?php } ?>
                                        </td>
                                        <!-- เพิ่มข้อมูลตรวจท้อง -->
                                        <div class="modal" id="pregnancycheck<?php echo $row['breed_id']; ?>" tabindex="-1"
                                            aria-labelledby="pregnancycheck<?php echo $row['breed_id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5"
                                                            id="pregnancycheck<?php echo $row['breed_id']; ?>">
                                                            เพิ่มข้อมูลตรวจท้อง</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                                                        $pre = mysqli_query($conn, "select * from cow_breed inner join cow on cow_breed.cow_id = cow.cow_id where cow.deleteAt IS NULL AND breed_id='" . $row['breed_id'] . "'");
                                                        $cpre = mysqli_fetch_array($pre);
                                                        ?>
                                                        <form
                                                            action="pregnancycheck.php?breed_id=<?php echo $row['breed_id']; ?>&cow_id=<?php echo $cpre['cow_id']; ?>"
                                                            method="post" class="form" enctype="multipart/form-data">
                                                            <div class="mb-3">
                                                                <label for="id" class="form-label">รหัสโคที่รับการผสม : </label>
                                                                <input type="text" class="form-control" name="cow_id"
                                                                    value="<?php echo $cpre['cow_id']; ?>" disabled="disabled">
                                                                <input type="hidden" class="form-control" name="cow_id"
                                                                    value="<?php echo $cpre['cow_id']; ?>">
                                                                <input type="hidden" class="form-control" name="breed_id"
                                                                    value="<?php echo $row['breed_id']; ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="id" class="form-label">ชื่อโคที่รับการผสม : </label>
                                                                <input type="text" class="form-control" name="cow_name"
                                                                    value="<?php echo $cpre['cow_name'] ?>" disabled="disabled">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="date" class="form-label">วันที่ผสมพันธุ์</label>
                                                                <input type="date" class="form-control" name="breed_date"
                                                                    value="<?php echo $cpre['breed_date']; ?>"
                                                                    disabled="disabled">
                                                                <input type="hidden" class="form-control" name="breed_date"
                                                                    value="<?php echo $cpre['breed_date']; ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="breeder"
                                                                    class="form-label">รหัสพ่อพันธุ์/น้ำเชื้อ</label>
                                                                <input type="text" class="form-control" name="breed_breeder"
                                                                    value="<?php echo $cpre['breed_breeder']; ?>"
                                                                    disabled="disabled">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="officer" class="form-label">ผู้ผสมพันธุ์</label>
                                                                <input type="text" class="form-control" name="cow_breed_officer"
                                                                    value="<?php echo $cpre['cow_breed_officer']; ?>"
                                                                    disabled="disabled">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="officer"
                                                                    class="form-label">ผลการตรวจท้อง</label><br>
                                                                <input type="radio" class="btn-check" name="options"
                                                                    value='ตั้งท้อง' id="success-outlined" autocomplete="off"
                                                                    checked>
                                                                <label class="btn btn-outline-success"
                                                                    for="success-outlined">ผสมติด</label>
                                                                <input type="radio" class="btn-check" name="options"
                                                                    value='ผสมไม่ติด' id="danger-outlined" autocomplete="off">
                                                                <label class="btn btn-outline-danger"
                                                                    for="danger-outlined">ผสมไม่ติด</label>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="exampleFormControlTextarea1"
                                                                    class="form-label">หมายเหตุ</label>
                                                                <textarea class="form-control" id="exampleFormControlTextarea1"
                                                                    rows="3" name="note"
                                                                    pattern="[^' '][a-zA-Zก-๙0-9]+"></textarea>
                                                            </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">ปิด</button>
                                                        <button type="submit" class="btn btn-primary"
                                                            name="pregnancycheck">ยืนยัน</button>
                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                        </div>

                                        <!-- เพิ่มข้อมูลการคลอด -->
                                        <div class="modal" id="calfcheck<?php echo $row['breed_id']; ?>" tabindex="-1"
                                            aria-labelledby="calfcheck<?php echo $row['breed_id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5"
                                                            id="calfcheck<?php echo $row['breed_id']; ?>">
                                                            เพิ่มข้อมูลการคลอด</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form
                                                            action="addcalf_db.php?breed_id=<?php echo $row['breed_id']; ?>&cow_id=<?php echo $row['cow_id']; ?>"
                                                            method="post" class="form" enctype="multipart/form-data">
                                                            <div class="mb-3  was-validated">
                                                                <label for="dropdown" class="form-label">การคลอด</label>
                                                                <select class="form-select" id="dropdown" name="calf_status"
                                                                    required>
                                                                    <option value="" selected disabled>เลือกการคลอด</option>
                                                                    <option value="คลอดปกติ">คลอดปกติ</option>
                                                                    <option value="คลอดหลังกำหนด">คลอดหลังกำหนด</option>
                                                                    <option value="คลอดก่อนกำหนด">คลอดก่อนกำหนด</option>
                                                                    <option value="แท้ง">แท้ง</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3  was-validated">
                                                                <label for="calf_no" class="form-label">รหัสลูกโค</label>
                                                                <input type="text" class="form-control" id="calf_no"
                                                                    name="calf_no" pattern="[a-zA-Z]+([a-zA-Z0-9\s,\-\.\(/)]*)"
                                                                    required>
                                                            </div>
                                                            <div class="mb-3  was-validated">
                                                                <input type="hidden" class="form-control" name="breed_date"
                                                                    value="<?php echo $cpre['breed_date']; ?>">
                                                            </div>
                                                            <div class="mb-3 was-validated">
                                                                <input type="hidden" class="form-control" name="calf_date"
                                                                    value="<?php echo $cpre['calf_date']; ?>">
                                                            </div>
                                                            <div class="mb-3 was-validated">
                                                                <label for="inputField" class="form-label">เพศลูกโค</label>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="flexRadioDefault" id="Male" value="เพศผู้">
                                                                    <label class="form-check-label"
                                                                        for="inputSection1Male">เพศผู้</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="flexRadioDefault" id="Female" checked
                                                                        value="เพศเมีย">
                                                                    <label class="form-check-label"
                                                                        for="inputSection1Female">เพศเมีย</label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 was-validated">
                                                                <label for="inputField" class="form-label">วันที่คลอด</label>
                                                                <input type="date" class="form-control" id="calf_bday"
                                                                    name="calf_bday" required>
                                                            </div>
                                                            <div class="mb-3 was-validated">
                                                                <label for="inputField"
                                                                    class="form-label">น้ำหนักแรกคลอดลูกโค</label>
                                                                <input type="float" class="form-control" id="calf_weight"
                                                                    name="calf_weight" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="inputField" class="form-label">หมายเหตุ</label>
                                                                <textarea type="text" class="form-control" id="calf_note"
                                                                    name="calf_note" rows="3"
                                                                    pattern="[^' '][a-zA-Zก-๙0-9]+"></textarea>
                                                            </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">ปิด</button>
                                                        <button type="submit" class="btn btn-primary"
                                                            name="addcalf">บันทึก</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- แก้ไขข้อมูลผสมพันธุ์ -->
                                        <div class="modal" id="editbreed<?php echo $row['breed_id']; ?>" tabindex="-1"
                                            aria-labelledby="editbreed<?php echo $row['breed_id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5"
                                                            id="editbreed<?php echo $row['breed_id']; ?>">
                                                            แก้ไขข้อมูลผสมพันธุ์</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form
                                                            action="pregnancycheck.php?breed_id=<?php echo $row['breed_id']; ?>"
                                                            method="post" class="form" enctype="multipart/form-data">
                                                            <?php
                                                            $pre = mysqli_query($conn, "select * from cow_breed inner join cow on cow_breed.cow_id = cow.cow_id where breed_id='" . $row['breed_id'] . "'");
                                                            $cpre = mysqli_fetch_array($pre);
                                                            ?>
                                                            <div class="mb-3">
                                                                <label for="id" class="form-label">รหัสโคที่รับการผสม
                                                                    : </label>
                                                                <input type="decimal" class="form-control" name="cow_id"
                                                                    value="<?php echo $cpre['cow_id']; ?>" disabled="disabled">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="id" class="form-label">ชื่อโคที่รับการผสม :
                                                                </label>
                                                                <input type="decimal" class="form-control" name="cow_name"
                                                                    value="<?php echo $cpre['cow_name'] ?>" disabled="disabled">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="date" class="form-label">วันที่ผสมพันธุ์</label>
                                                                <input type="date" class="form-control" name="breed_date"
                                                                    value="<?php echo $cpre['breed_date']; ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="breeder"
                                                                    class="form-label">ชื่อพ่อพันธุ์/น้ำเชื้อ</label>
                                                                <input type="text" class="form-control" name="breed_breeder"
                                                                    value="<?php echo $cpre['breed_breeder']; ?>"
                                                                    disabled="disabled">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="officer" class="form-label">ผู้ผสมพันธุ์</label>
                                                                <input type="text" class="form-control" name="cow_breed_officer"
                                                                    value="<?php echo $cpre['cow_breed_officer']; ?>"
                                                                    disabled="disabled">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="officer"
                                                                    class="form-label">ผลการตรวจท้อง</label><br>
                                                                <input type="radio" class="btn-check" name="options-outlined"
                                                                    value='ผสมติด' id="success-outlined" autocomplete="off"
                                                                    checked>
                                                                <label class="btn btn-outline-success"
                                                                    for="success-outlined">ผสมติด</label>
                                                                <input type="radio" class="btn-check" name="options-outlined"
                                                                    value='ผสมไม่ติด' id="danger-outlined" autocomplete="off">
                                                                <label class="btn btn-outline-danger"
                                                                    for="danger-outlined">ผสมไม่ติด</label>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="exampleFormControlTextarea1"
                                                                    class="form-label">หมายเหตุ</label>
                                                                <textarea class="form-control" id="exampleFormControlTextarea1"
                                                                    rows="3" name="note"
                                                                    pattern="[^' '][a-zA-Zก-๙0-9]+"></textarea>
                                                            </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">ปิด</button>
                                                        <button type="submit" class="btn btn-primary"
                                                            name="pregnancycheck">บันทึก</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- รายละเอียดเพิ่มเติม -->
                                        <div class="modal" id="detailcalf<?php echo $row['breed_id']; ?>" tabindex="-1"
                                            aria-labelledby="calfcheck<?php echo $row['breed_id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5"
                                                            id="detailcalf<?php echo $row['breed_id']; ?>">
                                                            รายละเอียดเพิ่มเติม</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                                                        $pre = mysqli_query($conn, "select * from cow_breed inner join cow on cow_breed.cow_id = cow.cow_id where breed_id='" . $row['breed_id'] . "'");
                                                        $cpre = mysqli_fetch_array($pre);
                                                        ?>
                                                        <div class="mb-3" id="calf_no">
                                                            <label for="calf_no" class="form-label">รหัสลูกโค</label>
                                                            <input type="text" class="form-control" id="calf_no" name="calf_no"
                                                                value="<?php echo $cpre['calf_no']; ?>"
                                                                disabled="disabled"></input>
                                                        </div>
                                                        <div class="mb-3" id="calf_gender">
                                                            <label for="calf_gender" class="form-label">เพศลูกโค</label>
                                                            <input type="text" class="form-control" id="calf_gender"
                                                                name="calf_gender" value="<?php echo $cpre['calf_gender']; ?>"
                                                                disabled="disabled"></input>
                                                        </div>
                                                        <div class="mb-3" id="calf_bday">
                                                            <label for="calf_bday" class="form-label">วันคลอดลูกโค</label>
                                                            <input type="text" class="form-control" id="calf_bday"
                                                                name="calf_bday"
                                                                value="<?php echo date("d-m-Y", strtotime($cpre["calf_bday"])); ?>"
                                                                disabled="disabled"></input>
                                                        </div>
                                                        <div class="mb-3" id="calf_weight">
                                                            <label for="calf_weight" class="form-label">น้ำหนักแรกเกิด</label>
                                                            <input type="text" class="form-control" id="calf_weight"
                                                                name="calf_weight" value="<?php echo $cpre['calf_weight']; ?>"
                                                                disabled="disabled">
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">ปิด</button>
                                                        <button type="submit" class="btn btn-primary">บันทึก</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </tr>
                                <?php }
                            } else if ($result1 && $result1->num_rows == 0) {
                                echo "<td colspan='9' class='no-data-message' style='padding:2em; text-align:center;'>ยังไม่มีข้อมูล</td> ";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var today = new Date().toISOString().split('T')[0]; // วันที่ปัจจุบันในรูปแบบ ISO
            var dateInput = document.getElementById('breed_date');
            var calfInput = document.getElementById('calf_bday');

            dateInput.max = today; // กำหนดค่าสูงสุดให้เป็นวันที่ปัจจุบัน
            calfInput.max = today; // กำหนดค่าสูงสุดให้เป็นวันที่ปัจจุบัน

            dateInput.addEventListener('change', function () {
                var selectedDate = new Date(dateInput.value);

                if (selectedDate > new Date(today)) {
                    alert("ไม่สามารถเลือกวันที่เกินวันปัจจุบันได้");
                    dateInput.value = today; // เซ็ตค่าวันที่ให้เป็นวันปัจจุบัน
                }
            });
            calfInput.addEventListener('change', function () {
                var selectedcalfDate = new Date(calfInput.value);

                if (selectedcalfDate > new Date(today)) {
                    alert("ไม่สามารถเลือกวันที่เกินวันปัจจุบันได้");
                    calfInput.value = today; // เซ็ตค่าวันที่ให้เป็นวันปัจจุบัน
                }
            });
        });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const calfStatusSelect = document.getElementById('dropdown');
        const calfNoInput = document.getElementById('calf_no');
        const calfBdayInput = document.getElementById('calf_bday');
        const calfWeightInput = document.getElementById('calf_weight');
        const calfNoteInput = document.getElementById('calf_note');

        calfStatusSelect.addEventListener('change', function () {
            if (this.value === 'แท้ง') {
                // ปิดฟิลด์ที่ไม่จำเป็น
                calfNoInput.setAttribute('disabled', true);
                calfBdayInput.setAttribute('disabled', true);
                calfWeightInput.setAttribute('disabled', true);
                calfNoteInput.setAttribute('disabled', true);
            } else {
                // เปิดฟิลด์ที่ปิดไว้
                calfNoInput.removeAttribute('disabled');
                calfBdayInput.removeAttribute('disabled');
                calfWeightInput.removeAttribute('disabled');
                calfNoteInput.removeAttribute('disabled');
            }
        });
    });
</script>


    <?php
    if (isset ($_SESSION['resultData'])) {
        $resultData = $_SESSION['resultData'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'เพิ่มข้อมูลสำเร็จ',
                        text: '" . $resultData . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
        unset($_SESSION['resultData']);
    }


    if (isset ($_SESSION['sData'])) {
        $editData = $_SESSION['sData'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'รหัสโคนี้ถูกใช้แล้ว',
                        text: '" . $editData . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: true,
                    });
                });
            </script>";
        unset($_SESSION['sData']);
    }
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector("#menu a[href='index_breed_cow.php']").classList.add("active");
        });
    </script>
</body>

</html>