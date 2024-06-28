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
<?php 
$acc_id = $_SESSION['acc_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>หน้าหลัก</title>
	<link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <style>
     * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Kanit', sans-serif;
    }

    body {
        padding-top: 6em;
    }

    .heading {
        font-size: 20px;
        font-weight: 600;
        color: #3D5AFE;
    }

    .card-content {
        width: 250rem;
    }

    .menu-card {
        transition: all 0.2s ease;
        cursor: pointer;
        margin-top: 3rem;
        margin-bottom: 3rem;
    }

    .menu-card:hover {
        box-shadow: 5px 6px 6px 2px gray;
        background-color: #d5e6fc;
        transform: scale(1.1);
        border-radius: 2rem;
    }

    .img img {
        height: 25rem;
        width: 100%;
        object-fit: cover;

    }

    .card-news {
        width: 21rem !important;
        margin: 0.5rem;
        border-radius: 20px !important;
    }

    .card-new {
        padding: 0 !important;
        margin: 1em;
        box-shadow: rgba(0, 0, 0, 0.07) 0px 1px 2px, rgba(0, 0, 0, 0.07) 0px 2px 4px, rgba(0, 0, 0, 0.07) 0px 4px 8px, rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.07) 0px 16px 32px, rgba(0, 0, 0, 0.07) 0px 32px 64px;
        transition: transform 250ms;
    }

    .card-new:hover,
    .card-new:focus {
        transform: translateY(-10px);
        cursor: pointer;

    }

    .card-new img {
        height: 15rem !important;
        width: 100% !important;
        object-fit: cover;
        border-radius: 20px;
    }

    img.card-img-top {
        border-top-left-radius: 20px !important;
        border-top-right-radius: 20px !important;
    }

    .h1 h1 {
        margin: 0em 0em 1em;
        text-align: center;
    }

    .card-title {
        font-weight: bold;
        margin: 0.5em 0em;
    }

    .detail {
        height: 11em;
    }

    .detail p {
        text-overflow: ellipsis;
        overflow: hidden;
        display: -webkit-box !important;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        white-space: normal;
    }

    .detail h5 {
        text-overflow: ellipsis;
        overflow: hidden;
        display: -webkit-box !important;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        white-space: normal;
    }

    .card-all {
        background-color: #f8f8f8;
        padding: 3em 0em;
    }

    .btn-readall a {
        width: 12em !important;
        border-radius: 20px;
    }
    </style>
</head>

