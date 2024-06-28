<?php

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
    if (isset($_POST['health'])) {
        $health_date = $_POST['health_date'];
        $type_dianosis_id = $_POST['type_dianosis_id'];
        $symptom = $_POST['symptom'];
        $health_officer = $_POST['health_officer'];
        $health_status = $_POST['health_status'];
        $note = $_POST['note'];
        $cow_id = $_POST['cow_id'];

        //จอยตาราง
        $bd = "INSERT INTO cow_health (health_date,type_dianosis_id,symptom,health_officer,health_status, note,cow_id)
VALUES ('$health_date','$type_dianosis_id','$symptom','$health_officer','$health_status','$note','$cow_id')";
        $query = mysqli_query($conn, $bd) or die(mysqli_error($conn));
    }
    mysqli_close($conn);
    if ($conn) {
        $resultData = "ข้อมูลถูกบันทึกเรียบร้อยแล้ว";
        $_SESSION['resultData'] = $resultData;
        header("Location: index_health_cow.php");
        exit();
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('เพิ่มข้อมูลไม่สำเร็จ');";
        echo "window.location = 'index_health_cow.php'; ";
        echo "</script>";
    }

    ?>

</body>

</html>