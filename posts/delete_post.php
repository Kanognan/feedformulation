<?php
session_start();
include ("../server.php");
if (isset($_POST['postsID'])) {
    $postsID = $_POST['postsID'];
    // echo 'postsID: ' . $postsID;
    mysqli_query($conn, "UPDATE posts SET deleteAt = NOW() WHERE postsID = '$postsID'");

    $resultDeletePost = "กระทู้ของคุณถูกลบเรียบร้อยแล้ว";
    $_SESSION['resultDeletePost'] = $resultDeletePost;
    echo "<script type='text/javascript'>";
    echo "window.location = 'mypost.php'; ";
    echo "</script>";
} else {
    echo "<script type='text/javascript'>";
    echo "alert('ไม่สามารถลบกระทู้ได้ โปรดลองอีกครั้ง');";
    echo "window.location = 'mypost.php'; ";
    echo "</script>";
}

?>