<?php
session_start();
if (!isset($_SESSION['user_status']) || ($_SESSION['user_status'] != 'Admin')) {
    $resultNoSessionAdmin = "สำหรับผู้ดูแลระบบเท่านั้น";
    $_SESSION['resultNoSessionAdmin'] = $resultNoSessionAdmin;
    echo "<script type='text/javascript'>";
    echo "window.location = '../login.php'; ";
    echo "</script>";
    exit();
}
include "../server.php";
?>
<?php
ini_set('display_errors', 0);
error_reporting(0);
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['cancelSubmit'])) {
        $cancelReason = mysqli_real_escape_string($conn, $_POST['cancelReason']);
        $cancel_expert_id = $_POST['cancel_expert_id'];

        $sql_update_cancel = "UPDATE expert SET ex_status = 'Cancel', ex_cancel_note = '$cancelReason' WHERE expert_id = '$cancel_expert_id'";
        $result_update = mysqli_query($conn, $sql_update_cancel);

        if ($result_update) {
            $sql_select_account_id = "SELECT acc_id FROM expert WHERE expert_id = '$cancel_expert_id'";
            $result_select_account_id = mysqli_query($conn, $sql_select_account_id);

            if ($result_select_account_id) {
                $row = mysqli_fetch_assoc($result_select_account_id);
                $acc_id = $row['acc_id'];
                $sql_update_account = "UPDATE account SET acc_status = 'User' WHERE acc_id = '$acc_id'";
                $result_update_account = mysqli_query($conn, $sql_update_account);

                if ($result_update_account) {
                    echo '<script>alert("ยืนยันสิทธิ์และอัพเดต Account เรียบร้อยแล้ว");</script>';
                } else {
                    echo '<script>alert("เกิดข้อผิดพลาดในการอัพเดต Account");</script>';
                }
            } else {
                echo '<script>alert("เกิดข้อผิดพลาดในการดึง acc_id");</script>';
            }
        } else {
            echo '<script>alert("เกิดข้อผิดพลาด");</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php //include("../header.php");        ?>
    <title>จัดการสิทธิ์ผู้เชี่ยวชาญ</title>
	<link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
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

        h1 {
            text-align: center;
        }

        .h2 {
            background-color: #B0DFEB;
            padding: 0.5em 1em;
            margin-bottom: 0px !important;
            margin-top: 1.5em !important;
        }

        .h4 {
            padding: 0em 1.3em !important;
        }

        .content {
            background-color: #DBEDF2;
            padding: 2em 0em;
        }

        .cardInfo {
            width: 80%;
            display: block;
            margin: 0 auto;
            padding: 0.5em;
            border-radius: 20px !important;
        }

        .img img {
            object-fit: cover;
            width: 100%;
            height: 12rem;
            display: block;
            margin: 0.5em auto;
            border-radius: 20px;
            padding: 0.5em;
        }

        .img h5 {
            text-align: center;
        }

        .card-footer {
            background-color: transparent !important;
            border-top: none !important;
        }

        /* -------------------------------------------- */
        .btn-more {
            margin: 1em 0em;
        }

        .btn-more .confirm {
            background-color: #ffba05;
            color: white;
            width: 100%;
            border-radius: 20px !important;
            margin: 0em 0.3em;
            border: none;
            margin: 0.15em;
        }

        .btn-more .confirm:hover {
            background-color: #6999C6 !important;
        }

        .btn-more .cancel {
            background-color: #FE5E5E;
            color: white;
            width: 100%;
            border-radius: 20px !important;
            margin: 0em 0.3em;
            border: none;
            margin: 0.15em;
        }

        .btn-more .cancel:hover {
            background-color: #6999C6 !important;
        }

        @media (max-width: 576px) {
            .btn-more .confirm {
                width: 100%;
            }

            .btn-more .cancel {
                width: 100%;
            }

            .cardInfo {
                width: 90%;
            }
        }

        .container-foot {
            position: relative;
            min-height: 75vh !important;
        }
    </style>
</head>

<body>
    <?php include 'nav-bar.php' ?>
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
            '12' => 'ธันวาคม'
        );

        return $thai_months[$month];
    }
    ?>
    <div class="container container-foot">
        <h1>จัดการสิทธิผู้เชี่ยวชาญ</h1>
        <div class="">
            <div class="h2">
                <h2>รายชื่อผู้เชี่ยวชาญ</h2>
            </div>
            <div class="content">
                <?php
                $sql = "SELECT expert.*, career.*, account.*, DATE_FORMAT(expert.updateAt, '%d %M %Y %H:%i:%s') AS formatted_updateAt
                        FROM expert
                        INNER JOIN career ON expert.career_id = career.career_id
                        INNER JOIN account ON expert.acc_id = account.acc_id
                        WHERE expert.ex_status = 'Yes'
                        ORDER BY expert.createAt ASC";

                $rs = mysqli_query($conn, $sql);

                if (mysqli_num_rows($rs) > 0) {
                    while ($row = mysqli_fetch_assoc($rs)) {
                        if ($row['ex_status'] == "Yes") {
                            ?>
                            <div class="card mb-4 cardInfo">
                                <div class="row g-0">
                                    <div class="col-md-4 col-lg-3 img">
                                        <?php
                                        if (!empty($row['acc_image'])) {
                                            $image_url = "../pic/" . $row['acc_image'];
                                        } else {
                                            $image_url = "../Images/profile_ex.jpg";
                                        }
                                        ?>
                                        <img src="<?php echo $image_url; ?>" alt="">
                                        <h5>
                                            <?php echo $row['ex_fname'] . " " . $row['ex_lname']; ?>
                                        </h5>
                                    </div>
                                    <div class="col-md-4 col-lg-6">
                                        <div class="card-body">
                                            อาชีพ :
                                            <?php echo $row['career_name']; ?> <br>

                                            สถานที่ทำงาน :
                                            <?php echo $row['ex_company']; ?> <br>

                                            การศึกษา :
                                            <?php echo $row['ex_education']; ?> <br>

                                            สถานศึกษา :
                                            <?php echo $row['ex_graduated']; ?> <br>

                                            <?php
                                            $date = date('d F Y H:i:s', strtotime($row['formatted_updateAt']));
                                            $parts = explode(' ', $date);
                                            $day = $parts[0];
                                            $month = thai_month(date('m', strtotime($row['formatted_updateAt'])));
                                            $year = $parts[2] + 543;
                                            $time = $parts[3];
                                            $thai_date = "$day $month $year $time";
                                            ?>

                                            <p class="card-text">
                                                <small class="text-body-secondary">วันที่ยืนยันสิทธิ์
                                                    <?php echo $thai_date; ?>
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <div class="card-footer ">
                                            <form method="post">
                                                <div class="btn-more">
                                                    <input type="hidden" name="expert_id" value="<?php echo $row['expert_id']; ?>">
                                                    <button type="button" class="btn btn-primary confirm"
                                                        data-fancybox="gallery_<?php echo $row['expert_id']; ?>"
                                                        data-src="../pic/<?php echo $row['ex_edu_qualification']; ?>"
                                                        data-caption="การศึกษา">
                                                        ดูหลักฐานยืนยันสิทธิ์
                                                        <div style="display:none">
                                                            <img src="../pic/<?php echo $row['ex_edu_qualification']; ?>"
                                                                class="d-block" alt="การศึกษา" class="zoom-in">
                                                        </div>
                                                    </button>

                                                    <button type="button" class="btn btn-danger cancel" data-bs-toggle="modal"
                                                        data-bs-target="#cancelModal_<?php echo $row['expert_id']; ?>">ยกเลิกสิทธิ์ผู้เชี่ยวชาญ</button>
                                                    <div style="display:none">
                                                        <a data-fancybox="gallery_<?php echo $row['expert_id']; ?>"
                                                            data-src="../pic/<?php echo $row['ex_profes_license']; ?>"
                                                            data-caption="ใบอนุญาต" class="zoom-in">
                                                            <img src="../pic/<?php echo $row['ex_profes_license']; ?>"
                                                                class="d-block" alt="ใบอนุญาต">
                                                        </a>
                                                        <a data-fancybox="gallery_<?php echo $row['expert_id']; ?>"
                                                            data-src="../pic/<?php echo $row['ex_other']; ?>" data-caption="อื่นๆ"
                                                            class="zoom-in">
                                                            <img src="../pic/<?php echo $row['ex_other']; ?>" class="d-block"
                                                                alt="อื่นๆ">
                                                        </a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="cancelModal_<?php echo $row['expert_id']; ?>" tabindex="-1"
                                aria-labelledby="cancelModalLabel_<?php echo $row['expert_id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title fs-5" id="cancelModalLabel">ยืนยันการยกเลิกสิทธิ์</h2>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form method="POST" class="">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <input type="hidden" name="cancel_expert_id"
                                                        value="<?php echo $row['expert_id']; ?>">
                                                    <label for="cancelReason" class="form-label">เหตุผลที่ยกเลิก</label>
                                                    <textarea class="form-control" id="cancelReason" name="cancelReason" rows="3"
                                                        required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="btn-more">
                                                    <button type="button" class="btn btn-secondary cancel"
                                                        data-bs-dismiss="modal">ปิด</button>
                                                    <button type="submit" class="btn btn-primary confirm"
                                                        name="cancelSubmit">บันทึก</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    }
                } else { ?>
                    <div class="h4">
                        <h4>ไม่พบข้อมูลผู้เชี่ยวชาญ</h4>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <?php include ("../footer.php"); ?>
    </div>
    <script>
        Fancybox.bind('[data-fancybox^="gallery"]', {
            //
        });
    </script>

</body>

</html>