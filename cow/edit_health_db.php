<?php
session_start(); 
include('../server.php');
$cow_health_id = $_GET['cow_health_id'];
$health_date = $_POST['health_date'];
$symptom = $_POST['symptom'];
$health_officer = $_POST['health_officer'];
$health_status= $_POST['health_status'];
$note = $_POST['note'];
$type_dianosis_id = $_POST['type_dianosis_id'];
$health = " UPDATE cow_health set health_date ='" . $health_date . "',symptom='" . $symptom . "'
    ,health_officer='" . $health_officer . "',health_status='" . $health_status . "',note='" . $note . "',type_dianosis_id='" . $type_dianosis_id . "' where cow_health_id='" . $cow_health_id ."'";
    // echo $up;
    $healthq = mysqli_query($conn, $health) or die (mysqli_error($conn)); 
    mysqli_close($conn);
    if ($conn) {
        $editData = "แก้ไขข้อมูลเรียบร้อยแล้ว";
        $_SESSION['editData'] = $editData;
        header("Location: index_health_cow.php");
        exit();
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('แก้ไขข้อมูลไม่สำเร็จ');";
        echo "window.location = 'index_health_cow.php'; ";
        echo "</script>";
    }

?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 