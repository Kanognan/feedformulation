<?php
session_start();
include("../server.php");

date_default_timezone_set('asia/bangkok');
$create_At = date('Y-m-d H:i:s', time());

$errors = array();

if (isset($_POST['addRaw'])) {
    // รับค่าจากฟอร์มและตรวจสอบความถูกต้อง
    $type_ms_id = $_POST['type_ms_id'];
    $ms_engname = $_POST['ms_engname'];
    $ms_thainame = $_POST['ms_thainame'];
    $feed_class = $_POST['feed_class'];


    // ตัวแปรที่เกี่ยวกับ N
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

    if (isset($_GET['id'])) {
        $ms_id = $_GET['id'];
        $sql_check = "SELECT * FROM source_minerals WHERE ms_id = '$ms_id'";
        $result_check = $conn->query($sql_check);

        foreach ($result_check as $row) {
            $source_id = $row['source_id'];
            $source_detail_id = $row['source_detail_id'];

            $sql_update_ms = "UPDATE mineral_source_raw SET 
                ms_engname='$ms_engname', 
                ms_thainame='$ms_thainame', 
                feed_class='$feed_class' 
                WHERE ms_id=$ms_id";
            $resql_update_ms = $conn->query($sql_update_ms);

            if (!$resql_update_ms) {
                echo "Error updating mineral_source_raw record: " . $conn->error;
            } else {
                $sqlMs = "UPDATE source_minerals_detail SET 
                            ds_DM = '$ds_DM',
                            ds_ca = '$ds_ca',
                            ds_p = '$ds_p',
                            ds_mg = '$ds_mg',
                            ds_k = '$ds_k',
                            ds_s = '$ds_s',
                            ds_na = '$ds_na',
                            ds_cl = '$ds_cl',
                            ds_cu = '$ds_cu',
                            ds_fe = '$ds_fe',
                            ds_mn = '$ds_mn',
                            ds_zn = '$ds_zn',
                            ds_co = '$ds_co',
                            ds_i = '$ds_i',
                            ds_se = '$ds_se',
                            ds_vitA = '$vitA',
                            ds_vitD = '$vitD',
                            ds_vitE = '$vitE'
                            WHERE source_detail_id = $source_detail_id";
                $resqlMs = $conn->query($sqlMs);
            }

            if ($resqlMs) {
				$resultDataEditRaw = "บันทึกข้อมูลสำเร็จ";
                $_SESSION['resultDataEditRaw'] = $resultDataEditRaw;
                echo "<script type='text/javascript'>";
                echo "window.location = 'edit_source_minerals.php'; ";
                echo "</script>";
                exit();
            } else {
                echo "error: " . $conn->error;
            }
        }

    } else {
        echo "ไม่มีข้อมูลที่ถูกส่งมาหรือไม่ใช่อาร์เรย์";
    }
}

$conn->close();
?>