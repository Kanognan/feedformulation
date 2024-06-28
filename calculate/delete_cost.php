<?php
session_start();
include('../server.php');

if (isset($_GET['id'])) {
    $group_cal_id = $_GET['id'];
    $deleteAt = date('Y-m-d H:i:s');
    $sql_soft_delete = "UPDATE group_calculate SET deleteAt = '$deleteAt' WHERE group_cal_id = $group_cal_id";

    if (mysqli_query($conn, $sql_soft_delete)) {
        $resultDeleteCost = "ข้อมูลได้ถูกลบเรียบร้อยแล้ว";
        $_SESSION['resultDeleteCost'] = $resultDeleteCost;
        echo "<script type='text/javascript'>";
        echo "window.location = 'cost_history.php'; ";
        echo "</script>";
    } else {
        $errorDeleteCost = "มีข้อผิดพลาดเกิดขึ้นในการลบข้อมูล";
        $_SESSION['errorDeleteCost'] = $errorDeleteCost;
        echo "<script type='text/javascript'>";
        echo "window.location = 'cost_history.php'; ";
        echo "</script>";
    }
} else {
    $errorDeleteCost = "มีข้อผิดพลาดเกิดขึ้นในการลบข้อมูล";
    $_SESSION['errorDeleteCost'] = $errorDeleteCost;
    echo "<script type='text/javascript'>";
    echo "window.location = 'cost_history.php'; ";
    echo "</script>";
}
?>