<?php
//session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php //include "../header.php" ;      ?>
    <title>Document</title>
</head>

<body>
    <?php
    include('../server.php');

    if (isset($_POST['delete'])) {
        if (isset($_POST['price_id'])) {
            $price_id = $_POST['price_id'];
            $delete_sql = "DELETE FROM price WHERE price_id = '$price_id'";
            if ($conn->query($delete_sql) === TRUE) {
                $resultDelete = "ลบข้อมูลราคาสำเร็จ";
                $_SESSION['resultDelete'] = $resultDelete;
                echo "<script type='text/javascript'>";
                echo "window.location = 'price.php'; ";
                echo "</script>";
            } else {
                // ไม่สำเร็จ
                echo "<script>alert('เกิดข้อผิดพลาดในการลบข้อมูลราคา'); window.location.href='price.php';</script>";
            }
        }
        if (isset($_POST['price_ms_id'])) {
            $price_ms_id = $_POST['price_ms_id'];
            $delete_sqlMs = "DELETE FROM price_ms WHERE price_ms_id = '$price_ms_id'";
            if ($conn->query($delete_sqlMs) === TRUE) {
                $resultDelete = "ลบข้อมูลราคาสำเร็จ";
                $_SESSION['resultDelete'] = $resultDelete;
                echo "<script type='text/javascript'>";
                echo "window.location = 'price.php'; ";
                echo "</script>";
            } else {
                // ไม่สำเร็จ
                echo "<script>alert('เกิดข้อผิดพลาดในการลบข้อมูลราคา'); window.location.href='price.php';</script>";
            }
        }
    }
    ?>

</body>

</html>