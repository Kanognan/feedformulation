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
        /* td{
            text-align: center !important;
        } */
    </style>
</head>

<body>
    <?php include("nav-bar.php") ?>
    <div class="container">
        <?php
        $ms_id = $_GET['id'];

        // echo $ms_id;
        $sqltab3 = "SELECT * FROM  mineral_source_raw WHERE ms_id ='$ms_id'";
        $resulttab3 = $conn->query($sqltab3);
        $rowMs = $resulttab3->fetch_assoc();
        $ms_thainame = $rowMs['ms_thainame'];
        $ms_engname = $rowMs['ms_engname'];
        $type_ms_id = $rowMs["type_ms_id"];
        $feed_class = $rowMs["feed_class"];

        if ($type_ms_id) {
            $sqltype_ms_id = "SELECT * FROM  type_mineral_source_raw WHERE type_ms_id ='$type_ms_id'";
            $resulttype_ms_id = $conn->query($sqltype_ms_id);
            $rowtype_ms_id = $resulttype_ms_id->fetch_assoc();
            $type_ms_thainame = $rowtype_ms_id["type_ms_thainame"];
        }

        $sqlsource_minerals = "SELECT * FROM  source_minerals WHERE ms_id ='$ms_id'";
        $resultsource_minerals = $conn->query($sqlsource_minerals);
       
        while ($row = $resultsource_minerals->fetch_assoc()) {
            $source_detail_id = $row["source_detail_id"];
            // echo $source_detail_id;
            $sql = "SELECT * FROM source_minerals_detail WHERE source_detail_id = $source_detail_id";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while ($row_detail = $result->fetch_assoc()) {
                    $ds_DM = $row_detail['ds_DM'];
                    $ds_ca = $row_detail['ds_ca'];
                    $ds_p = $row_detail['ds_p'];
                    $ds_mg = $row_detail['ds_mg'];
                    $ds_k = $row_detail['ds_k'];
                    $ds_s = $row_detail['ds_s'];
                    $ds_na = $row_detail['ds_na'];
                    $ds_cl = $row_detail['ds_cl'];
                    $ds_cu = $row_detail['ds_cu'];
                    $ds_fe = $row_detail['ds_fe'];
                    $ds_mn = $row_detail['ds_mn'];
                    $ds_zn = $row_detail['ds_zn'];
                    $ds_co = $row_detail['ds_co'];
                    $ds_i = $row_detail['ds_i'];
                    $ds_se = $row_detail['ds_se'];
                    $vitA = $row_detail['ds_vitA'];
                    $vitD = $row_detail['ds_vitD'];
                    $vitE = $row_detail['ds_vitE'];
                }
            }
        }

        ?>
        <h1>แก้ไขค่าแร่ธาตุของวัตถุดิบ</h1>
        <form class="" action="source_minerals_edit_db.php?id=<?php echo $ms_id; ?>" method="post"
            enctype="multipart/form-data" id="material_detail">
            <div class="row t1-1 t22">
                <div class="col-6">
                    <label for="data5-2" class="form-label">ชื่อสามัญภาษาไทย</label>
                    <input type="text" class="form-control" id="data5-2" name="ms_thainame"
                        placeholder="กรอกชื่อแร่ธาตุภาษาไทย" value="<?php echo $ms_thainame; ?>" required>
                </div>
                <div class="col-6">
                    <label for="data5-3" class="form-label">ชื่อสามัญภาษาอังกฤษ</label>
                    <input type="text" class="form-control" id="data5-3" name="ms_engname"
                        placeholder="กรอกชื่อแร่ธาตุภาษาอังกฤษ" value="<?php echo $ms_engname; ?>" required>
                </div>
                <div class="col-6">
                    <label for="type_ms_id" class="col-form-label">หมวดหมู่ :</label>
                    <select class="form-select" id="type_ms_id" name="type_ms_id">
                        <?php
                        $sql_type = "SELECT 
                                        type_mineral_source_raw.*
                                    FROM 
                                        type_mineral_source_raw";

                        $result_type = $conn->query($sql_type);

                        while ($row_type = $result_type->fetch_assoc()) {
                            $selected = ($row_type["type_ms_id"] == $type_ms_id) ? "selected" : "";
                            echo "<option value='{$row_type["type_ms_id"]}' $selected>{$row_type["type_ms_thainame"]}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-6">
                    <label for="data3-1" class="col-form-label">Feed Class</label>
                    <input type="text" class="form-control" id="data3-1" placeholder="กรอกชื่อแร่ธาตุภาษาไทย"
                        value="6 (วัตถุดิบแหล่งแร่ธาตุ)" disabled>
                    <input type="text" name="feed_class" value="6" hidden>
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
                                <th scope="col">โดยน้ำหนักสด</th>
                                <th scope="col">หน่วย</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">ค่าวัตถุแห้ง (DM)</th>
                                <td><input type="text" class="form-control" id="data3-1-1" name="ds_DM" required
                                        pattern="(?:nd|Nd|ND|\d+(\.\d+)?)" value="<?php echo $ds_DM; ?>"></td>
                                <td rowspan="8" class="text-center">%</td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าแคลเซียม (Ca)</th>
                                <td><input type="text" class="form-control" id="data3-2-1" name="ds_ca" required
                                        pattern="(?:nd|Nd|ND|\d+(\.\d+)?)" value="<?php echo $ds_ca; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าฟอสฟอรัส (P)</th>
                                <td><input type="text" class="form-control" id="data3-3-1" name="ds_p" required
                                        pattern="(?:nd|Nd|ND|\d+(\.\d+)?)" value="<?php echo $ds_p; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าแมกนีเซียม (Mg)</th>
                                <td><input type="text" class="form-control" id="data3-4-1" name="ds_mg" required
                                        pattern="(?:nd|Nd|ND|\d+(\.\d+)?)" value="<?php echo $ds_mg; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าโพแทสเซียม (K)</th>
                                <td><input type="text" class="form-control" id="data3-5-1" name="ds_k" required
                                        pattern="(?:nd|Nd|ND|\d+(\.\d+)?)" value="<?php echo $ds_k; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่ากำมะถัน (S)</th>
                                <td><input type="text" class="form-control" id="data3-6-1" name="ds_s" required
                                        pattern="(?:nd|Nd|ND|\d+(\.\d+)?)" value="<?php echo $ds_s; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าโซเดียม (Na)</th>
                                <td><input type="text" class="form-control" id="data3-7-1" name="ds_na" required
                                        pattern="(?:nd|Nd|ND|\d+(\.\d+)?)" value="<?php echo $ds_na; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าคลอรีน (Cl)</th>
                                <td><input type="text" class="form-control" id="data3-8-1" name="ds_cl" required
                                        pattern="(?:nd|Nd|ND|\d+(\.\d+)?)" value="<?php echo $ds_cl; ?>"></td>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <th scope="row">ค่าทองแดง (Cu)</th>
                                <td><input type="text" class="form-control" id="data3-9-1" name="ds_cu" required
                                        pattern="(?:nd|Nd|ND|\d+(\.\d+)?)" value="<?php echo $ds_cu; ?>"></td>
                                <td rowspan="7" class="text-center">mg/kg</td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าเหล็ก (Fe)</th>
                                <td><input type="text" class="form-control" id="data3-10-1" name="ds_fe" required
                                        pattern="(?:nd|Nd|ND|\d+(\.\d+)?)" value="<?php echo $ds_fe; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าแมงกานีส (Mn)</th>
                                <td><input type="text" class="form-control" id="data3-11-1" name="ds_mn" required
                                        pattern="(?:nd|Nd|ND|\d+(\.\d+)?)" value="<?php echo $ds_mn; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าสังกะสี (Zn)</th>
                                <td><input type="text" class="form-control" id="data3-12-1" name="ds_zn" required
                                        pattern="(?:nd|Nd|ND|\d+(\.\d+)?)" value="<?php echo $ds_zn; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าโคบอลท์ (Co)</th>
                                <td><input type="text" class="form-control" id="data3-13-1" name="ds_co" required
                                        pattern="(?:nd|Nd|ND|\d+(\.\d+)?)" value="<?php echo $ds_co; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าไอโอดีน (I)</th>
                                <td><input type="text" class="form-control" id="data3-14-1" name="ds_i" required
                                        pattern="(?:nd|Nd|ND|\d+(\.\d+)?)" value="<?php echo $ds_i; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าซีลีเนียม (Se)</th>
                                <td><input type="text" class="form-control" id="data3-15-1" name="ds_se" required
                                        pattern="(?:nd|Nd|ND|\d+(\.\d+)?)" value="<?php echo $ds_se; ?>"></td>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <th scope="row">ค่าวิตามินเอ (Vit A)</th>
                                <td><input type="text" class="form-control" id="data3-16-1" name="vitA" required
                                        pattern="(?:nd|Nd|ND|\d+(\.\d+)?)" value="<?php echo $vitA; ?>"></td>
                                <td rowspan="3" class="text-center">IU/kg</td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าวิตามินดี (Vit D)</th>
                                <td><input type="text" class="form-control" id="data3-17-1" name="vitD" required
                                        pattern="(?:nd|Nd|ND|\d+(\.\d+)?)" value="<?php echo $vitD; ?>"></td>
                            </tr>
                            <tr>
                                <th scope="row">ค่าวิตามินดี (Vit E)</th>
                                <td><input type="text" class="form-control" id="data3-18-1" name="vitE" required
                                        pattern="(?:nd|Nd|ND|\d+(\.\d+)?)" value="<?php echo $vitE; ?>"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center btn-more">
                    <div class="form-group">
                        <button type="button" class="btn btn-cancel btn-back"
                            onclick="window.location.href='edit_source_minerals.php'">ย้อนกลับ</button>
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