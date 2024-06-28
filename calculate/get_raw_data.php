<?php
include("../server.php");

$rawId = $_GET['raw_id'];

$sql = "SELECT * FROM raw WHERE raw_id = $rawId";
$result = $conn->query($sql);

$response = array();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $response['success'] = true;
    $response['data'] = $row;
} else {
    $response['success'] = false;
    $response['message'] = 'ไม่พบข้อมูล';
}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
