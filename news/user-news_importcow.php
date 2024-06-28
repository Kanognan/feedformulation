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
include "pagination_function.php";
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
 <link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <title>ข่าวสารนำเข้า/ส่งออกโคนม</title>
    <style>
   * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Kanit', sans-serif; 
        }

        body {
            padding-top: 7em;
        }

        .content-news {
            border: 2px solid #f5f5f5;
            margin: 2rem auto;
            padding: 1.6em;
            width: 93%;
            height: cover;
            box-shadow: 5px 6px 6px 2px lightgray;
        }

        .contenLink:hover {
            cursor: pointer;
        }

        .addnews {
            margin: 2em;

        }

        .button-add {
            padding: 0.8em;
            border-radius: 2em;
            width: 10em;
            background-color: #77DC67;
            border: none;
            color: #fff;
            margin-right: 6em;

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

    .text-news {
        margin-top: 0.8em;
        width: 80%;
        margin: 1em 0;
		cursor: pointer;
    }

    .text-news .col-12 {
        font-weight: 600;
        font-size: 1.3em;
        color: #4f80c0;
        overflow: hidden;
        text-overflow: ellipsis;
        /* เพิ่ม ellipsis เมื่อเกิดการตัดข้อความ */
        white-space: nowrap;
        /* ป้องกันข้อความขึ้นบรรทัดใหม่ */
    }

    .text-news .col-4 {
        padding-top: 0.4em;
        color: gray;
        font-size: 0.9em;
    }

    .carousel {
            width: 100%;
        }


    .carousel-inner .carousel-item img {
        object-fit: cover;
        width: 100%;
        height: 15rem;
        margin: 0 auto;
        border-radius: 5px;
    }

   
    </style>
</head>

<body>
    <?php include "nav-bar.php"?>
    <div class="imghead">
        <img src="../Images/news-head.jpg" alt="room" class="img">
        <h1>
            ข่าวสาร
        </h1>
    </div><br><br>
    <div class="container">
        <?php include("user_category.php") ?>
        <!-- --------------------------------------------------------------->
        <div class="content-news">
        <?php
        // Query เพื่อดึงข้อมูลข่าวทั้งหมด
        $sql = "SELECT news.*, news_img.news_img
                FROM news
                LEFT JOIN news_img ON news.news_id = news_img.news_id
                WHERE category_news_id= '6' 
                GROUP BY news.news_id";
        $result = mysqli_query($conn, $sql);
        $num = 0;
        $total = $result->num_rows;
        $e_page = 9; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า   
        $step_num = 0;
        
        if (!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] == 1)) {
            $_GET['page'] = 1;
            $step_num = 0;
            $s_page = 0;
        } else {
            $s_page = $_GET['page'] - 1;
            $step_num = $_GET['page'] - 1;
            $s_page = $s_page * $e_page;
        }
        
        $sql .= " ORDER BY news_id DESC LIMIT " . $s_page . ",$e_page";
        $result = $conn->query($sql);
        ?>
        <div class="row">
            <?php
            // ตรวจสอบว่ามีข้อมูลข่าวหรือไม่
            if ($result && $result->num_rows > 0) {
                // วนลูปแสดงข้อมูลข่าวทั้งหมด
                while ($row = $result->fetch_assoc()) {
                    $newsDate = new DateTime($row['news.createAt']);
                    $currentDate = new DateTime(); // Current date and time
                    // Calculate the difference in days
                    $interval = $currentDate->diff($newsDate);
                    $daysDifference = $interval->days;
                    $news_id = $row['news_id'];
            ?>
                    <div class="col-12 col-lg-4 col-xl-4 col-md-6 col-sm-12 ">
                        <div class="news-img border-content">
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
                                            <img src="../pic/<?php echo $image_row['news_img']; ?>" class="d-block w-100" alt="News Image">
                                        </div>
                                    <?php
                                        $is_first = false;
                                    }
                                    ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls<?php echo $news_id; ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls<?php echo $news_id; ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                        <div class="text-news">
                            <div class="row">
                                <div class="col-12">
                                    <?php echo $row['news_topic']; ?>
                                </div>
                                <div class="col-4">
                                <?php
                                    if ($daysDifference == 0) {
                                        echo "ล่าสุดวันนี้";
                                    } else {
                                        echo $daysDifference . " วันที่ผ่านมา";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                // ถ้าไม่มีข้อมูลข่าว
                echo "<p class='mt-5'>ไม่มีข้อมูล</p>";
            }
            ?>
        </div>

        </div>
        <?php
        page_navi($total, (isset($_GET['page'])) ? $_GET['page'] : 1, $e_page);
        ?>
    </div>
	 <?php include("../footer.php"); ?>
</body>

</html>