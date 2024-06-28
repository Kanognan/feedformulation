<?php
session_start();
include "../server.php";

$errors = array();
if (isset($_POST['addRaw2'])) {
$acc_id = $_SESSION['acc_id'];

    // $raw_engname = $_POST['raw_engname'];
    if (isset($_POST['raw_engname']) && !empty($_POST['raw_engname'])) {
        $raw_engname = $_POST['raw_engname'];
    } else {
        $raw_engname = '';
    }
    $raw_thainame = $_POST['raw_thainame'];


    // ปริมาณแร่ธาตุ AVG
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
    $type_detail_id_avg = 1;

    // ปริมาณแร่ธาตุ SD
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
    $type_detail_id_sd = 2;

    // ปริมาณแร่ธาตุ N
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
    $type_detail_id_n = 3;


    if ($conn) {
        $sql_rawthainame = "SELECT * FROM raw_material WHERE raw_thainame = '$raw_thainame'";
        $result_rawthainame = $conn->query($sql_rawthainame);
        if ($result_rawthainame->num_rows > 0) {
            $row = $result_rawthainame->fetch_assoc();
            $raw_id = $row['raw_id'];
            
            $sqlAVG = "INSERT INTO minerals_detail (dminer_per_ca, dminer_per_p, dminer_per_mg, dminer_per_k, dminer_per_s, dminer_per_na, dminer_kg_cu, dminer_kg_fe, dminer_kg_mn, dminer_kg_zn, type_detail_id) 
            VALUES ('$dminer_per_ca_avg', '$dminer_per_p_avg', '$dminer_per_mg_avg', '$dminer_per_k_avg', '$dminer_per_s_avg', '$dminer_per_na_avg', '$dminer_kg_cu_avg', '$dminer_kg_fe_avg', '$dminer_kg_mn_avg', '$dminer_kg_zn_avg', '$type_detail_id_avg')";
            $resqlAVG = $conn->query($sqlAVG);
            $minerals_detail_id_avg = $conn->insert_id;

            $sqlSD = "INSERT INTO minerals_detail (dminer_per_ca, dminer_per_p, dminer_per_mg, dminer_per_k, dminer_per_s, dminer_per_na, dminer_kg_cu, dminer_kg_fe, dminer_kg_mn, dminer_kg_zn, type_detail_id) 
            VALUES ('$dminer_per_ca_sd', '$dminer_per_p_sd', '$dminer_per_mg_sd', '$dminer_per_k_sd', '$dminer_per_s_sd', '$dminer_per_na_sd', '$dminer_kg_cu_sd', '$dminer_kg_fe_sd', '$dminer_kg_mn_sd', '$dminer_kg_zn_sd', '$type_detail_id_sd')";
            $resqlSD = $conn->query($sqlSD);
            $minerals_detail_id_sd = $conn->insert_id;

            $sqlN = "INSERT INTO minerals_detail (dminer_per_ca, dminer_per_p, dminer_per_mg, dminer_per_k, dminer_per_s, dminer_per_na, dminer_kg_cu, dminer_kg_fe, dminer_kg_mn, dminer_kg_zn, type_detail_id) 
            VALUES ('$dminer_per_ca_n', '$dminer_per_p_n', '$dminer_per_mg_n', '$dminer_per_k_n', '$dminer_per_s_n', '$dminer_per_na_n', '$dminer_kg_cu_n', '$dminer_kg_fe_n', '$dminer_kg_mn_n', '$dminer_kg_zn_n', '$type_detail_id_n')";
            $resqlN = $conn->query($sqlN);
            $minerals_detail_id_n = $conn->insert_id;

            if ($resqlAVG && $resqlSD && $resqlN) {
                $sqlMineralsAVG = "INSERT INTO minerals (minerals_detail_id, raw_id) SELECT $minerals_detail_id_avg, $raw_id";
                $resqlMineralsAVG = $conn->query($sqlMineralsAVG);

                $sqlMineralsSD = "INSERT INTO minerals (minerals_detail_id, raw_id) SELECT $minerals_detail_id_sd, $raw_id";
                $resqlMineralsSD = $conn->query($sqlMineralsSD);

                $sqlMineralsN = "INSERT INTO minerals (minerals_detail_id, raw_id) SELECT $minerals_detail_id_n, $raw_id";
                $resqlMineralsN = $conn->query($sqlMineralsN);

                if ($resqlMineralsAVG && $resqlMineralsSD && $resqlMineralsN) {
                    echo "<script type='text/javascript'>";
                    echo "alert('บันทึกข้อมูลสำเร็จ');";
                    echo "window.location = 'edit_minerals.php'; ";
                    echo "</script>";
                } else {
                    echo "error: " . $conn->error;
                }
            } else {
                echo "Error inserting into minerals_detail table: " . $conn->error;
            }
        } else {
            $feed_class = $_POST['feed_class'];
            $type_raw_id = $_POST["type_id"];

            $sql1 = "INSERT INTO raw_material (type_raw_id, raw_engname, raw_thainame, feed_class, acc_id) VALUES ('$type_raw_id', '$raw_engname', '$raw_thainame', '$feed_class', '$acc_id')";
            $resql1 = $conn->query($sql1);
            $raw_id = $conn->insert_id;

            $sqlAVG = "INSERT INTO minerals_detail (dminer_per_ca, dminer_per_p, dminer_per_mg, dminer_per_k, dminer_per_s, dminer_per_na, dminer_kg_cu, dminer_kg_fe, dminer_kg_mn, dminer_kg_zn, type_detail_id) 
                    VALUES ('$dminer_per_ca_avg', '$dminer_per_p_avg', '$dminer_per_mg_avg', '$dminer_per_k_avg', '$dminer_per_s_avg', '$dminer_per_na_avg', '$dminer_kg_cu_avg', '$dminer_kg_fe_avg', '$dminer_kg_mn_avg', '$dminer_kg_zn_avg', '$type_detail_id_avg')";
            $resqlAVG = $conn->query($sqlAVG);
            $minerals_detail_id_avg = $conn->insert_id;

            $sqlSD = "INSERT INTO minerals_detail (dminer_per_ca, dminer_per_p, dminer_per_mg, dminer_per_k, dminer_per_s, dminer_per_na, dminer_kg_cu, dminer_kg_fe, dminer_kg_mn, dminer_kg_zn, type_detail_id) 
                    VALUES ('$dminer_per_ca_sd', '$dminer_per_p_sd', '$dminer_per_mg_sd', '$dminer_per_k_sd', '$dminer_per_s_sd', '$dminer_per_na_sd', '$dminer_kg_cu_sd', '$dminer_kg_fe_sd', '$dminer_kg_mn_sd', '$dminer_kg_zn_sd', '$type_detail_id_sd')";
            $resqlSD = $conn->query($sqlSD);
            $minerals_detail_id_sd = $conn->insert_id;


            $sqlN = "INSERT INTO minerals_detail (dminer_per_ca, dminer_per_p, dminer_per_mg, dminer_per_k, dminer_per_s, dminer_per_na, dminer_kg_cu, dminer_kg_fe, dminer_kg_mn, dminer_kg_zn, type_detail_id) 
                    VALUES ('$dminer_per_ca_n', '$dminer_per_p_n', '$dminer_per_mg_n', '$dminer_per_k_n', '$dminer_per_s_n', '$dminer_per_na_n', '$dminer_kg_cu_n', '$dminer_kg_fe_n', '$dminer_kg_mn_n', '$dminer_kg_zn_n', '$type_detail_id_n')";
            $resqlN = $conn->query($sqlN);
            $minerals_detail_id_n = $conn->insert_id;


            if ($resqlAVG && $resqlSD && $resqlN) {
                $sqlMineralsAVG = "INSERT INTO minerals (minerals_detail_id, raw_id) SELECT $minerals_detail_id_avg, $raw_id";
                $resqlMineralsAVG = $conn->query($sqlMineralsAVG);

                $sqlMineralsSD = "INSERT INTO minerals (minerals_detail_id, raw_id) SELECT $minerals_detail_id_sd, $raw_id";
                $resqlMineralsSD = $conn->query($sqlMineralsSD);

                $sqlMineralsN = "INSERT INTO minerals (minerals_detail_id, raw_id) SELECT $minerals_detail_id_n, $raw_id";
                $resqlMineralsN = $conn->query($sqlMineralsN);

                if ($resqlMineralsAVG && $resqlMineralsSD && $resqlMineralsN) {
                    echo "<script type='text/javascript'>";
                    echo "alert('บันทึกข้อมูลสำเร็จ');";
                    echo "window.location = 'edit_minerals.php'; ";
                    echo "</script>";
                } else {
                    echo "error: " . $conn->error;
                }
            } else {
                echo "Error inserting into minerals_detail table: " . $conn->error;
            }
        }

        $conn->close();

    } else {
        header("location: add_nutrition.php");
    }
}
?>