<?php

$servername = "localhost:3306";
$username = "kkufeed_feedformulation";
$password = "1xa44Y_k3";
$dbname = "kkufeed_feedformulation";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("connection failed :" . $conn->connect_error);
}

date_default_timezone_set('Asia/bangkok');

?>