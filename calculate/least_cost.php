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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php //include("../header.php");          ?>
	<link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <title>คำนวณต้นทุน</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://unpkg.com/javascript-lp-solver/prod/solver.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Kanit', sans-serif;
        }

        body {
            background-color: #F5F5F5 !important;
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

        /* ----------------------------- */
        .btn-more .btn-select {
            background-color: #FE5E5E;
            color: white;
            width: 10em;
            border-radius: 20px !important;
            border: none;
        }

        .btn-more .btn-select:hover {
            background-color: #6999C6 !important;
        }

        table {
            width: 100%;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
        }

        thead tr th {
            background: #A1CAE2 !important;
        }

        .btn-more {
            margin: 4em 0em 1em 0em;
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

            /* table input{
                width: 5em !important;
            } */
        }
    </style>
</head>

<body>
    <?php
    $jsonData = isset ($_SESSION['jsonData']) ? $_SESSION['jsonData'] : '';
    $data = json_decode($jsonData, true);
    $materials = $data['materials'];
    $mineral_sources = $data['mineral_sources'];
    $cow = $data['cow_demand'];
    ?>
    <div class="flex">
        <div class="g-1">
            <?php include ('sidebar.php') ?>
        </div>
        <div class="g-2">
            <div class="content">
                <h2 class="text-center mb-5 mt-3">สูตรอาหารต้นทุนต่ำสุด</h2>
                <div class="table-scrollable ">
                    <h4>สูตรอาหารและต้นทุนต่ำสุดสำหรับ
                        <?php echo $cow[0]['dem_name']; ?>
                    </h4>
                    <div class="table-responsive">
                        <table class="table table-light table-bordered">
                            <thead class="table-head text-center">
                                <tr>
                                    <th scope="col" class="p-3">รายการวัตถุดิบ</th>
                                    <th scope="col" class="p-3">จำนวนที่ใช้ (%)</th>
                                    <th scope="col" class="p-3">จำนวนที่ใช้ (กก.)</th>
                                    <th scope="col" class="p-3">จำนวนที่ใช้ต่อ Intake (กก./วัน)</th>
                                    <th scope="col" class="p-3">ราคาต่อหน่วย (บาท/กก.)</th>
                                    <th scope="col" class="p-3">ราคารวม (บาท/กก.)</th>
                                    <th scope="col" class="p-3">ราคารวมทั้งหมด (บาท)</th>
                                </tr>
                            </thead>
                            <tbody class="text-center" id="material-table-body">
                                <?php foreach ($materials as $material): ?>
                                    <tr>
                                        <td scope="row" class="material-name">
                                            <?php echo $material['raw_thainame']; ?>
                                        </td>
                                        <td class="percent"></td>
                                        <td class="materialKG"></td>
                                        <td class="dem_intake"></td>
                                        <td class="results_key" hidden></td>
                                        <td>
                                            <?php echo $material['price']; ?>
                                        </td>
                                        <td class="show_price_kg"></td>
                                        <td class="show_price"></td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php foreach ($mineral_sources as $ms): ?>
                                    <tr>
                                        <td scope="row" class="material-name">
                                            <?php echo $ms['ms_thainame']; ?>
                                        </td>
                                        <td class="percent"></td>
                                        <td class="materialKG"></td>
                                        <td class="dem_intake"></td>
                                        <td class="results_key" hidden></td>
                                        <td>
                                            <?php echo $ms['price']; ?>
                                        </td>
                                        <td class="show_price_kg"></td>
                                        <td class="show_price"></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="text-center table-secondary">
                                    <th scope="row" colspan="" class="">รวม</th>
                                    <th scope="row" colspan="" class="">100%</th>
                                    <th scope="row" colspan="" class="">1 กก.</th>
                                    <th scope="row" colspan="" class="">
                                        <?php echo $cow[0]['dem_intake']; ?> กก.
                                    </th>
                                    <th scope="row" colspan="" class="">#</th>
                                    <th class="text-center" id="result_kg">0</th>
                                    <th class="text-center" id="result">0</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- <p id="show-tdn"></p> -->
                <div>
                    <h4 class="mt-5">คุณค่าทางโภชนะของ
                        <?php echo $cow[0]['dem_name']; ?>
                    </h4>
                    <?php

                    foreach ($materials as $material) {
                        if (isset ($material['checkbox']['checkboxALL'])) {
                            foreach ($material['checkbox']['checkboxALL'] as $checkbox) {
                                if (isset ($checkbox['dnut_tdn'])) {
                                    $tdn = $cow[0]['dem_tdn'];
                                }
                                if (isset ($checkbox['dnut_de'])) {
                                    $de = $cow[0]['dem_de'];
                                }
                                if (isset ($checkbox['dnut_me'])) {
                                    $me = $cow[0]['dem_me'];
                                }
                                if (isset ($checkbox['dnut_nel'])) {
                                    $nel = $cow[0]['dem_nel'];
                                }
                                if (isset ($checkbox['dnut_adf'])) {
                                    $adf = $cow[0]['dem_adf'];
                                }
                                if (isset ($checkbox['dnut_ndf'])) {
                                    $ndf = $cow[0]['dem_ndf'];
                                }
                                if (isset ($checkbox['dnut_cp'])) {
                                    $cp = $cow[0]['dem_cp'];
                                }
                                if (isset ($checkbox['dnut_rup'])) {
                                    $rup = $cow[0]['dem_rup'];
                                }
                                if (isset ($checkbox['dnut_ee'])) {
                                    $ee = $cow[0]['dem_fat'];
                                }
                                if (isset ($checkbox['dminer_per_ca'])) {
                                    $ca = $cow[0]['dem_ca'];
                                }
                                if (isset ($checkbox['dminer_per_p'])) {
                                    $p = $cow[0]['dem_p'];
                                }
                                // --------------------
                                if (isset ($checkbox['dnut_cf'])) {
                                    $cf = $cow[0]['dem_cf']; //?
                                }
                                if (isset ($checkbox['dnut_nfe'])) {
                                    $nfe = $cow[0]['dem_nfe']; //?
                                }
                                if (isset ($checkbox['dmat_lys'])) {
                                    $lys = $cow[0]['dem_lys']; //?
                                }
                                if (isset ($checkbox['dmat_met'])) {
                                    $met = $cow[0]['dem_met']; //?
                                }
                            }
                        }
                    }


                    foreach ($mineral_sources as $ms) {
                        if (isset ($ms['checkbox']['checkbox_source_minerals'])) {
                            foreach ($ms['checkbox']['checkbox_source_minerals'] as $checkbox) {
                                if (isset ($checkbox['ds_vitA'])) {
                                    $a = $cow[0]['dem_vitA'];
                                }
                                if (isset ($checkbox['ds_vitD'])) {
                                    $d = $cow[0]['dem_vitD'];
                                }
                                if (isset ($checkbox['ds_vitE'])) {
                                    $e = $cow[0]['dem_vitE'];
                                }
                            }
                        }
                    }
                    ?>
                    <div class="table-responsive">
                        <table class="table table-light table-bordered">
                            <thead class="table-head text-center">
                                <tr>
                                    <th scope="col" class="p-3">รายการ</th>
                                    <th scope="col" class="p-3">ความต้องการโภชนะโค</th>
                                    <th scope="col" class="p-3">โภชนะของวัตถุดิบ</th>
                                    <th scope="col" class="p-3">ค่าความคาดเคลื่อน</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">


                                <?php if (isset ($tdn)): ?>
                                    <tr>
                                        <td>โภชนะที่ย่อยได้ทั้งหมด (TDN) (%)</td>
                                        <td>
                                            <?php echo $tdn; ?>
                                        </td>
                                        <td id="show-tdn"></td>
                                        <td id="show-tdn-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset ($de)): ?>
                                    <tr>
                                        <td>ค่าพลังงานที่ย่อยได้ (DE) (Mcal/kg)</td>
                                        <td>
                                            <?php echo $de; ?>
                                        </td>
                                        <td id="show-de"></td>
                                        <td id="show-de-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset ($me)): ?>
                                    <tr>
                                        <td>พลังงานที่ใช้ประโยชน์ได้ (ME) (Mcal/kg)</td>
                                        <td>
                                            <?php echo $me; ?>
                                        </td>
                                        <td id="show-me"></td>
                                        <td id="show-me-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset ($nel)): ?>
                                    <tr>
                                        <td>พลังงานสุทธิเพื่อการให้ผลผลิตน้ำนม (NEL) (Mcal/kg)</td>
                                        <td>
                                            <?php echo $nel; ?>
                                        </td>
                                        <td id="show-nel"></td>
                                        <td id="show-nel-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset ($adf)): ?>
                                    <tr>
                                        <td>เยื่อใยที่ไม่ละลายในสารฟอกที่เป็นกรด (ADF) (%)</td>
                                        <td>
                                            <?php echo $adf; ?>
                                        </td>
                                        <td id="show-adf"></td>
                                        <td id="show-adf-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset ($ndf)): ?>
                                    <tr>
                                        <td>เยื่อใยที่ไม่ละลายในสารฟอกที่เป็นกลาง (NDF) (%)</td>
                                        <td>
                                            <?php echo $ndf; ?>
                                        </td>
                                        <td id="show-ndf"></td>
                                        <td id="show-ndf-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset ($ee)): ?>
                                    <tr>
                                        <td>ไขมัน (EE) (%)</td>
                                        <td>
                                            <?php echo $ee; ?>
                                        </td>
                                        <td id="show-ee"></td>
                                        <td id="show-ee-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset ($cp)): ?>
                                    <tr>
                                        <td>โปรตีนรวม (CP) (%)</td>
                                        <td>
                                            <?php echo $cp; ?>
                                        </td>
                                        <td id="show-cp"></td>
                                        <td id="show-cp-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset ($rup)): ?>
                                    <tr>
                                        <td>โปรตีนที่ไม่ย่อยสลายในกระเพาะหมัก (RUP) (%)</td>
                                        <td>
                                            <?php echo $rup; ?>
                                        </td>
                                        <td id="show-rup"></td>
                                        <td id="show-rup-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset ($ca)): ?>
                                    <tr>
                                        <td>แคลเซียม (Ca) (%)</td>
                                        <td>
                                            <?php echo $ca; ?>
                                        </td>
                                        <td id="show-ca"></td>
                                        <td id="show-ca-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset ($p)): ?>
                                    <tr>
                                        <td>ฟอสฟอรัส (P) (%)</td>
                                        <td>
                                            <?php echo $p; ?>
                                        </td>
                                        <td id="show-p"></td>
                                        <td id="show-p-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset ($a)): ?>
                                    <tr>
                                        <td>วิตามิน A (IU/Kg)</td>
                                        <td>
                                            <?php echo $a; ?>
                                        </td>
                                        <td id="show-a"></td>
                                        <td id="show-a-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset ($d)): ?>
                                    <tr>
                                        <td>วิตามิน D (IU/Kg)</td>
                                        <td>
                                            <?php echo $d; ?>
                                        </td>
                                        <td id="show-d"></td>
                                        <td id="show-d-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset ($e)): ?>
                                    <tr>
                                        <td>วิตามิน E (IU/Kg)</td>
                                        <td>
                                            <?php echo $e; ?>
                                        </td>
                                        <td id="show-e"></td>
                                        <td id="show-e-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset ($cf)): ?>
                                    <tr>
                                        <td>CF</td>
                                        <td>
                                            <?php echo $cf; ?>
                                        </td>
                                        <td id="show-cf"></td>
                                        <td id="show-cf-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset ($nfe)): ?>
                                    <tr>
                                        <td>NFE</td>
                                        <td>
                                            <?php echo $nfe; ?>
                                        </td>
                                        <td id="show-nfe"></td>
                                        <td id="show-nfe-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset ($lys)): ?>
                                    <tr>
                                        <td>LYS</td>
                                        <td>
                                            <?php echo $lys; ?>
                                        </td>
                                        <td id="show-lys"></td>
                                        <td id="show-lys-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset ($met)): ?>
                                    <tr>
                                        <td>MET</td>
                                        <td>
                                            <?php echo $met; ?>
                                        </td>
                                        <td id="show-met"></td>
                                        <td id="show-met-2"></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
                    <div class="d-flex justify-content-center btn-more">
                        <div class="form-group">
                            <button type="reset" onclick="window.location='cost.php'"
                                class="btn btn-cancel">ย้อนกลับ</button>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-add confirm" data-bs-toggle="modal"
                                data-bs-target="#cancelModal">บันทึกข้อมูล</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="SaveModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="SaveModal">กรอกชื่อสูตรอาหาร</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="hidden-form" action="least_cost_group.php" method="post">
                        <div class="modal-body was-validated">
                            <div class="mb-3">
                                <input type="hidden" name="session_data"
                                    value="<?php echo htmlspecialchars($jsonData); ?>">

                                <input type="text" class="form-control" id="name-least" name="name_group" required
                                    pattern="[ก-๙a-zA-Z]+([ก-๙a-zA-Z0-9\s,\-\.\(\)]*)">
                                <label for="name-least" class="text-muted"
                                    style="font-size:0.9em;">จำเป็นต้องกรอกชื่อสูตรอาหารก่อนการบันทึกสูตร</label>

                                <input type="hidden" name="valuetotalTDN" id="valuetotalTDN" value="">
                                <input type="hidden" name="valuetotalDE" id="valuetotalDE" value="">
                                <input type="hidden" name="valuetotalME" id="valuetotalME" value="">
                                <input type="hidden" name="valuetotalNEL" id="valuetotalNEL" value="">
                                <input type="hidden" name="valuetotalCF" id="valuetotalCF" value="">
                                <input type="hidden" name="valuetotalADF" id="valuetotalADF" value="">
                                <input type="hidden" name="valuetotalNDF" id="valuetotalNDF" value="">
                                <input type="hidden" name="valuetotalNFE" id="valuetotalNFE" value="">
                                <input type="hidden" name="valuetotalCP" id="valuetotalCP" value="">
                                <input type="hidden" name="valuetotalRUP" id="valuetotalRUP" value="">
                                <input type="hidden" name="valuetotalLYS" id="valuetotalLYS" value="">
                                <input type="hidden" name="valuetotalMET" id="valuetotalMET" value="">
                                <input type="hidden" name="valuetotalCA" id="valuetotalCA" value="">
                                <input type="hidden" name="valuetotalP" id="valuetotalP" value="">
                                <input type="hidden" name="valuetotalVitaminA" id="valuetotalVitaminA" value="">
                                <input type="hidden" name="valuetotalVitaminD" id="valuetotalVitaminD" value="">
                                <input type="hidden" name="valuetotalVitaminE" id="valuetotalVitaminE" value="">
                                <input type="hidden" name="valuetotalEE" id="valuetotalEE" value="">

                                <input type="hidden" id="materialPrice" name="materialPrice" value="">
                                <input type="hidden" id="materialData" name="materialData" value="">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-more">
                                <button type="button" class="btn btn-secondary cancel"
                                    data-bs-dismiss="modal">ปิด</button>
                                <button class="btn btn-primary confirm" type="button" id="submit-button">บันทึก</button>
                            </div>
                        </div>
                    </form>
                </div>
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector("#menu a[href='cost.php']").classList.add("active");
        });
    </script>
    
    <script>
        const data = <?php echo json_encode($data); ?>;
        const materials = data.materials;
        const mineral_sources = data.mineral_sources;
        const cowdemand = data.cow_demand;
        let materialPrice = 0;
        const constraints = {};

        let hasDnutTdn = false;
        constraints.TDN = { min: 0, max: 1000 };

        let hasDnutDe = false;
        constraints.DE = { min: 0, max: 1000 };

        let hasDnutMe = false;
        constraints.ME = { min: 0, max: 1000 };

        let hasDnutNel = false;
        constraints.NEL = { min: 0, max: 1000 };

        let hasDnutCf = false;
        constraints.CF = { min: 0 };

        let hasDnutAdf = false;
        constraints.ADF = { min: 0, max: 1000 };

        let hasDnutNdf = false;
        constraints.NDF = { min: 0, max: 1000 };

        let hasDnutNfe = false;
        constraints.NFE = { min: 0 };

        let hasDnutCp = false;
        constraints.CP = { min: 0, max: 1000 };

        let hasDnutRup = false;
        constraints.RUP = { min: 0, max: 1000 };

        let hasDnutLys = false;
        constraints.LYS = { min: 0 };

        let hasDnutMet = false;
        constraints.MET = { min: 0 };

        let hasDnutCa = false;
        constraints.CA = { min: 0, max: 1000 };

        let hasDnutP = false;
        constraints.P = { min: 0, max: 1000 };

        let hasDnutVitaminA = false;
        constraints.VitaminA = { min: 0 };

        let hasDnutVitaminD = false;
        constraints.VitaminD = { min: 0 };

        let hasDnutVitaminE = false;
        constraints.VitaminE = { min: 0 };

        let hasDnutEE = false;
        constraints.EE = { min: 0, max: 1000 };


        if (cowdemand && cowdemand.length > 0) {
            cowdemand.forEach(cow => {
                if (materials && materials.length > 0) {
                    materials.forEach(material => {
                        if (material.checkbox && material.checkbox.checkboxALL && material.checkbox.checkboxALL.length > 0) {
                            const dnut_tdn = material.checkbox.checkboxALL.find(item => item.dnut_tdn);
                            const dnut_de = material.checkbox.checkboxALL.find(item => item.dnut_de);
                            const dnut_me = material.checkbox.checkboxALL.find(item => item.dnut_me);
                            const dnut_nel = material.checkbox.checkboxALL.find(item => item.dnut_nel);
                            const dnut_cf = material.checkbox.checkboxALL.find(item => item.dnut_cf);
                            const dnut_adf = material.checkbox.checkboxALL.find(item => item.dnut_adf);
                            const dnut_ndf = material.checkbox.checkboxALL.find(item => item.dnut_ndf);
                            const dnut_nfe = material.checkbox.checkboxALL.find(item => item.dnut_nfe);
                            const dnut_cp = material.checkbox.checkboxALL.find(item => item.dnut_cp);
                            const dnut_rup = material.checkbox.checkboxALL.find(item => item.dnut_rup);
                            const dnut_ee = material.checkbox.checkboxALL.find(item => item.dnut_ee);
                            const dmat_lys = material.checkbox.checkboxALL.find(item => item.dmat_lys);
                            const dmat_met = material.checkbox.checkboxALL.find(item => item.dmat_met);
                            const dminer_per_ca = material.checkbox.checkboxALL.find(item => item.dminer_per_ca);
                            const dminer_per_p = material.checkbox.checkboxALL.find(item => item.dminer_per_p);

                            if (dnut_tdn) {
                                constraints.TDN.min = isNaN(parseFloat(cow.dem_tdn)) ? 0 : parseFloat(cow.dem_tdn);
                                hasDnutTdn = true;
                            }
                            if (dnut_de) {
                                constraints.DE.min = isNaN(parseFloat(cow.dem_de)) ? 0 : parseFloat(cow.dem_de);
                                hasDnutDe = true;
                            }
                            if (dnut_me) {
                                constraints.ME.min = isNaN(parseFloat(cow.dem_me)) ? 0 : parseFloat(cow.dem_me);
                                hasDnutMe = true;
                            }
                            if (dnut_nel) {
                                constraints.NEL.min = isNaN(parseFloat(cow.dem_nel)) ? 0 : parseFloat(cow.dem_nel);
                                hasDnutNel = true;
                            }
                            if (dnut_cf) {
                                constraints.CF.min = 0;
                                hasDnutCf = true;
                            }
                            if (dnut_adf) {
                                constraints.ADF.min = isNaN(parseFloat(cow.dem_adf)) ? 0 : parseFloat(cow.dem_adf);
                                hasDnutAdf = true;
                            }
                            if (dnut_ndf) {
                                constraints.NDF.min = isNaN(parseFloat(cow.dem_ndf)) ? 0 : parseFloat(cow.dem_ndf);
                                hasDnutNdf = true;
                            }
                            if (dnut_nfe) {
                                constraints.NFE.min = 1000; //กำหนดค่าไว้ก่อน
                                hasDnutNfe = true;
                            }
                            if (dnut_cp) {
                                constraints.CP.min = isNaN(parseFloat(cow.dem_cp)) ? 0 : parseFloat(cow.dem_cp);
                                hasDnutCp = true;
                            }
                            if (dnut_rup) {
                                constraints.RUP.min = isNaN(parseFloat(cow.dem_rup)) ? 0 : parseFloat(cow.dem_rup);
                                hasDnutRup = true;
                            }
                            if (dnut_ee) {
                                constraints.EE.min = isNaN(parseFloat(cow.dem_fat)) ? 0 : parseFloat(cow.dem_fat);
                                hasDnutEE = true;
                            }

                            if (dmat_lys) {
                                constraints.LYS.min = 1000 //กำหนดค่าไว้ก่อน
                                hasDnutLys = true;
                            }
                            if (dmat_met) {
                                constraints.MET.min = 1000; //กำหนดค่าไว้ก่อน
                                hasDnutMet = true;
                            }

                            if (dminer_per_ca) {
                                constraints.CA.min = isNaN(parseFloat(cow.dem_ca)) ? 0 : parseFloat(cow.dem_ca);
                                hasDnutCa = true;
                            }
                            if (dminer_per_p) {
                                constraints.P.min = isNaN(parseFloat(cow.dem_p)) ? 0 : parseFloat(cow.dem_p);
                                hasDnutP = true;
                            }
                        }
                        if (material.checkbox && material.checkbox.checkbox_source_minerals && material.checkbox.checkbox_source_minerals.length > 0) {
                            const ds_ca = material.checkbox.checkbox_source_minerals.find(item => item.ds_ca);
                            const ds_p = material.checkbox.checkbox_source_minerals.find(item => item.ds_p);

                            const ds_vitA = material.checkbox.checkbox_source_minerals.find(item => item.ds_vitA);
                            const ds_vitD = material.checkbox.checkbox_source_minerals.find(item => item.ds_vitD);
                            const ds_vitE = material.checkbox.checkbox_source_minerals.find(item => item.ds_vitE);
                            if (ds_ca) {
                                constraints.CA.min = isNaN(parseFloat(cow.dem_ca)) ? 0 : parseFloat(cow.dem_ca);
                                hasDnutCa = true;
                            }
                            if (ds_p) {
                                constraints.P.min = isNaN(parseFloat(cow.dem_p)) ? 0 : parseFloat(cow.dem_p);
                                hasDnutP = true;
                            }
                            if (ds_vitA) {
                                constraints.VitaminA.min = isNaN(parseFloat(cow.dem_vitA)) ? 0 : parseFloat(cow.dem_vitA);
                                hasDnutVitaminA = true;
                            }
                            if (ds_vitD) {
                                constraints.VitaminD.min = isNaN(parseFloat(cow.dem_vitD)) ? 0 : parseFloat(cow.dem_vitD);
                                hasDnutVitaminD = true;
                            }
                            if (ds_vitE) {
                                constraints.VitaminE.min = isNaN(parseFloat(cow.dem_vitE)) ? 0 : parseFloat(cow.dem_vitE);
                                hasDnutVitaminE = true;
                            }
                        }
                    });
                }
            });
        }

        if (!hasDnutTdn) {
            constraints.TDN.min = 0;
        }
        if (!hasDnutDe) {
            constraints.DE.min = 0;
        }
        if (!hasDnutMe) {
            constraints.ME.min = 0;
        }
        if (!hasDnutNel) {
            constraints.NEL.min = 0;
        }
        if (!hasDnutCf) {
            constraints.CF.min = 0;
        }
        if (!hasDnutAdf) {
            constraints.ADF.min = 0;
        }
        if (!hasDnutNdf) {
            constraints.NDF.min = 0;
        }
        if (!hasDnutNfe) {
            constraints.NFE.min = 0;
        }
        if (!hasDnutCp) {
            constraints.CP.min = 0;
        }
        if (!hasDnutRup) {
            constraints.RUP.min = 0;
        }
        if (!hasDnutEE) {
            constraints.EE.min = 0;
        }
        if (!hasDnutLys) {
            constraints.LYS.min = 0;
        }
        if (!hasDnutMet) {
            constraints.MET.min = 0;
        }
        if (!hasDnutCa) {
            constraints.CA.min = 0;
        }
        if (!hasDnutP) {
            constraints.P.min = 0;
        }
        if (!hasDnutVitaminA) {
            constraints.VitaminA.min = 0;
        }
        if (!hasDnutVitaminD) {
            constraints.VitaminD.min = 0;
        }
        if (!hasDnutVitaminE) {
            constraints.VitaminE.min = 0;
        }
        if (!hasDnutEE) {
            constraints.EE.min = 0;
        }


        materials.forEach(material => {
            constraints[material.raw_thainame] = { max: material.max };
        });

        mineral_sources.forEach(source => {
            constraints[source.ms_thainame] = { max: source.max };
        });




        const variables = {};
        [...materials, ...mineral_sources].forEach(item => {
            const getAllMaterial = (key, collection) => {
                const item = collection.find(item => item.hasOwnProperty(key));
                return item && !isNaN(parseFloat(item[key])) ? parseFloat(item[key]) : 0;
            };

            const getMineralsValue = (key, collection) => {
                const item = collection.find(item => item.hasOwnProperty(key));
                return item && !isNaN(parseFloat(item[key])) ? parseFloat(item[key]) : 0;
            };
            const AllMaterial = item.checkbox.checkboxALL || [];
            const sourceMinerals = item.checkbox.checkbox_source_minerals || [];

            variables[item.raw_thainame || item.ms_thainame] = {
                TDN: getAllMaterial('dnut_tdn', AllMaterial),
                DE: getAllMaterial('dnut_de', AllMaterial),
                ME: getAllMaterial('dnut_me', AllMaterial),
                NEL: getAllMaterial('dnut_nel', AllMaterial),
                CF: getAllMaterial('dnut_cf', AllMaterial),
                ADF: getAllMaterial('dnut_adf', AllMaterial),
                NDF: getAllMaterial('dnut_ndf', AllMaterial),
                NFE: getAllMaterial('dnut_nfe', AllMaterial),
                CP: getAllMaterial('dnut_cp', AllMaterial),
                RUP: getAllMaterial('dnut_rup', AllMaterial),
                LYS: getAllMaterial('dmat_lys', AllMaterial),
                MET: getAllMaterial('dmat_met', AllMaterial),
                CA: getAllMaterial('dminer_per_ca', AllMaterial) || getMineralsValue('ds_ca', sourceMinerals),
                P: getAllMaterial('dminer_per_p', AllMaterial) || getMineralsValue('ds_p', sourceMinerals),
                VitaminA: getMineralsValue('ds_vitA', sourceMinerals),
                VitaminD: getMineralsValue('ds_vitD', sourceMinerals),
                VitaminE: getMineralsValue('ds_vitE', sourceMinerals),
                EE: getAllMaterial('dnut_ee', AllMaterial),
                cost: [item.price],
                [item.raw_thainame || item.ms_thainame]: item.min
            };
            // console.log(variables);
        });

        const model = {
            optimize: "cost",
            opType: "min",
            constraints: constraints,
            variables: variables,
        };

        const results = solver.Solve(model);
        console.log(results);

        if (results) {
            console.log("The solution is feasible and within bounds.");
            const least_cost = results.result;
            const materialsList = document.getElementById('material-table-body');
            const resultElements = materialsList.querySelectorAll('.results_key');
            let totalResult = 0;
            let resultKG = 0;
            let resultPriceKG = 0;
            let materialPrice = 0;
            resultElements.forEach((resultElement, index) => {
                const materialNameElement = resultElement.closest('tr').querySelector('.material-name');
                const materialName = materialNameElement.textContent.trim();

                materials.forEach((material) => {
                    if (material.raw_thainame === materialName) {
                        materialPrice = material.price;
                    }
                });
                mineral_sources.forEach((mineralSource) => {
                    if (mineralSource.ms_thainame === materialName) {
                        materialPrice = mineralSource.price;
                    }
                });
                if (results.hasOwnProperty(materialName)) {
                    const materialResult = results[materialName];
                    resultElement.textContent = materialResult.toFixed(3);
                    totalResult += materialResult;
                    // console.log(materialName, materialResult);

                    // const showPriceKGElement = resultElement.closest('tr').querySelector('.show_price_kg');
                    // const priceKG = materialResult * materialPrice;
                    // showPriceKGElement.textContent = priceKG.toFixed(3);
                    // console.log('test' + materialResult);

                } else {
                    resultElement.closest('tr').style.display = 'none'
                    // const materialResult = results[materialName];
                    // resultElement.textContent = '0';
                    // const showPriceElement = resultElement.closest('tr').querySelector('.show_price');
                    // showPriceElement.textContent = 0;
                }
            });
            // คำนวณเปอร์เซ็นต์ของผลลัพธ์แต่ละวัตถุดิบ
            resultElements.forEach((resultElement, index) => {
                const materialNameElement = resultElement.closest('tr').querySelector('.material-name');
                const materialName = materialNameElement.textContent.trim();

                materials.forEach((material) => {
                    if (material.raw_thainame === materialName) {
                        materialPrice = material.price;
                    }
                });
                mineral_sources.forEach((mineralSource) => {
                    if (mineralSource.ms_thainame === materialName) {
                        materialPrice = mineralSource.price;
                    }
                });

                const materialResult = parseFloat(resultElement.textContent.trim());
                const percent = (materialResult / totalResult) * 100;
                const showPercent = resultElement.closest('tr').querySelector('.percent');
                showPercent.textContent = percent.toFixed(3);

                const materialKG = percent / 100;
                const showMaterialKG = resultElement.closest('tr').querySelector('.materialKG');
                showMaterialKG.textContent = materialKG.toFixed(3);


                const demintake = materialKG * <?php echo $cow[0]['dem_intake']; ?>;
                const showIntake = resultElement.closest('tr').querySelector('.dem_intake');
                showIntake.textContent = demintake.toFixed(3);

                const showPriceElement = resultElement.closest('tr').querySelector('.show_price');
                // const showPriceKGElement = resultElement.closest('tr').querySelector('.show_price_kg');
                if (!isNaN(materialPrice) && isFinite(materialPrice)) {
                    const price = demintake * materialPrice;
                    // console.log(materialPrice);
                    showPriceElement.textContent = price.toFixed(3);
                    if (!isNaN(price)) {
                        resultKG += price;
                        document.getElementById('result').textContent = resultKG.toFixed(3);
                    }


                } else {
                    console.log(`Invalid material price for ${materialName}`);
                }

                const showPriceKGElement = resultElement.closest('tr').querySelector('.show_price_kg');
                const priceKG = materialKG * materialPrice;
                showPriceKGElement.textContent = priceKG.toFixed(3);
                // console.log('test' + materialResult);
                if (!isNaN(priceKG)) {
                    resultPriceKG += priceKG;
                    document.getElementById('result_kg').textContent = resultPriceKG.toFixed(3);
                }

                // const showPriceElement = resultElement.closest('tr').querySelector('.show_price');
                // const price = materialKG * materialPrice;
                // showPriceElement.textContent = price.toFixed(3);
                // resultKG += price;
            });

            const resultMaterials = {};
            let totalTDN = 0;
            let totalDE = 0;
            let totalME = 0;
            let totalNEL = 0;
            let totalCF = 0;
            let totalADF = 0;
            let totalNDF = 0;
            let totalNFE = 0;
            let totalCP = 0;
            let totalRUP = 0;
            let totalLYS = 0;
            let totalMET = 0;
            let totalCA = 0;
            let totalP = 0;
            let totalVitaminA = 0;
            let totalVitaminD = 0;
            let totalVitaminE = 0;
            let totalEE = 0;
            for (const materialName in variables) {
                if (variables.hasOwnProperty(materialName)) {
                    if (results.hasOwnProperty(materialName)) {
                        const totalResultForMaterial = results[materialName];
                        const materialData = variables[materialName];
                        resultMaterials[materialName] = {
                            TDN: materialData.TDN * totalResultForMaterial,
                            DE: materialData.DE * totalResultForMaterial,
                            ME: materialData.ME * totalResultForMaterial,
                            NEL: materialData.NEL * totalResultForMaterial,
                            CF: materialData.CF * totalResultForMaterial,
                            ADF: materialData.ADF * totalResultForMaterial,
                            NDF: materialData.NDF * totalResultForMaterial,
                            NFE: materialData.NFE * totalResultForMaterial,
                            CP: materialData.CP * totalResultForMaterial,
                            RUP: materialData.RUP * totalResultForMaterial,
                            LYS: materialData.LYS * totalResultForMaterial,
                            MET: materialData.MET * totalResultForMaterial,
                            CA: materialData.CA * totalResultForMaterial,
                            P: materialData.P * totalResultForMaterial,
                            VitaminA: materialData.VitaminA * totalResultForMaterial,
                            VitaminD: materialData.VitaminD * totalResultForMaterial,
                            VitaminE: materialData.VitaminE * totalResultForMaterial,
                            EE: materialData.EE * totalResultForMaterial,
                        };
                        totalTDN += resultMaterials[materialName].TDN;
                        totalDE += resultMaterials[materialName].DE;
                        totalME += resultMaterials[materialName].ME;
                        totalNEL += resultMaterials[materialName].NEL;
                        totalCF += resultMaterials[materialName].CF;
                        totalADF += resultMaterials[materialName].ADF;
                        totalNDF += resultMaterials[materialName].NDF;
                        totalNFE += resultMaterials[materialName].NFE;
                        totalCP += resultMaterials[materialName].CP;
                        totalRUP += resultMaterials[materialName].RUP;
                        totalLYS += resultMaterials[materialName].LYS;
                        totalMET += resultMaterials[materialName].MET;
                        totalCA += resultMaterials[materialName].CA;
                        totalP += resultMaterials[materialName].P;
                        totalVitaminA += resultMaterials[materialName].VitaminA;
                        totalVitaminD += resultMaterials[materialName].VitaminD;
                        totalVitaminE += resultMaterials[materialName].VitaminE;
                        totalEE += resultMaterials[materialName].EE;
                    }
                }
            }
            // console.log(totalTDN);
            // console.log(resultMaterials);

            // document.getElementById('show-nfe').textContent = 
            // document.getElementById('show-lys').textContent = 
            // document.getElementById('show-met').textContent = 

            // ฟังก์ชันสำหรับเช็คและแสดงผลข้อมูล
            $(document).ready(function () {
                // function checkAndDisplayData() {
                var materials = data.materials;
                var mineralSources = data.mineral_sources;
                if (cowdemand && cowdemand.length > 0) {
                    cowdemand.forEach((cow) => {
                        materials.forEach(function (material) {
                            if (material.checkbox.checkboxALL) {
                                material.checkbox.checkboxALL.forEach(function (checkbox) {
                                    if (checkbox.dnut_tdn !== undefined && checkbox.dnut_tdn !== null) {
                                        $("#show-tdn").text(totalTDN.toFixed(3));
                                        if (totalTDN == 0) {
                                            $("#show-tdn-2").text("ไม่มีข้อมูลวัตถุดิบที่มี TDN");
                                        } else {
                                            let cal = totalTDN - cow.dem_tdn;
                                            if (Math.abs(cal) < 0.001) {
                                                $("#show-tdn-2").text("เหมาะสม").css("color", "green");
                                            } else {
                                                $("#show-tdn-2").text(cal.toFixed(3));
                                                if (cal < 0) {
                                                    $("#show-tdn-2").css("color", "red");
                                                } else {
                                                    $("#show-tdn-2").css("color", "#c29200");
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.dnut_de !== undefined && checkbox.dnut_de !== null) {
                                        $("#show-de").text(totalDE.toFixed(3));
                                        if (totalDE == 0) {
                                            $("#show-de-2").text("ไม่มีข้อมูลวัตถุดิบที่มี DE");
                                        } else {
                                            let cal = totalDE - cow.dem_de;
                                            if (Math.abs(cal) < 0.001) {
                                                $("#show-de-2").text("เหมาะสม").css("color", "green");
                                            } else {
                                                $("#show-de-2").text(cal.toFixed(3));
                                                if (cal < 0) {
                                                    $("#show-de-2").css("color", "red");
                                                } else {
                                                    $("#show-de-2").css("color", "#c29200");
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.dnut_me !== undefined && checkbox.dnut_me !== null) {
                                        $("#show-me").text(totalME.toFixed(3));
                                        if (totalME == 0) {
                                            $("#show-me-2").text("ไม่มีข้อมูลวัตถุดิบที่มี ME");
                                        } else {
                                            let cal = totalME - cow.dem_me;
                                            if (Math.abs(cal) < 0.001) {
                                                $("#show-me-2").text("เหมาะสม").css("color", "green");
                                            } else {
                                                $("#show-me-2").text(cal.toFixed(3));
                                                if (cal < 0) {
                                                    $("#show-me-2").css("color", "red");
                                                } else {
                                                    $("#show-me-2").css("color", "#c29200");
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.dnut_nel !== undefined && checkbox.dnut_nel !== null) {
                                        $("#show-nel").text(totalNEL.toFixed(3));
                                        if (totalNEL == 0) {
                                            $("#show-nel-2").text("ไม่มีข้อมูลวัตถุดิบที่มี NEL");
                                        } else {
                                            let cal = totalNEL - cow.dem_nel;
                                            if (Math.abs(cal) < 0.001) {
                                                $("#show-nel-2").text("เหมาะสม").css("color", "green");
                                            } else {
                                                $("#show-nel-2").text(cal.toFixed(3));
                                                if (cal < 0) {
                                                    $("#show-nel-2").css("color", "red");
                                                } else {
                                                    $("#show-nel-2").css("color", "#c29200");
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.dnut_adf !== undefined && checkbox.dnut_adf !== null) {
                                        $("#show-adf").text(totalADF.toFixed(3));
                                        if (totalADF == 0) {
                                            $("#show-adf-2").text("ไม่มีข้อมูลวัตถุดิบที่มี ADF");
                                        } else {
                                            let cal = totalADF - cow.dem_adf;
                                            if (Math.abs(cal) < 0.001) {
                                                $("#show-adf-2").text("เหมาะสม").css("color", "green");
                                            } else {
                                                $("#show-adf-2").text(cal.toFixed(3));
                                                if (cal < 0) {
                                                    $("#show-adf-2").css("color", "red");
                                                } else {
                                                    $("#show-adf-2").css("color", "#c29200");
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.dnut_ndf !== undefined && checkbox.dnut_ndf !== null) {
                                        $("#show-ndf").text(totalNDF.toFixed(3));
                                        if (totalNDF == 0) {
                                            $("#show-ndf-2").text("ไม่มีข้อมูลวัตถุดิบที่มี NDF");
                                        } else {
                                            let cal = totalNDF - cow.dem_ndf;
                                            if (Math.abs(cal) < 0.001) {
                                                $("#show-ndf-2").text("เหมาะสม").css("color", "green");
                                            } else {
                                                $("#show-ndf-2").text(cal.toFixed(3));
                                                if (cal < 0) {
                                                    $("#show-ndf-2").css("color", "red");
                                                } else {
                                                    $("#show-ndf-2").css("color", "#c29200");
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.dnut_ee !== undefined && checkbox.dnut_ee !== null) {
                                        $("#show-ee").text(totalEE.toFixed(3));
                                        if (totalEE == 0) {
                                            $("#show-ee-2").text("ไม่มีข้อมูลวัตถุดิบที่มี EE");
                                        } else {
                                            let cal = totalEE - cow.dem_fat;
                                            if (Math.abs(cal) < 0.001) {
                                                $("#show-ee-2").text("เหมาะสม").css("color", "green");
                                            } else {
                                                $("#show-ee-2").text(cal.toFixed(3));
                                                if (cal < 0) {
                                                    $("#show-ee-2").css("color", "red");
                                                } else {
                                                    $("#show-ee-2").css("color", "#c29200");
                                                }
                                            }
                                        }
                                    }

                                    if (checkbox.dnut_cp !== undefined && checkbox.dnut_cp !== null) {
                                        $("#show-cp").text(totalCP.toFixed(3));
                                        if (totalCP == 0) {
                                            $("#show-cp-2").text("ไม่มีข้อมูลวัตถุดิบที่มี CP");
                                        } else {
                                            let cal = totalCP - cow.dem_cp;
                                            if (Math.abs(cal) < 0.001) {
                                                $("#show-cp-2").text("เหมาะสม").css("color", "green");
                                            } else {
                                                $("#show-cp-2").text(cal.toFixed(3));
                                                if (cal < 0) {
                                                    $("#show-cp-2").css("color", "red");
                                                } else {
                                                    $("#show-cp-2").css("color", "#c29200");
                                                }
                                            }
                                        }
                                    }

                                    if (checkbox.dnut_rup !== undefined && checkbox.dnut_rup !== null) {
                                        $("#show-rup").text(totalRUP.toFixed(3));
                                        if (totalRUP == 0) {
                                            $("#show-rup-2").text("ไม่มีข้อมูลวัตถุดิบที่มี RUP");
                                        } else {
                                            let cal = totalRUP - cow.dem_rup;
                                            if (Math.abs(cal) < 0.001) {
                                                $("#show-rup-2").text("เหมาะสม").css("color", "green");
                                            } else {
                                                $("#show-rup-2").text(cal.toFixed(3));
                                                if (cal < 0) {
                                                    $("#show-rup-2").css("color", "red");
                                                } else {
                                                    $("#show-rup-2").css("color", "#c29200");
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.dnut_cf !== undefined && checkbox.dnut_cf !== null) {
                                        $("#show-cf").text(totalCF.toFixed(3));
                                        if (totalCF == 0) {
                                            $("#show-cf-2").text("ไม่มีข้อมูลวัตถุดิบที่มี CF");
                                        } else {
                                            let cal = totalCF - cow.dem_cf;
                                            if (Math.abs(cal) < 0.001) {
                                                $("#show-cf-2").text("เหมาะสม").css("color", "green");
                                            } else {
                                                $("#show-cf-2").text(cal.toFixed(3));
                                                if (cal < 0) {
                                                    $("#show-cf-2").css("color", "red");
                                                } else {
                                                    $("#show-cf-2").css("color", "#c29200");
                                                }
                                            }
                                        }
                                    }

                                    if (checkbox.dnut_nfe !== undefined && checkbox.dnut_nfe !== null) {
                                        $("#show-nfe").text(totalNFE.toFixed(3));
                                        if (totalNFE == 0) {
                                            $("#show-nfe-2").text("ไม่มีข้อมูลวัตถุดิบที่มี NFE");
                                        } else {
                                            let cal = totalNFE - cow.dem_nfe;
                                            if (Math.abs(cal) < 0.001) {
                                                $("#show-nfe-2").text("เหมาะสม").css("color", "green");
                                            } else {
                                                $("#show-nfe-2").text(cal.toFixed(3));
                                                if (cal < 0) {
                                                    $("#show-nfe-2").css("color", "red");
                                                } else {
                                                    $("#show-nfe-2").css("color", "#c29200");
                                                }
                                            }
                                        }
                                    }

                                    if (checkbox.dmat_lys !== undefined && checkbox.dmat_lys !== null) {
                                        $("#show-lys").text(totalLYS.toFixed(3));
                                        if (totalLYS == 0) {
                                            $("#show-lys-2").text("ไม่มีข้อมูลวัตถุดิบที่มี LYS");
                                        } else {
                                            let cal = totalLYS - cow.dem_lys;
                                            if (Math.abs(cal) < 0.001) {
                                                $("#show-lys-2").text("เหมาะสม").css("color", "green");
                                            } else {
                                                $("#show-lys-2").text(cal.toFixed(3));
                                                if (cal < 0) {
                                                    $("#show-lys-2").css("color", "red");
                                                } else {
                                                    $("#show-lys-2").css("color", "#c29200");
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.dmat_met !== undefined && checkbox.dmat_met !== null) {
                                        $("#show-met").text(totalMET.toFixed(3));
                                        if (totalMET == 0) {
                                            $("#show-met-2").text("ไม่มีข้อมูลวัตถุดิบที่มี MET");
                                        } else {
                                            let cal = totalMET - cow.dem_met;
                                            if (Math.abs(cal) < 0.001) {
                                                $("#show-met-2").text("เหมาะสม").css("color", "green");
                                            } else {
                                                $("#show-met-2").text(cal.toFixed(3));
                                                if (cal < 0) {
                                                    $("#show-met-2").css("color", "red");
                                                } else {
                                                    $("#show-met-2").css("color", "#c29200");
                                                }
                                            }
                                        }
                                    }
                                });
                            }
                        });

                        mineralSources.forEach(function (mineral) {
                            if (mineral.checkbox.checkbox_source_minerals) {
                                mineral.checkbox.checkbox_source_minerals.forEach(function (
                                    checkbox
                                ) {
                                    if (checkbox.ds_ca !== undefined && checkbox.ds_ca !== null) {
                                        $("#show-ca").text(totalCA.toFixed(3));
                                        if (totalCA == 0) {
                                            $("#show-ca-2").text("ไม่มีข้อมูลวัตถุดิบที่มี CA");
                                        } else {
                                            let cal = totalCA - cow.dem_ca;
                                            if (Math.abs(cal) < 0.001) {
                                                $("#show-ca-2").text("เหมาะสม").css("color", "green");
                                            } else {
                                                $("#show-ca-2").text(cal.toFixed(3));
                                                if (cal < 0) {
                                                    $("#show-ca-2").css("color", "red");
                                                } else {
                                                    $("#show-ca-2").css("color", "#c29200");
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.ds_p !== undefined && checkbox.ds_p !== null) {
                                        $("#show-p").text(totalP.toFixed(3));
                                        if (totalP == 0) {
                                            $("#show-p-2").text("ไม่มีข้อมูลวัตถุดิบที่มี P");
                                        } else {
                                            let cal = totalP - cow.dem_p;
                                            if (Math.abs(cal) < 0.001) {
                                                $("#show-p-2").text("เหมาะสม").css("color", "green");
                                            } else {
                                                $("#show-p-2").text(cal.toFixed(3));
                                                if (cal < 0) {
                                                    $("#show-p-2").css("color", "red");
                                                } else {
                                                    $("#show-p-2").css("color", "#c29200");
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.ds_vitA !== undefined && checkbox.ds_vitA !== null) {
                                        $("#show-a").text(totalVitaminA.toFixed(3));
                                        if (totalVitaminA == 0) {
                                            $("#show-a-2").text("ไม่มีข้อมูลวัตถุดิบที่มี Vit A");
                                        } else {
                                            let cal = totalVitaminA - cow.dem_vitA;
                                            if (Math.abs(cal) < 0.001) {
                                                $("#show-a-2").text("เหมาะสม").css("color", "green");
                                            } else {
                                                $("#show-a-2").text(cal.toFixed(3));
                                                if (cal < 0) {
                                                    $("#show-a-2").css("color", "red");
                                                } else {
                                                    $("#show-a-2").css("color", "#c29200");
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.ds_vitD !== undefined && checkbox.ds_vitD !== null) {
                                        $("#show-d").text(totalVitaminD.toFixed(3));
                                        if (totalVitaminD == 0) {
                                            $("#show-d-2").text("ไม่มีข้อมูลวัตถุดิบที่มี Vit D");
                                        } else {
                                            let cal = totalVitaminD - cow.dem_vitD;
                                            if (Math.abs(cal) < 0.001) {
                                                $("#show-d-2").text("เหมาะสม").css("color", "green");
                                            } else {
                                                $("#show-d-2").text(cal.toFixed(3));
                                                if (cal < 0) {
                                                    $("#show-d-2").css("color", "red");
                                                } else {
                                                    $("#show-d-2").css("color", "#c29200");
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.ds_vitE !== undefined && checkbox.ds_vitE !== null) {
                                        $("#show-e").text(totalVitaminE.toFixed(3));
                                        if (totalVitaminE == 0) {
                                            $("#show-e-2").text("ไม่มีข้อมูลวัตถุดิบที่มี Vit E");
                                        } else {
                                            let cal = totalVitaminE - cow.dem_vitE;
                                            if (Math.abs(cal) < 0.001) {
                                                $("#show-e-2").text("เหมาะสม").css("color", "green");
                                            } else {
                                                $("#show-e-2").text(cal.toFixed(3));
                                                if (cal < 0) {
                                                    $("#show-e-2").css("color", "red");
                                                } else {
                                                    $("#show-e-2").css("color", "#c29200");
                                                }
                                            }
                                        }
                                    }
                                });
                            }
                        });
                    });
                }
                // }

                // ใช้ jQuery syntax ในการเรียกใช้ฟังก์ชัน checkAndDisplayData() เมื่อ DOM โหลดเสร็จ
                // $(document).ready(function () {
                // checkAndDisplayData();
            });

            var materialData = [];
            resultElements.forEach((resultElement, index) => {
                const materialNameElement = resultElement.closest('tr').querySelector('.material-name');
                const materialName = materialNameElement.textContent.trim();
                const materialResult = parseFloat(resultElement.textContent.trim());
                const percent = ((materialResult / totalResult) * 100).toFixed(3);
                const materialKG = (percent / 100).toFixed(3);
                const showMaterialKG = resultElement.closest('tr').querySelector('.materialKG').textContent.trim();
                const price = parseFloat(resultElement.closest('tr').querySelector('.show_price').textContent.trim());
                const demintake = parseFloat(resultElement.closest('tr').querySelector('.dem_intake').textContent.trim());
                let materialPrice = 0;
                materials.forEach((material) => {
                    if (material.raw_thainame === materialName) {
                        materialPrice = material.price;
                    }
                });
                mineral_sources.forEach((mineralSource) => {
                    if (mineralSource.ms_thainame === materialName) {
                        materialPrice = mineralSource.price;
                    }
                });
                document.getElementById("materialPrice").value = materialPrice;
                materialData.push({
                    // materialID : materialID,
                    materialName: materialName,
                    materialResult: materialResult,
                    percent: percent,
                    showMaterialKG: showMaterialKG,
                    price: price,
                    materialPrice: materialPrice,
                    demintake: demintake
                });
            });
            document.getElementById("submit-button").addEventListener("click", function () {
                var values = {
                    valuetotalTDN: totalTDN,
                    valuetotalDE: totalDE,
                    valuetotalME: totalME,
                    valuetotalNEL: totalNEL,
                    valuetotalCF: totalCF,
                    valuetotalADF: totalADF,
                    valuetotalNDF: totalNDF,
                    valuetotalNFE: totalNFE,
                    valuetotalCP: totalCP,
                    valuetotalRUP: totalRUP,
                    valuetotalLYS: totalLYS,
                    valuetotalMET: totalMET,
                    valuetotalCA: totalCA,
                    valuetotalP: totalP,
                    valuetotalVitaminA: totalVitaminA,
                    valuetotalVitaminD: totalVitaminD,
                    valuetotalVitaminE: totalVitaminE,
                    valuetotalEE: totalEE,
                    materialData: JSON.stringify(materialData) // แปลงข้อมูลเป็น JSON string
                };
                Object.keys(values).forEach(function (key) {
                    document.getElementById(key).value = values[key];
                });
                if (!validateForm()) {
                    return;
                }
                document.getElementById("hidden-form").submit();

                function validateForm() {
                    var nameLeast = document.getElementById("name-least").value.trim();
                    if (nameLeast === "") {
                        return false;
                    }
                    return true;
                }
            });
        } else {
            console.log("The solution is infeasible or not within bounds.");
        }
    </script>
</body>

</html>