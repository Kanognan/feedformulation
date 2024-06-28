<?php
session_start();
include('../server.php');

if (isset($_GET['id'])) {
    $knowledge_id = $_GET['id'];

    $sql_delete_knowledge_img = "DELETE FROM knowledge_img WHERE knowledge_id = $knowledge_id";
    mysqli_query($conn, $sql_delete_knowledge_img);

    $sql_delete_knowledge = "DELETE FROM knowledge WHERE knowledge_id = $knowledge_id";
    mysqli_query($conn, $sql_delete_knowledge);

    $resultDeleteKnow = "ข้อมูลถูกลบเรียบร้อยแล้ว";
    $_SESSION['resultDeleteKnow'] = $resultDeleteKnow;
    echo "<script type='text/javascript'>";
    echo "window.location = 'knowledge.php'; ";
    echo "</script>";
    exit();
} else {
    header("Location: knowledge.php");
    exit();
}
?>
