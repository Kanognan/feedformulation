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

    if (isset($_POST['reg_expert'])) {
        $ex_fname = $_POST['ex_fname'];
        $ex_lname = $_POST['ex_lname'];
        $email = $_POST['email'];
        $password_1 = $_POST['password_1'];
        $password_2 = $_POST['password_2'];
        $ex_bday = $_POST['ex_bday'];
        $career = $_POST['career'];
        $ex_phone = $_POST['ex_phone'];
        $ex_status = "No";
        $ex_gender = $_POST['gender'];
        $ex_company = $_POST['ex_company'];
        $ex_education = $_POST['ex_education'];
        $ex_graduated = $_POST['ex_graduated'];
        $acc_status = "User";
		$_SESSION['user_status'] = $acc_status;

        // --------------------------------------------
    
        $date = date("Ymd");
        $numrand = (mt_rand());
        $ex_edu_qualification = $_FILES['ex_edu_qualification'];

        if ($ex_edu_qualification != '') {
            $path = "pic/";
            $type = strrchr($_FILES['ex_edu_qualification']["name"], ".");
            $newname1 = $date . $numrand . $type;
            $file_img = $path . $newname1;

            if (move_uploaded_file($_FILES["ex_edu_qualification"]["tmp_name"], $file_img)) {
                $ex_edu_qualification_db = $newname1;
            } else {
                echo "เกิดข้อผิดพลาด";
            }
        }

        $ex_profes_license = $_FILES['ex_profes_license'];
        if ($ex_profes_license != '') {
            $path = "pic/";
            $type = strrchr($_FILES['ex_profes_license']["name"], ".");
            $newname2 = $date . $numrand . $type;
            $file_img = $path . $newname2;

            if (move_uploaded_file($_FILES["ex_profes_license"]["tmp_name"], $file_img)) {
                $ex_profes_license_db = $newname2;
            } else {
                echo "เกิดข้อผิดพลาด";
            }
        }

        $ex_other = $_FILES['ex_other'];
        if ($ex_other != '') {
            $path = "pic/";
            $type = strrchr($_FILES['ex_other']["name"], ".");
            $newname3 = $date . $numrand . $type;
            $file_img = $path . $newname3;

            if (move_uploaded_file($_FILES["ex_other"]["tmp_name"], $file_img)) {
                $ex_other_db = $newname3;
            } else {
                echo "เกิดข้อผิดพลาด";
            }
        }
        // ----------------------------------------------------
    

        if ($email) {
            $user_check_query = "SELECT * FROM account WHERE acc_email = '$email' LIMIT 1";
            $result = $conn->query($user_check_query);

            if ($result->num_rows > 0) {
                $resultErrorEmail = "อีเมลนี้ถูกใช้งานแล้ว";
                $_SESSION['resultErrorEmail'] = $resultErrorEmail;
                echo "<script type='text/javascript'>";
                echo "window.location = 'register_expert.php'; ";
                echo "</script>";
                exit(); 
            }

            if (count($errors) == 0) {
                $password = md5($password_1);

                $sql1 = "INSERT INTO account (acc_name, acc_email, acc_pass, acc_status) VALUES ('$ex_fname', '$email', '$password', '$acc_status')";
                $resql1 = $conn->query($sql1);
                $last_id = $conn->insert_id;

                $sql2 = "INSERT INTO expert (ex_fname, ex_lname, ex_gender, ex_bday, ex_phone, ex_status, ex_education, ex_graduated, ex_company, ex_edu_qualification, ex_profes_license, ex_other, career_id, acc_id) 
                SELECT '$ex_fname', '$ex_lname', '$ex_gender','$ex_bday','$ex_phone','$ex_status','$ex_education','$ex_graduated','$ex_company','$ex_edu_qualification_db','$ex_profes_license_db','$ex_other_db','$career', account.acc_id FROM account WHERE account.acc_id = $last_id";

                $resql2 = $conn->query($sql2);
                $conn->close();

                $_SESSION['username'] = $ex_fname;
                $_SESSION['email'] = $email;
                $_SESSION['acc_id'] = $last_id;
                $_SESSION['success'] = "Your are now logged in";

                $resultRegisterEx = "สมัครสมาชิกสำเร็จ รอตรวจสอบสถานะ";
                $_SESSION['resultRegisterEx'] = $resultRegisterEx;
                echo "<script type='text/javascript'>";
                echo "window.location = 'user/user_index.php'; ";
                echo "</script>";

            } else {
                echo "<script type='text/javascript'>";
                echo "window.location = 'register_expert.php'; ";
                echo "</script>";
            }
        }

    } else {
        echo "<script type='text/javascript'>";
        echo "window.location = 'login.php'; ";
        echo "</script>";
    }

    ?>
</body>

</html>
