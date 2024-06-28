<?php
//session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php //include "../header.php" ;    ?>
    <title>Document</title>
</head>

<body>
    <?php
    include('../server.php');

    if (isset($_POST['change'])) {
        if (isset($_POST['price_id']) && isset($_POST['price'])) {
            $price_id = $_POST['price_id'];
            $new_price = $_POST['price'];
            if (!empty($price_id) && !empty($new_price)) {
                $update_sql = "UPDATE price SET price = '$new_price' WHERE price_id = '$price_id'";
                if ($conn->query($update_sql) === TRUE) {
                    $resultData = "อัพเดตราคาวัตถุดิบสำเร็จ";
                    $_SESSION['resultData'] = $resultData;
                    echo "<script type='text/javascript'>";
                    echo "window.location = 'price.php'; ";
                    echo "</script>";
                    exit();
                } else {
                    echo "<script>alert('เกิดข้อผิดพลาดในการอัพเดตราคา'); window.location.href='price.php';</script>";
                }
            }
        } else if (isset($_POST['price_ms_id']) && isset($_POST['price_ms'])) {
            $price_ms_id = $_POST['price_ms_id'];
            $price_ms = $_POST['price_ms'];
            if (!empty($price_ms_id) && !empty($price_ms)) {
                $update_sqlMs = "UPDATE price_ms SET price = '$price_ms' WHERE price_ms_id = '$price_ms_id'";
                if ($conn->query($update_sqlMs) === TRUE) {
                    $resultData = "อัพเดตราคาวัตถุดิบสำเร็จ";
                    $_SESSION['resultData'] = $resultData;
                    echo "<script type='text/javascript'>";
                    echo "window.location = 'price.php'; ";
                    echo "</script>";
                } else {
                    echo "<script>alert('เกิดข้อผิดพลาดในการอัพเดตราคา'); window.location.href='price.php';</script>";
                }
            }
        }
    }
    ?>

</body>

</html>