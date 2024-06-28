<?php
session_start(); 
include('../server.php');
$cow_dianosis_id = $_GET['cow_dianosis_id'];
$dianosis_date = $_POST['dianosis_date'];
$disease_result = $_POST['disease_result'];
$type_dianosis_name = $_POST['type_dianosis_name'];
$dianosis = " UPDATE cow_dianosis set dianosis_date ='" . $dianosis_date . "',disease_result='" . $disease_result . "',type_dianosis_id='" . $type_dianosis_name . "' where cow_dianosis_id='" . $cow_dianosis_id ."'";
    // echo $up;
    $dianosisq = mysqli_query($conn, $dianosis) or die (mysqli_error($conn)); 
    mysqli_close($conn);
    if ($conn) {
        $editData = "แก้ไขข้อมูลเรียบร้อยแล้ว";
        $_SESSION['editData'] = $editData;
        header("Location: index_dianosis_cow.php");
        exit();
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('แก้ไขข้อมูลไม่สำเร็จ');";
        echo "window.location = 'index_dianosis_cow.php'; ";
        echo "</script>";
    }
?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 