<?php
session_start();
include "../server.php";
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "feedformulation";

// $conn = new mysqli($servername, $username, $password, $dbname);

// date_default_timezone_set('asia/bangkok');
// $create_At = date('Y-m-d H:i:s', time());

$errors = array();

if (isset($_POST['addSourceM'])) {
    $acc_id = 1;
    $ms_thainame = $_POST["ms_thainame"];
    $ms_engname = $_POST['ms_engname'];
    $feed_class = $_POST['feed_class'];
    $type_ms_id = $_POST["type_ms_id"];
    $ds_DM = $_POST['ds_DM'];
    $ds_ca = $_POST['ds_ca'];
    $ds_p = $_POST['ds_p'];
    $ds_mg = $_POST['ds_mg'];
    $ds_k = $_POST['ds_k'];
    $ds_s = $_POST['ds_s'];
    $ds_na = $_POST['ds_na'];
    $ds_cl = $_POST['ds_cl'];
    $ds_cu = $_POST['ds_cu'];
    $ds_fe = $_POST['ds_fe'];
    $ds_mn = $_POST['ds_mn'];
    $ds_zn = $_POST['ds_zn'];
    $ds_co = $_POST['ds_co'];
    $ds_i = $_POST['ds_i'];
    $ds_se = $_POST['ds_se'];
    $vitA = $_POST['vitA'];
    $vitD = $_POST['vitD'];
    $vitE = $_POST['vitE'];


    if ($conn) {
        $sql = "INSERT INTO mineral_source_raw (ms_thainame, ms_engname, feed_class, type_ms_id, acc_id) 
                                VALUES ('$ms_thainame', '$ms_engname', '$feed_class', '$type_ms_id', '$acc_id')";
        $resql = $conn->query($sql);
        $ms_id = $conn->insert_id;

        if ($resql) {
            // ทำการ insert ข้อมูลในตาราง source_minerals_detail
            $sql1 = "INSERT INTO source_minerals_detail (ds_DM, ds_ca, ds_p, ds_mg, ds_k, ds_s, ds_na, ds_cl, ds_cu, ds_fe, ds_mn, ds_zn, ds_co, ds_i, ds_se, vitA, vitD, vitE) 
                                    VALUES ('$ds_DM', '$ds_ca', '$ds_p', '$ds_mg', '$ds_k', '$ds_s', '$ds_na', '$ds_cl', '$ds_cu', '$ds_fe', '$ds_mn', '$ds_zn', '$ds_co', '$ds_i','$ds_se','$vitA','$vitD','$vitE')";
            $resql1 = $conn->query($sql1);
            $source_detail_id = $conn->insert_id;

            if ($resql1) {
                // ทำการ insert ข้อมูลในตาราง source_minerals
                $sqlSourceMinerals = "INSERT INTO source_minerals (source_detail_id, ms_id) SELECT $source_detail_id, $ms_id";
                $resqlSourceMinerals = $conn->query($sqlSourceMinerals);

                if ($resqlSourceMinerals) {
                    echo "<script type='text/javascript'>";
                    echo "alert('บันทึกข้อมูลสำเร็จ');";
                    echo "window.location = 'edit_source_minerals.php'; ";
                    echo "</script>";
                } else {
                    echo "error: " . $conn->error;
                }
            } else {
                echo "Error inserting into source_minerals_detail table: " . $conn->error;
            }
        } else {
            echo "Error inserting into mineral_source_raw table: " . $conn->error;
        }
    } else {
        // ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้
        echo '<script>alert("ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้");</script>';
    }

} else {
    header("location: add_nutrition.php");
}

$conn->close();
?>