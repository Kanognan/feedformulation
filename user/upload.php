<?php
session_start();
require_once('../server.php');

// ตรวจสอบว่ามีการเรียกอัปโหลดไฟล์ภาพหรือไม่
if (isset($_POST['upload'])) {
    // ตรวจสอบว่ามีไฟล์ภาพถูกอัปโหลดหรือไม่
    if (isset($_FILES['profile_pic'])) {
        $file = $_FILES['profile_pic'];
        if ($file['error'] === 0) {
            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($fileExt, $allowedExtensions)) {
                if ($fileSize <= 5242880) { // 5 MB (1 MB = 1024 KB)
                    $newFileName = uniqid() . '.' . $fileExt;
                    $uploadPath = '../pic/' . $newFileName;
                    if ($conn->connect_error) {
                        die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
                    }
                    $sql = "UPDATE account SET acc_image = ? WHERE acc_id = ?";
                    $stmt = $conn->prepare($sql);
                    if ($stmt) {
                        $userId = $_SESSION['acc_id'];
                        $stmt->bind_param("si", $newFileName, $userId);
                        if ($stmt->execute()) {
                            echo 'อัปโหลดรูปโปรไฟล์และบันทึกเรียบร้อยแล้ว';
                            $sql = "SELECT acc_image FROM account WHERE acc_id = $userId";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $newProfilePic = $row['acc_image'];
                                $profilePicURL = '../pic/' . $newProfilePic; // ปรับ URL ตามโครงสร้างโฟลเดอร์ของคุณ
                            } else {
                                echo 'ไม่พบข้อมูลรูปโปรไฟล์ใหม่';
                            }
                        } else {
                            echo 'มีข้อผิดพลาดในการบันทึกรูปภาพใหม่: ' . $stmt->error;
                        }

                        $stmt->close(); // ปิดคำสั่ง SQL
                    } else {
                        echo 'มีข้อผิดพลาดในการเตรียมคำสั่ง SQL: ' . $conn->error;
                    }

                    $conn->close(); // ปิดการเชื่อมต่อกับฐานข้อมูล
                } else {
                    echo 'ไฟล์มีขนาดใหญ่เกินไป (ขนาดสูงสุด 5 MB)';
                }
            } else {
                echo 'ประเภทไฟล์ไม่ถูกต้อง (รองรับเฉพาะ jpg, jpeg, png, และ gif)';
            }
        } else {
            echo 'มีข้อผิดพลาดในการอัปโหลดไฟล์: ' . $file['error'];
        }
    } else {
        echo 'ไม่มีไฟล์รูปภาพถูกอัปโหลด';
    }
}

?>