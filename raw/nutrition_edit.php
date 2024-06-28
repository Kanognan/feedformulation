<?php
session_start();
if (!isset($_SESSION['user_status']) || ($_SESSION['user_status'] != 'Admin' && $_SESSION['user_status'] != 'Expert')) {
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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php //include("../header.php"); ?>
    <title>Document</title>
    <link rel="stylesheet" href="raw_style.css">
    <style>
        h1 {
            text-align: center;
            padding: 0.5em;
            margin: 1em 0em !important;
            background-color: #6999c6;
            border-radius: 10px;
        }

        .btn-back {
            background-color: rgb(255 179 0) !important;
        }
    </style>
</head>

<body>
    <?php include("nav-bar.php") ?>
    <div class="container">
        <?php
        $raw_id = $_GET['id'];

        $sqltab1 = "SELECT 
                raw_material.raw_id, 
                raw_material.raw_thainame,
                raw_material.raw_engname,
                raw_material.feed_class,
                type_raw_material.type_raw_thainame,
                type_raw_material.type_raw_id,
                GROUP_CONCAT(nutrition_detail.nutrition_detail_id) as nutrition_detail_ids
            FROM 
                raw_material
            JOIN 
                type_raw_material ON raw_material.type_raw_id = type_raw_material.type_raw_id
            JOIN 
                nutrition ON raw_material.raw_id = nutrition.raw_id
            JOIN 
                nutrition_detail ON nutrition.nutrition_detail_id = nutrition_detail.nutrition_detail_id
            WHERE
                raw_material.raw_id = '$raw_id'
            GROUP BY 
                raw_material.raw_id, raw_material.raw_thainame, raw_material.raw_engname, raw_material.feed_class, type_raw_material.type_raw_thainame, type_raw_material.type_raw_id";

        $resulttab1 = $conn->query($sqltab1);

        if ($resulttab1 && $resulttab1->num_rows > 0) {
            while ($rowtab1 = $resulttab1->fetch_assoc()) {
                $raw_thainame = $rowtab1["raw_thainame"];
                $raw_engname = $rowtab1["raw_engname"];
                $type_raw_id = $rowtab1["type_raw_id"];
                $type_raw_thainame = $rowtab1["type_raw_thainame"];
                $feed_class = $rowtab1["feed_class"];
                $nutrition_detail_ids = $rowtab1["nutrition_detail_ids"];
                $nutrition_detail_array = explode(",", $nutrition_detail_ids);

                foreach ($nutrition_detail_array as $nutrition_detail_id) {
                    $sql = "SELECT * FROM nutrition_detail WHERE nutrition_detail_id = $nutrition_detail_id";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // ในที่นี้คุณสามารถใช้ $row เพื่อเข้าถึงข้อมูลจากตาราง nutrition_detail
                            if ($row['type_detail_id'] == 1) {
                                $dnut_dm_avg = $row['dnut_dm'];
                                $dnut_cp_avg = $row['dnut_cp'];
                                $dnut_ee_avg = $row['dnut_ee'];
                                $dnut_cf_avg = $row['dnut_cf'];
                                $dnut_ash_avg = $row['dnut_ash'];
                                $dnut_nfe_avg = $row['dnut_nfe'];
                                $dnut_ndf_avg = $row['dnut_ndf'];
                                $dnut_adf_avg = $row['dnut_adf'];
                                $dnut_adl_avg = $row['dnut_adl'];
                                $dnut_ndicp_avg = $row['dnut_ndicp'];
                                $dnut_adicp_avg = $row['dnut_adicp'];
                                $dnut_ndfd_avg = $row['dnut_ndfd'];
                                $dnut_rup_avg = $row['dnut_rup'];
                                $dnut_dmd_avg = $row['dnut_dmd'];
                                $dnut_omd_avg = $row['dnut_omd'];
                                $dnut_tdn_avg = $row['dnut_tdn'];
                                $dnut_de_avg = $row['dnut_de'];
                                $dnut_me_avg = $row['dnut_me'];
                                $dnut_nel_avg = $row['dnut_nel'];
                            }
                            if ($row['type_detail_id'] == 2) {
                                $dnut_dm_sd = $row['dnut_dm'];
                                $dnut_cp_sd = $row['dnut_cp'];
                                $dnut_ee_sd = $row['dnut_ee'];
                                $dnut_cf_sd = $row['dnut_cf'];
                                $dnut_ash_sd = $row['dnut_ash'];
                                $dnut_nfe_sd = $row['dnut_nfe'];
                                $dnut_ndf_sd = $row['dnut_ndf'];
                                $dnut_adf_sd = $row['dnut_adf'];
                                $dnut_adl_sd = $row['dnut_adl'];
                                $dnut_ndicp_sd = $row['dnut_ndicp'];
                                $dnut_adicp_sd = $row['dnut_adicp'];
                                $dnut_ndfd_sd = $row['dnut_ndfd'];
                                $dnut_rup_sd = $row['dnut_rup'];
                                $dnut_dmd_sd = $row['dnut_dmd'];
                                $dnut_omd_sd = $row['dnut_omd'];
                                $dnut_tdn_sd = $row['dnut_tdn'];
                                $dnut_de_sd = $row['dnut_de'];
                                $dnut_me_sd = $row['dnut_me'];
                                $dnut_nel_sd = $row['dnut_nel'];
                            }
                            if ($row['type_detail_id'] == 3) {
                                $dnut_dm_n = $row['dnut_dm'];
                                $dnut_cp_n = $row['dnut_cp'];
                                $dnut_ee_n = $row['dnut_ee'];
                                $dnut_cf_n = $row['dnut_cf'];
                                $dnut_ash_n = $row['dnut_ash'];
                                $dnut_nfe_n = $row['dnut_nfe'];
                                $dnut_ndf_n = $row['dnut_ndf'];
                                $dnut_adf_n = $row['dnut_adf'];
                                $dnut_adl_n = $row['dnut_adl'];
                                $dnut_ndicp_n = $row['dnut_ndicp'];
                                $dnut_adicp_n = $row['dnut_adicp'];
                                $dnut_ndfd_n = $row['dnut_ndfd'];
                                $dnut_rup_n = $row['dnut_rup'];
                                $dnut_dmd_n = $row['dnut_dmd'];
                                $dnut_omd_n = $row['dnut_omd'];
                                $dnut_tdn_n = $row['dnut_tdn'];
                                $dnut_de_n = $row['dnut_de'];
                                $dnut_me_n = $row['dnut_me'];
                                $dnut_nel_n = $row['dnut_nel'];
                            }
                        }
                    }
                }
            }
        } else {
            echo "ไม่พบข้อมูลที่ตรงกับ raw_id: $raw_id";
        }
        ?>

        <h1>
            แก้ไขคุณค่าทางโภชนะของวัตถุดิบ
        </h1>
        <form class="" action="nutrition_edit_db.php?id=<?php echo $raw_id; ?>" method="post"
            enctype="multipart/form-data" id="nutrition_detail">
            <div class="row t1-1 t22">
                <div class="col-6">
                    <div class="cate-raw">
                        <label for="type_raw_id" class="col-form-label">หมวดหมู่ :</label>
                        <select class="form-select" id="type_raw_id" name="type_raw_id">
                            <?php
                            $sql_type = "SELECT 
                                        type_raw_material.*
                                    FROM 
                                        type_raw_material";

                            $result_type = $conn->query($sql_type);

                            while ($row_type = $result_type->fetch_assoc()) {
                                $selected = ($row_type["type_raw_id"] == $type_raw_id) ? "selected" : "";
                                echo "<option value='{$row_type["type_raw_id"]}' $selected>{$row_type["type_raw_thainame"]}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <label for="data1-1" class="form-label">Feed Class</label>
                    <select class="form-select" aria-label="Feed Class" id="data1-1" name="feed_class" required>
                        <option selected disabled>เลือก Feed Class</option>
                        <?php
                        $feed_class_values = [
                            1 => "1 (พืชอาหารสัตว์หมัก สด แห้งและอาหารหยาบแห้ง)",
                            2 => "2 (วัตถุดิบแหล่งโปรตีน)",
                            3 => "3 (วัตถุดิบแหล่งพลังงาน)"
                        ];

                        foreach ($feed_class_values as $key => $value) {
                            $selected = ($key == $feed_class) ? "selected" : "";
                            echo "<option value='$key' $selected>$value</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-6">
                    <label for="data1-2" class="form-label">ชื่อสามัญภาษาไทย</label>
                    <input type="text" class="form-control" id="data1-2" name="raw_thainame"
                        placeholder="กรอกชื่อสามัญภาษาไทย" value="<?php echo $raw_thainame; ?>" required>
                </div>
                <div class="col-6">
                    <label for="data1-3" class="form-label">ชื่อสามัญภาษาอังกฤษ</label>
                    <input type="text" class="form-control" id="data1-3" name="raw_engname"
                        placeholder="กรอกชื่อสามัญภาษาอังกฤษ" value="<?php echo $raw_engname; ?>" required>
                </div>
            </div>
            <div class="" id="2nd" role="tabpanel" aria-labelledby="2nd-tab" tabindex="0">
                <div>
                    <p>* หากไม่มีข้อมูลในรายการนั้นให้กรอก ND (No data)</p>
                    <p>* หากไม่สามารถตรวจวัดข้อมูลได้ให้กรอก Nd (No detect)</p>
                </div>
                <div class="table-responsive py-4 table">
                    <table class="table table-bordered ">
                        <thead class="thead-primary text-center">
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
                                <td><input type="text" class="form-control" id="data2-1-1" name="dnut_dm_avg"
                                        value="<?php echo $dnut_dm_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-1-2" name="dnut_dm_sd"
                                        value="<?php echo $dnut_dm_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-1-3" name="dnut_dm_n"
                                        value="<?php echo $dnut_dm_n; ?>"></td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <th scope="row">ค่าโปรตีนหยาบ (CP)</th>
                                <td><input type="text" class="form-control" id="data2-2-1" name="dnut_cp_avg"
                                        value="<?php echo $dnut_cp_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-2-2" name="dnut_cp_sd"
                                        value="<?php echo $dnut_cp_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-2-3" name="dnut_cp_n"
                                        value="<?php echo $dnut_cp_n; ?>"></td>
                                <td rowspan="8" class="text-center">% on DM</td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าไขมัน (EE)</th>
                                <td><input type="text" class="form-control" id="data2-3-1" name="dnut_ee_avg"
                                        value="<?php echo $dnut_ee_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-3-2" name="dnut_ee_sd"
                                        value="<?php echo $dnut_ee_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-3-3" name="dnut_ee_n"
                                        value="<?php echo $dnut_ee_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าเยื่อใยหยาบ (CF)</th>
                                <td><input type="text" class="form-control" id="data2-4-1" name="dnut_cf_avg"
                                        value="<?php echo $dnut_cf_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-4-2" name="dnut_cf_sd"
                                        value="<?php echo $dnut_cf_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-4-3" name="dnut_cf_n"
                                        value="<?php echo $dnut_cf_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าเถ้า (Ash)</th>
                                <td><input type="text" class="form-control" id="data2-5-1" name="dnut_ash_avg"
                                        value="<?php echo $dnut_ash_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-5-2" name="dnut_ash_sd"
                                        value="<?php echo $dnut_ash_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-5-3" name="dnut_ash_n"
                                        value="<?php echo $dnut_ash_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าแป้งและน้ำตาล (NFE)</th>
                                <td><input type="text" class="form-control" id="data2-6-1" name="dnut_nfe_avg"
                                        value="<?php echo $dnut_nfe_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-6-2" name="dnut_nfe_sd"
                                        value="<?php echo $dnut_nfe_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-6-3" name="dnut_nfe_n"
                                        value="<?php echo $dnut_nfe_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าเยื่อใยที่ไม่สามารถละลายได้ในสารฟอกที่เป็นกลาง
                                    (NDF)</th>
                                <td><input type="text" class="form-control" id="data2-7-1" name="dnut_ndf_avg"
                                        value="<?php echo $dnut_ndf_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-7-2" name="dnut_ndf_sd"
                                        value="<?php echo $dnut_ndf_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-7-3" name="dnut_ndf_n"
                                        value="<?php echo $dnut_ndf_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าเยื่อใยที่ไม่สามารถละลายได้ในสารฟอกที่เป็นกรด
                                    (ADF)</th>
                                <td><input type="text" class="form-control" id="data2-8-1" name="dnut_adf_avg"
                                        value="<?php echo $dnut_adf_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-8-2" name="dnut_adf_sd"
                                        value="<?php echo $dnut_adf_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-8-3" name="dnut_adf_n"
                                        value="<?php echo $dnut_adf_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าลิกนิน (ADL)</th>
                                <td><input type="text" class="form-control" id="data2-9-1" name="dnut_adl_avg"
                                        value="<?php echo $dnut_adl_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-9-2" name="dnut_adl_sd"
                                        value="<?php echo $dnut_adl_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-9-3" name="dnut_adl_n"
                                        value="<?php echo $dnut_adl_n; ?>"></td>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <th scope="row">
                                    ค่าโปรตีนในเยื่อใยที่ไม่สามารถละลายได้ในสารฟอกที่เป็นกลาง
                                    (NDICP)</th>
                                <td><input type="text" class="form-control" id="data2-10-1" name="dnut_ndicp_avg"
                                        value="<?php echo $dnut_ndicp_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-10-2" name="dnut_ndicp_sd"
                                        value="<?php echo $dnut_ndicp_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-10-3" name="dnut_ndicp_n"
                                        value="<?php echo $dnut_ndicp_n; ?>"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">
                                    ค่าโปรตีนในเยื่อใยที่ไม่สามารถละลายได้ในสารฟอกที่เป็นกรด (ADICP)
                                </th>
                                <td><input type="text" class="form-control" id="data2-11-1" name="dnut_adicp_avg"
                                        value="<?php echo $dnut_adicp_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-11-2" name="dnut_adicp_sd"
                                        value="<?php echo $dnut_adicp_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-11-3" name="dnut_adicp_n"
                                        value="<?php echo $dnut_adicp_n; ?>"></td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <th scope="row">ค่าการย่อยได้ของผนังเซลล์ (NDFD)</th>
                                <td><input type="text" class="form-control" id="data2-12-1" name="dnut_ndfd_avg"
                                        value="<?php echo $dnut_ndfd_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-12-2" name="dnut_ndfd_sd"
                                        value="<?php echo $dnut_ndfd_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-12-3" name="dnut_ndfd_n"
                                        value="<?php echo $dnut_ndfd_n; ?>"></td>
                                <td class="text-center">%of NDF</td>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <th scope="row">ค่าโปรตีนที่ไม่ย่อยสลายได้ในกระเพาะหมัก (RUP)</th>
                                <td><input type="text" class="form-control" id="data2-13-1" name="dnut_rup_avg"
                                        value="<?php echo $dnut_rup_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-13-2" name="dnut_rup_sd"
                                        value="<?php echo $dnut_rup_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-13-3" name="dnut_rup_n"
                                        value="<?php echo $dnut_rup_n; ?>"></td>
                                <td class="text-center">%of protein</td>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <th scope="row">ค่าการย่อยได้ของวัตถุแห้ง (DMD)</th>
                                <td><input type="text" class="form-control" id="data2-14-1" name="dnut_dmd_avg"
                                        value="<?php echo $dnut_dmd_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-14-2" name="dnut_dmd_sd"
                                        value="<?php echo $dnut_dmd_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-14-3" name="dnut_dmd_n"
                                        value="<?php echo $dnut_dmd_n; ?>"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าการย่อยได้ของอันทรียวัตถุ (OMD)</th>
                                <td><input type="text" class="form-control" id="data2-15-1" name="dnut_omd_avg"
                                        value="<?php echo $dnut_omd_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-15-2" name="dnut_omd_sd"
                                        value="<?php echo $dnut_omd_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-15-3" name="dnut_omd_n"
                                        value="<?php echo $dnut_omd_n; ?>"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าโภชนะที่สามารถย่อยได้รวมมทั้งหมด (TDN)</th>
                                <td><input type="text" class="form-control" id="data2-16-1" name="dnut_tdn_avg"
                                        value="<?php echo $dnut_tdn_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-16-2" name="dnut_tdn_sd"
                                        value="<?php echo $dnut_tdn_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-16-3" name="dnut_tdn_n"
                                        value="<?php echo $dnut_tdn_n; ?>"></td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <th scope="row">ค่าพลังงานที่ย่อยได้ (DE)</th>
                                <td><input type="text" class="form-control" id="data2-17-1" name="dnut_de_avg"
                                        value="<?php echo $dnut_de_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-17-2" name="dnut_de_sd"
                                        value="<?php echo $dnut_de_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-17-3" name="dnut_de_n"
                                        value="<?php echo $dnut_de_n; ?>"></td>
                                <td rowspan="3" class="text-center">Mcal/kgDM</td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าพลังงานที่สามารถใช้ปนะโยชน์ได้ (ME)</th>
                                <td><input type="text" class="form-control" id="data2-18-1" name="dnut_me_avg"
                                        value="<?php echo $dnut_me_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-18-2" name="dnut_me_sd"
                                        value="<?php echo $dnut_me_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-18-3" name="dnut_me_n"
                                        value="<?php echo $dnut_me_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าพลังงานสุทธิเพื่อการให้ผลผลิตน้ำนม (NEL)</th>
                                <td><input type="text" class="form-control" id="data2-19-1" name="dnut_nel_avg"
                                        value="<?php echo $dnut_nel_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-19-2" name="dnut_nel_sd"
                                        value="<?php echo $dnut_nel_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data2-19-3" name="dnut_nel_n"
                                        value="<?php echo $dnut_nel_n; ?>"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center btn-more">
                    <div class="form-group">
                        <button type="button" class="btn btn-cancel btn-back"
                            onclick="window.location.href='edit_nutrition.php'">ย้อนกลับ</button>
                    </div>
                    <div class="form-group">
                        <button type="reset" class="btn btn-cancel">ล้างข้างมูล</button>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-add confirm" name="addRaw">ยืนยัน</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</body>

</html>