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
    <?php //include("../header.php");     ?>
    <title>เพิ่มกระทู้</title>
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
    </style>
</head>

<body>
    <?php include ('nav-bar.php'); ?>
    <div class="container">
        <div class="content-posts">
            <h2 class="h2-title">เพิ่มกระทู้</h2>
            <div class="add-posts">
                <form action="addpost_db.php" method="post" enctype="multipart/form-data">
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
                            <option disabled selected value="">เลือกหมวดหมู่กระทู้</option>
                            <?php
                            $sql = "SELECT * FROM category";
                            $result = $conn->query($sql);
                            while ($career = $result->fetch_assoc()):
                                ;
                                ?>
                                <option value="<?php echo $career["category_id"]; ?>">
                                    <?php echo $career["category_name"]; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="posts_name">ชื่อกระทู้</label>
                        <textarea type="content" name="posts_name" class="form-control" rows="3" cols="100" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="posts_content">ข้อความกระทู้</label>
                        <textarea type="content" name="posts_content" class="form-control" rows="5" cols="100" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="thread_img">เพิ่มรูปภาพ</label>
                        <input type="file" class="form-control" name="img[]" id="thread_img" multiple>
                    </div>
                    <div class="d-flex justify-content-center btn-more">
                        <div class="form-group">
                            <button type="reset" name="reset" class="btn btn-cancel"
                                onclick="window.location='home-webboard.php'">ยกเลิก</button>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="addpost" class="btn btn-add">เพิ่มกระทู้</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php include ("../footer.php"); ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.querySelector("form");
            form.addEventListener("submit", function (event) {
                const postsNameInput = document.querySelector("[name='posts_name']");
                const postsContentInput = document.querySelector("[name='posts_content']");

                if (postsNameInput.value.trim() === '' || postsContentInput.value.trim() === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'ข้อมูลไม่ครบถ้วน',
                        text: 'กรุณากรอกชื่อกระทู้และข้อความกระทู้ให้ถูกต้อง',
                    });
                    event.preventDefault(); // ยกเลิกการส่งฟอร์ม
                }
            });
        });
    </script>
</body>

</html>