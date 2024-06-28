<?php //session_start();  ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php //include("../header.php"); ?>
    <title>Document</title>
</head>

<body>
    <?php
    if (!isset($_SESSION['user_status']) || ($_SESSION['user_status'] != 'Admin' && $_SESSION['user_status'] != 'Expert')) {
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้',
                text: 'สำหรับผู้ดูแลระบบและผู้เชี่ยวชาญเท่านั้น',
                confirmButtonText: 'ตกลง',
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