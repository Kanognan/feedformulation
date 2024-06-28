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


if(isset($_POST['addstatement'])){
    // การรับข้อมูลจากฟอร์ม
    $statement_detail = $_POST['statement_detail'];
    $statement_amount = $_POST['statement_amount'];
    $statement_status = $_POST['statement_status'];
    $statement_date = $_POST['statement_date'];
	// echo var_dump($statement_amount);
    
    // ตรวจสอบว่า $statement_detail และ $statement_amount เป็น array หรือไม่
    if(is_array($statement_detail) && is_array($statement_amount)) {
        $total_statement = count($statement_detail); // นับจำนวนรายการที่ถูกเลือก

        if ($total_statement > 0) { // ตรวจสอบว่ามีการเลือกมาอย่างน้อย 1 รายการหรือไม่
            foreach ($statement_detail as $key => $value) {
                // แสดงชุดข้อมูล ที่สอดคล้องกับ checkbox
                $sql = "INSERT INTO statement
                    (statement_detail, statement_amount, statement_status, statement_date,acc_id)
                    VALUES
                    ('$statement_detail[$key]', '$statement_amount[$key]', '$statement_status', '$statement_date','$acc_id')";
                $result = mysqli_query($conn, $sql) or die ("Error in query: $sql " . mysqli_error($conn)); 
            }
        }
    } else {
        // Handle the case where $statement_detail or $statement_amount is not an array
    }

    mysqli_close($conn);
	if($result){
        $resultData = "ข้อมูลถูกบันทึกเรียบร้อยแล้ว";
        $_SESSION['resultData'] = $resultData;
        header("Location: index_profit.php");
        exit();
			}
			else{
			echo "<script type='text/javascript'>";
			echo "alert('Error!!');";
			echo "window.location = 'index_profit.php'; ";
			echo "</script>";
 			}
		}
 
?>
</body>

</html>