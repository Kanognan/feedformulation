<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php //include "../header.php" ; ?>
    <title>Document</title>
</head>

<body>
    <?php
    include "../server.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $namedetail = $_POST["namedetail"];
        $detailRaw = $_POST["detailRaw"];

        // ตรวจสอบว่า $_SESSION["acc_id"] ถูกต้องและมีค่า
        if (!isset($_SESSION["acc_id"]) || empty($_SESSION["acc_id"])) {
            // ถ้าไม่ถูกต้องหรือไม่มีค่า แสดงข้อความและหยุดการทำงาน
            echo "Invalid or missing session data.";
            exit();
        }

        $acc_id = $_SESSION["acc_id"];

        // ตั้งคำสั่ง SQL INSERT สำหรับตารางที่ต้องการเพิ่มข้อมูล
        $insertQueryRawGroup = "INSERT INTO raw_group (group_name, group_description, acc_id) VALUES ('$namedetail', '$detailRaw', '$acc_id')";

        // ทำการ execute คำสั่ง SQL
        if (mysqli_query($conn, $insertQueryRawGroup)) {

            // เรียกใช้ last_insert_id() เพื่อหา ID ของข้อมูลที่เพิ่มล่าสุด (หากต้องการ)
            $raw_group_id = mysqli_insert_id($conn);

            // เพิ่มข้อมูลในตาราง raw_material_in_group หากมีข้อมูลที่เลือก
            if (isset($_POST["selectRaw"])) {
                $selectedRawMaterials = $_POST["selectRaw"];
                foreach ($selectedRawMaterials as $rawMaterialId) {
                    $insertRawMaterialQuery = "INSERT INTO raw_material_in_group (raw_id, raw_group_id) VALUES ('$rawMaterialId', '$raw_group_id')";
                    mysqli_query($conn, $insertRawMaterialQuery);
                }
            }

            // เพิ่มข้อมูลในตาราง mineral_has_raw หากมีข้อมูลที่เลือก
            if (isset($_POST["selectMineral"])) {
                $selectedMinerals = $_POST["selectMineral"];
                foreach ($selectedMinerals as $mineralId) {
                    $insertMineralQuery = "INSERT INTO mineral_source_in_group (ms_id, raw_group_id) VALUES ('$mineralId', '$raw_group_id')";
                    mysqli_query($conn, $insertMineralQuery);
                }
            }

            // เพิ่มข้อมูลในตาราง raw_material_has_raw หากมีข้อมูลที่เพิ่มเติม
            // if (isset($_POST["addRawKey"])) {
            //     $addedRawMaterials = $_POST["addRawKey"];
            //     foreach ($addedRawMaterials as $addedRawMaterial) {
            //         // ตรวจสอบว่า $addedRawMaterial ไม่ใช่ค่าว่าง
            //         if (!empty($addedRawMaterial)) {
            //             $insertAddedRawMaterialQuery = "INSERT INTO personal_raw (p_raw_name, raw_group_id) VALUES ('$addedRawMaterial', '$raw_group_id')";
            //             mysqli_query($conn, $insertAddedRawMaterialQuery);
            //         }
            //     }
            // }

            // // เพิ่มข้อมูลในตาราง mineral_has_raw หากมีข้อมูลที่เพิ่มเติม
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
            
            $resultData = "ข้อมูลถูกบันทึกเรียบร้อยแล้ว";
            $_SESSION['resultData'] = $resultData;
            echo "<script type='text/javascript'>";
            echo "window.location = 'select_raw.php'; ";
            echo "</script>";
            exit();

        } else {
            echo "ผิดพลาดในการบันทึกข้อมูล: " . mysqli_error($conn);
        }

        // ปิดการเชื่อมต่อกับฐานข้อมูล
        mysqli_close($conn);
    }
    ?>

</body>

</html>