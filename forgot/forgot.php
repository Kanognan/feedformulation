<?php
session_start();

include "../server.php";
?>
<?php
ini_set('display_errors', 0);
error_reporting(0);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>ลืมรหัสผ่าน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,200;0,400;0,500;1,400&family=Lobster&display=swap"
        rel="stylesheet">
	<link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <style>
    * {
        font-family: 'Kanit';

    }

    body {
        margin-top: 8em;
        background-color: #64839b;
    }

    #card {

        border-radius: 15px;
        background-color: white;
        box-shadow: 4px 4px 7px #DBEDF2;
    }

    form {
        width: 100%;
        padding: 15px;


    }


    .next .btn {
        background-color: #4F80C0;
        color: white;
        width: 6.5em;
        padding: 0.5em;
        border-radius: 20px;
        font-size: 1em;
        margin: 0.5em 0em;
    }

    .next .btn:hover,
    .next .btn:focus:hover {
        background-color: #92CA68;
        color: black;
    }

    .over .btn {
        background-color: #ccc;
        color: black;
        width: 6.5em;
        padding: 0.5em;
        border-radius: 20px;
        font-size: 1em;
        margin: 0.5em 0.8em 0.5em 0.2em;
    }

    .over .btn:hover,
    .over .btn:focus:hover {
        background-color: gray;
        color: white;
    }
    </style>
</head>
<?php 
require "mail.php";

	$mode = "enter_email";
	if(isset($_GET['mode'])){
		$mode = $_GET['mode'];
	}

	//something is posted
	if(count($_POST) > 0){

		switch ($mode) {
			case 'enter_email':
				// code...
				$email = $_POST['email'];
				//validate email
				if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
					$error[] = "กรอกอีเมลของคุณให้ถูกต้อง";
				}elseif(!valid_email($email)){
					$error[] = "ไม่พบอีเมลนี้";
				}else{

					$_SESSION['forgot']['email'] = $email;
					send_email($email);
					header("Location: forgot.php?mode=enter_code");
					die;
				}
				break;

			case 'enter_code':
				// code...
				$code = $_POST['code'];
				$result = is_code_correct($code);

				if($result == "the code is correct"){

					$_SESSION['forgot']['code'] = $code;
					header("Location: forgot.php?mode=enter_password");
					die;
				}else{
					$error[] = $result;
				}
				break;

			case 'enter_password':
				// code...
				$password = $_POST['password'];
				$password2 = $_POST['password2'];

				if($password !== $password2){
					$error[] = "รหัสผ่านไม่ตรงกัน";
				}elseif(!isset($_SESSION['forgot']['email']) || !isset($_SESSION['forgot']['code'])){
					header("Location: forgot.php");
					die;
				}else{
					
					save_password($password);
					if(isset($_SESSION['forgot'])){
						unset($_SESSION['forgot']);
					}

					header("Location: ../login.php");
					die;
				}
				break;
			
			default:
				// code...
				break;
		}
	}

	function send_email($email){
		
		global $conn;

		$expire = time() + (60 * 1);
		$code = rand(10000,99999);
		$email = addslashes($email);
		$_SESSION['forgot']['expire'] = $expire;
		$query = "insert into codes (email,code,expire) value ('$email','$code','$expire')";
		mysqli_query($conn,$query);

		//send email here
		send_mail($email, 'รีเซ็ตรหัสผ่าน', "Code ของคุณ คือ " . $code . "<br>รหัสอ้างอิง " . $expire);

	}
	
	function save_password($password){
		global $conn;
		$email = addslashes($_SESSION['forgot']['email']);
		$hashed_password = md5($password); // ใช้ md5() เพื่อเข้ารหัสรหัสผ่านใหม่
		$query = "UPDATE account SET acc_pass = '$hashed_password' WHERE acc_email = '$email' LIMIT 1";
		mysqli_query($conn, $query);
	}
	
	
	function valid_email($email){
		global $conn;
		$email = addslashes($email);
		$query = "select * from account where acc_email = '$email' limit 1";		
		$result = mysqli_query($conn,$query);
		if($result){
			if(mysqli_num_rows($result) > 0)
			{
				return true;
 			}
		}

		return false;

	}

	function is_code_correct($code){
		global $conn;

		$code = addslashes($code);
		$expire = time();
		$email = addslashes($_SESSION['forgot']['email']);
		$query = "select * from codes where code = '$code' && email = '$email' order by id desc limit 1";
		$result = mysqli_query($conn,$query);
		if($result){
			if(mysqli_num_rows($result) > 0)
			{
				$row = mysqli_fetch_assoc($result);
				if($row['expire'] > $expire){

					return "the code is correct";
				}else{
					return "the code is expired";
				}
			}else{
				return "the code is incorrect";
			}
		}

		return "the code is incorrect";
	}

	
