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


if (isset($_POST['addRawMat'])) {
    $acc_id = 1;
    $type_raw_id = $_POST["type_id"];
    $raw_engname = $_POST['raw_engname'];
    $raw_thainame = $_POST['raw_thainame'];
    $feed_class = $_POST['feed_class'];


    if ($conn) {
        $sql1 = "INSERT INTO raw_material (type_raw_id, raw_engname, raw_thainame, feed_class, acc_id) VALUES ('$type_raw_id', '$raw_engname', '$raw_thainame', '$feed_class', '$acc_id')";
        $resql1 = $conn->query($sql1);
        $raw_id = $conn->insert_id;

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