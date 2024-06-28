<?php
session_start();
if (!isset($_SESSION["acc_id"]) || $_SESSION["acc_id"] == "") {
    $resultNoSession = "เข้าสู่ระบบก่อนใช้งาน";
    $_SESSION['resultNoSession'] = $resultNoSession;
    echo "<script type='text/javascript'>";
    echo "window.location = '../login.php'; ";
    echo "</script>";
    exit();
    // ผู้ใช้งานทั่วไป
}
include "../server.php";
?>
<?php
ini_set('display_errors', 0);
error_reporting(0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <title>ติดต่อเรา</title>
    
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Kanit';
    }

    body {
        width: 100%;
    }

 .c {
        background: #f5f5f5;
        border-radius: 10px;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 20px 10px -5px;
        margin: 9em auto;
        width: 60%;
        padding: 2em;
       
    }

    .y {
        font-size: 1rem;
        padding: 8px 0;
        border: none;
        background: #46739C;
        color: #FFF;
        cursor: pointer;
        border-radius: 20px;
        width: 20%;
        margin: 0 auto;
        display: block;
    }
	.form-control{
        width: 100% !important;
    }
    .head-msg {
        text-align: center;
        background-color: #5e86a9;
        color: #fff;
        border-radius: 5px;
        padding: 0.8em;
        margin-bottom: 2em;

    }
    @media (max-width: 576px) {
        .c {
            width:85%;
        }
    }
    </style>
</head>
<body>
    <?php include('nav-bar.php') ?>
    <form id="myForm" class="c">
      <div class="head-msg">
            <h2>ติดต่อเรา</h2>
            <p>ส่งข้อความไปยังผู้ดูแลระบบ</p>
        </div>
        <div class="col-mb-3">
            <label>อีเมลของคุณ</label>
            <input type="email" id="email" class="form-control" placeholder="กรอกอีเมล" required>
        </div>
        <div class="col-mb-3">
            <label>หัวข้อเรื่อง</label>
            <input type="text" id="header" class="form-control" placeholder="หัวข้อเรื่อง" required>
        </div>
        <div class="col-mb-3">
            <label>รายละเอียด</label>
            <textarea id="detail" class="form-control" type="text" placeholder="รายละเอียด" rows="5"required></textarea>
        </div>
        <button type="button" onclick="sendEmail()" class="y">ส่ง</button>
    </form>
<?php include ("../footer.php"); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script type="text/javascript">
    function sendEmail() {
        var email = $("#email");
        var header = $("#header");
        var detail = $("#detail");

        if (isNotEmpty(email) && isNotEmpty(header) && isNotEmpty(detail)) {
            $.ajax({
                url: 'sendEmail.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    email: email.val(),
                    header: header.val(),
                    detail: detail.val()
                },
                success: function(response) {
                    $('#myForm')[0].reset();
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'ส่งข้อความสำเร็จ',
                            text: response.response,
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด',
                            text: response.response,
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถส่งข้อความได้ โปรดลองอีกครั้ง',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    }
    function isNotEmpty(caller) {
        if (caller.val() == "") {
            caller.css('border', '1px solid red');
            return false;
        } else {
            caller.css('border', '');
            return true;
        }
    }
    </script>
</body>

</html>