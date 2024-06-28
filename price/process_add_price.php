<?php
//session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php //include "../header.php" ;     ?>
    <title>Document</title>
</head>

<body>
    <?php
    include('../server.php');
    $raw_id = $_POST['raw_id'];
    // $ms_id = $_POST['ms_id'];
    $price = $_POST['price'];

    // File Upload
    $filename = $_FILES["raw_img"]["name"];
    $fileTmpname = $_FILES["raw_img"]["tmp_name"];
    $fileExt = pathinfo($filename, PATHINFO_EXTENSION);
    $newFilename = time() . "." . $fileExt;
    $fileDes = '../pic/' . $newFilename;

    if (!move_uploaded_file($fileTmpname, $fileDes)) {
        die("Error: Failed to move uploaded file.");
    }

    if (isset($_POST['addprice'])) {
        $sqlRawPrice = "INSERT INTO price (price, raw_img, raw_id) VALUE ('$price', '$newFilename', '$raw_id')";
        $resqlRawPrice = $conn->query($sqlRawPrice);

        $sqlMsPrice = "INSERT INTO price_ms (price, raw_img, ms_id) VALUE ('$price', '$newFilename', '$raw_id')";
        $resqlMsPrice = $conn->query($sqlMsPrice);
        if ($resqlRawPrice || $resqlMsPrice) {
            $resultAddRaw = "เพิ่มราคารายการวัตถุดิบสำเร็จ";
            $_SESSION['resultAddRaw'] = $resultAddRaw;
            echo "<script type='text/javascript'>";
            echo "window.location = 'price.php'; ";
            echo "</script>";
        } else {
            echo "เพิ่มข้อมูลไม่สำเร็จ: " . mysqli_error($conn);
        }
    }
    ?>

</body>

</html>