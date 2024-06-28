<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php include("header.php"); ?>
    <title>Document</title>
</head>

<body>
    <?php
    include("server.php");
    date_default_timezone_set('asia/bangkok');
    $create_At = date('Y-m-d H:i:s', time());

    $errors = array();

    if (isset($_POST['reg_user'])) {
        $user_fname = $_POST['user_fname'];
        $user_lname = $_POST['user_lname'];
        $email = $_POST['email'];
        $password_1 = $_POST['password_1'];
        $password_2 = $_POST['password_2'];
        $bday = $_POST['bday'];
        $career = $_POST['career'];
        $phone = $_POST['phone'];
        $gender = $_POST['gender'];
        $acc_status = "User";
    	$_SESSION['user_status'] = $acc_status;

        // Check if email already exists
        $user_check_query = "SELECT * FROM account WHERE acc_email = '$email' LIMIT 1";
        $query = $conn->query($user_check_query);
        $result = mysqli_fetch_assoc($query);

        if ($result) {
            $resultErrorEmail = "อีเมลนี้ถูกใช้งานแล้ว";
            $_SESSION['resultErrorEmail'] = $resultErrorEmail;
            echo "<script type='text/javascript'>";
            echo "window.location = 'register_user.php'; ";
            echo "</script>";
            exit(); 
        }

        if (count($errors) == 0) {
            $password = md5($password_1);

            $sql1 = "INSERT INTO account (acc_name, acc_email, acc_pass ,acc_status) VALUES ('$user_fname', '$email', '$password', '$acc_status')";
            $resql1 = $conn->query($sql1);
            $last_id = $conn->insert_id;

            $sql2 = "INSERT INTO user (user_fname, user_lname, user_gender, user_bdate, career_id, user_phone, acc_id) 
                VALUES ('$user_fname', '$user_lname', '$gender','$bday','$career','$phone', '$last_id')";

            $resql2 = $conn->query($sql2);

            $conn->close();

            $_SESSION['username'] = $user_fname;
            $_SESSION['email'] = $email;
            $_SESSION['acc_id'] = $last_id;
            $_SESSION['success'] = "Your are now logged in";

            $resultRegister = "สมัครสมาชิกสำเร็จ";
            $_SESSION['resultRegister'] = $resultRegister;
            echo "<script type='text/javascript'>";
            echo "window.location = 'user/user_index.php'; ";
            echo "</script>";

        } else {
            echo "<script type='text/javascript'>";
            echo "window.location = 'register_user.php'; ";
            echo "</script>";
        }
    } else {
        echo "<script type='text/javascript'>";
        echo "window.location = 'login.php'; ";
        echo "</script>";
    }
    ?>

</body>

</html>