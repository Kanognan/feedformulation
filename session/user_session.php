<?php //session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php //include("../header.php");  ?>
    <title>Document</title>
</head>

<body>
    <?php
    if (!isset($_SESSION["acc_id"]) || $_SESSION["acc_id"] == "") {
        echo "<script>
                Swal.fire({
                    icon: 'warning',
                    title: 'การเข้าสู่ระบบผิดพลาด',
                    text: 'จำเป็นต้องเข้าสู่ระบบเพื่อใช้งาน',
                    confirmButtonText: 'เข้าสู่ระบบ',
                    showCancelButton: false,
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '../login.php';
                    }
                });
              </script>";
        exit;
    }
    ?>
</body>

</html>