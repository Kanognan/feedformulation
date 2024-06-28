<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedformulation";

$conn = new mysqli($servername, $username, $password, $dbname);

date_default_timezone_set('asia/bangkok');
$create_At = date('Y-m-d H:i:s', time());

$errors = array();

if (isset($_POST['addRaw'])) {
    // รับค่าจากฟอร์มและตรวจสอบความถูกต้อง
    $type_raw_id = $_POST['type_raw_id'];
    $raw_engname = $_POST['raw_engname'];
    $raw_thainame = $_POST['raw_thainame'];
    $feed_class = $_POST['feed_class'];

    // ตัวแปรที่เกี่ยวกับ AVG
    $dminer_per_ca_avg = $_POST['dminer_per_ca_avg'];
    $dminer_per_p_avg = $_POST['dminer_per_p_avg'];
    $dminer_per_mg_avg = $_POST['dminer_per_mg_avg'];
    $dminer_per_k_avg = $_POST['dminer_per_k_avg'];
    $dminer_per_s_avg = $_POST['dminer_per_s_avg'];
    $dminer_per_na_avg = $_POST['dminer_per_na_avg'];
    $dminer_kg_cu_avg = $_POST['dminer_kg_cu_avg'];
    $dminer_kg_fe_avg = $_POST['dminer_kg_fe_avg'];
    $dminer_kg_mn_avg = $_POST['dminer_kg_mn_avg'];
    $dminer_kg_zn_avg = $_POST['dminer_kg_zn_avg'];

    // ตัวแปรที่เกี่ยวกับ SD
    $dminer_per_ca_sd = $_POST['dminer_per_ca_sd'];
    $dminer_per_p_sd = $_POST['dminer_per_p_sd'];
    $dminer_per_mg_sd = $_POST['dminer_per_mg_sd'];
    $dminer_per_k_sd = $_POST['dminer_per_k_sd'];
    $dminer_per_s_sd = $_POST['dminer_per_s_sd'];
    $dminer_per_na_sd = $_POST['dminer_per_na_sd'];
    $dminer_kg_cu_sd = $_POST['dminer_kg_cu_sd'];
    $dminer_kg_fe_sd = $_POST['dminer_kg_fe_sd'];
    $dminer_kg_mn_sd = $_POST['dminer_kg_mn_sd'];
    $dminer_kg_zn_sd = $_POST['dminer_kg_zn_sd'];

    // ตัวแปรที่เกี่ยวกับ N
    $dminer_per_ca_n = $_POST['dminer_per_ca_n'];
    $dminer_per_p_n = $_POST['dminer_per_p_n'];
    $dminer_per_mg_n = $_POST['dminer_per_mg_n'];
    $dminer_per_k_n = $_POST['dminer_per_k_n'];
    $dminer_per_s_n = $_POST['dminer_per_s_n'];
    $dminer_per_na_n = $_POST['dminer_per_na_n'];
    $dminer_kg_cu_n = $_POST['dminer_kg_cu_n'];
    $dminer_kg_fe_n = $_POST['dminer_kg_fe_n'];
    $dminer_kg_mn_n = $_POST['dminer_kg_mn_n'];
    $dminer_kg_zn_n = $_POST['dminer_kg_zn_n'];

    if (isset($_GET['id'])) {
        $raw_id = $_GET['id'];
        $sql_check = "SELECT * FROM minerals WHERE raw_id = '$raw_id'";
        $result_check = $conn->query($sql_check);

        foreach($result_check as $row){
            $minerals_id = $row['minerals_id'];
            $minerals_detail_id = $row['minerals_detail_id'];

            $sql_update_raw_material = "UPDATE raw_material SET 
                raw_engname='$raw_engname', 
                raw_thainame='$raw_thainame', 
                feed_class='$feed_class' 
                WHERE raw_id=$raw_id";
            $resql_update_raw_material = $conn->query($sql_update_raw_material);

            if (!$resql_update_raw_material) {
                echo "Error updating raw_material record: " . $conn->error;
            } else {
                $sqlAVG = "UPDATE minerals_detail SET 
                            dminer_per_ca='$dminer_per_ca_avg', 
                            dminer_per_p='$dminer_per_p_avg', 
                            dminer_per_mg='$dminer_per_mg_avg',
                            dminer_per_k='$dminer_per_k_avg', 
                            dminer_per_s='$dminer_per_s_avg', 
                            dminer_per_na='$dminer_per_na_avg', 
                            dminer_kg_cu='$dminer_kg_cu_avg', 
                            dminer_kg_fe='$dminer_kg_fe_avg', 
                            dminer_kg_mn='$dminer_kg_mn_avg', 
                            dminer_kg_zn='$dminer_kg_zn_avg' 
                            WHERE minerals_detail_id = $minerals_detail_id AND type_detail_id = 1";
                $resqlAVG = $conn->query($sqlAVG);

                $sqlSD = "UPDATE minerals_detail SET 
                            dminer_per_ca='$dminer_per_ca_sd', 
                            dminer_per_p='$dminer_per_p_sd', 
                            dminer_per_mg='$dminer_per_mg_sd',
                            dminer_per_k='$dminer_per_k_sd', 
                            dminer_per_s='$dminer_per_s_sd', 
                            dminer_per_na='$dminer_per_na_sd', 
                            dminer_kg_cu='$dminer_kg_cu_sd', 
                            dminer_kg_fe='$dminer_kg_fe_sd', 
                            dminer_kg_mn='$dminer_kg_mn_sd', 
                            dminer_kg_zn='$dminer_kg_zn_sd'  
                            WHERE minerals_detail_id = $minerals_detail_id AND type_detail_id = 2";
                $resqlSD = $conn->query($sqlSD);

                $sqlN = "UPDATE minerals_detail SET 
                            dminer_per_ca='$dminer_per_ca_n', 
                            dminer_per_p='$dminer_per_p_n', 
                            dminer_per_mg='$dminer_per_mg_n',
                            dminer_per_k='$dminer_per_k_n', 
                            dminer_per_s='$dminer_per_s_n', 
                            dminer_per_na='$dminer_per_na_n', 
                            dminer_kg_cu='$dminer_kg_cu_n', 
                            dminer_kg_fe='$dminer_kg_fe_n', 
                            dminer_kg_mn='$dminer_kg_mn_n', 
                            dminer_kg_zn='$dminer_kg_zn_n' 
                            WHERE minerals_detail_id = $minerals_detail_id AND type_detail_id = 3";
                $resqlN = $conn->query($sqlN);
            }

            if ($resqlAVG && $resqlSD && $resqlN) {
                echo "<script type='text/javascript'>";
                echo "alert('บันทึกข้อมูลสำเร็จ');";
                echo "window.location = 'edit_minerals.php'; ";
                echo "</script>";
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