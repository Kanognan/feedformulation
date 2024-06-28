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
    include('server.php');
    $errors = array();

    if (isset($_POST['login_user'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($email)) {
            array_push($errors, "Email is required");
        }

        if (empty($password)) {
            array_push($errors, "Password is required");
        }

        if (count($errors) == 0) {
            $password = md5($password);

            $query = "SELECT * FROM account WHERE acc_email = '$email' AND acc_pass = '$password' AND ISNULL(deleteAt)";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) == 1) {
                $user_data = mysqli_fetch_assoc($result);

                $_SESSION['email'] = $email;
                $_SESSION['acc_id'] = $user_data['acc_id'];
                $_SESSION['success'] = "You are now logged in";


                $user_status = $user_data['acc_status'];

                if ($user_status == 'Admin') {
                    $query = "SELECT * FROM admin WHERE acc_id = {$user_data['acc_id']}";
                    $result = mysqli_query($conn, $query);
                    $admin_data = mysqli_fetch_assoc($result);
                    $_SESSION['admin_id'] = $admin_data['admin_id'];
                    $_SESSION['admin_fname'] = $admin_data['admin_fname'];
                    $_SESSION['user_status'] = 'Admin';

                    $resultData = "เข้าสู่ระบบสำเร็จ";
                    $_SESSION['resultData'] = $resultData;
                    echo "<script type='text/javascript'>";
                    echo "window.location = 'admin/admin_index.php'; ";
                    echo "</script>";
                    exit();
                } elseif ($user_status == 'User') {
                    $query = "SELECT * FROM user WHERE acc_id = {$user_data['acc_id']}";
                    $result = mysqli_query($conn, $query);

                    // ตรวจสอบว่ามีผลลัพธ์จากการ query หรือไม่
                    if (mysqli_num_rows($result) > 0) {
                        $user_data = mysqli_fetch_assoc($result);
                        $_SESSION['user_id'] = $user_data['user_id'];
                        $_SESSION['username'] = $user_data['user_fname'];
                        $_SESSION['user_status'] = 'User';

                        $resultData = "เข้าสู่ระบบสำเร็จ";
                        $_SESSION['resultData'] = $resultData;

                        echo "<script type='text/javascript'>";
                        echo "window.location = 'user/user_index.php'; ";
                        echo "</script>";
                        exit();
                    } else {
                        $query = "SELECT * FROM expert WHERE acc_id = {$user_data['acc_id']}";
                        $result = mysqli_query($conn, $query);
                        $expert_data = mysqli_fetch_assoc($result);
                        $_SESSION['user_id'] = $expert_data['expert_id'];
                        $_SESSION['username'] = $expert_data['ex_fname'];
                        $_SESSION['user_status'] = 'User';

                        $resultData = "เข้าสู่ระบบสำเร็จ";
                        $_SESSION['resultData'] = $resultData;
                        echo "<script type='text/javascript'>";
                        echo "window.location = 'user/user_index.php'; ";
                        echo "</script>";
                        exit();
                    }
                } elseif ($user_status == 'Expert') {
                    $query = "SELECT * FROM expert WHERE acc_id = {$user_data['acc_id']}";
                    $result = mysqli_query($conn, $query);
                    $expert_data = mysqli_fetch_assoc($result);
                    $_SESSION['expert_id'] = $expert_data['expert_id'];
                    $_SESSION['expert_fname'] = $expert_data['ex_fname'];
                    $_SESSION['user_status'] = 'Expert';

                    $resultData = "เข้าสู่ระบบสำเร็จ";
                    $_SESSION['resultData'] = $resultData;
                    echo "<script type='text/javascript'>";
                    echo "window.location = 'expert/expert_index.php'; ";
                    echo "</script>";
                    exit();
                }
            } else {
                $resultErrorLogin = "เข้าสู่ระบบไม่สำเร็จ เนื่องจากชื่อผู้ใช้หรือรหัสผ่านผิดพลาด";
                $_SESSION['resultErrorLogin'] = $resultErrorLogin;
                echo "<script type='text/javascript'>";
                echo "window.location = 'login.php'; ";
                echo "</script>";
                exit();
            }
        } else {
            $resultErrorLogin2 = "โปรดกรอกชื่อผู้ใช้และรหัสผ่านให้ถูกต้อง";
            $_SESSION['resultErrorLogin2'] = $resultErrorLogin2;
            echo "<script type='text/javascript'>";
            echo "window.location = 'login.php'; ";
            echo "</script>";
            exit();
        }
    }
    ?>
</body>

</html>