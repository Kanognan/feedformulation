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
    <?php include "../header.php"; ?>
    <title>ข้อมูลทั่วไปของโค</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'kanit';

        }

        .add .btn {
            background-color: #4F80C0;
            color: white;
            width: 8.8em;
            padding: 0.5em;
            border-radius: 20px;
            font-size: 1em;
            margin: 0.5em 0.2em 0.5em 0.2em;

        }

        .add .btn:hover,
        .add .btn:focus,
        button[type=submit]:hover {
            background-color: #AACCE2;
            color: black;
        }

        .cow {
            width: 100%;
            margin-top: 9em;
        }


        .cowpic {
            margin: 0 auto;
            border-radius: 15px !important;
            width: 16em;
            height: 16em;
            overflow: hidden;

        }

        .cowpic img {
            align-items: center;
            max-width: 100%;
            height: auto;
            padding: 1em;
            /* display: block; */
            /* margin: 0 auto; */
            border-radius: 30px;
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





        #box {
            border-radius: 8px;
            padding: 1.2em;
            cursor: pointer;

        }

        .title-detail {
            text-align: center;
            margin-bottom: 1.5em;
        }

        .detail {
            margin-top: 1.2em;
            background-color: #c6d9eb !important;
            padding: 0.8em;
            border-radius: 5px;
            height: cover;

        }

        .detail-topic {
            font-size: 1.2em;
            font-weight: 500;
            margin-bottom: 1em;
            background-color: #6999C6;
            padding: 0.8em;
            border-radius: 5px;
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

        #menu a.active {
            color: black !important;
            background-color: #bbd1e5;
        }

        .rg {
            padding: 1em 1.3em;

        }

        .other {
            border-radius: 5px;
            background-color: #fffff0;
            width: 100%;
            margin: 0em auto;
            padding: .6em;
            height: 13em;
            overflow: auto;

        }

        .topic-other {
            background-color: #9fd4a3;
            border-radius: 5px;
            padding: 0.4em;
            margin-bottom: 0.5em;
            font-size: 1.2em;
            font-weight: 500;
            color: white;

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
                width: 95%;
            }

            .cowpic {
                display: none;
            }

            .box{
                margin-left:1.5em;
            }
            

            .ms1 .col-4 .ms1 p,
            .ms1 .col-5 p {
                margin-bottom: 10px;
            }

            .ms1 .detail-topic {
                font-size: 18px;
                font-weight: bold;
                margin-bottom: 10px;
            }

            .ms1 .other {
                margin-bottom: 10px;

            }

            .ms1 .text-other {
                font-size: 14px;
            }

            .ms1 p {
                font-size: 14px;
            }

            
            .ms1 .row.rg {
                flex-direction: column;
                padding: 2.5px;
            }

            .ms1 .col-6 {
                width: 100%;
                flex: 0 0 auto;
                max-width: 100%;
            }

            .ms1 .topic-other {
                font-size: 14px;
            }

        }

        @media (min-width: 768px) {
            .col-md-6 {
                width: 100% !important;
            }

            .g-2 {
                width: 92% !important;
            }

            .no-data-message {
                text-align: left !important;
                padding: 2em;
            }

            .col-md-5 {
                width: 48% !important;
            }
        }
    </style>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.3/dist/bootstrap-table.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.1/dist/bootstrap-table.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.2/dist/bootstrap-table-locale-all.min.js"></script>

