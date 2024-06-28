<?php
session_start();
include('../server.php');
$acc_id = $_SESSION['acc_id'];

if (isset($_POST['editknowledge'])) {
    $knowledge_id = $_POST['knowledge_id'];
    $knowledge_topic = $_POST['knowledge_topic'];
    $knowledge_content = $_POST['knowledge_content'];
    $category_knowledge = $_POST['category_knowledge'];

    if (!empty($_FILES['knowledge_img']['name'][0])) {
        $sql_update_old_images = "UPDATE knowledge_img SET deleteAt = NOW() WHERE knowledge_id = $knowledge_id";
        mysqli_query($conn, $sql_update_old_images);

        foreach ($_FILES['knowledge_img']['tmp_name'] as $key => $file_tmp) {
            $file_name = $_FILES['knowledge_img']['name'][$key];
            $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $new_file_name = uniqid() . '.' . $file_extension;
            $target_dir = '../pic/';
            $target_file = $target_dir . $new_file_name;

            if (move_uploaded_file($_FILES['knowledge_img']['tmp_name'][$key], $target_file)) {
                $sql_insert_image = "INSERT INTO knowledge_img (knowledge_id, knowledge_img) 
                                     VALUES ($knowledge_id, '$new_file_name')";
                mysqli_query($conn, $sql_insert_image);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    $sql_update_knowledge = "UPDATE knowledge SET category_knowledge_id = $category_knowledge, 
        knowledge_topic = '$knowledge_topic', knowledge_content = '$knowledge_content' 
        WHERE knowledge_id = $knowledge_id";
    mysqli_query($conn, $sql_update_knowledge);

    $resultEditKnow = "อัพเดตข้อมูลเรียบร้อยแล้ว";
    $_SESSION['resultEditKnow'] = $resultEditKnow;
    echo "<script type='text/javascript'>";
    echo "window.location = 'knowledge_topic.php?id=$knowledge_id'; ";
    echo "</script>";
    exit();
}
?>
