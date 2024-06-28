<?php
include "../server.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['personalId']) && isset($_POST['dataType'])) {
        $personalId = $_POST['personalId'];
        $dataType = $_POST['dataType'];

        if ($dataType === 'personal_raw') {
            $tableName = 'personal_raw';
            $idColumn = 'personal_raw_id';
        } elseif ($dataType === 'personal_ms') {
            $tableName = 'personal_ms';
            $idColumn = 'personal_ms_id';
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'ประเภทข้อมูลไม่ถูกต้อง'));
            exit();
        }

        $sqlDelete = "DELETE FROM $tableName WHERE $idColumn = $personalId";
        $resultDelete = mysqli_query($conn, $sqlDelete);

        if ($resultDelete) {
            echo json_encode(array('status' => 'success', 'message' => 'ลบข้อมูลสำเร็จ'));
            exit();
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการลบข้อมูล: ' . mysqli_error($conn)));
            exit();
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'ข้อมูลไม่ถูกต้องหรือไม่ครบถ้วน'));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
    exit();
}
?>
