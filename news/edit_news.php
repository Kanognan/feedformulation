<?php
session_start();
if (!isset($_SESSION['user_status']) || ($_SESSION['user_status'] != 'Admin' && $_SESSION['user_status'] != 'Expert')) {
    $resultNoSessionExpert = "สำหรับผู้ดูแลระบบและผู้เชี่ยวชาญเท่านั้น";
    $_SESSION['resultNoSessionExpert'] = $resultNoSessionExpert;
    echo "<script type='text/javascript'>";
    echo "window.location = '../login.php'; ";
    echo "</script>";
    exit();
    // ผู้เชี่ยวชาญ
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
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <title>แก้ไขข่าวสาร</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Kanit', sans-serif;
    }

    body {
        padding-top: 8em;
    }

    .content-posts {
        background-color: #DBEDF2;
        margin: 2rem 1rem;
    }

    .h2-title {
        background-color: #6999C6;
        color: white;
        padding: 1rem;
    }

    .add-posts {
        padding: 2rem;
    }

    .btn-more {
        margin: 1em 0em;
    }

    .btn-more .btn-add {
        background-color: #77DC67;
        color: white;
        width: 10em;
        border-radius: 20px !important;
        margin: 0em 0.3em;
    }

    .btn-more .btn-add:hover {
        background-color: #6999C6 !important;
    }

    .btn-more .btn-cancel {
        background-color: #FE5E5E;
        color: white;
        width: 8em;
        border-radius: 20px !important;
        margin: 0em 0.3em;
    }

    .btn-more .btn-cancel:hover {
        background-color: #6999C6 !important;
    }

    .form-group {
        margin: 0em 0em 1.5em 0em;
    }
    </style>
</head>

<body>
    <?php
    session_start();
    include('nav-bar.php')
        ?>
    <div class="container">
        <div class="content-posts">
            <h2 class="h2-title">แก้ไขข่าวสาร</h2>
            <div class="add-posts">
                <?php $news_id = $_GET['news_id']; ?>
                <?php
                    $sql_news = "SELECT * FROM news
                                            INNER JOIN category_news
                                            ON news.category_news_id = category_news.category_news_id 
                                            WHERE news.news_id = $news_id";
                            $rns = $conn->query($sql_news);
                            $result_news = mysqli_fetch_assoc($rns);   

                            // ดึงข้อมูลรูปภาพข่าวที่มี news_id เท่ากับค่าที่ส่งมาจาก URL
                            $sql_news_img = "SELECT news.*, news_img.news_img
                                    FROM news
                                    LEFT JOIN news_img ON news.news_id = news_img.news_id 
                                    WHERE news.news_id = $news_id
                                    GROUP BY news.news_id";
                            $rnms = mysqli_query($conn, $sql_news_img);
                            $result_news_img = mysqli_fetch_assoc($rnms); 
                       
                        ?>

                <form action="edit_news_db.php?news_id=<?php echo $news_id; ?>" method="post"
                    enctype="multipart/form-data">
                    <?php if (isset($_SESSION['error'])): ?>
                    <div class="error">
                        <h3>
                            <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
                        </h3>
                    </div>
                    <?php endif ?>

                    <div class="form-group">
                        <label for="category">หมวดหมู่</label>
                        <select name="category" id="category" class="form-control" required>
                            <option value="" selected disabled>เลือกหมวดหมู่</option>
                            <?php
                $sql_news_all = "SELECT * FROM category_news";
                $result_news_all = $conn->query($sql_news_all);
                while ($row_news = mysqli_fetch_assoc($result_news_all)) {
                    // เลือกค่า option ที่มี category_news_id เท่ากับ category_news_id ของข่าวที่ถูกเลือกไว้ล่วงหน้า
                    $selected = ($row_news["category_news_id"] == $result_news["category_news_id"]) ? "selected" : "";
                    echo "<option value='{$row_news["category_news_id"]}' $selected>{$row_news["category_news_name"]}</option>";
                }
            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="news_topic">หัวข้อความรู้/เทคนิค</label>
                        <input type="content" name="news_topic" class="form-control"
                            value="<?php echo $result_news['news_topic']?>"></input>
                    </div>
                    <div class="form-group">
                        <label for="news_detail">เนื้อหาความรู้/เทคนิค</label>
                        <textarea name="news_detail" class="form-control" rows="5"
                            cols="100"><?php echo $result_news['news_detail']?></textarea>
                    </div>
                    <div class="d-flex justify-content-center btn-more">
                        <div class="form-group">
                            <button type="reset" name="reset" class="btn btn-cancel"
                                onclick="window.location='expert-news.php'">ยกเลิก</button>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="edit_news" class="btn btn-add">ยืนยัน</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>


</html>