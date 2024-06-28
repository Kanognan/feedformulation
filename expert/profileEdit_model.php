<?php
session_start();
include("../server.php");
$errors = array();

date_default_timezone_set('Asia/Bangkok');
$updateAt = date('Y-m-d H:i:s', time());

if (isset($_POST['saveChanges'])) {
    $acc_name = $_POST['acc_name'];
    $acc_email = $_POST['acc_email'];
    $ex_fname = $_POST['ex_fname'];
    $ex_lname = $_POST['ex_lname'];
    $ex_gender = $_POST['ex_gender'];
    $ex_bday = $_POST['ex_bday'];
    $ex_phone = $_POST['ex_phone'];
    $career_id = $_POST['career_id'];
    $id = $_SESSION['acc_id'];

    // ตรวจสอบว่ามีการอัพโหลดรูปภาพหรือไม่
    if (isset($_FILES['acc_image']) && $_FILES['acc_image']['name'] != '') {
        $date = date("Ymd");
        $numrand = (mt_rand());
        $acc_image = $_FILES['acc_image'];
        $path = "../pic/";
        $type = strrchr($acc_image['name'], ".");
        $newname1 = $date . $numrand . $type;
        $file_img = $path . $newname1;

        if (move_uploaded_file($acc_image["tmp_name"], $file_img)) {
            // ไฟล์ภาพใหม่ถูกอัพโหลดสำเร็จ
            echo "ไฟล์ภาพชื่อ" . $newname1 . "อัพโหลดแล้ว";
            $acc_image_db = $newname1;

            // ตรวจสอบว่ามีรูปในฐานข้อมูลหรือไม่
            $sql_img = "SELECT acc_image FROM account WHERE acc_id = '$id'";
            $result_img = $conn->query($sql_img);

            if ($result_img->num_rows > 0) {
                $row = $result_img->fetch_assoc();
                $old_image = $row['acc_image'];

                // ลบรูปเก่า
                if ($old_image && file_exists($path . $old_image)) {
                    unlink($path . $old_image);
                }
            }

        } else {
            echo "รูปภาพเกิดข้อผิดพลาด";
        }
    } else {
        $acc_image_db = null; // กำหนดให้ $acc_image_db เป็นค่าว่างไว้ก่อน

        // ตรวจสอบว่ามีรูปในฐานข้อมูลหรือไม่
        $sql_img = "SELECT acc_image FROM account WHERE acc_id = '$id'";
        $result_img = $conn->query($sql_img);

        if ($result_img->num_rows > 0) {
            // ถ้ามีรูป ให้ใช้รูปนั้น
            $row = $result_img->fetch_assoc();
            $acc_image_db = $row['acc_image'];
        }
    }

    // ทำการอัพเดตข้อมูล
    $sqlUpdate = "UPDATE account
        SET acc_name='$acc_name', acc_email='$acc_email', acc_image='$acc_image_db'
        WHERE acc_id = '$id'";
    $resql1 = $conn->query($sqlUpdate);

    $sqlUpdate2 = "UPDATE expert
        SET ex_fname='$ex_fname', ex_lname='$ex_lname', ex_gender='$ex_gender', ex_bday='$ex_bday', ex_phone='$ex_phone', career_id='$career_id', updateAt='$updateAt' 
        WHERE acc_id = '$id'";
    $resql2 = $conn->query($sqlUpdate2);

    if ($resql1 && $resql2) {
        header("location: profile.php");
        exit(); // ออกจากการประมวลผลเพื่อป้องกันการทำงานต่อ
    } else {
        echo "เกิดข้อผิดพลาด";
    }
}
?>