<?php
session_start();
include ("../server.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postsID = $_SESSION["postsID"];
    $posts_name = $_POST['posts_name'];
    $posts_content = $_POST['posts_content'];

    $filenames = isset($_FILES["img"]["name"]) ? $_FILES["img"]["name"] : null;
    $fileTmpNames = isset($_FILES["img"]["tmp_name"]) ? $_FILES["img"]["tmp_name"] : null;
    if (!empty($filenames) && array_filter($filenames)) {
        foreach ($filenames as $key => $filename) {
            if ($filename) {
                $tmpName = $fileTmpNames[$key];

                $ext = explode(".", $filename);
                $acExt = strtolower(end($ext));
                $newFilename = time() . "_" . $key . "." . $acExt;
                $meetFileLocation = '../pic/' . $newFilename;

                if (move_uploaded_file($tmpName, $meetFileLocation)) {
                    $sql = "INSERT INTO posts_img (posts_img, postsID) VALUES ('$meetFileLocation','$postsID')";
                    $result = mysqli_query($conn, $sql);
                    if (!$result) {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    } else {
                        $resultData = "ข้อมูลถูกบันทึกเรียบร้อยแล้ว";
                        $_SESSION['resultData'] = $resultData;
                    }
                } else {
                    echo "Failed to upload image.";
                    exit;
                }
            }
        }
    }

    $update_query = "UPDATE posts SET posts_name = '$posts_name', posts_content = '$posts_content' WHERE postsID = '$postsID'";
    if (mysqli_query($conn, $update_query)) {
        $resultUpdatePost = "แก้ไขข้อมูลกระทู้สำเร็จ";
        $_SESSION['resultUpdatePost'] = $resultUpdatePost;
        echo "<script type='text/javascript'>";
        echo "window.location = 'mypost.php'; ";
        echo "</script>";
        exit();
    } else {
        echo "เกิดข้อผิดพลาดในการอัพเดตโพสต์: " . mysqli_error($conn);
    }
} else {
    echo "ไม่สามารถเข้าถึงหน้านี้โดยตรงได้";
}

mysqli_close($conn);
