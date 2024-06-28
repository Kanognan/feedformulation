<?php
session_start();
include "../server.php";

$rawId = $_GET['raw_id'];

$sqlPrice = "SELECT price FROM price WHERE raw_id = $rawId";
$resultPrice = $conn->query($sqlPrice);

if ($resultPrice) {
    $rowPrice = $resultPrice->fetch_assoc();
    $price = $rowPrice['price'];

    echo json_encode(['price' => $price]);
} else {
    echo json_encode(['error' => 'Error in SQL Price: ' . $conn->error]);
}
?>
