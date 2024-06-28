<?php
	include('../server.php');
    $cow_dianosis_id=$_GET['cow_dianosis_id'];
	mysqli_query($conn,"delete from cow_dianosis where cow_dianosis_id ='$cow_dianosis_id'");
	header('location:index_dianosis_cow.php');
?>