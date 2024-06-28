<?php
session_start();
if (!isset ($_SESSION['user_status']) || ($_SESSION['user_status'] != 'Admin')) {
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
session_start();
if (!isset ($_SESSION['user_status']) || ($_SESSION['user_status'] != 'Admin' && $_SESSION['user_status'] != 'Expert')) {
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
    <title>เพิ่มความรู้เทคนิค</title>
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
            padding-top: 8em;
            padding-bottom: 5em;
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
            width: 8em;
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

        @media screen and (max-width: 576px) {
            .btn-more .btn-add {
                font-size: 1em;
                width: 6em;
                margin: 0em 0.3em;
            }

            .btn-more .btn-cancel {
                font-size: 1em;
                width: 6em;
                margin: 0em 0.3em;
            }
        }
    </style>
</head>

<body>
    <?php include ('nav-bar.php'); ?>
    <h2 class="text-center pt-3">เพิ่มความรู้ / เทคนิค</h2>
    <?php include ('category.php'); ?>
    <div class="container ps-5 pe-5">
        <div class="content-posts">
            <!-- <h2 class="h2-title">เพิ่มความรู้/เทคนิค</h2> -->
            <div class="add-posts">
                <form action="knowledge_db.php" method="post" enctype="multipart/form-data">
                    <?php if (isset ($_SESSION['error'])): ?>
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
                        <label for="category_knowledge">หมวดหมู่</label>
                        <select name="category_knowledge" id="category_knowledge" class="form-control" required>
                            <option disabled selected>เลือกหมวดหมู่</option>
                            <?php
                            $sql = "SELECT * FROM category_knowledge";
                            $result = $conn->query($sql);
                            while ($career = $result->fetch_assoc()):
                                ;
                                ?>
                                <option value="<?php echo $career["category_knowledge_id"]; ?>">
                                    <?php echo $career["category_knowledge_name"]; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="posts_name">หัวข้อความรู้/เทคนิค</label>
                        <input type="content" name="knowledge_topic" class="form-control" required></input>
                    </div>
                    <div class="form-group">
                        <label for="posts_content">เนื้อหาความรู้/เทคนิค</label>
                        <textarea type="content" name="knowledge_content" class="form-control" rows="5" cols="100"
                            required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="thread_img">เพิ่มรูปภาพ</label>
                        <input type="file" class="form-control" name="knowledge_img[]" id="knowledge_img" multiple>
                    </div>
                    <div class="d-flex justify-content-center btn-more">
                        <div class="form-group">
                            <button type="reset" name="reset" class="btn btn-cancel"
                                onclick="window.location='knowledge.php'">ยกเลิก</button>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="addknowledge" class="btn btn-add">บันทึก</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        let menus = document.querySelectorAll('.menu');
        menus.forEach(menu => {
            menu.addEventListener('click', () => {
                menus.forEach(m => m.classList.remove('active'));
                menu.classList.add('active');
            });
        });

    </script>
</body>

</html>