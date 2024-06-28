<?php 
session_start();
include('../server.php');
if (isset($_POST['up'])){
$upg = (isset($_POST['checkbox-id']))?$_POST['checkbox-id']:NULL;
$group_id =  $_SESSION['group_id'];
if(count($upg)>0){  // ตรวจสอบ checkbox ว่ามีการเลือกมาอย่างน้อย 1 รายการหรือไม่
    foreach($upg as $key=>$value){
        // แสดงชุดข้อมูล ที่สอดคล้องกับ checkbox
		$up = " UPDATE cow set group_id ='" . $group_id . "' WHERE cow_id = '$upg[$key]'";
		$gcow = mysqli_query($conn, $up) or die (mysqli_error($conn));
        // echo $id[$key]."<br>";
    }   
}

}
mysqli_close($conn);
if ($conn) {
    $editData = "เพิ่มสมาชิกเรียบร้อยแล้ว";
    $_SESSION['editData'] = $editData;
    header("Location: group.php");
    exit();
} else {
    echo "<script type='text/javascript'>";
    echo "alert('แก้ไขข้อมูลไม่สำเร็จ');";
    echo "window.location = group.php ";
    echo "</script>";
}

?>