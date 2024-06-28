<?php
include('../server.php');

// ตรวจสอบว่ามีค่าของ $_GET['cow_id'] ที่ส่งมาหรือไม่
if (isset($_GET['cow_id']) && !empty($_GET['cow_id'])) {
    $cow_id = $_GET['cow_id'];

    // 1. ลบข้อมูลจากตารางที่อ้างอิงถึงโค
    mysqli_query($conn, "DELETE FROM cow_demand WHERE cow_id = '$cow_id'");
    mysqli_query($conn, "DELETE FROM cow_vaccine WHERE cow_id = '$cow_id'");
    mysqli_query($conn, "DELETE FROM cow_milk WHERE cow_id = '$cow_id'");
    mysqli_query($conn, "DELETE FROM cow_breed WHERE cow_id = '$cow_id'");
    mysqli_query($conn, "DELETE FROM cow_diagnosis WHERE cow_id = '$cow_id'");
    mysqli_query($conn, "DELETE FROM cow_health WHERE cow_id = '$cow_id'");

    // 2. ลบข้อมูลจากตารางหลัก
    // อัพเดต deleted_at เป็น timestamp เมื่อลบแบบ soft delete
    mysqli_query($conn, "UPDATE cow SET deleteAt = NOW() WHERE cow_id = '$cow_id'");

    // ส่งผลลัพธ์กลับไปหน้าที่เหมาะสม
    header('location: cow.php');
} else {
    // กรณีไม่พบข้อมูล cow_id หรือมีค่าว่าง
    // ส่งผลลัพธ์กลับไปยังหน้า cow.php หรือหน้าที่เหมาะสม
    header('location: cow.php');
}
?>
