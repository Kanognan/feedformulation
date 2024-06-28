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
    $acc_id = $_SESSION['acc_id'];

    $result = mysqli_query($conn, "UPDATE account SET deleteAt = NOW() WHERE acc_id = '$acc_id'");
    if ($result) {
        $resultDeleteUser = "ลบบัญชีผู้ใช้สำเร็จ";
        $_SESSION['resultDeleteUser'] = $resultDeleteUser;
        echo "<script type='text/javascript'>";
        echo "window.location = '../login.php'; ";
        echo "</script>";
    } else {
        $errorMessage = "เกิดข้อผิดพลาดในการลบบัญชีผู้ใช้"; 
        echo "<script type='text/javascript'>";
        echo "alert('$errorMessage');";
        echo "window.location = 'profile.php'; ";
        echo "</script>";
    }
    ?>

</body>

</html>