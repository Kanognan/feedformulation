<?php
session_start();
include("../server.php");

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
    $dnut_dm_avg = $_POST['dnut_dm_avg'];
    $dnut_cp_avg = $_POST['dnut_cp_avg'];
    $dnut_ee_avg = $_POST['dnut_ee_avg'];
    $dnut_cf_avg = $_POST['dnut_cf_avg'];
    $dnut_ash_avg = $_POST['dnut_ash_avg'];
    $dnut_nfe_avg = $_POST['dnut_nfe_avg'];
    $dnut_ndf_avg = $_POST['dnut_ndf_avg'];
    $dnut_adf_avg = $_POST['dnut_adf_avg'];
    $dnut_adl_avg = $_POST['dnut_adl_avg'];
    $dnut_ndicp_avg = $_POST['dnut_ndicp_avg'];
    $dnut_adicp_avg = $_POST['dnut_adicp_avg'];
    $dnut_ndfd_avg = $_POST['dnut_ndfd_avg'];
    $dnut_rup_avg = $_POST['dnut_rup_avg'];
    $dnut_dmd_avg = $_POST['dnut_dmd_avg'];
    $dnut_omd_avg = $_POST['dnut_omd_avg'];
    $dnut_tdn_avg = $_POST['dnut_tdn_avg'];
    $dnut_de_avg = $_POST['dnut_de_avg'];
    $dnut_me_avg = $_POST['dnut_me_avg'];
    $dnut_nel_avg = $_POST['dnut_nel_avg'];

    // ตัวแปรที่เกี่ยวกับ SD
    $dnut_dm_sd = $_POST['dnut_dm_sd'];
    $dnut_cp_sd = $_POST['dnut_cp_sd'];
    $dnut_ee_sd = $_POST['dnut_ee_sd'];
    $dnut_cf_sd = $_POST['dnut_cf_sd'];
    $dnut_ash_sd = $_POST['dnut_ash_sd'];
    $dnut_nfe_sd = $_POST['dnut_nfe_sd'];
    $dnut_ndf_sd = $_POST['dnut_ndf_sd'];
    $dnut_adf_sd = $_POST['dnut_adf_sd'];
    $dnut_adl_sd = $_POST['dnut_adl_sd'];
    $dnut_ndicp_sd = $_POST['dnut_ndicp_sd'];
    $dnut_adicp_sd = $_POST['dnut_adicp_sd'];
    $dnut_ndfd_sd = $_POST['dnut_ndfd_sd'];
    $dnut_rup_sd = $_POST['dnut_rup_sd'];
    $dnut_dmd_sd = $_POST['dnut_dmd_sd'];
    $dnut_omd_sd = $_POST['dnut_omd_sd'];
    $dnut_tdn_sd = $_POST['dnut_tdn_sd'];
    $dnut_de_sd = $_POST['dnut_de_sd'];
    $dnut_me_sd = $_POST['dnut_me_sd'];
    $dnut_nel_sd = $_POST['dnut_nel_sd'];

    // ตัวแปรที่เกี่ยวกับ N
    $dnut_dm_n = $_POST['dnut_dm_n'];
    $dnut_cp_n = $_POST['dnut_cp_n'];
    $dnut_ee_n = $_POST['dnut_ee_n'];
    $dnut_cf_n = $_POST['dnut_cf_n'];
    $dnut_ash_n = $_POST['dnut_ash_n'];
    $dnut_nfe_n = $_POST['dnut_nfe_n'];
    $dnut_ndf_n = $_POST['dnut_ndf_n'];
    $dnut_adf_n = $_POST['dnut_adf_n'];
    $dnut_adl_n = $_POST['dnut_adl_n'];
    $dnut_ndicp_n = $_POST['dnut_ndicp_n'];
    $dnut_adicp_n = $_POST['dnut_adicp_n'];
    $dnut_ndfd_n = $_POST['dnut_ndfd_n'];
    $dnut_rup_n = $_POST['dnut_rup_n'];
    $dnut_dmd_n = $_POST['dnut_dmd_n'];
    $dnut_omd_n = $_POST['dnut_omd_n'];
    $dnut_tdn_n = $_POST['dnut_tdn_n'];
    $dnut_de_n = $_POST['dnut_de_n'];
    $dnut_me_n = $_POST['dnut_me_n'];
    $dnut_nel_n = $_POST['dnut_nel_n'];

    if (isset($_GET['id'])) {
        $raw_id = $_GET['id'];
        $sql_check = "SELECT * FROM nutrition WHERE raw_id = '$raw_id'";
        $result_check = $conn->query($sql_check);

        foreach($result_check as $row){
            $nutrition_id = $row['nutrition_id'];
            $nutrition_detail_id = $row['nutrition_detail_id'];

            $sql_update_raw_material = "UPDATE raw_material SET 
                raw_engname='$raw_engname', 
                raw_thainame='$raw_thainame', 
                feed_class='$feed_class' 
                WHERE raw_id=$raw_id";
            $resql_update_raw_material = $conn->query($sql_update_raw_material);

            if (!$resql_update_raw_material) {
                echo "Error updating raw_material record: " . $conn->error;
            } else {
                $sqlAVG = "UPDATE nutrition_detail SET 
                            dnut_dm='$dnut_dm_avg', 
                            dnut_cp='$dnut_cp_avg', 
                            dnut_ee='$dnut_ee_avg', 
                            dnut_cf='$dnut_cf_avg', 
                            dnut_ash='$dnut_ash_avg', 
                            dnut_nfe='$dnut_nfe_avg', 
                            dnut_ndf='$dnut_ndf_avg', 
                            dnut_adf='$dnut_adf_avg', 
                            dnut_adl='$dnut_adl_avg', 
                            dnut_ndicp='$dnut_ndicp_avg', 
                            dnut_adicp='$dnut_adicp_avg', 
                            dnut_ndfd='$dnut_ndfd_avg', 
                            dnut_rup='$dnut_rup_avg', 
                            dnut_dmd='$dnut_dmd_avg', 
                            dnut_omd='$dnut_omd_avg', 
                            dnut_tdn='$dnut_tdn_avg', 
                            dnut_de='$dnut_de_avg', 
                            dnut_me='$dnut_me_avg', 
                            dnut_nel='$dnut_nel_avg' 
                            WHERE nutrition_detail_id = $nutrition_detail_id AND type_detail_id = 1";
                $resqlAVG = $conn->query($sqlAVG);

                $sqlSD = "UPDATE nutrition_detail SET 
                            dnut_dm='$dnut_dm_sd', 
                            dnut_cp='$dnut_cp_sd', 
                            dnut_ee='$dnut_ee_sd', 
                            dnut_cf='$dnut_cf_sd', 
                            dnut_ash='$dnut_ash_sd', 
                            dnut_nfe='$dnut_nfe_sd', 
                            dnut_ndf='$dnut_ndf_sd', 
                            dnut_adf='$dnut_adf_sd', 
                            dnut_adl='$dnut_adl_sd', 
                            dnut_ndicp='$dnut_ndicp_sd', 
                            dnut_adicp='$dnut_adicp_sd', 
                            dnut_ndfd='$dnut_ndfd_sd', 
                            dnut_rup='$dnut_rup_sd', 
                            dnut_dmd='$dnut_dmd_sd', 
                            dnut_omd='$dnut_omd_sd', 
                            dnut_tdn='$dnut_tdn_sd', 
                            dnut_de='$dnut_de_sd', 
                            dnut_me='$dnut_me_sd', 
                            dnut_nel='$dnut_nel_sd' 
                            WHERE nutrition_detail_id = $nutrition_detail_id AND type_detail_id = 2";
                $resqlSD = $conn->query($sqlSD);

                $sqlN = "UPDATE nutrition_detail SET 
                            dnut_dm='$dnut_dm_n', 
                            dnut_cp='$dnut_cp_n', 
                            dnut_ee='$dnut_ee_n', 
                            dnut_cf='$dnut_cf_n', 
                            dnut_ash='$dnut_ash_n', 
                            dnut_nfe='$dnut_nfe_n', 
                            dnut_ndf='$dnut_ndf_n', 
                            dnut_adf='$dnut_adf_n', 
                            dnut_adl='$dnut_adl_n', 
                            dnut_ndicp='$dnut_ndicp_n', 
                            dnut_adicp='$dnut_adicp_n', 
                            dnut_ndfd='$dnut_ndfd_n', 
                            dnut_rup='$dnut_rup_n', 
                            dnut_dmd='$dnut_dmd_n', 
                            dnut_omd='$dnut_omd_n', 
                            dnut_tdn='$dnut_tdn_n', 
                            dnut_de='$dnut_de_n', 
                            dnut_me='$dnut_me_n', 
                            dnut_nel='$dnut_nel_n' 
                            WHERE nutrition_detail_id = $nutrition_detail_id AND type_detail_id = 3";
                $resqlN = $conn->query($sqlN);
            }

            if ($resqlAVG && $resqlSD && $resqlN) {
				$resultDataEditRaw = "บันทึกข้อมูลสำเร็จ";
                $_SESSION['resultDataEditRaw'] = $resultDataEditRaw;
                echo "<script type='text/javascript'>";
                echo "window.location = 'edit_nutrition.php'; ";
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