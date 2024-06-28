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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <title>แก้ไขข้อมูลโค</title>
    <?php include ('../header.php'); ?>
    <style>
        .w {
            width: 100%;
            margin-top: 7em;
            background-color: white;
            padding-bottom: 2em;


        }

        .t-head {
            padding-top: 1.5em;
            margin: 0 auto;
            width: 80%;
            text-align: center;

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

        .gender-label {
            margin-right: 0.6rem;

        }

        .radio-button {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            margin-right: 1rem;
            margin-top: 1px;
            background-color: #d5e6fc;
            padding: 0.5em 2em 0.5em 1.5em;
            transition: background-color 0.3s;
            border-radius: 10px;
            width: 47%;
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

        .radio-button input {
            /* visibility: hidden; */
            margin-right: 0.5em;
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

        }
    </style>
</head>

<body>
    <?php include 'nav-bar.php' ?>
    <div class="w">
        <?php $cow_id = $_GET['cow_id'];
        //   $cb_id = $_GET['cb_id'];
        
        ?>
        <h3 class="t-head">แก้ไขข้อมูลโค</h3>
        <div class="card">
            <div class="card-body">
                <?php
                $cow = mysqli_query($conn, "select * from cow where cow_id='" . $cow_id . "'");
                $ccow = mysqli_fetch_array($cow);
                ?>
                <?php
                $sql_breed = "SELECT * FROM cow
                                    inner join cattle_breed
                                    on cow.cb_id = cattle_breed.cb_id
                                    where cow_id = '" . $cow_id . "'";
                $rbs = $conn->query($sql_breed);
                $result_breed = mysqli_fetch_assoc($rbs);
                ?>
                <?php
                $sql_group = "SELECT * FROM cow
                                    inner join group_cow
                                    on cow.group_id = group_cow.group_id
                                    where cow_id = '" . $cow_id . "'";
                $rgs = $conn->query($sql_group);
                $result_group = mysqli_fetch_assoc($rgs);
                ?>
                <form action="edit_cow_db.php?cow_id=<?php echo $cow_id; ?>" method="post" class="form"
                    enctype="multipart/form-data" name="form1">
                    <h4 class="topic">ข้อมูลทั่วไปของโค</h4>

                    <div class="row">

                        <div class="col-md-12 mb-3">
                            <label for="gr" class="form-label">กลุ่มของโค</label>
                            <div class="input-group">
                                <select class="form-select" id="group_id" aria-label="Example select with button addon"
                                    name="group_id">
                                    <?php
                                    $sql_group_all = "SELECT * FROM group_cow";
                                    $result_group_all = $conn->query($sql_group_all);
                                    while ($row_group = mysqli_fetch_assoc($result_group_all)) {
                                        $selected = ($row_group["group_id"] == $result_group["group_id"]) ? "selected" : "";
                                        echo "<option value='{$row_group["group_id"]}' $selected>{$row_group["group_name"]}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div><br>
                        <div class="col-md-6 mb-3"><label for="cow_id">หมายเลขประจำตัวโค</label>
                            <input class="form-control" type="text" id="cow_id" name="cow_id"
                                value="<?php echo $cow_id; ?>">
                        </div>
                        <div class="col-md-6 mb-3"><label for="cb_id">พันธุ์ของโค</label>
                            <div class="input-group">
                                <select class="form-select" id="cb_id" aria-label="Example select with button addon"
                                    name="cb_id">
                                    <?php
                                    $sql_breed_all = "SELECT * FROM cattle_breed";
                                    $result_breed_all = $conn->query($sql_breed_all);
                                    while ($row_breed = mysqli_fetch_assoc($result_breed_all)) {
                                        $selected = ($row_breed["cb_id"] == $result_breed["cb_id"]) ? "selected" : "";
                                        echo "<option value='{$row_breed["cb_id"]}' $selected>{$row_breed["cb_Thainame"]}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label for="cow_name">ชื่อของโค</label>
                            <input class="form-control" type="text" id="cow_name" name="cow_name"
                                value="<?php echo $ccow['cow_name']; ?>">
                        </div>

                        <div class="col-md-6 mb-3"><label for="cow_bday">วันเกิดของโค</label>
                            <input class="form-control" type="date" id="cow_bday" name="cow_bday"
                                value="<?php echo $ccow['cow_bday']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label for="cow_weight">น้ำหนักแรกเกิดของโค</label>
                            <input class="form-control" type="number" id="cow_first_weight" name="cow_first_weight"
                                value="<?php echo $ccow['cow_first_weight']; ?>">
                        </div>
                        <div class="col-md-6 mb-3"><label for="cow_weight">น้ำหนักปัจจุบันของโค</label>
                            <input class="form-control" type="number" id="cow_weight" name="cow_weight"
                                value="<?php echo $ccow['cow_weight']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3"><label for="cow_breed_status">สถานะการตั้งท้อง</label><span
                                style="color:red;">
                                *</span><br>
                            <div class="input-group mb-3">
                                <select class="form-select" id="cow_breed_status" name="cow_breed_status" required>
                                    <option selected>เลือกสถานะการตั้งท้อง</option>
                                    <option value="ตั้งท้อง" <?php echo ($ccow['cow_breed_status'] == 'ตั้งท้อง') ? 'selected' : ''; ?>>ตั้งท้อง</option>
                                    <option value="ท้องว่าง" <?php echo ($ccow['cow_breed_status'] == 'ท้องว่าง') ? 'selected' : ''; ?>>ท้องว่าง</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="calf_date">อายุครรภ์ (วัน)</label><br>
                            <input class="form-control" type="text" id="calf_date" name="calf_date"
                                placeholder="กรอกอายุครรภ์ของโค " value="<?php echo $ccow['calf_date']; ?>">
                            <!-- <span style="color:gray;">* ถ้าไม่อยู่ในช่วงตั้งครรภ์ให้กรอก 0</span> -->
                        </div>
                        <div class="col-md-3 mb-3"><label for="cow_milk_status">สถานะการให้นม</label><span
                                style="color:red;">
                                *</span><br>
                            <div class="input-group mb-3">
                                <select class="form-select" id="cow_milk_status" name="cow_milk_status" required>
                                    <option selected>เลือกสถานะการให้นม</option>
                                    <option value="ให้นม" <?php echo ($ccow['cow_milk_status'] == 'ให้นม') ? 'selected' : ''; ?>>ให้นม</option>
                                    <option value="ไม่ให้นม" <?php echo ($ccow['cow_milk_status'] == 'ไม่ให้นม') ? 'selected' : ''; ?>>ไม่ให้นม</option>
                                    <option value="พักรีด" <?php echo ($ccow['cow_milk_status'] == 'พักรีด') ? 'selected' : ''; ?>>พักรีด</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="milk_date">วันให้นม (วัน)</label><br>
                            <input class="form-control" type="text" id="milk_date" name="milk_date"
                                placeholder="กรอกวันให้นมของโค " value="<?php echo $ccow['milk_date']; ?>">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cow_activity">กิตติกรรมการเดิน</label><span style="color:red;">*</span><br>
                            <div class="input-group mb-3">
                                <select class="form-select" id="cow_activity" name="cow_activity">
                                    <option value="ขังคอก" <?php echo ($ccow['cow_activity'] == 'ขังคอก') ? 'selected' : ''; ?>>
                                        ขังคอก
                                    </option>
                                    <option value="ปล่อยเล็มแปลงพืช" <?php echo ($ccow['cow_activity'] == 'ปล่อยเล็มแปลงพืช') ? 'selected' : ''; ?>>
                                        ปล่อยเล็มแปลงพืช
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="calf_gender" class="calf_gender">เพศโค<span style="color:red;">
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
                <h4 class="topic">ข้อมูลบรรพบุรุษของโค</h4>
                <div class="row">
                    <div class="col-md-6 mb-3"><label for="cow_dad_id">หมายเลขประจำตัวพ่อโค</label><br>
                        <input class="form-control" type="text" id="cow_dad_id" name="cow_dad_id"
                            value="<?php echo $ccow['cow_dad_id']; ?>">
                    </div>
                    <div class="col-md-6 mb-3"><label for="cow_dad_breed">พันธุ์ของพ่อโค</label><br>
                        <div class="input-group">
                            <select class="form-select" id="cow_dad_breed" aria-label="Example select with button addon"
                                name="cow_dad_breed">
                                <?php
                                $sql_breed_all = "SELECT * FROM cattle_breed";
                                $result_breed_all = $conn->query($sql_breed_all);
                                $selected = ""; // กำหนดค่า selected เริ่มต้นเป็นข้อความว่า "ไม่ได้เลือกพันธุ์โค"
                                while ($row_breed = mysqli_fetch_assoc($result_breed_all)) {
                                    if ($row_breed["cb_Thainame"] == $result_breed["cow_dad_breed"]) {
                                        $selected = "selected"; // หากพบว่าพันธุ์ของพ่อโคตรงกับค่าที่ถูกเลือกไว้ล่วงหน้า ก็กำหนดค่า selected เป็น "selected"
                                    }
                                    echo "<option value='{$row_breed["cb_id"]}' $selected>{$row_breed["cb_Thainame"]}</option>";
                                }

                                // หากไม่พบพันธุ์ของพ่อโคที่ตรงกับค่าที่ถูกเลือกไว้ล่วงหน้า ก็ให้แสดง option ใหม่เป็น "ไม่ได้เลือกพันธุ์โค"
                                if ($selected !== "selected") {
                                    echo "<option value='' selected>เลือกพันธุ์โค</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3"><label for="cow_mom_id">หมายเลขประจำตัวแม่โค</label><br>
                        <input class="form-control" type="text" id="cow_mom_id" name="cow_mom_id"
                            value="<?php echo $ccow['cow_mom_id']; ?>">
                        </div>
                        <div class="col-md-6 mb-3"><label for="cow_mom_breed">พันธุ์ของแม่โค</label><br>
                            <div class="input-group">
                                <select class="form-select" id="cow_mom_breed"
                                    aria-label="Example select with button addon" name="cow_mom_breed">
                                    <?php
                                    $sql_breed_all = "SELECT * FROM cattle_breed";
                                    $result_breed_all = $conn->query($sql_breed_all);
                                    $selected = ""; // กำหนดค่า selected เริ่มต้นเป็นข้อความว่า "ไม่ได้เลือกพันธุ์โค"
                                    while ($row_breed = mysqli_fetch_assoc($result_breed_all)) {
                                        if ($row_breed["cb_Thainame"] == $result_breed["cow_mom_breed"]) {
                                            $selected = "selected"; // หากพบว่าพันธุ์ของพ่อโคตรงกับค่าที่ถูกเลือกไว้ล่วงหน้า ก็กำหนดค่า selected เป็น "selected"
                                        }
                                        echo "<option value='{$row_breed["cb_id"]}' $selected>{$row_breed["cb_Thainame"]}</option>";
                                    }

                                    // หากไม่พบพันธุ์ของพ่อโคที่ตรงกับค่าที่ถูกเลือกไว้ล่วงหน้า ก็ให้แสดง option ใหม่เป็น "ไม่ได้เลือกพันธุ์โค"
                                    if ($selected !== "selected") {
                                        echo "<option value='' selected>เลือกพันธุ์โค</option>";
                                    }
                                    ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center btn-more">
            <div class="form-group">
                <button type="button" class="btn btn-cancel" onclick="window.location.href='cow.php'">ย้อนกลับ</button>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-add confirm" name="addcow">ยืนยัน</button>
            </div>
        </div>

    </div>
    </form>

</body>

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
            milkDateInput.placeholder = 'กรอกอายุครรภ์ของโค ';
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
        var cowBday = new Date("<?php echo $ccow['cow_bday']; ?>");
        var sixMonthsAgo = new Date();
        sixMonthsAgo.setMonth(sixMonthsAgo.getMonth() - 6);

        // Check cow's age and update breeding and milking status accordingly
        if (cowBday.getTime() > sixMonthsAgo.getTime()) {
            document.getElementById('cow_breed_status').value = 'ท้องว่าง';
            document.getElementById('cow_breed_status').disabled = true;
            document.getElementById('calf_date').value = '0';
            document.getElementById('calf_date').disabled = true;
            document.getElementById('cow_milk_status').value = 'ไม่ให้นม';
            document.getElementById('cow_milk_status').disabled = true;
            document.getElementById('milk_date').value = '0';
            document.getElementById('milk_date').disabled = true;
        } else {
            // Cow is older than 6 months, allow editing breeding and milking status
            document.getElementById('cow_breed_status').disabled = false;
            document.getElementById('calf_date').disabled = false;
            document.getElementById('cow_milk_status').disabled = false;
            document.getElementById('milk_date').disabled = false;
        }
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
                        icon: 'warning',
                        title: 'แก้ไขข้อมูลแล้ว',
                        text: '" . $editData . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: true,
                    });
                });
            </script>";
    unset($_SESSION['editData']);
}
?>

</html>