<?php session_start();?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php //include("../header.php"); ?>
    <title>Document</title>
</head>

<body>
    <?php
    include "../server.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $namedetail = $_POST["namedetail"];
        $detailRaw = $_POST["detailRaw"];

        if (!isset($_SESSION["acc_id"]) || empty($_SESSION["acc_id"])) {
            echo "Invalid or missing session data.";
            exit();
        }

        $acc_id = $_SESSION["acc_id"];

        if (isset($_POST['rawGroupId'])) {
            $raw_group_id = $_POST['rawGroupId'];
            $updateQueryRawGroup = "UPDATE raw_group SET group_name = '$namedetail', group_description = '$detailRaw' WHERE raw_group_id = $raw_group_id AND acc_id = $acc_id";



            $resultUpdateRawGroup = mysqli_query($conn, $updateQueryRawGroup);

            if ($resultUpdateRawGroup) {
                if (isset($_POST["selectRaw"])) {
                    $selectedRawMaterials = $_POST["selectRaw"];
                    foreach ($selectedRawMaterials as $rawMaterialId) {
                        $insertRawMaterialQuery = "INSERT INTO raw_material_in_group (raw_id, raw_group_id) VALUES ('$rawMaterialId', '$raw_group_id')";
                        mysqli_query($conn, $insertRawMaterialQuery);
                    }
                }

                if (isset($_POST["selectMineral"])) {
                    $selectedMinerals = $_POST["selectMineral"];
                    foreach ($selectedMinerals as $mineralId) {
                        $insertMineralQuery = "INSERT INTO mineral_source_in_group (ms_id, raw_group_id) VALUES ('$mineralId', '$raw_group_id')";
                        mysqli_query($conn, $insertMineralQuery);
                    }
                }

                // if (isset($_POST['addRawKey'])) {
                //     $addedRawMaterials = $_POST["addRawKey"];
                //     foreach ($addedRawMaterials as $addedRawMaterial) {
                //         // ตรวจสอบว่า $addedRawMaterial ไม่ใช่ค่าว่าง
                //         if (!empty($addedRawMaterial)) {
                //             $insertAddedRawMaterialQuery = "INSERT INTO personal_raw (p_raw_name, raw_group_id) VALUES ('$addedRawMaterial', '$raw_group_id')";
                //             mysqli_query($conn, $insertAddedRawMaterialQuery);
                //         }
                //     }
                // }

                // if (isset($_POST["addMineralKey"])) {
                //     $addedMinerals = $_POST["addMineralKey"];
                //     foreach ($addedMinerals as $addedMineral) {
                //         // ตรวจสอบว่า $addedMineral ไม่ใช่ค่าว่าง
                //         if (!empty($addedMineral)) {
                //             $insertAddedMineralQuery = "INSERT INTO personal_ms (p_ms_name, raw_group_id) VALUES ('$addedMineral', '$raw_group_id')";
                //             mysqli_query($conn, $insertAddedMineralQuery);
                //         }
                //     }
                // }

                $resultUp = "ข้อมูลถูกอัพเดตเรียบร้อย";
                $_SESSION['resultUp'] = $resultUp;
                header("Location: select_raw_edit.php?raw_group_id=$raw_group_id");
                exit();

            } else {
                echo "ผิดพลาดในการบันทึกข้อมูล: " . mysqli_error($conn);
            }
        } else {
            echo "No rawGroupId";
        }

        // ปิดการเชื่อมต่อกับฐานข้อมูล
        mysqli_close($conn);
    }
    ?>

</body>

</html>