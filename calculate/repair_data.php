<?php
session_start();
include "../server.php";

if (!$conn) {
    die ("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . mysqli_connect_error());
}

if (isset ($_POST['group_calculate'])) {
    $group_cal_id = $_POST['group_calculate'];

    $sql = "SELECT * FROM group_calculate WHERE group_cal_id = $group_cal_id";
    $result_group_calculate = mysqli_query($conn, $sql);
    $data = array();
    if (mysqli_num_rows($result_group_calculate) > 0) {
        $row_group_calculate = mysqli_fetch_assoc($result_group_calculate);
        $dem_id = $row_group_calculate['dem_id'];
        $data['dem_id'] = $dem_id;
        $sql_dem = "SELECT * FROM cow_demand WHERE dem_id = $dem_id";
        $result_dem = mysqli_query($conn, $sql_dem);
        if (mysqli_num_rows($result_dem) > 0) {
            $row_dem = mysqli_fetch_assoc($result_dem);
            $data['dem_intake'] = $row_dem['dem_intake'];
        }

        $sql_raw = "SELECT * FROM cal_raw WHERE group_cal_id = $group_cal_id";
        $result_raw = mysqli_query($conn, $sql_raw);

        $sql_ms = "SELECT * FROM cal_ms WHERE group_cal_id = $group_cal_id";
        $result_ms = mysqli_query($conn, $sql_ms);

        if (mysqli_num_rows($result_raw) > 0 || mysqli_num_rows($result_ms) > 0) {
            $sql_raw_material = "SELECT * FROM raw_material";
            $result_raw_material = mysqli_query($conn, $sql_raw_material);
            $raw_material_map = array();
            while ($row = mysqli_fetch_assoc($result_raw_material)) {
                $raw_id = $row['raw_id'];
                $dataRaw = array(
                    "TDN" => 0,
                    "DE" => 0,
                    "ME" => 0,
                    "NEL" => 0,
                    "ADF" => 0,
                    "NDF" => 0,
                    "EE" => 0,
                    "CP" => 0,
                    "RUP" => 0,
                    "Ca" => 0,
                    "P" => 0,
                    "VitA" => 0,
                    "VitD" => 0,
                    "VitE" => 0
                );

                $sqlRawMineralsData = "SELECT * FROM minerals WHERE raw_id = $raw_id";
                $resultMineralsData = mysqli_query($conn, $sqlRawMineralsData);

                $sqlRawNutritionData = "SELECT * FROM nutrition WHERE raw_id = $raw_id";
                $resultNutritionData = mysqli_query($conn, $sqlRawNutritionData);

                $sqlRawMaterialData = "SELECT * FROM material WHERE raw_id = $raw_id";
                $resultMaterialData = mysqli_query($conn, $sqlRawMaterialData);

                if ($resultMineralsData->num_rows > 0) {
                    $rowMineralsData = mysqli_fetch_assoc($resultMineralsData);
                    $minerals_id = $rowMineralsData['minerals_id'];
                    $minerals_detail_id = $rowMineralsData['minerals_detail_id'];
                    $sqlMineralsDetail = "SELECT * FROM minerals_detail WHERE minerals_detail_id = $minerals_detail_id AND type_detail_id = 1";
                    $resultMineralsDetail = mysqli_query($conn, $sqlMineralsDetail);
                    if ($resultMineralsDetail->num_rows > 0) {
                        $rowMineralsDetail = mysqli_fetch_assoc($resultMineralsDetail);
                        $dataRaw["Ca"] = is_numeric($rowMineralsDetail['dminer_per_ca']) ? $rowMineralsDetail['dminer_per_ca'] : 0;
                        $dataRaw["P"] = is_numeric($rowMineralsDetail['dminer_per_p']) ? $rowMineralsDetail['dminer_per_p'] : 0;
                    }
                }

                if ($resultNutritionData->num_rows > 0) {
                    $rowNutritionData = mysqli_fetch_assoc($resultNutritionData);
                    $nutrition_id = $rowNutritionData['nutrition_id'];
                    $nutrition_detail_id = $rowNutritionData['nutrition_detail_id'];
                    $sqlNutritionDetail = "SELECT * FROM nutrition_detail WHERE nutrition_detail_id = $nutrition_detail_id AND type_detail_id = 1";
                    $resultNutritionDetail = mysqli_query($conn, $sqlNutritionDetail);
                    if ($resultNutritionDetail->num_rows > 0) {
                        $rowNutritionDetail = mysqli_fetch_assoc($resultNutritionDetail);
                        $dataRaw["TDN"] = is_numeric($rowNutritionDetail['dnut_tdn']) ? $rowNutritionDetail['dnut_tdn'] : 0;
                        $dataRaw["DE"] = is_numeric($rowNutritionDetail['dnut_de']) ? $rowNutritionDetail['dnut_de'] : 0;
                        $dataRaw["ME"] = is_numeric($rowNutritionDetail['dnut_me']) ? $rowNutritionDetail['dnut_me'] : 0;
                        $dataRaw["NEL"] = is_numeric($rowNutritionDetail['dnut_nel']) ? $rowNutritionDetail['dnut_nel'] : 0;
                        $dataRaw["ADF"] = is_numeric($rowNutritionDetail['dnut_adf']) ? $rowNutritionDetail['dnut_adf'] : 0;
                        $dataRaw["NDF"] = is_numeric($rowNutritionDetail['dnut_ndf']) ? $rowNutritionDetail['dnut_ndf'] : 0;
                        $dataRaw["EE"] = is_numeric($rowNutritionDetail['dnut_ee']) ? $rowNutritionDetail['dnut_ee'] : 0;
                        $dataRaw["CP"] = is_numeric($rowNutritionDetail['dnut_cp']) ? $rowNutritionDetail['dnut_cp'] : 0;
                        $dataRaw["RUP"] = is_numeric($rowNutritionDetail['dnut_rup']) ? $rowNutritionDetail['dnut_rup'] : 0;
                    }
                }

                if ($resultMaterialData->num_rows > 0) {
                    $rowMaterialData = mysqli_fetch_assoc($resultMaterialData);
                    $material_id = $rowMaterialData['material_id'];
                    $material_detail_id = $rowMaterialData['material_detail_id'];
                    $sqlMaterialDetail = "SELECT * FROM material_detail WHERE material_detail_id = $material_detail_id AND type_detail_id = 1";
                    $resultMaterialDetail = mysqli_query($conn, $sqlMaterialDetail);
                    if ($resultMaterialDetail->num_rows > 0) {
                        $rowMaterialDetail = mysqli_fetch_assoc($resultMaterialDetail);
                        $dataRaw["TDN"] = 0;
                        $dataRaw["DE"] = 0;
                        $dataRaw["ME"] = 0;
                        $dataRaw["NEL"] = 0;
                        $dataRaw["ADF"] = 0;
                        $dataRaw["NDF"] = 0;
                        $dataRaw["EE"] = 0;
                        $dataRaw["CP"] = 0;
                        $dataRaw["RUP"] = 0;
                        $dataRaw["Ca"] = 0;
                        $dataRaw["P"] = 0;
                        $dataRaw["VitA"] = 0;
                        $dataRaw["VitD"] = 0;
                        $dataRaw["VitE"] = 0;
                    }
                }

                $raw_material_map[$row['raw_id']] = array(
                    "raw_thainame" => $row['raw_thainame'],
                    "raw_engname" => $row['raw_engname'],
                    "data" => $dataRaw
                );
            }

            $sql_mineral_source_raw = "SELECT * FROM mineral_source_raw";
            $result_mineral_source_raw = mysqli_query($conn, $sql_mineral_source_raw);
            $mineral_source_raw_map = array();
            while ($row = mysqli_fetch_assoc($result_mineral_source_raw)) {
                $ms_id = $row['ms_id'];
                $dataRaw = array(
                    "TDN" => 0,
                    "DE" => 0,
                    "ME" => 0,
                    "NEL" => 0,
                    "ADF" => 0,
                    "NDF" => 0,
                    "EE" => 0,
                    "CP" => 0,
                    "RUP" => 0,
                    "Ca" => 0,
                    "P" => 0,
                    "VitA" => 0,
                    "VitD" => 0,
                    "VitE" => 0
                );

                $sqlsource_mineralsData = "SELECT * FROM source_minerals WHERE ms_id = $ms_id";
                $resultsource_mineralsData = mysqli_query($conn, $sqlsource_mineralsData);

                if ($resultsource_mineralsData->num_rows > 0) {
                    $rowsource_mineralsData = mysqli_fetch_assoc($resultsource_mineralsData);
                    $source_id = $rowsource_mineralsData['source_id'];
                    $source_detail_id = $rowsource_mineralsData['source_detail_id'];
                    $sqlsource_mineralsDetail = "SELECT * FROM source_minerals_detail WHERE source_detail_id = $source_detail_id";
                    $resultsource_mineralsDetail = mysqli_query($conn, $sqlsource_mineralsDetail);
                    if ($resultsource_mineralsDetail->num_rows > 0) {
                        $rowsource_mineralsDetail = mysqli_fetch_assoc($resultsource_mineralsDetail);
                        $dataRaw["Ca"] = is_numeric($rowsource_mineralsDetail['ds_ca']) ? $rowsource_mineralsDetail['ds_ca'] : 0;
                        $dataRaw["P"] = is_numeric($rowsource_mineralsDetail['ds_p']) ? $rowsource_mineralsDetail['ds_p'] : 0;
                        $dataRaw["VitA"] = is_numeric($rowsource_mineralsDetail['ds_vitA']) ? $rowsource_mineralsDetail['ds_vitA'] : 0;
                        $dataRaw["VitD"] = is_numeric($rowsource_mineralsDetail['ds_vitD']) ? $rowsource_mineralsDetail['ds_vitD'] : 0;
                        $dataRaw["VitE"] = is_numeric($rowsource_mineralsDetail['ds_vitE']) ? $rowsource_mineralsDetail['ds_vitE'] : 0;
                    }
                }
                $mineral_source_raw_map[$row['ms_id']] = array(
                    "ms_thainame" => $row['ms_thainame'],
                    "ms_engname" => $row['ms_engname'],
                    "data" => $dataRaw
                );

            }

            while ($row = mysqli_fetch_assoc($result_raw)) {
                $row['rawmaterial'] = $raw_material_map[$row['raw_id']];
                $data['cal_raw'][] = $row;
            }

            while ($row = mysqli_fetch_assoc($result_ms)) {
                $row['rawmaterial'] = $mineral_source_raw_map[$row['ms_id']];
                $data['cal_ms'][] = $row;
            }

            $_SESSION['cal_data'] = $data;
            header('Content-Type: application/json');

            echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            echo "ไม่พบข้อมูลสำหรับ group_cal_id ที่ระบุ";
        }
    } else {
        echo "ไม่พบข้อมูลสำหรับ group_cal_id ที่ระบุ";
    }
} else {
    echo "ไม่ได้รับข้อมูล group_cal_id";
}

mysqli_close($conn);
?>