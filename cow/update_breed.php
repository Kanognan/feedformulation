<?php 
session_start();
include('../server.php');
$breed_id = $_GET['breed_id'];
$calf_no = $_POST['calf_no'];
$cow_breed_bday = $_POST['cow_breed_bday'];
$calf_id = $_POST['calf_id'];
$calf_gender = $_POST['flexRadioDefault'];
$breed_calf = " UPDATE cow_breed set calf_no ='" . $calf_no . "',cow_breed_bday='" . $cow_breed_bday . "'
    ,calf_id='" . $calf_id . "',calf_gender='".$calf_gender."' where breed_id='" . $breed_id ."'";
    // echo $up;
    $breed_calfq = mysqli_query($conn, $breed_calf) or die (mysqli_error($conn)); 
    echo "<script type='text/javascript'>";
        echo "alert('แก้ไขข้อมูลสำเร็จ');";
        echo "window.location = 'cow.php'; ";
        echo "</script>";
?>
