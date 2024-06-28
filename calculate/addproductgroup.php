<?php
include('../server.php');
session_start();
$acc_id = $_SESSION['acc_id'];

if (isset($_POST['calproductgroup'])) {
    $group_id = $_GET['group_id'];
    $dem_name = isset($_POST['dem_name']) ? $_POST['dem_name'] : '';

    if (empty($dem_name)) {
        echo "กรอกชื่อรายการโภชนะโค";
    } else {
        // ตรวจสอบและดึงค่าที่ถูกส่งมา
        $selectCowIDsQuery = "SELECT cow_id FROM cow WHERE group_id = $group_id";
        $resultCowIDs = mysqli_query($conn, $selectCowIDsQuery);

        // Initialize an empty array to store cow_ids
        $cow_ids = array();

        // Fetch cow_ids into an array
        while ($rowCowID = mysqli_fetch_assoc($resultCowIDs)) {
            $cow_ids[] = $rowCowID['cow_id'];
        }
        $dem_BW = isset($_POST['BW']) ? $_POST['BW'] : null;
        $dem_thi = isset($_POST['THI']) ? $_POST['THI'] : null;
        $dem_fat = isset($_POST['Fat']) ? $_POST['Fat'] : null;
        $dem_intake = isset($_POST['DMI']) ? $_POST['DMI'] : null;
        $dem_protein = isset($_POST['Protein']) ? $_POST['Protein'] : null;
        $dem_bdc = isset($_POST['BDC']) ? $_POST['BDC'] : null;
        $dem_adg = isset($_POST['ADG']) ? $_POST['ADG'] : null;
        $dem_milk = isset($_POST['Milk']) ? $_POST['Milk'] : null;
        $dem_me = isset($_POST['ME']) ? $_POST['ME'] : null;
        $dem_nel = isset($_POST['NEL']) ? $_POST['NEL'] : null;
        $dem_mp = isset($_POST['MP']) ? $_POST['MP'] : null;
        $dem_de = isset($_POST['DE']) ? $_POST['DE'] : null;
        $dem_tdn = isset($_POST['TDN']) ? $_POST['TDN'] : null;
        $dem_rdp = isset($_POST['RDP']) ? $_POST['RDP'] : null;
        $dem_rup = isset($_POST['RUP']) ? $_POST['RUP'] : null;
        $dem_cp = isset($_POST['CP']) ? $_POST['CP'] : null;
		$dem_ndf = 33;
		$dem_adf = 21;
		$dem_nfc = 43;
        $dem_ca = 0.62;
        $dem_p = 0.32;
        $dem_mg = 0.18;
        $dem_cl =  0.24;
        $dem_k =  1;
        $dem_na =  0.22;  
        $dem_s =  0.2;
        $dem_co =  0.11;
        $dem_cu =  11;
        $dem_i =  0.6;
        $dem_fe =  12.3;
        $dem_mn =  14;
        $dem_se = 0.3;
        $dem_zn = 43;
        $selectedVitamin = 0;
        if (isset($_POST['vitA_kg_1']) && $_POST['vitA_kg_1'] !== '') {
            $selectedVitamin = array(
                'type' => 1,
                'A_kg' => $_POST['vitA_kg_1'],
                'A_ui' => $_POST['vitA_ui_1'],
                'D_kg' => $_POST['vitD_kg_1'],
                'D_ui' => $_POST['vitD_ui_1'],
                'E_kg' => $_POST['vitE_kg_1'],
                'E_ui' => $_POST['vitE_ui_1']
            );
        }else if (isset($_POST['vitA_kg_2']) && $_POST['vitA_kg_2'] !== '') {
            $selectedVitamin = array(
                'type' => 2,
                'A_kg' => $_POST['vitA_kg_2'],
                'A_ui' => $_POST['vitA_ui_2'],
                'D_kg' => $_POST['vitD_kg_2'],
                'D_ui' => $_POST['vitD_ui_2'],
                'E_kg' => $_POST['vitE_kg_2'],
                'E_ui' => $_POST['vitE_ui_2']
            );
        }else if (isset($_POST['vitA_kg_3']) && $_POST['vitA_kg_3'] !== '') {
            $selectedVitamin = array(
                'type' => 3,
                'A_kg' => $_POST['vitA_kg_3'],
                'A_ui' => $_POST['vitA_ui_3'],
                'D_kg' => $_POST['vitD_kg_3'],
                'D_ui' => $_POST['vitD_ui_3'],
                'E_kg' => $_POST['vitE_kg_3'],
                'E_ui' => $_POST['vitE_ui_3']
            );
        }
       
        $A_kg = null;
        $A_ui = null;
        $D_kg = null;
        $D_ui = null;
        $E_kg = null;
        $E_ui = null;
        
        if ($selectedVitamin !== 0) {
            $A_kg = $selectedVitamin['A_kg'];
            $A_ui = $selectedVitamin['A_ui'];
            $D_kg = $selectedVitamin['D_kg'];
            $D_ui = $selectedVitamin['D_ui'];
            $E_kg = $selectedVitamin['E_kg'];
            $E_ui = $selectedVitamin['E_ui'];
        }

        }

        // ... (similar blocks for type 2 and type 3)

        // Insert cow_demand record
        $sql = "INSERT INTO cow_demand (
            dem_name, dem_BW, dem_thi, dem_fat, dem_intake, dem_protein, dem_adg, dem_bdc,
            dem_milk, dem_me, dem_nel, dem_mp, dem_de, dem_tdn, dem_rdp, dem_rup, dem_cp,
            dem_ndf, dem_adf, dem_nfc, dem_ca, dem_p, dem_mg, dem_cl, dem_k,
            dem_na, dem_s, dem_co, dem_cu, dem_i, dem_fe, dem_mn, dem_se, dem_zn, dem_vitA,
            dem_vitE, dem_vitD,acc_id
        ) VALUES (
            '$dem_name', '$dem_BW', '$dem_thi', '$dem_fat', '$dem_intake', '$dem_protein',
            '$dem_adg', '$dem_bdc', '$dem_milk', '$dem_me', '$dem_nel', '$dem_mp',
            '$dem_de', '$dem_tdn', '$dem_rdp', '$dem_rup', '$dem_cp',
            '$dem_ndf', '$dem_adf', '$dem_nfc', '$dem_ca', '$dem_p', '$dem_mg', '$dem_cl',
            '$dem_k', '$dem_na ', '$dem_s', '$dem_co', '$dem_cu', '$dem_i', '$dem_fe',
            '$dem_mn', '$dem_se', '$dem_zn', '$A_ui', '$D_ui', '$E_ui','$acc_id'
        )";
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        // Get the last inserted ID
        $lastInsertedId = mysqli_insert_id($conn);

        // Check if $cow_ids is an array before using foreach
        if (is_array($cow_ids) && count($cow_ids) > 0) {
            // Iterate through the cow IDs
            foreach ($cow_ids as $value) {
                // Update the cow table with the new dem_id
                $up = "UPDATE cow SET dem_id = '$lastInsertedId' WHERE cow_id = '$value'";
                $gcow = mysqli_query($conn, $up) or die(mysqli_error($conn));
            }
        }
    }
    mysqli_close($conn);
	if ($conn) {
        $resultData = "ข้อมูลถูกบันทึกเรียบร้อยแล้ว";
        $_SESSION['resultData'] = $resultData;
        header("Location: group_feed.php");
        exit();
	} else {
		echo "<script type='text/javascript'>";
        echo "alert('เพิ่มข้อมูลไม่สำเร็จ');";
		echo "window.location = 'group_feed.php'; ";
		echo "</script>";
    }
	






