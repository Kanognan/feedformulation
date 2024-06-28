<?php 
session_start();   
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
if (isset($_POST['addbreed'])){
	$breed_date = $_POST['breed_date'];
	$breed_breeder = $_POST['breed_breeder'];
	$cattle_breed_breeder = $_POST['cattle_breed_breeder'];
	$cow_breed_officer = $_POST['cow_breed_officer'];
	$breed_status = "รอตรวจท้อง";
    $cow_milk_status = "ไม่ให้นม";
    $calf_day = null; // หรือให้เป็นค่า null ตามที่คุณต้องการ
    $milk_day = null;
        // ตรวจสอบค่า null
        if (is_null($calf_day)) {
            echo "-";
        } else {
            echo "ค่าของ calf_day: $calf_day";
        }
        echo "<br>";
        if ($milk_day === null) {
            echo "-";
        } else {
            echo "ค่าของ milk_day: $milk_day";
        }
        
            $cow_id = $_POST['cow_id'];

    //จอยตาราง
$bd = "INSERT INTO cow_breed (breed_date,breed_breeder, cattle_breed_breeder, cow_breed_officer,breed_status,cow_id)
VALUES ('$breed_date','$breed_breeder','$cattle_breed_breeder','$cow_breed_officer','$breed_status','$cow_id')";
$query = mysqli_query($conn, $bd) or die (mysqli_error($conn)); 

$cow = "UPDATE cow set cow_milk_status ='" . $cow_milk_status . "' where cow_id='" . $cow_id ."'";
$cowquery = mysqli_query($conn, $cow) or die (mysqli_error($conn)); 
}
mysqli_close($conn);
    if ($conn) {
        $resultData = "ข้อมูลถูกบันทึกเรียบร้อยแล้ว";
        $_SESSION['resultData'] = $resultData;
        header("Location: index_breed_cow.php");
        exit();
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('เพิ่มข้อมูลไม่สำเร็จ');";
        echo "window.location = 'index_breed_cow.php'"; // เพื่อให้กลับไปหน้า 'cow.php'
        echo "</script>";
    }

?>

</body>

</html>