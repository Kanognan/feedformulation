<?php
session_start();
include '../server.php';

date_default_timezone_set('Asia/Bangkok');
$createAt = date('Y-m-d H:i:s', time());
$posts_name = $_POST['posts_name'];
$posts_content = $_POST['posts_content'];
$acc_id = $_SESSION['acc_id'];
$category_id = $_POST['category'];

$filenames = isset($_FILES["img"]["name"]) ? $_FILES["img"]["name"] : null;
$fileTmpNames = isset($_FILES["img"]["tmp_name"]) ? $_FILES["img"]["tmp_name"] : null;

$strSQL = "INSERT INTO
    posts(
        posts_name,
        posts_content,
        acc_id,
        category_id
    ) VALUE (
        '$posts_name',
        '$posts_content',
        '$acc_id',
        '$category_id'
    )";

if (mysqli_query($conn, $strSQL)) {
    $postsID = mysqli_insert_id($conn);

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
    // Redirect to home-webboard.php after successfully adding data
    echo "<script type='text/javascript'>";
    echo "window.location = 'home-webboard.php'; ";
    echo "</script>";
    exit();
} else {
    echo "<script type='text/javascript'>";
    echo "window.location = 'home-webboard.php'; ";
    echo "</script>";
    exit();
}
