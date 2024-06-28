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


if (isset($_POST['addraw'])) {
    $acc_id = 1;
    $type_raw_id = $_POST["type_id"];
    $type_detail_id = $_POST["type_detail_id"];
    $raw_engname = $_POST['raw_engname'];
    $raw_thainame = $_POST['raw_thainame'];
    $raw_price = $_POST['raw_price'];
    $feed_class = $_POST['feed_class'];

    // คุณค่าทางโภชนะของวัตถุดิบ
    $dnut_dm = $_POST['dnut_dm'];
    $dnut_cp = $_POST['dnut_cp'];
    $dnut_ee = $_POST['dnut_ee'];
    $dnut_cf = $_POST['dnut_cf'];
    $dnut_ash = $_POST['dnut_ash'];
    $dnut_nfe = $_POST['dnut_nfe'];
    $dnut_ndf = $_POST['dnut_ndf'];
    $dnut_adf = $_POST['dnut_adf'];
    $dnut_adl = $_POST['dnut_adl'];
    $dnut_ndicp = $_POST['dnut_ndicp'];
    $dnut_adicp = $_POST['dnut_adicp'];
    $dnut_ndfd = $_POST['dnut_ndfd'];
    $dnut_rup = $_POST['dnut_rup'];
    $dnut_dmd = $_POST['dnut_dmd'];
    $dnut_omd = $_POST['dnut_omd'];
    $dnut_tdn = $_POST['dnut_tdn'];
    $dnut_de = $_POST['dnut_de'];
    $dnut_me = $_POST['dnut_me'];
    $dnut_nel = $_POST['dnut_nel'];

 

    // กรดอะมิโนในวัตถุดิบ
    $dmat_ala = $_POST['dmat_ala'];
    $dmat_arg = $_POST['dmat_arg'];
    $dmat_asp = $_POST['dmat_asp'];
    $dmat_cys = $_POST['dmat_cys'];
    $dmat_glu = $_POST['dmat_glu'];
    $dmat_gly = $_POST['dmat_gly'];
    $dmat_his = $_POST['dmat_his'];
    $dmat_hyl = $_POST['dmat_hyl'];
    $dmat_hyp = $_POST['dmat_hyp'];
    $dmat_ile = $_POST['dmat_ile'];
    $dmat_leu = $_POST['dmat_leu'];
    $dmat_lys = $_POST['dmat_lys'];
    $dmat_met = $_POST['dmat_met'];
    $dmat_phe = $_POST['dmat_phe'];
    $dmat_pro = $_POST['dmat_pro'];
    $dmat_ser = $_POST['dmat_ser'];
    $dmat_thr = $_POST['dmat_thr'];
    $dmat_trp = $_POST['dmat_trp'];
    $dmat_tyr = $_POST['dmat_tyr'];
    $dmat_val = $_POST['dmat_val'];


    if ($conn) {
        $sql1 = "INSERT INTO raw_material (type_raw_id, raw_engname, raw_thainame, feed_class, acc_id) VALUES ('$type_raw_id', '$raw_engname', '$raw_thainame', '$feed_class', '$acc_id')";
        $resql1 = $conn->query($sql1);
        $raw_id = $conn->insert_id;

        echo  $raw_id;

        $sql2 = "INSERT INTO nutrition_detail (dnut_dm, dnut_cp, dnut_ee, dnut_cf, dnut_ash, dnut_nfe, dnut_ndf, dnut_adf, dnut_adl, dnut_ndicp, dnut_adicp, dnut_ndfd, dnut_rup, dnut_dmd, dnut_omd, dnut_tdn, dnut_de, dnut_me, dnut_nel, type_detail_id)  
    VALUES ('$dnut_dm', '$dnut_cp', '$dnut_ee', '$dnut_cf', '$dnut_ash', '$dnut_nfe', '$dnut_ndf', '$dnut_adf', '$dnut_adl', '$dnut_ndicp', '$dnut_adicp', '$dnut_ndfd', '$dnut_rup', '$dnut_dmd', '$dnut_omd', '$dnut_tdn', '$dnut_de', '$dnut_me', '$dnut_nel', '$type_detail_id')";
        $resql2 = $conn->query($sql2);
        $nutrition_detail_id = $conn->insert_id;

        if ($resql2) {
            $sqlNutrition = "INSERT INTO nutrition (nutrition_detail_id, raw_id) SELECT $nutrition_detail_id, $raw_id";
            $resqlNutrition = $conn->query($sqlNutrition);
        } else {
            echo "Error inserting into nutrition_detail table: " . $conn->error;
        }

    //     $sql4 = "INSERT INTO minerals_detail (dminer_per_ca, dminer_per_p, dminer_per_mg, dminer_per_k, dminer_per_s, dminer_per_na, dminer_kg_cu, dminer_kg_fe, dminer_kg_mn, dminer_kg_zn, type_detail_id) 
    // VALUES ('$dminer_per_ca', '$dminer_per_p', '$dminer_per_mg', '$dminer_per_k', '$dminer_per_s', '$dminer_per_na', '$dminer_kg_cu', '$dminer_kg_fe', '$dminer_kg_mn', '$dminer_kg_zn', '$type_detail_id')";
    //     $resql4 = $conn->query($sql4);
    //     $minerals_detail_id = $conn->insert_id;
    //     if ($resql4) {
    //         $sqlMinerals = "INSERT INTO minerals (minerals_detail_id, raw_id) SELECT $minerals_detail_id, $raw_id";
    //         $resqlMinerals = $conn->query($sqlMinerals);
    //     } else {
    //         echo "Error inserting into minerals_detail table: " . $conn->error;
    //     }

    //     $sql5 = "INSERT INTO material_detail (dmat_ala, dmat_arg, dmat_asp, dmat_cys, dmat_glu, dmat_gly, dmat_his, dmat_hyl, dmat_hyp, dmat_ile, dmat_leu, dmat_lys, dmat_met, dmat_phe, dmat_pro, dmat_ser, dmat_thr, dmat_trp, dmat_tyr, dmat_val, type_detail_id) 
    // VALUES ('$dmat_ala', '$dmat_arg', '$dmat_asp', '$dmat_cys', '$dmat_glu', '$dmat_gly', '$dmat_his', '$dmat_hyl', '$dmat_hyp', '$dmat_ile', '$dmat_leu', '$dmat_lys', '$dmat_met', '$dmat_phe', '$dmat_pro', '$dmat_ser', '$dmat_thr', '$dmat_trp', '$dmat_tyr', '$dmat_val', '$type_detail_id')";
    //     $resql5 = $conn->query($sql5);
    //     $material_detail_id = $conn->insert_id;
    //     if ($resql5) {
    //         $sqlMaterial = "INSERT INTO material (material_detail_id, raw_id) SELECT $material_detail_id, $raw_id";
    //         $resqlMaterial = $conn->query($sqlMaterial);
    //     } else {
    //         echo "Error inserting into material_detail table: " . $conn->error;
    //     }


        if ($resql1 && $resql2) {
            // Insertion successful
            echo "<script type='text/javascript'>";
            echo "alert('Data inserted successfully.');";
            echo "window.location = 'raw_material.php'; ";
            echo "</script>";
        } else {
            // Insertion failed
            echo "error: " . $conn->error;
        }

        $conn->close();

    } else {
        header("location: raw_material.php");
    }
}


?>