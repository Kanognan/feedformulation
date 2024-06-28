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
    $dmat_ala_avg = $_POST['dmat_ala_avg'];
    $dmat_arg_avg = $_POST['dmat_arg_avg'];
    $dmat_asp_avg = $_POST['dmat_asp_avg'];
    $dmat_cys_avg = $_POST['dmat_cys_avg'];
    $dmat_glu_avg = $_POST['dmat_glu_avg'];
    $dmat_gly_avg = $_POST['dmat_gly_avg'];
    $dmat_his_avg = $_POST['dmat_his_avg'];
    $dmat_hyl_avg = $_POST['dmat_hyl_avg'];
    $dmat_hyp_avg = $_POST['dmat_hyp_avg'];
    $dmat_ile_avg = $_POST['dmat_ile_avg'];
    $dmat_leu_avg = $_POST['dmat_leu_avg'];
    $dmat_lys_avg = $_POST['dmat_lys_avg'];
    $dmat_met_avg = $_POST['dmat_met_avg'];
    $dmat_phe_avg = $_POST['dmat_phe_avg'];
    $dmat_pro_avg = $_POST['dmat_pro_avg'];
    $dmat_ser_avg = $_POST['dmat_ser_avg'];
    $dmat_thr_avg = $_POST['dmat_thr_avg'];
    $dmat_trp_avg = $_POST['dmat_trp_avg'];
    $dmat_tyr_avg = $_POST['dmat_tyr_avg'];
    $dmat_val_avg = $_POST['dmat_val_avg'];

    // ตัวแปรที่เกี่ยวกับ SD
    $dmat_ala_sd = $_POST['dmat_ala_sd'];
    $dmat_arg_sd = $_POST['dmat_arg_sd'];
    $dmat_asp_sd = $_POST['dmat_asp_sd'];
    $dmat_cys_sd = $_POST['dmat_cys_sd'];
    $dmat_glu_sd = $_POST['dmat_glu_sd'];
    $dmat_gly_sd = $_POST['dmat_gly_sd'];
    $dmat_his_sd = $_POST['dmat_his_sd'];
    $dmat_hyl_sd = $_POST['dmat_hyl_sd'];
    $dmat_hyp_sd = $_POST['dmat_hyp_sd'];
    $dmat_ile_sd = $_POST['dmat_ile_sd'];
    $dmat_leu_sd = $_POST['dmat_leu_sd'];
    $dmat_lys_sd = $_POST['dmat_lys_sd'];
    $dmat_met_sd = $_POST['dmat_met_sd'];
    $dmat_phe_sd = $_POST['dmat_phe_sd'];
    $dmat_pro_sd = $_POST['dmat_pro_sd'];
    $dmat_ser_sd = $_POST['dmat_ser_sd'];
    $dmat_thr_sd = $_POST['dmat_thr_sd'];
    $dmat_trp_sd = $_POST['dmat_trp_sd'];
    $dmat_tyr_sd = $_POST['dmat_tyr_sd'];
    $dmat_val_sd = $_POST['dmat_val_sd'];

    // ตัวแปรที่เกี่ยวกับ N
    $dmat_ala_n = $_POST['dmat_ala_n'];
    $dmat_arg_n = $_POST['dmat_arg_n'];
    $dmat_asp_n = $_POST['dmat_asp_n'];
    $dmat_cys_n = $_POST['dmat_cys_n'];
    $dmat_glu_n = $_POST['dmat_glu_n'];
    $dmat_gly_n = $_POST['dmat_gly_n'];
    $dmat_his_n = $_POST['dmat_his_n'];
    $dmat_hyl_n = $_POST['dmat_hyl_n'];
    $dmat_hyp_n = $_POST['dmat_hyp_n'];
    $dmat_ile_n = $_POST['dmat_ile_n'];
    $dmat_leu_n = $_POST['dmat_leu_n'];
    $dmat_lys_n = $_POST['dmat_lys_n'];
    $dmat_met_n = $_POST['dmat_met_n'];
    $dmat_phe_n = $_POST['dmat_phe_n'];
    $dmat_pro_n = $_POST['dmat_pro_n'];
    $dmat_ser_n = $_POST['dmat_ser_n'];
    $dmat_thr_n = $_POST['dmat_thr_n'];
    $dmat_trp_n = $_POST['dmat_trp_n'];
    $dmat_tyr_n = $_POST['dmat_tyr_n'];
    $dmat_val_n = $_POST['dmat_val_n'];

    if (isset($_GET['id'])) {
        $raw_id = $_GET['id'];
        $sql_check = "SELECT * FROM material WHERE raw_id = '$raw_id'";
        $result_check = $conn->query($sql_check);

        foreach ($result_check as $row) {
            $material_id = $row['material_id'];
            $material_detail_id = $row['material_detail_id'];

            $sql_update_raw_material = "UPDATE raw_material SET 
                raw_engname='$raw_engname', 
                raw_thainame='$raw_thainame', 
                feed_class='$feed_class' 
                WHERE raw_id=$raw_id";
            $resql_update_raw_material = $conn->query($sql_update_raw_material);

            if (!$resql_update_raw_material) {
                echo "Error updating raw_material record: " . $conn->error;
            } else {
                $sqlAVG = "UPDATE material_detail SET 
                            dmat_ala = '$dmat_ala_avg',
                            dmat_arg = '$dmat_arg_avg',
                            dmat_asp = '$dmat_asp_avg',
                            dmat_cys = '$dmat_cys_avg',
                            dmat_glu = '$dmat_glu_avg',
                            dmat_gly = '$dmat_gly_avg',
                            dmat_his = '$dmat_his_avg',
                            dmat_hyl = '$dmat_hyl_avg',
                            dmat_hyp = '$dmat_hyp_avg',
                            dmat_ile = '$dmat_ile_avg',
                            dmat_leu = '$dmat_leu_avg',
                            dmat_lys = '$dmat_lys_avg',
                            dmat_met = '$dmat_met_avg',
                            dmat_phe = '$dmat_phe_avg',
                            dmat_pro = '$dmat_pro_avg',
                            dmat_ser = '$dmat_ser_avg',
                            dmat_thr = '$dmat_thr_avg',
                            dmat_trp = '$dmat_trp_avg',
                            dmat_tyr = '$dmat_tyr_avg',
                            dmat_val = '$dmat_val_avg'
                            WHERE material_detail_id = $material_detail_id AND type_detail_id = 1";
                $resqlAVG = $conn->query($sqlAVG);

                $sqlSD = "UPDATE material_detail SET 
                            dmat_ala = '$dmat_ala_sd',
                            dmat_arg = '$dmat_arg_sd',
                            dmat_asp = '$dmat_asp_sd',
                            dmat_cys = '$dmat_cys_sd',
                            dmat_glu = '$dmat_glu_sd',
                            dmat_gly = '$dmat_gly_sd',
                            dmat_his = '$dmat_his_sd',
                            dmat_hyl = '$dmat_hyl_sd',
                            dmat_hyp = '$dmat_hyp_sd',
                            dmat_ile = '$dmat_ile_sd',
                            dmat_leu = '$dmat_leu_sd',
                            dmat_lys = '$dmat_lys_sd',
                            dmat_met = '$dmat_met_sd',
                            dmat_phe = '$dmat_phe_sd',
                            dmat_pro = '$dmat_pro_sd',
                            dmat_ser = '$dmat_ser_sd',
                            dmat_thr = '$dmat_thr_sd',
                            dmat_trp = '$dmat_trp_sd',
                            dmat_tyr = '$dmat_tyr_sd',
                            dmat_val = '$dmat_val_sd'
                            WHERE material_detail_id = $material_detail_id AND type_detail_id = 2";
                $resqlSD = $conn->query($sqlSD);

                $sqlN = "UPDATE material_detail SET 
                            dmat_ala = '$dmat_ala_n',
                            dmat_arg = '$dmat_arg_n',
                            dmat_asp = '$dmat_asp_n',
                            dmat_cys = '$dmat_cys_n',
                            dmat_glu = '$dmat_glu_n',
                            dmat_gly = '$dmat_gly_n',
                            dmat_his = '$dmat_his_n',
                            dmat_hyl = '$dmat_hyl_n',
                            dmat_hyp = '$dmat_hyp_n',
                            dmat_ile = '$dmat_ile_n',
                            dmat_leu = '$dmat_leu_n',
                            dmat_lys = '$dmat_lys_n',
                            dmat_met = '$dmat_met_n',
                            dmat_phe = '$dmat_phe_n',
                            dmat_pro = '$dmat_pro_n',
                            dmat_ser = '$dmat_ser_n',
                            dmat_thr = '$dmat_thr_n',
                            dmat_trp = '$dmat_trp_n',
                            dmat_tyr = '$dmat_tyr_n',
                            dmat_val = '$dmat_val_n'
                            WHERE material_detail_id = $material_detail_id AND type_detail_id = 3";
                $resqlN = $conn->query($sqlN);
            }

            if ($resqlAVG && $resqlSD && $resqlN) {
				$resultDataEditRaw = "บันทึกข้อมูลสำเร็จ";
                $_SESSION['resultDataEditRaw'] = $resultDataEditRaw;
                echo "<script type='text/javascript'>";
                echo "window.location = 'edit_material.php'; ";
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