<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php 
session_start();
include '../server.php';
$acc_id = $_SESSION['acc_id'];
?>
    <?php

// if (isset($_POST['addstatement'])) {
//     var_dump($_POST);
// }

if(isset($_GET['statement_id'])) {
    $statement_id = $_GET['statement_id'];
    $statement_detail = $_POST['statement_detail'];
    $statement_amount = $_POST['statement_amount'];
    $statement_status = $_POST['statement_status'];
    $statement_date = $_POST['statement_date'];
    $sql = "UPDATE statement SET
    statement_detail = '$statement_detail', 
    statement_amount = '$statement_amount', 
    statement_status = '$statement_status', 
    statement_date = '$statement_date'
    WHERE statement_id = $statement_id and acc_id = $acc_id";
    $result = mysqli_query($conn, $sql) or die ("Error in query: $sql " . mysqli_error($conn)); 
    }

    mysqli_close($conn);
	if($result){
        echo "<script type='text/javascript'>";
		echo "alert('แก้ไขข้อมูลสำเร็จ');";
		echo "window.location = 'index_profit.php'; ";
		echo "</script>";
    }
			else{
			echo "<script type='text/javascript'>";
			echo "alert('Error!!');";
			echo "window.location = 'index_profit.php'; ";
			echo "</script>";
 			}
		
 
?>
</body>

</html>