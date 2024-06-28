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


if (isset($_POST['addRaw3'])) {
    $acc_id = $_SESSION['acc_id'];
    // $raw_engname = $_POST['raw_engname'];
    if (isset($_POST['raw_engname']) && !empty($_POST['raw_engname'])) {
        $raw_engname = $_POST['raw_engname'];
    } else {
        $raw_engname = '';
    }
    $raw_thainame = $_POST['raw_thainame'];


    // กรดอะมิโนในวัตถุดิบ AVG
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
    $type_detail_id_avg = 1;

    // กรดอะมิโนในวัตถุดิบ SD
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
    $type_detail_id_sd = 2;

    // กรดอะมิโนในวัตถุดิบ N
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
    $type_detail_id_n = 3;

    if ($conn) {
        $sql_rawthainame = "SELECT * FROM raw_material WHERE raw_thainame = '$raw_thainame'";
        $result_rawthainame = $conn->query($sql_rawthainame);

        if ($result_rawthainame->num_rows > 0) {
            $row = $result_rawthainame->fetch_assoc();
            $raw_id = $row['raw_id'];

            $sqlAVG = "INSERT INTO material_detail (dmat_ala, dmat_arg, dmat_asp, dmat_cys, dmat_glu, dmat_gly, dmat_his, dmat_hyl, dmat_hyp, dmat_ile, dmat_leu, dmat_lys, dmat_met, dmat_phe, dmat_pro, dmat_ser, dmat_thr, dmat_trp, dmat_tyr, dmat_val, type_detail_id) 
                    VALUES ('$dmat_ala_avg', '$dmat_arg_avg', '$dmat_asp_avg', '$dmat_cys_avg', '$dmat_glu_avg', '$dmat_gly_avg', '$dmat_his_avg', '$dmat_hyl_avg', '$dmat_hyp_avg', '$dmat_ile_avg', '$dmat_leu_avg', '$dmat_lys_avg', '$dmat_met_avg', '$dmat_phe_avg', '$dmat_pro_avg', '$dmat_ser_avg', '$dmat_thr_avg', '$dmat_trp_avg', '$dmat_tyr_avg', '$dmat_val_avg', '$type_detail_id_avg')";
            $resqlAVG = $conn->query($sqlAVG);
            $material_detail_id_avg = $conn->insert_id;

            $sqlSD = "INSERT INTO material_detail (dmat_ala, dmat_arg, dmat_asp, dmat_cys, dmat_glu, dmat_gly, dmat_his, dmat_hyl, dmat_hyp, dmat_ile, dmat_leu, dmat_lys, dmat_met, dmat_phe, dmat_pro, dmat_ser, dmat_thr, dmat_trp, dmat_tyr, dmat_val, type_detail_id) 
                    VALUES ('$dmat_ala_sd', '$dmat_arg_sd', '$dmat_asp_sd', '$dmat_cys_sd', '$dmat_glu_sd', '$dmat_gly_sd', '$dmat_his_sd', '$dmat_hyl_sd', '$dmat_hyp_sd', '$dmat_ile_sd', '$dmat_leu_sd', '$dmat_lys_sd', '$dmat_met_sd', '$dmat_phe_sd', '$dmat_pro_sd', '$dmat_ser_sd', '$dmat_thr_sd', '$dmat_trp_sd', '$dmat_tyr_sd', '$dmat_val_sd', '$type_detail_id_sd')";
            $resqlSD = $conn->query($sqlSD);
            $material_detail_id_sd = $conn->insert_id;

            $sqlN = "INSERT INTO material_detail (dmat_ala, dmat_arg, dmat_asp, dmat_cys, dmat_glu, dmat_gly, dmat_his, dmat_hyl, dmat_hyp, dmat_ile, dmat_leu, dmat_lys, dmat_met, dmat_phe, dmat_pro, dmat_ser, dmat_thr, dmat_trp, dmat_tyr, dmat_val, type_detail_id) 
                    VALUES ('$dmat_ala_n', '$dmat_arg_n', '$dmat_asp_n', '$dmat_cys_n', '$dmat_glu_n', '$dmat_gly_n', '$dmat_his_n', '$dmat_hyl_n', '$dmat_hyp_n', '$dmat_ile_n', '$dmat_leu_n', '$dmat_lys_n', '$dmat_met_n', '$dmat_phe_n', '$dmat_pro_n', '$dmat_ser_n', '$dmat_thr_n', '$dmat_trp_n', '$dmat_tyr_n', '$dmat_val_n', '$type_detail_id_n')";
            $resqlN = $conn->query($sqlN);
            $material_detail_id_n = $conn->insert_id;

            if ($resqlAVG && $resqlSD && $resqlN) {
                $sqlMaterialAVG = "INSERT INTO material (material_detail_id, raw_id) SELECT $material_detail_id_avg, $raw_id";
                $resqlMaterialAVG = $conn->query($sqlMaterialAVG);

                $sqlMaterialSD = "INSERT INTO material (material_detail_id, raw_id) SELECT $material_detail_id_sd, $raw_id";
                $resqlMaterialSD = $conn->query($sqlMaterialSD);

                $sqlMaterialN = "INSERT INTO material (material_detail_id, raw_id) SELECT $material_detail_id_n, $raw_id";
                $resqlMaterialN = $conn->query($sqlMaterialN);

                if ($resqlMaterialAVG && $resqlMaterialSD && $resqlMaterialN) {
                    echo "<script type='text/javascript'>";
                    echo "alert('บันทึกข้อมูลสำเร็จ');";
                    echo "window.location = 'edit_material.php'; ";
                    echo "</script>";
                } else {
                    echo "error: " . $conn->error;
                }
            } else {
                echo "Error inserting into material_detail table: " . $conn->error;
            }
        } else {
            $feed_class = $_POST['feed_class'];
            $type_raw_id = $_POST["type_id"];

            $sql1 = "INSERT INTO raw_material (type_raw_id, raw_engname, raw_thainame, feed_class, acc_id) VALUES ('$type_raw_id', '$raw_engname', '$raw_thainame', '$feed_class', '$acc_id')";
            $resql1 = $conn->query($sql1);
            $raw_id = $conn->insert_id;


            $sqlAVG = "INSERT INTO material_detail (dmat_ala, dmat_arg, dmat_asp, dmat_cys, dmat_glu, dmat_gly, dmat_his, dmat_hyl, dmat_hyp, dmat_ile, dmat_leu, dmat_lys, dmat_met, dmat_phe, dmat_pro, dmat_ser, dmat_thr, dmat_trp, dmat_tyr, dmat_val, type_detail_id) 
                    VALUES ('$dmat_ala_avg', '$dmat_arg_avg', '$dmat_asp_avg', '$dmat_cys_avg', '$dmat_glu_avg', '$dmat_gly_avg', '$dmat_his_avg', '$dmat_hyl_avg', '$dmat_hyp_avg', '$dmat_ile_avg', '$dmat_leu_avg', '$dmat_lys_avg', '$dmat_met_avg', '$dmat_phe_avg', '$dmat_pro_avg', '$dmat_ser_avg', '$dmat_thr_avg', '$dmat_trp_avg', '$dmat_tyr_avg', '$dmat_val_avg', '$type_detail_id_avg')";
            $resqlAVG = $conn->query($sqlAVG);
            $material_detail_id_avg = $conn->insert_id;

            $sqlSD = "INSERT INTO material_detail (dmat_ala, dmat_arg, dmat_asp, dmat_cys, dmat_glu, dmat_gly, dmat_his, dmat_hyl, dmat_hyp, dmat_ile, dmat_leu, dmat_lys, dmat_met, dmat_phe, dmat_pro, dmat_ser, dmat_thr, dmat_trp, dmat_tyr, dmat_val, type_detail_id) 
                    VALUES ('$dmat_ala_sd', '$dmat_arg_sd', '$dmat_asp_sd', '$dmat_cys_sd', '$dmat_glu_sd', '$dmat_gly_sd', '$dmat_his_sd', '$dmat_hyl_sd', '$dmat_hyp_sd', '$dmat_ile_sd', '$dmat_leu_sd', '$dmat_lys_sd', '$dmat_met_sd', '$dmat_phe_sd', '$dmat_pro_sd', '$dmat_ser_sd', '$dmat_thr_sd', '$dmat_trp_sd', '$dmat_tyr_sd', '$dmat_val_sd', '$type_detail_id_sd')";
            $resqlSD = $conn->query($sqlSD);
            $material_detail_id_sd = $conn->insert_id;

            $sqlN = "INSERT INTO material_detail (dmat_ala, dmat_arg, dmat_asp, dmat_cys, dmat_glu, dmat_gly, dmat_his, dmat_hyl, dmat_hyp, dmat_ile, dmat_leu, dmat_lys, dmat_met, dmat_phe, dmat_pro, dmat_ser, dmat_thr, dmat_trp, dmat_tyr, dmat_val, type_detail_id) 
                    VALUES ('$dmat_ala_n', '$dmat_arg_n', '$dmat_asp_n', '$dmat_cys_n', '$dmat_glu_n', '$dmat_gly_n', '$dmat_his_n', '$dmat_hyl_n', '$dmat_hyp_n', '$dmat_ile_n', '$dmat_leu_n', '$dmat_lys_n', '$dmat_met_n', '$dmat_phe_n', '$dmat_pro_n', '$dmat_ser_n', '$dmat_thr_n', '$dmat_trp_n', '$dmat_tyr_n', '$dmat_val_n', '$type_detail_id_n')";
            $resqlN = $conn->query($sqlN);
            $material_detail_id_n = $conn->insert_id;

            if ($resqlAVG && $resqlSD && $resqlN) {
                $sqlMaterialAVG = "INSERT INTO material (material_detail_id, raw_id) SELECT $material_detail_id_avg, $raw_id";
                $resqlMaterialAVG = $conn->query($sqlMaterialAVG);

                $sqlMaterialSD = "INSERT INTO material (material_detail_id, raw_id) SELECT $material_detail_id_sd, $raw_id";
                $resqlMaterialSD = $conn->query($sqlMaterialSD);

                $sqlMaterialN = "INSERT INTO material (material_detail_id, raw_id) SELECT $material_detail_id_n, $raw_id";
                $resqlMaterialN = $conn->query($sqlMaterialN);

                if ($resqlMaterialAVG && $resqlMaterialSD && $resqlMaterialN) {
                    echo "<script type='text/javascript'>";
                    echo "alert('บันทึกข้อมูลสำเร็จ');";
                    echo "window.location = 'edit_material.php'; ";
                    echo "</script>";
                } else {
                    echo "error: " . $conn->error;
                }
            } else {
                echo "Error inserting into material_detail table: " . $conn->error;
            }
        }

        $conn->close();

    } else {
        header("location: add_nutrition.php");
    }
}


?>