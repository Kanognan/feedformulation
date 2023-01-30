<?php 
    session_start();
    include('server.php');
    
    $errors = array();

    if (isset($_POST['reg_user'])) {
        $user_fname = mysqli_real_escape_string($conn, $_POST['user_fname']);
        $user_lname = mysqli_real_escape_string($conn, $_POST['user_lname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
        $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);
        $bday = mysqli_real_escape_string($conn, $_POST['bday']);
        $career = mysqli_real_escape_string($conn, $_POST['career']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        if (empty($user_fname)) {
            array_push($errors, "โปรดระบุชื่อผู้ใช้งาน");
            $_SESSION['error'] = "โปรดระบุชื่อผู้ใช้งาน";
        }
        if (empty($user_fname)) {
            array_push($errors, "โปรดระบุนามสกุลผู้ใช้งาน");
            $_SESSION['error'] = "โปรดระบุนามสกุลผู้ใช้งาน";
        }
        if (empty($email)) {
            array_push($errors, "โปรดระบุอีเมล");
            $_SESSION['error'] = "โปรดระบุอีเมล";
        }
        if (empty($password_1)) {
            array_push($errors, "โปรดระบุรหัสผ่าน");
            $_SESSION['error'] = "โปรดระบุรหัสผ่าน";
        }
        if ($password_1 != $password_2) {
            array_push($errors, "รหัสผ่านไม่ตรงกัน");
            $_SESSION['error'] = "รหัสผ่านไม่ตรงกัน";
        }
        if (empty($bday)) {
            array_push($errors, "โปรดระบุวัน/เดือน/ปีเกิด");
            $_SESSION['error'] = "โปรดระบุวัน/เดือน/ปีเกิด";
        }
        if (empty($career)) {
            array_push($errors, "โปรดเลือกอาชีพ");
            $_SESSION['error'] = "โปรดเลือกอาชีพ";
        }
        // if (empty($phone)) {
        //     array_push($errors, "โปรดระบุเบอร์โทรศัพท์");
        //     $_SESSION['error'] = "โปรดระบุเบอร์โทรศัพท์";
        // }
        // if (empty($gender)) {
        //     array_push($errors, "โปรดเลือกเพศ");
        //     $_SESSION['error'] = "โปรดเลือกเพศ";
        // }
        // if (empty($status)) {
        //     array_push($errors, "โปรดเลือกสถานะ");
        //     $_SESSION['error'] = "โปรดเลือกสถานะ";
        // }

        $user_check_query = "SELECT * FROM account WHERE acc_email = '$email' LIMIT 1";
        
        // test
        //$test = "SELECT * FROM account INNER JOIN user ON  account.acc_id = user.ac_id";
        //$QUERY= mysqli_query($test) or die ("Error Query [".$test."]");  
        // test



        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);

        if ($result) { // if user exists
            if ($result['user_fname'] === $user_fname) {
                array_push($errors, "มีชื่อผู้ใช้แล้ว");
            }
            if ($result['acc_email'] === $email) {
                array_push($errors, "อีเมลนี้ถูกใช้งานแล้ว");
            }
        }

        if (count($errors) == 0) {
            $password = md5($password_1);

            $sql = "INSERT INTO account (acc_name ,acc_email, acc_pass) VALUES ('$user_fname','$email','$password')";
            //$sql_test = "INSERT INTO user (user_fname, user_lname, user_gender, user_bdate, career_id, user_phone) VALUES ('$user_fname', '$user_lname', '$gender','$bday','$career','$phone')";

            $resql = mysqli_query($conn, $sql) or die ("Error in query: $sql " .mysqli_error($conn));
            //$resqltest = mysqli_query($conn, $sql_test) or die ("Error in query: $sql_test " .mysqli_error($conn));
            echo $sql;
            //echo $sql_test;

            mysqli_close($con);

            $_SESSION['username'] = $user_fname;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
        } else {
            header("location: register.php");
        }
    }

?>