<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="icon" type="image" href="../Images/logofeeds.png">
    <title>Document</title>
</head>

<body>
    <?php 
session_start();
include('../server.php');

if (isset($_POST['edit_news'])) {
    $news_id = $_GET['news_id'];
    $category = $_POST['category'];
    $news_topic = $_POST['news_topic'];
    $news_detail = $_POST['news_detail'];

    // ทำการอัปเดตข้อมูลในฐานข้อมูล
    $sql_update = "UPDATE news SET 
                   category_news_id = '$category', 
                   news_topic = '$news_topic', 
                   news_detail = '$news_detail' 
                   WHERE news_id = '$news_id'";
    
    if (mysqli_query($conn, $sql_update))     
	if ($conn) {
        $editData = "แก้ไขข้อมูลเรียบร้อยแล้ว";
        $_SESSION['editData'] = $editData;
        header("Location: expert-news.php");
        exit();
	} else {
		echo "<script type='text/javascript'>";
		echo "window.location = 'expert-news.php'; ";
		echo "</script>";
	}
}

?>
</body>

</html>