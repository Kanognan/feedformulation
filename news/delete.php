<?php
	include('../server.php');
    $news_id=$_GET['news_id'];
	mysqli_query($conn ,"delete from news where news_id='$news_id'");
	header('location:expert-news.php');
?>
