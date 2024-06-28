<?php
    session_start();
    include('../server.php');
    $cow_id = $_GET['cow_id'];
    $cow_name = $_POST['cow_name'];
    $cb_id = $_POST['cb_id'];
    $cow_bday = $_POST['cow_bday'];
    $cow_weight = $_POST['cow_weight'];
    $cow_first_weight = $_POST['cow_first_weight'];
   
    // รับค่าอื่น ๆ จากฟอร์ม
    $cow_dad_id = $_POST['cow_dad_id'];
    $cow_dad_breed = $_POST['cow_dad_breed'];
    $cow_mom_id = $_POST['cow_mom_id'];
    $cow_mom_breed = $_POST['cow_mom_breed'];
    $cow_breed_status = isset($_POST['cow_breed_status']) ? $_POST['cow_breed_status'] : 'ท้องว่าง';
    if ($cow_breed_status == '') {
        $cow_breed_status = 'ท้องว่าง';
    }
    $cow_milk_status = isset($_POST['cow_milk_status']) ? $_POST['cow_milk_status'] : 'ไม่ให้นม';
    if ($cow_milk_status == '') {
        $cow_milk_status = 'ไม่ให้นม';
    }
    $calf_date = $_POST['calf_date'];
    $milk_date = $_POST['milk_date'];
    $cow_milk_status = $_POST['cow_milk_status'];
    $cow_activity = $_POST['cow_activity'];
   

// สร้างคำสั่ง SQL สำหรับการอัปเดตข้อมูล
$up = "UPDATE cow SET
        cow_name = '" . $cow_name . "',
        cb_id = '" . $cb_id . "',
        cow_bday = '" . $cow_bday . "',
        cow_weight = '" . $cow_weight . "',
        cow_first_weight = '" . $cow_first_weight . "',
        cow_dad_id = '" . $cow_dad_id . "',
        cow_dad_breed = '" . $cow_dad_breed . "',
        cow_mom_id = '" . $cow_mom_id . "',
        cow_mom_breed = '" . $cow_mom_breed . "',
        cow_milk_status = '" . $cow_milk_status . "',
        cow_breed_status = '" . $cow_breed_status . "',
        calf_date = '" . $calf_date . "',
        milk_date = '" . $milk_date . "',
        cow_activity = '" . $cow_activity . "' 
        WHERE cow_id = '" . $cow_id . "'"; 
    // echo $up;
    $query = mysqli_query($conn, $up) or die (mysqli_error($conn)); 
    mysqli_close($conn);
    if ($conn) {
        $editData = "แก้ไขข้อมูลเรียบร้อยแล้ว";
        $_SESSION['editData'] = $editData;
        header("Location: cow.php");
        exit();
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('แก้ไขข้อมูลไม่สำเร็จ');";
        echo "window.location = cow.php ";
        echo "</script>";
    }

	
?>
