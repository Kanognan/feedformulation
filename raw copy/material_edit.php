<?php
session_start();
include "../server.php";
?>
<?php require "../session/expert_session.php"; ?>
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
        $sqltab3 = "SELECT 
                        raw_material.raw_id, 
                        raw_material.raw_thainame,
                        raw_material.raw_engname,
                        raw_material.feed_class,
                        type_raw_material.type_raw_thainame, 
                        type_raw_material.type_raw_id,
                        GROUP_CONCAT(material_detail.material_detail_id) as material_detail_ids
                    FROM 
                        raw_material
                    JOIN 
                        type_raw_material ON raw_material.type_raw_id = type_raw_material.type_raw_id
                    JOIN 
                        material ON raw_material.raw_id = material.raw_id
                    JOIN 
                        material_detail ON material.material_detail_id = material_detail.material_detail_id
                    WHERE
                            raw_material.raw_id = '$raw_id'
                    GROUP BY 
                        raw_material.raw_id, raw_material.raw_thainame, raw_material.raw_engname, raw_material.feed_class, type_raw_material.type_raw_thainame, type_raw_material.type_raw_id";

        $resulttab3 = $conn->query($sqltab3);

        if ($resulttab3 && $resulttab3->num_rows > 0) {
            while ($rowtab3 = $resulttab3->fetch_assoc()) {
                $raw_thainame = $rowtab3["raw_thainame"];
                $raw_engname = $rowtab3["raw_engname"];
                $type_raw_id = $rowtab3["type_raw_id"];
                $type_raw_thainame = $rowtab3["type_raw_thainame"];
                $feed_class = $rowtab3["feed_class"];
                $material_detail_ids = $rowtab3["material_detail_ids"];
                $material_detail_array = explode(",", $material_detail_ids);

                foreach ($material_detail_array as $material_detail_id) {
                    $sql = "SELECT * FROM material_detail WHERE material_detail_id = $material_detail_id";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if ($row['type_detail_id'] == 1) {
                                $dmat_ala_avg = $row['dmat_ala'];
                                $dmat_arg_avg = $row['dmat_arg'];
                                $dmat_asp_avg = $row['dmat_asp'];
                                $dmat_cys_avg = $row['dmat_cys'];
                                $dmat_glu_avg = $row['dmat_glu'];
                                $dmat_gly_avg = $row['dmat_gly'];
                                $dmat_his_avg = $row['dmat_his'];
                                $dmat_hyl_avg = $row['dmat_hyl'];
                                $dmat_hyp_avg = $row['dmat_hyp'];
                                $dmat_ile_avg = $row['dmat_ile'];
                                $dmat_leu_avg = $row['dmat_leu'];
                                $dmat_lys_avg = $row['dmat_lys'];
                                $dmat_met_avg = $row['dmat_met'];
                                $dmat_phe_avg = $row['dmat_phe'];
                                $dmat_pro_avg = $row['dmat_pro'];
                                $dmat_ser_avg = $row['dmat_ser'];
                                $dmat_thr_avg = $row['dmat_thr'];
                                $dmat_trp_avg = $row['dmat_trp'];
                                $dmat_tyr_avg = $row['dmat_tyr'];
                                $dmat_val_avg = $row['dmat_val'];
                            }
                            if ($row['type_detail_id'] == 2) {
                                $dmat_ala_sd = $row['dmat_ala'];
                                $dmat_arg_sd = $row['dmat_arg'];
                                $dmat_asp_sd = $row['dmat_asp'];
                                $dmat_cys_sd = $row['dmat_cys'];
                                $dmat_glu_sd = $row['dmat_glu'];
                                $dmat_gly_sd = $row['dmat_gly'];
                                $dmat_his_sd = $row['dmat_his'];
                                $dmat_hyl_sd = $row['dmat_hyl'];
                                $dmat_hyp_sd = $row['dmat_hyp'];
                                $dmat_ile_sd = $row['dmat_ile'];
                                $dmat_leu_sd = $row['dmat_leu'];
                                $dmat_lys_sd = $row['dmat_lys'];
                                $dmat_met_sd = $row['dmat_met'];
                                $dmat_phe_sd = $row['dmat_phe'];
                                $dmat_pro_sd = $row['dmat_pro'];
                                $dmat_ser_sd = $row['dmat_ser'];
                                $dmat_thr_sd = $row['dmat_thr'];
                                $dmat_trp_sd = $row['dmat_trp'];
                                $dmat_tyr_sd = $row['dmat_tyr'];
                                $dmat_val_sd = $row['dmat_val'];
                            }
                            if ($row['type_detail_id'] == 3) {
                                $dmat_ala_n = $row['dmat_ala'];
                                $dmat_arg_n = $row['dmat_arg'];
                                $dmat_asp_n = $row['dmat_asp'];
                                $dmat_cys_n = $row['dmat_cys'];
                                $dmat_glu_n = $row['dmat_glu'];
                                $dmat_gly_n = $row['dmat_gly'];
                                $dmat_his_n = $row['dmat_his'];
                                $dmat_hyl_n = $row['dmat_hyl'];
                                $dmat_hyp_n = $row['dmat_hyp'];
                                $dmat_ile_n = $row['dmat_ile'];
                                $dmat_leu_n = $row['dmat_leu'];
                                $dmat_lys_n = $row['dmat_lys'];
                                $dmat_met_n = $row['dmat_met'];
                                $dmat_phe_n = $row['dmat_phe'];
                                $dmat_pro_n = $row['dmat_pro'];
                                $dmat_ser_n = $row['dmat_ser'];
                                $dmat_thr_n = $row['dmat_thr'];
                                $dmat_trp_n = $row['dmat_trp'];
                                $dmat_tyr_n = $row['dmat_tyr'];
                                $dmat_val_n = $row['dmat_val'];
                            }
                        }
                    }
                }
            }
        } else {
            echo "ไม่พบข้อมูลที่ตรงกับ raw_id: $raw_id";
        }
        ?>
        <h1>แก้ไขกรดอะมิโนในวัตถุดิบ</h1>
        <form class="" action="material_edit_db.php?id=<?php echo $raw_id; ?>" method="post"
            enctype="multipart/form-data" id="material_detail">
            <div class="row t1-1 t22">
                <div class="col-6">
                    <label for="data5-2" class="form-label">ชื่อสามัญภาษาไทย</label>
                    <input type="text" class="form-control" id="data5-2" name="raw_thainame"
                        placeholder="กรอกชื่อสามัญภาษาไทย" value="<?php echo $raw_thainame; ?>" required>
                </div>
                <div class="col-6">
                    <label for="data5-3" class="form-label">ชื่อสามัญภาษาอังกฤษ</label>
                    <input type="text" class="form-control" id="data5-3" name="raw_engname"
                        placeholder="กรอกชื่อสามัญภาษาอังกฤษ" value="<?php echo $raw_engname; ?>" required>
                </div>
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
            </div>
            <div class="" id="5th" role="tabpanel" aria-labelledby="5th-tab" tabindex="0">
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
                                <th scope="row">ค่า Alanine (Ala)</th>
                                <td><input type="text" class="form-control" id="data5-1-1" name="dmat_ala_avg"
                                        value="<?php echo $dmat_ala_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-1-2" name="dmat_ala_sd"
                                        value="<?php echo $dmat_ala_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-1-3" name="dmat_ala_n"
                                        value="<?php echo $dmat_ala_n; ?>"></td>
                                <td rowspan="20" class="text-center">mg/100g</td>
                            </tr>
                            <tr>
                                <th scope="row">ค่า Arginine (Arg)</th>
                                <td><input type="text" class="form-control" id="data5-2-1" name="dmat_arg_avg"
                                        value="<?php echo $dmat_arg_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-2-2" name="dmat_arg_sd"
                                        value="<?php echo $dmat_arg_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-2-3" name="dmat_arg_n"
                                        value="<?php echo $dmat_arg_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่า Aspartic acid (Asp)</th>
                                <td><input type="text" class="form-control" id="data5-3-1" name="dmat_asp_avg"
                                        value="<?php echo $dmat_asp_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-3-2" name="dmat_asp_sd"
                                        value="<?php echo $dmat_asp_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-3-3" name="dmat_asp_n"
                                        value="<?php echo $dmat_asp_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่า Cystine (Cys)</th>
                                <td><input type="text" class="form-control" id="data5-4-1" name="dmat_cys_avg"
                                        value="<?php echo $dmat_cys_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-4-2" name="dmat_cys_sd"
                                        value="<?php echo $dmat_cys_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-4-3" name="dmat_cys_n"
                                        value="<?php echo $dmat_cys_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่า Glutamic acid (Glu)</th>
                                <td><input type="text" class="form-control" id="data5-5-1" name="dmat_glu_avg"
                                        value="<?php echo $dmat_glu_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-5-2" name="dmat_glu_sd"
                                        value="<?php echo $dmat_glu_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-5-3" name="dmat_glu_n"
                                        value="<?php echo $dmat_glu_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่า Glycine (Gly)</th>
                                <td><input type="text" class="form-control" id="data5-6-1" name="dmat_gly_avg"
                                        value="<?php echo $dmat_gly_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-6-2" name="dmat_gly_sd"
                                        value="<?php echo $dmat_gly_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-6-3" name="dmat_gly_n"
                                        value="<?php echo $dmat_gly_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่า Histidine (His)</th>
                                <td><input type="text" class="form-control" id="data5-7-1" name="dmat_his_avg"
                                        value="<?php echo $dmat_his_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-7-2" name="dmat_his_sd"
                                        value="<?php echo $dmat_his_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-7-3" name="dmat_his_n"
                                        value="<?php echo $dmat_his_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่า Hydroxylysine (Hyl)</th>
                                <td><input type="text" class="form-control" id="data5-8-1" name="dmat_hyl_avg"
                                        value="<?php echo $dmat_hyl_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-8-2" name="dmat_hyl_sd"
                                        value="<?php echo $dmat_hyl_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-8-3" name="dmat_hyl_n"
                                        value="<?php echo $dmat_hyl_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่า Hydroxyproline (Hyp)</th>
                                <td><input type="text" class="form-control" id="data5-9-1" name="dmat_hyp_avg"
                                        value="<?php echo $dmat_hyp_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-9-2" name="dmat_hyp_sd"
                                        value="<?php echo $dmat_hyp_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-9-3" name="dmat_hyp_n"
                                        value="<?php echo $dmat_hyp_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่า Isoleucine (Ile)</th>
                                <td><input type="text" class="form-control" id="data5-10-1" name="dmat_ile_avg"
                                        value="<?php echo $dmat_ile_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-10-2" name="dmat_ile_sd"
                                        value="<?php echo $dmat_ile_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-10-3" name="dmat_ile_n"
                                        value="<?php echo $dmat_ile_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่า Leucine (Leu)</th>
                                <td><input type="text" class="form-control" id="data5-11-1" name="dmat_leu_avg"
                                        value="<?php echo $dmat_leu_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-11-2" name="dmat_leu_sd"
                                        value="<?php echo $dmat_leu_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-11-3" name="dmat_leu_n"
                                        value="<?php echo $dmat_leu_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่า Lysine (Lys)</th>
                                <td><input type="text" class="form-control" id="data5-12-1" name="dmat_lys_avg"
                                        value="<?php echo $dmat_lys_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-12-2" name="dmat_lys_sd"
                                        value="<?php echo $dmat_lys_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-12-3" name="dmat_lys_n"
                                        value="<?php echo $dmat_lys_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่า Methionine (Met)</th>
                                <td><input type="text" class="form-control" id="data5-13-1" name="dmat_met_avg"
                                        value="<?php echo $dmat_met_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-13-2" name="dmat_met_sd"
                                        value="<?php echo $dmat_met_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-13-3" name="dmat_met_n"
                                        value="<?php echo $dmat_met_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่า Phenylalanine (Phe)</th>
                                <td><input type="text" class="form-control" id="data5-14-1" name="dmat_phe_avg"
                                        value="<?php echo $dmat_phe_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-14-2" name="dmat_phe_sd"
                                        value="<?php echo $dmat_phe_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-14-3" name="dmat_phe_n"
                                        value="<?php echo $dmat_phe_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่า Proline (Pro)</th>
                                <td><input type="text" class="form-control" id="data5-15-1" name="dmat_pro_avg"
                                        value="<?php echo $dmat_pro_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-15-2" name="dmat_pro_sd"
                                        value="<?php echo $dmat_pro_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-15-3" name="dmat_pro_n"
                                        value="<?php echo $dmat_pro_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่า Serine (Ser)</th>
                                <td><input type="text" class="form-control" id="data5-16-1" name="dmat_ser_avg"
                                        value="<?php echo $dmat_ser_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-16-2" name="dmat_ser_sd"
                                        value="<?php echo $dmat_ser_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-16-3" name="dmat_ser_n"
                                        value="<?php echo $dmat_ser_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่า Threnine (Thr)</th>
                                <td><input type="text" class="form-control" id="data5-17-1" name="dmat_thr_avg"
                                        value="<?php echo $dmat_thr_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-17-2" name="dmat_thr_sd"
                                        value="<?php echo $dmat_thr_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-17-3" name="dmat_thr_n"
                                        value="<?php echo $dmat_thr_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่า Tryptophan (Trp)</th>
                                <td><input type="text" class="form-control" id="data5-18-1" name="dmat_trp_avg"
                                        value="<?php echo $dmat_trp_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-18-2" name="dmat_trp_sd"
                                        value="<?php echo $dmat_trp_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-18-3" name="dmat_trp_n"
                                        value="<?php echo $dmat_trp_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่า Tyrosine (Tyr)</th>
                                <td><input type="text" class="form-control" id="data5-19-1" name="dmat_tyr_avg"
                                        value="<?php echo $dmat_tyr_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-19-2" name="dmat_tyr_sd"
                                        value="<?php echo $dmat_tyr_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-19-3" name="dmat_tyr_n"
                                        value="<?php echo $dmat_tyr_n; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่า Valine (Val)</th>
                                <td><input type="text" class="form-control" id="data5-20-1" name="dmat_val_avg"
                                        value="<?php echo $dmat_val_avg; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-20-2" name="dmat_val_sd"
                                        value="<?php echo $dmat_val_sd; ?>"></td>
                                <td><input type="text" class="form-control" id="data5-20-3" name="dmat_val_n"
                                        value="<?php echo $dmat_val_n; ?>"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center btn-more">
                    <div class="form-group">
                        <button type="button" class="btn btn-cancel btn-back"
                            onclick="window.location.href='raw_material.php'">ย้อนกลับ</button>
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