<body>

    <?php include("nav-bar.php") ?>
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner img">
            <div class="carousel-item active caro">
                <img src="https://www.fossanalytics.com/-/media/images/segments/raw-milk-testing/articletop/cows-1480x550.jpg"
                    class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item caro">
                <img src="https://farmhouseguide.com/wp-content/uploads/2022/05/Farm-black-and-white-cows-graze-in-meadow-ee220511.png"
                    class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item caro">
                <img src="https://dug.com/wp-content/uploads/2021/08/Webp.net-resizeimage-5.jpg" class="d-block w-100"
                    alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <div class="container mt-4 d-flex justify-content-center">
        <div class="row g-0 card-content ">
            <div class="col-md-4 border-right content" onclick="window.location='../raw/select_raw.php'">
                <div class="cards menu-card">
                    <div class="first p-4 text-center">
                        <img src="../Images/calculate1.png" style="width: 8rem; margin-bottom: 1rem" />
                        <h5>คำนวณ</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 border-right content" onclick="window.location='../price/index_price.php'">
                <div class="cards menu-card">
                    <div class="second p-4 text-center">
                        <img src="../Images/price.png" style="width: 8rem; margin-bottom: 1rem" />
                        <h5>ราคาวัตถุดิบ</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 content ">
                <div class="cards menu-card">
                    <div class="third p-4 text-center" onclick="window.location='../knowledge/knowledge.php'">
                        <img src="../Images/knowlenge.png" style="width: 8rem; margin-bottom: 1rem" />
                        <h5>ความรู้ / เทคนิค</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <div class="card-all">
    <div class="container">
        <div class="h1">
            <h1>ข่าวสารที่น่าสนใจ</h1>
        </div>
        <div class="card-deck row d-flex justify-content-center news-box">
            <?php
            $sql = "SELECT news.*, news_img.news_img
                    FROM news
                    LEFT JOIN news_img ON news.news_id = news_img.news_id
                    GROUP BY news.news_id
                    ORDER BY news.createAt DESC";
            $result = mysqli_query($conn, $sql);
            $counter = 0; // กำหนดตัวแปรนับจำนวนข่าวที่แสดง
            if ($result && $result->num_rows > 0) {
                // วนลูปแสดงข้อมูลข่าวทั้งหมด
                while ($row = $result->fetch_assoc()) {
                    if ($counter < 6) { // เพิ่มเงื่อนไขนับจำนวนข่าว
                        $creatAt = $row['createAt'];
                        $newsDate = new DateTime($creatAt);
                        $currentDate = new DateTime(); // Current date and time
                        // Calculate the difference in days
                        $interval = $currentDate->diff($newsDate);
                        $daysDifference = $interval->days;
                        $news_id = $row['news_id'];
            ?>
           <div class="card-news card-new card col-md-4 mt-3 col-sm-10 p-0">
                <div id="carouselExampleControls<?php echo $news_id; ?>" class="carousel slide"
                    data-bs-ride="carousel">
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
                    <button class="carousel-control-prev" type="hidden"
                        data-bs-target="#carouselExampleControls<?php echo $news_id; ?>" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="hidden"
                        data-bs-target="#carouselExampleControls<?php echo $news_id; ?>" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <div class="card-body detail" onclick="window.location='../news/readnews.php?news_id=<?php echo $news_id; ?>'">
                    <h5 class="card-title news_topic">
                        <?php echo $row['news_topic']; ?>
                    </h5>
                    <p class="card-text news-detail text-muted">
                        <?php echo $row['news_detail']; ?>
                    </p>
                </div>
                <div class="card-footer d-flex mb-2" style="margin-bottom: 0 !important;">
                    <small class="text-muted p-2">โพสเมื่อ
                        <?php
                        if ($daysDifference == 0) {
                            echo "ล่าสุดวันนี้";
                        } else {
                            echo $daysDifference . " วันที่ผ่านมา";
                        }
                        ?>
                    </small>
                    <small class="text-muted ms-auto p-2">อ่านเพิ่มเติม</small>
                </div>
            </div>
            <?php
                        $counter++; // เพิ่มจำนวนข่าวที่แสดงไปทีละ 1
                    }
                }
            }
            ?>
            <?php if ($counter >= 6): ?>
            <!-- ส่วนปุ่ม "อ่านข่าวทั้งหมด" -->
            <div class="text-center mt-4 mb-2 btn-readall">
                <a href="../news/user-news.php" class="btn btn-outline-secondary">อ่านข่าวทั้งหมด</a>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>
 <?php include("../footer.php"); ?>
    <?php
    if (isset($_SESSION['resultData'])) {
        $resultData = $_SESSION['resultData'];
        echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'เข้าสู่ระบบสำเร็จ',
                            confirmButtonText: 'OK',
                            showConfirmButton: false,
                            timer: 1500 
                        });
                    });
                </script>";
        unset($_SESSION['resultData']);
    }
    ?>
    <?php
    if (isset($_SESSION['resultRegister'])) {
        $resultRegister = $_SESSION['resultRegister'];
        echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'สมัครสมาชิกสำเร็จ',
                            text: '" . $resultRegister . "',
                            confirmButtonText: 'OK',
                            showConfirmButton: false,
                            timer: 2000 
                        });
                    });
                </script>";
        unset($_SESSION['resultRegister']);
    }
    ?>
    <?php
    if (isset($_SESSION['resultRegisterEx'])) {
        $resultRegisterEx = $_SESSION['resultRegisterEx'];
        echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'สมัครสมาชิกสำเร็จ',
                            text: '" . $resultRegisterEx . "',
                            confirmButtonText: 'OK',
                            showConfirmButton: false,
                            timer: 3000 
                        });
                    });
                </script>";
        unset($_SESSION['resultRegisterEx']);
    }
    ?>
</body>
</html>