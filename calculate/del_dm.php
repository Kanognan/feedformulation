
<?php
	include('../server.php');
    $dm = $_GET['dem_id'];
    
	$query = "SELECT * FROM cow WHERE dem_id = '$dm'";
	$result = mysqli_query($conn, $query);

	while($row = mysqli_fetch_assoc($result)) {
		$cow_id = $row['cow_id'];
		mysqli_query($conn, "UPDATE cow SET dem_id = Null WHERE cow_id = '$cow_id'");
	}

    // Delete the record from cow_demand
    mysqli_query($conn, "DELETE FROM cow_demand WHERE dem_id ='$dm'");
    
    mysqli_close($conn);
	if ($conn) {
		echo "<script type='text/javascript'>";
		echo "alert('ลบข้อมูลโภชนะโคสำเร็จ');";
		echo "window.location = 'history_demand.php'; ";
		echo "</script>";
	} else {
		echo "<script type='text/javascript'>";
		echo "window.location = 'history_demand.php'; ";
		echo "</script>";
	}
?>


