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


if (isset($_POST['addRaw'])) {
    $acc_id = 1;

    // $raw_engname = $_POST['raw_engname'];
    if (isset($_POST['raw_engname']) && !empty($_POST['raw_engname'])) {
        $raw_engname = $_POST['raw_engname'];
    } else {
        $raw_engname = '';
    }
    $raw_thainame = $_POST['raw_thainame'];

    // คุณค่าทางโภชนะของวัตถุดิบ AVG
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
    $type_detail_id_avg = 1;

    // คุณค่าทางโภชนะของวัตถุดิบ SD
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
    $type_detail_id_sd = 2;

    // คุณค่าทางโภชนะของวัตถุดิบ N
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
    $type_detail_id_n = 3;


    if ($conn) {
        $sql_rawthainame = "SELECT * FROM raw_material WHERE raw_thainame = '$raw_thainame'";
        $result_rawthainame = $conn->query($sql_rawthainame);
        if ($result_rawthainame->num_rows > 0) {
            $row = $result_rawthainame->fetch_assoc();
            $raw_id = $row['raw_id'];
            
            $sqlAVG = "INSERT INTO nutrition_detail (dnut_dm, dnut_cp, dnut_ee, dnut_cf, dnut_ash, dnut_nfe, dnut_ndf, dnut_adf, dnut_adl, dnut_ndicp, dnut_adicp, dnut_ndfd, dnut_rup, dnut_dmd, dnut_omd, dnut_tdn, dnut_de, dnut_me, dnut_nel, type_detail_id)  
                VALUES ('$dnut_dm_avg', '$dnut_cp_avg', '$dnut_ee_avg', '$dnut_cf_avg', '$dnut_ash_avg', '$dnut_nfe_avg', '$dnut_ndf_avg', '$dnut_adf_avg', '$dnut_adl_avg', '$dnut_ndicp_avg', '$dnut_adicp_avg', '$dnut_ndfd_avg', '$dnut_rup_avg', '$dnut_dmd_avg', '$dnut_omd_avg', '$dnut_tdn_avg', '$dnut_de_avg', '$dnut_me_avg', '$dnut_nel_avg', '$type_detail_id_avg')";
            $resqlAVG = $conn->query($sqlAVG);
            $nutrition_detail_id_avg = $conn->insert_id;

            $sqlSD = "INSERT INTO nutrition_detail (dnut_dm, dnut_cp, dnut_ee, dnut_cf, dnut_ash, dnut_nfe, dnut_ndf, dnut_adf, dnut_adl, dnut_ndicp, dnut_adicp, dnut_ndfd, dnut_rup, dnut_dmd, dnut_omd, dnut_tdn, dnut_de, dnut_me, dnut_nel, type_detail_id)  
                VALUES ('$dnut_dm_sd', '$dnut_cp_sd', '$dnut_ee_sd', '$dnut_cf_sd', '$dnut_ash_sd', '$dnut_nfe_sd', '$dnut_ndf_sd', '$dnut_adf_sd', '$dnut_adl_sd', '$dnut_ndicp_sd', '$dnut_adicp_sd', '$dnut_ndfd_sd', '$dnut_rup_sd', '$dnut_dmd_sd', '$dnut_omd_sd', '$dnut_tdn_sd', '$dnut_de_sd', '$dnut_me_sd', '$dnut_nel_sd', '$type_detail_id_sd')";
            $resqlSD = $conn->query($sqlSD);
            $nutrition_detail_id_sd = $conn->insert_id;

            $sqlN = "INSERT INTO nutrition_detail (dnut_dm, dnut_cp, dnut_ee, dnut_cf, dnut_ash, dnut_nfe, dnut_ndf, dnut_adf, dnut_adl, dnut_ndicp, dnut_adicp, dnut_ndfd, dnut_rup, dnut_dmd, dnut_omd, dnut_tdn, dnut_de, dnut_me, dnut_nel, type_detail_id)  
                VALUES ('$dnut_dm_n', '$dnut_cp_n', '$dnut_ee_n', '$dnut_cf_n', '$dnut_ash_n', '$dnut_nfe_n', '$dnut_ndf_n', '$dnut_adf_n', '$dnut_adl_n', '$dnut_ndicp_n', '$dnut_adicp_n', '$dnut_ndfd_n', '$dnut_rup_n', '$dnut_dmd_n', '$dnut_omd_n', '$dnut_tdn_n', '$dnut_de_n', '$dnut_me_n', '$dnut_nel_n', '$type_detail_id_n')";
            $resqlN = $conn->query($sqlN);
            $nutrition_detail_id_n = $conn->insert_id;

            if ($resqlAVG && $resqlSD && $resqlN) {
                $sqlNutritionAVG = "INSERT INTO nutrition (nutrition_detail_id, raw_id) SELECT $nutrition_detail_id_avg, $raw_id";
                $resqlNutritionAVG = $conn->query($sqlNutritionAVG);

                $sqlNutritionSD = "INSERT INTO nutrition (nutrition_detail_id, raw_id) SELECT $nutrition_detail_id_sd, $raw_id";
                $resqlNutritionSD = $conn->query($sqlNutritionSD);

                $sqlNutritionN = "INSERT INTO nutrition (nutrition_detail_id, raw_id) SELECT $nutrition_detail_id_n, $raw_id";
                $resqlNutritionN = $conn->query($sqlNutritionN);

                if ($resqlNutritionAVG && $resqlNutritionSD && $resqlNutritionN) {
                    echo "<script type='text/javascript'>";
                    echo "alert('บันทึกข้อมูลสำเร็จ');";
                    echo "window.location = 'edit_nutrition.php'; ";
                    echo "</script>";
                } else {
                    echo "error: " . $conn->error;
                }
            } else {
                echo "Error inserting into nutrition_detail table: " . $conn->error;
            }

        } else {
            $type_raw_id = $_POST["type_id"];
            $feed_class = $_POST['feed_class'];

            $sql1 = "INSERT INTO raw_material (type_raw_id, raw_engname, raw_thainame, feed_class, acc_id) VALUES ('$type_raw_id', '$raw_engname', '$raw_thainame', '$feed_class', '$acc_id')";
            $resql1 = $conn->query($sql1);
            $raw_id = $conn->insert_id;

            $sqlAVG = "INSERT INTO nutrition_detail (dnut_dm, dnut_cp, dnut_ee, dnut_cf, dnut_ash, dnut_nfe, dnut_ndf, dnut_adf, dnut_adl, dnut_ndicp, dnut_adicp, dnut_ndfd, dnut_rup, dnut_dmd, dnut_omd, dnut_tdn, dnut_de, dnut_me, dnut_nel, type_detail_id)  
                        VALUES ('$dnut_dm_avg', '$dnut_cp_avg', '$dnut_ee_avg', '$dnut_cf_avg', '$dnut_ash_avg', '$dnut_nfe_avg', '$dnut_ndf_avg', '$dnut_adf_avg', '$dnut_adl_avg', '$dnut_ndicp_avg', '$dnut_adicp_avg', '$dnut_ndfd_avg', '$dnut_rup_avg', '$dnut_dmd_avg', '$dnut_omd_avg', '$dnut_tdn_avg', '$dnut_de_avg', '$dnut_me_avg', '$dnut_nel_avg', '$type_detail_id_avg')";
            $resqlAVG = $conn->query($sqlAVG);
            $nutrition_detail_id_avg = $conn->insert_id;

            $sqlSD = "INSERT INTO nutrition_detail (dnut_dm, dnut_cp, dnut_ee, dnut_cf, dnut_ash, dnut_nfe, dnut_ndf, dnut_adf, dnut_adl, dnut_ndicp, dnut_adicp, dnut_ndfd, dnut_rup, dnut_dmd, dnut_omd, dnut_tdn, dnut_de, dnut_me, dnut_nel, type_detail_id)  
                        VALUES ('$dnut_dm_sd', '$dnut_cp_sd', '$dnut_ee_sd', '$dnut_cf_sd', '$dnut_ash_sd', '$dnut_nfe_sd', '$dnut_ndf_sd', '$dnut_adf_sd', '$dnut_adl_sd', '$dnut_ndicp_sd', '$dnut_adicp_sd', '$dnut_ndfd_sd', '$dnut_rup_sd', '$dnut_dmd_sd', '$dnut_omd_sd', '$dnut_tdn_sd', '$dnut_de_sd', '$dnut_me_sd', '$dnut_nel_sd', '$type_detail_id_sd')";
            $resqlSD = $conn->query($sqlSD);
            $nutrition_detail_id_sd = $conn->insert_id;

            $sqlN = "INSERT INTO nutrition_detail (dnut_dm, dnut_cp, dnut_ee, dnut_cf, dnut_ash, dnut_nfe, dnut_ndf, dnut_adf, dnut_adl, dnut_ndicp, dnut_adicp, dnut_ndfd, dnut_rup, dnut_dmd, dnut_omd, dnut_tdn, dnut_de, dnut_me, dnut_nel, type_detail_id)  
                        VALUES ('$dnut_dm_n', '$dnut_cp_n', '$dnut_ee_n', '$dnut_cf_n', '$dnut_ash_n', '$dnut_nfe_n', '$dnut_ndf_n', '$dnut_adf_n', '$dnut_adl_n', '$dnut_ndicp_n', '$dnut_adicp_n', '$dnut_ndfd_n', '$dnut_rup_n', '$dnut_dmd_n', '$dnut_omd_n', '$dnut_tdn_n', '$dnut_de_n', '$dnut_me_n', '$dnut_nel_n', '$type_detail_id_n')";
            $resqlN = $conn->query($sqlN);
            $nutrition_detail_id_n = $conn->insert_id;

            if ($resqlAVG && $resqlSD && $resqlN) {
                $sqlNutritionAVG = "INSERT INTO nutrition (nutrition_detail_id, raw_id) SELECT $nutrition_detail_id_avg, $raw_id";
                $resqlNutritionAVG = $conn->query($sqlNutritionAVG);

                $sqlNutritionSD = "INSERT INTO nutrition (nutrition_detail_id, raw_id) SELECT $nutrition_detail_id_sd, $raw_id";
                $resqlNutritionSD = $conn->query($sqlNutritionSD);

                $sqlNutritionN = "INSERT INTO nutrition (nutrition_detail_id, raw_id) SELECT $nutrition_detail_id_n, $raw_id";
                $resqlNutritionN = $conn->query($sqlNutritionN);

                if ($resqlNutritionAVG && $resqlNutritionSD && $resqlNutritionN) {
                    echo "<script type='text/javascript'>";
                    echo "alert('บันทึกข้อมูลสำเร็จ');";
                    echo "window.location = 'edit_nutrition.php'; ";
                    echo "</script>";
                } else {
                    echo "error: " . $conn->error;
                }
            } else {
                echo "Error inserting into nutrition_detail table: " . $conn->error;
            }
        }

        $conn->close();

    } else {
        header("location: add_nutrition.php");
    }
}


?>