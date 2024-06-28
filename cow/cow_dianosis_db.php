<?php
session_start();
include('../server.php');
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
    if (isset($_POST['dia'])) {
        $dianosis_date = $_POST['dianosis_date'];
        $disease_result = $_POST['disease_result'];
        $type_dianosis_id = $_POST['type_dianosis_id'];
        $cow_id = $_POST['cow_id'];

        //จอยตาราง
        $bd = "INSERT INTO cow_dianosis (dianosis_date,disease_result, type_dianosis_id,cow_id)
VALUES ('$dianosis_date','$disease_result','$type_dianosis_id','$cow_id')";
        $query = mysqli_query($conn, $bd) or die(mysqli_error($conn));
    }
    mysqli_close($conn);
    if ($conn) {
        $resultData = "ข้อมูลถูกบันทึกเรียบร้อยแล้ว";
        $_SESSION['resultData'] = $resultData;
        header("Location: index_dianosis_cow.php");
        exit();
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('เพิ่มข้อมูลไม่สำเร็จ');";
        echo "window.location = 'index_dianosis_cow.php'"; // เพื่อให้กลับไปหน้า 'cow.php'
        echo "</script>";
    }

    ?>

</body>

</html>