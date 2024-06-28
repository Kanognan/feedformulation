<?php
session_start();
include("../server.php");

if (isset($_GET['id'])) {
    $posts_img_id = $_GET['id'];

    // สร้างคำสั่ง SQL สำหรับการดึง postsID จากตาราง posts_img
    $get_postsID_query = "SELECT postsID FROM posts_img WHERE posts_img_id = $posts_img_id";
    $result_postsID = mysqli_query($conn, $get_postsID_query);

    if ($result_postsID) {
        $row = mysqli_fetch_assoc($result_postsID);
        $postsID = $row['postsID'];

        $delete_query = "DELETE FROM posts_img WHERE posts_img_id = $posts_img_id";

        if (mysqli_query($conn, $delete_query)) {
            $resultDeleteImg = "รูปภาพถูกลบเรียบร้อยแล้ว";
            $_SESSION['resultDeleteImg'] = $resultDeleteImg;
            echo "<script type='text/javascript'>";
            echo "window.location = 'mypost_edit.php?id=$postsID'; ";
            echo "</script>";
            exit();
        } else {
            echo "เกิดข้อผิดพลาดในการลบรูปภาพ: " . mysqli_error($conn);
        }
    } else {
        echo "ไม่พบรหัสรูปภาพที่ต้องการลบ";
    }
} else {
    echo "ไม่พบรหัสรูปภาพที่ต้องการลบ";
}

// ปิดการเชื่อมต่อกับ MySQL Database
mysqli_close($conn);
?>
