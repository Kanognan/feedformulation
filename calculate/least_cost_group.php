<?php
session_start();
include "../server.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <?php //include "../header.php"; ?>
    <title>Document</title>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["session_data"])) {
        $jsonData = $_POST["session_data"];
        $data = json_decode($jsonData, true);
        $acc_id = $_SESSION['acc_id'];
        $name_group = $_POST["name_group"];
        $selectCow = $data['selectCow'];
        $raw_group_id = $data['raw_group_id'];
        $materialData = json_decode($_POST["materialData"], true);

        $sql = "INSERT INTO group_calculate (acc_id, name_group, dem_id) VALUES ('$acc_id', '$name_group', '$selectCow')";

        if (mysqli_query($conn, $sql)) {
            $group_cal_id = mysqli_insert_id($conn);
            // echo "group_cal_id: " . $group_cal_id . "<br>";
    
            foreach ($materialData as $material) {
                $materialName = $material['materialName'];
                $materialResult = $material['materialResult'];
                $percent = $material['percent'];
                $showMaterialKG = $material['showMaterialKG'];
                $price = $material['price'];
                $materialPrice = $material['materialPrice'];
                $demintake = $material['demintake'];

                $sql_check_material_raw = "SELECT * FROM raw_material WHERE raw_thainame = '$materialName'";
                $result_material_raw = mysqli_query($conn, $sql_check_material_raw);
                if (mysqli_num_rows($result_material_raw) > 0) {
                    $row = mysqli_fetch_assoc($result_material_raw);
                    $raw_id = $row['raw_id'];
                    // echo "ชื่อวัสดุ $materialName มี raw_id เท่ากับ $raw_id<br>";
    
                    $sql_insert_cal_raw = "INSERT INTO cal_raw (group_cal_id, raw_id, per_use, intake_use, price, intake_lc_result ,material_result) 
                                       VALUES ('$group_cal_id', '$raw_id', '$percent', '$demintake', '$materialPrice', '$price', '$materialResult')";

                    if (mysqli_query($conn, $sql_insert_cal_raw)) {
                        $resultData = "ข้อมูลถูกบันทึกเรียบร้อยแล้ว";
                        $_SESSION['resultData'] = $resultData;
                        echo "<script type='text/javascript'>";
                        echo "window.location = 'least_cost.php'; ";
                        echo "</script>";
                    } else {
                        echo "Error: " . $sql_insert_cal_raw . "<br>" . mysqli_error($conn);
                    }
                } else {
                    $sql_check_material_mineral = "SELECT * FROM mineral_source_raw WHERE ms_thainame = '$materialName'";
                    $result_material_mineral = mysqli_query($conn, $sql_check_material_mineral);
                    if (mysqli_num_rows($result_material_mineral) > 0) {
                        $row = mysqli_fetch_assoc($result_material_mineral);
                        $ms_id = $row['ms_id'];
                        // echo "ชื่อวัสดุ $materialName มี ms_id เท่ากับ $ms_id<br>";
    
                        $sql_insert_cal_ms = "INSERT INTO cal_ms (group_cal_id, ms_id, per_use, intake_use, price, intake_lc_result, material_result) 
                    VALUES ('$group_cal_id', '$ms_id', '$percent', '$demintake', '$materialPrice', '$price', '$materialResult')";

                        if (mysqli_query($conn, $sql_insert_cal_ms)) {
                            $resultData = "ข้อมูลถูกบันทึกเรียบร้อยแล้ว";
                            $_SESSION['resultData'] = $resultData;
                            echo "<script type='text/javascript'>";
                            echo "window.location = 'least_cost.php'; ";
                            echo "</script>";
                        } else {
                            echo "Error: " . $sql_insert_cal_ms . "<br>" . mysqli_error($conn);
                        }
                    }
                }
            }

        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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

        // foreach ($fields as $field => $fieldName) {
        //     ${$field} = isset($_POST[$field]) ? $_POST[$field] : 0;
        //     echo $fieldName . ": " . ${$field} . "<br>";
        // }
    
    }
    ?>
</body>

</html>