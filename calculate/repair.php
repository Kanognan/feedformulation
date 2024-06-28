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
$acc_id = $_SESSION['acc_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php //include "../header.php";                                                                        ?>
    <link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.css">
    <title>ปรับปรุงคุณภาพอาหาร</title>
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
            padding-left: 16em !important;
            width: 100%;
        }

        .t1-1 {
            background-color: #c6d9eb;
            padding: 2em;
            border-radius: 15px;
            /* margin: 1.8em; */
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
            height: cover;
        }

        .button-select {
            width: 100%;
            border-radius: 20px;
        }


        table {
            width: 100%;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
        }

        thead tr th {
            background: #A1CAE2 !important;
            padding: 1em !important;
        }

        .per-use-new,
        .price-new {
            background-color: #d5ffd5 !important;
        }

        .hidden {
            display: none !important;
        }

        .nameGroup {
            background-color: #A1CAE2 !important;
            padding: 1em;
            margin-bottom: 2em;
            border-radius: 10px;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
            font-weight: bold;
        }

        .button-select {
            background-color: #77DC67 !important;
            border: none !important;
        }

        .button-select:hover {
            background-color: #6999C6 !important;
        }

        .btn-cal {
            background-color: #4F80C0 !important;
            color: white;
            border-radius: 20px !important;
            margin-top: 3em;
            border: none !important;
        }

        .btn-cal:hover {
            background-color: #75a4e2 !important;
        }

        @media (max-width: 576px) {
            .content {
                padding-left: 4em !important;
                padding-right: 1em !important;
            }
        }

        @media (max-width: 860px) {
            .g-2 {
                width: 95% !important;
            }

            table input {
                width: 6em !important;
            }
            .t1-1{
                padding: 1em;
            }
            .saveButton{
                width: 70% !important;
            }
        }
    </style>

