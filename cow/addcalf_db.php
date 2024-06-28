<?php

session_start();
if (!isset ($_SESSION["acc_id"]) || $_SESSION["acc_id"] == "") {
    $resultNoSession = "เข้าสู่ระบบก่อนใช้งาน";
    $_SESSION['resultNoSession'] = $resultNoSession;
    echo "<script type='text/javascript'>";
    echo "window.location = '../login.php'; ";
    echo "</script>";
    exit();
    // ผู้ใช้งานทั่วไป
}
include "../server.php";

$milk_date = "";
$acc_id = $_SESSION['acc_id'];
if (isset ($_POST['addcalf'])) {
    $breed_id = $_GET['breed_id'];
    $calf_status = isset ($_POST['calf_status']) ? $_POST['calf_status'] : null;
    $calf_bday = isset ($_POST['calf_bday']) ? $_POST['calf_bday'] : null;

    // Process the form data
    if (!empty ($calf_bday)) {
        // Check if calf_no already exists in the database
        $check_query = "SELECT * FROM cow WHERE cow_id = '$calf_no'";
        $result = mysqli_query($conn, $check_query);

        // Check if there is any row returned
        if ($result && mysqli_num_rows($result) > 0) {
            // If the calf_no already exists, display an error message or handle it accordingly
            echo "<script type='text/javascript'>";
            $sData = "กรอกรหัสลูกโคใหม่";
            $_SESSION['sData'] = $sData;
            echo "window.history.back();"; // เพื่อให้กลับไปที่หน้าที่แล้วโดยไม่ต้องรีเฟรชหน้า
            echo "</script>";
            exit;
        } else {
            // Proceed with inserting the new calf data into the database
            // Your code to insert data goes here
        }
       
        $calf_gender = isset ($_POST['flexRadioDefault']) ? $_POST['flexRadioDefault'] : null;
        $calf_no = isset ($_POST['calf_no']) ? $_POST['calf_no'] : null;
        $calf_note = $_POST['calf_note'];
        $calf_weight = $_POST['calf_weight'];
        $cow_id = $_GET['cow_id'];

        // Query to select data from cow table
        $sql = "SELECT * FROM cow WHERE cow.acc_id = $acc_id AND cow.deleteAt IS NULL AND cow_id = '$cow_id'";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die ("Error: " . mysqli_error($conn));
        }

        // Query to select data from cow_breed table
        $sql1 = "SELECT * FROM cow_breed WHERE cow_id = '$cow_id'";
        $result1 = mysqli_query($conn, $sql1);
        if (!$result1) {
            die ("Error: " . mysqli_error($conn));
        }

        // Fetch data from the results
        $row = mysqli_fetch_assoc($result);
        $row1 = mysqli_fetch_assoc($result1);

        // Assign values to variables
        $cb_mom = $row['cb_id'];
        $cb_dad = $row1['cattle_breed_breeder'];
        $id_dad = $row1['breed_breeder'];

        // สร้างวัตถุ DateTime จากค่าวันที่
        $calf_bdayTime = new DateTime($calf_bday);
        if ($calf_status == "คลอดปกติ" || $calf_status == "คลอดก่อนกำหนด" || $calf_status == "คลอดหลังกำหนด") {
            // ทำการเพิ่ม 1 วัน
            $cow_breed_status = "ท้องว่าง";
            $calf_bdayTime->add(new DateInterval('P1D'));
            $milk_day = $calf_bdayTime->format('Y-m-d');
            $cow_milk_status = "ให้นม";
            $calf_bday_diff = 0; // Initialize the day difference variable
            $vvd = 1;
            $calf_date = 0;
            if (!empty ($calf_bday) && $calf_bday != "-") {
                $calf_bday_datetime = new DateTime($calf_bday);
                $current_datetime = new DateTime();
                // Calculate the difference in days
                $interval = $current_datetime->diff($calf_bday_datetime);
                $calf_bday_datetime = $interval->days - $vvd;
            }
            // Update the database
            $calf_update_query = " UPDATE cow_breed set calf_bday ='" . $calf_bday . "',calf_gender='" . $calf_gender . "'
        ,calf_no='" . $calf_no . "',calf_note='" . $calf_note . "',milk_day='" . $milk_day . "',calf_weight='" . $calf_weight . "', breed_status='" . $calf_status . "' where breed_id='" . $breed_id . "'";
            $query = mysqli_query($conn, $calf_update_query) or die (mysqli_error($conn));
            $cow = "UPDATE cow set cow_milk_status ='" . $cow_milk_status . "',cow_breed_status='" . $cow_breed_status . "',milk_date='" . $calf_bday_datetime . "',calf_date='" . $calf_date . "' where cow_id='" . $cow_id . "'";
            $cowquery = mysqli_query($conn, $cow) or die (mysqli_error($conn));

            $cow_insert = "INSERT INTO cow (cow_id,cow_name, cow_gender, cow_first_weight, cow_weight, cow_bday, cow_img, cow_dad_id, cow_dad_breed, cow_mom_id,cow_mom_breed, cow_breed_status, cow_milk_status,cow_activity, calf_date, milk_date, group_id,cb_id,dem_id,acc_id) 
                        VALUE ('$calf_no','ลูกโคใหม่','$calf_gender','$calf_weight','$calf_weight','$calf_bday','../pic/coweat.png','$id_dad','$cb_dad','$cow_id','$cb_mom','ท้องว่าง','ไม่ให้นม','ขังคอก','0','0','1','$cb_mom',NULL,'$acc_id')";
            $cow_insert_query = mysqli_query($conn, $cow_insert) or die (mysqli_error($conn));
        }  
    } elseif (empty ($calf_bday)) {
        // กรณี $breed_date ไม่ได้รับค่าหรือเป็นค่าว่าง
        $calf_status = "แท้ง"; // ตั้งค่าสถานะเป็น "แท้ง"
        $cow_breed_status = "ท้องว่าง";
        $calf_date = null;
        $milk_day = null;
        $cow_id = $_GET['cow_id'];
        $cow_milk_status = "ไม่ให้นม"; // กำหนดให้ว่างเพื่อกรณี "รอตรวจท้อง"
        
        $calf_update_query = "UPDATE cow_breed SET calf_bday = NULL, calf_gender = '$calf_gender',
        calf_no = '$calf_no', calf_note = '$calf_note', milk_day = NULL, calf_weight = '$calf_weight', 
        breed_status = '$calf_status' WHERE breed_id = '$breed_id'";
        $query = mysqli_query($conn, $calf_update_query) or die (mysqli_error($conn));
        $cow = "UPDATE cow set cow_milk_status ='" . $cow_milk_status . "',cow_breed_status='" . $cow_breed_status . "',milk_date='" . $calf_bday_datetime . "',calf_date='" . $calf_date . "' where cow_id='" . $cow_id . "'";
        $cowquery = mysqli_query($conn, $cow) or die (mysqli_error($conn));
    }
    
    mysqli_close($conn);
    if ($conn) {
        $resultData = "ข้อมูลถูกบันทึกเรียบร้อยแล้ว";
        $_SESSION['resultData'] = $resultData;
        header("Location: index_breed_cow.php");
        exit();
    } else {
        echo "<script type='text/javascript'>";
        echo "window.location = 'cow.php'; ";
        echo "</script>";
    }
}
?>