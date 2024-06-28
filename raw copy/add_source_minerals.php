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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hello, Bootstrap Table!</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="raw_style.css">
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
            width: 16em !important;
            padding: 1em;
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
        
        th {
            background-color: #f3faff !important;
        }
    </style>
</head>

<body>
    <?php include "nav-bar.php"; ?>
    <div class="container">
        <div class="menu-add">
            <div class="d-flex justify-content-center">
                <div class="row text-center">
                    <div class="col-md-3 col-sm-6 col-12">
                        <button type="button" class="select-add btn btn-light add"
                            onclick="window.location='add_nutrition.php'">เพิ่มคุณค่าทางโภชนะของวัตถุดิบ</button>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <button type="button" class="select-add btn btn-light add"
                            onclick="window.location='add_minerals.php'">เพิ่มปริมาณแร่ธาตุในวัตถุดิบ</button>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <button type="button" class="select-add btn btn-light add"
                            onclick="window.location='add_material.php'">เพิ่มกรดอะมิโนในวัตถุดิบ</button>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <button type="button" class="select-add-active btn btn-light add"
                            onclick="window.location='add_source_minerals.php'">เพิ่มค่าแร่ธาตุของวัตถุดิบ</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="form_add">
            <h1>เพิ่มค่าแร่ธาตุของวัตถุดิบ</h1>
            <form class="needs-validation" action="source_minerals.php" method="post" enctype="multipart/form-data"
                id="source_minerals" novalidate>
                <div class="" id="general-information" role="tabpanel" aria-labelledby="general-information-tab"
                    tabindex="0">
                    <div class="row t1-1 t22">
                        <?php
                        $sqlRawThai = "SELECT * FROM mineral_source_raw";
                        $resultRawThai = $conn->query($sqlRawThai);
                        ?>
                        <div class="col-6 was-validated">
                            <label for="data1-2" class="form-label">ชื่อแร่ธาตุภาษาไทย</label>
                            <input class="form-control" type="text" list="ms_thainame" id="data1-2"
                                placeholder="กรอกชื่อสามัญภาษาไทย" name="ms_thainame" required
                                pattern="[ก-๙]+([ก-๙0-9\s,\.\(\)]*)">
                        </div>
                        <div class="col-6 was-validated">
                            <label for="data1-3" class="form-label">ชื่อแร่ธาตุ ภาษาอังกฤษ</label>
                            <input type="text" class="form-control" id="data1-3" name="ms_engname" required
                                pattern="[a-zA-Z]+([a-zA-Z0-9\s,\-\.\(\)]*)" placeholder="กรอกชื่อสามัญภาษาอังกฤษ">
                        </div>

                        <div class="col-6">
                            <div class="cate-raw">
                                <label for="type_ms_id" class="form-label">หมวดหมู่แร่ธาตุ</label>
                                <select name="type_ms_id" id="type_ms_id" class="form-select" required>
                                    <option selected disabled>เลือกหมวดหมู่แร่ธาตุ</option>
                                    <?php
                                    $sql = "SELECT * FROM type_mineral_source_raw";
                                    $result = $conn->query($sql);

                                    while ($raw = $result->fetch_assoc()):
                                        ;
                                        ?>
                                        <option value="<?php echo $raw["type_ms_id"]; ?>">
                                            <?php echo $raw["type_ms_thainame"]; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                                <div class="invalid-feedback" id="error-message"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="data3-1" class="form-label">Feed Class</label>
                            <input type="text" class="form-control" id="data3-1" placeholder="กรอกชื่อแร่ธาตุภาษาไทย"
                                value="6 (วัตถุดิบแหล่งแร่ธาตุ)" disabled>
                            <input type="text" name="feed_class" value="6" hidden>
                        </div>
                    </div>
                </div>
                <div class="" id="3rd" role="tabpanel" aria-labelledby="3rd-tab" tabindex="0">
                    <div>
                        <p>* หากไม่มีข้อมูลในรายการนั้นให้กรอก ND (No data)</p>
                        <p>* หากไม่สามารถตรวจวัดข้อมูลได้ให้กรอก Nd (No detect)</p>
                    </div>
                    <div class="table-responsive py-4 table">
                        <table class="table table-bordered was-validated">
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
                                    <td><input type="text" class="form-control" id="data3-1-1" name="ds_DM" required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td rowspan="8" class="text-center">%</td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าแคลเซียม (Ca)</th>
                                    <td><input type="text" class="form-control" id="data3-2-1" name="ds_ca" required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าฟอสฟอรัส (P)</th>
                                    <td><input type="text" class="form-control" id="data3-3-1" name="ds_p" required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าแมกนีเซียม (Mg)</th>
                                    <td><input type="text" class="form-control" id="data3-4-1" name="ds_mg" required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าโพแทสเซียม (K)</th>
                                    <td><input type="text" class="form-control" id="data3-5-1" name="ds_k" required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่ากำมะถัน (S)</th>
                                    <td><input type="text" class="form-control" id="data3-6-1" name="ds_s" required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าโซเดียม (Na)</th>
                                    <td><input type="text" class="form-control" id="data3-7-1" name="ds_na" required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าคลอรีน (Cl)</th>
                                    <td><input type="text" class="form-control" id="data3-8-1" name="ds_cl" required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <th scope="row">ค่าทองแดง (Cu)</th>
                                    <td><input type="text" class="form-control" id="data3-9-1" name="ds_cu" required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td rowspan="7" class="text-center">mg/kg</td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าเหล็ก (Fe)</th>
                                    <td><input type="text" class="form-control" id="data3-10-1" name="ds_fe" required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าแมงกานีส (Mn)</th>
                                    <td><input type="text" class="form-control" id="data3-11-1" name="ds_mn" required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าสังกะสี (Zn)</th>
                                    <td><input type="text" class="form-control" id="data3-12-1" name="ds_zn" required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าโคบอลท์ (Co)</th>
                                    <td><input type="text" class="form-control" id="data3-13-1" name="ds_co" required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าไอโอดีน (I)</th>
                                    <td><input type="text" class="form-control" id="data3-14-1" name="ds_i" required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าซีลีเนียม (Se)</th>
                                    <td><input type="text" class="form-control" id="data3-15-1" name="ds_se" required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <th scope="row">ค่าวิตามินเอ (Vit A)</th>
                                    <td><input type="text" class="form-control" id="data3-16-1" name="vitA" required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                    <td rowspan="3" class="text-center">IU/kg</td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าวิตามินดี (Vit D)</th>
                                    <td><input type="text" class="form-control" id="data3-17-1" name="vitD" required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                                <tr>
                                    <th scope="row">ค่าวิตามินดี (Vit E)</th>
                                    <td><input type="text" class="form-control" id="data3-18-1" name="vitE" required pattern="(?:nd|Nd|ND|\d+(\.\d+)?)"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center btn-more">
                        <div class="form-group">
                            <button type="reset" class="btn btn-cancel">ล้างข้างมูล</button>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-add confirm" name="addSourceM">ยืนยัน</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    if (isset($_SESSION['resultData'])) {
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

</body>

</html>