<?php
    use PHPMailer\PHPMailer\PHPMailer;

    if(isset($_POST['email'])) {
        
        $email = addslashes($_POST['email']);
        $header = addslashes($_POST['header']);
        $detail = addslashes($_POST['detail']);

        require_once "PHPMailer/PHPMailer.php";
        require_once "PHPMailer/SMTP.php";
        require_once "PHPMailer/Exception.php";

        $mail = new PHPMailer();

        // SMTP Settings
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "feedformulationa@gmail.com"; // enter your email address
        $mail->Password = "axubnqznbhxemrtm"; // enter your password
        $mail->Port = 587;
        $mail->SMTPSecure = "tls";

        //Email Settings
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->setFrom($email); // ใช้ที่อยู่อีเมล์จากข้อมูลฟอร์มเป็นผู้ส่ง
        $mail->addReplyTo($email); // เพิ่มที่อยู่อีเมล์ในหัวอีเมล์เป็นอีเมล์ผู้ส่ง
        $mail->addAddress('feedformulationa@gmail.com'); // Send to mail
        $mail->Subject = $header;
        $mail->Body = $detail;

        if ($mail->send()) {
            $status = "success";
            $response = "ข้อความของคุณส่งไปยังผู้ดูแลระบบแล้ว";
        } else {
            $status = "failed";
            $response = "มีบางอย่างผิดพลาด โปรดกรอกใหม่อีกครั้ง "; 
        }
        
        // ส่งผลลัพธ์กลับไปยัง JavaScript
        echo json_encode(array("status" => $status, "response" => $response));
    }
        
?>
