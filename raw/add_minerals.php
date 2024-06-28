<?php
session_start();
if (!isset ($_SESSION['user_status']) || ($_SESSION['user_status'] != 'Admin' && $_SESSION['user_status'] != 'Expert')) {
    $resultNoSessionExpert = "สำหรับผู้ดูแลระบบและผู้เชี่ยวชาญเท่านั้น";
    $_SESSION['resultNoSessionExpert'] = $resultNoSessionExpert;
    echo "<script type='text/javascript'>";
    echo "window.location = '../login.php'; ";
    echo "</script>";
    exit();
    // ผู้เชี่ยวชาญ
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>รายการวัตถุดิบ</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="raw_style.css">
	<link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #F5F5F5 !important;
            font-family: 'Kanit', sans-serif;
            padding-top: 8em;
        }

        button.add {
            margin-top: 2em;
            width: 15em !important;
            padding: 0.7em;
            border: none;
            border-radius: 30px;
            background-color: #afc7de;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
        }


        .select-add-active {
            background-color: #7495b4 !important;
            box-shadow: none !important;
            color: white !important;
        }

        .form_add h1 {
            text-align: center;
            padding: 0.4em 1em;
            margin: 1em 0em;
        }

        thead th {
            background-color: #9cc0e2 !important;
            padding: 1.2em !important;
            text-align: center;
        }

        .form_add table {
            background-color: white !important;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
        }

        .btn-more {
            margin: 1em 0em 1em 0em !important;
        }

        th {
            background-color: #f3faff !important;
        }

        @media (max-width: 577px) {
            td input {
                width: 5em !important;
            }

            .t1-1 {
                padding: 1em !important;
            }
        }
    </style>
</head>

