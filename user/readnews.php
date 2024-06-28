<?php
session_start();
if (!isset($_SESSION["acc_id"]) || $_SESSION["acc_id"] == "") {
    $resultNoSession = "เข้าสู่ระบบก่อนใช้งาน";
    $_SESSION['resultNoSession'] = $resultNoSession;
    echo "<script type='text/javascript'>";
    echo "window.location = '../login.php'; ";
    echo "</script>";
    exit();
    // ผู้ใช้งานทั่วไป
}
include "../server.php";
?>
<?php
ini_set('display_errors', 0);
error_reporting(0);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ข่าวสาร</title>
	<link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Kanit';
    }

    body {
        padding-top: 6.5em;
    }

    .imghead {
        height: 20rem;
        position: relative;
        overflow: hidden;
    }

    .imghead img {
        height: 20rem;
        width: 100%;
        object-fit: cover;
        filter: blur(2px);
    }

    .imghead h1 {
        position: absolute;
        color: white;
        top: 40%;
        text-align: center;
        font-weight: bold;
        width: 100%;
        text-shadow: -1px 1px 6px rgba(0, 0, 0, 0.79);
    }

    .carousel {
            width: 70%;
            margin: 0 auto;
        }


    .carousel-inner .carousel-item img {
        object-fit: cover;
        width: 100%;
        height: 20rem;
        margin: 0 auto;
        border-radius: 5px;
    }

    .topic h2 {
        margin: 2em 0em;
        text-align: center;
        font-weight: bold;
    }

    .detail p {
        margin: 2em 10em;
        font-size: 1.1em;
        text-indent: 1.5em;
    }

    </style>
</head>

<body>
    <?php include("nav-bar.php"); ?>
    <?php
    $news_id = isset($_GET['news_id']) ? $_GET['news_id'] : null;

if (!empty($news_id)) {
    // ตรวจสอบค่า $news_id เพื่อป้องกัน SQL Injection
    $safe_news_id = mysqli_real_escape_string($conn, $news_id);

    // ดึงข้อมูลข่าวและรูปภาพที่เกี่ยวข้อง
    $query = mysqli_query($conn, "SELECT * FROM news WHERE news_id = $safe_news_id");
    $result = mysqli_fetch_assoc($query);

    if ($result) {
        // เข้าถึงข้อมูลข่าว
        $news_topic = $result['news_topic'];
        $news_detail = $result['news_detail'];
        ?>
    <div class="imghead">
        <img src="../Images/news-head.jpg" alt="room" class="img">
        <h1>
            ข่าวสาร
        </h1>
    </div>
    <div class="container">
        <div class="content">
            <div class="topic">
                <h2>
                    <?php echo $news_topic; ?>
                </h2>
            </div>
            <div class="content-img">
                <div id="carouselExampleControls<?php echo $news_id; ?>" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                                    // Query เพื่อดึงรูปภาพของข่าวนั้นๆ
                                    $sql_images = "SELECT * FROM news_img WHERE news_id = $news_id";
                                    $result_images = mysqli_query($conn, $sql_images);
                                    $is_first = true;
                                    // วนลูปแสดงรูปภาพของข่าวนั้นๆ
                                    while ($image_row = mysqli_fetch_assoc($result_images)) {
                                    ?>
                        <div class="carousel-item <?php echo $is_first ? 'active' : ''; ?>">
                            <img src="../pic/<?php echo $image_row['news_img']; ?>" class="d-block w-100"
                                alt="News Image">
                        </div>
                        <?php
                                        $is_first = false;
                                    }
                                    ?>
                    </div>
                    <button class="carousel-control-prev" type="button"
                        data-bs-target="#carouselExampleControls<?php echo $news_id; ?>" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button"
                        data-bs-target="#carouselExampleControls<?php echo $news_id; ?>" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <div class="detail">
                <p>
                    <?php echo $news_detail; ?>
                </p>
            </div>
        </div>
    </div>
    <?php
    } else {
        echo "<p>ไม่พบข้อมูลข่าว</p>";
    }
} else {
    echo "<p>ไม่พบรหัสข่าว</p>";
}
?>
<div class="text-center mt-4 mb-5 btn-readall">
	<a href="../news/user-news.php" class="btn btn-outline-secondary">อ่านข่าวทั้งหมด</a>
</div>
<?php include("../footer.php"); ?>
</body>

</html>