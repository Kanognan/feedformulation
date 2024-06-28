
<!-- health -->
<?php
	include('../server.php');
    $cow_health_id=$_GET['cow_health_id'];
	mysqli_query($conn,"delete from cow_health where cow_health_id ='$cow_health_id'");
	header('location:index_health_cow.php');
?>
<!-- dianosis -->

<!--breed -->