<body>
    <?php include "nav-bar.php"; ?>
    <div class="container">
        <div class="menu-add">
            <div class="d-flex justify-content-center">
                <div class="row text-center">
                    <div class="col-12 col-sm-6 col-lg-3">
                        <button type="button" class="select-add btn btn-light add"
                            onclick="window.location='add_nutrition.php'">เพิ่มคุณค่าทางโภชนะของวัตถุดิบ</button>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <button type="button" class="select-add-active btn btn-light add"
                            onclick="window.location='add_minerals.php'">เพิ่มปริมาณแร่ธาตุในวัตถุดิบ</button>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <button type="button" class="select-add btn btn-light add"
                            onclick="window.location='add_material.php'">เพิ่มกรดอะมิโนในวัตถุดิบ</button>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <button type="button" class="select-add btn btn-light add"
                            onclick="window.location='add_source_minerals.php'">เพิ่มค่าแร่ธาตุและวิตามิน</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="form_add">
            <h1>เพิ่มปริมาณแร่ธาตุในวัตถุดิบ</h1>
            <form class="container" action="minerals_detail.php" method="post" enctype="multipart/form-data"
                id="myForm">
                <div class="row t1-1 t22">
                    <?php
                    $sqlRawThai = "SELECT * FROM raw_material WHERE ISNULL(raw_material.deleteAt)";
                    $resultRawThai = $conn->query($sqlRawThai);
                    ?>
                    <div class="col-12 col-sm-6 was-validated">
                        <label for="data1-2" class="form-label">ชื่อสามัญภาษาไทย</label>
                        <input class="form-control" type="text" list="raw_thainame" id="data1-2"
                            placeholder="กรอกชื่อสามัญภาษาไทย" name="raw_thainame" required
                            pattern="[ก-๙]+([ก-๙0-9\s,\.\(\)\-]*)">
                        <datalist id="raw_thainame">
                            <?php while ($rawThai = $resultRawThai->fetch_assoc()): ?>
                                <option value="<?php echo $rawThai["raw_thainame"]; ?>"
                                    data-rawengname="<?php echo $rawThai["raw_engname"]; ?>"
                                    data-typeid="<?php echo $rawThai["type_raw_id"]; ?>"
                                    data-feedclass="<?php echo $rawThai["feed_class"]; ?>">
                                    <?php echo $rawThai["raw_thainame"]; ?>
                                </option>
                            <?php endwhile; ?>
                        </datalist>
                    </div>
                    <div class="col-12 col-sm-6 was-validated">
                        <label for="data1-3" class="form-label">ชื่อสามัญภาษาอังกฤษ</label>
                        <input type="text" class="form-control" id="data1-3" name="raw_engname" required
                            pattern="[a-zA-Z\-]+([a-zA-Z0-9\s,\-\.\(\)]*)" placeholder="กรอกชื่อสามัญภาษาอังกฤษ">
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="cate-raw">
                            <label for="type_raw_id" class="form-label">หมวดหมู่</label>
                            <select name="type_id" id="type_raw_id" class="form-select" required>
                                <option selected disabled>เลือกหมวดหมู่วัตถุดิบ</option>
                                <?php
                                $sql = "SELECT * FROM type_raw_material";
                                $result = $conn->query($sql);

                                while ($raw = $result->fetch_assoc()):
                                    ?>
                                    <option value="<?php echo $raw["type_raw_id"]; ?>">
                                        <?php echo $raw["type_raw_thainame"]; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="data1-1" class="form-label">Feed Class</label>
                        <select class="form-select" aria-label="Feed Class" id="data1-1" name="feed_class" required>
                            <option selected disabled>เลือก Feed Class</option>
                            <option value="1">1 (พืชอาหารสัตว์หมัก สด แห้งและอาหารหยาบแห้ง)</option>
                            <option value="2">2 (วัตถุดิบแหล่งโปรตีน)</option>
                            <option value="3">3 (วัตถุดิบแหล่งพลังงาน)</option>
                        </select>
                    </div>
                </div>
                <div class="" id="4th" role="tabpanel" aria-labelledby="4th-tab" tabindex="0">
                    <div>
                        <p>* หากไม่มีข้อมูลในรายการนั้นให้กรอก ND (No data)</p>
                        <p>* หากไม่สามารถตรวจวัดข้อมูลได้ให้กรอก Nd (No detect)</p>
                    </div>
                    <div class="table-responsive py-4 table">
                        <table class="table table-bordered was-validated">
                            <thead class="thead-primary ">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">AVG</th>
                                    <th scope="col">SD</th>
                                    <th scope="col">N</th>
                                    <th scope="col">หน่วย</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">ค่าแคลเซียม (Ca)</th>
                                    <td><input type="text" class="form-control" id="data4-1-1" name="dminer_per_ca_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data4-1-2" name="dminer_per_ca_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data4-1-3" name="dminer_per_ca_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td rowspan="6" class="text-center">%</td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าฟอสฟอรัส (P)</th>
                                    <td><input type="text" class="form-control" id="data4-2-1" name="dminer_per_p_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data4-2-2" name="dminer_per_p_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data4-2-3" name="dminer_per_p_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าแมกนีเซียม (Mg)</th>
                                    <td><input type="text" class="form-control" id="data4-3-1" name="dminer_per_mg_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data4-3-2" name="dminer_per_mg_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data4-3-3" name="dminer_per_mg_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าโพแทสเซียม (K)</th>
                                    <td><input type="text" class="form-control" id="data4-4-1" name="dminer_per_k_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data4-4-2" name="dminer_per_k_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data4-4-3" name="dminer_per_k_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่ากำมะถัน (S)</th>
                                    <td><input type="text" class="form-control" id="data4-5-1" name="dminer_per_s_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data4-5-2" name="dminer_per_s_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data4-5-3" name="dminer_per_s_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าโซเดียม (Na)</th>
                                    <td><input type="text" class="form-control" id="data4-6-1" name="dminer_per_na_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data4-6-2" name="dminer_per_na_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data4-6-3" name="dminer_per_na_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <th scope="row">ค่าทองแดง (Cu)</th>
                                    <td><input type="text" class="form-control" id="data4-7-1" name="dminer_kg_cu_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data4-7-2" name="dminer_kg_cu_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data4-7-3" name="dminer_kg_cu_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td rowspan="4" class="text-center">mg/kg</td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าเหล็ก (Fe)</th>
                                    <td><input type="text" class="form-control" id="data4-8-1" name="dminer_kg_fe_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data4-8-2" name="dminer_kg_fe_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data4-8-3" name="dminer_kg_fe_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าแมงกานีส (Mn)</th>
                                    <td><input type="text" class="form-control" id="data4-9-1" name="dminer_kg_mn_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data4-9-2" name="dminer_kg_mn_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data4-9-3" name="dminer_kg_mn_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าสังกะสี (Zn)</th>
                                    <td><input type="text" class="form-control" id="data4-10-1" name="dminer_kg_zn_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data4-10-2" name="dminer_kg_zn_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data4-10-3" name="dminer_kg_zn_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center btn-more">
                        <div class="form-group">
                            <button type="reset" class="btn btn-cancel">ล้างข้างมูล</button>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-add confirm" name="addRaw2">ยืนยัน</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
	<?php include ("../footer.php"); ?>
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

    <!-- Scripts -->
    <script>
        $('#selectRaw').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
            allowClear: true,
        });
        $('#selectMineral').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
            allowClear: true,
        });
    </script>
    <script>
        document.getElementById('data1-2').addEventListener('change', function () {
            var selectedThaiName = this.value;
            var rawThainames = document.getElementById('raw_thainame').options;
            var rawEngnameInput = document.getElementById('data1-3');
            var typeDropdown = document.getElementById('type_raw_id');
            var feedClassDropdown = document.getElementById('data1-1');

            var found = false;

            for (var i = 0; i < rawThainames.length; i++) {
                if (rawThainames[i].value === selectedThaiName) {
                    // หากพบชื่อสามัญภาษาไทยที่ถูกเลือก ให้ค้นหาชื่อภาษาอังกฤษที่เกี่ยวข้องและแสดงใน input ชื่อสามัญภาษาอังกฤษ
                    rawEngnameInput.value = rawThainames[i].getAttribute('data-rawengname');
                    // กำหนดค่าหมวดหมู่และ feed class
                    typeDropdown.value = rawThainames[i].getAttribute('data-typeid');
                    feedClassDropdown.value = rawThainames[i].getAttribute('data-feedclass');
                    found = true;
                    break;
                }
            }

            // หากไม่พบชื่อวัตถุดิบที่ตรงกับที่รับมา ให้ล้างค่าของฟอร์ม
            if (!found) {
                rawEngnameInput.value = '';
                typeDropdown.selectedIndex = 0;
                feedClassDropdown.selectedIndex = 0;
            }

            // ตรวจสอบว่าควรจะเปิดหรือปิดค่า disabled ของช่องข้อมูล
            updateDisabledState(found);
        });

        function updateDisabledState(found) {
            // หากพบชื่อวัตถุดิบที่ตรงกับที่รับมา ให้ปิดค่า disabled ของช่องข้อมูล
            // มิฉะนั้นเปิดค่า disabled ของช่องข้อมูล
            document.getElementById('data1-3').disabled = found ? true : false;
            document.getElementById('type_raw_id').disabled = found ? true : false;
            document.getElementById('data1-1').disabled = found ? true : false;
        }
    </script>
</body>

</html>