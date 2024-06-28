<?php
session_start();

// เชื่อมต่อกับฐานข้อมูล
include('../server.php');

if (isset($_POST['saveNewPassword'])) {
    // รับค่ารหัสผ่านเดิมและรหัสผ่านใหม่
    $old_pass = mysqli_real_escape_string($conn, $_POST['acc_pass']);
    $new_pass_1 = mysqli_real_escape_string($conn, $_POST['pass_1']);
    $new_pass_2 = mysqli_real_escape_string($conn, $_POST['pass_2']);

    // ตรวจสอบว่ารหัสผ่านใหม่ตรงกันหรือไม่
    if ($new_pass_1 != $new_pass_2) {
        $error = "รหัสผ่านใหม่ไม่ตรงกัน";
        $_SESSION['error'] = $error;
        echo "<script type='text/javascript'>";
        echo "window.location = 'profile.php'; ";
        echo "</script>";
        exit();
    }

    // ตรวจสอบรหัสผ่านเดิม
    $acc_id = $_SESSION['acc_id']; // รหัสผู้ใช้ที่เข้าสู่ระบบ
    $query = "SELECT * FROM account WHERE acc_id = '$acc_id' AND acc_pass = MD5('$old_pass')";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        // ถ้ารหัสผ่านเดิมถูกต้อง ดำเนินการเปลี่ยนแปลงรหัสผ่านใหม่
        $update_query = "UPDATE account SET acc_pass = MD5('$new_pass_1') WHERE acc_id = '$acc_id'";
        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            $successPass = "เปลี่ยนรหัสผ่านสำเร็จ";
            $_SESSION['successPass'] = $successPass;
            echo "<script type='text/javascript'>";
            echo "window.location = 'profile.php'; ";
            echo "</script>";
            exit();
        } else {
            $error = "เกิดข้อผิดพลาดในการเปลี่ยนรหัสผ่าน";
            $_SESSION['error'] = $error;
            echo "<script type='text/javascript'>";
            echo "window.location = 'profile.php'; ";
            echo "</script>";
            exit();
        }
    } else {
        $error = "รหัสผ่านเดิมไม่ถูกต้อง";
        $_SESSION['error'] = $error;
        echo "<script type='text/javascript'>";
        echo "window.location = 'profile.php'; ";
        echo "</script>";
        exit();
    }
}
?>