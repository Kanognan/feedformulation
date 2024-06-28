<?php
include "../server.php";
session_start();

function getRawThainameById($conn, $raw_id)
{
    $sql = "SELECT * FROM raw_material WHERE raw_id = $raw_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["raw_thainame"];
    } else {
        return "ไม่พบข้อมูล";
    }
}
function checkRawIdTable($conn, $raw_id)
{
    $raw_thainame = getRawThainameById($conn, $raw_id);
    if ($raw_thainame === "ไม่พบข้อมูล") {
        return "ไม่สามารถหา raw_thainame ได้";
    }

    $sql = "SELECT 'minerals' AS table_name FROM minerals WHERE raw_id = $raw_id
                UNION
                SELECT 'nutrition' AS table_name FROM nutrition WHERE raw_id = $raw_id
                UNION
                SELECT 'material' AS table_name FROM material WHERE raw_id = $raw_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $tables = array();
        while ($row = $result->fetch_assoc()) {
            $tables[] = $row["table_name"];
        }
        return $tables;
    } else {
        return "ไม่พบข้อมูลในตารางใดๆ";
    }
}
function getMSrawById($conn, $ms_id)
{
    $sql = "SELECT * FROM mineral_source_raw WHERE ms_id = $ms_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["ms_thainame"];
    } else {
        return "ไม่พบข้อมูล";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectCow = $_POST["selectCow"];
    $raw_group_id = $_POST["selectRaw"];

    $outputData = array(
        'selectCow' => $selectCow,
        'raw_group_id' => $raw_group_id,
        'materials' => array(),
        'mineral_sources' => array(),
        'checkbox' => array(),
    );

    $materials = isset($_POST['materials']) ? $_POST['materials'] : [];
    $mineral_sources = isset($_POST['mineral_sources']) ? $_POST['mineral_sources'] : [];

    $tdn = isset($_POST['checkbox-tdn']) ? $_POST['checkbox-tdn'] : null; //ตาราง nutrition_detail
    $de = isset($_POST['checkbox-de']) ? $_POST['checkbox-de'] : null; //ตาราง nutrition_detail
    $me = isset($_POST['checkbox-me']) ? $_POST['checkbox-me'] : null; //ตาราง nutrition_detail
    $nel = isset($_POST['checkbox-nel']) ? $_POST['checkbox-nel'] : null; //ตาราง nutrition_detail
    $cf = isset($_POST['checkbox-cf']) ? $_POST['checkbox-cf'] : null; //ตาราง nutrition_detail
    $adf = isset($_POST['checkbox-adf']) ? $_POST['checkbox-adf'] : null; //ตาราง nutrition_detail
    $ndf = isset($_POST['checkbox-ndf']) ? $_POST['checkbox-ndf'] : null; //ตาราง nutrition_detail
    $nfe = isset($_POST['checkbox-nfe']) ? $_POST['checkbox-nfe'] : null; //ตาราง nutrition_detail
    $cp = isset($_POST['checkbox-cp']) ? $_POST['checkbox-cp'] : null; //ตาราง nutrition_detail
    $rup = isset($_POST['checkbox-rup']) ? $_POST['checkbox-rup'] : null; //ตาราง nutrition_detail
    $ee = isset($_POST['checkbox-ee']) ? $_POST['checkbox-ee'] : null; //ตาราง nutrition_detail
    $checkboxesNutrition = array(
        'tdn' => $tdn,
        'de' => $de,
        'me' => $me,
        'nel' => $nel,
        'cf' => $cf,
        'adf' => $adf,
        'ndf' => $ndf,
        'nfe' => $nfe,
        'cp' => $cp,
        'rup' => $rup,
        'ee' => $ee
    );

    $lys = isset($_POST['checkbox-lys']) ? $_POST['checkbox-lys'] : null; //ตาราง material_detail
    $met = isset($_POST['checkbox-met']) ? $_POST['checkbox-met'] : null; //ตาราง material_detail
    $checkboxesMaterial = array(
        'lys' => $lys,
        'met' => $met
    );

    $ca = isset($_POST['checkbox-ca']) ? $_POST['checkbox-ca'] : null; //ตาราง minerals_detail
    $p = isset($_POST['checkbox-p']) ? $_POST['checkbox-p'] : null; //ตาราง minerals_detail
    // $premix = isset($_POST['checkbox-premix']) ? $_POST['checkbox-premix'] : null; 
    // $a = isset($_POST['checkbox-a']) ? $_POST['checkbox-a'] : null;
    // $d = isset($_POST['checkbox-d']) ? $_POST['checkbox-d'] : null;
    // $e = isset($_POST['checkbox-e']) ? $_POST['checkbox-e'] : null;



    // if (isset($tdn)) {
    //     $sql = "SELECT * FROM nutrition_detail"; // ปรับเงื่อนไขตามที่ต้องการ
    //     $result = $conn->query($sql);

    //     if ($result->num_rows > 0) {
    //         while ($row = $result->fetch_assoc()) {
    //             $outputData['checkbox'][] = array(
    //                 'constraint' => $row['dnut_tdn'],
    //             );
    //         }
    //     }
    // }

    // if (isset($tdn)) {
    //     $outputData['checkbox'][] = array(
    //         'constraint' => $tdn,
    //     );
    // }

    // if (isset($de)) {
    //     $outputData['checkbox'][] = array(
    //         'constraint' => $de,
    //     );
    // }

    // if (isset($me)) {
    //     $outputData['checkbox'][] = array(
    //         'constraint' => $me,
    //     );
    // }

    // if (isset($nel)) {
    //     $outputData['checkbox'][] = array(
    //         'constraint' => $nel,
    //     );
    // }

    // if (isset($fat)) {
    //     $outputData['checkbox'][] = array(
    //         'constraint' => $fat,
    //     );
    // }

    // if (isset($cp)) {
    //     $outputData['checkbox'][] = array(
    //         'constraint' => $cp,
    //     );
    // }

    // if (isset($cf)) {
    //     $outputData['checkbox'][] = array(
    //         'constraint' => $cf,
    //     );
    // }

    // if (isset($adf)) {
    //     $outputData['checkbox'][] = array(
    //         'constraint' => $adf,
    //     );
    // }

    // if (isset($ndf)) {
    //     $outputData['checkbox'][] = array(
    //         'constraint' => $ndf,
    //     );
    // }

    // if (isset($nfe)) {
    //     $outputData['checkbox'][] = array(
    //         'constraint' => $nfe,
    //     );
    // }

    // if (isset($ash)) {
    //     $outputData['checkbox'][] = array(
    //         'constraint' => $ash,
    //     );
    // }

    // if (isset($ca)) {
    //     $outputData['checkbox'][] = array(
    //         'constraint' => $ca,
    //     );
    // }

    // if (isset($p)) {
    //     $outputData['checkbox'][] = array(
    //         'constraint' => $p,
    //     );
    // }


    // วิตามินพรีมิกซ์ ไม่เกิน 0.1

    foreach ($materials as $raw_id => $materialData) {
        $price = isset($materialData['price']) ? floatval($materialData['price']) : 0;
        $min = isset($materialData['min']) ? floatval($materialData['min']) : 0;
        $max = isset($materialData['max']) ? floatval($materialData['max']) : 0;

        $raw_thainame = getRawThainameById($conn, $raw_id);

        $tables = checkRawIdTable($conn, $raw_id);
        if (is_array($tables)) {
            foreach ($tables as $table) {
                if ($table == "minerals") {
                    // echo "RawID $raw_id is found in the following tables: " . implode(", ", $tables) . " ";
                    $sql = "SELECT * FROM $table WHERE raw_id = $raw_id";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // echo "minerals_id: " . $row['minerals_id'];
                            $minerals_id = $row['minerals_id'];
                            $sqlminerals = "SELECT * FROM minerals WHERE minerals_id = $minerals_id";
                            $resultminerals = $conn->query($sqlminerals);
                            if ($resultminerals->num_rows > 0) {
                                while ($rowminerals = $resultminerals->fetch_assoc()) {
                                    // echo "minerals_detail_id: " . $rowminerals['minerals_detail_id'];
                                    $minerals_detail_id = $rowminerals['minerals_detail_id'];
                                    $sqlminerals_detail = "SELECT * FROM minerals_detail WHERE minerals_detail_id = $minerals_detail_id AND type_detail_id = 1";
                                    $resultminerals_detail = $conn->query($sqlminerals_detail);
                                    if ($resultminerals_detail->num_rows > 0) {
                                        while ($rowminerals_detail = $resultminerals_detail->fetch_assoc()) {
                                            $outputData['materials'][] = array(
                                                'raw_id' => $raw_id,
                                                'raw_thainame' => $raw_thainame,
                                                'price' => $price,
                                                'min' => $min,
                                                'max' => $max,
                                                'minerals_detail_id' => $rowminerals_detail['minerals_detail_id'],
                                                'dminer_per_ca' => $rowminerals_detail['dminer_per_ca'],
                                                'dminer_per_p' => $rowminerals_detail['dminer_per_p'],
                                                'dminer_per_mg' => $rowminerals_detail['dminer_per_mg'],
                                                'dminer_per_k' => $rowminerals_detail['dminer_per_k'],
                                                'dminer_per_s' => $rowminerals_detail['dminer_per_s'],
                                                'dminer_per_na' => $rowminerals_detail['dminer_per_na'],
                                                'dminer_kg_cu' => $rowminerals_detail['dminer_kg_cu'],
                                                'dminer_kg_fe' => $rowminerals_detail['dminer_kg_fe'],
                                                'dminer_kg_mn' => $rowminerals_detail['dminer_kg_mn'],
                                                'dminer_kg_zn' => $rowminerals_detail['dminer_kg_zn'],
                                            );
                                        }
                                    }
                                }
                            } else {
                                echo "ไม่พบข้อมูล";
                            }
                        }
                    } else {
                        echo "ไม่พบข้อมูล";
                    }
                }
                if ($table == "nutrition") {
                    // echo "RawID $raw_id is found in the following tables: " . implode(", ", $tables) . " ";
                    $sql = "SELECT * FROM $table WHERE raw_id = $raw_id";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // echo "nutrition_id: " . $row['nutrition_id'];
                            $nutrition_id = $row['nutrition_id'];
                            $sqlnutrition = "SELECT * FROM nutrition WHERE nutrition_id = $nutrition_id";
                            $resultnutrition = $conn->query($sqlnutrition);
                            if ($resultnutrition->num_rows > 0) {
                                while ($rownutrition = $resultnutrition->fetch_assoc()) {
                                    // echo "nutrition_detail_id: " . $rownutrition['nutrition_detail_id'];
                                    $nutrition_detail_id = $rownutrition['nutrition_detail_id'];
                                    $sqlnutrition_detail = "SELECT * FROM nutrition_detail WHERE nutrition_detail_id = $nutrition_detail_id AND type_detail_id = 1";
                                    $resultnutrition_detail = $conn->query($sqlnutrition_detail);
                                    if ($resultnutrition_detail->num_rows > 0) {
                                        while ($rownutrition_detail = $resultnutrition_detail->fetch_assoc()) {
                                            foreach ($checkboxesNutrition as $key => $value) {
                                                if (isset($value)) {
                                                    $outputData['checkbox'][] = array(
                                                        "dnut_$key" => $rownutrition_detail["dnut_$key"]
                                                    );
                                                }
                                            }
                                            $outputData['materials'][] = array(
                                                'raw_id' => $raw_id,
                                                'raw_thainame' => $raw_thainame,
                                                'price' => $price,
                                                'min' => $min,
                                                'max' => $max,
                                                'nutrition_detail_id' => $rownutrition_detail['nutrition_detail_id'],
                                                // 'dnut_dm' => $rownutrition_detail['dnut_dm'],
                                                // 'dnut_cp' => $rownutrition_detail['dnut_cp'],
                                                // 'dnut_ee' => $rownutrition_detail['dnut_ee'],
                                                // 'dnut_cf' => $rownutrition_detail['dnut_cf'],
                                                // 'dnut_ash' => $rownutrition_detail['dnut_ash'],
                                                // 'dnut_nfe' => $rownutrition_detail['dnut_nfe'],
                                                // 'dnut_ndf' => $rownutrition_detail['dnut_ndf'],
                                                // 'dnut_adf' => $rownutrition_detail['dnut_adf'],
                                                // 'dnut_adl' => $rownutrition_detail['dnut_adl'],
                                                // 'dnut_ndicp' => $rownutrition_detail['dnut_ndicp'],
                                                // 'dnut_adicp' => $rownutrition_detail['dnut_adicp'],
                                                // 'dnut_ndfd' => $rownutrition_detail['dnut_ndfd'],
                                                // 'dnut_rup' => $rownutrition_detail['dnut_rup'],
                                                // 'dnut_dmd' => $rownutrition_detail['dnut_dmd'],
                                                // 'dnut_omd' => $rownutrition_detail['dnut_omd'],
                                                // 'dnut_tdn' => $rownutrition_detail['dnut_tdn'],
                                                // 'dnut_de' => $rownutrition_detail['dnut_de'],
                                                // 'dnut_me' => $rownutrition_detail['dnut_me'],
                                                // 'dnut_nel' => $rownutrition_detail['dnut_nel'],
                                            );
                                        }
                                    }
                                }
                            } else {
                                echo "ไม่พบข้อมูล";
                            }
                        }
                    } else {
                        echo "ไม่พบข้อมูล";
                    }
                }

                if ($table == "material") {
                    // echo "RawID $raw_id is found in the following tables: " . implode(", ", $tables) . " ";
                    $sql = "SELECT * FROM $table WHERE raw_id = $raw_id";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // echo "material_id: " . $row['material_id'];
                            $material_id = $row['material_id'];
                            $sqlmaterial = "SELECT * FROM material WHERE material_id = $material_id";
                            $resultmaterial = $conn->query($sqlmaterial);
                            if ($resultmaterial->num_rows > 0) {
                                while ($rowmaterial = $resultmaterial->fetch_assoc()) {
                                    // echo "material_detail_id: " . $rowmaterial['material_detail_id'];
                                    $material_detail_id = $rowmaterial['material_detail_id'];
                                    $sqlmaterial_detail = "SELECT * FROM material_detail WHERE material_detail_id = $material_detail_id AND type_detail_id = 1";
                                    $resultmaterial_detail = $conn->query($sqlmaterial_detail);
                                    if ($resultmaterial_detail->num_rows > 0) {
                                        while ($rowmaterial_detail = $resultmaterial_detail->fetch_assoc()) {
                                            foreach ($checkboxesMaterial as $key => $value) {
                                                if (isset($value)) {
                                                    $outputData['checkbox'][] = array(
                                                        "dmat_$key" => $rowmaterial_detail["dmat_$key"]
                                                    );
                                                }
                                            }
                                            $outputData['materials'][] = array(
                                                'raw_id' => $raw_id,
                                                'raw_thainame' => $raw_thainame,
                                                'price' => $price,
                                                'min' => $min,
                                                'max' => $max,
                                                'material_detail_id' => $rowmaterial_detail['material_detail_id'],
                                                // 'dmat_ala' => $rowmaterial_detail['dmat_ala'],
                                                // 'dmat_arg' => $rowmaterial_detail['dmat_arg'],
                                                // 'dmat_asp' => $rowmaterial_detail['dmat_asp'],
                                                // 'dmat_cys' => $rowmaterial_detail['dmat_cys'],
                                                // 'dmat_glu' => $rowmaterial_detail['dmat_glu'],
                                                // 'dmat_gly' => $rowmaterial_detail['dmat_gly'],
                                                // 'dmat_his' => $rowmaterial_detail['dmat_his'],
                                                // 'dmat_hyl' => $rowmaterial_detail['dmat_hyl'],
                                                // 'dmat_hyp' => $rowmaterial_detail['dmat_hyp'],
                                                // 'dmat_ile' => $rowmaterial_detail['dmat_ile'],
                                                // 'dmat_leu' => $rowmaterial_detail['dmat_leu'],
                                                // 'dmat_lys' => $rowmaterial_detail['dmat_lys'],
                                                // 'dmat_met' => $rowmaterial_detail['dmat_met'],
                                                // 'dmat_phe' => $rowmaterial_detail['dmat_phe'],
                                                // 'dmat_pro' => $rowmaterial_detail['dmat_pro'],
                                                // 'dmat_ser' => $rowmaterial_detail['dmat_ser'],
                                                // 'dmat_thr' => $rowmaterial_detail['dmat_thr'],
                                                // 'dmat_trp' => $rowmaterial_detail['dmat_trp'],
                                                // 'dmat_tyr' => $rowmaterial_detail['dmat_tyr'],
                                                // 'dmat_val' => $rowmaterial_detail['dmat_val'],
                                            );
                                        }
                                    }
                                }
                            } else {
                                echo "ไม่พบข้อมูล";
                            }
                        }
                    } else {
                        echo "ไม่พบข้อมูล";
                    }
                }
            }
        } else {
            echo $tables;
        }
    }

    // รวบรวมข้อมูลวิตามินและแร่ธาตุ
    foreach ($mineral_sources as $ms_id => $mineralSourceData) {
        $price = isset($mineralSourceData['price']) ? floatval($mineralSourceData['price']) : 0;
        $min = isset($mineralSourceData['min']) ? floatval($mineralSourceData['min']) : 0;
        $max = isset($mineralSourceData['max']) ? floatval($mineralSourceData['max']) : 0;

        $ms_thainame = getMSrawById($conn, $ms_id);

        $sql = "SELECT * FROM source_minerals WHERE ms_id = $ms_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $source_detail_id = $row['source_detail_id'];
                $sqlms = "SELECT * FROM source_minerals_detail WHERE source_detail_id = $source_detail_id";
                $resultms = $conn->query($sqlms);
                if ($resultms->num_rows > 0) {
                    while ($rowms = $resultms->fetch_assoc()) {
                        $outputData['mineral_sources'][] = array(
                            'ms_id' => $ms_id,
                            'ms_thainame' => $ms_thainame,
                            'price' => $price,
                            'min' => $min,
                            'max' => $max,
                            'source_detail_id' => $rowms['source_detail_id'],
                            'ds_DM' => $rowms['ds_DM'],
                            'ds_ca' => $rowms['ds_ca'],
                            'ds_p' => $rowms['ds_p'],
                            'ds_mg' => $rowms['ds_mg'],
                            'ds_k' => $rowms['ds_k'],
                            'ds_s' => $rowms['ds_s'],
                            'ds_na' => $rowms['ds_na'],
                            'ds_cl' => $rowms['ds_cl'],
                            'ds_cu' => $rowms['ds_cu'],
                            'ds_fe' => $rowms['ds_fe'],
                            'ds_mn' => $rowms['ds_mn'],
                            'ds_zn' => $rowms['ds_zn'],
                            'ds_co' => $rowms['ds_co'],
                            'ds_i' => $rowms['ds_i'],
                            'ds_se' => $rowms['ds_se'],
                        );
                    }
                }
            }
        }
    }


    // แปลงข้อมูลเป็น JSON
    $jsonOutput = json_encode($outputData, JSON_PRETTY_PRINT);

    header('Content-Type: application/json');
    echo json_encode($outputData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    $_SESSION['jsonData'] = $jsonOutput;
    // header("Location: least_cost.php");

} else {
    echo "No data received.";
}

?>