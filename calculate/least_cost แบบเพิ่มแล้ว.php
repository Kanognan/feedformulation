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
                <h2 class="text-center">คำนวณต้นทุน</h2>
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
                <div>
                    <h4 class="mt-5">คุณค่าทางโภชนะของ
                        <?php echo $cow[0]['dem_name']; ?>
                    </h4>
                    <table class="table table-light table-bordered table-responsive">
                        <thead class="table-head text-center">
                            <tr>
                                <th scope="col" class="p-3">รายการ</th>
                                <th scope="col" class="p-3">ความต้องการ</th>
                                <th scope="col" class="p-3">จำนวนที่ใช้ได้</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr>
                                <td>ปริมาณการกินได้น้ำหนักแห้ง (กก./วัน)</td>
                                <td>
                                    <?php echo $cow[0]['dem_intake']; ?>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>โปรตีนหยาบ (%)</td>
                                <td>
                                    <?php echo $cow[0]['dem_cp']; ?>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="text-center table-secondary">
                                <th scope="row" colspan="" class="">รวม</th>
                                <th scope="row" colspan="" class="">100%</th>
                                <th scope="row" colspan="" class="">1 กก.</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div>
                    <div class="btn-more mt-5 mb-5">
                        <button type="button"
                            class="btn btn-primary d-grid gap-2 col-2 mx-auto select-button btn-select"
                            onclick="window.location.href = 'cost.php'">ย้อนกลับ</button>
                    </div>
                </div>
                <h1>Data Display</h1>
                <pre>
                    <?php
                    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    ?>
                </pre>
            </div>
        </div>
    </div>


    <script>
        const data = <?php echo json_encode($data); ?>;
        const materials = data.materials;
        const mineral_sources = data.mineral_sources;
        const cowdemand = data.cow_demand;
        let materialPrice = 0;
        const constraints = {};

        // let hasDnutTdn = false;
        // constraints.TDN = { min: 0, max: 1000 };

        // let hasDnutDe = false;
        // constraints.DE = { min: 0, max: 1000 };

        // let hasDnutMe = false;
        // constraints.ME = { min: 0, max: 1000 };

        // let hasDnutNel = false;
        // constraints.NEL = { min: 0, max: 1000 };

        // let hasDnutCf = false;
        // constraints.CF = { min: 0 };

        // let hasDnutAdf = false;
        // constraints.ADF = { min: 0, max: 1000 };

        // let hasDnutNdf = false;
        // constraints.NDF = { min: 0, max: 1000 };

        // let hasDnutNfe = false;
        // constraints.NFE = { min: 0 };

        // let hasDnutCp = false;
        // constraints.CP = { min: 0, max: 1000 };

        // let hasDnutRup = false;
        // constraints.RUP = { min: 0, max: 1000 };

        // let hasDnutLys = false;
        // constraints.LYS = { min: 0 };

        // let hasDnutMet = false;
        // constraints.MET = { min: 0 };

        // let hasDnutCa = false;
        // constraints.CA = { min: 0, max: 1000 };

        // let hasDnutP = false;
        // constraints.P = { min: 0, max: 1000 };

        // let hasDnutVitaminA = false;
        // constraints.VitaminA = { min: 0, max: 1000 };

        // let hasDnutVitaminD = false;
        // constraints.VitaminD = { min: 0, max: 1000 };

        // let hasDnutVitaminE = false;
        // constraints.VitaminE = { min: 0, max: 1000 };

        // let hasDnutEE = false;
        // constraints.EE = { min: 0, max: 1000 };


        // if (cowdemand && cowdemand.length > 0) {
        //     cowdemand.forEach(cow => {
        //         if (materials && materials.length > 0) {
        //             materials.forEach(material => {
        //                 if (material.checkbox && material.checkbox.checkboxALL && material.checkbox.checkboxALL.length > 0) {
        //                     const dnut_tdn = material.checkbox.checkboxALL.find(item => item.dnut_tdn);
        //                     const dnut_de = material.checkbox.checkboxALL.find(item => item.dnut_de);
        //                     const dnut_me = material.checkbox.checkboxALL.find(item => item.dnut_me);
        //                     const dnut_nel = material.checkbox.checkboxALL.find(item => item.dnut_nel);
        //                     const dnut_cf = material.checkbox.checkboxALL.find(item => item.dnut_cf);
        //                     const dnut_adf = material.checkbox.checkboxALL.find(item => item.dnut_adf);
        //                     const dnut_ndf = material.checkbox.checkboxALL.find(item => item.dnut_ndf);
        //                     const dnut_nfe = material.checkbox.checkboxALL.find(item => item.dnut_nfe);
        //                     const dnut_cp = material.checkbox.checkboxALL.find(item => item.dnut_cp);
        //                     const dnut_rup = material.checkbox.checkboxALL.find(item => item.dnut_rup);
        //                     const dnut_ee = material.checkbox.checkboxALL.find(item => item.dnut_ee);
        //                     const dmat_lys = material.checkbox.checkboxALL.find(item => item.dmat_lys);
        //                     const dmat_met = material.checkbox.checkboxALL.find(item => item.dmat_met);
        //                     const dminer_per_ca = material.checkbox.checkboxALL.find(item => item.dminer_per_ca);
        //                     const dminer_per_p = material.checkbox.checkboxALL.find(item => item.dminer_per_p);

        //                     if (dnut_tdn) {
        //                         constraints.TDN.min = isNaN(parseFloat(cow.dem_tdn)) ? 0 : parseFloat(cow.dem_tdn);
        //                         hasDnutTdn = true;
        //                         // console.log("1")
        //                     }
        //                     if (dnut_de) {
        //                         constraints.DE.min = isNaN(parseFloat(cow.dem_de)) ? 0 : parseFloat(cow.dem_de);
        //                         hasDnutDe = true;
        //                         // console.log("2")
        //                     }
        //                     if (dnut_me) {
        //                         constraints.ME.min = isNaN(parseFloat(cow.dem_me)) ? 0 : parseFloat(cow.dem_me);
        //                         hasDnutMe = true;
        //                         // console.log("3")
        //                     }
        //                     if (dnut_nel) {
        //                         constraints.NEL.min = isNaN(parseFloat(cow.dem_nel)) ? 0 : parseFloat(cow.dem_nel);
        //                         hasDnutNel = true;
        //                         // console.log("4")
        //                     }
        //                     if (dnut_cf) {
        //                         constraints.CF.min = 0;
        //                         hasDnutCf = true;
        //                         // console.log("5")
        //                     }
        //                     if (dnut_adf) {
        //                         constraints.ADF.min = isNaN(parseFloat(cow.dem_adf)) ? 0 : parseFloat(cow.dem_adf);
        //                         hasDnutAdf = true;
        //                         // console.log("6")
        //                     }
        //                     if (dnut_ndf) {
        //                         constraints.NDF.min = isNaN(parseFloat(cow.dem_ndf)) ? 0 : parseFloat(cow.dem_ndf);
        //                         hasDnutNdf = true;
        //                         // console.log("7")
        //                     }
        //                     if (dnut_nfe) {
        //                         constraints.NFE.min = 0;
        //                         hasDnutNfe = true;
        //                         // console.log("8")
        //                     }
        //                     if (dnut_cp) {
        //                         constraints.CP.min = isNaN(parseFloat(cow.dem_cp)) ? 0 : parseFloat(cow.dem_cp);
        //                         hasDnutCp = true;
        //                         // console.log("9")
        //                     }
        //                     if (dnut_rup) {
        //                         constraints.RUP.min = isNaN(parseFloat(cow.dem_rup)) ? 0 : parseFloat(cow.dem_rup);
        //                         hasDnutRup = true;
        //                         // console.log("10")
        //                     }
        //                     if (dnut_ee) {
        //                         constraints.EE.min = isNaN(parseFloat(cow.dem_fat)) ? 0 : parseFloat(cow.dem_fat);
        //                         hasDnutEE = true;
        //                         // console.log("11")
        //                     }

        //                     if (dmat_lys) {
        //                         constraints.LYS.min = 1000 //กำหนดค่าไว้ก่อน
        //                         hasDnutLys = true;
        //                         // console.log("สวัสดี")
        //                     }
        //                     if (dmat_met) {
        //                         constraints.MET.min = 1000; //กำหนดค่าไว้ก่อน
        //                         hasDnutMet = true;
        //                         // console.log("สวัสดี2")
        //                     }

        //                     if (dminer_per_ca) {
        //                         constraints.CA.min = isNaN(parseFloat(cow.dem_ca)) ? 0 : parseFloat(cow.dem_ca);
        //                         hasDnutCa = true;
        //                     }
        //                     if (dminer_per_p) {
        //                         constraints.P.min = isNaN(parseFloat(cow.dem_p)) ? 0 : parseFloat(cow.dem_p);
        //                         hasDnutP = true;
        //                     }
        //                 }
        //                 if (material.checkbox && material.checkbox.checkbox_source_minerals && material.checkbox.checkbox_source_minerals.length > 0) {
        //                     const ds_ca = material.checkbox.checkbox_source_minerals.find(item => item.ds_ca);
        //                     const ds_p = material.checkbox.checkbox_source_minerals.find(item => item.ds_p);

        //                     const ds_vitA = material.checkbox.checkbox_source_minerals.find(item => item.ds_vitA);
        //                     const ds_vitD = material.checkbox.checkbox_source_minerals.find(item => item.ds_vitD);
        //                     const ds_vitE = material.checkbox.checkbox_source_minerals.find(item => item.ds_vitE);
        //                     if (ds_ca) {
        //                         constraints.CA.min = isNaN(parseFloat(cow.dem_ca)) ? 0 : parseFloat(cow.dem_ca);
        //                         hasDnutCa = true;
        //                     }
        //                     if (ds_p) {
        //                         constraints.P.min = isNaN(parseFloat(cow.dem_p)) ? 0 : parseFloat(cow.dem_p);
        //                         hasDnutP = true;
        //                     }
        //                     if (ds_vitA) {
        //                         constraints.VitaminA.min = isNaN(parseFloat(cow.dem_vitA)) ? 0 : parseFloat(cow.dem_vitA);
        //                         hasDnutVitaminA = true;
        //                     }
        //                     if (ds_vitD) {
        //                         constraints.VitaminD.min = isNaN(parseFloat(cow.dem_vitD)) ? 0 : parseFloat(cow.dem_vitD);
        //                         hasDnutVitaminD = true;
        //                     }
        //                     if (ds_vitE) {
        //                         constraints.VitaminE.min = isNaN(parseFloat(cow.dem_vitE)) ? 0 : parseFloat(cow.dem_vitE);
        //                         hasDnutVitaminE = true;
        //                     }
        //                 }
        //             });
        //         }
        //     });
        // }

        // if (!hasDnutTdn) {
        //     constraints.TDN.min = 0;
        // }
        // if (!hasDnutDe) {
        //     constraints.DE.min = 0;
        // }
        // if (!hasDnutMe) {
        //     constraints.ME.min = 0;
        // }
        // if (!hasDnutNel) {
        //     constraints.NEL.min = 0;
        // }
        // if (!hasDnutCf) {
        //     constraints.CF.min = 0;
        // }
        // if (!hasDnutAdf) {
        //     constraints.ADF.min = 0;
        // }
        // if (!hasDnutNdf) {
        //     constraints.NDF.min = 0;
        // }
        // if (!hasDnutNfe) {
        //     constraints.NFE.min = 0;
        // }
        // if (!hasDnutCp) {
        //     constraints.CP.min = 0;
        // }
        // if (!hasDnutRup) {
        //     constraints.RUP.min = 0;
        // }
        // if (!hasDnutEE) {
        //     constraints.EE.min = 0;
        // }
        // if (!hasDnutLys) {
        //     constraints.LYS.min = 0;
        // }
        // if (!hasDnutMet) {
        //     constraints.MET.min = 0;
        // }
        // if (!hasDnutCa) {
        //     constraints.CA.min = 0;
        // }
        // if (!hasDnutP) {
        //     constraints.P.min = 0;
        // }
        // if (!hasDnutVitaminA) {
        //     constraints.VitaminA.min = 0;
        // }
        // if (!hasDnutVitaminD) {
        //     constraints.VitaminD.min = 0;
        // }
        // if (!hasDnutVitaminE) {
        //     constraints.VitaminE.min = 0;
        // }
        // if (!hasDnutEE) {
        //     constraints.EE.min = 0;
        // }


        materials.forEach(material => {
            constraints[material.raw_thainame] = { max: material.max };
        });

        mineral_sources.forEach(source => {
            constraints[source.ms_thainame] = { max: source.max };
        });




        const variables = {};
        [...materials, ...mineral_sources].forEach(item => {
            // แก้ไขการสร้างฟังก์ชัน getAllMaterial และ getMineralsValue ให้ถูกต้อง
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
                TDN: getNutritionValue('dnut_tdn', AllMaterial),
                DE: getNutritionValue('dnut_de', AllMaterial),
                ME: getNutritionValue('dnut_me', AllMaterial),
                NEL: getNutritionValue('dnut_nel', AllMaterial),
                CF: getNutritionValue('dnut_cf', AllMaterial),
                ADF: getNutritionValue('dnut_adf', AllMaterial),
                NDF: getNutritionValue('dnut_ndf', AllMaterial),
                NFE: getNutritionValue('dnut_nfe', AllMaterial),
                CP: getNutritionValue('dnut_cp', AllMaterial),
                RUP: getNutritionValue('dnut_rup', AllMaterial),
                LYS: getNutritionValue('dmat_lys', AllMaterial),
                MET: getNutritionValue('dmat_met', AllMaterial),
                CA: getMineralsValue('dminer_per_ca', sourceMinerals),
                P: getMineralsValue('dminer_per_p', sourceMinerals),
                VitaminA: getNutritionValue('ds_vitA', AllMaterial),
                VitaminD: getNutritionValue('ds_vitD', AllMaterial),
                VitaminE: getNutritionValue('ds_vitE', AllMaterial),
                EE: getNutritionValue('dnut_ee', AllMaterial),
                cost: [item.price],
                [item.raw_thainame || item.ms_thainame]: item.min
            };
        });

        const model = {
            optimize: "cost",
            opType: "min",
            constraints: constraints,
            variables: variables,
        };

        const results = solver.Solve(model);

        console.log(results);

        if (results.feasible && results.bounded) {
            console.log("The solution is feasible and within bounds.");
            const least_cost = results.result;
            const materialsList = document.getElementById('material-table-body');
            const resultElements = materialsList.querySelectorAll('.results_key');
            let totalResult = 0;
            let resultKG = 0;

            resultElements.forEach((resultElement, index) => {
                const materialNameElement = resultElement.closest('tr').querySelector('.material-name');
                const materialName = materialNameElement.textContent.trim();
                // console.log(materialName);
                materials.forEach((material) => {
                    if (material.raw_thainame === materialName) {
                        materialPrice = material.price;
                    }
                });
                if (results.hasOwnProperty(materialName)) {
                    const materialResult = results[materialName];
                    resultElement.textContent = materialResult.toFixed(3);
                    totalResult += materialResult;

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
                        console.log(resultKG);
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

        } else {
            console.log("The solution is infeasible or not within bounds.");
        }

    </script>

    <?php // unset($_SESSION['jsonData']);                        ?>
</body>