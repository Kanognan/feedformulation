<?php
session_start();
include "../server.php";
?>
<?php require "../session/user_session.php"; ?>
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
    <title>คำนวณต้นทุน</title>
	 <link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
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
                padding-left: 7em !important;
            }
        }
    </style>
</head>

<body>
    <?php
    $jsonData = isset($_SESSION['jsonData']) ? $_SESSION['jsonData'] : '';
    $data = json_decode($jsonData, true);
    $materials = $data['materials'];
    $mineral_sources = $data['mineral_sources'];
    $cow = $data['cow_demand'];
    ?>
    <div class="flex">
        <div class="g-1">
            <?php include('sidebar.php') ?>
        </div>
        <div class="g-2">
            <div class="content">
                <h2 class="text-center mb-5 mt-3">คำนวณต้นทุน</h2>
                <div class="table-scrollable ">
                    <h4>ผลลัพธ์สำหรับปริมาณอาหาร 1 กิโลกรัม</h4>
                    <table class="table table-light table-bordered table-responsive">
                        <thead class="table-head text-center">
                            <tr>
                                <th scope="col" class="p-3">รายการวัตถุดิบ</th>
                                <th scope="col" class="p-3">จำนวนที่ใช้ (%)</th>
                                <th scope="col" class="p-3">จำนวนที่ใช้ (กก.)</th>
                                <th scope="col" class="p-3">ราคาต่อหน่วย (บาท/กก.)</th>
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
                                    <td class="results_key" hidden></td>
                                    <td>
                                        <?php echo $material['price']; ?>
                                    </td>
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
                                    <td class="results_key" hidden></td>
                                    <td>
                                        <?php echo $ms['price']; ?>
                                    </td>
                                    <td class="show_price"></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="text-center table-secondary">
                                <th scope="row" colspan="" class="">รวม</th>
                                <th scope="row" colspan="" class="">100%</th>
                                <th scope="row" colspan="" class="">1 กก.</th>
                                <th scope="row" colspan="" class="">#</th>
                                <th class="text-center" id="result">0</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- <p id="show-tdn"></p> -->
                <div>
                    <h4 class="mt-5">คุณค่าทางโภชนะของ
                        <?php echo $cow[0]['dem_name']; ?>
                    </h4>
                    <form method="post" action="least_cost_group.php" id="myForm">
                        <?php

                        foreach ($materials as $material) {
                            if (isset($material['checkbox']['checkboxALL'])) {
                                foreach ($material['checkbox']['checkboxALL'] as $checkbox) {
                                    if (isset($checkbox['dnut_tdn'])) {
                                        $tdn = $cow[0]['dem_tdn'];
                                    }
                                    if (isset($checkbox['dnut_de'])) {
                                        $de = $cow[0]['dem_de'];
                                    }
                                    if (isset($checkbox['dnut_me'])) {
                                        $me = $cow[0]['dem_me'];
                                    }
                                    if (isset($checkbox['dnut_nel'])) {
                                        $nel = $cow[0]['dem_nel'];
                                    }
                                    if (isset($checkbox['dnut_adf'])) {
                                        $adf = $cow[0]['dem_adf'];
                                    }
                                    if (isset($checkbox['dnut_ndf'])) {
                                        $ndf = $cow[0]['dem_ndf'];
                                    }
                                    if (isset($checkbox['dnut_cp'])) {
                                        $cp = $cow[0]['dem_cp'];
                                    }
                                    if (isset($checkbox['dnut_rup'])) {
                                        $rup = $cow[0]['dem_rup'];
                                    }
                                    if (isset($checkbox['dnut_ee'])) {
                                        $ee = $cow[0]['dem_fat'];
                                    }
                                    if (isset($checkbox['dminer_per_ca'])) {
                                        $ca = $cow[0]['dem_ca'];
                                    }
                                    if (isset($checkbox['dminer_per_p'])) {
                                        $p = $cow[0]['dem_p'];
                                    }
                                    // --------------------
                                    if (isset($checkbox['dnut_cf'])) {
                                        $cf = $cow[0]['dem_cf']; //?
                                    }
                                    if (isset($checkbox['dnut_nfe'])) {
                                        $nfe = $cow[0]['dem_nfe']; //?
                                    }
                                    if (isset($checkbox['dmat_lys'])) {
                                        $lys = $cow[0]['dem_lys']; //?
                                    }
                                    if (isset($checkbox['dmat_met'])) {
                                        $met = $cow[0]['dem_met']; //?
                                    }
                                }
                            }
                        }


                        foreach ($mineral_sources as $ms) {
                            if (isset($ms['checkbox']['checkbox_source_minerals'])) {
                                foreach ($ms['checkbox']['checkbox_source_minerals'] as $checkbox) {
                                    if (isset($checkbox['ds_vitA'])) {
                                        $a = $cow[0]['dem_vitA'];
                                    }
                                    if (isset($checkbox['ds_vitD'])) {
                                        $d = $cow[0]['dem_vitD'];
                                    }
                                    if (isset($checkbox['ds_vitE'])) {
                                        $e = $cow[0]['dem_vitE'];
                                    }
                                }
                            }
                        }
                        ?>

                        <table class="table table-light table-bordered table-responsive">
                            <thead class="table-head text-center">
                                <tr>
                                    <th scope="col" class="p-3">รายการ</th>
                                    <th scope="col" class="p-3">ความต้องการโภชนะโค</th>
                                    <th scope="col" class="p-3">โภชนะของวัตถุดิบ</th>
                                    <th scope="col" class="p-3">ค่าความคาดเคลื่อน</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php if (isset($lys)): ?>
                                    <input type="hidden" name="tdn_id" id="tdn_id" value="<?php echo $tdn_id; ?>">
                                    <tr>
                                        <td>โภชนะที่ย่อยได้ทั้งหมด (TDN)</td>
                                        <td>
                                            <?php echo $tdn; ?>
                                        </td>
                                        <td id="show-tdn"></td>
                                        <td id="show-tdn-2"></td>
                                    </tr>
                                <?php endif; ?>

                                <!-- <?php if (isset($tdn)): ?>
                                    <tr>
                                        <td>โภชนะที่ย่อยได้ทั้งหมด (TDN)</td>
                                        <td>
                                            <?php echo $tdn; ?>
                                        </td>
                                        <td id="show-tdn"></td>
                                        <td id="show-tdn-2"></td>
                                    </tr>
                                <?php endif; ?> -->
                                <?php if (isset($de)): ?>
                                    <tr>
                                        <td>ค่าพลังงานที่ย่อยได้ (DE)</td>
                                        <td>
                                            <?php echo $de; ?>
                                        </td>
                                        <td id="show-de"></td>
                                        <td id="show-de-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset($me)): ?>
                                    <tr>
                                        <td>พลังงานที่ใช้ประโยชน์ได้ (ME)</td>
                                        <td>
                                            <?php echo $me; ?>
                                        </td>
                                        <td id="show-me"></td>
                                        <td id="show-me-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset($nel)): ?>
                                    <tr>
                                        <td>พลังงานสุทธิเพื่อการให้ผลผลิตน้ำนม (NEL)</td>
                                        <td>
                                            <?php echo $nel; ?>
                                        </td>
                                        <td id="show-nel"></td>
                                        <td id="show-nel-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset($adf)): ?>
                                    <tr>
                                        <td>เยื่อใยที่ไม่ละลายในสารฟอกที่เป็นกรด (ADF)</td>
                                        <td>
                                            <?php echo $adf; ?>
                                        </td>
                                        <td id="show-adf"></td>
                                        <td id="show-adf-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset($ndf)): ?>
                                    <tr>
                                        <td>เยื่อใยที่ไม่ละลายในสารฟอกที่เป็นกลาง (NDF)</td>
                                        <td>
                                            <?php echo $ndf; ?>
                                        </td>
                                        <td id="show-ndf"></td>
                                        <td id="show-ndf-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset($ee)): ?>
                                    <tr>
                                        <td>ไขมัน (EE)</td>
                                        <td>
                                            <?php echo $ee; ?>
                                        </td>
                                        <td id="show-ee"></td>
                                        <td id="show-ee-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset($cp)): ?>
                                    <tr>
                                        <td>โปรตีนรวม (CP)</td>
                                        <td>
                                            <?php echo $cp; ?>
                                        </td>
                                        <td id="show-cp"></td>
                                        <td id="show-cp-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset($rup)): ?>
                                    <tr>
                                        <td>โปรตีนที่ไม่ย่อยสลายในกระเพาะหมัก (RUP)</td>
                                        <td>
                                            <?php echo $rup; ?>
                                        </td>
                                        <td id="show-rup"></td>
                                        <td id="show-rup-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset($ca)): ?>
                                    <tr>
                                        <td>แคลเซียม (Ca)</td>
                                        <td>
                                            <?php echo $ca; ?>
                                        </td>
                                        <td id="show-ca"></td>
                                        <td id="show-ca-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset($p)): ?>
                                    <tr>
                                        <td>ฟอสฟอรัส (P)</td>
                                        <td>
                                            <?php echo $p; ?>
                                        </td>
                                        <td id="show-p"></td>
                                        <td id="show-p-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset($a)): ?>
                                    <tr>
                                        <td>วิตามิน A</td>
                                        <td>
                                            <?php echo $a; ?>
                                        </td>
                                        <td id="show-a"></td>
                                        <td id="show-a-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset($d)): ?>
                                    <tr>
                                        <td>วิตามิน D</td>
                                        <td>
                                            <?php echo $d; ?>
                                        </td>
                                        <td id="show-d"></td>
                                        <td id="show-d-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset($e)): ?>
                                    <tr>
                                        <td>วิตามิน E</td>
                                        <td>
                                            <?php echo $e; ?>
                                        </td>
                                        <td id="show-e"></td>
                                        <td id="show-e-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset($cf)): ?>
                                    <tr>
                                        <td>CF</td>
                                        <td>
                                            <?php echo $cf; ?>
                                        </td>
                                        <td id="show-cf"></td>
                                        <td id="show-cf-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset($nfe)): ?>
                                    <tr>
                                        <td>NFE</td>
                                        <td>
                                            <?php echo $nfe; ?>
                                        </td>
                                        <td id="show-nfe"></td>
                                        <td id="show-nfe-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset($lys)): ?>
                                    <tr>
                                        <td>LYS</td>
                                        <td>
                                            <?php echo $lys; ?>
                                        </td>
                                        <td id="show-lys"></td>
                                        <td id="show-lys-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset($met)): ?>
                                    <tr>
                                        <td>MET</td>
                                        <td>
                                            <?php echo $met; ?>
                                        </td>
                                        <td id="show-met"></td>
                                        <td id="show-met-2"></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td>ปริมาณการกินได้น้ำหนักแห้ง (Intake) (กก./วัน)</td>
                                    <td>
                                        <?php echo $cow[0]['dem_intake']; ?>
                                    </td>
                                    <td></td>
                                    <td id="show"></td>
                                </tr>
                            </tbody>
                            <!-- <tfoot>
                            <tr class="text-center table-secondary">
                                <th scope="row" colspan="" class="">รวม</th>
                                <th scope="row" colspan="" class="">100%</th>
                                <th scope="row" colspan="" class="">1 กก.</th>
                            </tr>
                        </tfoot> -->
                        </table>
                        <div>
                            <div class="d-flex justify-content-center btn-more">
                                <div class="form-group">
                                    <button type="reset" onclick="window.location='cost.php'"
                                        class="btn btn-cancel">ย้อนกลับ</button>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-add confirm" type="button" value="Submit"
                                        onclick="submitForm()">บันทึกข้อมูล</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- <h1>Data Display</h1>
                <pre>
                    <?php
                    //echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    ?>
                </pre> -->

            </div>
        </div>
    </div>


    <script>
        $(function () {
            $('#table').bootstrapTable()
        })
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

            resultElements.forEach((resultElement, index) => {
                const materialNameElement = resultElement.closest('tr').querySelector('.material-name');
                const materialName = materialNameElement.textContent.trim();
                materials.forEach((material) => {
                    if (material.raw_thainame === materialName) {
                        materialPrice = material.price;
                    }
                    if (material.ms_thainame === materialName) {
                        materialPrice = mineral_sources.price;
                    }
                });
                if (results.hasOwnProperty(materialName)) {
                    const materialResult = results[materialName];
                    resultElement.textContent = materialResult.toFixed(3);
                    totalResult += materialResult;
                    console.log(materialName, materialResult);

                    // const showPriceElement = resultElement.closest('tr').querySelector('.show_price');
                    // const price = materialResult * materialPrice;
                    // showPriceElement.textContent = price.toFixed(3);

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
                const materialResult = parseFloat(resultElement.textContent.trim());
                const percent = (materialResult / totalResult) * 100;
                const showPercent = resultElement.closest('tr').querySelector('.percent');
                showPercent.textContent = percent.toFixed(3);

                const materialKG = percent / 100;
                const showMaterialKG = resultElement.closest('tr').querySelector('.materialKG');
                showMaterialKG.textContent = materialKG.toFixed(3);

                const showPriceElement = resultElement.closest('tr').querySelector('.show_price');
                if (!isNaN(materialPrice) && isFinite(materialPrice)) {
                    const price = materialKG * materialPrice;
                    showPriceElement.textContent = price.toFixed(3);
                    if (!isNaN(price)) {
                        resultKG += price;
                        // console.log(resultKG);
                        document.getElementById('result').textContent = resultKG.toFixed(3);
                    }
                } else {
                    console.log(`Invalid material price for ${materialName}`);
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
            console.log(resultMaterials);

            // document.getElementById('show-nfe').textContent = 
            // document.getElementById('show-lys').textContent = 
            // document.getElementById('show-met').textContent = 

            // ฟังก์ชันสำหรับเช็คและแสดงผลข้อมูล
            function checkAndDisplayData() {
                var materials = data.materials;
                var mineralSources = data.mineral_sources;
                if (cowdemand && cowdemand.length > 0) {
                    cowdemand.forEach(cow => {
                        materials.forEach(function (material) {
                            if (material.checkbox.checkboxALL) {
                                material.checkbox.checkboxALL.forEach(function (checkbox) {
                                    if (checkbox.dnut_tdn !== undefined && checkbox.dnut_tdn !== null) {
                                        document.getElementById('show-tdn').textContent = totalTDN.toFixed(3);
                                        if (totalTDN == 0) {
                                            document.getElementById('show-tdn-2').textContent = 'ไม่มีข้อมูลวัตถุดิบที่มี TDN';
                                        } else {
                                            let cal = totalTDN - cow.dem_tdn;
                                            if (Math.abs(cal) < 0.001) {
                                                document.getElementById('show-tdn-2').textContent = 'สมบูรณ์';
                                                document.getElementById('show-tdn-2').style.color = 'green';
                                            } else {
                                                document.getElementById('show-tdn-2').textContent = cal.toFixed(3);
                                                if (cal < 0) {
                                                    document.getElementById('show-tdn-2').style.color = 'red';
                                                } else {
                                                    document.getElementById('show-tdn-2').style.color = '#c29200';
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.dnut_de !== undefined && checkbox.dnut_de !== null) {
                                        document.getElementById('show-de').textContent = totalDE.toFixed(3);
                                        if (totalDE == 0) {
                                            document.getElementById('show-de-2').textContent = 'ไม่มีข้อมูลวัตถุดิบที่มี DE';
                                        } else {
                                            let cal = totalDE - cow.dem_de;
                                            if (Math.abs(cal) < 0.001) {
                                                document.getElementById('show-de-2').textContent = 'สมบูรณ์';
                                                document.getElementById('show-de-2').style.color = 'green';
                                            } else {
                                                document.getElementById('show-de-2').textContent = cal.toFixed(3);
                                                if (cal < 0) {
                                                    document.getElementById('show-de-2').style.color = 'red';
                                                } else {
                                                    document.getElementById('show-de-2').style.color = '#c29200';
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.dnut_me !== undefined && checkbox.dnut_me !== null) {
                                        document.getElementById('show-me').textContent = totalME.toFixed(3);
                                        if (totalME == 0) {
                                            document.getElementById('show-me-2').textContent = 'ไม่มีข้อมูลวัตถุดิบที่มี ME';
                                        } else {
                                            let cal = totalME - cow.dem_me;
                                            if (Math.abs(cal) < 0.001) {
                                                document.getElementById('show-me-2').textContent = 'สมบูรณ์';
                                                document.getElementById('show-me-2').style.color = 'green';
                                            } else {
                                                document.getElementById('show-me-2').textContent = cal.toFixed(3);
                                                if (cal < 0) {
                                                    document.getElementById('show-me-2').style.color = 'red';
                                                } else {
                                                    document.getElementById('show-me-2').style.color = '#c29200';
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.dnut_nel !== undefined && checkbox.dnut_nel !== null) {
                                        document.getElementById('show-nel').textContent = totalNEL.toFixed(3);
                                        if (totalNEL == 0) {
                                            document.getElementById('show-nel-2').textContent = 'ไม่มีข้อมูลวัตถุดิบที่มี NEL';
                                        } else {
                                            let cal = totalNEL - cow.dem_nel;
                                            if (Math.abs(cal) < 0.001) {
                                                document.getElementById('show-nel-2').textContent = 'สมบูรณ์';
                                                document.getElementById('show-nel-2').style.color = 'green';
                                            } else {
                                                document.getElementById('show-nel-2').textContent = cal.toFixed(3);
                                                if (cal < 0) {
                                                    document.getElementById('show-nel-2').style.color = 'red';
                                                } else {
                                                    document.getElementById('show-nel-2').style.color = '#c29200';
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.dnut_adf !== undefined && checkbox.dnut_adf !== null) {
                                        document.getElementById('show-adf').textContent = totalADF.toFixed(3);
                                        if (totalADF == 0) {
                                            document.getElementById('show-adf-2').textContent = 'ไม่มีข้อมูลวัตถุดิบที่มี ADF';
                                        } else {
                                            let cal = totalADF - cow.dem_adf;
                                            if (Math.abs(cal) < 0.001) {
                                                document.getElementById('show-adf-2').textContent = 'สมบูรณ์';
                                                document.getElementById('show-adf-2').style.color = 'green';
                                            } else {
                                                document.getElementById('show-adf-2').textContent = cal.toFixed(3);
                                                if (cal < 0) {
                                                    document.getElementById('show-adf-2').style.color = 'red';
                                                } else {
                                                    document.getElementById('show-adf-2').style.color = '#c29200';
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.dnut_ndf !== undefined && checkbox.dnut_ndf !== null) {
                                        document.getElementById('show-ndf').textContent = totalNDF.toFixed(3);
                                        if (totalNDF == 0) {
                                            document.getElementById('show-ndf-2').textContent = 'ไม่มีข้อมูลวัตถุดิบที่มี NDF';
                                        } else {
                                            let cal = totalNDF - cow.dem_ndf;
                                            if (Math.abs(cal) < 0.001) {
                                                document.getElementById('show-ndf-2').textContent = 'สมบูรณ์';
                                                document.getElementById('show-ndf-2').style.color = 'green';
                                            } else {
                                                document.getElementById('show-ndf-2').textContent = cal.toFixed(3);
                                                if (cal < 0) {
                                                    document.getElementById('show-ndf-2').style.color = 'red';
                                                } else {
                                                    document.getElementById('show-ndf-2').style.color = '#c29200';
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.dnut_ee !== undefined && checkbox.dnut_ee !== null) {
                                        document.getElementById('show-ee').textContent = totalEE.toFixed(3);
                                        if (totalEE == 0) {
                                            document.getElementById('show-ee-2').textContent = 'ไม่มีข้อมูลวัตถุดิบที่มี EE';
                                        } else {
                                            let cal = totalEE - cow.dem_fat;
                                            if (Math.abs(cal) < 0.001) {
                                                document.getElementById('show-ee-2').textContent = 'สมบูรณ์';
                                                document.getElementById('show-ee-2').style.color = 'green';
                                            } else {
                                                document.getElementById('show-ee-2').textContent = cal.toFixed(3);
                                                if (cal < 0) {
                                                    document.getElementById('show-ee-2').style.color = 'red';
                                                } else {
                                                    document.getElementById('show-ee-2').style.color = '#c29200';
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.dnut_cp !== undefined && checkbox.dnut_cp !== null) {
                                        document.getElementById('show-cp').textContent = totalCP.toFixed(3);
                                        if (totalCP == 0) {
                                            document.getElementById('show-cp-2').textContent = 'ไม่มีข้อมูลวัตถุดิบที่มี CP';
                                        } else {
                                            let cal = totalCP - cow.dem_cp;
                                            if (Math.abs(cal) < 0.001) {
                                                document.getElementById('show-cp-2').textContent = 'สมบูรณ์';
                                                document.getElementById('show-cp-2').style.color = 'green';
                                            } else {
                                                document.getElementById('show-cp-2').textContent = cal.toFixed(3);
                                                if (cal < 0) {
                                                    document.getElementById('show-cp-2').style.color = 'red';
                                                } else {
                                                    document.getElementById('show-cp-2').style.color = '#c29200';
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.dnut_rup !== undefined && checkbox.dnut_rup !== null) {
                                        document.getElementById('show-rup').textContent = totalRUP.toFixed(3);
                                        if (totalRUP == 0) {
                                            document.getElementById('show-rup-2').textContent = 'ไม่มีข้อมูลวัตถุดิบที่มี RUP';
                                        } else {
                                            let cal = totalRUP - cow.dem_rup;
                                            if (Math.abs(cal) < 0.001) {
                                                document.getElementById('show-rup-2').textContent = 'สมบูรณ์';
                                                document.getElementById('show-rup-2').style.color = 'green';
                                            } else {
                                                document.getElementById('show-rup-2').textContent = cal.toFixed(3);
                                                if (cal < 0) {
                                                    document.getElementById('show-rup-2').style.color = 'red';
                                                } else {
                                                    document.getElementById('show-rup-2').style.color = '#c29200';
                                                }
                                            }
                                        }
                                    }

                                    if (checkbox.dnut_cf !== undefined && checkbox.dnut_cf !== null) {
                                        document.getElementById('show-cf').textContent = totalCF.toFixed(3);
                                        if (totalCF == 0) {
                                            document.getElementById('show-cf-2').textContent = 'ไม่มีข้อมูลวัตถุดิบที่มี CF';
                                        } else {
                                            let cal = totalCF - cow.dem_cf;
                                            if (Math.abs(cal) < 0.001) {
                                                document.getElementById('show-cf-2').textContent = 'สมบูรณ์';
                                                document.getElementById('show-cf-2').style.color = 'green';
                                            } else {
                                                document.getElementById('show-cf-2').textContent = cal.toFixed(3);
                                                if (cal < 0) {
                                                    document.getElementById('show-cf-2').style.color = 'red';
                                                } else {
                                                    document.getElementById('show-cf-2').style.color = '#c29200';
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.dnut_nfe !== undefined && checkbox.dnut_nfe !== null) {
                                        document.getElementById('show-nfe').textContent = totalNFE.toFixed(3);
                                        if (totalNFE == 0) {
                                            document.getElementById('show-nfe-2').textContent = 'ไม่มีข้อมูลวัตถุดิบที่มี NFE';
                                        } else {
                                            let cal = totalNFE - cow.dem_nfe;
                                            if (Math.abs(cal) < 0.001) {
                                                document.getElementById('show-nfe-2').textContent = 'สมบูรณ์';
                                                document.getElementById('show-nfe-2').style.color = 'green';
                                            } else {
                                                document.getElementById('show-nfe-2').textContent = cal.toFixed(3);
                                                if (cal < 0) {
                                                    document.getElementById('show-nfe-2').style.color = 'red';
                                                } else {
                                                    document.getElementById('show-nfe-2').style.color = '#c29200';
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.dmat_lys !== undefined && checkbox.dmat_lys !== null) {
                                        document.getElementById('show-lys').textContent = totalLYS.toFixed(3);
                                        if (totalLYS == 0) {
                                            document.getElementById('show-lys-2').textContent = 'ไม่มีข้อมูลวัตถุดิบที่มี LYS';
                                        } else {
                                            let cal = totalLYS - cow.dem_lys;
                                            if (Math.abs(cal) < 0.001) {
                                                document.getElementById('show-lys-2').textContent = 'สมบูรณ์';
                                                document.getElementById('show-lys-2').style.color = 'green';
                                            } else {
                                                document.getElementById('show-lys-2').textContent = cal.toFixed(3);
                                                if (cal < 0) {
                                                    document.getElementById('show-lys-2').style.color = 'red';
                                                } else {
                                                    document.getElementById('show-lys-2').style.color = '#c29200';
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.dmat_met !== undefined && checkbox.dmat_met !== null) {
                                        document.getElementById('show-met').textContent = totalMET.toFixed(3);
                                        if (totalMET == 0) {
                                            document.getElementById('show-met-2').textContent = 'ไม่มีข้อมูลวัตถุดิบที่มี MET';
                                        } else {
                                            let cal = totalMET - cow.dem_met;
                                            if (Math.abs(cal) < 0.001) {
                                                document.getElementById('show-met-2').textContent = 'สมบูรณ์';
                                                document.getElementById('show-met-2').style.color = 'green';
                                            } else {
                                                document.getElementById('show-met-2').textContent = cal.toFixed(3);
                                                if (cal < 0) {
                                                    document.getElementById('show-met-2').style.color = 'red';
                                                } else {
                                                    document.getElementById('show-met-2').style.color = '#c29200';
                                                }
                                            }
                                        }
                                    }
                                });
                            }
                        });


                        mineralSources.forEach(function (mineral) {
                            if (mineral.checkbox.checkbox_source_minerals) {
                                mineral.checkbox.checkbox_source_minerals.forEach(function (checkbox) {
                                    if (checkbox.ds_ca !== undefined && checkbox.ds_ca !== null) {
                                        document.getElementById('show-ca').textContent = totalCA.toFixed(3);
                                        if (totalCA == 0) {
                                            document.getElementById('show-ca-2').textContent = 'ไม่มีข้อมูลวัตถุดิบที่มี CA';
                                        } else {
                                            let cal = totalCA - cow.dem_ca;
                                            if (Math.abs(cal) < 0.001) {
                                                document.getElementById('show-ca-2').textContent = 'สมบูรณ์';
                                                document.getElementById('show-ca-2').style.color = 'green';
                                            } else {
                                                document.getElementById('show-ca-2').textContent = cal.toFixed(3);
                                                if (cal < 0) {
                                                    document.getElementById('show-ca-2').style.color = 'red';
                                                } else {
                                                    document.getElementById('show-ca-2').style.color = '#c29200';
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.ds_p !== undefined && checkbox.ds_p !== null) {
                                        document.getElementById('show-p').textContent = totalP.toFixed(3);
                                        if (totalP == 0) {
                                            document.getElementById('show-p-2').textContent = 'ไม่มีข้อมูลวัตถุดิบที่มี P';
                                        } else {
                                            let cal = totalP - cow.dem_p;
                                            if (Math.abs(cal) < 0.001) {
                                                document.getElementById('show-p-2').textContent = 'สมบูรณ์';
                                                document.getElementById('show-p-2').style.color = 'green';
                                            } else {
                                                document.getElementById('show-p-2').textContent = cal.toFixed(3);
                                                if (cal < 0) {
                                                    document.getElementById('show-p-2').style.color = 'red';
                                                } else {
                                                    document.getElementById('show-p-2').style.color = '#c29200';
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.ds_vitA !== undefined && checkbox.ds_vitA !== null) {
                                        document.getElementById('show-a').textContent = totalVitaminA.toFixed(3);
                                        if (totalVitaminA == 0) {
                                            document.getElementById('show-a-2').textContent = 'ไม่มีข้อมูลวัตถุดิบที่มี Vit A';
                                        } else {
                                            let cal = totalVitaminA - cow.dem_vitA;
                                            if (Math.abs(cal) < 0.001) {
                                                document.getElementById('show-a-2').textContent = 'สมบูรณ์';
                                                document.getElementById('show-a-2').style.color = 'green';
                                            } else {
                                                document.getElementById('show-a-2').textContent = cal.toFixed(3);
                                                if (cal < 0) {
                                                    document.getElementById('show-a-2').style.color = 'red';
                                                } else {
                                                    document.getElementById('show-a-2').style.color = '#c29200';
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.ds_vitD !== undefined && checkbox.ds_vitD !== null) {
                                        document.getElementById('show-d').textContent = totalVitaminD.toFixed(3);
                                        if (totalVitaminD == 0) {
                                            document.getElementById('show-d-2').textContent = 'ไม่มีข้อมูลวัตถุดิบที่มี Vit D';
                                        } else {
                                            let cal = totalVitaminD - cow.dem_vitD;
                                            if (Math.abs(cal) < 0.001) {
                                                document.getElementById('show-d-2').textContent = 'สมบูรณ์';
                                                document.getElementById('show-d-2').style.color = 'green';
                                            } else {
                                                document.getElementById('show-d-2').textContent = cal.toFixed(3);
                                                if (cal < 0) {
                                                    document.getElementById('show-d-2').style.color = 'red';
                                                } else {
                                                    document.getElementById('show-d-2').style.color = '#c29200';
                                                }
                                            }
                                        }
                                    }
                                    if (checkbox.ds_vitE !== undefined && checkbox.ds_vitE !== null) {
                                        document.getElementById('show-e').textContent = totalVitaminE.toFixed(3);
                                        if (totalVitaminE == 0) {
                                            document.getElementById('show-e-2').textContent = 'ไม่มีข้อมูลวัตถุดิบที่มี Vit E';
                                        } else {
                                            let cal = totalVitaminE - cow.dem_vitE;
                                            if (Math.abs(cal) < 0.001) {
                                                document.getElementById('show-e-2').textContent = 'สมบูรณ์';
                                                document.getElementById('show-e-2').style.color = 'green';
                                            } else {
                                                document.getElementById('show-e-2').textContent = cal.toFixed(3);
                                                if (cal < 0) {
                                                    document.getElementById('show-e-2').style.color = 'red';
                                                } else {
                                                    document.getElementById('show-e-2').style.color = '#c29200';
                                                }
                                            }
                                        }
                                    }
                                });
                            }
                        });
                    });
                }
            }
            document.addEventListener("DOMContentLoaded", checkAndDisplayData);


            console.log(totalTDN);
        } else {
            console.log("The solution is infeasible or not within bounds.");
        }
    </script>
    <!-- <script>
        document.getElementById('saveButton').addEventListener('click', function () {

            const myData = {
                totalTDN: 11,
                totalDE: 12,
                // เพิ่มข้อมูลอื่น ๆ ตามต้องการ
            };

            fetch('least_cost_group.php?totalTDN=' + myData.totalTDN + '&totalDE=' + myData.totalDE, {
                method: 'POST', // หรือ 'GET' ตามที่คุณต้องการ
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(myData),
            })
                .then(response => {
                    if (response.ok) {
                        return response.text();
                    }
                    throw new Error('Network response was not ok.');
                })
                .then(data => {
                    console.log('Success:', data);
                    // เพิ่มโค้ดที่ต้องการจะทำหลังจากบันทึกข้อมูลเรียบร้อย
                    // เช่นการแสดงข้อมูลหรือทำการ redirect หน้าเว็บ
                })
                .catch((error) => {
                    console.error('Error:', error);
                    // เพิ่มโค้ดที่ต้องการจะทำหลังจากเกิดข้อผิดพลาดในการบันทึก
                });
        });
    </script> -->
    <script>
        function submitForm() {
            var tdnElement = document.getElementById("show-tdn"); // เลือกอิลิเมนต์ที่มี id "show-tdn"
            if (tdnElement !== null) { // ตรวจสอบว่าอิลิเมนต์มีอยู่หรือไม่
                var tdnValue = tdnElement.textContent; // อ่านค่าจากอิลิเมนต์
                document.getElementById("tdn_id").value = tdnValue; // กำหนดค่าให้กับฟิลด์ที่มี id "tdn_id"
                document.getElementById("myForm").submit(); // ส่งฟอร์ม
            } else {
                console.error("Element 'show-tdn' not found in the DOM."); // แสดงข้อผิดพลาดถ้าไม่พบอิลิเมนต์
            }
        }
    </script>
    <?php ?>
</body>