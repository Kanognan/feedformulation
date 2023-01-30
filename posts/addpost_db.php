<?php 
    session_start();
    include('../server.php');

    $errors = array();

	$posts_name = $_POST['posts_name'];
	$posts_content = $_POST['posts_content'];
	$thread_img = $_POST['thread_img'];
	$usertest = 1;
	$category_id = $_POST['category'];
	
    if (isset($_POST['add'])) {

		//*** Insert Question ***//

		$strSQL = "INSERT INTO 
		posts(
			posts_name,
			posts_content,
			thread_img,
			acc_id,
			category_id
		) VALUE (
			'$posts_name',
			'$posts_content',
			'$thread_img',
			'$usertest',
			'$category_id'
		)";

		if (mysqli_query($conn, $strSQL)) {
			echo '<script>alert("เพิ่มโพสสำเร็จ");window.location="home-webboard.php";</script>';
			// header("location:home-webboard.php");
		} else {
			echo "Error: " . $strSQL . "<br>" . mysqli_error($conn);
		}
		
		// $objQuery = mysqli_query($conn, $strSQL) or die (mysqli_error($conn));

		// if($conn->query($strSQL) === TRUE)
        // {
        //     echo "Complaint Registered";
        // }
        // else
        // {
        //     echo "ERROR".$strSQL."<br>". $con->error ;
        // }
		
		// if ($conn) {
		// 	echo '<script>alert("เพิ่มข้อมูลแล้ว");window.location="index.php";</script>';
		// } else {
		// 	echo '<script>alert("พบข้อผิดพลาด");window.location="create.php";</script>';
		// }
		
		// header("location:home-webboard.php");

    }
	mysqli_close($conn);
?>