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
    <title>กลุ่มโค</title>
    <link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">

    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: "kanit";

        }


        .cow-border {
            width: 90%;
            margin: 4em auto;
            padding: 1.2em;
            border-radius: 10px;

        }

        a {
            text-decoration: none;
            color: black;
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


        .card-img-top img {
            align-items: center;
            margin-left: 2em;
        }

        .card-text p {
            text-align: center;
            margin-top: 1.2em;
        }

        .add .btn {
            background-color: #4F80C0;
            color: white;
            width: 9em;
            border-radius: 20px;
            font-size: 1em;


        }

        .add .btn:hover,
        .add .btn:focus:hover {
            background-color: #AACCE2;
            color: black;
        }

        .search {
            /* width: 50%; */
            border-color: #4F80C0;
            border-radius: 20px;
            /* margin: 0.2em auto; */
            margin-bottom: 2em;
        }


        #test {
            border: 1px solid gray;
            margin: 1.8rem;
            padding: 3em;
        }

        .hr-bottom {
            border: 1px solid #f5f5f5;
        }

        .checkbox-wrapper-26 * {
            -webkit-tap-highlight-color: transparent;
            outline: none;
        }

        .checkbox-wrapper-26 input[type="checkbox"] {
            display: none;
        }

        .checkbox-wrapper-26 label {
            --size: 1.7em;
            --shadow: calc(var(--size) * .07) calc(var(--size) * .1);
            position: relative;
            display: block;
            width: var(--size);
            height: var(--size);
            margin: 0 auto;
            background-color: #dc3545;
            border-radius: 50%;
            box-shadow: 0 var(--shadow) #ffbeb8;
            cursor: pointer;
            transition: 0.2s ease transform, 0.2s ease background-color, 0.2s ease box-shadow;
            overflow: hidden;
            z-index: 1;
        }

        .checkbox-wrapper-26 label:before {
            content: "";
            position: absolute;
            top: 50%;
            right: 0;
            left: 0;
            width: calc(var(--size) * .7);
            height: calc(var(--size) * .7);
            margin: 0 auto;
            background-color: #fff;
            transform: translateY(-50%);
            border-radius: 50%;
            box-shadow: inset 0 var(--shadow) #ffbeb8;
            transition: 0.2s ease width, 0.2s ease height;
        }

        .checkbox-wrapper-26 label:hover:before {
            width: calc(var(--size) * .55);
            height: calc(var(--size) * .55);
            box-shadow: inset 0 var(--shadow) #ff9d96;
        }

        .checkbox-wrapper-26 label:active {
            transform: scale(0.9);
        }

        .checkbox-wrapper-26 .tick_mark {
            position: absolute;
            top: -1px;
            right: 0;
            left: calc(var(--size) * -.05);
            width: calc(var(--size) * .6);
            height: calc(var(--size) * .6);
            margin: 0 auto;
            margin-left: calc(var(--size) * .14);
            transform: rotateZ(-40deg);
        }

        .checkbox-wrapper-26 .tick_mark:before,
        .checkbox-wrapper-26 .tick_mark:after {
            content: "";
            position: absolute;
            background-color: #fff;
            border-radius: 2px;
            opacity: 0;
            transition: 0.2s ease transform, 0.2s ease opacity;
        }

        .checkbox-wrapper-26 .tick_mark:before {
            left: 0;
            bottom: 0;
            width: calc(var(--size) * .1);
            height: calc(var(--size) * .3);
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.23);
            transform: translateY(calc(var(--size) * -.68));
        }

        .checkbox-wrapper-26 .tick_mark:after {
            left: 0;
            bottom: 0;
            width: 100%;
            height: calc(var(--size) * .1);
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.23);
            transform: translateX(calc(var(--size) * .78));
        }

        .checkbox-wrapper-26 input[type="checkbox"]:checked+label {
            background-color: #198754;
            box-shadow: 0 var(--shadow) #92ff97;
        }

        .checkbox-wrapper-26 input[type="checkbox"]:checked+label:before {
            width: 0;
            height: 0;
        }

        .checkbox-wrapper-26 input[type="checkbox"]:checked+label .tick_mark:before,
        .checkbox-wrapper-26 input[type="checkbox"]:checked+label .tick_mark:after {
            transform: translate(0);
            opacity: 1;
        }

        .group-head {
            text-align: center;
        }

        @media (max-width: 576px) {
            .content {
                padding-left: 4.5em !important;
                padding-right: 1.2em !important;

            }

            .g-2 {
                width: 95%;
            }

            .add {
                margin-left: auto;
                /* Move the button to the right */
            }

            .no-data-message {
                text-align: left !important;
                padding: 2em;
            }
            td  >.box{
                margin-top:0.5em !important;
                width:8em !important;
            }

        }

        @media (min-width: 768px) {
            .col-md-6 {
                width: 100% !important;
            }

            .g-2 {
                width: 92% !important;
            }
            td>.box{
                margin-top:0.5em !important;
                width:8em !important;
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
    <div class="flex">
        <div class="g-1">
            <?php include ('sidebar.php'); ?>
        </div>
        <div class="g-2">
            <div class="content">
                <div class="col">
                    <h3 class="group-head">ข้อมูลกลุ่มโค</h3>
                </div>
                <div class="row">
                    <div class="cow-border">
                        <div class="d-flex justify-content-start">
                            <a href="addgroup.php" class="add">
                                <button type="button" class="btn">เพิ่มกลุ่มโค</button>
                            </a>
                        </div>
                        <?php
                        $acc_id = $_SESSION['acc_id'];
                        $sql = "SELECT *, COUNT(group_cow.group_name) AS count_group,
                            AVG(DATEDIFF(NOW(), cow_bday)) AS age ,AVG(cow.cow_weight) AS avg_weight
                                        FROM cow
                                        LEFT JOIN group_cow ON cow.group_id = group_cow.group_id
                                        WHERE cow.acc_id = $acc_id AND cow.group_id <> 1
                                        AND cow.deleteAt IS NULL 
                                        GROUP BY group_cow.group_id
                                        ORDER BY group_cow.createAt DESC ";
                        $result = $conn->query($sql);
                        ?>
                        <table class="table" id="table" data-filter-control="true" data-toggle="table"
                            data-pagination="true" data-locale="th-TH" data-flat="true" data-icons="icons"
                            data-toggle="table" data-search="true" data-search-highlight="true">
                            <thead class="table-group text-center">
                                <tr class="table table-primary">
                                    <th>ชื่อกลุ่ม</th>
                                    <th>จำนวนโค</th>
                                    <th>น้ำหนักเฉลี่ย(กิโลกรัม)</th>
                                    <th>รายละเอียด</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <?php
                             function convertDaysToYearsMonthsDays($days)
                             {
                                 $years = floor($days / 365);
                                 $months = floor(($days % 365) / 30);
                                 $remainingDays = $days % 30;

                                 return "$years ปี $months เดือน $remainingDays วัน";
                             }

                             // Function to calculate generation
                             function calculateGen($avgAgeDays, $milk_date, $calf_date)
                             {
                                 $gen = "ไม่พบรุ่น";
                                 $milkPeriod = "";

                                 if ($avgAgeDays >= 0 && $avgAgeDays <= 89) {
                                     $gen = "ลูกโค";
                                 } elseif ($avgAgeDays >= 90 && $avgAgeDays <= 149) {
                                     $gen = "โคหย่านม";
                                 } elseif ($avgAgeDays >= 150 && $avgAgeDays <= 269) {
                                     $gen = "โครุ่น";
                                 } elseif ($avgAgeDays >= 270) {
                                     if ($calf_date == 0 && $milk_date == 0) {
                                         $gen = "โคสาว";
                                     } elseif ($calf_date >= 0 && $calf_date < 226) {
                                         if ($milk_date >= 1 && $milk_date <= 100) {
                                             $gen = "โครีดนมช่วงต้น";
                                         } elseif ($milk_date >= 101 && $milk_date <= 200) {
                                             $gen = "โครีดนมช่วงกลาง";
                                         } elseif ($milk_date > 201) {
                                             $gen = "โครีดนมช่วงปลาย";
                                         } elseif ($milk_date == 0) {
                                             $gen = "โคท้อง";
                                         }
                                     } elseif ($calf_date >= 226 && $calf_date < 285) {
                                         $gen = "โคพักรีด";
                                     }
                                 }

                                 return $gen . " " . $milkPeriod;
                             }
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                   
                                    $avgAgeDays = $row['age'];
                                    $cow_breed_status = $row['cow_breed_status'];
                                    $cow_milk_status = $row['cow_milk_status'];
                                    $calf_date = $row['calf_date'];
                                    $milk_date = $row['milk_date'];
                                    $age = convertDaysToYearsMonthsDays($row['age']);
                                    $generation = calculateGen($avgAgeDays, $milk_date, $calf_date);
                                    $group_id = $row['group_id'];
                                    $group_name = $row['group_name'];
                                    $count_group = $row['count_group'];

                                    ?>
                                    <tr>
                                        <td style="text-align: center;">
                                            <?= $row["group_name"] ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?= $row["count_group"] ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <?= number_format($row["avg_weight"], 2) ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <button class="btn btn-light box" data-bs-toggle="modal"
                                                data-bs-target="#mgroup<?= $group_id ?>">รายละเอียดกลุ่ม</button>
                                            <div class="modal" tabindex="-1" id="mgroup<?php echo $group_id ?>">
                                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">รายละเอียด</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <!-- แสดงรายละเอียดกลุ่มโค -->
                                                        <div class="modal-body">
                                                            <p style="text-align: left;"><b>ชื่อกลุ่ม :</b>
                                                                <?php echo $group_name ?>
                                                            </p>
                                                            <p style="text-align: left;"><b>จำนวนสมาชิกในกลุ่ม :</b>
                                                                <?php echo $count_group, " "; ?> ตัว
                                                            </p>
                                                            <p style="text-align: left;"> <b>สมาชิกในกลุ่ม</b> </p>

                                                            <?php
                                                            $ju = "select * from cow inner join cattle_breed on cow.cb_id = cattle_breed.cb_id WHERE acc_id = $acc_id and group_id = $group_id";
                                                            $lo = mysqli_query($conn, $ju) or die(mysqli_error($conn)); ?>
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr class="table table-primary text-center">
                                                                            <th style='padding:0.5em;' scope="col">รูปภาพ</th>
                                                                            <th style='padding:0.5em;' scope="col">รหัสโค</th>
                                                                            <th style='padding:0.5em;' scope="col">ชื่อโค</th>
                                                                            <th style='padding:0.5em;' scope="col">เพศ</th>
                                                                            <th style='padding:0.5em;' scope="col">พันธุ์</th>
                                                                            <!-- <th scope="col">รุ่น</th> -->
                                                                        </tr>
                                                                    </thead>
                                                                    <?php
                                                                    while ($row = $lo->fetch_assoc()): {
                                                                            ?>

                                                                            <tbody>
                                                                                <tr>
                                                                                    <td><img class="img-circle"
                                                                                            style="width:3em; height:3em; border-radius:50%;"
                                                                                            src="../pic/<?php echo $row["cow_img"]; ?>" />
                                                                                        </th>
                                                                                    <td>
                                                                                        <?php echo $row['cow_id']; ?>
                                                                                        </th>
                                                                                    <td>
                                                                                        <?php echo $row['cow_name']; ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?php echo $row['cow_gender']; ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?php echo $row['cb_Thainame']; ?>
                                                                                    </td>
                                                                                    <!-- <td>
                                                                                    <?php echo $generation; ?>
                                                                                </td> -->
                                                                                </tr>
                                                                            </tbody>
                                                                            <?php
                                                                        }
                                                                    endwhile;
                                                                    ?>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">ปิด</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="text-align: center;">
                                            <button class="btn btn-light box" data-bs-toggle="modal"
                                                data-bs-target="#addmember<?php echo $group_id; ?>"
                                                style="width:105px; margin:0 auto;">เพิ่มสมาชิก</button>
                                                <div class="modal" tabindex="-1" id="addmember<?php echo $group_id; ?>">
                                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                    <div class="modal-content">
                                                        <form action="group_up.php" method="post">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">เพิ่มสมาชิกในกลุ่ม</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <?php
                                                                $_SESSION['group_id'] = $group_id;
                                                                ?>
                                                                <p style="text-align: left;"><b>ชื่อกลุ่ม :</b>
                                                                    <?php echo $group_name; ?>
                                                                </p>
                                                                <p style="text-align: left; font-weight:bold;">เลือกสมาชิก</p>

                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr class="table table-primary">
                                                                                <th style='padding:0.5em;' scope="col">เลือก</th>
                                                                                <th style='padding:0.5em;' scope="col">รูปภาพ</th>
                                                                                <th style='padding:0.5em;' scope="col">รหัสโค</th>
                                                                                <th style='padding:0.5em;' scope="col">ชื่อโค</th>
                                                                                <th style='padding:0.5em;' scope="col">เพศ</th>
                                                                                <th style='padding:0.5em;' scope="col">พันธุ์</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $r = "SELECT * FROM cow INNER JOIN cattle_breed ON cattle_breed.cb_id = cow.cb_id  
                                                                            WHERE cow.acc_id = $acc_id AND cow.group_id = 1 
                                                                            AND cow.deleteAt IS NULL 
                                                                            ORDER BY cow.createAt DESC";
                                                                            $r1 = $conn->query($r);
                                                                            if ($r1->num_rows > 0) {
                                                                                while ($row = $r1->fetch_assoc()) {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <div class="checkbox-wrapper-26">
                                                                                                <input type="checkbox"
                                                                                                    id="checkbox-id<?php echo $row["cow_id"]; ?>"
                                                                                                    value="<?php echo $row["cow_id"]; ?>"
                                                                                                    name="checkbox-id[]">
                                                                                                <label
                                                                                                    for="checkbox-id<?php echo $row["cow_id"]; ?>">
                                                                                                    <div class="tick_mark"></div>
                                                                                                </label>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td><img class="img-circle"
                                                                                                style="width:3em; height:3em; border-radius:50%;"
                                                                                                src="../pic/<?php echo $row["cow_img"]; ?>" />
                                                                                        </td>
                                                                                        <td>
                                                                                            <?php echo $row['cow_id']; ?>
                                                                                        </td>
                                                                                        <td>
                                                                                            <?php echo $row['cow_name']; ?>
                                                                                        </td>
                                                                                        <td>
                                                                                            <?php echo $row['cow_gender']; ?>
                                                                                        </td>
                                                                                        <td>
                                                                                            <?php echo $row['cb_Thainame']; ?>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php
                                                                                }
                                                                            } else {
                                                                                echo "<tr><td colspan='6'>ไม่มีรายชื่อโคที่ไม่มีกลุ่ม</td></tr>";
                                                                            }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">ปิด</button>
                                                                <button type="submit" name="up" value="submit"
                                                                    class="btn btn-primary">ยืนยัน</button>
                                                            </div>
                                                        </form> <!-- ปิด form ที่ถูกต้อง -->
                                                        </div>
                                                </div>
                                            </div>
                                          
                                           <button type="button" class="btn btn-warning box" data-bs-toggle="modal"
                                                data-bs-target="#ed<?= $group_id; ?>">แก้ไขกลุ่มโค</button>
                                           
                                            <div class="modal" id="ed<?php echo $group_id; ?>" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                    <div class="modal-content">
                                                        <form action="group_edit.php?group_id=<?php echo $row['group_id']; ?>"
                                                            method="post">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                    แก้ไขข้อมูลกลุ่มโค</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <input type="hidden" name="group_id"
                                                                value="<?php echo $group_id; ?>">

                                                            <div class="modal-body">
                                                                <div class="mb-3" style="text-align: left;">
                                                                    <label for="" style="text-align: left;">ชื่อกลุ่ม</label>
                                                                    <input type="text" class="form-control" name="group_name"
                                                                        value="<?php echo $group_name ?>">
                                                                </div>
                                                                <p style="text-align: left;"><b>สมาชิกในกลุ่ม </b></p>
                                                                <?php

                                                                $ju = "SELECT * FROM cow INNER JOIN cattle_breed ON cow.cb_id = cattle_breed.cb_id WHERE acc_id = $acc_id AND group_id = $group_id";
                                                                $lo = mysqli_query($conn, $ju) or die(mysqli_error($conn));
                                                                ?>
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr class="table table-primary text-center">
                                                                                <th style='padding:0.5em;' scope="col">รูปภาพ</th>
                                                                                <th style='padding:0.5em;' scope="col">รหัสโค</th>
                                                                                <th style='padding:0.5em;' scope="col">ชื่อโค</th>
                                                                                <th style='padding:0.5em;' scope="col">เพศ</th>
                                                                                <th style='padding:0.5em;' scope="col">พันธุ์</th>
                                                                                <!-- <th scope="col">รุ่น</th> -->
                                                                                <th style='padding:0.5em;' scope="col">ลบ</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <?php while ($row = $lo->fetch_assoc()): ?>
                                                                            <tbody>
                                                                                <tr>

                                                                                    <td><img class="img-circle"
                                                                                            style="width:3em; height:3em; border-radius:50%;"
                                                                                            src="../pic/<?php echo $row["cow_img"]; ?>" />
                                                                                        </th>
                                                                                    <td>
                                                                                        <?php echo $row['cow_id']; ?>
                                                                                        </th>
                                                                                    <td>
                                                                                        <?php echo $row['cow_name']; ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?php echo $row['cow_gender']; ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?php echo $row['cb_Thainame']; ?>
                                                                                    </td>
                                                                                    <!-- <td>
                                                                                    <?php echo $generation; ?>
                                                                                </td> -->
                                                                                    <td>
                                                                                        <a href="del_cowingroup.php?id=<?php echo $row['cow_id']; ?>"
                                                                                            onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบสมาชิกโคนี้จากกลุ่มโค?')">
                                                                                            <i class="fa-solid fa-trash-can"
                                                                                                style="color: white; background-color:#dc3545; padding:0.6em; border-radius:10px;"
                                                                                                title="ลบสมาชิกโคจากกลุ่ม"></i>
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                            <?php

                                                                        endwhile;
                                                                        ?>
                                                                    </table>

                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">ปิด</button>
                                                                <button type="submit" class="btn btn-primary"
                                                                    name="edit_group">ยืนยัน</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button" class="btn btn-danger box" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal2<?= $group_id; ?>">ลบกลุ่มโค</button>

                                            <div class="modal" id="exampleModal2<?php echo $group_id; ?>" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                ยืนยันการลบข้อมูลกลุ่มโค</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="container-fluid text-center">
                                                                คุณต้องการลบรายการกลุ่มโค ชื่อ :
                                                                <strong>
                                                                    <?php echo $group_name; ?>
                                                                </strong> ใช่หรือไม่
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">ปิด</button>
                                                            <a href="del_group.php?group_id=<?php echo $group_id; ?>"
                                                                class="btn btn-danger">
                                                                <span class="glyphicon glyphicon-trash"></span> ยืนยัน
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                            </div>
                                            </div>

                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else if ($result->num_rows == 0) {
                                echo "<tr><td colspan='5' class='no-data-message' style='color: gray; padding: 2em; font-size:1.1em; text-align:center;'>ไม่มีรายการข้อมูลกลุ่มโค</td></tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector("#menu a[href='cow.php']").classList.add("active");
        });
    </script>

</body>

</html>