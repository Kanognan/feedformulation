<?php
session_start();
include('../server.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
</head>

<body>
    <?php
    include('../server.php');


    if (isset($_GET['raw_id']) && !empty($_GET['raw_id'])) {
        $raw_id = $_GET['raw_id'];
        mysqli_query($conn, "UPDATE raw_material SET deleteAt = NOW() WHERE raw_id = '$raw_id'");
        $resultDeleteRaw = "ลบรายการวัตถุดิบสำเร็จ";
        $_SESSION['resultDeleteRaw'] = $resultDeleteRaw;
        echo "<script type='text/javascript'>";
        echo "window.location = 'edit_nutrition.php'; ";
        echo "</script>";
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('ไม่สามารถส่งข้อมูลได้ โปรดลองอีกครั้ง');";
        echo "window.location = 'edit_nutrition.php'; ";
        echo "</script>";
    }
    ?>
</body>

</html>