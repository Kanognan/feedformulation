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
    if (isset($_GET['ms_id']) && !empty($_GET['ms_id'])) {
        $ms_id = $_GET['ms_id'];
        // echo $ms_id;
        mysqli_query($conn, "UPDATE mineral_source_raw SET deleteAt = NOW() WHERE ms_id = '$ms_id'");
        $resultDeleteRaw = "ลบรายการวัตถุดิบสำเร็จ";
        $_SESSION['resultDeleteRaw'] = $resultDeleteRaw;
        echo "<script type='text/javascript'>";
        echo "window.location = 'edit_source_minerals.php'; ";
        echo "</script>";
    } else {
        echo "<script type='text/javascript'>";
        echo "alert('ไม่สามารถส่งข้อมูลได้ โปรดลองอีกครั้ง');";
        echo "window.location = 'edit_source_minerals.php'; ";
        echo "</script>";
    }
    ?>
</body>

</html>