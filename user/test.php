<?php
session_start();
require_once '../server.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php //include "../header.php"; ?>
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Kanit';
        }

        body {
            padding-top: 10em;
        }

        .update .btn-pass {
            background-color: #7CA7D3;
            margin: 0em 1em;
            color: white;
            width: 8em;
            border-radius: 20px !important;
            border: none;
        }

        .update .btn-pass:hover {
            background-color: #D6F4FF !important;
            color: black;
        }

        .update .btn-edit-profile {
            background-color: #ffc720;
            margin: 0em 1em;
            color: white;
            width: 8em;
            border-radius: 20px !important;
            border: none;
        }

        .update .btn-edit-profile:hover {
            background-color: #D6F4FF !important;
            color: black;
        }

        .user-edit {
            padding-top: 1.75em;
            padding-bottom: 5em;
        }

        .user-edit .btn-edit {
            background-color: #f8f8f8;
            padding: 1.5em 4em;
            color: black;
            width: 100%;
            border-radius: 5px !important;
        }

        .user-edit .btn-edit:hover {
            background-color: #D6F4FF !important;
        }

        .container-personal {
            width: 50%;
            border-radius: 0px !important;
            display: block;
            margin: auto auto;
        }

        .update .btn-warning {
            border-radius: 20px !important;

        }

        .pic-profile {
            margin-bottom: 2em;
        }

        .pic-profile img {
            width: 12em;
            height: 12em;
            object-fit: cover;
            border: 1px solid #ccc;
            box-shadow: 0px 3px 8px #ccc;
            margin: 0 auto;
            border-radius: 50%;
        }

        .image {
            display: flex;
            justify-content: center;
            align-content: center;
        }

        .image img {
            width: 12em;
            height: 12em;
            object-fit: cover;
            border: 1px solid #ccc;
            box-shadow: 0px 3px 8px #ccc;
            padding: 4px;
            display: none;
            margin: 0 auto;
            border-radius: 50%;
        }

        .image img.show {
            display: block;
        }


        /* ----------------------------------------------------- */
        .gender-label {
            margin-right: 0.6rem;

        }

        .radio-button {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            margin-right: 0.25rem;
            background-color: #d5e6fc;
            padding: 0.275em 1em 0.275em 1em;
            transition: background-color 0.3s;
            border-radius: 10px;
        }

        .input-group:not(.has-validation)>.dropdown-toggle:nth-last-child(n+3),
        .input-group:not(.has-validation)>.form-floating:not(:last-child)>.form-control,
        .input-group:not(.has-validation)>.form-floating:not(:last-child)>.form-select,
        .input-group:not(.has-validation)>:not(:last-child):not(.dropdown-toggle):not(.dropdown-menu):not(.form-floating) {
            border-top-right-radius: 10px !important;
            border-bottom-right-radius: 10px !important;
        }

        .input-group>:not(:first-child):not(.dropdown-menu):not(.valid-tooltip):not(.valid-feedback):not(.invalid-tooltip):not(.invalid-feedback) {
            margin-left: calc(var(--bs-border-width) * -1);
            border-top-left-radius: 10px !important;
            border-bottom-left-radius: 10px !important;
        }

        .radio-button:hover {
            background-color: #e0e0e0;
        }

        .custom-radio input {
            width: 1.5em;
            height: 1.5em;
            border: 2px solid #ccc;
            border-radius: 50%;
            display: inline-block;
            position: relative;
            margin: 0em 0.25rem;
            visibility: hidden;
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
            width: 8px;
            height: 8px;
            background-color: #007bff;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .radio-text {
            font-size: 1rem;
            color: #212529;
        }


        /* ----------------------------------------------- */
        .update {
            margin-top: 1.5em;
            margin-bottom: 1.5em;
        }

        .infor {
            margin-top: 0.7em !important;
        }
    </style>
</head>

