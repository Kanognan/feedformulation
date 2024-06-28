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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <title>ผลผลิตของโค</title>

    <style>
    * {
        margin: 0;
        padding: 0;
        font-family: 'kanit';

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
        .g-2{
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
                text-align: left !important; /* จัดตำแหน่งข้อความชิดซ้าย */
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
            <?php include('sidebar.php') ?>
        </div>
        <div class="g-2">
            <div class="content">
                <div class="col-12 col-md-6 col-lg-12 mb-3" id="box">
                    <h3 class="title-detail">ผลผลิตของโค</h3>
                    <!----------------------------------------------------------------------------------------------------------- -->
                    <div class="add row">
                        <div class="col-2">
                            <button type="button" class="breed" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                เพิ่มรายการ
                            </button>
                        </div>
                    </div>
                    <!-- เพิ่มข้อมูลผลผลิตของโค -->
                    <div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">เพิ่มข้อมูลผลผลิตของโค</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="cow_milk_db.php" method="post" class="form" enctype="multipart/form-data">
                                    <?php
                                            $sql = "SELECT * FROM cow 
                                            WHERE acc_id = $acc_id AND deleteAt IS NULL AND cow_breed_status = 'ให้นม'
                                            ORDER BY createAt DESC";
                                            $result = $conn->query($sql);
                                            if($result->num_rows > 0){
                                        ?>
                                    <div class="modal-body">
                                        <div class="mb-3 was-validated">
                                            <label for="cow_id" class="form-label">รหัสโคที่ให้ผลผลิต</label><br>
                                            <div class="input-group">
                                                <select class="form-select" id="cow_id"
                                                    aria-label="Example select with button addon" name="cow_id" required>
                                                    <option value="" selected disabled>เลือกโค</option>
                                                    <?php
                                                        while ($raw = $result->fetch_assoc()):;
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
                                            <label for="date" class="form-label">วันที่รีด</label>
                                            <input type="date" class="form-control" name="date_milk" id="date_milk" required>
                                        </div>
                                        <div class="mb-3 was-validated">
                                            <label for="breeder"
                                                class="form-label">ปริมาณน้ำนมรวม/วัน(หน่วยกิโลกรัม)</label>
                                            <input type="float" class="form-control" name="milk_amount"
                                                placeholder="กรอกปริมาณน้ำนมรวม/วัน(หน่วยกิโลกรัม)" required>
                                        </div>

                                        <div class="mb-3 was-validated">
                                            <label for="officer" class="form-label">ปริมาณไขมันในน้ำนม(%)</label>
                                            <input type="float" class="form-control" name="milk_fat"
                                                placeholder="กรอกปริมาณไขมันในน้ำนม(%)" required>
                                        </div>
                                        <div class="mb-3 was-validated">
                                            <label for="officer" class="form-label">ปริมาณโปรตีนในน้ำนม(%)</label>
                                            <input type="float" class="form-control" name="milk_protein"
                                                placeholder="กรอกปริมาณโปรตีนในน้ำนม(%)" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="calf_no" class="form-label">หมายเหตุ</label>
                                            <textarea type="text" class="form-control" name="note"
                                                pattern="[^' '][a-zA-Zก-๙0-9]+"></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">ปิด</button>
                                            <button type="submit" class="btn btn-primary"
                                                name="milk">เพิ่มข้อมูล</button>
                                        </div>
                                        <?php 
                                             }else if($result->num_rows === 0){
                                                echo "<p style='text-align: center; color: gray; margin-top: 2em;'>คุณยังไม่มีข้อมูลโค?
                                                <span><a style='text-decoration: underline; color: #6999C6'
                                                        href='../cow/addcow.php'>เพิ่มข้อมูลโค</a></span><br>
                                                        <span style='color: red;'>*ต้องเป็นโคที่อยู่ในช่วงให้นม<span>
                                            </p>";?>
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
                    <!----------------------------------------------------------------------------------------------------------- -->
                    <!-- ดึงข้อมูลจากดาต้าเบส -->
                    <?php
                        $sql = "SELECT * FROM cow_milk 
                        inner join cow on cow_milk.cow_id = cow.cow_id 
                        WHERE acc_id = $acc_id AND cow.deleteAt IS NULL 
                        ORDER BY cow_milk.createAt DESC";
                        $result = $conn->query($sql);
                        ?>

                    <table class="table" id="table" data-filter-control="true" data-toggle="table"
                        data-pagination="true" data-locale="th-TH" data-flat="true" data-icons="icons"
                        data-toggle="table" data-search="true" data-search-highlight="true">
                        <thead>
                            <tr class='table table-primary' style='text-align:center;'>
                                <th>วัน/เดือน/ปี</th>
                                <th>รหัสโคที่ให้ผลผลิต</th>
                                <th>ชื่อโค</th>
                                <th>น้ำนม/วัน(กก.)</th>
                                <th>ปริมาณไขมันในน้ำนม</th>
                                <th>ปริมาณโปรตีนในน้ำนม</th>
                                <th>หมายเหตุ</th>
                                <th data-searchable="false">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="table-group text-center">
                            <?php
                                if ($result && $result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td> <?php echo date("d-m-Y",strtotime($row["date_milk"])); ?></td>
                                <td><?php echo $row["cow_id"], " "; ?></td>
                                <td><?php echo $row["cow_name"], " "; ?></td>
                                <td><?php echo $row["milk_amount"], " "; ?></td>
                                <td><?php echo $row["milk_fat"]; ?></td>
                                <td><?php echo $row["milk_protein"]; ?></td>
                                <td><?php echo $row["note"]; ?></td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#milkedit<?php echo $row['cow_milk_id']; ?>">
                                        <span class="glyphicon glyphicon-edit"></span><img src="../pic/edit.png" alt=""
                                            style="width:12px; height:12px; " title="แก้ไขข้อมูลโค">
                                    </button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#milkdel<?php echo $row['cow_milk_id']; ?>">
                                        <span class="glyphicon glyphicon-trash"></span><img src="../pic/delete.png"
                                            alt="" style="width:12px; height:12px; " title="ลบข้อมูลโค">
                                    </button>
                                    <?php include('cow_update_model.php'); ?>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal" id="milkedit<?php echo $row['cow_milk_id']; ?>" tabindex="-1"
                                aria-labelledby="milkedit<?php echo $row['cow_milk_id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5"
                                                id="milkedit<?php echo $row['cow_milk_id']; ?>">
                                                แก้ไขข้อมูลผลผลิต
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                                                $milk = mysqli_query($conn, "select * from cow_milk where cow_milk_id='" . $row['cow_milk_id'] . "'");
                                                                $cmilk = mysqli_fetch_array($milk);
                                                                ?>
                                            <form
                                                action="edit_milk_db.php?cow_milk_id=<?php echo $cmilk['cow_milk_id']; ?>"
                                                method="post">
                                                <div class="container-pot">
                                                    <div class="row">
                                                        <div class="col-12-topic"><label
                                                                for="date_milk">วันที่รีด</label><br>
                                                            <input type="date" class="form-control" id="date_milk"
                                                                name="date_milk" require
                                                                value="<?php echo $cmilk['date_milk']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12-topic"><label
                                                                for="milk_amount">ปริมาณน้ำนมรวม/วัน
                                                                (หน่วยกิโลกรัม)</label><br>
                                                            <input type="text" class="form-control" id="milk_amount"
                                                                name="milk_amount"
                                                                value="<?php echo $cmilk['milk_amount']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12-topic"><label
                                                                for="milk_fat">ปริมาณไขมันในน้ำนม</label><br>
                                                            <input type="float" class="form-control" id="milk_fat"
                                                                name="milk_fat"
                                                                value="<?php echo $cmilk['milk_fat']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12-topic"><label
                                                                for="milk_protein">ปริมาณโปรตีนในน้ำนม</label><br>
                                                            <input type="float" class="form-control" id="milk_protein"
                                                                name="milk_protein"
                                                                value="<?php echo $cmilk['milk_protein']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12-topic"><label for="note">หมายเหตุ</label><br>
                                                            <input type="text" class="form-control" id="note"
                                                                name="note" value="<?php echo $cmilk['note']; ?>"
                                                                pattern="[^' '][a-zA-Zก-๙0-9]+">
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
                                </div>
                            </div>
                            <?php }
            } else if ($result && $result->num_rows == 0) {
                echo "<td colspan='8' class='no-data-message' style='padding:2em; text-align:center;'>ยังไม่มีข้อมูล</td> ";
                            
            }
            ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var today = new Date().toISOString().split('T')[0]; // วันที่ปัจจุบันในรูปแบบ ISO
        var dateInput = document.getElementById('date_milk');

        dateInput.max = today; // กำหนดค่าสูงสุดให้เป็นวันที่ปัจจุบัน

        dateInput.addEventListener('change', function() {
            var selectedDate = new Date(dateInput.value);
            if (selectedDate > new Date(today)) {
                alert("ไม่สามารถเลือกวันที่เกินวันปัจจุบันได้");
                dateInput.value = today; // เซ็ตค่าวันที่ให้เป็นวันปัจจุบัน
            }
        });
    });
    </script>

    <?php
    if (isset($_SESSION['resultData'])) {
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
    }?>
    <?php
    if (isset($_SESSION['editData'])) {
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
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector("#menu a[href='index_milk_cow.php']").classList.add("active");
    });
    </script>

</body>

</html>