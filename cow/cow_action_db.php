<?php

include('../server.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>

<body>
    <?php
	session_start();
	if (isset($_POST['addcow'])) {
		$cow_id = isset($_POST["cow_id"]) ? $_POST["cow_id"] : null;

		// Check if $cow_id is set and not empty
		if (!empty($cow_id)) {
			// Sanitize the input to prevent SQL injection
			$sanitized_cow_id = mysqli_real_escape_string($conn, $cow_id);
			// Check if the cow_id already exists in the database
			$check_query = "SELECT * FROM cow WHERE cow_id = '$sanitized_cow_id'";
			$result = mysqli_query($conn, $check_query);
			if ($result && mysqli_num_rows($result) > 0) {
				// If the cow_id already exists, display an error message
				echo "<script type='text/javascript'>";
				$sData = "กรอกรหัสโคใหม่";
        		$_SESSION['sData'] = $sData;
				echo "window.history.back();"; // เพื่อให้กลับไปที่หน้าที่แล้วโดยไม่ต้องรีเฟรชหน้า
				echo "</script>";
				exit; // ให้จบการทำงานทันทีหลังจากแสดงข้อความแจ้งเตือน
			} 
		} else {
			// Handle the case where $cow_id is empty or not set
			echo "Invalid input: Please enter a valid Cow ID.";
		}
		$acc_id = $_SESSION['acc_id'];
		$cow_name = $_POST['cow_name'];
		$cb_id = $_POST['cb_id'];
		// รูปภาพ
		// รับไฟล์ภาพและกำหนดที่เก็บ
		$filename = isset($_FILES["meetfile"]["name"]) ? $_FILES["meetfile"]["name"] : null;
			$filTmpename = isset($_FILES["meetfile"]["tmp_name"]) ? $_FILES["meetfile"]["tmp_name"] : null;
			if (!empty($filename) && !empty($filTmpename)) {  
				$Ext = explode(".", $filename);
				$AcExt = strtolower(end($Ext));
				$new = time() . "." . $AcExt; 
				$meetfilelocation = '../pic/' . $new;
				if (move_uploaded_file($filTmpename, $meetfilelocation)) {
		// เมื่ออัโหลดไฟล์ภาพสำเร็จ
			}else {
		// ถ้าเกิดข้อผิดพลาดในการอัปโหลดไฟล์
				echo "Failed to upload image.";
			exit; // หยุดการทำงานทันที
				}
			}else {
		// ถ้าไม่ได้อัปโหลดภาพให้ใช้รูปเริ่มต้น	
		$meetfilelocation = '../pic/coweat.png';
		}
		$cow_gender = $_POST['flexRadioDefault'];
		$cow_bday = $_POST['cow_bday'];
		$cow_weight = $_POST['cow_weight'];
		$cow_first_weight = $_POST['cow_first_weight'];
		$cow_dad_id = $_POST['cow_dad_id'];
		$cow_dad_breed = $_POST['cow_dad_breed'];
		$cow_mom_id = $_POST['cow_mom_id'];
		$cow_mom_breed = $_POST['cow_mom_breed'];
		$cow_activity = $_POST['cow_activity'];
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
		$group_id = $_POST['group_id'];
		}
		//จอยตาราง
		$sql = "INSERT INTO cow (cow_id, cow_name,cow_img, cow_gender,cow_weight,cow_first_weight,cow_bday, cow_dad_id, cow_dad_breed,
 		cow_mom_id,cow_mom_breed,cow_breed_status,cow_milk_status,cow_activity,calf_date,milk_date,group_id,cb_id,acc_id)
		VALUES ('$cow_id','$cow_name','$meetfilelocation','$cow_gender','$cow_weight','$cow_first_weight','$cow_bday','$cow_dad_id','$cow_dad_breed',
		'$cow_mom_id','$cow_mom_breed','$cow_breed_status','$cow_milk_status','$cow_activity','$calf_date','$milk_date','$group_id','$cb_id','$acc_id')";
		$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	

	mysqli_close($conn);
	if ($conn) {
        $resultData = "ข้อมูลถูกบันทึกเรียบร้อยแล้ว";
        $_SESSION['resultData'] = $resultData;
        header("Location: cow.php");
        exit();
	} else {
		echo "<script type='text/javascript'>";
		echo "window.location = 'cow.php'; ";
		echo "</script>";
	}

	?>

</body>

</html>