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
    <title>การเจ็บป่วยของโค</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'kanit';
            /* color:black; */

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
</script>

<body>
    <?php include ('nav-bar.php');
    $acc_id = $_SESSION['acc_id'];

    ?>
    <div class="flex">
        <div class="g-1">
            <?php include ('sidebar.php') ?>
        </div>
        <div class="g-2">
            <div class="content">
                <div class="col-12 col-md-6 col-lg-12 mb-3" id="box">
                    <h3 class="title-detail">การตรวจโรคประจำปี</h3>
                    <div class="add row">
                        <div class="col-2">
                            <button type="button" class="breed" data-bs-toggle="modal" data-bs-target="#dianosis">
                                เพิ่มรายการ
                            </button>
                        </div>
                    </div>
                    <!-- เพิ่มข้อมูลการตรวจโรค -->
                    <div class="modal" id="dianosis" tabindex="-1" aria-labelledby="dianosis" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="dianosis">เพิ่มข้อมูลการตรวจโรค</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="cow_dianosis_db.php" method="post" class="form"
                                    enctype="multipart/form-data">
                                    <?php
                                    $sql = "SELECT * FROM cow WHERE acc_id = $acc_id AND deleteAt IS NULL order by createAt DESC";
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        ?>
                                        <div class="modal-body">
                                            <div class="mb-3 was-validated">
                                                <label for="cow_id" class="form-label">รหัสโคที่ตรวจ</label><br>
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
                                                <label for="date" class="form-label">วันที่ตรวจโรค</label>
                                                <input type="date" class="form-control" name="dianosis_date"
                                                    id="dianosis_date" required>
                                            </div>
                                            <div class="mb-3 was-validated">
                                                <label for="type_dianosis" class="form-label">โรคที่ตรวจ</label>
                                                <select class="form-select" id="type_dianosis"
                                                    aria-label="Example select with button addon" name="type_dianosis_id"
                                                    required>
                                                    <option value="" selected disabled>เลือกโรคที่ตรวจ</option>
                                                    <?php
                                                    $sql = "SELECT * FROM type_dianosis";
                                                    $result = $conn->query($sql);
                                                    while ($raw = $result->fetch_assoc()):
                                                        ;
                                                        ?>
                                                        <option value="<?php echo $raw["type_dianosis_id"]; ?>">
                                                            <?php echo $raw["type_dianosis_name"]; ?>
                                                        </option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                            <div class="mb-3 was-validated">
                                                <label for="breeder" class="form-label">ผลที่ตรวจ</label>
                                                <textarea type="text" class="form-control" name="disease_result"
                                                    pattern="[a-zA-Z]+([a-zA-Z0-9\s,\-\.\(/)]*)" required></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">ปิด</button>
                                                <button type="submit" class="btn btn-primary"
                                                    name="dia">เพิ่มข้อมูล</button>
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
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- ---------------------------------------------------------------------------------------------------------- -->
                    <!-- ดึงข้อมูลจากดาต้าเบส -->
                    <?php
                    $sql = "SELECT * FROM cow_dianosis 
                        inner join type_dianosis on type_dianosis.type_dianosis_id = cow_dianosis.type_dianosis_id
                        inner join cow on cow_dianosis.cow_id = cow.cow_id WHERE acc_id = $acc_id AND cow.deleteAt IS NULL
                        ORDER BY cow_dianosis.createAt DESC";
                    $result = $conn->query($sql);
                    ?>
                    <table class="table" id="table" data-filter-control="true" data-toggle="table"
                        data-pagination="true" data-locale="th-TH" data-flat="true" data-icons="icons"
                        data-toggle="table" data-search="true" data-search-highlight="true">
                        <thead>
                            <tr class='table table-primary' style='text-align:center;'>
                                <th data-field="breed_date">วัน/เดือน/ปี</th>
                                <th data-field="cow_id">รหัสโคที่ตรวจ</th>
                                <th data-field="cow_name">ชื่อโค</th>
                                <th data-field="breed_breeder">โรคที่ตรวจ</th>
                                <th data-field="cow_breed_officer">ผลการตรวจ</th>
                                <th data-searchable="false">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="table-group text-center">
                            <?php
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td style="text-align:center">
                                            <?php echo date("d-m-Y", strtotime($row["dianosis_date"])); ?>
                                        </td>
                                        <td style="text-align:center">
                                            <?php echo $row["cow_id"]; ?>
                                        </td>
                                        <td style="text-align:center">
                                            <?php echo $row["cow_name"]; ?>
                                        </td>
                                        <td style="text-align:center">
                                            <?php echo $row["type_dianosis_name"], " "; ?>
                                        </td>
                                        <td style="text-align:center">
                                            <?php echo $row["disease_result"]; ?>
                                        </td>
                                        <td style="text-align:center">
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#dianosisedit<?php echo $row['cow_dianosis_id']; ?>">
                                                <span class="glyphicon glyphicon-edit"></span><img src="../pic/edit.png" alt=""
                                                    style="width:12px; height:12px; " title="แก้ไขข้อมูลโค">
                                            </button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#dianosisdel<?php echo $row['cow_dianosis_id']; ?>">
                                                <span class="glyphicon glyphicon-trash"></span><img src="../pic/delete.png"
                                                    alt="" style="width:12px; height:12px; " title="ลบข้อมูลโค"></button>
                                            <?php include ('../cow/cow_update_model.php'); ?>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal" id="dianosisedit<?php echo $row['cow_dianosis_id']; ?>" tabindex="-1"
                                        aria-labelledby="#dianosisedit<?php echo $row['cow_dianosis_id']; ?>"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form
                                                    action="edit_dianosis_db.php?cow_dianosis_id=<?php echo $row['cow_dianosis_id']; ?>"
                                                    method="post">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5"
                                                            id="dianosisedit<?php echo $row['cow_dianosis_id']; ?>">
                                                            แก้ไขข้อมูลการตรวจโรคประจำปี</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                                                        $dianosis = mysqli_query($conn, "select * from cow_dianosis where cow_dianosis_id='" . $row['cow_dianosis_id'] . "'");
                                                        $cdianosis = mysqli_fetch_array($dianosis);
                                                        $tdia = mysqli_query($conn, "select * from cow_dianosis inner join type_dianosis on cow_dianosis.type_dianosis_id = type_dianosis.type_dianosis_id");
                                                        $ctdia = mysqli_fetch_array($tdia);
                                                        ?>

                                                        <div class="container-pot">
                                                            <div class="row">
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12-topic"><label
                                                                        for="dianosis_date">วัน/เดือน/ปีที่ตรวจโรค</label><br>
                                                                    <input type="date" class="form-control" id="dianosis_date"
                                                                        name="dianosis_date"
                                                                        value="<?php echo $cdianosis['dianosis_date']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12-topic">
                                                                    <label for="type_dianosis_name">โรคที่ตรวจ</label><br>
                                                                    <select class="form-select" id="type_dianosis_name"
                                                                        name="type_dianosis_name">
                                                                        <?php
                                                                        $sql_dianosis = "SELECT * FROM cow_dianosis 
                                                                                    inner join type_dianosis
                                                                                    on cow_dianosis.type_dianosis_id = type_dianosis.type_dianosis_id
                                                                                    where cow_dianosis_id = '" . $row['cow_dianosis_id'] . "'";
                                                                        $rds = $conn->query($sql_dianosis);
                                                                        $result_dianosis = mysqli_fetch_assoc($rds);
                                                                        ?>
                                                                        <?php
                                                                        $sql_dianosis_all = "SELECT * FROM type_dianosis";
                                                                        $result_dianosis_all = $conn->query($sql_dianosis_all);
                                                                        while ($row_dianosis = mysqli_fetch_assoc($result_dianosis_all)) {
                                                                            $selected = ($row_dianosis["type_dianosis_id"] == $result_dianosis["type_dianosis_id"]) ? "selected" : "";
                                                                            echo "<option value='{$row_dianosis["type_dianosis_id"]}' $selected>{$row_dianosis["type_dianosis_name"]}</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12-topic"><label
                                                                        for="disease_result">ผลการตรวจ</label><br>
                                                                    <input type="text" class="form-control" id="disease_result"
                                                                        name="disease_result"
                                                                        value="<?php echo $cdianosis['disease_result']; ?>"
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
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            } else if ($result && $result->num_rows == 0) {
                                echo "<td colspan='8'class='no-data-message' style='padding:2em; text-align:center;'>ยังไม่มีข้อมูล</td> ";
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
            var dateInput = document.getElementById('dianosis_date');

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
            document.querySelector("#menu a[href='index_dianosis_cow.php']").classList.add("active");
        });
    </script>
</body>

</html>