<body>
    <?php include ('nav-bar.php');
    $acc_id = $_SESSION['acc_id'];

    ?>
    <div class="flex">
        <div class="g-1">
            <?php include ('sidebar.php') ?>
        </div>
        <div class="g-2">
            <!-- -------------------------------------------------------- -->
            <div class="content">
                <?php
                $cow_id = mysqli_real_escape_string($conn, $_GET['id']);

                // ดึงข้อมูลโคตาม cow_id จากตาราง cow
                $dec = mysqli_query($conn, "SELECT *, DATEDIFF(NOW(), cow_bday) AS age FROM cow WHERE cow_id = '$cow_id'");
                $dtc = mysqli_fetch_assoc($dec);

                // ดึงข้อมูลสายพันธุ์ของโค
                $cb_id = $dtc['cb_id'];
                $cb_id = mysqli_real_escape_string($conn, $cb_id);
                $mui = mysqli_query($conn, "SELECT * FROM cattle_breed WHERE cb_id = '$cb_id'");
                $mtc = mysqli_fetch_assoc($mui);

                // ดึงข้อมูลกลุ่มของโค
                $group = mysqli_query($conn, "SELECT * FROM group_cow 
                              INNER JOIN cow ON group_cow.group_id = cow.group_id 
                              WHERE cow.cow_id = '$cow_id'");
                $ngroup = mysqli_fetch_assoc($group);

                // ดึงข้อมูลความต้องการของโค
                $dem = mysqli_query($conn, "SELECT * FROM cow_demand 
            INNER JOIN cow ON cow_demand.dem_id = cow.cow_id 
            WHERE cow.cow_id = '$cow_id'");
                $qdem = mysqli_fetch_assoc($dem);

                $cow_breed_status = $dtc['cow_breed_status'];
                $cow_milk_status = $dtc['cow_milk_status'];
                $calf_date = $dtc['calf_date'];
                $milk_date = $dtc['milk_date'];
                $avgAgeDays = $dtc['age'];
                $generation = calculateGen($avgAgeDays, $milk_date, $calf_date);
                $age = convertDaysToYearsMonthsDays($dtc['age']);
                $row["cow_id"] = $dec;
                ?>
                <!-- ------------------------------------------------------------------------------------------------------- -->
                <!-- ------------------------------------------------------------------------------------------------------- -->
                <div class="ms1">
                    <div class="detail">
                        <div class="detail-topic">ข้อมูลทั่วไปของโค</div>
                        <div class="row">
                        <div class="col-xl col-lg-12 col-md-12 col-sm-12">
                                <div class="cowpic"><img src="../pic/<?php echo $dtc["cow_img"]; ?>" alt=""></div>
                            </div>
                            <div class="col-xl col-lg-5 col-md-5 col-sm-6 col-12">
                                    <div class="box">
                                    <p>
                                        <b>รหัสของโค : </b>
                                        <?php echo $dtc['cow_id'] ?>
                                    </p>
                                    <p><b>ชื่อ : </b>
                                        <?php echo $dtc["cow_name"], " ", " ", "<b>เพศ :</b>"; ?>
                                        <?php echo $dtc["cow_gender"]; ?>
                                    </p>
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

                                    ?>
                                    </p>
                                    <p><b> อายุ : </b>
                                        <?php echo $age ?>
                                    </p>
                                    <p><b> รุ่นของโค : </b>
                                        <?php echo $generation ?>
                                    </p>
                                    <p><b> พันธุ์ :</b>
                                        <?php echo $mtc["cb_Thainame"]; ?>
                                    </p>

                                    <p><b> น้ำหนักแรกเกิดของโค : </b>
                                        <?php echo $dtc["cow_first_weight"], " ", " กิโลกรัม"; ?>

                                    </p>
                                    <p><b> น้ำหนักปัจจุบันของโค : </b>
                                        <?php echo $dtc["cow_weight"], " ", " กิโลกรัม"; ?>
                                    </p>
                                </div>
                                    </div>
                           
                            <div class="col-xl col-lg-5 col-md-5 col-sm-6 col-12 ">
                                <div class="box">
                                    <p>
                                        <b>สถานะการตั้งท้อง : </b>
                                        <?php
                                        if ($dtc["cow_breed_status"] == "ตั้งท้อง") {
                                            echo $dtc["cow_breed_status"] . " " . $dtc['calf_date'] . " วัน";
                                        } else {
                                            echo "ท้องว่าง";
                                        }
                                        ?>
                                    </p>
                                    <p>
                                        <b>สถานะการให้นม : </b>
                                        <?php
                                        if ($dtc["cow_milk_status"] == "ให้นม") {
                                            echo $dtc["cow_milk_status"] . " " . $dtc['milk_date'] . " วัน";
                                        } else {
                                            echo "ไม่ให้นม";
                                        }
                                        ?>
                                    </p>
                                    <p><b> กิตติกรรมการเดิน :</b>
                                        <?php echo $dtc["cow_activity"]; ?>
                                    </p>
                                    <p>
                                        <b>โภชนะของโค : </b>
                                        <?php
                                        if (!empty ($qdem["dem_name"])) {
                                            echo $qdem["dem_name"];
                                        } else {
                                            echo "ยังไม่มีการคำนวณโภชนะ";
                                        }
                                        ?>
                                    </p>
                                    <p><b> กลุ่ม :
                                        </b>
                                        <?php echo $ngroup["group_name"]; ?>
                                    </p>
                                    <p><b> พ่อโค :</b>
                                        <?php echo !empty ($dtc["cow_dad_id"]) ? $dtc["cow_dad_id"] : '-'; ?>
                                    </p>
                                    <p><b> แม่โค :</b>
                                        <?php echo !empty ($dtc["cow_mom_id"]) ? $dtc["cow_mom_id"] : '-'; ?>
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ms1">
                    <div class="detail">
                        <div class="detail-topic">ข้อมูลเพิ่มเติมของโค</div>
                        <div class="row rg">
                            <div class="col-md-6 col-12 mt-3">
                                <div class="other">
                                    <div class="topic-other">ประวัติการผสมพันธุ์</div>
                                    <div class='text-other'>
                                        <?php
                                        $cow_id = mysqli_real_escape_string($conn, $_GET['id']);
                                        $breed_query = mysqli_query($conn, "SELECT * FROM cow_breed 
                                                INNER JOIN cow ON cow_breed.cow_id = cow.cow_id 
                                                WHERE cow.cow_id = '$cow_id' AND cow.deleteAt IS NULL 
                                                ");

                                        if (!$breed_query || mysqli_num_rows($breed_query) == 0) {
                                            echo "<p style='text-align:center; margin-top:1.2em; color:gray;'>ยังไม่มีข้อมูล</p>";
                                        } else {
                                            $counter = 1; // เพิ่มตัวแปรเพื่อนับลำดับ
                                            ?>
                                            <table id="table" data-toggle="table" data-height="200">
                                                <thead>
                                                    <tr>
                                                        <th>ลำดับ</th>
                                                        <th>วันที่ผสมพันธุ์</th>
                                                        <th>รหัสพ่อพันธุ์/น้ำเชื้อ</th>
                                                        <th>สถานะ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    while ($qbreed = mysqli_fetch_assoc($breed_query)) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $counter; ?>
                                                            </td> <!-- แสดงลำดับ -->
                                                            <td>
                                                                <?php echo date("d/m/Y", strtotime($qbreed["breed_date"])); ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $qbreed["breed_breeder"]; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $qbreed["breed_status"]; ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $counter++; // เพิ่มค่าลำดับ
                                                    }
                                                    ?>
                                                </tbody>
                                            </table><br>
                                            <button type="button"
                                                onclick="window.location='detail_cow_breed.php?id=<?php echo $cow_id; ?>'"
                                                class="btn btn-outline-success">สรุปผล</button>
                                            <?php
                                        }
                                        ?>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6 col-12 mt-3">
                                <div class="other">
                                    <div class="topic-other">ประวัติการเจ็บป่วย</div>
                                    <div class="text-other">
                                        <?php
                                        $cow_id = mysqli_real_escape_string($conn, $_GET['id']);
                                        $health_query = mysqli_query($conn, "SELECT * FROM cow_health 
                                                        INNER JOIN cow ON cow_health.cow_id = cow.cow_id 
                                                        WHERE cow.cow_id = '$cow_id' 
                                                        ORDER BY cow_health.updateAt");

                                        if (!$health_query || mysqli_num_rows($health_query) == 0) {
                                            echo "<p style='text-align:center; margin-top:1.2em; color:gray;'>ยังไม่มีข้อมูล</p>";
                                        } else {
                                            $qhealth = mysqli_fetch_assoc($health_query);
                                            ?>
                                            <p><b>ข้อมูลล่าสุด ณ วันที่ :</b>
                                                <?php echo date("d/m/Y", strtotime($qhealth["health_date"])); ?>
                                            </p>
                                            <p><b>อาการเจ็บป่วย :</b>
                                                <?php echo $qhealth["symptom"]; ?>
                                            </p>
                                            <p><b>สถานะการเจ็บป่วย :</b>
                                                <?php echo $qhealth["health_status"]; ?>
                                            </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6 col-12 mt-3">
                                <div class="other">
                                    <div class="topic-other">ประวัติการตรวจโรคประจำปี</div>
                                    <div class="text-other">
                                        <?php
                                        $cow_id = mysqli_real_escape_string($conn, $_GET['id']);
                                        $dianosis = mysqli_query($conn, "SELECT * FROM cow_dianosis 
                                                    INNER JOIN type_dianosis ON type_dianosis.type_dianosis_id = cow_dianosis.type_dianosis_id 
                                                    INNER JOIN cow ON cow_dianosis.cow_id = cow.cow_id 
                                                    WHERE cow.cow_id = '$cow_id' 
                                                    ORDER BY cow_dianosis.updateAt 
                                                    LIMIT 1");
                                        if (!$dianosis || mysqli_num_rows($dianosis) == 0) {
                                            echo "<p style='text-align:center; margin-top:1.2em; color:gray;'>ยังไม่มีข้อมูล</p>";
                                        } else {
                                            $qdianosis = mysqli_fetch_assoc($dianosis);
                                            ?>
                                            <p><b>ข้อมูลล่าสุด ณ วันที่ :</b>
                                                <?php echo date("d/m/Y", strtotime($qdianosis["dianosis_date"])); ?>
                                            </p>
                                            <p><b>ชื่อโรคที่ตรวจ :</b>
                                                <?php echo $qdianosis["type_dianosis_name"]; ?>
                                            </p>
                                            <p><b>ผลการตรวจ :</b>
                                                <?php echo $qdianosis["disease_result"]; ?>
                                            </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 mt-3">
                                <div class="other">
                                    <div class="topic-other">ประวัติการฉีควัคซีน</div>
                                    <div class="text-other">
                                        <?php
                                        $cow_id = mysqli_real_escape_string($conn, $_GET['id']);
                                        $vaccine = mysqli_query($conn, "SELECT * FROM type_vaccine 
                                                    INNER JOIN cow_vaccine ON type_vaccine.type_vaccine_id = cow_vaccine.type_vaccine_id 
                                                    INNER JOIN cow ON cow_vaccine.cow_id = cow.cow_id 
                                                    WHERE cow.cow_id = '$cow_id' 
                                                    ORDER BY cow_vaccine.updateAt 
                                                    LIMIT 1");
                                        if (!$vaccine || mysqli_num_rows($vaccine) == 0) {
                                            echo "<p style='text-align:center; margin-top:1.2em; color:gray;'>ยังไม่มีข้อมูล</p>";
                                        } else {
                                            $qvaccine = mysqli_fetch_assoc($vaccine);
                                            ?>
                                            <p><b>ข้อมูลล่าสุด ณ วันที่ :</b>
                                                <?php echo date("d/m/Y", strtotime($qvaccine["date_cow_vaccine"])); ?>
                                            </p>
                                            <p><b>ชื่อวัคซีน :</b>
                                                <?php echo $qvaccine["type_vaccine_name"]; ?>
                                            </p>
                                            <p><b>ผู้ฉีดวัคซีน :</b>
                                                <?php echo $qvaccine["vaccine_officer"]; ?>
                                            </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 mt-3">
                                <div class="other">
                                    <div class="topic-other">ประวัติการให้ปริมาณน้ำนม</div>
                                    <div class="text-other">
                                        <?php
                                        $cow_id = mysqli_real_escape_string($conn, $_GET['id']);
                                        $milk = mysqli_query($conn, "SELECT * FROM cow_milk 
                                                INNER JOIN cow ON cow_milk.cow_id = cow.cow_id 
                                                WHERE cow.cow_id = '$cow_id' 
                                                ORDER BY cow_milk.updateAt DESC 
                                                LIMIT 1");

                                        if (!$milk || mysqli_num_rows($milk) == 0) {
                                            echo "<p style='text-align:center; margin-top:1.2em; color:gray;'>ยังไม่มีข้อมูล</p>";
                                        } else {
                                            $qmilk = mysqli_fetch_assoc($milk);
                                            ?>
                                            <p><b>ข้อมูลล่าสุด ณ วันที่ :</b>
                                                <?php echo date("d/m/Y", strtotime($qmilk["date_milk"])); ?>
                                            </p>
                                            <p><b>ปริมาณน้ำนมรวม (กิโลกรัม) :</b>
                                                <?php echo $qmilk["milk_amount"]; ?>
                                            </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><br>
                <div class="d-flex justify-content-center btn-more">
            <div class="form-group">
                <button type="button"  onclick="window.location='cow.php'" class="btn btn-cancel">ย้อนกลับ</button>
            </div>
            <!-- <div class="form-group">
                <button type="submit" class="btn btn-add confirm" name="addcow">ยืนยัน</button>
            </div> -->
        </div>
            </div>
        </div>
    </div>

</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector("#menu a[href='cow.php']").classList.add("active");
    });
</script>

</html>