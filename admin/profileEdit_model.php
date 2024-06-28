<?php
session_start();
include("../server.php");

$errors = array();

date_default_timezone_set('Asia/Bangkok');
$updateAt = date('Y-m-d H:i:s', time());

if (isset($_POST['saveChanges'])) {
    $acc_name = $_POST['acc_name'];
    $acc_email = $_POST['acc_email'];
    $admin_fname = $_POST['admin_fname'];
    $admin_lname = $_POST['admin_lname'];
    $admin_gender = $_POST['admin_gender'];
    $admin_bdate = $_POST['admin_bdate'];
    $admin_phone = $_POST['admin_phone'];
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
            echo "ไฟล์ภาพชื่อ" . $newname1 . "อัพโหลดแล้ว";
            $acc_image_db = $newname1;
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
        $acc_image_db = null;

        $sql_img = "SELECT acc_image FROM account WHERE acc_id = '$id'";
        $result_img = $conn->query($sql_img);

        if ($result_img->num_rows > 0) {
            $row = $result_img->fetch_assoc();
            $acc_image_db = $row['acc_image'];
        }
    }

    // ทำการอัพเดตข้อมูล
    $sqlUpdate = "UPDATE account
        SET acc_name='$acc_name', acc_email='$acc_email', acc_image='$acc_image_db'
        WHERE acc_id = '$id'";
    $resql1 = $conn->query($sqlUpdate);

    $sqlUpdate2 = "UPDATE admin
        SET admin_fname='$admin_fname', admin_lname='$admin_lname', admin_gender='$admin_gender', admin_bdate='$admin_bdate', admin_phone='$admin_phone', career_id='$career_id', updateAt='$updateAt' 
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