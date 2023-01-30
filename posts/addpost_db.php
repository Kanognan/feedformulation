<?php 
    session_start();
    include('../server.php');

    $errors = array();

	$posts_name = $_POST['posts_name'];
	$posts_content = $_POST['posts_content'];
	$thread_img = $_POST['thread_img'];
	$usertest = 1;
	$category_id = $_POST['category'];
	
    if (isset($_POST['addpost'])) {

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
		} else {
			echo "Error: " . $strSQL . "<br>" . mysqli_error($conn);
		}
    }
	mysqli_close($conn);
?>