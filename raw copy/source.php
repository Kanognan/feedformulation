<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedformulation";

$conn = new mysqli($servername, $username, $password, $dbname);

date_default_timezone_set('asia/bangkok');
$create_At = date('Y-m-d H:i:s', time());

$errors = array();


if (isset($_POST['addSource'])) {
    $acc_id = 1;
    $type_ms_id = $_POST["type_ms_id"];
    $ms_thainame = $_POST['ms_thainame'];
    $ms_engname = $_POST['ms_engname'];
    $feed_class = $_POST['feed_class'];

    if ($conn) {
        $sql1 = "INSERT INTO mineral_source_raw (ms_thainame, ms_engname, feed_class, type_ms_id, acc_id) VALUES ('$ms_thainame', '$ms_engname', '$feed_class', '$type_ms_id', '$acc_id')";
        $resql1 = $conn->query($sql1);
        $ms_id = $conn->insert_id;

        if ($resql1) {
            // Insertion successful
            echo "<script type='text/javascript'>";
            echo "alert('บันทึกข้อมูลสำเร็จ');";
            echo "window.location = 'raw_material.php'; ";
            echo "</script>";
        } else {
            // Insertion failed
            echo "error: " . $conn->error;
        }

        $conn->close();

    } else {
        header("location: raw_material.php");
    }
}


?>