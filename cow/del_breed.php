<?php
include('../server.php');

// รับค่าตัวแปรจาก URL
$breed_id = $_GET['breed_id'];
// เช็คว่ามี cow_id ที่มี breed_id ตรงกับที่จะลบ
$sql = "SELECT cow_id FROM cow_breed WHERE breed_id = '$breed_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // มี cow_id ที่ตรงกับ breed_id ที่ต้องการลบ
    // ให้อัปเดต cow_breed_status ในตาราง cow โดยใช้คำสั่ง SQL ดังนี้
    mysqli_query($conn, "UPDATE cow SET 
    cow_breed_status = 'ท้องว่าง',
    calf_date = 0,
    milk_date = 0 
    WHERE cow_id IN (SELECT cow_id FROM cow_breed WHERE breed_id = '$breed_id')");
}
// ลบรายการแบบฟอร์มในตาราง cow_breed จาก breed_id ที่กำหนด
mysqli_query($conn, "DELETE FROM cow_breed WHERE breed_id ='$breed_id'");

// นำผลลัพธ์ไปยังหน้าหลักที่เกี่ยวข้อง
header('location:index_breed_cow.php');
?>
