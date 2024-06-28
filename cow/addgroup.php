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
    <title>เพิ่มกลุ่มโค</title>
    <style>
        .w {
            width: 100%;
            margin-top: 8em;
        }

        .t-head {
            padding-top: 1.5em;
            width: 100%;
            text-align: center;

        }

        .cow {
            width: 100%;
            margin-top: 9em;
        }

        img {
            align-items: center;
            border-radius: 50%;
            width: 4.5em;
            height: 4.5em;
        }

        .col-3 #right {
            display: inline;

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

        .card {
            display: flex;
            margin: 2em auto;
            width: 90%;
            padding: 1.5rem;
        }

        .col-6 {
            padding: 0.8rem 1.2rem 0.8rem 1.3rem;
        }

        .addcowbutton .btn {
            display: block;
            background-color: #4F80C0;
            color: white;
            padding: 0.5em;
            width: 8em;
            margin: 1em auto;
            border-radius: 20px;
            font-size: 1em;
        }

        .addcowbutton .btn:hover {
            background-color: #92CA68;
            color: white;
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
                padding-left: 4em !important;
                padding-right: 1.5em !important;
            }

            .card {
                margin: 0 auto;
                width: 95%;
            }

            .col-2 {
                display: none;
                width: 100%;
            }

            .g-2 {
                width: 95%;

            }
            .no-data-message {
                text-align: left !important;
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
</script>

<body>
    <div class="flex">
        <div class="g-1">
            <?php include ('sidebar.php'); ?>
        </div>
        <div class="g-2">
            <div class="content">
                <h3 class="t-head">เพิ่มกลุ่มโค</h3>
                <div class="card">
                    <div class="card-body">
                        <div class="topic">
                            <form action="group_db.php" name="frmAdd" method="post" enctype="multipart/form-data"
                                class="was-validated">
                                <label for="group_name" class="form-label">ชื่อกลุ่มโค</label>
                                <input type="text" class="form-control" name="group_name" id="group_name"
                                    placeholder="กรอกชื่อกลุ่มโค" pattern="[a-zA-Z]+([a-zA-Z0-9\s,\-\.\(/)]*)"
                                    required><br>

                                <label for="meetfile" class="form-label">เลือกโค</label>
                                <table class="table" id="table" data-filter-control="true" data-toggle="table"
                                    data-pagination="true" data-locale="th-TH" data-flat="true" data-icons="icons"
                                    data-click-to-select="true">
                                    <thead>
                                        <tr class="table table-primary" style="text-align:center;">
                                            <th scope="col">เลือก</th>
                                            <th scope="col" data-searchable="false">รูปภาพ</th>
                                            <th scope="col">หมายเลขประจำตัวโค</th>
                                            <th scope="col">ชื่อ</th>
                                            <th scope="col">พันธุ์</th>
                                            <th scope="col">เพศ</th>
                                            <th scope="col">รุ่น</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    // ถ้าไม่มีการค้นหาหรือคำค้นหาว่างเปล่า, แสดงข้อมูลทั้งหมด
                                    $sql = "SELECT cow.*, cattle_breed.cb_Thainame ,DATEDIFF(NOW(), cow.cow_bday) AS age 
                                        FROM cow 
                                        INNER JOIN cattle_breed ON cow.cb_id = cattle_breed.cb_id 
                                        WHERE cow.group_id = 1 AND cow.acc_id = $acc_id 
                                        AND cow.deleteAt IS NULL
                                        ORDER BY cow.createAt DESC";
                                    $result = $conn->query($sql);


                                    // Function to calculate generation
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
                                    } ?>
                                    <tbody>
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $avgAgeDays = $row['age'];
                                                $cow_breed_status = $row['cow_breed_status'];
                                                $cow_milk_status = $row['cow_milk_status'];
                                                $calf_date = $row['calf_date'];
                                                $milk_date = $row['milk_date'];
                                                $age = convertDaysToYearsMonthsDays($row['age']);
                                                $generation = calculateGen($avgAgeDays, $milk_date, $calf_date);
                                                ?>
                                            <tr style="text-align:center;">
                                                <td>
                                                    <div class="checkbox-wrapper-26">
                                                        <input type="checkbox" id="checkbox-id<?php echo $row["cow_id"]; ?>"
                                                            value="<?php echo $row["cow_id"]; ?>" name="id[]">
                                                        <label for="checkbox-id<?php echo $row["cow_id"]; ?>">
                                                            <div class="tick_mark"></div>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><img class="img-circle" src="../pic/<?php echo $row["cow_img"]; ?>" />
                                                </td>
                                                <td>
                                                    <?php echo $row["cow_id"], " "; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row["cow_name"], " "; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row["cb_Thainame"], " "; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row["cow_gender"], " ", " "; ?>
                                                </td>
                                                <td>
                                                    <?php echo $generation, " ", " "; ?>
                                                </td>
                                            </tr>
                                            <?php
                                            }
                                        }else if($result->num_rows == 0){
                                            echo "<tr>
                                            <td colspan='7'>
                                                <p class='no-data-message' style='text-align: center; color: gray; margin-top: 2em;'>
                                                    คุณยังไม่มีข้อมูลโค ? <span><a href='addcow.php'  style='color: #4f80c0;'>เพิ่มข้อมูลโค</a></span></p>
                                            </td>";
                                        }?>
                                    
                                </tr>

                                    </tbody>
                                </table>
                                <div class="addcowbutton">
                                    <button type="submit" name="addgroup" value="submit" class="btn">สร้างกลุ่ม</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>


    <body>


    </body>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector("#menu a[href='cow.php']").classList.add("active");
        });
    </script>

</html>