<?php
    include('server.php');
    $news_id = $_GET['news_id'];
    $news_category = $_POST['news_category'];
    $news_topic = $_POST['news_topic'];
    $news_detail = $_POST['news_detail'];
    $news_img = $_POST['news_img'];

    mysqli_query($conn ,"update news set news_category='$news_category', news_topic='$news_topic', news_detail='$news_detail',news_img='$news_img' where news_id='$news_id'");
	header('location:expert-news.php');
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 