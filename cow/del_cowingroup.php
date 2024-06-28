<?php
session_start();
include('../server.php');
if (isset($_GET['id'])) {
    $cow_id = $_GET['id'];
    $up = "UPDATE cow SET group_id ='1' WHERE cow_id = '$cow_id'";
    $gcow = mysqli_query($conn, $up) or die(mysqli_error($conn));
    header('location:group.php');
} else {
    // หากค่า cow_id ไม่ถูกตั้งค่าให้กลับไปที่หน้า group.php
    header('location:group.php');
}

?>
