<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>

    <div class="content">
        <?php include ('server.php'); ?>
        <?php

		$sql = "SELECT * FROM news order by news_id DESC";
		$result = $conn->query($sql);
		if ($result->num_rows > 0){
			while($row = $result->fetch_assoc()) {
				?>
        <h3><?php echo "Category ". $row["news_category"]; ?></h3>
        <div class="container text-center">
            <div class="row">
                <div class="col-9"><p><?php echo $row["news_topic"];?></p></div>
                <div class="col-3"><p class="datetime"><?php echo $row["createAt"]; ?></p></div>
            </div>
        </div>
        
        
        <img style="width: 560px; height: 400px; text-align:center;" src="pic/<?php echo $row['news_img']?>">
        <p class="img-con"><?php echo $row['news_detail']; ?></p>
        <div class="border-con"></div>
        <?php 	}
		
		 }else{

		 }
		?>

    </div>
</body>

</html>