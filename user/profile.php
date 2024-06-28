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
    <?php //include "../header.php";          ?>
	<link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <title>โปรไฟล์</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Kanit';
        }

        body {
            padding-top: 10em;
            background-color: #f8f8f8 !important;
        }

        .update {
            margin-top: 1.5em;
            margin-bottom: 1.5em;
        }

        .infor {
            margin-top: 0.7em !important;
        }

        .raw {
            margin-top: 0.8em !important;
            margin-bottom: 0.8em !important;
        }

        .raw .btn-addraw {
            background-color: #7CA7D3;
            margin: 0em 1em;
            color: white;
            border-radius: 20px !important;
            border: none;
            width: 60%;
            padding: 0.5em 0em;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.06) 0px 2px 4px -1px;
        }

        .raw .btn-addraw:hover {
            background-color: #D6F4FF !important;
            color: black;
        }

        .raw .btn-editraw {
            background-color: #7CA7D3;
            margin: 0em 1em;
            color: white;
            border-radius: 20px !important;
            border: none;
            width: 60%;
            padding: 0.5em 0em;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.06) 0px 2px 4px -1px;
        }

        .raw .btn-editraw:hover {
            background-color: #D6F4FF !important;
            color: black;
        }

        .update .btn-pass {
            border-color: #4171a4;
            margin: 0em 1em;
            color: #4171a4;
            width: 8em;
            border-radius: 20px !important;
            /* border: none; */
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
            background-color: #e0e7ef;
            padding: 1em 2em;
            color: black;
            width: 100%;
            border-radius: 20px !important;
            margin: 0.2em 0em;
            font-size: 1.1em;
            box-shadow: rgba(0, 0, 0, 0.06) 0px 2px 4px 0px inset;
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

        .userfix p {
            margin-bottom: 0rem !important;
        }

        .modaledit {
            text-align: center;
        }

        .modaledit p {
            margin-top: 1em;
        }

        .modaledit img {
            width: 100%;
            height: 15rem;
            object-fit: cover;
            margin: 1em 0 2em 0em;
            border-radius: 10px;
            box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
        }

        @media (max-width: 992px) {
            .container-personal {
                width: 90%;
            }

            .pic-profile img {
                width: 9em;
                height: 9em;
            }

            .card-body {
                padding: 0px !important;
            }
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
    <?php

    $id = $_SESSION['acc_id'];

    // ตรวจสอบว่า $id อยู่ในตาราง user หรือไม่
    $sql_user = "SELECT * FROM user WHERE acc_id = '$id'";
    $result_user = $conn->query($sql_user);

    if ($result_user->num_rows > 0) {
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

        $fname = $result["user_fname"];
        $lname = $result["user_lname"];
        $gender = $result["user_gender"];
        $phone = $result["user_phone"];
        $bdate = $result['user_bdate'];
        $status_user = "";
        $ex_cancel_note = "";
        $ex_edu_qualification = "";
        $ex_profes_license = "";
        $ex_other = "";

    } else {
        // ถ้าไม่อยู่ในตาราง user ก็ตรวจสอบในตาราง expert
        $sql_expert = "SELECT * FROM expert WHERE acc_id = '$id'";
        $result_expert = $conn->query($sql_expert);

        if ($result_expert->num_rows > 0) {
            $sql = "SELECT * FROM account INNER JOIN expert ON account.acc_id = expert.acc_id WHERE account.acc_id = '$id'";
            $rs = mysqli_query($conn, $sql);
            $result = mysqli_fetch_assoc($rs);

            $career_id = $result["career_id"];
            $sql_career = "SELECT * FROM career INNER JOIN expert ON career.career_id = expert.career_id WHERE career.career_id = '$career_id'";
            $rs_career = mysqli_query($conn, $sql_career);
            $result_career = mysqli_fetch_assoc($rs_career);

            $date = date('d F Y H:i:s', strtotime($result['ex_bday']));
            $parts = explode(' ', $date);
            $day = $parts[0];
            $month = thai_month(date('m', strtotime($result['ex_bday'])));
            $year = $parts[2] + 543;
            $time = $parts[3];
            $thai_date = "$day $month $year";

            $fname = $result["ex_fname"];
            $lname = $result["ex_lname"];
            $gender = $result["ex_gender"];
            $phone = $result["ex_phone"];
            $bdate = $result['ex_bday'];
            $ex_cancel_note = "";
            $ex_edu_qualification = $result['ex_edu_qualification'];
            $ex_profes_license = $result['ex_profes_license'];
            $ex_other = $result['ex_other'];


            if ($result["ex_status"] == "Cancel") {
                $status_user = "สิทธิ์ผู้เชี่ยวชาญถูกยกเลิก";
                $ex_cancel_note = "เนื่องจาก" . $result['ex_cancel_note'] . " " . "<a href='' class='text-danger-emphasis' data-bs-toggle='modal' data-bs-target='#ModalEdit'>แก้ไขเอกสารยืนยันสิทธิ์</a>";
            }
            if ($result["ex_status"] == "No") {
                $status_user = "รอยืนยันสิทธิ์ผู้เชี่ยวชาญ";
            }

        } else {
            echo "ไม่พบ ID $id ในทั้งสองตาราง";
        }
    }
    ?>

    <div class="container">
        <div class="row" id="head">
            <div class="col-12">
                <?php
                if (mysqli_num_rows($rs) != 0) { ?>
                    <div class="row">
                        <div class="col"></div>
                        <div class="col-12 d-flex justify-content-center">
                            <div class="pic-profile">
                                <?php if (!empty ($result["acc_image"])): ?>
                                    <img src="../pic/<?php echo $result["acc_image"]; ?>" alt="">
                                <?php else: ?>
                                    <img src="../Images/profile.jpg" alt="">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col"></div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-4 col-lg-4"></div>
                        <div class="col-12 col-md-4 col-lg-4 text-center userfix">
                            <h4>ชื่อผู้ใช้งาน :
                                <?php echo $result["acc_name"]; ?>
                            </h4>
                            <p class="text-muted text-primary-emphasis">
                                <?php
                                if ($result['acc_status'] == 'User') {
                                    echo "ผู้ใช้งานทั่วไป";
                                    echo "<p class='wait text-danger-emphasis'>$status_user</p>";
                                    echo "<p class='wait text-danger-emphasis'>$ex_cancel_note</p>";
                                }
                                if ($result['acc_status'] == 'Admin') {
                                    echo "ผู้ดูแลระบบ";
                                }
                                if ($result['acc_status'] == 'Expert') {
                                    echo "ผู้เชี่ยวชาญ";
                                }
                                ;
                                ?>
                            </p>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4"></div>
                    </div>
                </div>
            </div>
            <div class="container-personal">
                <div class="user-edit text-center">
                    <div class="personal">
                        <button class="btn btn-edit" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInfor"
                            aria-expanded="false" aria-controls="collapseInfor">
                            <div class="row">
                                <div class="col">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    ข้อมูลส่วนตัว
                                </div>
                                <div class="col-1">
                                    <i class="fa-solid fa-chevron-down" style="color: #000000;"></i>
                                </div>
                            </div>
                        </button>
                        <div class="collapse" id="collapseInfor">
                            <div class="card card-body card-profile">
                                <div class="row infor">
                                    <div class="col-5" style="text-align: right;">ชื่อ-นามสกุล</div>
                                    <div class="col-2">:</div>
                                    <div class="col-5" style="text-align: left;">
                                        <?php echo $fname;
                                        echo " ";
                                        echo $lname; ?>
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
                                        <?php echo $gender; ?>
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
                                        <?php echo $phone ?>
                                    </div>
                                </div>
                                <div class="col update text-center">
                                    <button type="button" class="btn btn-warning btn-edit-profile mt-1" data-bs-toggle="modal"
                                        data-bs-target="#editProfile">แก้ไขข้อมูล</button>
                                    <button class="btn btn-pass mt-1" type="button" data-bs-toggle="modal"
                                        data-bs-target="#editPass">เปลี่ยนรหัสผ่าน</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div>
                        <button class="btn btn-edit" type="button">สูตรอาหารของฉัน</button>
                    </div> -->
                    <div>
                        <button class="btn btn-edit" type="button"
                            onclick="window.location.href='../posts/mypost.php'">กระทู้ของฉัน</button>
                    </div>
                    <div>
                        <form action="delete_user.php" method="post" id="deleteForm">
                            <div>
                                <button class="btn btn-edit" type="button" id="deleteButton"
                                    name="deleteUser">ลบบัญชีผู้ใช้</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php } else {
                }
                ?>
    </div>
    <!--------------------modal-------------------->
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
                            <div class="mb-3 col-sm-6 col-12">
                                <label for="acc_name" class="col-form-label">ชื่อผู้ใช้งาน :</label>
                                <input type="text" class="form-control" id="acc_name" name="acc_name"
                                    value="<?php echo $result["acc_name"]; ?>">
                            </div>
                            <div class="mb-3 col-sm-6 col-12">
                                <label for="acc_email" class="col-form-label">อีเมล :</label>
                                <input type="email" class="form-control" id="acc_email" name="acc_email"
                                    value="<?php echo $result["acc_email"]; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-sm-6 col-12">
                                <label for="user_fname" class="col-form-label">ชื่อ :</label>
                                <input type="text" class="form-control" id="user_fname" name="user_fname"
                                    value="<?php echo $fname; ?>">
                            </div>
                            <div class="mb-3 col-sm-6 col-12">
                                <label for="user_lname" class="col-form-label">นามสกุล :</label>
                                <input type="text" class="form-control" id="user_lname" name="user_lname"
                                    value="<?php echo $lname; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label class="col-form-label">เพศ :</label>
                                    <div class="input-group">
                                        <label class="radio-button">
                                            <div class="form-check form-check-inline gender">
                                                <input class="form-check-input" type="radio" name="user_gender"
                                                    id="male" value="ชาย" <?php if ($gender == "ชาย") {
                                                        echo "checked";
                                                    }
                                                    ?>>
                                                <span class="form-check-label" for="male">ชาย</span>
                                            </div>
                                        </label>
                                        <label class="radio-button">
                                            <div class="form-check form-check-inline gender">
                                                <input class="form-check-input" type="radio" name="user_gender"
                                                    id="female" value="หญิง" <?php if ($gender == "หญิง") {
                                                        echo "checked";
                                                    }
                                                    ?>>
                                                <span class="form-check-label" for="female">หญิง</span>
                                            </div>
                                        </label>
                                        <label class="radio-button">
                                            <div class="form-check form-check-inline gender">
                                                <input class="form-check-input" type="radio" name="user_gender"
                                                    id="other" value="อื่นๆ" <?php if ($gender == "อื่นๆ") {
                                                        echo "checked";
                                                    }
                                                    ?>>
                                                <span class="form-check-label" for="other">อื่นๆ</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 col-sm-6 col-12">
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
                            <div class="mb-3 col-sm-6 col-12">
                                <label for="user_bdate" class="col-form-label">วัน/เดือน/ปีเกิด :</label>
                                <input type="date" class="form-control" id="user_bdate" name="user_bdate"
                                    value="<?php echo isset ($_POST["$bdate"]) ? $_POST["$bdate"] : $bdate; ?>">
                            </div>
                            <div class="mb-3 col-sm-6 col-12">
                                <label for="user_phone" class="col-form-label">เบอร์โทรศัพท์ :</label>
                                <input type="tel" class="form-control" id="user_phone" name="user_phone"
                                    value="<?php echo $phone; ?>">
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
    <div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="ModalEdit" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ModalEdit">แก้ไขเอกสารหลักฐานยืนยันสิทธิ์</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="update_image.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row modaledit">
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-4">
                                <h5>วุฒิการศึกษา</h5>
                                <img src="../pic/<?php echo $ex_edu_qualification; ?>" alt=""
                                    id="edu_qualification_image">
                                <input type="file" id="new_edu_qualification" accept="image/*"
                                    name="ex_edu_qualification" hidden>
                                <button type="button" class="btn btn-secondary"
                                    id="change_edu_qualification_image">เปลี่ยนภาพ</button>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-4">
                                <h5>ใบประกอบวิชาชีพ</h5>
                                <img src="../pic/<?php echo $ex_profes_license; ?>" alt="" id="profes_license_image">
                                <input type="file" id="new_profes_license" accept="image/*" name="ex_profes_license"
                                    hidden>
                                <button type="button" class="btn btn-secondary"
                                    id="change_new_profes_license_image">เปลี่ยนภาพ</button>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-4">
                                <h5>เอกสารหลักฐานอื่นๆ</h5>
                                <img src="../pic/<?php echo $ex_other; ?>" alt="" id="other_image">
                                <input type="file" id="new_other" accept="image/*" name="ex_other" hidden>
                                <button type="button" class="btn btn-secondary"
                                    id="change_new_other_image">เปลี่ยนภาพ</button>
                            </div>
                        </div>
                        <div>
                            <label for="ex_note" class="form-label">รายละเอียดเพิ่มเติม</label>
                            <textarea class="form-control" id="ex_note" rows="3" name="ex_note"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary" name="imgUpdate">ส่งเอกสาร</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade myModal" id="editPass" data-bs-backdrop="static" tabindex="-1" aria-labelledby="editPass"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editPass">เปลี่ยนรหัสผ่าน</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="profilePass.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="col">
                            <label for="old_pass" class="col-form-label">รหัสผ่านเดิม :</label>
                            <input type="password" class="form-control" id="old_pass" name="acc_pass" required
                                pattern="[a-zA-Z0-9]+" placeholder="กรอกรหัสผ่านเดิม">
                        </div>
                        <div class="col">
                            <label for="pass_1" class="col-form-label">รหัสผ่านใหม่ :</label>
                            <input type="password" class="form-control" id="pass_1" name="pass_1" required
                                pattern="[a-zA-Z0-9]+" minlength="8" placeholder="กรอกรหัสผ่านใหม่">
                        </div>
                        <div class="col">
                            <label for="pass_2" class="col-form-label">ยืนยันรหัสผ่านใหม่ :</label>
                            <input type="password" class="form-control" id="pass_2" name="pass_2" required
                                pattern="[a-zA-Z0-9]+" minlength="8" placeholder="กรอกยืนยันรหัสผ่านใหม่">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <input type="submit" class="btn btn-primary" value="บันทึก" name="saveNewPassword">
                    </div>
                </form>
            </div>
        </div>
    </div>
	<?php include ("../footer.php"); ?>
    <?php
    if (isset ($_SESSION['successPass'])) {
        $successPass = $_SESSION['successPass'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'เปลี่ยนรหัสผ่านสำเร็จ',
                        text: '" . $successPass . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
        unset($_SESSION['successPass']);
    }
    ?>
    <?php
    if (isset ($_SESSION['error'])) {
        $error = $_SESSION['error'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'เกิดข้อผิดพลาด',
                        text: '" . $error . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
        unset($_SESSION['error']);
    }
    ?>
    <?php $conn->close(); ?>
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
    <script>
        document.getElementById('change_edu_qualification_image').addEventListener('click', function () {
            document.getElementById('new_edu_qualification').click();
        });
        document.getElementById('new_edu_qualification').addEventListener('change', function () {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function () {
                document.getElementById('edu_qualification_image').src = reader.result;
            }
            reader.readAsDataURL(file);
        });


        document.getElementById('change_new_profes_license_image').addEventListener('click', function () {
            document.getElementById('new_profes_license').click();
        });
        document.getElementById('new_profes_license').addEventListener('change', function () {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function () {
                document.getElementById('profes_license_image').src = reader.result;
            }
            reader.readAsDataURL(file);
        });


        document.getElementById('change_new_other_image').addEventListener('click', function () {
            document.getElementById('new_other').click();
        });
        document.getElementById('new_other').addEventListener('change', function () {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function () {
                document.getElementById('other_image').src = reader.result;
            }
            reader.readAsDataURL(file);
        });
        document.addEventListener('DOMContentLoaded', function () {
            var buttons = document.querySelectorAll('.btn-edit');

            buttons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var icon = button.querySelector('i');
                    icon.classList.toggle('fa-chevron-down');
                    icon.classList.toggle('fa-chevron-up');
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('deleteButton').addEventListener('click', function () {
                Swal.fire({
                    title: 'ยืนยันการลบบัญชีผู้ใช้?',
                    text: "คุณต้องการที่จะลบบัญชีผู้ใช้นี้หรือไม่? หากลบจะไม่สามารถเข้าใช้งานบัญชีได้อีก",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('deleteForm').submit(); // ส่งข้อมูลเมื่อผู้ใช้ยืนยันการลบ
                    }
                });
            });
        });
    </script>

</body>

</html>