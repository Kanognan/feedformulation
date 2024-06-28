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
    <title>การฉีดวัคซีน</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'kanit';
            /* color:black; */

        }

        .add .btn:hover,
        .add .btn:focus,
        button[type=submit]:hover {
            background-color: #AACCE2;
            color: black;
        }


        .title-detail {
            text-align: center;
            margin-bottom: 1.5em;
        }

        .detail {
            margin-top: 1.2em;
            background-color: #c6d9eb !important;
            /* padding: 1.2em; */
            border-radius: 15px;
            height: 30em;

        }

        .detail-topic {
            font-size: 1.2em;
            font-weight: 500;
            margin-bottom: 1em;
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

<body>
    <?php
    $acc_id = $_SESSION['acc_id'];

    ?>
    <div class="flex">
        <div class="g-1">
            <?php include ('sidebar.php') ?>
        </div>
        <div class="g-2">

            <div class="content">
                <div class="col-12 col-md-6 col-lg-12 mb-3" id="box">
                    <h3 class="title-detail">การฉีดวัคซีน</h3>
                    <!-- ------------------------------------------------------------------------------------------------- -->
                    <div class="add row">
                        <div class="col-2">
                            <button type="button" class="breed" data-bs-toggle="modal" data-bs-target="#addvaccine">
                                เพิ่มรายการ
                            </button>
                        </div>
                    </div>
                    <!-- เพิ่มข้อมูลการฉีควัคซีน -->
                    <div class="modal" id="addvaccine" tabindex="-1" aria-labelledby="vaccine" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="addvaccine">เพิ่มข้อมูลการฉีควัคซีน</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="cow_vaccine_db.php" method="post" class="form"
                                    enctype="multipart/form-data">
                                    <div class="mb-3 was-validated">
                                        <?php
                                        $sql = "SELECT * FROM cow WHERE acc_id = $acc_id AND deleteAt IS NULL order by createAt DESC";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            ?>
                                            <div class="modal-body">
                                                <label for="cow_id" class="form-label">รหัสโคที่ตรวจ</label><br>
                                                <div class="input-group">
                                                    <select class="form-select" id="cow_id" required
                                                        aria-label="Example select with button addon" name="cow_id">
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
                                                </div><br>
                                                <div class="mb-3 was-validated">
                                                    <label for="date" class="form-label">วัน/เดือน/ปีที่ฉีดวัคซีน</label>
                                                    <input type="date" class="form-control" name="date_cow_vaccine"
                                                        id="date_cow_vaccine" required>
                                                </div>
                                                <div class="mb-3 was-validated">
                                                    <label for="type_vaccine" class="form-label">ประเภทของวัคซีน</label>
                                                    <select class="form-select" id="type_vaccine" required
                                                        aria-label="Example select with button addon"
                                                        name="type_vaccine_id">
                                                        <option value="" selected disabled>เลือกวัคซีน</option>
                                                        <?php
                                                        $sql = "SELECT * FROM type_vaccine";
                                                        $result = $conn->query($sql);
                                                        while ($raw = $result->fetch_assoc()) {
                                                            ?>
                                                            <option value="<?php echo $raw["type_vaccine_id"]; ?>">
                                                                <?php echo $raw["type_vaccine_name"]; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3 was-validated">
                                                    <label for="breeder" class="form-label">ผู้ฉีดวัคซีน</label>
                                                    <input type="text" class="form-control" name="vaccine_officer" required
                                                        pattern="[a-zA-Z]+([a-zA-Z0-9\s,\-\.\(/)]*)">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">ปิด</button>
                                                    <button type="submit" class="btn btn-primary"
                                                        name="vaccine">เพิ่มข้อมูล</button>
                                                </div>
                                            <?php
                                        } else if ($result->num_rows === 0) {
                                            echo "<p style='text-align: center; color: gray; margin-top: 2em;'>คุณยังไม่มีข้อมูลโค?
                                                <span><a style='text-decoration: underline; color: #6999C6'
                                                        href='../cow/addcow.php'>เพิ่มข้อมูลโค</a></span>
                                            </p>"; ?>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">ปิด</button>
                                                    </div>
                                                <?php
                                        }
                                        ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- ------------------------------------------------------------------------------------------------- -->
                    <!-- ดึงข้อมูลจากดาต้าเบส -->
                    <?php
                    $sql = "SELECT * FROM type_vaccine 
                        inner join cow_vaccine on type_vaccine.type_vaccine_id =  cow_vaccine.type_vaccine_id
                        inner join cow on cow_vaccine.cow_id = cow.cow_id WHERE acc_id = $acc_id AND cow.deleteAt IS NULL
                        ORDER BY cow_vaccine.createAt DESC";
                    $result = $conn->query($sql);
                    ?>

                    <table class="table" id="table" data-filter-control="true" data-toggle="table"
                        data-pagination="true" data-locale="th-TH" data-flat="true" data-icons="icons"
                        data-toggle="table" data-search="true" data-search-highlight="true">
                        <thead>
                            <tr class='table table-primary' style='text-align:center;'>
                                <th>วัน/เดือน/ปี</th>
                                <th>รหัสโคที่ฉีด</th>
                                <th>ชื่อโค</th>
                                <th>ประเภทของวัคซีน</th>
                                <th>ผู้ฉีดวัคซีน</th>
                                <th data-searchable="false">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="table-group text-center">
                            <?php
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo date("d-m-Y", strtotime($row["date_cow_vaccine"])); ?>
                                        </td>
                                        <td>
                                            <?php echo $row["cow_id"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["cow_name"]; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["type_vaccine_name"], " "; ?>
                                        </td>
                                        <td>
                                            <?php echo $row["vaccine_officer"]; ?>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editvaccine<?php echo $row['cow_vaccine_id']; ?>">
                                                </span><img src="../pic/edit.png" alt="" style="width:12px; height:12px; "
                                                    title="แก้ไขข้อมูลโค">
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#vaccinedel<?php echo $row['cow_vaccine_id']; ?>">
                                                <span class="glyphicon glyphicon-trash"></span><img src="../pic/delete.png"
                                                    alt="" style="width:12px; height:12px; " title="ลบข้อมูลโค">
                                            </button>
                                            <?php include ('cow_update_model.php'); ?>
                                        </td>
                                    </tr>
                                    <!-- แก้ไขข้อมูลฉีดวัคซีน -->
                                    <div class="modal" id="editvaccine<?php echo $row['cow_vaccine_id']; ?>" tabindex="-1"
                                        aria-labelledby="editvaccine<?php echo $row['cow_vaccine_id']; ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form
                                                action="edit_vaccine_db.php?cow_vaccine_id=<?php echo $row['cow_vaccine_id']; ?>"
                                                method="post">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5"
                                                            id="editvaccine<?php echo $row['cow_vaccine_id']; ?>">
                                                            แก้ไขข้อมูลฉีดวัคซีน</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                                                        $vaccine = mysqli_query($conn, "select * from cow_vaccine where cow_vaccine_id='" . $row['cow_vaccine_id'] . "'");
                                                        $cvaccine = mysqli_fetch_array($vaccine);
                                                        $tvac = mysqli_query($conn, "select * from cow_vaccine inner join type_vaccine on cow_vaccine.type_vaccine_id = type_vaccine.type_vaccine_id");
                                                        $ctvac = mysqli_fetch_array($tvac);
                                                        ?>

                                                        <div class="container-pot">
                                                            <div class="row">
                                                                <div class="col-12-topic"><label
                                                                        for="date_cow_vaccine">วัน/เดือน/ปีที่ฉีดวัคซีน</label><br>
                                                                    <input type="date" class="form-control"
                                                                        id="date_cow_vaccine" name="date_cow_vaccine" require
                                                                        value="<?php echo $cvaccine['date_cow_vaccine']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12-topic"><label
                                                                        for="type_vaccine_name">ประเภทของวัคซีน</label><br>
                                                                    <select class="form-select" id="type_vaccine_id"
                                                                        name="type_vaccine_id">
                                                                        <?php
                                                                        $sql_vaccine = "SELECT * FROM cow_vaccine 
                                                                                inner join type_vaccine
                                                                                on cow_vaccine.type_vaccine_id = type_vaccine.type_vaccine_id
                                                                                where cow_vaccine_id = '" . $row['cow_vaccine_id'] . "'";
                                                                        $rvs = $conn->query($sql_vaccine);
                                                                        $result_vaccine = mysqli_fetch_assoc($rvs);
                                                                        // วนลูปเพื่อแสดง dropdown ทั้งหมด
                                                                        ?>
                                                                        <?php
                                                                        $sql_vaccine_all = "SELECT * FROM type_vaccine";
                                                                        $result_vaccine_all = $conn->query($sql_vaccine_all);
                                                                        while ($row_vaccine = mysqli_fetch_assoc($result_vaccine_all)) {
                                                                            $selected = ($row_vaccine["type_vaccine_id"] == $result_vaccine["type_vaccine_id"]) ? "selected" : "";
                                                                            echo "<option value='{$row_vaccine["type_vaccine_id"]}' $selected>{$row_vaccine["type_vaccine_name"]}</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12-topic"><label
                                                                        for="vaccine_officer">ผู้ฉีดวัคซีน</label><br>
                                                                    <input type="text" class="form-control" id="vaccine_officer"
                                                                        name="vaccine_officer"
                                                                        value="<?php echo $cvaccine['vaccine_officer']; ?>"
                                                                        pattern="[a-zA-Z]+([a-zA-Z0-9\s,\-\.\(/)]*)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">ปิด</button>
                                                        <button type="submit" class="btn btn-primary">ยืนยัน</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                <?php }
                            } else if ($result && $result->num_rows == 0) {
                                echo "<td colspan='8' class='no-data-message' style='padding:2em; text-align:center;'>ยังไม่มีข้อมูล</td> ";
                            }
                            ?>
                        </tbody>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var today = new Date().toISOString().split('T')[0]; // วันที่ปัจจุบันในรูปแบบ ISO
            var dateInput = document.getElementById('date_cow_vaccine');

            dateInput.max = today; // กำหนดค่าสูงสุดให้เป็นวันที่ปัจจุบัน

            dateInput.addEventListener('change', function () {
                var selectedDate = new Date(dateInput.value);
                if (selectedDate > new Date(today)) {
                    alert("ไม่สามารถเลือกวันที่เกินวันปัจจุบันได้");
                    dateInput.value = today; // เซ็ตค่าวันที่ให้เป็นวันปัจจุบัน
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
    if (isset ($_SESSION['editData'])) {
        $editData = $_SESSION['editData'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'แก้ไขข้อมูลสำเร็จ',
                        text: '" . $editData . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
        unset($_SESSION['editData']);
    }
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector("#menu a[href='index_vaccine_cow.php']").classList.add("active");
        });
    </script>
</body>

</html>