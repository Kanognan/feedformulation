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
                        <button type="button" class="select-add-active btn btn-light add"
                            onclick="window.location='add_nutrition.php'">เพิ่มคุณค่าทางโภชนะของวัตถุดิบ</button>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <button type="button" class="select-add btn btn-light add"
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
            <h1>เพิ่มคุณค่าทางโภชนะของวัตถุดิบ</h1>
            <form class="container" action="nutrition_detail.php" method="post" enctype="multipart/form-data"
                id="nutrition_detail">
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
                <div class="table" id="2nd" role="tabpanel" aria-labelledby="2nd-tab" tabindex="0">
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
                                    <th scope="row">ค่าวัตถุแห้ง (DM)</th>
                                    <td><input type="text" class="form-control is-invalid" id="data2-1-1"
                                            name="dnut_dm_avg" required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control is-invalid" id="data2-1-2"
                                            name="dnut_dm_sd" required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control is-invalid" id="data2-1-3"
                                            name="dnut_dm_n" required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td></td>

                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <th scope="row">ค่าโปรตีนหยาบ (CP)</th>
                                    <td><input type="text" class="form-control" id="data2-2-1" name="dnut_cp_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-2-2" name="dnut_cp_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-2-3" name="dnut_cp_n" required
                                            pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td rowspan="8" class="text-center">% on DM</td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าไขมัน (EE)</th>
                                    <td><input type="text" class="form-control" id="data2-3-1" name="dnut_ee_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-3-2" name="dnut_ee_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-3-3" name="dnut_ee_n" required
                                            pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าเยื่อใยหยาบ (CF)</th>
                                    <td><input type="text" class="form-control" id="data2-4-1" name="dnut_cf_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-4-2" name="dnut_cf_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-4-3" name="dnut_cf_n" required
                                            pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าเถ้า (Ash)</th>
                                    <td><input type="text" class="form-control" id="data2-5-1" name="dnut_ash_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-5-2" name="dnut_ash_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-5-3" name="dnut_ash_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าแป้งและน้ำตาล (NFE)</th>
                                    <td><input type="text" class="form-control" id="data2-6-1" name="dnut_nfe_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-6-2" name="dnut_nfe_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-6-3" name="dnut_nfe_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าเยื่อใยที่ไม่สามารถละลายได้ในสารฟอกที่เป็นกลาง
                                        (NDF)</th>
                                    <td><input type="text" class="form-control" id="data2-7-1" name="dnut_ndf_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-7-2" name="dnut_ndf_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-7-3" name="dnut_ndf_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าเยื่อใยที่ไม่สามารถละลายได้ในสารฟอกที่เป็นกรด
                                        (ADF)</th>
                                    <td><input type="text" class="form-control" id="data2-8-1" name="dnut_adf_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-8-2" name="dnut_adf_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-8-3" name="dnut_adf_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าลิกนิน (ADL)</th>
                                    <td><input type="text" class="form-control" id="data2-9-1" name="dnut_adl_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-9-2" name="dnut_adl_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-9-3" name="dnut_adl_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <th scope="row">
                                        ค่าโปรตีนในเยื่อใยที่ไม่สามารถละลายได้ในสารฟอกที่เป็นกลาง
                                        (NDICP)</th>
                                    <td><input type="text" class="form-control" id="data2-10-1" name="dnut_ndicp_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data2-10-2" name="dnut_ndicp_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data2-10-3" name="dnut_ndicp_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        ค่าโปรตีนในเยื่อใยที่ไม่สามารถละลายได้ในสารฟอกที่เป็นกรด (ADICP)
                                    </th>
                                    <td><input type="text" class="form-control" id="data2-11-1" name="dnut_adicp_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data2-11-2" name="dnut_adicp_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data2-11-3" name="dnut_adicp_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <th scope="row">ค่าการย่อยได้ของผนังเซลล์ (NDFD)</th>
                                    <td><input type="text" class="form-control" id="data2-12-1" name="dnut_ndfd_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data2-12-2" name="dnut_ndfd_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data2-12-3" name="dnut_ndfd_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td class="text-center">%of NDF</td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <th scope="row">ค่าโปรตีนที่ไม่ย่อยสลายได้ในกระเพาะหมัก (RUP)</th>
                                    <td><input type="text" class="form-control" id="data2-13-1" name="dnut_rup_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data2-13-2" name="dnut_rup_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-13-3" name="dnut_rup_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td class="text-center">%of protein</td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <th scope="row">ค่าการย่อยได้ของวัตถุแห้ง (DMD)</th>
                                    <td><input type="text" class="form-control" id="data2-14-1" name="dnut_dmd_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data2-14-2" name="dnut_dmd_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-14-3" name="dnut_dmd_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าการย่อยได้ของอันทรียวัตถุ (OMD)</th>
                                    <td><input type="text" class="form-control" id="data2-15-1" name="dnut_omd_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data2-15-2" name="dnut_omd_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-15-3" name="dnut_omd_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าโภชนะที่สามารถย่อยได้รวมมทั้งหมด (TDN)</th>
                                    <td><input type="text" class="form-control" id="data2-16-1" name="dnut_tdn_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data2-16-2" name="dnut_tdn_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-16-3" name="dnut_tdn_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td></td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <th scope="row">ค่าพลังงานที่ย่อยได้ (DE)</th>
                                    <td><input type="text" class="form-control" id="data2-17-1" name="dnut_de_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-17-2" name="dnut_de_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-17-3" name="dnut_de_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td rowspan="3" class="text-center">Mcal/kgDM</td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าพลังงานที่สามารถใช้ปนะโยชน์ได้ (ME)</th>
                                    <td><input type="text" class="form-control" id="data2-18-1" name="dnut_me_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-18-2" name="dnut_me_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-18-3" name="dnut_me_n"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าพลังงานสุทธิเพื่อการให้ผลผลิตน้ำนม (NEL)</th>
                                    <td><input type="text" class="form-control" id="data2-19-1" name="dnut_nel_avg"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)">
                                    </td>
                                    <td><input type="text" class="form-control" id="data2-19-2" name="dnut_nel_sd"
                                            required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td><input type="text" class="form-control" id="data2-19-3" name="dnut_nel_n"
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
                            <button type="submit" class="btn btn-add confirm" name="addRaw">บันทึก</button>
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

                    // document.getElementById("data1-3").value = rawEngName;
                    // document.getElementById("type_id").value = typeId;
                    // document.getElementById("feed_class").value = feedClass;
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