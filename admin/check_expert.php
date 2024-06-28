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
    if (isset($_POST['confirm'])) {
        $confirm_expert_id = $_POST['confirm_expert_id'];
        $sql_update_expert = "UPDATE expert SET ex_status = 'Yes' WHERE expert_id = '$confirm_expert_id'";
        $result_update_expert = mysqli_query($conn, $sql_update_expert);

        if ($result_update_expert) {
            $sql_select_account_id = "SELECT acc_id FROM expert WHERE expert_id = '$confirm_expert_id'";
            $result_select_account_id = mysqli_query($conn, $sql_select_account_id);

            if ($result_select_account_id) {
                $row = mysqli_fetch_assoc($result_select_account_id);
                $acc_id = $row['acc_id'];
                $sql_update_account = "UPDATE account SET acc_status = 'Expert' WHERE acc_id = '$acc_id'";
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
            echo '<script>alert("เกิดข้อผิดพลาดในการอัพเดต Expert");</script>';
        }
    }

    if (isset($_POST['cancelSubmit'])) {
        $cancelReason = mysqli_real_escape_string($conn, $_POST['cancelReason']);
        $cancel_expert_id = $_POST['cancel_expert_id'];

        $sql_update_cancel = "UPDATE expert SET ex_status = 'Cancel', ex_cancel_note = '$cancelReason' WHERE expert_id = '$cancel_expert_id'";
        $result_update = mysqli_query($conn, $sql_update_cancel);

        if ($result_update) {
            echo '<script>alert("ยกเลิกสิทธิ์เรียบร้อยแล้ว");</script>';
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
    <title>ตรวจสอบสิทธิ์ผู้เชี่ยวชาญ</title>
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




        .carousel {
            width: 100%;
        }

        .cardInfo {
            width: 80%;
            display: block;
            margin: 2em auto;
            background-color: #DBEDF2 !important;
            padding: 0.5em;
            border-radius: 20px !important;
        }

        .carousel-inner .carousel-item img {
            object-fit: cover;
            width: 100%;
            height: 15rem;
            margin: 0 auto;
            border-radius: 20px;
        }

        .card-footer {
            background-color: #DBEDF2 !important;
            border-top: none !important;
        }

        h1 {
            text-align: center;
        }

        .cancel {
            margin-top: 0.5em;
        }

        .zoom-in {
            cursor: zoom-in;
        }

        .h3 {
            text-align: center;
            padding: 3em;
        }

        /* -------------------------------------------- */
        .btn-more {
            margin: 1em 0em;
        }

        .btn-more .confirm {
            background-color: #77DC67;
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
        <h1>ตรวจสอบสิทธิผู้เชี่ยวชาญ</h1>
        <?php
        $sql = "SELECT expert.*, career.*, DATE_FORMAT(expert.createAt, '%d %M %Y %H:%i:%s') AS formatted_createAt
                FROM expert
                INNER JOIN career ON expert.career_id = career.career_id
                WHERE expert.ex_status = 'No'
                ORDER BY expert.createAt ASC";


        $rs = mysqli_query($conn, $sql);

        if (mysqli_num_rows($rs) > 0) {
            while ($row = mysqli_fetch_assoc($rs)) {
                if ($row['ex_status'] == "No") {
                    ?>
                    <div class="card mb-3 cardInfo">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5">
                                <div id="carouselExampleIndicators<?php echo $row['expert_id']; ?>" class="carousel slide">
                                    <div class="carousel-indicators">
                                        <?php for ($i = 0; $i < 3; $i++) { ?>
                                            <button type="button"
                                                data-bs-target="#carouselExampleIndicators<?php echo $row['expert_id']; ?>"
                                                data-bs-slide-to="<?php echo $i; ?>" <?php if ($i === 0) { ?>class="active" <?php } ?>
                                                aria-label="Slide <?php echo $i + 1; ?>"></button>
                                        <?php } ?>
                                    </div>
                                    <div class="carousel-inner">
                                        <?php for ($i = 0; $i < 3; $i++) { ?>
                                            <div class="carousel-item <?php if ($i === 0) { ?>active<?php } ?>">
                                                <?php if ($i === 0) { ?>
                                                    <a data-fancybox="gallery_<?php echo $row['expert_id']; ?>"
                                                        data-src="../pic/<?php echo $row['ex_edu_qualification']; ?>"
                                                        data-caption="การศึกษา" class="zoom-in">
                                                        <img src="../pic/<?php echo $row['ex_edu_qualification']; ?>" class="d-block"
                                                            alt="การศึกษา">
                                                    </a>
                                                <?php } elseif ($i === 1) { ?>
                                                    <a data-fancybox="gallery_<?php echo $row['expert_id']; ?>"
                                                        data-src="../pic/<?php echo $row['ex_profes_license']; ?>" data-caption="ใบอนุญาต"
                                                        class="zoom-in">
                                                        <img src="../pic/<?php echo $row['ex_profes_license']; ?>" class="d-block"
                                                            alt="ใบอนุญาต">
                                                    </a>
                                                <?php } elseif ($i === 2) { ?>
                                                    <a data-fancybox="gallery_<?php echo $row['expert_id']; ?>"
                                                        data-src="../pic/<?php echo $row['ex_other']; ?>" data-caption="อื่นๆ"
                                                        class="zoom-in">
                                                        <img src="../pic/<?php echo $row['ex_other']; ?>" class="d-block" alt="อื่นๆ">
                                                    </a>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselExampleIndicators<?php echo $row['expert_id']; ?>"
                                        data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselExampleIndicators<?php echo $row['expert_id']; ?>"
                                        data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <div class="card-body">
                                    <h5 class="card-title">ชื่อ-นามสกุล :
                                        <?php echo $row['ex_fname'] . " " . $row['ex_lname']; ?>
                                    </h5>
                                    อาชีพ :
                                    <?php echo $row['career_name']; ?> <br>

                                    สถานที่ทำงาน :
                                    <?php echo $row['ex_company']; ?> <br>

                                    การศึกษา :
                                    <?php echo $row['ex_education']; ?> <br>

                                    สถานศึกษา :
                                    <?php echo $row['ex_graduated']; ?> <br>

                                    อาชีพ :
                                    <?php echo $row['career_name']; ?> <br>
                                    <?php
                                    if ($row['ex_note'] != '') {
                                        echo "<div class='text-danger-emphasis'>รายละเอียดเพิ่มเติม : ";
                                        echo $row['ex_note'];
                                        echo "</div>";
                                    }
                                    ?>
                                    <?php
                                    if ($row['ex_cancel_note'] != '') {
                                        echo "<div class='text-danger-emphasis'>เหตุผลที่ไม่ผ่าน : ";
                                        echo $row['ex_cancel_note'];
                                        echo "</div>";
                                    }
                                    ?>
                                    <?php
                                    $date = date('d F Y H:i:s', strtotime($row['formatted_createAt']));
                                    $parts = explode(' ', $date);
                                    $day = $parts[0];
                                    $month = thai_month(date('m', strtotime($row['formatted_createAt'])));
                                    $year = $parts[2] + 543;
                                    $time = $parts[3];
                                    $thai_date = "$day $month $year $time";
                                    ?>

                                    <p class="card-text"><small class="text-body-secondary">วันที่ลงทะเบียน
                                            <?php echo $thai_date; ?>
                                        </small></p>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-3">
                                <div class="card-footer ">
                                    <form method="post">
                                        <div class="btn-more">
                                            <input type="hidden" name="expert_id" value="<?php echo $row['expert_id']; ?>">
                                            <button type="button" class="btn btn-primary confirm" data-bs-toggle="modal"
                                                data-bs-target="#confirmModal_<?php echo $row['expert_id']; ?>">อนุมัติ</button>
                                            <button type="button" class="btn btn-danger cancel" data-bs-toggle="modal"
                                                data-bs-target="#cancelModal_<?php echo $row['expert_id']; ?>">ไม่อนุมัติ</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="confirmModal_<?php echo $row['expert_id']; ?>" tabindex="-1"
                        aria-labelledby="confirmModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title fs-5" id="confirmModalLabel">อนุมัติผู้เชี่ยวชาญ</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">โปรดตรวจสอบข้อมูลผู้เชี่ยวชาญให้แน่ใจก่อนอนุมัติ</label>
                                    </div>
                                </div>
                                <form method="POST">
                                    <div class="modal-footer">
                                        <div class="btn-more">
                                            <input type="hidden" name="confirm_expert_id" value="<?php echo $row['expert_id']; ?>">
                                            <button type="button" class="btn btn-secondary cancel"
                                                data-bs-dismiss="modal">ปิด</button>
                                            <button type="submit" class="btn btn-primary confirm" name="confirm">ยืนยัน</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="cancelModal_<?php echo $row['expert_id']; ?>" tabindex="-1"
                        aria-labelledby="cancelModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title fs-5" id="cancelModalLabel">ยืนยันการยกเลิกสิทธิ์</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="POST" class="needs-validation">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <input type="hidden" name="cancel_expert_id" value="<?php echo $row['expert_id']; ?>">
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
            <div class="h3">
                <h3>ไม่พบข้อมูล</h3>
            </div>
        <?php } ?>
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