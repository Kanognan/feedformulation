<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php
	include('../server.php');
    $statement_id = $_GET['statement_id'];
    mysqli_query($conn, "DELETE FROM statement WHERE statement_id ='$statement_id'");
    
    mysqli_close($conn);
	if ($conn) {
		echo "<script type='text/javascript'>";
		echo "alert('ลบข้อมูลรายรับรายจ่ายสำเร็จ');";
		echo "window.location = 'index_profit.php'; ";
		echo "</script>";
	} else {
		echo "<script type='text/javascript'>";
		echo "window.location = 'index_profit.php'; ";
		echo "</script>";
	}
?>

</body>
</html>