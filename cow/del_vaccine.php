<!-- vaccine -->
<?php
	include('../server.php');
    $cow_vaccine_id=$_GET['cow_vaccine_id'];
	mysqli_query($conn,"delete from cow_vaccine where cow_vaccine_id ='$cow_vaccine_id'");
	header('location:index_vaccine_cow.php');
?>