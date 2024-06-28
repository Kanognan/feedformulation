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
   <link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <title>เพิ่มข่าวสาร</title>
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
    include('nav-bar.php')
        ?>
    <div class="container">
        <div class="content-posts">
            <h2 class="h2-title">เพิ่มข่าวสาร</h2>
            <div class="add-posts">
                <form action="data.php" method="post" enctype="multipart/form-data">
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
                            $sql = "SELECT * FROM category_news";
                            $result = $conn->query($sql);
                            while ($career = $result->fetch_assoc()):
                                ;
                                ?>
                            <option value="<?php echo $career["category_news_id"]; ?>">
                                <?php echo $career["category_news_name"]; ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="news_topic">หัวข้อข่าวสาร</label>
                        <input type="content" name="news_topic" class="form-control" required></input>
                    </div>
                    <div class="form-group">
                        <label for="news_detail">เนื้อหาข่าวสาร</label>
                        <textarea type="content" name="news_detail" class="form-control" rows="5" cols="100"
                            required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="news_img">เพิ่มรูปภาพ</label>
                        <input type="file" class="form-control" name="upload[]" id="upload" multiple>
                    </div>
                    <div class="d-flex justify-content-center btn-more">
                        <div class="form-group">
                            <button type="reset" name="reset" class="btn btn-cancel"
                                onclick="window.location='expert-news.php'">ยกเลิก</button>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="post_text" class="btn btn-add">เพิ่มข่าวสาร
							</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
        integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous">
    </script>
	 <?php include("../footer.php"); ?>
</body>

</html>