?>
<body>

    <div class="row justify-content-center">
        <div class="col-4" id="card">
            <?php 
			switch ($mode) {
				case 'enter_email':
					// code...
					?>
            <form method="post" action="forgot.php?mode=enter_email">
                <h3 style="text-align:center; margin:0.8em 0.5em">ลืมรหัสผ่าน</h3>
                <p>รีเซ็ตรหัสผ่านด้วยอีเมลที่ใช้งาน</p>
                <span style="font-size: 15px;color:red;">
                <?php 
								foreach ($error as $err) {
									// code...
									echo $err . "<br>";
								}
							?>
            </span>
                </span>
                <input class="form-control" type="email" name="email" placeholder="อีเมล"><br>
                <br style="clear: both;">
                <div class="row">
                    <div class="col-9">
                        <div class="next">
                            <input type="submit" value="ยืนยัน" class="btn"></button>
                        </div>
                    </div>
                    <div class="col-3" style="margin-top:1em;"><a style="text-decoration:none; color:#4F80C0;"
                            href="../login.php">เข้าสู่ระบบ</a></div>
                </div>
            </form>


            <?php				
					break;

				case 'enter_code':
					// code...
					?>
            <form method="post" action="forgot.php?mode=enter_code">
                <h3 style="text-align:center; margin:0.8em 0.5em">ลืมรหัสผ่าน</h3>
                <p>กรอก code ที่ส่งไปยังอีเมลของคุณ</p>
                
                <!-- เพิ่มฟิลด์สำหรับแสดงรหัสอ้างอิง -->
				<p>รหัสอ้างอิง : <?php echo isset($_SESSION['forgot']['expire']) ? $_SESSION['forgot']['expire'] : ''; ?></p>

                <!-- เพิ่มฟิลด์สำหรับแสดงรหัสอ้างอิง -->

                <span style="font-size: 15px;color:red;">
                    <?php 
            foreach ($error as $err) {
                // code...
                echo $err . "<br>";
            }
        ?>
                </span>
                <input class="form-control" type="text" name="code" placeholder="code"><br>
                <div class="row">

                    <div class="col-9">
                        <div class="next">
                            <button type="submit" value="ต่อไป" class="btn">ต่อไป
                        </div>

                    </div>
                    <div class="col-3" style="margin-top:1em;">
                        <a style="color:#4F80C0; text-decoration:none;" href="../login.php">เข้าสู่ระบบ</a>
                    </div>
                </div>
            </form>

        </div>
        <?php
					break;

				case 'enter_password':
					// code...
					?>
        <form method="post" action="forgot.php?mode=enter_password">
            <h3 style="text-align:center; margin:0.8em 0.5em">ลืมรหัสผ่าน</h3>
            <p>กรอกรหัสผ่านใหม่</p>
            <span style="font-size: 15px;color:red;">
                <?php 
								foreach ($error as $err) {
									// code...
									echo $err . "<br>";
								}
							?>
            </span>

            <input class="form-control" type="password" name="password" required pattern="[a-zA-Z0-9]+" minlength="8" placeholder="รหัสผ่าน"><br>
            <p>ยืนยันรหัสผ่านใหม่</p>
            <input class="form-control" type="password" name="password2" required pattern="[a-zA-Z0-9]+" minlength="8" placeholder="ยืนยันรหัสผ่านใหม่"><br>
            <div class="row">
                <div class="col-3">
                    <div class="over">
                        <a href="forgot.php">
                            <button type="button" value="Start Over" class="btn">ย้อนกลับ</button>
                        </a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="next">
                        <button type="submit" value="Next" class="btn">ต่อไป
                    </div>

                </div>
                <div class="col-3" style="margin-top:1em;">
                    <a style="color:#4F80C0;" href="../login.php">เข้าสู่ระบบ</a>
                </div>
            </div>

        </form>
        <?php
					break;
				
				default:
					// code...
					break;
			}

		?>

    </div>
    </div>


</body>

</html>