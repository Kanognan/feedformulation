<?php

// เรียกใช้ไฟล์ server.php ที่มีการเชื่อมต่อกับฐานข้อมูล
include('../server.php');

// ตรวจสอบว่ามีการส่งค่า preganancycheck มาหรือไม่
if (isset($_POST['pregnancycheck'])) {
    // รับค่าที่ส่งมาจากฟอร์ม
    $breed_id = $_POST['breed_id'];
    $breed_date = $_POST['breed_date'];
    $breed_status = $_POST['options'];
    $note = $_POST['note'];
    $cow_id = $_POST['cow_id'];

    // สร้างคำสั่ง SQL เพื่อดึงข้อมูลโคจากฐานข้อมูล
    $breed_query = "SELECT * FROM cow WHERE cow_id = '$cow_id'";
    $breed_result = mysqli_query($conn, $breed_query) or die(mysqli_error($conn));
    
    // ดึงข้อมูลจากผลลัพธ์ที่ได้และเก็บไว้ในตัวแปร
    if ($breed_row = mysqli_fetch_assoc($breed_result)) {
        $cow_breed_status = $breed_row['cow_breed_status'];
        $cow_milk_status = $breed_row['cow_milk_status'];
    }
    
    // ตรวจสอบและประมวลผลข้อมูลตามเงื่อนไขที่กำหนด
    if (!empty($breed_date)) {
        $breedDateTime = new DateTime($breed_date);
       
            if ($breed_status == "ตั้งท้อง") {
                // ปรับค่าสถานะของโคเป็น 'ตั้งท้อง' และกำหนดวันคลอด
                $cow_milk_status = "ไม่ให้นม";
                $cow_breed_status = 'ตั้งท้อง';
                $breed_status = "ตั้งท้อง";
                $breedDateTime->add(new DateInterval('P285D'));
                $calf_day = $breedDateTime->format('Y-m-d');
                
                // อัปเดตข้อมูลในตาราง cow_breed
                $breed_update_query = "UPDATE cow_breed SET calf_day ='" . $calf_day . "', breed_status ='" . $breed_status . "', note ='" . $note . "' WHERE breed_id ='" . $breed_id . "'";
                $cowq1 = mysqli_query($conn, $breed_update_query) or die(mysqli_error($conn));
            } elseif ($breed_status == "ผสมไม่ติด") {
                // ปรับค่าสถานะของโคเป็น 'ท้องว่าง' และล้างข้อมูลที่เกี่ยวข้อง
                $breed_status = "ผสมไม่ติด";
                $cow_breed_status = 'ท้องว่าง';
                $cow_milk_status = "ไม่ให้นม";
                
                // อัปเดตข้อมูลในตาราง cow_breed
                $breed_update_query = "UPDATE cow_breed SET calf_day = null, breed_status ='" . $breed_status . "', note ='" . $note . "' WHERE breed_id ='" . $breed_id . "'";
                $cowq1 = mysqli_query($conn, $breed_update_query) or die(mysqli_error($conn));
            }
        }
    


mysqli_close($conn);
	if ($conn) {
		echo "<script type='text/javascript'>";
		echo "alert('เพิ่มข้อมูลสำเร็จ');";
		echo "window.location = 'index_breed_cow.php'; ";
		echo "</script>";
	} else {
		echo "<script type='text/javascript'>";
        echo "alert('เพิ่มข้อมูลไม่สำเร็จ');";
		echo "window.location = 'index_breed_cow.php'; ";
		echo "</script>";
	}

}

?>