<?php
session_start();
include('server.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php 
        $test = "SELECT * FROM account INNER JOIN user ON account.acc_id = user.acc_id";
        $query= mysqli_query($conn, $test) or die ("Error Query ['.$test.']");  
    ?>

    <div class="header">
        <h2>Register</h2>
    </div>

    <form action="register_db.php" method="post">
        <?php include('errors.php'); ?>
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
            <label for="user_fname">ชื่อ</label>
            <input type="text" name="user_fname">
        </div>
        <div class="input-group">
            <label for="user_lname">นามสกุล</label>
            <input type="text" name="user_lname">
        </div>
        <div class="input-group">
            <label for="email">อีเมล</label>
            <input type="email" name="email">
        </div>
        <div class="input-group">
            <label for="password_1">รหัสผ่าน</label>
            <input type="password" name="password_1">
        </div>
        <div class="input-group">
            <label for="password_2">ยืนยันรหัสผ่าน</label>
            <input type="password" name="password_2">
        </div>
        <div class="input-group">
            <label for="bday">วัน/เดือน/ปีเกิด</label>
            <input type="date" name="bday">
        </div>
        <div class="input-group">
            <label for="career_id">อาชีพ</label>
            <select name="career" id="career">
                <?php
                $sql = "SELECT * FROM career";
                $result = $conn->query($sql);

                while ($career = $result->fetch_assoc()):
                    ;
                    ?>
                    <option value="<?php echo $career["career_id"]; ?>">
                        <?php echo $career["career_name"]; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <!-- <div class="input-group">
            <label for="phone">เบอร์โทร</label>
            <input type="tel" name="phone">
        </div>
        <div class="input-group">
            <input type="radio" name="gender" value="male"> เพศชาย
            <input type="radio" name="gender" value="female"> เพศหญิง
        </div>
        <div class="input-group">
            <input type="radio" name="status" value="expert"> ผู้เชี่ยวชาญ
            <input type="radio" name="status" value="user"> ผู้ใช้งาน
        </div> -->
        <div class="input-group">
            <button type="submit" name="reg_user" class="btn">Register</button>
        </div>
        <p>Already a member? <a href="login.php">Sign in</a></p>
    </form>

</body>

</html>