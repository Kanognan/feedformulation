<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedformulation";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("connection failed :" . $conn->connect_error);
}

date_default_timezone_set('Asia/bangkok');

?>
