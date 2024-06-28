<?php 
session_start();
include('../server.php');
$cow_vaccine_id = $_GET['cow_vaccine_id'];
$date_cow_vaccine = $_POST['date_cow_vaccine'];
$vaccine_officer = $_POST['vaccine_officer'];
$type_vaccine_id = $_POST['type_vaccine_id'];

$vaccine = " UPDATE cow_vaccine set date_cow_vaccine ='" . $date_cow_vaccine . "',vaccine_officer='" . $vaccine_officer . "'
    ,type_vaccine_id='" . $type_vaccine_id . "' where cow_vaccine_id='" . $cow_vaccine_id ."'";
    // echo $up;
    $vaccineq = mysqli_query($conn, $vaccine) or die (mysqli_error($conn)); 
    mysqli_close($conn);
    if ($conn) {
        $editData = "แก้ไขข้อมูลเรียบร้อยแล้ว";
        $_SESSION['editData'] = $editData;
        header("Location: index_vaccine_cow.php");
        exit();
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('แก้ไขข้อมูลไม่สำเร็จ');";
        echo "window.location = 'index_vaccine_cow.php'; ";
        echo "</script>";
    }
?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 