<body>
    <?php include "nav-bar.php"; ?>
    <?php
    function thai_month($month)
    {
        $thai_months = array(
            '01' => 'มกราคม',
            '02' => 'กุมภาพันธ์',
            '03' => 'มีนาคม',
            '04' => 'เมษายน',
            '05' => 'พฤษภาคม',
            '06' => 'มิถุนายน',
            '07' => 'กรกฎาคม',
            '08' => 'สิงหาคม',
            '09' => 'กันยายน',
            '10' => 'ตุลาคม',
            '11' => 'พฤศจิกายน',
            '12' => 'ธันวาคม',
        );

        return $thai_months[$month];
    }
    ?>
    <div class="container">
        <div class="row" id="head">
            <div class="col-12">
                <?php
                $id = $_SESSION['acc_id'];
                $sql = "SELECT * FROM account INNER JOIN user ON account.acc_id = user.acc_id WHERE account.acc_id = '$id'";
                $rs = mysqli_query($conn, $sql);
                $result = mysqli_fetch_assoc($rs);

                $career_id = $result["career_id"];
                $sql_career = "SELECT * FROM career INNER JOIN user ON career.career_id = user.career_id WHERE career.career_id = '$career_id'";
                $rs_career = mysqli_query($conn, $sql_career);
                $result_career = mysqli_fetch_assoc($rs_career);

                $date = date('d F Y H:i:s', strtotime($result['user_bdate']));
                $parts = explode(' ', $date);
                $day = $parts[0];
                $month = thai_month(date('m', strtotime($result['user_bdate'])));
                $year = $parts[2] + 543;
                $time = $parts[3];
                $thai_date = "$day $month $year";

                if (mysqli_num_rows($rs) != 0) { ?>
                    <div class="row">
                        <div class="col"></div>
                        <div class="col-12 d-flex justify-content-center">
                            <div class="pic-profile">
                                <?php if (!empty($result["acc_image"])): ?>
                                    <img src="../pic/<?php echo $result["acc_image"]; ?>" alt="">
                                <?php else: ?>
                                    <img src="../Images/profile.jpg" alt="">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col"></div>
                    </div>
                    <div class="row">
                        <div class="col"></div>
                        <div class="col-6 text-center userfix">
                            <h4>ชื่อผู้ใช้งาน :
                                <?php echo $result["acc_name"]; ?>
                            </h4>
                            <p class="text-muted text-primary-emphasis">
                                <?php
                                if ($_SESSION['user_status'] == 'User') {
                                    echo "ผู้ใช้งานทั่วไป";
                                }
                                if ($_SESSION['user_status'] == 'Admin') {
                                    echo "ผู้ดูแลระบบ";
                                }
                                if ($_SESSION['user_status'] == 'Expert') {
                                    echo "ผู้เชี่ยวชาญ";
                                }
                                ;
                                ?>
                            </p>
                        </div>
                        <div class="col"></div>
                    </div>
                </div>
            </div>
            <div class="container-personal">
                <div class="user-edit text-center">
                    <div class="personal">
                        <button class="btn btn-edit" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            ข้อมูลส่วนตัว
                        </button>
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body card-profile">
                                <div class="row infor">
                                    <div class="col-5" style="text-align: right;">ชื่อ-นามสกุล</div>
                                    <div class="col-2">:</div>
                                    <div class="col-5" style="text-align: left;">
                                        <?php echo $result["user_fname"];
                                        echo " ";
                                        echo $result["user_lname"]; ?>
                                    </div>
                                </div>
                                <div class="row infor">
                                    <div class="col-5" style="text-align: right;">อีเมล</div>
                                    <div class="col-2">:</div>
                                    <div class="col-5" style="text-align: left;">
                                        <?php echo $result["acc_email"]; ?>
                                    </div>
                                </div>
                                <div class="row infor">
                                    <div class="col-5" style="text-align: right;">เพศ</div>
                                    <div class="col-2">:</div>
                                    <div class="col-5" style="text-align: left;">
                                        <?php echo $result["user_gender"]; ?>
                                    </div>
                                </div>
                                <div class="row infor">
                                    <div class="col-5" style="text-align: right;">อาชีพ</div>
                                    <div class="col-2">:</div>
                                    <div class="col-5" style="text-align: left;">
                                        <?php echo $result_career["career_name"]; ?>
                                    </div>
                                </div>
                                <div class="row infor">
                                    <div class="col-5" style="text-align: right;">วัน/เดือน/ปีเกิด</div>
                                    <div class="col-2">:</div>
                                    <div class="col-5" style="text-align: left;">
                                        <?php echo $thai_date; ?>
                                    </div>
                                </div>
                                <div class="row infor">
                                    <div class="col-5" style="text-align: right;">เบอร์โทรศัพท์</div>
                                    <div class="col-2">:</div>
                                    <div class="col-5" style="text-align: left;">
                                        <?php echo $result["user_phone"]; ?>
                                    </div>
                                </div>
                                <div class="col update text-center">
                                    <button type="button" class="btn btn-warning btn-edit-profile" data-bs-toggle="modal"
                                        data-bs-target="#editProfile">แก้ไขข้อมูล</button>
                                    <button class="btn btn-pass" type="button">เปลี่ยนรหัสผ่าน</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-edit" type="button">สูตรอาหารของฉัน</button>
                    </div>
                    <div>
                        <button class="btn btn-edit" type="button">กระทู้ของฉัน</button>
                    </div>
                    <div>
                        <button class="btn btn-edit" type="button">ลบบัญชีผู้ใช้</button>
                    </div>
                </div>
            </div>
        <?php } else {
                }
                ?>
    </div>
    <!-- ------------------modal------------------ -->
    <div class="modal fade myModal" id="editProfile" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modaledit"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modaledit">แก้ไขโปรไฟล์</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="profileEdit_model.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="acc_name" class="col-form-label">ชื่อผู้ใช้งาน :</label>
                                <input type="text" class="form-control" id="acc_name" name="acc_name"
                                    value="<?php echo $result["acc_name"]; ?>">
                            </div>
                            <div class="mb-3 col">
                                <label for="acc_email" class="col-form-label">อีเมล :</label>
                                <input type="email" class="form-control" id="acc_email" name="acc_email"
                                    value="<?php echo $result["acc_email"]; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="user_fname" class="col-form-label">ชื่อ :</label>
                                <input type="text" class="form-control" id="user_fname" name="user_fname"
                                    value="<?php echo $result["user_fname"]; ?>">
                            </div>
                            <div class="mb-3 col">
                                <label for="user_lname" class="col-form-label">นามสกุล :</label>
                                <input type="text" class="form-control" id="user_lname" name="user_lname"
                                    value="<?php echo $result["user_lname"]; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col">
                                <div class="form-group">
                                    <label class="col-form-label">เพศ :</label>
                                    <div class="input-group">
                                        <label class="radio-button">
                                            <div class="form-check form-check-inline gender">
                                                <input class="form-check-input" type="radio" name="user_gender"
                                                    id="male" value="ชาย" <?php if ($result["user_gender"] == "ชาย") {
                                                        echo "checked";
                                                    }
                                                    ?>>
                                                <span class="form-check-label" for="male">ชาย</span>
                                            </div>
                                        </label>
                                        <label class="radio-button">
                                            <div class="form-check form-check-inline gender">
                                                <input class="form-check-input" type="radio" name="user_gender"
                                                    id="female" value="หญิง" <?php if ($result["user_gender"] == "หญิง") {
                                                        echo "checked";
                                                    }
                                                    ?>>
                                                <span class="form-check-label" for="female">หญิง</span>
                                            </div>
                                        </label>
                                        <label class="radio-button">
                                            <div class="form-check form-check-inline gender">
                                                <input class="form-check-input" type="radio" name="user_gender"
                                                    id="other" value="อื่นๆ" <?php if ($result["user_gender"] == "อื่นๆ") {
                                                        echo "checked";
                                                    }
                                                    ?>>
                                                <span class="form-check-label" for="other">อื่นๆ</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 col">
                                <label for="career_id" class="col-form-label">อาชีพ :</label>
                                <select class="form-select" id="career_id" name="career_id">
                                    <?php
                                    $sql_career_all = "SELECT * FROM career";
                                    $result_career_all = $conn->query($sql_career_all);
                                    while ($row_career = mysqli_fetch_assoc($result_career_all)) {
                                        $selected = ($row_career["career_id"] == $result_career["career_id"]) ? "selected" : "";
                                        echo "<option value='{$row_career["career_id"]}' $selected>{$row_career["career_name"]}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col">
                                <label for="user_bdate" class="col-form-label">วัน/เดือน/ปีเกิด :</label>
                                <input type="date" class="form-control" id="user_bdate" name="user_bdate"
                                    value="<?php echo isset($_POST['user_bdate']) ? $_POST['user_bdate'] : $result["user_bdate"]; ?>">
                            </div>
                            <div class="mb-3 col">
                                <label for="user_phone" class="col-form-label">เบอร์โทรศัพท์ :</label>
                                <input type="tel" class="form-control" id="user_phone" name="user_phone"
                                    value="<?php echo $result["user_phone"]; ?>">
                            </div>
                        </div>
                        <div class="row image">
                            <div class="mb-3">
                                <label for="acc_image" class="col-form-label">รูปโปรไฟล์ :</label>
                                <input type="file" class="form-control" accept='image/*' onchange="showImage()"
                                    id="acc_image" name="acc_image">
                            </div>
                            <img id="imagePreview" src="../pic/<?php echo $result["acc_image"]; ?>" alt="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <input type="submit" class="btn btn-primary" value="บันทึก" name="saveChanges">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function showImage() {
            const imageUploader = document.querySelector("#acc_image");
            const imagePreview = document.querySelector("#imagePreview");
            const file = imageUploader.files[0];
            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.classList.add("show");
                imagePreview.src = e.target.result;
            }

            reader.readAsDataURL(file);
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var userBdateInput = document.getElementById('user_bdate');
            var displaySelectedDate = document.getElementById('display-selected-date');

            userBdateInput.addEventListener('change', function () {
                var selectedDate = new Date(userBdateInput.value);
                var thaiYear = selectedDate.getFullYear() + 543;
                var thaiBdate = (selectedDate.getDate() < 10 ? '0' : '') + selectedDate.getDate() + '/' +
                    ((selectedDate.getMonth() + 1) < 10 ? '0' : '') + (selectedDate.getMonth() + 1) + '/' + thaiYear;
            });
        });
    </script>

</body>

</html>