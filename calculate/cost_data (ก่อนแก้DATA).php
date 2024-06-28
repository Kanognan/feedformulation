<?php
include "../server.php";
session_start(); ?>

<?php
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
        'cow_demand' => array(),
        // 'checkbox' => array(),
    );

    if ($selectCow) {
        $sqlCow = "SELECT * FROM cow_demand WHERE dem_id = '$selectCow'";
        $resultCow = mysqli_query($conn, $sqlCow);
        if ($resultCow) {
            if (mysqli_num_rows($resultCow) > 0) {
                while ($row = mysqli_fetch_assoc($resultCow)) {
                    $outputData['cow_demand'][] = $row;
                }
            } else {
                $outputData['cow_demand'] = null;
            }
        } else {
            $outputData['error'] = mysqli_error($conn);
        }
    }

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

    $ca = isset($_POST['checkbox-ca']) ? $_POST['checkbox-ca'] : null; //ตาราง minerals_detail แล้วก็ตาราง source_minerals_detail
    $p = isset($_POST['checkbox-p']) ? $_POST['checkbox-p'] : null; //ตาราง minerals_detail แล้วก็ตาราง source_minerals_detail
    $checkboxesMineralsAndSource = array(
        'ca' => $ca,
        'p' => $p
    );

    // $premix = isset($_POST['checkbox-premix']) ? $_POST['checkbox-premix'] : null; //ตาราง source_minerals_detail
    // $a = isset($_POST['checkbox-a']) ? $_POST['checkbox-a'] : null;
    // $d = isset($_POST['checkbox-d']) ? $_POST['checkbox-d'] : null;
    // $e = isset($_POST['checkbox-e']) ? $_POST['checkbox-e'] : null;


    foreach ($materials as $raw_id => $materialData) {
        $price = isset($materialData['price']) ? floatval($materialData['price']) : 0;
        $min = isset($materialData['min']) ? floatval($materialData['min']) : 0;
        $max = isset($materialData['max']) ? floatval($materialData['max']) : 0;

        $raw_thainame = getRawThainameById($conn, $raw_id);

        $tables = checkRawIdTable($conn, $raw_id);
        if (is_array($tables)) {
            foreach ($tables as $table) {
                if ($table == "minerals") {
                    $sql = "SELECT * FROM $table WHERE raw_id = $raw_id";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $minerals_id = $row['minerals_id'];
                            $sqlminerals = "SELECT * FROM minerals WHERE minerals_id = $minerals_id";
                            $resultminerals = $conn->query($sqlminerals);
                            if ($resultminerals->num_rows > 0) {
                                while ($rowminerals = $resultminerals->fetch_assoc()) {
                                    $minerals_detail_id = $rowminerals['minerals_detail_id'];
                                    $sqlminerals_detail = "SELECT * FROM minerals_detail WHERE minerals_detail_id = $minerals_detail_id AND type_detail_id = 1";
                                    $resultminerals_detail = $conn->query($sqlminerals_detail);
                                    if ($resultminerals_detail->num_rows > 0) {
                                        while ($rowminerals_detail = $resultminerals_detail->fetch_assoc()) {
                                            $outputCheck_minerals = array();
                                            if (!empty($checkboxesMineralsAndSource)) {
                                                foreach ($checkboxesMineralsAndSource as $key => $value) {
                                                    if (isset($value)) {
                                                        $dminerValue = is_numeric($rowminerals_detail["dminer_per_$key"]) ? floatval($rowminerals_detail["dminer_per_$key"]) : 0;
                                                        $outputCheck_minerals['checkbox_minerals'][] = array(
                                                            "dminer_per_$key" => $dminerValue
                                                        );
                                                    }
                                                }
                                            } else {
                                                $outputCheck_minerals['checkbox_minerals'] = []; // กำหนดให้เป็น array ว่าง
                                            }

                                            $outputData['materials'][] = array(
                                                'raw_id' => $raw_id,
                                                'raw_thainame' => $raw_thainame,
                                                'price' => $price,
                                                'min' => $min,
                                                'max' => $max,
                                                'minerals_detail_id' => $rowminerals_detail['minerals_detail_id'],
                                                'checkbox' => $outputCheck_minerals,
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
                    $sql = "SELECT * FROM $table WHERE raw_id = $raw_id";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $nutrition_id = $row['nutrition_id'];
                            $sqlnutrition = "SELECT * FROM nutrition WHERE nutrition_id = $nutrition_id";
                            $resultnutrition = $conn->query($sqlnutrition);
                            if ($resultnutrition->num_rows > 0) {
                                while ($rownutrition = $resultnutrition->fetch_assoc()) {
                                    $nutrition_detail_id = $rownutrition['nutrition_detail_id'];
                                    $sqlnutrition_detail = "SELECT * FROM nutrition_detail WHERE nutrition_detail_id = $nutrition_detail_id AND type_detail_id = 1";
                                    $resultnutrition_detail = $conn->query($sqlnutrition_detail);
                                    if ($resultnutrition_detail->num_rows > 0) {
                                        while ($rownutrition_detail = $resultnutrition_detail->fetch_assoc()) {
                                            $outputCheck_nutrition = array();
                                            if (!empty($checkboxesNutrition)) {
                                                foreach ($checkboxesNutrition as $key => $value) {
                                                    if (isset($value)) {
                                                        $dnutValue = is_numeric($rownutrition_detail["dnut_$key"]) ? floatval($rownutrition_detail["dnut_$key"]) : 0;
                                                        $outputCheck_nutrition['checkbox_nutrition'][] = array(
                                                            "dnut_$key" => $dnutValue
                                                        );
                                                    }
                                                }
                                            } else {
                                                $outputCheck_nutrition['checkbox_nutrition'] = [];
                                            }

                                            $outputData['materials'][] = array(
                                                'raw_id' => $raw_id,
                                                'raw_thainame' => $raw_thainame,
                                                'price' => $price,
                                                'min' => $min,
                                                'max' => $max,
                                                'nutrition_detail_id' => $rownutrition_detail['nutrition_detail_id'],
                                                'checkbox' => $outputCheck_nutrition,
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
                    $sql = "SELECT * FROM $table WHERE raw_id = $raw_id";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $material_id = $row['material_id'];
                            $sqlmaterial = "SELECT * FROM material WHERE material_id = $material_id";
                            $resultmaterial = $conn->query($sqlmaterial);
                            if ($resultmaterial->num_rows > 0) {
                                while ($rowmaterial = $resultmaterial->fetch_assoc()) {
                                    $material_detail_id = $rowmaterial['material_detail_id'];
                                    $sqlmaterial_detail = "SELECT * FROM material_detail WHERE material_detail_id = $material_detail_id AND type_detail_id = 1";
                                    $resultmaterial_detail = $conn->query($sqlmaterial_detail);
                                    if ($resultmaterial_detail->num_rows > 0) {
                                        while ($rowmaterial_detail = $resultmaterial_detail->fetch_assoc()) {
                                            $outputCheck_material = array();
                                            if (!empty($checkboxesMaterial)) {
                                                foreach ($checkboxesMaterial as $key => $value) {
                                                    if (isset($value)) {
                                                        $dmatValue = is_numeric($rowmaterial_detail["dmat_$key"]) ? floatval($rowmaterial_detail["dmat_$key"]) : 0;
                                                        $outputCheck_material['checkbox_material'][] = array(
                                                            "dmat_$key" => $dmatValue
                                                        );
                                                    }
                                                }
                                            } else {
                                                $outputCheck_material['checkbox_material'] = [];
                                            }

                                            $outputData['materials'][] = array(
                                                'raw_id' => $raw_id,
                                                'raw_thainame' => $raw_thainame,
                                                'price' => $price,
                                                'min' => $min,
                                                'max' => $max,
                                                'material_detail_id' => $rowmaterial_detail['material_detail_id'],
                                                'checkbox' => $outputCheck_material,
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
                        $outputCheck_source_minerals = array();
                        if (!empty($checkboxesMineralsAndSource)) {
                            foreach ($checkboxesMineralsAndSource as $key => $value) {
                                if (isset($value)) {
                                    $dsValue = is_numeric($rowms["ds_$key"]) ? floatval($rowms["ds_$key"]) : 0;
                                    $outputCheck_source_minerals['checkbox_source_minerals'][] = array(
                                        "ds_$key" => $dsValue
                                    );
                                }
                            }
                        } else {
                            $outputCheck_source_minerals['checkbox_source_minerals'] = [];
                        }


                        $outputData['mineral_sources'][] = array(
                            'ms_id' => $ms_id,
                            'ms_thainame' => $ms_thainame,
                            'price' => $price,
                            'min' => $min,
                            'max' => $max,
                            'source_detail_id' => $rowms['source_detail_id'],
                            'checkbox' => $outputCheck_source_minerals,
                        );
                    }
                }
            }
        }
    }

    $jsonOutput = json_encode($outputData, JSON_PRETTY_PRINT);

    header('Content-Type: application/json');
    // echo json_encode($outputData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    $_SESSION['jsonData'] = $jsonOutput;
    header("Location: least_cost.php");
    exit();

} else {
    echo "No data received.";
}

?>