<body>
    <div class="flex">
        <div class="g-1">
            <?php include ('sidebar.php') ?>
        </div>
        <div class="g-2">
            <div class="content">
                <h2 class="text-center mb-5 mt-1">ปรับปรุงสูตรอาหาร</h2>
                <form action="get_repair_data.php" method="post">
                    <div class="t1-1">
                        <div class="row">
                            <label for="breeder" class="form-label">รายการสูตรอาหาร</label>
                            <div class="col-12 col-sm-10 mt-2">
                                <select class="form-select" id="group_calculate" name="group_calculate">
                                    <option selected disabled>เลือกรายการสูตรอาหารที่ต้องการปรับปรุง</option>
                                    <?php
                                    $sql = "SELECT * FROM group_calculate WHERE acc_id = $acc_id AND deleteAt IS NULL ORDER BY createAt DESC";
                                    $result = $conn->query($sql);
                                    while ($raw = $result->fetch_assoc()):
                                        ;
                                        ?>
                                        <option value="<?php echo $raw["group_cal_id"]; ?>">
                                            <?php echo $raw["name_group"]; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-12 col-sm-2 mt-2">
                                <button class="btn btn-primary button-select" type="button">เลือก</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="show mt-5 hidden was-validated">
                    <form action="repair_cal.php" id="repair_cal" method="post">
                        <div class="pt-2 pb-4 nameGroup">
                            <label for="name_group" class="pb-2">กรอกชื่อการปรับปรุงสูตรอาหาร</label>
                            <input type="text" name="name_group" id="name_group" class="form-control"
                                placeholder="กรอกชื่อการปรับปรุงสูตรอาหาร" required
                                pattern="[ก-๙a-zA-Z]+([ก-๙a-zA-Z0-9\s,\-\.\(\)]*)">
                        </div>
                        <div class="table-responsive">
                            <table class="table text-center" id="data-table">
                                <thead>
                                    <tr>
                                        <th scope="col">รายการวัตถุดิบ</th>
                                        <th scope="col">จำนวนที่ใช้ (%)</th>
                                        <th scope="col">จำนวนที่ใช้ต่อ Intake ใหม่</th>
                                        <th scope="col">จำนวนที่ใช้ต่อ Intake เดิม</th>
                                        <th scope="col">ราคาต่อหน่วย (บาท/กก.)</th>
                                        <th scope="col">ราคารวมทั้งหมด เดิม</th>
                                        <th scope="col">ราคารวมทั้งหมด ใหม่</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr class="text-center table-secondary">
                                        <th scope="row" colspan="" class="">รวม</th>
                                        <th scope="row" colspan="" class="" id="percent">100%</th>
                                        <th scope="row" colspan="" class="" id="new-intake">Intake</th>
                                        <th scope="row" colspan="" class="" id="old-intake">กก.</th>
                                        <th scope="row" colspan="" class="">#</th>
                                        <th class="text-center" id="result">0</th>
                                        <th class="text-center" id="result-new">0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table class="table text-center mt-5" id="data-nutrition">
                                <thead>
                                    <tr>
                                        <th scope="col">รายการวัตถุดิบ</th>
                                        <th scope="col">TDN</th>
                                        <th scope="col">DE</th>
                                        <th scope="col">ME</th>
                                        <th scope="col">NEL</th>
                                        <th scope="col">ADF</th>
                                        <th scope="col">NDF</th>
                                        <th scope="col">EE</th>
                                        <th scope="col">CP</th>
                                        <th scope="col">RUP</th>
                                        <th scope="col">Ca</th>
                                        <th scope="col">P</th>
                                        <th scope="col">VitA</th>
                                        <th scope="col">VitD</th>
                                        <th scope="col">VitE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <!-- <tfoot>
                                <tr class="text-center table-secondary">
                                    <th scope="row" colspan="" class="">รวม</th>
                                    <th scope="row" colspan="" class="sumTdn">0</th>
                                    <th scope="row" colspan="" class="sumDe">0</th>
                                    <th scope="row" colspan="" class="sumMe">0</th>
                                    <th scope="row" colspan="" class="sumNel">0</th>
                                    <th scope="row" colspan="" class="sumAdf">0</th>
                                    <th scope="row" colspan="" class="sumNdf">0</th>
                                    <th scope="row" colspan="" class="sumEe">0</th>
                                    <th scope="row" colspan="" class="sumCp">0</th>
                                    <th scope="row" colspan="" class="sumRup">0</th>
                                    <th scope="row" colspan="" class="sumCa">0</th>
                                    <th scope="row" colspan="" class="sumP">0</th>
                                    <th scope="row" colspan="" class="sumVitA">0</th>
                                    <th scope="row" colspan="" class="sumVitD">0</th>
                                    <th scope="row" colspan="" class="sumVitE">0</th>
                                </tr>
                            </tfoot> -->
                            </table>
                        </div>
                        <button
                            class="saveButton btn btn-primary d-grid gap-2 col-2 mx-auto btn-cost btn-hidden btn-cal">บันทึก</button>
                    </form>
                </div>
                <!-- <div class="showdata"></div> -->
            </div>
        </div>
    </div>
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
    ?>
    <?php
    if (isset ($_SESSION['resultName'])) {
        $resultName = $_SESSION['resultName'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'มีชื่อรายการสูตรอาหารนี้แล้ว',
                        text: '" . $resultName . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
        unset($_SESSION['resultName']);
    }
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector("#menu a[href='repair.php']").classList.add("active");
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tableBody = document.querySelector('#data-table tbody');
            var dataNutrition = document.querySelector('#data-nutrition tbody');
            document.querySelector('.button-select').addEventListener('click', function () {
                document.querySelector('.show').classList.remove('hidden');
            });

            function showNoDataMessage() {
                tableBody.innerHTML = '<tr><td colspan="5">ยังไม่มีข้อมูล</td></tr>';
                dataNutrition.innerHTML = '<tr><td colspan="15">ยังไม่มีข้อมูล</td></tr>';
            }

            function updateTable(data) {
                var newRowHTML = '';
                var newRawNutrition = '';
                var totalPerUseTimesDemIntake = 0;
                var totalOldPrice = 0;
                if (data.cal_raw) {
                    data.cal_raw.forEach(function (raw) {
                        newRowHTML += '<tr>' +
                            '<td>' + raw.rawmaterial.raw_thainame + '</td>' +
                            '<td><input required type="number" step="0.001" min="0" max="999" class="form-control per-use" value="' + raw.per_use + '" name="per_use[' + raw.raw_id + ']"></td>' +
                            '<td><input type="text" class="form-control per-use-new" readonly name="per-use-new[' + raw.raw_id + ']"></td>' +
                            '<td><input type="text" class="form-control" value="' + (raw.intake_use ? raw.intake_use : '') + '" disabled name="intake_use[' + raw.raw_id + ']"></td>' +
                            '<td><input type="text" class="form-control price" value="' + (raw.price ? raw.price : '') + '" disabled name="price[' + raw.raw_id + ']"></td>' +
                            '<td><input type="text" class="form-control" value="' + (raw.intake_lc_result ? raw.intake_lc_result : '') + '" disabled name="intake_lc_result[' + raw.raw_id + ']"></td>' +
                            '<td><input type="text" class="form-control price-new" readonly name="price-new[' + raw.raw_id + ']"></td>' +
                            '</tr>';

                        newRawNutrition += '<tr>' +
                            '<td>' + raw.rawmaterial.raw_thainame + '</td>' +
                            '<td class="showTDN" raw_id="' + raw.raw_id + '">' + ((raw.rawmaterial.data.TDN * raw.per_use) / 100).toFixed(2) + '</td>' +
                            '<td class="showDE" raw_id="' + raw.raw_id + '">' + ((raw.rawmaterial.data.DE * raw.per_use) / 100).toFixed(2) + '</td>' +
                            '<td class="showME" raw_id="' + raw.raw_id + '">' + ((raw.rawmaterial.data.ME * raw.per_use) / 100).toFixed(2) + '</td>' +
                            '<td class="showNEL" raw_id="' + raw.raw_id + '">' + ((raw.rawmaterial.data.NEL * raw.per_use) / 100).toFixed(2) + '</td>' +
                            '<td class="showADF" raw_id="' + raw.raw_id + '">' + ((raw.rawmaterial.data.ADF * raw.per_use) / 100).toFixed(2) + '</td>' +
                            '<td class="showNDF" raw_id="' + raw.raw_id + '">' + ((raw.rawmaterial.data.NDF * raw.per_use) / 100).toFixed(2) + '</td>' +
                            '<td class="showEE" raw_id="' + raw.raw_id + '">' + ((raw.rawmaterial.data.EE * raw.per_use) / 100).toFixed(2) + '</td>' +
                            '<td class="showCP" raw_id="' + raw.raw_id + '">' + ((raw.rawmaterial.data.CP * raw.per_use) / 100).toFixed(2) + '</td>' +
                            '<td class="showRUP" raw_id="' + raw.raw_id + '">' + ((raw.rawmaterial.data.RUP * raw.per_use) / 100).toFixed(2) + '</td>' +
                            '<td class="showCa" raw_id="' + raw.raw_id + '">' + ((raw.rawmaterial.data.Ca * raw.per_use) / 100).toFixed(2) + '</td>' +
                            '<td class="showP" raw_id="' + raw.raw_id + '">' + ((raw.rawmaterial.data.P * raw.per_use) / 100).toFixed(2) + '</td>' +
                            '<td>' + '-' + '</td>' +
                            '<td>' + '-' + '</td>' +
                            '<td>' + '-' + '</td>' +
                            '</tr>';

                        totalOldPrice += parseFloat(raw.intake_lc_result ? raw.intake_lc_result : 0);
                    });
                }
                if (data.cal_ms) {
                    data.cal_ms.forEach(function (ms) {
                        newRowHTML += '<tr>' +
                            '<td>' + ms.rawmaterial.ms_thainame + '</td>' +
                            '<td><input required type="number" step="0.001" min="0" max="999"  class="form-control per-use" value="' + ms.per_use + '" name="per_use[' + ms.ms_id + ']"></td>' +
                            '<td><input type="text" class="form-control per-use-new" readonly name="per-use-new[' + ms.ms_id + ']"></td>' +
                            '<td><input type="text" class="form-control" value="' + (ms.intake_use ? ms.intake_use : '') + '" disabled name="intake_use[' + ms.ms_id + ']"></td>' +
                            '<td><input type="text" class="form-control price" value="' + (ms.price ? ms.price : '') + '" disabled name="price[' + ms.ms_id + ']"></td>' +
                            '<td><input type="text" class="form-control" value="' + (ms.intake_lc_result ? ms.intake_lc_result : '') + '" disabled name="intake_lc_result[' + ms.ms_id + ']"></td>' +
                            '<td><input type="text" class="form-control price-new" readonly name="price-new[' + ms.ms_id + ']"></td>' +
                            '</tr>';

                        newRawNutrition += '<tr>' +
                            '<td>' + ms.rawmaterial.ms_thainame + '</td>' +
                            '<td>' + '-' + '</td>' +
                            '<td>' + '-' + '</td>' +
                            '<td>' + '-' + '</td>' +
                            '<td>' + '-' + '</td>' +
                            '<td>' + '-' + '</td>' +
                            '<td>' + '-' + '</td>' +
                            '<td>' + '-' + '</td>' +
                            '<td>' + '-' + '</td>' +
                            '<td>' + '-' + '</td>' +
                            '<td class="showCa" ms_id="' + ms.ms_id + '">' + ((ms.rawmaterial.data.Ca * ms.per_use) / 100).toFixed(2) + '</td>' +
                            '<td class="showP" ms_id="' + ms.ms_id + '">' + ((ms.rawmaterial.data.P * ms.per_use) / 100).toFixed(2) + '</td>' +
                            '<td class="showVitA" ms_id="' + ms.ms_id + '">' + ((ms.rawmaterial.data.VitA * ms.per_use) / 100).toFixed(2) + '</td>' +
                            '<td class="showVitD" ms_id="' + ms.ms_id + '">' + ((ms.rawmaterial.data.VitD * ms.per_use) / 100).toFixed(2) + '</td>' +
                            '<td class="showVitE" ms_id="' + ms.ms_id + '">' + ((ms.rawmaterial.data.VitE * ms.per_use) / 100).toFixed(2) + '</td>' +
                            '</tr>';

                        totalOldPrice += parseFloat(ms.intake_lc_result ? ms.intake_lc_result : 0);
                    });
                }
                document.getElementById('result').textContent = totalOldPrice.toFixed(2) + ' บาท';
                var demIntakeValue = parseFloat(data.dem_intake);
                console.log(demIntakeValue);
                document.getElementById('old-intake').textContent = 'Intake ' + demIntakeValue.toFixed(2) + ' กก.';

                tableBody.innerHTML = newRowHTML;
                dataNutrition.innerHTML = newRawNutrition;

                tableBody.querySelectorAll('.per-use').forEach(function (input) {
                    input.addEventListener('input', function () {
                        var perUseValue = parseFloat(input.value);
                        if (!isNaN(perUseValue)) {
                            totalPerUseTimesDemIntake = (perUseValue / 100) * demIntakeValue;
                            var perUseNewInput = input.parentElement.nextElementSibling.querySelector('.per-use-new');
                            if (perUseNewInput) {
                                perUseNewInput.value = totalPerUseTimesDemIntake.toFixed(2);
                            }

                            totalNewIntake = 0;
                            tableBody.querySelectorAll('.per-use-new').forEach(function (perUseNewInput) {
                                var perUseNewValue = parseFloat(perUseNewInput.value);
                                if (!isNaN(perUseNewValue)) {
                                    totalNewIntake += perUseNewValue;
                                }
                            });

                            // -------------------------------
                            let sumTdn = 0;
                            let sumDe = 0;
                            let sumMe = 0;
                            let sumNel = 0;
                            let sumAdf = 0;
                            let sumNdf = 0;
                            let sumEe = 0;
                            let sumCp = 0;
                            let sumRup = 0;
                            let sumCa = 0;
                            let sumP = 0;
                            let sumVitA = 0;
                            let sumVitD = 0;
                            let sumVitE = 0;
                            if (data.cal_raw) {
                                data.cal_raw.forEach(function (raw) {
                                    var rawId = raw.raw_id; // เก็บรหัส raw_id
                                    document.querySelectorAll('.per-use').forEach(function (input) {
                                        input.addEventListener('input', function () {
                                            var perUseValue = parseFloat(input.value);
                                            if (!isNaN(perUseValue)) {
                                                // ตรวจสอบว่า input นี้อยู่ในแถวของ raw_id ที่ตรงกับ raw_id ของ showTDN นั้นๆ
                                                if (input.name === 'per_use[' + rawId + ']') {
                                                    var tdnValue = raw.rawmaterial.data.TDN;
                                                    var deValue = raw.rawmaterial.data.DE;
                                                    var meValue = raw.rawmaterial.data.ME;
                                                    var nelValue = raw.rawmaterial.data.NEL;
                                                    var adfValue = raw.rawmaterial.data.ADF;
                                                    var ndfValue = raw.rawmaterial.data.NDF;
                                                    var eeValue = raw.rawmaterial.data.EE;
                                                    var cpValue = raw.rawmaterial.data.CP;
                                                    var rupValue = raw.rawmaterial.data.RUP;
                                                    var caValue = raw.rawmaterial.data.Ca;
                                                    var pValue = raw.rawmaterial.data.P;

                                                    var newTdnValue = (perUseValue * tdnValue) / 100;
                                                    var newDeValue = (perUseValue * deValue) / 100;
                                                    var newMeValue = (perUseValue * meValue) / 100;
                                                    var newNelValue = (perUseValue * nelValue) / 100;
                                                    var newAdfValue = (perUseValue * adfValue) / 100;
                                                    var newNdfValue = (perUseValue * ndfValue) / 100;
                                                    var newEeValue = (perUseValue * eeValue) / 100;
                                                    var newCpValue = (perUseValue * cpValue) / 100;
                                                    var newRupValue = (perUseValue * rupValue) / 100;
                                                    var newCaValue = (perUseValue * caValue) / 100;
                                                    var newPValue = (perUseValue * pValue) / 100;

                                                    var showTdnElement = document.querySelector('.showTDN[raw_id="' + rawId + '"]');
                                                    var showDeElement = document.querySelector('.showDE[raw_id="' + rawId + '"]');
                                                    var showMeElement = document.querySelector('.showME[raw_id="' + rawId + '"]');
                                                    var showNelElement = document.querySelector('.showNEL[raw_id="' + rawId + '"]');
                                                    var showAdfElement = document.querySelector('.showADF[raw_id="' + rawId + '"]');
                                                    var showNdfElement = document.querySelector('.showNDF[raw_id="' + rawId + '"]');
                                                    var showEeElement = document.querySelector('.showEE[raw_id="' + rawId + '"]');
                                                    var showCpElement = document.querySelector('.showCP[raw_id="' + rawId + '"]');
                                                    var showRupElement = document.querySelector('.showRUP[raw_id="' + rawId + '"]');
                                                    var showCaElement = document.querySelector('.showCa[raw_id="' + rawId + '"]');
                                                    var showPElement = document.querySelector('.showP[raw_id="' + rawId + '"]');

                                                    showTdnElement.textContent = newTdnValue.toFixed(2);
                                                    showDeElement.textContent = newDeValue.toFixed(2);
                                                    showMeElement.textContent = newMeValue.toFixed(2);
                                                    showNelElement.textContent = newNelValue.toFixed(2);
                                                    showAdfElement.textContent = newAdfValue.toFixed(2);
                                                    showNdfElement.textContent = newNdfValue.toFixed(2);
                                                    showEeElement.textContent = newEeValue.toFixed(2);
                                                    showCpElement.textContent = newCpValue.toFixed(2);
                                                    showRupElement.textContent = newRupValue.toFixed(2);
                                                    showCaElement.textContent = newCaValue.toFixed(2);
                                                    showPElement.textContent = newPValue.toFixed(2);

                                                }
                                            }
                                        });
                                    });
                                });
                            }
                            if (data.cal_ms) {
                                data.cal_ms.forEach(function (ms) {
                                    var msId = ms.ms_id; // เก็บรหัส ms_id
                                    document.querySelectorAll('.per-use').forEach(function (input) {
                                        input.addEventListener('input', function () {
                                            var perUseValue = parseFloat(input.value);
                                            if (!isNaN(perUseValue)) {
                                                if (input.name === 'per_use[' + msId + ']') {
                                                    var caValue = ms.rawmaterial.data.Ca;
                                                    var pValue = ms.rawmaterial.data.P;
                                                    var vitAValue = ms.rawmaterial.data.VitA;
                                                    var vitDValue = ms.rawmaterial.data.VitD;
                                                    var vitEValue = ms.rawmaterial.data.VitE;

                                                    var newCaValue = (perUseValue * caValue) / 100;
                                                    var newPValue = (perUseValue * pValue) / 100;
                                                    var newVitAValue = (perUseValue * vitAValue) / 100;
                                                    var newVitDValue = (perUseValue * vitDValue) / 100;
                                                    var newVitEValue = (perUseValue * vitEValue) / 100;

                                                    var showCaElement = document.querySelector('.showCa[ms_id="' + msId + '"]');
                                                    var showPElement = document.querySelector('.showP[ms_id="' + msId + '"]');
                                                    var showVitAElement = document.querySelector('.showVitA[ms_id="' + msId + '"]');
                                                    var showVitDElement = document.querySelector('.showVitD[ms_id="' + msId + '"]');
                                                    var showVitEElement = document.querySelector('.showVitE[ms_id="' + msId + '"]');

                                                    showCaElement.textContent = newCaValue.toFixed(2);
                                                    showPElement.textContent = newPValue.toFixed(2);
                                                    showVitAElement.textContent = newVitAValue.toLocaleString('en-US', { minimumFractionDigits: 2 });
                                                    showVitDElement.textContent = newVitDValue.toLocaleString('en-US', { minimumFractionDigits: 2 });
                                                    showVitEElement.textContent = newVitEValue.toLocaleString('en-US', { minimumFractionDigits: 2 });

                                                }
                                            }
                                        });
                                    });
                                });
                            }






                            document.getElementById('new-intake').textContent = 'Intake ' + totalNewIntake.toFixed(2) + ' กก.';

                            var priceInput = input.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.querySelector('.price');
                            var price = parseFloat(priceInput.value);
                            var totalPrice = totalPerUseTimesDemIntake * price;

                            var priceNewInput = input.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.querySelector('.price-new');
                            if (priceNewInput) {
                                priceNewInput.value = totalPrice.toFixed(2);
                            }

                            totalNewPrice = 0; // เริ่มต้นค่าใหม่ทุกครั้งที่มีการป้อนข้อมูลใหม่
                            tableBody.querySelectorAll('.price-new').forEach(function (priceNewInput) {
                                var priceNew = parseFloat(priceNewInput.value);
                                if (!isNaN(priceNew)) {
                                    totalNewPrice += priceNew;
                                }
                            });
                            document.getElementById('result-new').textContent = totalNewPrice.toFixed(2) + ' บาท';

                        }

                        var totalPercentage = calculateTotalPercentage();
                        if (totalPercentage > 100) {
                            alert('ค่าจำนวนที่ใช้ไม่สามารถเกิน 100% ได้');
                            input.value = '';
                        } else {
                            // แสดงผลรวมใหม่ทันที
                            document.getElementById('percent').textContent = totalPercentage.toFixed(2) + '%';
                        }
                    });
                });
            }

            document.querySelector('.saveButton').addEventListener('click', function () {
                var totalPercentage = calculateTotalPercentage();
                var nameGroupValue = document.getElementById('name_group').value.trim();

                if (totalPercentage < 99 || totalPercentage > 100.05) {
                    alert('เปอร์เซ็นต์รวมของการใช้วัตถุดิบต้องอยู่ระหว่าง 99% ถึง 100%');
                    document.getElementById('name_group').value = '';
                } else {
                    if (nameGroupValue === '') {
                        alert('กรุณากรอกชื่อการปรับปรุงสูตรอาหาร');
                    } else {
                        document.getElementById('repair_cal').submit();
                    }
                }
            });



            // เมื่อกดเลือกรายการ
            var selectButton = document.querySelector('.button-select');
            selectButton.addEventListener('click', function () {
                var selectedGroupId = document.getElementById('group_calculate').value;
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            var responseData = xhr.responseText;
                            var data = JSON.parse(responseData);
                            if (data) {
                                updateTable(data);
                                console.log(data)
                                var jsonDataElement = document.querySelector('.showdata');
                                if (jsonDataElement) {
                                    var htmlContent = '<pre>' + JSON.stringify(data, null, 4) + '</pre>';
                                    jsonDataElement.innerHTML = htmlContent;
                                }
                            } else {
                                showNoDataMessage();
                            }
                        } else {
                            console.error('เกิดข้อผิดพลาดในการโหลดข้อมูล: ' + xhr.status);
                        }
                    }
                };

                xhr.open('POST', 'repair_data.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('group_calculate=' + encodeURIComponent(selectedGroupId));
            });

            // ฟังก์ชันเพื่อคำนวณผลรวมของ per_use และตรวจสอบว่าผลรวมเกิน 100% หรือไม่
            function calculateTotalPercentage() {
                var totalPercentage = 0;
                tableBody.querySelectorAll('.per-use').forEach(function (input) {
                    var perUseValue = parseFloat(input.value);
                    if (!isNaN(perUseValue)) {
                        totalPercentage += perUseValue;
                    }
                });
                return totalPercentage;
            }
        });
    </script>
</body>

</html>