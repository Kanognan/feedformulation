<?php 
session_start();
include('../server.php');
$cow_milk_id = $_GET['cow_milk_id'];
$date_milk = $_POST['date_milk'];
$milk_amount = $_POST['milk_amount'];
$milk_fat = $_POST['milk_fat'];
$milk_protein = $_POST['milk_protein'];
$note = $_POST['note'];
$milk = " UPDATE cow_milk set date_milk ='" . $date_milk . "',milk_amount='" . $milk_amount . "'
    ,milk_fat='" . $milk_fat . "',milk_protein='" . $milk_protein . "',note='" . $note . "' where cow_milk_id='" . $cow_milk_id ."'";
    // echo $up;
    $milkq = mysqli_query($conn, $milk) or die (mysqli_error($conn)); 
    mysqli_close($conn);
    if ($conn) {
        $editData = "แก้ไขข้อมูลเรียบร้อยแล้ว";
        $_SESSION['editData'] = $editData;
        header("Location: index_milk_cow.php");
        exit();
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('แก้ไขข้อมูลไม่สำเร็จ');";
        echo "window.location = 'index_milk_cow.php'; ";
        echo "</script>";
    }
?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>