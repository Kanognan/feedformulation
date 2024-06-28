<?php
session_start();
include '../server.php';

date_default_timezone_set('Asia/Bangkok');

if (isset($_POST['comment_detail'], $_SESSION['acc_id'], $_SESSION['postsID'])) {
	$comment_detail = $_POST['comment_detail'];
	$acc_id = $_SESSION['acc_id'];
	$postsID = $_SESSION['postsID'];

	$filenames = isset($_FILES["img"]["name"]) ? $_FILES["img"]["name"] : null;
	$fileTmpNames = isset($_FILES["img"]["tmp_name"]) ? $_FILES["img"]["tmp_name"] : null;

	if (!empty($comment_detail) && !empty($acc_id) && !empty($postsID)) {
		$strSQL = "INSERT INTO comment (comment_detail, acc_id, postsID) VALUES ('$comment_detail', '$acc_id', '$postsID')";
		if (mysqli_query($conn, $strSQL)) {
			$comment_id = mysqli_insert_id($conn);

			if (!empty($filenames) && array_filter($filenames)) {
				foreach ($filenames as $key => $filename) {
					if ($filename) {
						$tmpName = $fileTmpNames[$key];

						$ext = explode(".", $filename);
						$acExt = strtolower(end($ext));
						$newFilename = time() . "_" . $key . "." . $acExt;
						$meetFileLocation = '../pic/' . $newFilename;

						if (move_uploaded_file($tmpName, $meetFileLocation)) {
							$sql = "INSERT INTO comment_img (com_img, comment_id) VALUES ('$meetFileLocation', '$comment_id')";

							$result = mysqli_query($conn, $sql);
							if (!$result) {
								echo "Error: " . $sql . "<br>" . mysqli_error($conn);
							}
						} else {
							echo "Failed to upload image.";
							exit;
						}
					}
				}
			}
			$resultData = "ข้อมูลถูกบันทึกเรียบร้อยแล้ว";
			$_SESSION['resultData'] = $resultData;
			$_SESSION['comment_id'] = $comment_id;
			echo "<script type='text/javascript'>";
			echo "window.location = 'webboard.php?id=$postsID'; ";
			echo "</script>";
			exit();
		} else {
			echo "Failed to add comment.";
			exit();
		}

	} else {
		echo "Invalid data.";
		exit();
	}
} else {
	echo "Missing required data.";
	exit();
}
?>