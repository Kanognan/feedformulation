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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="icon" type="image" href="../Images/logofeeds.png">
    <title>ผลลัพธ์การคำนวณโภชนะโคแบบรายตัว</title>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Kanit', sans-serif;
    }

    .flex {
        display: flex;
    }

    .g-2 {
        flex: 1;
    }

    .content {
        padding: 3em;
        padding-left: 17em !important;
        width: 100%;
    }

    i {
        font-size: 20px;
        margin-right: 0.7em;
    }

    .top {
        margin-top: 7em;
        height: cover;

    }

    .title-detail {
        text-align: center;
        margin-bottom: 1.5em;
    }

    .main {
        margin-top: 3rem;
        padding: 0.5rem;
        width: 100%;

    }

    .t1-1 {
        background-color: #c6d9eb;
        padding: 2em;
        border-radius: 15px;
        margin-bottom: 1.25em;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
    }

    .feedcow {
        border: 1px solid lightgray;
        padding: 2em;
        border-radius: 20px;
        margin: 1.5em auto;
        width: 85%;
        height: cover;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
    }


    .addmore .btn {
        display: block;
        background-color: #92CA68;
        color: white;
        padding: 0.5em;
        width: 6em;
        margin: 0 auto;
        border-radius: 20px;
        font-size: 1em;
    }


    .addcal .btn:hover,
    .addcal .btn:focus:hover {
        background-color: #92CA68;
        color: black;
    }

    .addmore .btn:hover,
    .addmore .btn:focus:hover {
        background-color: #DBEDF2;
        color: black;
    }

    .edible {
        background-color: #fff;
        /* border-radius: 20px; */
        /* padding: 0.5em; */
        margin: 0.5em auto;
        height: auto;

    }

    .box-edible {
        background-color: #c6d9eb;
        padding: 1.5em;
        border-radius: 20px;
        margin: 2em;
        height: auto;

    }


    .tpic-edible {
        background-color: #6999C6;
        padding: 0.5em;
        text-align: center;
        font-size: 1.2em;
        font-weight: 400;

    }

    .content-edible {
        height: 15em;
        padding: 1.5em;

    }

    .pspan {
        color: gray;
    }

    .btn-more {
        margin: 1em 0em 1em 0em;
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

    .hidden {
        display: none;
    }
    .pspan{
        color:#dc3545;
        font-size: 0.9em;
    }


    @media (max-width: 576px) {
        .content {
            padding-left: 5em !important;
            padding-right: 1em !important;
        }
        .g-2{
            width: 96%;
        }
        .t1-1{
            padding:15px;
        }
        .content-edible{
            padding:12px;
        }
    }
</style>

<div class="hidden">
    <?php include ('../weatherAPI.php'); ?>
</div>

<?php
// $humidity = $result['main']['humidity'];
// $tem = $result['main']['temp'] - 273.15;

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
        } elseif ($calf_date >= 0) {
            if ($milk_date > 0 && $milk_date <= 100) {
                $gen = "โครีดนมช่วงต้น";
            } elseif ($milk_date >= 101 && $milk_date <= 200) {
                $gen = "โครีดนมช่วงกลาง";
            } elseif ($milk_date > 201) {
                $gen = "โครีดนมช่วงปลาย";
            } elseif ($milk_date == 0) {
                $gen = "โคท้อง";
            }
        } elseif ($calf_date > 226 && $calf_date < 285) {
            $gen = "โคพักรีด";
        }
    }

    return $gen . " " . $milkPeriod;
}

