<?php
include '../server.php';
session_start();

date_default_timezone_set('Asia/Bangkok');
$createAt = date('Y-m-d H:i:s', time());

$knowledge_topic = $_POST['knowledge_topic'];
$knowledge_content = $_POST['knowledge_content'];
// $usertest = 1;
$acc_id = $_SESSION['acc_id'];
$category_knowledge = $_POST['category_knowledge'];

$filenames = isset ($_FILES["knowledge_img"]["name"]) ? $_FILES["knowledge_img"]["name"] : null;
$fileTmpNames = isset ($_FILES["knowledge_img"]["tmp_name"]) ? $_FILES["knowledge_img"]["tmp_name"] : null;

$strSQL = "INSERT INTO
    knowledge(
        knowledge_topic,
        knowledge_content,
        acc_id,
        category_knowledge_id
    ) VALUE (
        '$knowledge_topic',
        '$knowledge_content',
        '$acc_id',
        '$category_knowledge'
    )";
if (mysqli_query($conn, $strSQL)) {
    $knowledge_id = mysqli_insert_id($conn);

    if (!empty ($filenames) && array_filter($filenames)) {
        foreach ($filenames as $key => $filename) {
            if ($filename) {
                $tmpName = $fileTmpNames[$key];

                $ext = explode(".", $filename);
                $acExt = strtolower(end($ext));
                $newFilename = time() . "_" . $key . "." . $acExt;
                $meetFileLocation = '../pic/' . $newFilename;
                if (move_uploaded_file($tmpName, $meetFileLocation)) {
                    $sql = "INSERT INTO knowledge_img (knowledge_img, knowledge_id) VALUES ('$meetFileLocation','$knowledge_id')";
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

    mysqli_close($conn);

    $resultAddKnow = "เพิ่มข้อมูลสำเร็จ";
    $_SESSION['resultAddKnow'] = $resultAddKnow;
    echo "<script type='text/javascript'>";
    echo "window.location = 'knowledge.php'; ";
    echo "</script>";
    exit();
} else {
    $resultErrorKnow = "เพิ่มข้อมูลไม่สำเร็จ";
    $_SESSION['resultErrorKnow'] = $resultErrorKnow;
    echo "<script type='text/javascript'>";
    echo "window.location = 'knowledge.php'; ";
    echo "</script>";
    exit();
}
?>