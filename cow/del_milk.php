<!--milk -->
<?php
	include('../server.php');
    $cow_milk_id=$_GET['cow_milk_id'];
	mysqli_query($conn,"delete from cow_milk where cow_milk_id ='$cow_milk_id'");
	header('location:index_milk_cow.php');
?>
<!--  -->