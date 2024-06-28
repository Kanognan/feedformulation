<?php
    session_start();
    include('../server.php');

    // รับค่า group_id จาก url
    $group_id = $_GET['group_id'];

    // ดึงรายชื่อ cow ที่เกี่ยวข้องกับ group_id นี้
    $sql = "SELECT cow_id FROM cow WHERE group_id = '$group_id'";
    $result = mysqli_query($conn, $sql);
    
    // ในกรณีที่มี cow ที่เกี่ยวข้องกับ group_id นี้
    if (mysqli_num_rows($result) > 0) {
        // ใช้ loop เพื่ออัปเดต group_id ของ cow เป็น 1 ทุกตัว
        while ($row = mysqli_fetch_assoc($result)) {
            $cow_id = $row['cow_id'];
            // อัปเดต group_id ของ cow เป็น 1
            mysqli_query($conn, "UPDATE cow SET group_id = 1 WHERE cow_id = '$cow_id'") or die (mysqli_error($conn));
        }
    }

    // ลบ group นี้ออกจากตาราง group_cow
    mysqli_query($conn, "DELETE FROM group_cow WHERE group_id ='$group_id'") or die (mysqli_error($conn));

    // ส่งกลับไปที่หน้า group.php
    header('location:group.php');
?>
