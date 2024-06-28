<?php 
session_start();
include('../server.php');
$breed_id = $_GET['breed_id'];
$breed_date = $_POST['breed_date'];
$breed_breeder = $_POST['breed_breeder'];
$cow_breed_officer = $_POST['cow_breed_officer'];

$breed = " UPDATE cow_breed set breed_date ='" . $breed_date . "',breed_breeder ='" . $breed_breeder . "',cow_breed_officer ='" . $cow_breed_officer . "'
     where breed_id='" . $breed_id ."'";
    // echo $up;
    $breedq = mysqli_query($conn, $breed) or die (mysqli_error($conn)); 
    echo "<script type='text/javascript'>";
        echo "alert('แก้ไขข้อมูลสำเร็จ');";
        echo "window.location = 'cow.php'"; 
        echo "</script>";
?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 