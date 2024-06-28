<?php   
include ('../server.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  
   
</head>

<body>
    <?php 
if (isset($_POST['milk'])){
	$date_milk = $_POST['date_milk'];
	$milk_amount = $_POST['milk_amount'];
	$milk_fat = $_POST['milk_fat'];
    $milk_protein = $_POST['milk_protein'];
    $note = $_POST['note'];
    $cow_id = $_POST['cow_id'];
    
    //จอยตาราง
  
$bdmilk = "INSERT INTO cow_milk ( date_milk,milk_amount,milk_fat,milk_protein,note,cow_id)
VALUES ('$date_milk','$milk_amount','$milk_fat','$milk_protein','$note','$cow_id')";
$query = mysqli_query($conn, $bdmilk) or die (mysqli_error($conn)); 
}
mysqli_close($conn);
if ($conn) {
    $resultData = "ข้อมูลถูกบันทึกเรียบร้อยแล้ว";
    $_SESSION['resultData'] = $resultData;
    header("Location: index_milk_cow.php");
    exit();
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('เพิ่มข้อมูลไม่สำเร็จ');";
        echo "window.location = 'index_milk_cow.php'; ";
        echo "</script>";
    }


?>

</body>

</html>