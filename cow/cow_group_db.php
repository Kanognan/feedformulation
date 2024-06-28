
<?php
   
   include('../server.php');
   $group_id=$_GET['group_id'];
   mysqli_query($conn,"delete from group_cow where group_id ='$group_id'");
   header('location:cow_group.php');
?>


<?php
    $group_id = $_GET['group_id'];
    $group_name = $_POST['group_name'];
    $up = " UPDATE group_cow set group_name ='". $group_name. "' where group_id= $group_id ";
    $query = mysqli_query($conn, $up) or die (mysqli_error($conn));
        echo "<script type='text/javascript'>";
        echo "alert('แก้ไขข้อมูลสำเร็จ');";
        echo "window.location = 'cow_group.php'; ";
        echo "
        </script>";
?>