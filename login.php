<?php
session_start();
include('server.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <link rel="stylesheet" href="style.css">
    <!-- <style>
        * {
            margin: 0;
            padding: 0;
            background-image: url('https://pyxis.nymag.com/v1/imgs/c7b/27a/b76324b9e7790ff25ba67be21f92ccbbff-cow--.jpg');
            background-repeat: no-repeat;
            opacity: 0.5;
            background-position: center center;
            background-attachment: fixed;
            background-size: cover;
        }

        form {
            width: 30%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #b0c4de;
            background: white;
            border-radius: 0px 0px 10px 10px;
        }

        .input-group {
            margin: 10px 0px 10px 0px;
        }

        .input-group label {
            display: block;
            text-align: left;
            margin: 3px;
        }

        .input-group input {
            height: 30px;
            width: 93%;
            padding: 5px 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid gray;
        }

        .btn {
            padding: 10px;
            font-size: 15px;
            color: white;
            background: #5f9ea0;
            border: none;
            border-radius: 5px;
        }

        .btn {
            padding: 10px;
            font-size: 15px;
            color: white;
            background: #5f9ea0;
            border: none;
            border-radius: 5px;
        }

        .header {
            width: 30%;
            margin: 50px auto 0px;
            color: white;
            background: #5f9ea0;
            text-align: center;
            border: 1px solid #d5e6fc;
            border-bottom: none;
            border-radius: 10px 10px 0px 0px;
            padding: 20px;
        }
    </style> -->
</head>

<body>

    <div class="header">
        <h2>เข้าสู่ระบบ</h2>
    </div>

    <form action="login_db.php" method="post">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error">
                <h3>
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </h3>
            </div>
        <?php endif ?>
        <div class="input-group">
            <label for="email">อีเมล</label>
            <input type="email" name="email">
        </div>
        <div class="input-group">
            <label for="password">รหัสผ่าน</label>
            <input type="password" name="password">
        </div>
        <div class="input-group">
            <button type="submit" name="login_user" class="btn">เข้าสู่ระบบ</button>
        </div>
        <p><a href="register.php">ลงทะเบียน</a></p>
    </form>

</body>

</html>