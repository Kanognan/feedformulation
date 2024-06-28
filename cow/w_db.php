<!-- update_cows.php -->
<?php
session_start();
include('../server.php');

if (isset($_POST['updatecow'])) {
    $cow_ids = $_POST['cow_id'];
    $weights = $_POST['cow_weight'];

    // Loop through the array and update cow data in the database
    foreach ($cow_ids as $key => $cow_id) {
        $weight = $weights[$key];
        // ตรวจสอบว่าไอดีของวัวไม่ว่างเปล่าและเป็นข้อความ
        if (!empty($cow_id) && is_string($cow_id)) {
            // อัปเดตข้อมูลในฐานข้อมูลโดยใช้ไอดีของวัว
            $update_query = "UPDATE cow SET cow_weight = '$weight' WHERE cow_id = '$cow_id'";
            mysqli_query($conn, $update_query);
        }
    }
    mysqli_close($conn);
    if ($conn) {
        $editData = "แก้ไขข้อมูลเรียบร้อยแล้ว";
        $_SESSION['editData'] = $editData;
        header("Location: update_weight.php");
        exit();
    } else {
        echo "<script type='text/javascript'>";
        echo "window.location = 'update_weight.php'; ";
        echo "</script>";
    }
}
?>

