<?php
session_start();
include('server.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php include("header.php"); ?>
    <title>Login Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            color: #fff;
            background: #64839b;
            font-family: 'Kanit', sans-serif;
        }

        .form-control {
            font-size: 1em;
        }

        .form-control,
        .form-control:focus,
        .input-group-text {
            border-color: #e1e1e1;
        }

        .form-control {
            border-radius: 5px;
        }

        .register,
        .login {
            border-radius: 20px;

        }

        .signup-form {
            width: 60%;
            margin: 3em auto 0em;
            padding: 30px;
        }

        .signup-form form {
            color: #999;
            border-radius: 3px;
            margin-bottom: 15px;
            background: #fff;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            /* padding: 0px 30px 30px 30px; */
            padding: 30px;
            border-radius: 20px;
        }

        .signup-form h2 {
            color: #333;
            font-weight: bold;
            margin-top: 0;
            text-align: center;
        }

        .signup-form p {
            text-align: center;
        }

        .signup-form hr {
            margin: 0 -30px 20px;
        }

        .signup-form .form-group {
            margin-bottom: 20px;
        }

        .signup-form label {
            font-weight: normal;
            font-size: 15px;
        }

        .signup-form .form-control {
            min-height: 38px;
            box-shadow: none !important;
        }

        .signup-form .input-group-addon {
            max-width: 42px;
            text-align: center;
        }

        .signup-form .btn,
        .signup-form .btn:active {
            font-size: 16px;
            font-weight: bold;
            background: #004c6d !important;
            border: none;
            min-width: 140px;
        }

        .signup-form .btn:hover,
        .signup-form .btn:focus {
            background: #64839b !important;
        }

        .signup-form a {
            color: #fff;
            text-decoration: underline;
        }

        .signup-form a:hover {
            text-decoration: none;
        }

        .signup-form form a {
            color: #64839b;
            text-decoration: none;
        }

        .signup-form form a:hover {
            text-decoration: underline;
        }

        .signup-form .fa {
            font-size: 21px;
        }

        .signup-form .fa-paper-plane {
            font-size: 18px;
        }

        .signup-form .fa-check {
            color: #fff;
            left: 17px;
            top: 18px;
            font-size: 7px;
            position: absolute;
        }

        span.input-group-text {
            height: 38px;
        }

        .img p {
            margin-bottom: 0 !important;
        }

        .but-img button {
            width: 100%;
            border: 0px;
            box-shadow: rgba(0, 0, 0, 0.07) 0px 1px 2px, rgba(0, 0, 0, 0.07) 0px 2px 4px, rgba(0, 0, 0, 0.07) 0px 4px 8px, rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.07) 0px 16px 32px, rgba(0, 0, 0, 0.07) 0px 32px 64px;
            border-radius: 10px;
        }

        .img p {
            padding: 0.8em 0em;
        }

        p.text-muted {
            font-size: small;
        }

        .bt {
            margin-bottom: 20px !important;
        }

        .input-group>:not(:first-child):not(.dropdown-menu):not(.valid-tooltip):not(.valid-feedback):not(.invalid-tooltip):not(.invalid-feedback) {
            margin-left: calc(var(--bs-border-width) * -1);
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .input-group:not(.has-validation)>.dropdown-toggle:nth-last-child(n+3),
        .input-group:not(.has-validation)>.form-floating:not(:last-child)>.form-control,
        .input-group:not(.has-validation)>.form-floating:not(:last-child)>.form-select,
        .input-group:not(.has-validation)>:not(:last-child):not(.dropdown-toggle):not(.dropdown-menu):not(.form-floating) {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        @media (max-width: 994px) {
            .signup-form {
                width: 80%;
            }
        }

        @media (max-width: 768px) {
            .signup-form {
                width: 80%;
            }
        }

        @media (max-width: 576px) {
            .signup-form {
                width: 90%;
            }
        }
    </style>
</head>

<body>
    <div class="position-relative bg container">
        <div class="signup-form">
            <form action="login_db.php" method="post" class="was-validated">
                <h2>เข้าสู่ระบบ</h2>
                <p>กรอกแบบฟอร์มเพื่อเข้าสู่ระบบ</p>
                <hr>
                <div class="row">
                    <div class="form-group col">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope-at-fill"></i>
                                </span>
                            </div>
                            <input type="email" class="form-control" name="email" placeholder="อีเมล" required>
                            <div class="invalid-feedback text-start ps-5">
                                * กรอกอีเมล
                            </div>
                            <div class="valid-feedback text-start ps-5">
                                อีเมล
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="bi bi-person-fill-lock"></i>
                            </span>
                        </div>
                        <input type="password" class="form-control" name="password" placeholder="รหัสผ่าน"
                            required="required">
                        <div class="invalid-feedback text-start ps-5">
                            * กรอกรหัสผ่าน
                        </div>
                        <div class="valid-feedback text-start ps-5">
                            รหัสผ่าน
                        </div>
                    </div>
                </div>
                <div class="text-center bt">
                    <a href="forgot/forgot.php">ลืมรหัสผ่าน?</a>
                </div>
                <div class="form-group d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary btn-lg btn-block register"
                        name="login_user">เข้าสู่ระบบ</button>
                </div>
                <div class="text-center">
                    <a href="select_user_type.php">ยังไม่มีบัญชี? ลงทะเบียน</a>
                </div>
            </form>
        </div>
    </div>
    <?php
    if (isset($_SESSION['resultDeleteUser'])) {
        $resultDeleteUser = $_SESSION['resultDeleteUser'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'ลบบัญชีผู้ใช้สำเร็จ',
                        text: '" . $resultDeleteUser . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 3000 
                    });
                });
            </script>";
        unset($_SESSION['resultDeleteUser']);
    }
    ?>
    <?php
    if (isset($_SESSION['resultErrorLogin'])) {
        $resultErrorLogin = $_SESSION['resultErrorLogin'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'เข้าสู่ระบบไม่สำเร็จ',
                        text: '" . $resultErrorLogin . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
        unset($_SESSION['resultErrorLogin']);
    }
    ?>
    <?php
    if (isset($_SESSION['resultErrorLogin2'])) {
        $resultErrorLogin2 = $_SESSION['resultErrorLogin2'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'เข้าสู่ระบบไม่สำเร็จ',
                        text: '" . $resultErrorLogin2 . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
        unset($_SESSION['resultErrorLogin2']);
    }
    ?>
    <?php
    if (isset($_SESSION['resultNoSession'])) {
        $resultNoSession = $_SESSION['resultNoSession'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'กรุณเข้าสู่ระบบ',
                        text: '" . $resultNoSession . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
        unset($_SESSION['resultNoSession']);
    }
    ?>
    <?php
    if (isset($_SESSION['resultNoSessionExpert'])) {
        $resultNoSessionExpert = $_SESSION['resultNoSessionExpert'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'ไม่สามารถเข้าสู่หน้านี้ได้',
                        text: '" . $resultNoSessionExpert . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
        unset($_SESSION['resultNoSessionExpert']);
    }
    ?>
    <?php
    if (isset($_SESSION['resultNoSessionAdmin'])) {
        $resultNoSessionAdmin = $_SESSION['resultNoSessionAdmin'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'ไม่สามารถเข้าสู่หน้านี้ได้',
                        text: '" . $resultNoSessionAdmin . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
        unset($_SESSION['resultNoSessionAdmin']);
    }
    ?>
</body>

</html>