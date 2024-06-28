<?php
include "../server.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['RawId'], $_POST['DataType'], $_POST['RawGroupId'])) {
    // if (isset($_POST['dataType'])) {
        $RawId = $_POST['RawId'];
        $dataType = $_POST['DataType'];
        $rawGroupId = $_POST['RawGroupId'];

        $sqlDeleteGroup = "";

        if ($dataType === 'raw') {
            $sqlDeleteGroup = "DELETE FROM raw_material_in_group WHERE raw_id = $RawId AND raw_group_id = $rawGroupId";
        } elseif ($dataType === 'ms') {
            $sqlDeleteGroup = "DELETE FROM mineral_source_in_group WHERE ms_id = $RawId AND raw_group_id = $rawGroupId";
        }

        // Execute SQL query
        $resultDeleteGroup = mysqli_query($conn, $sqlDeleteGroup);

        if ($resultDeleteGroup) {
            echo json_encode(array('status' => 'success', 'message' => 'ลบข้อมูลสำเร็จ'));
            exit();
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการลบข้อมูล: ' . mysqli_error($conn)));
            exit();
        }
        if (!$resultDeleteGroup) {
            echo json_encode(array('status' => 'error', 'message' => 'เกิดข้อผิดพลาดในการลบข้อมูล: ' . mysqli_error($conn)));
            exit();
        }
        
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'no ID' . $_POST['DataType']));
        exit();
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
    exit();
}
?>