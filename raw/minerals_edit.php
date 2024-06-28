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
        $sqltab2 = "SELECT 
                        raw_material.raw_id, 
                        raw_material.raw_thainame,
                        raw_material.raw_engname,
                        raw_material.feed_class,
                        type_raw_material.type_raw_thainame,
                        type_raw_material.type_raw_id,
                        GROUP_CONCAT(minerals_detail.minerals_detail_id) as minerals_detail_ids
                    FROM 
                        raw_material
                    JOIN 
                        type_raw_material ON raw_material.type_raw_id = type_raw_material.type_raw_id
                    JOIN 
                        minerals ON raw_material.raw_id = minerals.raw_id
                    JOIN 
                        minerals_detail ON minerals.minerals_detail_id = minerals_detail.minerals_detail_id
                        WHERE
                                raw_material.raw_id = '$raw_id'
                    GROUP BY 
                        raw_material.raw_id, raw_material.raw_thainame, raw_material.raw_engname, raw_material.feed_class, type_raw_material.type_raw_thainame, type_raw_material.type_raw_id";

        $resulttab2 = $conn->query($sqltab2);

        if ($resulttab2 && $resulttab2->num_rows > 0) {
            while ($rowtab2 = $resulttab2->fetch_assoc()) {
                $raw_thainame = $rowtab2["raw_thainame"];
                $raw_engname = $rowtab2["raw_engname"];
                $type_raw_id = $rowtab2["type_raw_id"];
                $type_raw_thainame = $rowtab2["type_raw_thainame"];
                $feed_class = $rowtab2["feed_class"];
                $minerals_detail_ids = $rowtab2["minerals_detail_ids"];
                $minerals_detail_array = explode(",", $minerals_detail_ids);

                foreach ($minerals_detail_array as $minerals_detail_id) {
                    $sql = "SELECT * FROM minerals_detail WHERE minerals_detail_id = $minerals_detail_id";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if ($row['type_detail_id'] == 1) {
                                $dminer_per_ca_avg = $row['dminer_per_ca'];
                                $dminer_per_p_avg = $row['dminer_per_p'];
                                $dminer_per_mg_avg = $row['dminer_per_mg'];
                                $dminer_per_k_avg = $row['dminer_per_k'];
                                $dminer_per_s_avg = $row['dminer_per_s'];
                                $dminer_per_na_avg = $row['dminer_per_na'];
                                $dminer_kg_cu_avg = $row['dminer_kg_cu'];
                                $dminer_kg_fe_avg = $row['dminer_kg_fe'];
                                $dminer_kg_mn_avg = $row['dminer_kg_mn'];
                                $dminer_kg_zn_avg = $row['dminer_kg_zn'];
                            }
                            if ($row['type_detail_id'] == 2) {
                                $dminer_per_ca_sd = $row['dminer_per_ca'];
                                $dminer_per_p_sd = $row['dminer_per_p'];
                                $dminer_per_mg_sd = $row['dminer_per_mg'];
                                $dminer_per_k_sd = $row['dminer_per_k'];
                                $dminer_per_s_sd = $row['dminer_per_s'];
                                $dminer_per_na_sd = $row['dminer_per_na'];
                                $dminer_kg_cu_sd = $row['dminer_kg_cu'];
                                $dminer_kg_fe_sd = $row['dminer_kg_fe'];
                                $dminer_kg_mn_sd = $row['dminer_kg_mn'];
                                $dminer_kg_zn_sd = $row['dminer_kg_zn'];
                            }
                            if ($row['type_detail_id'] == 3) {
                                $dminer_per_ca_n = $row['dminer_per_ca'];
                                $dminer_per_p_n = $row['dminer_per_p'];
                                $dminer_per_mg_n = $row['dminer_per_mg'];
                                $dminer_per_k_n = $row['dminer_per_k'];
                                $dminer_per_s_n = $row['dminer_per_s'];
                                $dminer_per_na_n = $row['dminer_per_na'];
                                $dminer_kg_cu_n = $row['dminer_kg_cu'];
                                $dminer_kg_fe_n = $row['dminer_kg_fe'];
                                $dminer_kg_mn_n = $row['dminer_kg_mn'];
                                $dminer_kg_zn_n = $row['dminer_kg_zn'];
                            }
                        }
                    }
                }
            }
        } else {
            echo "ไม่พบข้อมูลที่ตรงกับ raw_id: $raw_id";
        }
        ?>
        <h1>แก้ไขปริมาณแร่ธาตุในวัตถุดิบ</h1>
        <form class="" action="minerals_edit_db.php?id=<?php echo $raw_id; ?>" method="post" enctype="multipart/form-data" id="minerals_detail">
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
                    <label for="data4-2" class="form-label">ชื่อสามัญภาษาไทย</label>
                    <input type="text" class="form-control" id="data4-2" name="raw_thainame"
                        placeholder="กรอกชื่อสามัญภาษาไทย" value="<?php echo $raw_thainame; ?>" required>
                </div>
                <div class="col-6">
                    <label for="data4-3" class="form-label">ชื่อสามัญภาษาอังกฤษ</label>
                    <input type="text" class="form-control" id="data4-3" name="raw_engname"
                        placeholder="กรอกชื่อสามัญภาษาอังกฤษ" value="<?php echo $raw_engname; ?>" required>
                </div>
            </div>
            <div class="" id="4th" role="tabpanel" aria-labelledby="4th-tab" tabindex="0">
                <div>
                    <p>* หากไม่มีข้อมูลในรายการนั้นให้กรอก ND (No data)</p>
                    <p>* หากไม่สามารถตรวจวัดข้อมูลได้ให้กรอก Nd (No detect)</p>
                </div>
                <div class="table-responsive py-4 table">
                    <table class="table table-bordered">
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
                                <td><input type="text" class="form-control" id="data4-1-1" name="dminer_per_ca_avg" value="<?php echo $dminer_per_ca_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data4-1-2" name="dminer_per_ca_sd" value="<?php echo $dminer_per_ca_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data4-1-3" name="dminer_per_ca_n" value="<?php echo $dminer_per_ca_n; ?>"></td>
                                <td rowspan="6" class="text-center">%</td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าฟอสฟอรัส (P)</th>
                                <td><input type="text" class="form-control" id="data4-2-1" name="dminer_per_p_avg" value="<?php echo $dminer_per_p_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data4-2-2" name="dminer_per_p_sd" value="<?php echo $dminer_per_p_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data4-2-3" name="dminer_per_p_n" value="<?php echo $dminer_per_p_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าแมกนีเซียม (Mg)</th>
                                <td><input type="text" class="form-control" id="data4-3-1" name="dminer_per_mg_avg" value="<?php echo $dminer_per_mg_avg; ?>">
                                </td>
                                <td><input type="text" class="form-control" id="data4-3-2" name="dminer_per_mg_sd" value="<?php echo $dminer_per_mg_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data4-3-3" name="dminer_per_mg_n" value="<?php echo $dminer_per_mg_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าโพแทสเซียม (K)</th>
                                <td><input type="text" class="form-control" id="data4-4-1" name="dminer_per_k_avg" value="<?php echo $dminer_per_k_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data4-4-2" name="dminer_per_k_sd" value="<?php echo $dminer_per_k_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data4-4-3" name="dminer_per_k_n" value="<?php echo $dminer_per_k_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่ากำมะถัน (S)</th>
                                <td><input type="text" class="form-control" id="data4-5-1" name="dminer_per_s_avg" value="<?php echo $dminer_per_s_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data4-5-2" name="dminer_per_s_sd" value="<?php echo $dminer_per_s_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data4-5-3" name="dminer_per_s_n" value="<?php echo $dminer_per_s_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าโซเดียม (Na)</th>
                                <td><input type="text" class="form-control" id="data4-6-1" name="dminer_per_na_avg" value="<?php echo $dminer_per_na_avg; ?>">
                                </td>
                                <td><input type="text" class="form-control" id="data4-6-2" name="dminer_per_na_sd" value="<?php echo $dminer_per_na_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data4-6-3" name="dminer_per_na_n" value="<?php echo $dminer_per_na_n; ?>"></td>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <th scope="row">ค่าทองแดง (Cu)</th>
                                <td><input type="text" class="form-control" id="data4-7-1" name="dminer_kg_cu_avg" value="<?php echo $dminer_kg_cu_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data4-7-2" name="dminer_kg_cu_sd" value="<?php echo $dminer_kg_cu_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data4-7-3" name="dminer_kg_cu_n" value="<?php echo $dminer_kg_cu_n; ?>"></td>
                                <td rowspan="4" class="text-center">mg/kg</td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าเหล็ก (Fe)</th>
                                <td><input type="text" class="form-control" id="data4-8-1" name="dminer_kg_fe_avg" value="<?php echo $dminer_kg_fe_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data4-8-2" name="dminer_kg_fe_sd" value="<?php echo $dminer_kg_fe_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data4-8-3" name="dminer_kg_fe_n" value="<?php echo $dminer_kg_fe_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าแมงกานีส (Mn)</th>
                                <td><input type="text" class="form-control" id="data4-9-1" name="dminer_kg_mn_avg" value="<?php echo $dminer_kg_mn_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data4-9-2" name="dminer_kg_mn_sd" value="<?php echo $dminer_kg_mn_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data4-9-3" name="dminer_kg_mn_n" value="<?php echo $dminer_kg_mn_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าสังกะสี (Zn)</th>
                                <td><input type="text" class="form-control" id="data4-10-1" name="dminer_kg_zn_avg" value="<?php echo $dminer_kg_zn_avg; ?>">
                                </td>
                                <td><input type="text" class="form-control" id="data4-10-2" name="dminer_kg_zn_sd" value="<?php echo $dminer_kg_zn_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data4-10-3" name="dminer_kg_zn_n" value="<?php echo $dminer_kg_zn_n; ?>"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center btn-more">
                    <div class="form-group">
                        <button type="button" class="btn btn-cancel btn-back" onclick="window.location.href='edit_minerals.php'">ย้อนกลับ</button>
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