if (isset ($_POST['calproduct'])) {
    $cid = $_POST['cow_select'];
    $cid = mysqli_real_escape_string($conn, $_POST['cow_select']);
    $temperature = $_POST['tem'];
    $rh = $_POST['humidity'];
    // echo $temperature,$rh;

    // ตรวจสอบสถานะการเชื่อมต่อฐานข้อมูล
    if (!$conn) {
        die ("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . mysqli_connect_error());
    }

    // ดึงข้อมูลจากตาราง cow
    $mui = mysqli_query($conn, "SELECT *, DATEDIFF(NOW(), cow_bday) AS age FROM cow WHERE cow_id = '$cid'");

    // ตรวจสอบสถานะการเรียกใช้ mysqli_query()
    if (!$mui) {
        die ("การเรียกใช้ mysqli_query() ล้มเหลว: " . mysqli_error($conn));
    }

    $mtc = mysqli_fetch_assoc($mui);

    // ดึงข้อมูลจากตาราง cow_breed
    $breed = mysqli_query($conn, "SELECT * FROM cow_breed WHERE cow_id = '$cid'");

    // ตรวจสอบสถานะการเรียกใช้ mysqli_query()
    if (!$breed) {
        die ("การเรียกใช้ mysqli_query() ล้มเหลว: " . mysqli_error($conn));
    }
    $cow_gender = $mtc['cow_gender'];
    $cow_weight = $mtc['cow_weight'];
    $cow_activity = $mtc['cow_activity'];
    $cow_breed_status = $mtc['cow_breed_status'];
    $cow_milk_status = $mtc['cow_milk_status'];
    $calf_date = $mtc['calf_date'];
    $milk_date = $mtc['milk_date'];
    $avgAgeDays = $mtc['age'];
    $generation = calculateGen($avgAgeDays, $milk_date, $calf_date);
    $age = convertDaysToYearsMonthsDays($mtc['age']);
    // w0.75-------------------------------------------------
    $weight75 = pow($cow_weight, 0.75);

    // หาค่า thi------------------------------------------------------------------------------------------
    $THI = (1.8 * $tem + 32) - (0.55 - 0.0055 * $rh) * (1.8 * $tem - 26);

    // หาค่าการกินได้ $DMI
    $DMIg = 0.105 * $weight75; // โคสาว,โคพักรีด
    $DMIl1 = 0.108 * $weight75; // โคให้นม

    // ค่าเยื่อใย
    $NDF = 33;
    $ADF = 21;
    $NFC = 43;
    $vitA_kg_1 = 16000;
    $vitD_kg_1 = 3076;
    $vitE_kg_1 = 6000;
    $vitA_ui_1 = 1154;
    $vitD_ui_1 = 160;
    $vitE_ui_1 = 31;
    $vitA_kg_2 = 24000;
    $vitD_kg_2 = 3380;
    $vitE_kg_2 = 9000;
    $vitA_ui_2 = 1268;
    $vitD_ui_2 = 240;
    $vitE_ui_2 = 34;
    $vitA_kg_3 = 36000;
    $vitD_kg_3 = 3185;
    $vitE_kg_3 = 13500;
    $vitA_ui_3 = 1195;
    $vitD_ui_3 = 360;
    $vitE_ui_3 = 32;

    // แร่ธาตุ
    $ca = 0.62;
    $p = 0.32;
    $mg = 0.18;
    $cl = 0.24;
    $k = 1;
    $na = 0.22;
    $s = 0.2;
    $co = 0.11;
    $cu = 11;
    $i = 0.6;
    $fe = 12.3;
    $mn = 14;
    $se = 0.3;
    $zn = 43;
    ?>

    <body>
        <div class="flex">
            <div class="g-1">
                <?php include ('sidebar.php') ?>
            </div>
            <div class="g-2">
                <div class="content">

                    <h2 class="text-center">ผลลัพธ์การคำนวณโภชนะโคแบบรายตัว</h2>
                    <form action="addproduct.php?cow_id=<?php echo $cid; ?>" method="post">
                        <div class="t1-1 was-validated">
                            <label for="exampleFormControlInput1" class="form-label">ชื่อรายการคำนวณโภชนะ</label>
                            <input type="text" class="form-control" id="dem_name" name="dem_name"
                                placeholder="กรอกชื่อรายการคำนวณโภชนะ" required pattern="[^' '][a-zA-Zก-๙0-9]+"><span class="pspan">* ถ้าต้องการบันทึกค่าการคำนวณโภชนะ</span>
                        </div>
                        <div class="t1-1">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="edible">
                                        <div class="tpic-edible">
                                            <p>ข้อมูลทั่วไป</p>
                                        </div>
                                        <div class="content-edible">
                                            <p>
                                                <?php echo "<b>หมายเลขประจำตัวโค : </b>" . $mtc['cow_id'], " ", "<b>ชื่อ :</b>", " " . $mtc['cow_name'], '<br>'; ?>
                                            </p>
                                            <p>
                                                <?php echo "<b>เพศ : </b>" . $mtc['cow_gender'], '<br>'; ?>
                                            </p>
                                            <p>
                                                <?php echo '<b>อายุ : </b>' . $age . '<br>'; ?>
                                            </p>
                                            <p>
                                                <?php echo ' <b>รุ่น : </b>' . $generation; ?>
                                            </p>
                                            <p>
                                                <?php echo ' <b>กิตติกรรมการเดิน : </b>' . $mtc['cow_activity']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="edible">
                                        <div class="tpic-edible">
                                            <p>ข้อมูลอื่นๆ</p>
                                        </div>
                                        <div class="content-edible">
                                            <p><b>สถานะการรีดนม : </b>
                                                <?php echo " " . $cow_milk_status, '<br>'; ?>
                                            </p>
                                            <p><b>วันให้นม :</b>
                                                <?php echo " " . $milk_date; ?> วัน
                                            </p>
                                            <p><b>สถานะการตั้งท้อง :</b>
                                                <?php echo " " . $cow_breed_status, '<br>'; ?>
                                            </p>
                                            <p><b>อายุครรภ์ :</b>
                                                <?php echo " " . $calf_date; ?>วัน
                                            </p>
                                            <p>
                                                <input type="hidden" name="THI"
                                                    value="<?php echo number_format($THI, 0, '.', ''); ?>">
                                                <b>ค่า THI :</b>
                                                <?php
                                                if ($THI < 72) {
                                                    echo number_format($THI, 0, '.', '') . " แสดงว่า <span style='color:white; background-color:green; padding:0.3em; border-radius:10px;'>โคอยู่ในสภาวะปกติ</span>";
                                                } else if ($THI > 72 && $THI < 79) {
                                                    echo number_format($THI, 0, '.', '') . " แสดงว่า <span style='color:black; background-color:yellow; font-weight:bold; padding:0.3em; border-radius:10px;'>โคอยู่ในสภาวะเครียดเล็กน้อย</span>";
                                                } else if ($THI > 79 && $THI < 90) {
                                                    echo number_format($THI, 0, '.', '') . " แสดงว่า <span style='color:white; background-color:orange; font-weight:bold; padding:0.3em; border-radius:10px;'>โคอยู่ในสภาวะเครียดปานกลาง</span>";
                                                } else if ($THI > 90) {
                                                    echo number_format($THI, 0, '.', '') . " แสดงว่า <span style='color:white; background-color:red; font-weight:bold; padding:0.3em; border-radius:10px;'>โคอยู่ในสภาวะเครียดสูง</span>";
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row mt-3">
                                <h5>ข้อมูลความต้องการโภชนะของโค</h5>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <tbody>
                                            <?php
                                            if ($cow_milk_status == "ให้นม") {
                                                $Fat = $_POST['fat'];
                                                $Protein = $_POST['protein'];
                                                $adg = $_POST['adg'];
                                                $Totalmilk = $_POST['totalmilk'];
                                                $fy = $Totalmilk * ($Fat / 100);
                                                $fcm = (0.35 * $Totalmilk) + (18.57 * $fy);
                                                $tpy = $fcm * ($Protein / 100);
                                                // adg---------------------------------------------------
                                                $adj_tpy = ($tpy * 1000) / 0.955;
                                                $adg_g = $adg * 1000;
                                                $adg_g75 = $adg / $weight75;

                                                $NEm = 85 * $weight75;
                                                $MEm = 123 * $weight75;
                                                $WOL = $milk_date / 7;
                                                $DMIl1 = (0.372 * $fcm + 0.0968 * $weight75) * (1 - exp((-0.192) * ($WOL + 3.67)));
                                                if ($THI > 90) {
                                                    $DMI = $DMIl1 * (1 - (($tem - 20) * 0.005922));
                                                    $MEhh = ($MEm * 15) / 100; // ค่า me เพื่อลดความเครียดจากความร้อนสูง
                                                } else if ($THI > 79 && $THI < 90) {
                                                    $DMI = $DMIl1 * (1 - (($tem - 20) * 0.005922));
                                                    $MEhh = ($MEm * 10) / 100; // ค่า me เพื่อลดความเครียดจากความร้อนสูง
                                                } else if ($THI > 72 && $THI < 79) {
                                                    $DMI = $DMIl1 * (1 - (($tem - 20) * 0.005922));
                                                    $MEhh = ($MEm * 5) / 100; // ค่า me เพื่อลดความเครียดจากความร้อนสูง
                                                } else if ($THI < 72) {
                                                    $DMI = $DMIl1 * (1 - ((5 - $tem) * 0.004644));
                                                    $MEhh = ($MEm * 0) / 100; // ค่า me เพื่อลดความเครียดจากความร้อนสูง
                                                }

                                                if ($cow_activity == 'ขังคอก') {
                                                    $MEa = $MEm * 0 / 100; // ค่า me เพื่อการเดิน
                                                } elseif ($cow_activity == 'ปล่อยเล็มแปลงพืช') {
                                                    $MEa = $MEm * 5 / 100; // ค่า me เพื่อการเดิน
                                                }

                                                // ------------------------------------------------------
                                                $NEl = ((0.0929 * $Fat) + (0.0547 * $Protein) + 0.192) * $Totalmilk / $DMI;

                                                // MP---------------------------------------------------
                                                $MPm = 3.055 * $weight75;
                                                $MPg = 3.6774 + (0.2568 * $adg_g75);
                                                $MPl = ($adj_tpy - 0.0813) / 0.3502;
                                                $MP = ($MPm + $MPg + $MPl);
                                                $MPtotal = $MP / 1000 / $DMI * 100;

                                                $RDP_1 = ($MP * 64.13/100) / (0.6375 * 0.95);
                                                $RUP_1 = ($MP * 35.87/100) / 0.85;
                                                $RDP = $RDP_1 / 1000  / $DMI *100 ;
                                                $RUP = $RUP_1 /1000 / $DMI *100 ;
                                                $CP = ($RDP + $RUP);

                                                // ME--------------------------------------------
                                        
                                                $MEl = $NEl * 0.69;
                                                $ME = ($MEm + $MEa + $MEhh + $MEl);
                                                $totalME = $ME /1000/ $DMI;

                                                // DE--------------------------------------------
                                                $DE = ($ME + 0.189) /1000 /0.92 / $DMI;

                                                // TDN-------------------------------------------
                                                $TDN = ($ME - 0.019) /1000 / 3.74 / $DMI * 100;

                                                $data = array(
                                                    "BW (Kg)" => number_format($cow_weight, 0, '.', ''),
                                                    "THI" => number_format($THI, 0, '.', ''),
                                                    "Milk (Kg/d)" => number_format($Totalmilk, 2, '.', ''),
                                                    "Fat (%)" => number_format($Fat, 2, '.', ''),
                                                    "Protien (%)" => number_format($Protein, 2, '.', ''),
                                                    "BDC (Kg/d)" => number_format($adg, 2, '.', ''),
                                                    "INTAKE (Kg/d)" => number_format($DMI, 2, '.', ''),
                                                    "NEL (Mcal/kg)" => number_format($NEl, 2, '.', ''),
                                                    "ME (Mcal/kg)" => number_format($totalME, 2, '.', ''),
                                                    "DE (Mcal/kg)" => number_format($DE, 1, '.', ''),
                                                    "TDN (%)" => number_format($TDN, 1, '.', ''),
                                                    "MP (%)" => number_format($MPtotal, 1, '.', ''),
                                                    "RDP (%)" => number_format($RDP, 1, '.', ''),
                                                    "RUP (%)" => number_format($RUP, 1, '.', ''),
                                                    "CP (%)" => number_format($CP, 1, '.', '')
                                                );
                                            } elseif ($cow_milk_status == "ไม่ให้นม") {
                                                $growth = $_POST['growth'];
                                                $NEm = 85 * $weight75;
                                                $MEm = 123 * $weight75;
                                                if ($THI > 90) {
                                                    $DMI = $DMIg * (1 - (($tem - 20) * 0.005922));
                                                    $MEhh = ($MEm * 15) / 100; // ค่า me เพื่อลดความเครียดจากความร้อนสูง
                                                } else if ($THI > 79 && $THI < 90) {
                                                    $DMI = $DMIg * (1 - (($tem - 20) * 0.005922));
                                                    $MEhh = ($MEm * 10) / 100; // ค่า me เพื่อลดความเครียดจากความร้อนสูง
                                                } else if ($THI > 72 && $THI < 79) {
                                                    $DMI = $DMIg * (1 - (($tem - 20) * 0.005922));
                                                    $MEhh = ($MEm * 5) / 100; // ค่า me เพื่อลดความเครียดจากความร้อนสูง
                                                } else if ($THI < 72) {
                                                    $DMI = $DMIg * (1 - ((5 - $tem) * 0.004644));
                                                    $MEhh = ($MEm * 0) / 100; // ค่า me เพื่อลดความเครียดจากความร้อนสูง
                                                }

                                                if ($cow_activity == 'ขังคอก') {
                                                    $MEa = $MEm * 0 / 100; // ค่า me เพื่อการเดิน
                                                } elseif ($cow_activity == 'ปล่อยเล็มแปลงพืช') {
                                                    $MEa = $MEm * 5 / 100; // ค่า me เพื่อการเดิน
                                                }

                                                $NEa = $NEm * 5 / 100;
                                                $NEhh = ($NEm * 15) / 100; // ค่า me เพื่อลดความเครียดจากความร้อนสูง
                                                $totalNE = ($NEm + $NEa + $NEhh) / 1000;

                                                // ME--------------------------------------------
                                        
                                                $MEhh = ($MEm * 15) / 100; // ค่า me เพื่อลดความเครียดจากความร้อนสูง
                                                $ME = ($MEm + $MEa + $MEhh) / 1000;
                                                $totalME = $ME / $DMI;
												$growth1 = $growth * 1000;
                                                $growth_g75 = $growth1 / $weight75;

                                                // MP---------------------------------------------------
                                                $MPm = 2.45373 * $weight75;
                                                $MPg1 = 3.6774 + (0.2568 * $growth_g75);
                                                $MPg = $MPg1 * $weight75;
                                                $MP = ($MPm + $MPg);
                                                $MPtotal = $MP / 1000 / $DMI * 100;

                                                // -----------------------------------------------------
                                                $RDP_1 = ($MP * 33.7 / 100) / (0.6375 * 0.95);
                                                $RDP = $RDP_1 /1000/ $DMI * 100;
                                                $RUP_1 = ($MP * 66.3 / 100) / 0.85;
                                                $RUP = $RUP_1 /1000/ $DMI * 100;
                                                $CP = ($RDP + $RUP);

                                                // DE--------------------------------------------
                                                $DE = ($ME + 0.189) / 0.92 / $DMI;

                                                // TDN-------------------------------------------
                                                $TDN = ($ME - 0.019) / 3.74 / $DMI * 100;
                                                $data = array(
                                                    "BW (Kg)" => number_format($cow_weight, 0, '.', ''),
                                                    "THI" => number_format($THI, 0, '.', ''),
                                                    "ADG (Kg/d)" => number_format($growth, 2, '.', ''),
                                                    "INTAKE (Kg/d)" => number_format($DMI, 2, '.', ''),
                                                    "ME (Mcal/kg)" => number_format($totalME, 2, '.', ''),
                                                    "DE (Mcal/kg)" => number_format($DE, 1, '.', ''),
                                                    "TDN (%)" => number_format($TDN, 1, '.', ''),
                                                    "MP (%)" => number_format($MPtotal, 1, '.', ''),
                                                    "RDP (%)" => number_format($RDP, 2, '.', ''),
                                                    "RUP (%)" => number_format($RUP, 2, '.', ''),
                                                    "CP (%)" => number_format($CP, 1, '.', '')
                                                );
                                            }
                                            // เริ่มต้นวนลูปแสดงข้อมูลในตาราง
                                            echo "<table class='table table-bordered' style='font-family:\"Kanit\"; text-align:center;'>";
                                            echo "<thead><tr style='background-color:#6999c6;'>";

                                            // สร้างหัวข้อคอลัมน์
                                            foreach ($data as $key => $value) {
                                                echo "<th scope='col'>$key</th>";

                                            }
                                            echo "</tr></thead><tbody><tr style='background-color:white;'>";
                                            // แสดงข้อมูลในแต่ละคอลัมน์
                                            foreach ($data as $value) {
                                                echo "<td>$value</td>";
                                            }
                                            echo "</tr></tbody></table>";
                                            ?>
                                            <input type="hidden" name="BW" value="<?php echo $data['BW (Kg)']; ?>">
                                            <input type="hidden" name="THI" value="<?php echo $data['THI']; ?>">
                                            <input type="hidden" name="Fat" value="<?php echo $data['Fat (%)']; ?>">
                                            <input type="hidden" name="Protein" value="<?php echo $data['Protien (%)']; ?>">
                                            <input type="hidden" name="Milk" value="<?php echo $data['Milk (Kg/d)']; ?>">
                                            <input type="hidden" name="BDC" value="<?php echo $data['BDC (Kg/d)']; ?>">
                                            <input type="hidden" name="ADG" value="<?php echo $data['ADG (Kg/d)']; ?>">
                                            <input type="hidden" name="INTAKE"
                                                value="<?php echo $data['INTAKE (Kg/d)']; ?>">
                                            <input type="hidden" name="NEL" value="<?php echo $data['NEL (Mcal/kg)']; ?>">
                                            <input type="hidden" name="ME" value="<?php echo $data['ME (Mcal/kg)']; ?>">
                                            <input type="hidden" name="DE" value="<?php echo $data['DE (Mcal/kg)']; ?>">
                                            <input type="hidden" name="TDN" value="<?php echo $data['TDN (%)']; ?>">
                                            <input type="hidden" name="MP" value="<?php echo $data['MP (%)']; ?>">
                                            <input type="hidden" name="RDP" value="<?php echo $data['RDP (%)']; ?>">
                                            <input type="hidden" name="RUP" value="<?php echo $data['RUP (%)']; ?>">
                                            <input type="hidden" name="CP" value="<?php echo $data['CP (%)']; ?>">
                                        </tbody>

                                    </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <h5>ข้อมูลค่าแนะนำความต้องการวิตามินและค่าเยื่อใยของโค</h5><br>
                                <div class="col-12">
                                    <div class="table-responsive">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="6">วิตามิน</th>
                                                <th colspan="3">เยื่อใย</th>
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">vit A</th>
                                                <th scope="col">vit D</th>
                                                <th scope="col">vit E</th>
                                                <th scope="col">NDF</th>
                                                <th scope="col">ADF</th>
                                                <th scope="col">NFC</th>
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="3">(IU/Day)</th>
                                                <th colspan="3">(IU/Kg)</th>
                                                <th colspan="3">(>%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <input type="hidden" name="vitA_kg_1" value="<?php echo $vitA_kg_1; ?>">
                                            <input type="hidden" name="vitD_kg_1" value="<?php echo $vitD_kg_1; ?>">
                                            <input type="hidden" name="vitE_kg_1" value="<?php echo $vitE_kg_1; ?>">
                                            <input type="hidden" name="vitA_ui_1" value="<?php echo $vitA_ui_1; ?>">
                                            <input type="hidden" name="vitD_ui_1" value="<?php echo $vitD_ui_1; ?>">
                                            <input type="hidden" name="vitE_ui_1" value="<?php echo $vitE_ui_1; ?>">
                                            <input type="hidden" name="vitA_kg_2" value="<?php echo $vitA_kg_2; ?>">
                                            <input type="hidden" name="vitD_kg_2" value="<?php echo $vitD_kg_2; ?>">
                                            <input type="hidden" name="vitE_kg_2" value="<?php echo $vitE_kg_2; ?>">
                                            <input type="hidden" name="vitA_ui_2" value="<?php echo $vitA_ui_2; ?>">
                                            <input type="hidden" name="vitD_ui_2" value="<?php echo $vitD_ui_2; ?>">
                                            <input type="hidden" name="vitE_ui_2" value="<?php echo $vitE_ui_2; ?>">
                                            <input type="hidden" name="vitA_kg_3" value="<?php echo $vitA_kg_3; ?>">
                                            <input type="hidden" name="vitD_kg_3" value="<?php echo $vitD_kg_3; ?>">
                                            <input type="hidden" name="vitE_kg_3" value="<?php echo $vitE_kg_3; ?>">
                                            <input type="hidden" name="vitA_ui_3" value="<?php echo $vitA_ui_3; ?>">
                                            <input type="hidden" name="vitD_ui_3" value="<?php echo $vitD_ui_3; ?>">
                                            <input type="hidden" name="vitE_ui_3" value="<?php echo $vitE_ui_3; ?>">
                                            <?php
                                            if ($avgAgeDays >= 180 && $avgAgeDays <= 359) {
                                                echo "
                                                  <tr style='text-align:center; background-color:#fff;'>
                                                      <td>$vitA_kg_1</td>
                                                      <td>$vitD_kg_1</td>
                                                      <td> $vitE_kg_1</td>
                                                      <td>$vitA_ui_1</td>
                                                      <td>$vitD_ui_1</td>
                                                      <td> $vitE_ui_1</td>
                                                      <td>$NDF</td>
                                                      <td>$ADF</td>
                                                      <td>$NFC</td>
                                                  </tr>
                                              ";
                                            } else if ($avgAgeDays >= 360 && $avgAgeDays <= 539) {
                                                echo "
                                                <tr style='text-align:center; background-color:#fff;'>
                                                    <td>$vitA_kg_2</td>
                                                    <td>$vitD_kg_2</td>
                                                    <td>$vitE_kg_2</td>
                                                    <td>$vitA_ui_2</td>
                                                    <td>$vitD_ui_2</td>
                                                    <td>$vitE_ui_2</td>
                                                    <td>$NDF</td>
                                                    <td>$ADF</td>
                                                    <td>$NFC</td>
                                                </tr>
                                            ";
                                            } else if ($avgAgeDays >= 540) {
                                                echo "
                                                <tr style='text-align:center; background-color:#fff;'>
                                                    <td>$vitA_kg_3</td>
                                                    <td>$vitD_kg_3</td>
                                                    <td>$vitE_kg_3</td>
                                                    <td>$vitA_ui_3</td>
                                                    <td>$vitD_ui_3</td>
                                                    <td>$vitE_ui_3</td>
                                                    <td>$NDF</td>
                                                    <td>$ADF</td>
                                                    <td>$NFC</td>
                                                </tr>
                                            ";
                                            } else {
                                                echo "<td colspan='9' style='padding:1.2em; text-align:center; color:gray;'>ยังไม่มีความต้องการวิตามินเสริม</td>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <h5>ข้อมูลค่าแนะนำความต้องการค่าแร่ธาตุของโค</h5>
                                <div class="col-12 ">
                                    <div class="table-responsive">
                                    <table class="table table-bordered" style="font-family:'Kanit'; text-align:center;">
                                        <thead>
                                            <tr style="background-color:#6999c6;">
                                                <th scope="col">Ca</th>
                                                <th scope="col">P</th>
                                                <th scope="col">Mg</th>
                                                <th scope="col">Cl</th>
                                                <th scope="col">K</th>
                                                <th scope="col">Na</th>
                                                <th scope="col">S</th>
                                                <th scope="col">Co</th>
                                                <th scope="col">Cu</th>
                                                <th scope="col">I</th>
                                                <th scope="col">Fe</th>
                                                <th scope="col">Mn</th>
                                                <th scope="col">Se</th>
                                                <th scope="col">Zn</th>
                                            </tr>
                                            <tr style="background-color:#6999c6;">
                                                <th colspan="15">(%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color:white;">
                                                <td>
                                                    <?php echo $ca ?>
                                                </td>
                                                <td>
                                                    <?php echo $p ?>
                                                </td>
                                                <td>
                                                    <?php echo $mg ?>
                                                </td>
                                                <td>
                                                    <?php echo $cl ?>
                                                </td>
                                                <td>
                                                    <?php echo $k ?>
                                                </td>
                                                <td>
                                                    <?php echo $na ?>
                                                </td>
                                                <td>
                                                    <?php echo $s ?>
                                                </td>
                                                <td>
                                                    <?php echo $co ?>
                                                </td>
                                                <td>
                                                    <?php echo $cu ?>
                                                </td>
                                                <td>
                                                    <?php echo $i ?>
                                                </td>
                                                <td>
                                                    <?php echo $fe ?>
                                                </td>
                                                <td>
                                                    <?php echo $mn ?>
                                                </td>
                                                <td>
                                                    <?php echo $se ?>
                                                </td>
                                                <td>
                                                    <?php echo $zn ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
}
?>
                    <div class="d-flex justify-content-center btn-more">
                        <div class="form-group">
                            <button type="reset" onclick="window.location='feed.php'"
                                class="btn btn-cancel">ย้อนกลับ</button>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-add confirm" name="calproduct">บันทึกข้อมูล</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector("#menu a[href='feed.php']").classList.add("active");
    });
</script>

</html>