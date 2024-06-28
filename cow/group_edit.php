<?php
    session_start();
    include('../server.php');

        $group_id = $_GET['group_id'];
        $group_name = $_POST['group_name'];

        $up = "UPDATE group_cow SET group_name = '" . $group_name . "' WHERE group_id = '" . $group_id . "'";
        $query = mysqli_query($conn, $up) or die(mysqli_error($conn));
        mysqli_close($conn);
    if ($conn) {
        $editData = "แก้ไขข้อมูลเรียบร้อยแล้ว";
        $_SESSION['editData'] = $editData;
        header("Location : group.php");
        exit();
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('แก้ไขข้อมูลไม่สำเร็จ');";
        echo "window.location = group.php; ";
        echo "</script>";
    }
    
?>
