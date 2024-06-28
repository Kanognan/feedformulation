<?php
session_start();
include('../server.php');

date_default_timezone_set('Asia/Bangkok');
$createAt = date('Y-m-d H:i:s', time());
$news_topic = $_POST['news_topic'];
$news_detail = $_POST['news_detail'];
$acc_id = $_SESSION['acc_id'];
$category = $_POST['category'];
$filenames = isset($_FILES["upload"]["name"]) ? $_FILES["upload"]["name"] : null;
$fileTmpNames = isset($_FILES["upload"]["tmp_name"]) ? $_FILES["upload"]["tmp_name"] : null;

//*** Insert Question ***//

$strSQL = "INSERT INTO
    news(
        news_topic,
        news_detail,
        acc_id,
        category_news_id
    ) VALUES (
        '$news_topic',
        '$news_detail',
        '$acc_id',
        '$category'
    )";

if (mysqli_query($conn, $strSQL)) {
    // หากสร้างข่าวสำเร็จ
    $news_id = mysqli_insert_id($conn); // รับค่า news_id ที่สร้างขึ้นมาใหม่

    // ตรวจสอบว่ามีการอัปโหลดรูปภาพหรือไม่
    if (!empty($filenames) && array_filter($filenames)) { // เพิ่ม array_filter เพื่อตรวจสอบว่ามีค่าที่เป็นช่องว่างหรือไม่
        foreach ($filenames as $key => $filename) {
            if($filename) { // เพิ่มเงื่อนไขตรวจสอบ $filename ว่าไม่เป็นค่าว่าง
                $tmpName = $fileTmpNames[$key];

                $ext = explode(".", $filename);
                $acExt = strtolower(end($ext));
                $newFilename = time() . "_" . $key . "." . $acExt; // สร้างชื่อไฟล์ใหม่
                $meetFileLocation = '../pic/' . $newFilename;

                // ย้ายไฟล์ไปยังตำแหน่งที่ต้องการ
                if (move_uploaded_file($tmpName, $meetFileLocation)) {
                    // เมื่ออัปโหลดไฟล์ภาพสำเร็จ
                    $sql = "INSERT INTO news_img (news_img, news_id) VALUES ('$meetFileLocation','$news_id')";
                    $result = mysqli_query($conn, $sql);
                    if (!$result) {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                } else {
                    // ถ้าเกิดข้อผิดพลาดในการอัปโหลดไฟล์
                    echo "Failed to upload image.";
                    exit; // หยุดการทำงานทันที
                }
            }
        }
    } 

    // ถ้าไม่มีไฟล์รูปภาพที่อัปโหลดเข้ามา
    else {
        // บันทึกรูป news หากไม่มีการเลือกไฟล์รูปภาพจากฟอร์มส่งมา
        $meetFileLocation = '../pic/news.png';

        // เพิ่มข้อมูลลงในฐานข้อมูล
        $sql = "INSERT INTO news_img (news_img, news_id) VALUES ('$meetFileLocation', '$news_id')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

	mysqli_close($conn);
	if ($conn) {
        $resultData = "ข้อมูลถูกบันทึกเรียบร้อยแล้ว";
        $_SESSION['resultData'] = $resultData;
        header("Location: expert-news.php");
        exit();
	} else {
		echo "<script type='text/javascript'>";
		echo "window.location = 'expert-news.php'; ";
		echo "</script>";
	}
}

