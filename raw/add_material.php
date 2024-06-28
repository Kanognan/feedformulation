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
            td input{
                width: 5em !important;
            }
            .t1-1{
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
                        <button type="button" class="select-add btn btn-light add"
                            onclick="window.location='add_minerals.php'">เพิ่มปริมาณแร่ธาตุในวัตถุดิบ</button>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <button type="button" class="select-add-active btn btn-light add"
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
            <h1>เพิ่มกรดอะมิโนในวัตถุดิบ</h1>
            <form class="container" action="material_detail.php" method="post" enctype="multipart/form-data"
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
                <div class="" id="5th" role="tabpanel" aria-labelledby="5th-tab" tabindex="0">
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
                                    <th scope="row">ค่า Alanine (Ala)</th>
                                    <td><input type="text" class="form-control" id="data5-1-1" name="dmat_ala_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-1-2" name="dmat_ala_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-1-3" name="dmat_ala_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td rowspan="20" class="text-center">mg/100g</td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่า Arginine (Arg)</th>
                                    <td><input type="text" class="form-control" id="data5-2-1" name="dmat_arg_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-2-2" name="dmat_arg_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-2-3" name="dmat_arg_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่า Aspartic acid (Asp)</th>
                                    <td><input type="text" class="form-control" id="data5-3-1" name="dmat_asp_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-3-2" name="dmat_asp_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-3-3" name="dmat_asp_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่า Cystine (Cys)</th>
                                    <td><input type="text" class="form-control" id="data5-4-1" name="dmat_cys_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-4-2" name="dmat_cys_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-4-3" name="dmat_cys_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่า Glutamic acid (Glu)</th>
                                    <td><input type="text" class="form-control" id="data5-5-1" name="dmat_glu_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-5-2" name="dmat_glu_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-5-3" name="dmat_glu_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่า Glycine (Gly)</th>
                                    <td><input type="text" class="form-control" id="data5-6-1" name="dmat_gly_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-6-2" name="dmat_gly_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-6-3" name="dmat_gly_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่า Histidine (His)</th>
                                    <td><input type="text" class="form-control" id="data5-7-1" name="dmat_his_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-7-2" name="dmat_his_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-7-3" name="dmat_his_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่า Hydroxylysine (Hyl)</th>
                                    <td><input type="text" class="form-control" id="data5-8-1" name="dmat_hyl_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-8-2" name="dmat_hyl_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-8-3" name="dmat_hyl_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่า Hydroxyproline (Hyp)</th>
                                    <td><input type="text" class="form-control" id="data5-9-1" name="dmat_hyp_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-9-2" name="dmat_hyp_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-9-3" name="dmat_hyp_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่า Isoleucine (Ile)</th>
                                    <td><input type="text" class="form-control" id="data5-10-1" name="dmat_ile_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data5-10-2" name="dmat_ile_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-10-3" name="dmat_ile_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่า Leucine (Leu)</th>
                                    <td><input type="text" class="form-control" id="data5-11-1" name="dmat_leu_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data5-11-2" name="dmat_leu_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-11-3" name="dmat_leu_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่า Lysine (Lys)</th>
                                    <td><input type="text" class="form-control" id="data5-12-1" name="dmat_lys_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data5-12-2" name="dmat_lys_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-12-3" name="dmat_lys_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่า Methionine (Met)</th>
                                    <td><input type="text" class="form-control" id="data5-13-1" name="dmat_met_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data5-13-2" name="dmat_met_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-13-3" name="dmat_met_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่า Phenylalanine (Phe)</th>
                                    <td><input type="text" class="form-control" id="data5-14-1" name="dmat_phe_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data5-14-2" name="dmat_phe_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-14-3" name="dmat_phe_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่า Proline (Pro)</th>
                                    <td><input type="text" class="form-control" id="data5-15-1" name="dmat_pro_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data5-15-2" name="dmat_pro_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-15-3" name="dmat_pro_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่า Serine (Ser)</th>
                                    <td><input type="text" class="form-control" id="data5-16-1" name="dmat_ser_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data5-16-2" name="dmat_ser_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-16-3" name="dmat_ser_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่า Threnine (Thr)</th>
                                    <td><input type="text" class="form-control" id="data5-17-1" name="dmat_thr_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data5-17-2" name="dmat_thr_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-17-3" name="dmat_thr_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่า Tryptophan (Trp)</th>
                                    <td><input type="text" class="form-control" id="data5-18-1" name="dmat_trp_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data5-18-2" name="dmat_trp_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-18-3" name="dmat_trp_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่า Tyrosine (Tyr)</th>
                                    <td><input type="text" class="form-control" id="data5-19-1" name="dmat_tyr_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data5-19-2" name="dmat_tyr_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-19-3" name="dmat_tyr_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่า Valine (Val)</th>
                                    <td><input type="text" class="form-control" id="data5-20-1" name="dmat_val_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data5-20-2" name="dmat_val_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data5-20-3" name="dmat_val_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center btn-more">
                        <div class="form-group">
                            <button type="reset" class="btn btn-cancel">ล้างข้างมูล</button>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-add confirm" name="addRaw3">ยืนยัน</button>
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