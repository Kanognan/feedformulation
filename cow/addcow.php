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
	 <link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <title>เพิ่มข้อมูลโค</title>
    <style>
        .w {
            width: 100%;
            margin-top: 7em;
            background-color: white;
            padding-bottom: 2em;
        }

        .t-head {
            padding-top: 2em;
            text-align: center;
            width: 100%;
        }

        .card {
            display: flex;
            margin: 2em auto;
            width: 80%;
            padding: 1.5rem;
            border-radius: 20px !important;
            border: none !important;
            background-color: #c6d9eb !important;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
        }

        .col-6 {
            padding: 0.8rem 1.2rem 0.8rem 1.3rem;
        }

        .btn-more .btn-add {
            background-color: #77DC67;
            color: white;
            width: 8em;
            border-radius: 20px !important;
            margin: 0em 0.3em;
        }

        .btn-more .btn-add:hover {
            background-color: #6999C6 !important;
        }

        .btn-more .btn-cancel {
            background-color: #FE5E5E;
            color: white;
            width: 8em;
            border-radius: 20px !important;
            margin: 0em 0.3em;
        }

        .btn-more .btn-cancel:hover {
            background-color: #6999C6 !important;
        }



        .radio-button {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            margin-right: 1.1em;
            margin-top: 1px;
            background-color: #d5e6fc;
            padding: 0.4em 0em 0.4em 1.5em;
            transition: background-color 0.3s;
            border-radius: 5px;
            width: 100%;
        }

        .input-group>:not(:first-child):not(.dropdown-menu):not(.valid-tooltip):not(.valid-feedback):not(.invalid-tooltip):not(.invalid-feedback) {
            margin-left: calc(var(--bs-border-width) * -1);
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .input-group:not(.has-validation)>.dropdown-toggle:nth-last-child(n+3),
        .input-group:not(.has-validation)>.form-floating:not(:last-child)>.form-control,
        .input-group:not(.has-validation)>.form-floating:not(:last-child)>.form-select,
        .input-group:not(.has-validation)>:not(:last-child):not(.dropdown-toggle):not(.dropdown-menu):not(.form-floating) {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .radio-button:hover {
            background-color: #6999C6;
        }

        .custom-radio input {
            width: 10em;
            height: 2em;
            border: 2px solid #ccc;
            border-radius: 50%;
            display: inline-block;
            position: relative;
            margin: 0em 0.5rem;
            visibility: hidden;
            /* เอาบริเวณวงกลมด้านหน้าออก */
        }

        .radio-button:hover .custom-radio {
            background-color: #007bff;
            border-color: #007bff;
        }

        .custom-radio input[type="radio"]:checked+.custom-radio::before {
            content: "";
            width: 3em;
            height: 8px;
            background-color: #007bff;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            text-align: center;
            transform: translate(-50%, -50%);
        }

        .radio-text {
            font-size: 1rem;
            color: #212529;
            margin-left: 1em;

        }
		@media (max-width: 576px) {
          
    
            .card {
                width: 90%;
				margin: 1em auto;
				padding-left:5px;
				padding-right:5px;
            }

        
        }
    </style>
</head>

<body>
    <?php include 'nav-bar.php' ?>
    <div class="w">
        <h3 class="t-head">เพิ่มข้อมูลโค</h3>
        <div class="card">
            <div class="card-body">
                <form action="cow_action_db.php" method="post" enctype="multipart/form-data" name="form1">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="error">
                            <h3>
                                <?php
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                                ?>
                            </h3>
                        </div>
                    <?php endif ?>
                    <h4 class="topic">ข้อมูลทั่วไปของโค</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="meetfile" class="form-label">รูปภาพ</label>
                            <input class="form-control" type="file" id="meetfile" name="meetfile">
                        </div>
                        <div class="col-md-6 mb-3 was-validated" >
                            <label for="group_id" class="form-label">กลุ่มของโค</label><span style="color:red;"> *</span>
                            <div class="input-group">
                                <select class="form-select" id="group_id" aria-label="Example select with button addon"
                                    name="group_id" required>
                                    <option value="" selected disabled>เลือกกลุ่มโค</option>
                                    <option value="1">ไม่มีกลุ่ม</option>
                                    <?php
                                    $sql = "SELECT DISTINCT group_cow.group_id, group_cow.group_name 
                                    FROM cow 
                                    INNER JOIN group_cow ON cow.group_id = group_cow.group_id 
                                    WHERE acc_id = $acc_id AND group_cow.group_id <> 1";
                                    $result = $conn->query($sql);
                                    while ($row = $result->fetch_assoc()):
                                        ?>
                                        <option value="<?php echo $row["group_id"]; ?>">
                                            <!-- <?php echo $row["group_id"]; ?> -->
                                            <?php echo "กลุ่ม ", $row["group_name"]; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 was-validated"><label for="cow_id" class="form-label">รหัสโค</label><span
                                style="color:red;">
                                *</span><br>
                            <input class="form-control" type="text" id="cow_id" name="cow_id" required
                                placeholder="กรอกรหัสโค เช่น 24665 "
                                pattern="[a-zA-Z]+([a-zA-Z0-9\s,\-\.\(/)]*)">
                        </div>
                        <!-- ทำดรอปดาวน์ -->
                        <div class="col-md-6 mb-3 was-validated"><label for="cb_id" class="form-label">พันธุ์ของโค</label><span style="color:red;">
                                *</span><br>
                            <div class="input-group">
                                <select class="form-select" id="cb_id" aria-label="Example select with button addon"
                                    name="cb_id" required>
                                    <option value="" selected disabled>เลือกพันธุ์โค</option>
                                    <?php
                                    $sql = "SELECT * FROM cattle_breed WHERE cb_id != 0";
                                    $result = $conn->query($sql);
                                    while ($raw = $result->fetch_assoc()):
                                        ;
                                        ?>
                                        <option value="<?php echo $raw["cb_id"]; ?>">
                                            <?php echo $raw["cb_Thainame"]; ?>
                                            <?php echo "(" . $raw["cb_Engname"] . ")"; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 was-validated"><label for="cow_name" class="form-label">ชื่อของโค</label><span style="color:red;">
                                *</span><br>
                            <input class="form-control" type="text" id="cow_name" name="cow_name"
                                placeholder="กรอกชื่อของโค" pattern="[a-zA-Z]+([a-zA-Z0-9\s,\-\.\(/)]*)" required>
                        </div>
                        <!-- ทำดรอปดาวน์ -->
                        <div class="col-md-6 mb-3 was-validated"><label for="cow_bday" class="form-label">วันเกิดของโค</label><span style="color:red;">
                                *</span><br>
                            <input class="form-control" type="date" id="cow_bday" name="cow_bday" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 was-validated"><label for="cow_weight" class="form-label">น้ำหนักแรกเกิดของโค (กิโลกรัม)</label><span
                                style="color:red;">
                                *</span><br>
                            <input class="form-control" type="number" step="0.01" min="0" max="999" id="cow_weight"
                                name="cow_first_weight" placeholder="กรอกน้ำหนักแรกเกิดของโค เช่น 45" required>
                        </div>
                        <div class="col-md-6 mb-3 was-validated"><label for="cow_weight" class="form-label">น้ำหนักปัจจุบันของโค (กิโลกรัม)</label><span
                                style="color:red;">
                                *</span><br>
                            <input class="form-control" type="number" step="0.01" min="0" max="999" id="cow_weight"
                                name="cow_weight" placeholder="กรอกน้ำหนักปัจจุบันของโค เช่น 100" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-3 was-validated"><label for="cow_breed_status" class="form-label">สถานะการตั้งท้อง</label><span
                                style="color:red;">
                                *</span><br>
                            <div class="input-group">
                                <select class="form-select disabled-select" id="cow_breed_status"
                                    name="cow_breed_status" required>
                                    <option value="" selected disabled>เลือกสถานะการตั้งท้อง</option>
                                    <option value="ตั้งท้อง">ตั้งท้อง</option>
                                    <option value="ท้องว่าง">ท้องว่าง</option>
                                </select>
                            </div>
                            <span style="color:gray;">* โคอายุ 6 เดือนขึ้นไปเท่านั้น</span>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3 was-validated">
                            <label for="calf_date" class="form-label">อายุครรภ์ (วัน)</label><br>
                            <input class="form-control" type="number" id="calf_date" name="calf_date"
                                placeholder="กรอกอายุครรภ์ของโค " required>
                            <!-- <span style="color:gray;">* ถ้าไม่อยู่ในช่วงตั้งครรภ์ให้กรอก 0</span> -->
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3 was-validated"><label for="cow_milk_status" class="form-label">สถานะการให้นม</label><span
                                style="color:red;">
                                *</span><br>
                            <div class="input-group mb-3">
                                <select class="form-select disabled-select" id="cow_milk_status" name="cow_milk_status"
                                    required>
                                    <option value="" selected disabled>เลือกสถานะการให้นม</option>
                                    <option value="ให้นม">ให้นม</option>
                                    <option value="ไม่ให้นม">ไม่ให้นม</option>
                                    <option value="พักรีด">พักรีด</option>
                                    <!-- <option value="พักรีดนม">พักรีดนม</option> -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3 was-validated">
                            <label for="milk_date" class="form-label">วันให้นม (วัน)</label><br>
                            <input class="form-control" type="number" id="milk_date" name="milk_date"
                                placeholder="กรอกวันให้นมของโค " required>
                            <!-- <span style="color:gray;">* ถ้าไม่อยู่ในช่วงให้นมให้กรอก 0</span> -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 was-validated">
                            <label for="cow_activity" class="form-label">กิตติกรรมการเดิน</label><span style="color:red;">
                                *</span>
                            <div class="input-group mb-3">
                                <select class="form-select" id="cow_activity" name="cow_activity" required>
                                    <option value="" selected disabled>เลือกกิตติกรรมการเดิน</option>
                                    <option value="ขังคอก">ขังคอก</option>
                                    <option value="ปล่อยเล็มแปลงพืช">ปล่อยเล็มแปลงพืช</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="calf_gender" class="form-label">เพศโค<span style="color:red;">
                                    *</span></label><br>
                            <div class="d-flex justify-content">
                                <label class="radio-button">
                                    <input type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="เพศผู้">
                                    <span class="custom-radio"></span>
                                    <span class="radio-text">เพศผู้</span>
                                </label>
                                <label class="radio-button">
                                    <input type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked
                                        value="เพศเมีย">
                                    <span class="custom-radio"></span>
                                    <span class="radio-text">เพศเมีย</span>
                                </label>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="topic">ข้อมูลบรรพบุรุษของโค (ถ้ามี)</h4>
                <div class="row">
                    <div class="col-md-6 mb-3"><label for="cow_dad_id" class="form-label">รหัสพ่อโค</label><br>
                        <input class="form-control" type="text" id="cow_dad_id" name="cow_dad_id"
                            placeholder="กรอกรหัสพ่อโค เช่น 24665 " pattern="[^' '][a-zA-Zก-๙0-9]+">
                    </div>
                    <div class="col-md-6 mb-3"><label for="cow_dad_breed" class="form-label">พันธุ์ของพ่อโค</label><br>
                        <div class="input-group">
                            <select class="form-select" id="cow_dad_breed" aria-label="Example select with button addon"
                                name="cow_dad_breed">
                                <option value="">เลือกพันธุ์ของพ่อโค</option>
                                <?php
                                $sql = "SELECT * FROM cattle_breed";
                                $result = $conn->query($sql);
                                while ($raw = $result->fetch_assoc()):
                                    ;
                                    ?>
                                    <option value="<?php echo $raw["cb_id"]; ?>">
                                        <?php echo $raw["cb_Thainame"]; ?>
                                        <?php echo "(" . $raw["cb_Engname"] . ")"; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3"><label for="cow_mom_id" class="form-label">รหัสแม่โค</label><br>
                        <input class="form-control" type="text" id="cow_mom_id" name="cow_mom_id" require
                            placeholder="กรอกรหัสแม่โค เช่น 24665 " pattern="[^' '][a-zA-Zก-๙0-9]+">
                    </div>
                    <div class="col-md-6 mb-3"><label for="cow_mom_breed" class="form-label">พันธุ์ของแม่โค</label><br>
                        <div class="input-group">
                            <select class="form-select" id="cow_mom_breed" aria-label="Example select with button addon"
                                name="cow_mom_breed">
                                <option value="">เลือกพันธุ์ของแม่โค</option>
                                <?php
                                $sql = "SELECT * FROM cattle_breed";
                                $result = $conn->query($sql);
                                while ($raw = $result->fetch_assoc()):
                                    ;
                                    ?>
                                    <option value="<?php echo $raw["cb_id"]; ?>">
                                        <?php echo $raw["cb_Thainame"]; ?>
                                        <?php echo "(" . $raw["cb_Engname"] . ")"; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center btn-more">
            <div class="form-group">
                <button type="button"  onclick="window.location='cow.php'" class="btn btn-cancel">ย้อนกลับ</button>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-add confirm" name="addcow">ยืนยัน</button>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('cow_breed_status').addEventListener('change', function () {
            var select = document.getElementById('cow_breed_status');
            var calfDateInput = document.getElementById('calf_date');

            if (select.value == 'ตั้งท้อง') {
                calfDateInput.value = '';
                calfDateInput.placeholder = 'กรอกอายุครรภ์ของโค ';
                calfDateInput.required = true;
                calfDateInput.disabled = false;
            } else if (select.value == 'ท้องว่าง') {
                calfDateInput.value = '0';
                calfDateInput.placeholder = '';
                calfDateInput.required = false;
                calfDateInput.disabled = true;
            }
        });
    </script>
    <script>
        document.getElementById('cow_milk_status').addEventListener('change', function () {
            var selectmilk = document.getElementById('cow_milk_status');
            var milkDateInput = document.getElementById('milk_date');

            if (selectmilk.value == 'ให้นม') {
                milkDateInput.value = '';
                milkDateInput.placeholder = 'กรอกวันให้นมของโค ';
                milkDateInput.required = true;
                milkDateInput.disabled = false;
            } else if (selectmilk.value == 'ไม่ให้นม' || selectmilk.value == 'พักรีด') {
                milkDateInput.value = '0';
                milkDateInput.placeholder = '';
                milkDateInput.required = false;
                milkDateInput.disabled = true;
            }
        });
    </script>
    <script>
        document.getElementById('cow_bday').addEventListener('change', function () {
            var select = document.getElementById('cow_breed_status');
            var selectmilk = document.getElementById('cow_milk_status');
            var calfDateInput = document.getElementById('calf_date');
            var milkDateInput = document.getElementById('milk_date');
            var cowBday = new Date(document.getElementById('cow_bday').value);
            var sixMonthsAgo = new Date();
            sixMonthsAgo.setMonth(sixMonthsAgo.getMonth() - 6);

            if (cowBday.getTime() > sixMonthsAgo.getTime()) {
                select.value = 'ท้องว่าง';
                select.disabled = true;
                calfDateInput.value = '0';
                calfDateInput.placeholder = '';
                calfDateInput.required = false;
                calfDateInput.disabled = true;

                selectmilk.value = 'ไม่ให้นม';
                selectmilk.disabled = true;
                milkDateInput.value = '0';
                milkDateInput.placeholder = '';
                milkDateInput.required = false;
                milkDateInput.disabled = true;
            } else {
                select.value = 'เลือกสถานะการตั้งท้อง';
                select.disabled = false;
                calfDateInput.value = '';
                calfDateInput.placeholder = 'กรอกอายุครรภ์ของโค ';
                calfDateInput.required = true;
                calfDateInput.disabled = false;

                selectmilk.value = 'เลือกสถานะการให้นม';
                selectmilk.disabled = false;
                milkDateInput.value = '';
                milkDateInput.placeholder = 'กรอกวันให้นม ';
                milkDateInput.required = true;
                milkDateInput.disabled = false;
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var today = new Date().toISOString().split('T')[0]; // วันที่ปัจจุบันในรูปแบบ ISO
            var dateInput = document.getElementById('cow_bday');

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
    }


    if (isset($_SESSION['sData'])) {
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
    </form>
</body>

</html>