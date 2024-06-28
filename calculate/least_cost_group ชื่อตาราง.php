<?php
session_start();
include "../server.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["session_data"])) {
    $jsonData = $_POST["session_data"];
    $data = json_decode($jsonData, true);
    $acc_id = $_SESSION['acc_id'];
    $name_group = $_POST["name_group"];
    $selectCow = $data['selectCow'];
    $raw_group_id = $data['raw_group_id'];
    // print_r($data);
    echo $selectCow;
    echo $raw_group_id;

    $sql = "INSERT INTO group_calculate (acc_id, name_group, dem_id) VALUES ('$acc_id', '$name_group', '$selectCow')";

    if (mysqli_query($conn, $sql)) {
        $group_cal_id = mysqli_insert_id($conn);
        echo "group_cal_id: " . $group_cal_id . "<br>";

        function checkRawIdTable($conn, $raw_id)
        {
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

        foreach ($data['materials'] as $material) {
            $materialName = $material['raw_thainame'];
            $sql_check_material_raw = "SELECT * FROM raw_material WHERE raw_thainame = '$materialName'";
            $result_material_raw = mysqli_query($conn, $sql_check_material_raw);
            if (mysqli_num_rows($result_material_raw) > 0) {
                $row = mysqli_fetch_assoc($result_material_raw);
                $raw_id = $row['raw_id'];
                $table_names = checkRawIdTable($conn, $raw_id);
                foreach ($table_names as $table_name) {
                    switch ($table_name) {
                        case 'minerals':
                            $sql = "SELECT * FROM minerals WHERE raw_id = $raw_id";
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
                                                    echo "ชื่อวัสดุ $materialName มี raw_id เท่ากับ $raw_id อยู่ในตาราง $table_name <br>";
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            break;
                        case 'nutrition':
                            $sql = "SELECT * FROM nutrition WHERE raw_id = $raw_id";
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
                                                    echo "ชื่อวัสดุ $materialName มี raw_id เท่ากับ $raw_id อยู่ในตาราง $table_name <br>";
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
                            break;
                        case 'material':
                            $sql = "SELECT * FROM material WHERE raw_id = $raw_id";
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
                                                    echo "ชื่อวัสดุ $materialName มี raw_id เท่ากับ $raw_id อยู่ในตาราง $table_name <br>";
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
                            break;

                        default:
                            // กรณีมีตารางอื่นๆ ที่อาจเพิ่มเข้ามาในอนาคต
                            break;
                    }
                }
            } else {
                echo "ชื่อวัสดุ $materialName ไม่พบในตาราง raw_material<br>";
            }
        }

        // ตรวจสอบชื่อวัสดุในตาราง mineral_source_raw
        foreach ($data['mineral_sources'] as $mineral) {
            $materialName = $mineral['ms_thainame'];
            $sql_check_material_mineral = "SELECT * FROM mineral_source_raw WHERE ms_thainame = '$materialName'";
            $result_material_mineral = mysqli_query($conn, $sql_check_material_mineral);
            if (mysqli_num_rows($result_material_mineral) > 0) {
                $row = mysqli_fetch_assoc($result_material_mineral);
                $ms_id = $row['ms_id'];
                $sql = "SELECT * FROM source_minerals WHERE ms_id = $ms_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $source_detail_id = $row['source_detail_id'];
                        $sqlms = "SELECT * FROM source_minerals_detail WHERE source_detail_id = $source_detail_id";
                        $resultms = $conn->query($sqlms);
                        if ($resultms->num_rows > 0) {
                            while ($rowms = $resultms->fetch_assoc()) {
                                echo "ชื่อวัสดุ $materialName มี ms_id เท่ากับ $ms_id อยู่ในตาราง source_minerals_detail <br>";
                            }
                        }
                    }
                }
            } else {
                echo "ชื่อวัสดุ $materialName ไม่พบในตาราง mineral_source_raw<br>";
            }
        }


    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    $materialData = json_decode($_POST["materialData"], true);

    foreach ($materialData as $material) {
        $materialName = $material['materialName'];
        $materialResult = $material['materialResult'];
        $percent = $material['percent'];
        $showMaterialKG = $material['showMaterialKG'];
        $price = $material['price'];
        $materialPrice = $material['materialPrice'];
        echo "Material Name: " . $materialName . "<br>";
        echo "Material Result: " . $materialResult . "<br>";
        echo "Percent: " . $percent . "<br>";
        echo "Show Material KG: " . $showMaterialKG . "<br>";
        echo "Price: " . $price . "<br>";
        echo "Material Price: " . $materialPrice . "<br>";
        echo "<hr>";
    }

    $fields = array(
        "valuetotalTDN" => "Total TDN",
        "valuetotalDE" => "Total DE",
        "valuetotalME" => "Total ME",
        "valuetotalNEL" => "Total NEL",
        "valuetotalCF" => "Total CF",
        "valuetotalADF" => "Total ADF",
        "valuetotalNDF" => "Total NDF",
        "valuetotalNFE" => "Total NFE",
        "valuetotalCP" => "Total CP",
        "valuetotalRUP" => "Total RUP",
        "valuetotalLYS" => "Total LYS",
        "valuetotalMET" => "Total MET",
        "valuetotalCA" => "Total CA",
        "valuetotalP" => "Total P",
        "valuetotalVitaminA" => "Total Vitamin A",
        "valuetotalVitaminD" => "Total Vitamin D",
        "valuetotalVitaminE" => "Total Vitamin E",
        "valuetotalEE" => "Total EE"
    );

    foreach ($fields as $field => $fieldName) {
        ${$field} = $_POST[$field];
        echo $fieldName . ": " . ${$field} . "<br>";
    }

}


