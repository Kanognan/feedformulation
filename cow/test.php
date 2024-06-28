<?php 
session_start();
include('../server.php');
include("../session/user_session.php");
$acc_id = $_SESSION['acc_id'];
require_once("pagination_function.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
        integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <title>Document</title>

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
        display: block;
        margin: auto;
        border-radius: 15px !important;
        width: 15em;


    }

    .tagname {
        /* text-align: center; */
        color: #4f80c0;
        font-size: 2em;
        font-style: italic;
        margin-bottom: 1.2em;
        padding-top: 1.2em;
    }

    .cowpic img {
        align-items: center;
        width: 100%;
        overflow: hidden;
        padding: 1em;
        /* display: block; */
        /* margin: 0 auto; */
        border-radius: 30px;
    }

    .ms1 {
        text-indent: 0.5em;

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
        min-height: 12em;

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
            padding-left: 7em !important;
        }
    }
    </style>
</head>

<body>
    <?php include('nav-bar.php') ?>
    <div class="flex">
        <div class="g-1">
            <?php include('sidebar.php') ?>
        </div>
        <div class="g-2">

            <!-- -------------------------------------------------------- -->
            <div class="content">
                <?php
            $cow_id = $_GET['id'];
            $cb_id = $_GET['id'];
            $dec = mysqli_query($conn, "select *, DATEDIFF(NOW(), cow_bday) AS age from cow WHERE cow_id = $cow_id");
            $dtc = mysqli_fetch_assoc($dec);
            $mui = mysqli_query($conn, "select * from cattle_breed inner join cow on cattle_breed.cb_id = cow.cb_id ");
            $mtc = mysqli_fetch_assoc($mui);
            $group = mysqli_query($conn, "select * from group_cow inner join cow on group_cow.group_id = cow.group_id WHERE cow_id = $cow_id");
            $ngroup = mysqli_fetch_assoc($group);
            $dem = mysqli_query($conn, "select * from cow_demand inner join cow on cow_demand.dem_id = cow.dem_id WHERE cow_id = $cow_id");
            $qdem = mysqli_fetch_assoc($dem);
            $cow_breed_status = $dtc['cow_breed_status'];
            $cow_milk_status = $dtc['cow_milk_status'];
            $calf_date = $dtc['calf_date'];
            $milk_date = $dtc['milk_date']; 
            $avgAgeDays = $dtc['age'];
            $generation = calculateGen($avgAgeDays);
            $age = convertDaysToYearsMonthsDays($dtc['age']);
            $row["cow_id"] = $dec;
            ?>

                <!-- ------------------------------------------------------------------------------------------------------- -->


                <!-- ------------------------------------------------------------------------------------------------------- -->

                <div class="ms1">
                    <div class="detail">
                        <div class="detail-topic">ข้อมูลทั่วไปของโค</div>
                        <div class="row">
                            <div class="col-3">
                                <div class="cowpic"><img src="../pic/<?php echo $dtc["cow_img"]; ?>" alt=""></div>
                            </div>
                            <div class="col-4">
                                <div class="ms1">
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
                                    function calculateGen($avgAgeDays)
                                    {
                                        $gen = "ไม่พบรุ่น";
                                    
                                        if ($avgAgeDays >= 0 && $avgAgeDays <= 5) {
                                            $gen = 1 . " " . "ลูกโคแรกคลอดถึงอายุ 5 วัน";
                                        } elseif ($avgAgeDays >= 6 && $avgAgeDays <= 89) {
                                            $gen = 2 . " " . "ลูกโคอายุ 6 วันถึง 2 เดือน";
                                        } elseif ($avgAgeDays >= 90 && $avgAgeDays <= 149) {
                                            $gen = 3 . " " . "ลูกโคอายุ 3 ถึง 4 เดือน";
                                        } elseif ($avgAgeDays >= 150 && $avgAgeDays <= 269) {
                                            $gen = 4 . " " . "โครุ่นอายุ 5 ถึง 8 เดือน";
                                        } elseif ($avgAgeDays >= 270 && $avgAgeDays <= 450) {
                                            $gen = 5 . " " . "โครุ่นอายุ 9 ถึง 15 เดือน";
                                        } elseif ($avgAgeDays > 451) {
                                            $gen = 6 . " " . "โครุ่นอายุ 15 เดือน ถึงโคอุ้มท้องแรก";
                                        }
                                    
                                        return "รุ่นที่ " . $gen;
                                    }
                                ?>
                                    </p>
                                    <p><b> อายุ : </b><?php echo $age ?>
                                    </p>
                                    <p><b> รุ่นของโค : </b><?php echo $generation?>
                                    </p>
                                    <p><b> พันธุ์ :</b> <?php echo $mtc["cb_Thainame"]; ?>
                                    </p>

                                    <p><b> น้ำหนักแรกเกิดของโค : </b>
                                        <?php echo $dtc["cow_first_weight"], " ", " กิโลกรัม"; ?>

                                    </p>
                                    <p><b> น้ำหนักปัจจุบันของโค : </b>
                                        <?php echo $dtc["cow_weight"], " ", " กิโลกรัม"; ?>
                                    </p>
                                </div>

                            </div>
                            <div class="col-5">
                                <p>
                                    <b>สถานะการตั้งครรภ์ ณ ปัจจุบัน : </b>
                                    <?php 
                                        if ($dtc["cow_breed_status"] == "อยู่ในช่วงตั้งท้อง") {
                                            echo $dtc["cow_breed_status"]." ".$dtc['calf_date']." วัน";
                                        } else {
                                            echo "ไม่ได้อยู่ในช่วงตั้งท้อง";
                                        }
                                    ?>
                                </p>
                                <p>
                                    <b>สถานะการให้นม ณ ปัจจุบัน : </b>
                                    <?php 
                                        if ($dtc["cow_milk_status"] == "อยู่ในช่วงให้นม") {
                                            echo $dtc["cow_milk_status"]." ".$dtc['milk_date']." วัน";
                                        } else if($dtc["cow_milk_status"] == "อยู่ในช่วงพักรีดนม"){
                                            echo "อยู่ในช่วงพักรีดนม";
                                        }
                                        else {
                                            echo "ไม่ได้อยู่ในช่วงให้นม";
                                        }
                                    ?>
                                </p>
                                <p><b> กิตติกรรมการเดิน :</b>
                                    <?php echo $dtc["cow_activity"]; ?>
                                </p>
                                <p>
                                    <b>โภชนะของโค:</b>
                                    <?php 
                                        if (!empty($qdem["dem_name"])) {
                                            echo $qdem["dem_name"];
                                        } else {
                                            echo "ยังไม่มีการคำนวณโภชนะ";
                                        }
                                    ?>
                                </p>
                                <p><b> กลุ่ม :
                                    </b><?php echo $ngroup["group_name"]; ?></p>
                                <p><b> พ่อโค :</b>
                                    <?php echo $dtc["cow_dad_id"]?>
                                </p>
                                <p><b> แม่โค :</b>
                                    <?php echo $dtc["cow_mom_id"]; ?>
                                </p>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ms1">
                    <div class="detail">
                        <div class="detail-topic">ข้อมูลเพิ่มเติมของโค</div>
                        <div class="row rg">
                            <div class="col-6">
                                <div class="other">
                                    <div class="topic-other">ประวัติการผสมพันธุ์</div>
                                    <div class='text-other'>
                                        <?php 
                                        $breed_query = mysqli_query($conn, "SELECT * FROM cow_breed INNER JOIN cow ON cow_breed.cow_id = cow.cow_id WHERE cow.cow_id = $cow_id order by cow_breed.updateAt LIMIT 1");
                                        // Check if there was an error in the query
                                        if (!$breed_query) {
                                            die("Query failed: " . mysqli_error($conn));
                                        }
                                        // Check if the query returned any rows
                                        if (mysqli_num_rows($breed_query) > 0) {
                                            // Fetch the first row as an associative array
                                            $qbreed = mysqli_fetch_assoc($breed_query);
                                            ?>
                                        <p><b>ข้อมูลล่าสุด ณ วันที่ :
                                            </b><?php echo date("d/m/Y", strtotime($qbreed["breed_date"])); ?></p>
                                        <p><b>พ่อพันธุ์/น้ำเชื้อ :</b> <?php echo $qbreed["breed_breeder"]; ?></p>
                                        <p><b>สถานะการผสมพันธุ์ :</b> <?php echo $qbreed["breed_status"]; ?></p>
                                        <?php
                                        } else {
                                            // Handle the case when no rows are returned
                                            echo "<p style='text-align:center; margin-top:1.2em; color:gray;'>ยังไม่มีข้อมูล</p>";
                                        }
                                        ?>
                                    </div>
                                </div>

                            </div>
                            <div class="col-6">
                                <div class="other">
                                    <div class="topic-other">ประวัติการประวัติการเจ็บป่วย</div>
                                    <div class="text-other">
                                        <?php 
                                        $health = mysqli_query($conn, "SELECT * FROM cow_health INNER JOIN cow ON cow_health.cow_id = cow.cow_id WHERE cow.cow_id = $cow_id order by cow_health.updateAt LIMIT 1");
                                        // Check if there was an error in the query
                                        if (!$health) {
                                            die("Query failed: " . mysqli_error($conn));
                                        }
                                        // Check if the query returned any rows
                                        if (mysqli_num_rows($health) > 0) {
                                            // Fetch the first row as an associative array
                                            $qhealth = mysqli_fetch_assoc($health);
                                            ?>
                                        <p><b>ข้อมูลล่าสุด ณ วันที่ :
                                            </b><?php echo date("d/m/Y", strtotime($qhealth["health_date"])); ?></p>
                                        <p><b>อาการเจ็บป่วย :</b> <?php echo $qhealth["symptom"]; ?></p>
                                        <p><b>สถานะการเจ็บป่วย :</b> <?php echo $qhealth["health_status"]; ?></p>

                                        <?php
                                        } else {
                                            // Handle the case when no rows are returned
                                            echo "<p style='text-align:center; margin-top:1.2em; color:gray;'>ยังไม่มีข้อมูล</p>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row rg">
                            <div class="col-6">
                                <div class="other">
                                    <div class="topic-other">ประวัติการตรวจโรคประจำปี</div>
                                    <div class="text-other">
                                        <?php 
                                        $dianosis = mysqli_query($conn, "SELECT * FROM cow_dianosis INNER JOIN type_dianosis ON type_dianosis.type_dianosis_id = cow_dianosis.type_dianosis_id INNER JOIN cow ON cow_dianosis.cow_id = cow.cow_id WHERE cow.cow_id = $cow_id order by cow_dianosis.updateAt LIMIT 1");
                                        // Check if there was an error in the query
                                        if (!$dianosis) {
                                            die("Query failed: " . mysqli_error($conn));
                                        }
                                        // Check if the query returned any rows
                                        if (mysqli_num_rows($dianosis) > 0) {
                                            // Fetch the first row as an associative array
                                            $qdianosis = mysqli_fetch_assoc($dianosis);
                                            ?>
                                        <p><b>ข้อมูลล่าสุด ณ วันที่ :
                                            </b><?php echo date("d/m/Y", strtotime($qdianosis["dianosis_date"])); ?></p>
                                        <p><b>ชื่อโรคที่ตรวจ :</b> <?php echo $qdianosis["type_dianosis_name"]; ?></p>
                                        <p><b>ผลการตรวจ :</b> <?php echo $qdianosis["disease_result"]; ?></p>

                                        <?php
                                        } else {
                                            // Handle the case when no rows are returned
                                            echo "<p style='text-align:center; margin-top:1.2em; color:gray;'>ยังไม่มีข้อมูล</p>";
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="other">
                                    <div class="topic-other">ประวัติการฉีควัคซีน</div>
                                    <div class="text-other">
                                        <?php 
                                        $vaccine = mysqli_query($conn, "SELECT * FROM type_vaccine INNER JOIN cow_vaccine ON type_vaccine.type_vaccine_id = cow_vaccine.type_vaccine_id INNER JOIN cow ON cow_vaccine.cow_id = cow.cow_id WHERE cow.cow_id = $cow_id order by cow_vaccine.updateAt LIMIT 1");
                                        // Check if there was an error in the query
                                        if (!$vaccine) {
                                            die("Query failed: " . mysqli_error($conn));
                                        }
                                        // Check if the query returned any rows
                                        if (mysqli_num_rows($vaccine) > 0) {
                                            // Fetch the first row as an associative array
                                            $qvaccine = mysqli_fetch_assoc($vaccine);
                                            ?>
                                        <p><b>ข้อมูลล่าสุด ณ วันที่ :
                                            </b><?php echo date("d/m/Y", strtotime($qvaccine["date_cow_vaccine"])); ?>
                                        </p>
                                        <p><b>ชื่อวัคซีน :</b> <?php echo $qvaccine["type_vaccine_name"]; ?></p>
                                        <p><b>ผู้ฉีดวัคซีน :</b> <?php echo $qvaccine["vaccine_officer"]; ?></p>

                                        <?php
                                        } else {
                                            // Handle the case when no rows are returned
                                            echo "<p style='text-align:center; margin-top:1.2em; color:gray;'>ยังไม่มีข้อมูล</p>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row rg">
                            <div class="col-6">
                                <div class="other">
                                    <div class="topic-other">ประวัติการให้ปริมาณน้ำนม</div>
                                    <div class="text-other">
                                        <?php 
                                        $milk = mysqli_query($conn, "SELECT * FROM cow_milk INNER JOIN cow ON cow_milk.cow_id = cow.cow_id WHERE cow.cow_id = $cow_id ORDER BY cow_milk.updateAt DESC LIMIT 1");
                                        // Check if there was an error in the query
                                        if (!$milk) {
                                            die("Query failed: " . mysqli_error($conn));
                                        }
                                        // Check if the query returned any rows
                                        if (mysqli_num_rows($milk) > 0) {
                                            // Fetch the first row as an associative array
                                            $qmilk = mysqli_fetch_assoc($milk);
                                            ?>
                                        <p><b>ข้อมูลล่าสุด ณ วันที่ :
                                            </b><?php echo date("d/m/Y", strtotime($qmilk["date_milk"])); ?></p>
                                        <p><b>ปริมาณน้ำนมรวม (กิโลกรัม) :</b> <?php echo $qmilk["milk_amount"]; ?></p>



                                        <?php
                                        } else {
                                            // Handle the case when no rows are returned
                                            echo "<p style='text-align:center; margin-top:1.2em; color:gray;'>ยังไม่มีข้อมูล</p>";
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




</body>
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector("#menu a[href='cow.php']").classList.add("active");
});
</script>

</html>