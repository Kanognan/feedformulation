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
    if (isset($_POST['addgroup'])) {
        $group_name = $_POST["group_name"];
        $id = (isset($_POST['id'])) ? $_POST['id'] : NULL;
        // echo $id;
    ?>
        <?php
        $sql = "INSERT INTO group_cow (group_name) VALUES ('$group_name')";
        $kol = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $group_id = $conn->insert_id;

        if (count($id) > 0) { // ตรวจสอบ checkbox ว่ามีการเลือกมาอย่างน้อย 1 รายการหรือไม่
            foreach ($id as $key => $value) {
                // แสดงชุดข้อมูล ที่สอดคล้องกับ checkbox
                $up = "UPDATE cow SET group_id = '$group_id' WHERE cow_id = '$id[$key]'";

                $gcow = mysqli_query($conn, $up) or die(mysqli_error($conn));
                
            }
        }
    }
    mysqli_close($conn);
	if ($conn) {
        $resultData = "ข้อมูลถูกบันทึกเรียบร้อยแล้ว";
        $_SESSION['resultData'] = $resultData;
        header("Location: group.php");
        exit();
	} else {
		echo "<script type='text/javascript'>";
		echo "window.location = 'group.php'; ";
		echo "</script>";
	}

    ?>



</body>

</html>