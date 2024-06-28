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
    <?php //include("../header.php");                      ?>
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Kanit', sans-serif;
        }

        body {
            padding-top: 10em;
        }

        .content-posts {
            background-color: #DBEDF2;
            margin: 2rem 2rem;
        }

        .h2-title {
            background-color: #6999C6;
            color: white;
            padding: 1rem;
        }

        .h3-title {
            background-color: #B0DFEB;
            color: black;
            padding: 1rem;
        }

        .img img {
            /* width: 40%; */
            display: block;
            margin: 0 auto;
        }

        .end {
            background-color: #B0DFEB;
            padding: 0.5em !important;
        }

        .comment {
            padding: 5em;
            text-align: center;
        }

        .back {
            padding-bottom: 5em;

        }

        .btn-back {
            padding: 0.5em !important;
            border-radius: 20px !important;
            width: 10em;
        }

        .btn-comment {
            padding: 0.5em !important;
            border-radius: 20px !important;
            width: 10em;
        }

        .label {
            padding: 1em !important;
            font-weight: bold;
        }

        .detail-comment {
            background-color: white;
            padding: 0.5em;
            margin-bottom: 1em;
            text-align: left;
        }

        .detail-comment p {
            margin-bottom: 0rem;
        }

        #detai {
            padding: 2em 0em;
        }

        #name {
            background-color: #F2F7F9;
            border-top: 1px solid gray;
            font-size: 0.8em;
        }

        #count {
            font-size: 0.8em;
            border-bottom: 1px solid gray;
        }

        .com-img img {
            /* width: 30%; */
            display: block;
            margin: 0 auto;
        }

        .resizable {
            height: auto !important;
            overflow: hidden !important;
            resize: vertical !important;
        }

        .row {
            margin: 0px !important;
        }

        #box {
            background-color: #F2F7F9 !important;
            padding: 1em;
            border-radius: 15px;
        }

        @media (max-width: 576px) {
            .comment {
                padding: 1em;
            }

            .com-img img {
                width: 100%;
            }
        }
    </style>

</head>

<body>
    <?php include "nav-bar.php" ?>
    <div class="container">
        <?php
        $postsID = $_GET['id'];
        $query = mysqli_query($conn, "select * from posts WHERE postsID = $postsID");
        $result = mysqli_fetch_assoc($query);
        $_SESSION["postsID"] = $postsID;
        // $comment_id = $_SESSION['comment_id'];
        
        $query_comment = mysqli_query($conn, "SELECT * FROM comment JOIN account ON comment.acc_id = account.acc_id WHERE comment.postsID = '$postsID'");
        $comment_count = mysqli_num_rows($query_comment);
        $comment_number = 1;
        ?>
        <div class="content-posts">
            <h4 class="h2-title">
                <?php echo $result['posts_name'] ?>
            </h4>
            <div class="posts">
                <div class="d-flex justify-content-center post">
                    <div class="mb-3" style="width: 80%">
                        <div class="content-center">
                            <div class="col img row">
                                <div class="card-text pt-5 pb-5">
                                    <?php echo $result['posts_content']; ?>
                                </div>
                                <?php
                                $sql_images = "SELECT * FROM posts_img WHERE postsID = $postsID";
                                $result_images = mysqli_query($conn, $sql_images);
                                $num_rows = mysqli_num_rows($result_images);

                                if ($num_rows > 0) { ?>
                                    <div class="img row">
                                        <?php
                                        $is_first = true;
                                        while ($image_row = mysqli_fetch_assoc($result_images)) {
                                            ?>
                                            <img src="../pic/<?php echo $image_row['posts_img']; ?>"
                                                class="col col-sm-6 col-md-4 mt-3" alt="Posts Image">
                                            <?php
                                            $is_first = false;
                                        }
                                        ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card-body end">
                        <div>
                            <?php
                            $sqlacc = "SELECT account.acc_name FROM posts INNER JOIN account ON posts.acc_id = account.acc_id";
                            $resultacc = mysqli_query($conn, $sqlacc);
                            if (mysqli_num_rows($resultacc) > 0) {
                                $row = mysqli_fetch_assoc($resultacc);
                                echo $row['acc_name'];
                            } else {
                                echo "ไม่พบชื่อผู้โพส";
                            }
                            ?>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="d-flex justify-content-start">
                                <p class="card-text">
                                    <small class="text-muted">โพสเมื่อ
                                        <?php echo $result['createAt']; ?>
                                    </small>
                                </p>
                            </div>
                            <div class="d-flex justify-content-end ">
                                <p class="card-text">
                                    <small class="text-muted">ความคิดเห็นทั้งหมด
                                        <?php echo $comment_count; ?>
                                    </small>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-posts">
            <h4 class="h3-title">
                ความคิดเห็น
            </h4>
            <div class="comment">
                <?php
                if ($comment_count > 0) {
                    while ($rs = mysqli_fetch_assoc($query_comment)) { ?>
                        <div class="detail-comment">
                            <p id="count">
                                ความคิดเห็นที่
                                <?php echo $comment_number; ?>
                            </p>
                            <div id="detai">
                                <p>
                                    <?php echo $rs['comment_detail']; ?>
                                </p>
                                <?php
                                // เพิ่มตัวแปร $comment_id ที่ดึงมาจากแต่ละความคิดเห็น
                                $comment_id = $rs['comment_id'];
                                $sql_images_com = "SELECT * FROM comment_img WHERE comment_id = $comment_id";
                                $result_images_com = mysqli_query($conn, $sql_images_com);
                                $num_rows = mysqli_num_rows($result_images_com);

                                if ($num_rows > 0) { ?>
                                    <div class="row com-img">
                                        <?php
                                        while ($image_row_com = mysqli_fetch_assoc($result_images_com)) {
                                            ?>
                                            <img src="../pic/<?php echo $image_row_com['com_img']; ?>"
                                                class="col col-sm-6 col-md-4 mt-3" alt="Comment Image">
                                            <?php
                                        }
                                        ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <p id="name">
                                โดย
                                <?php echo $rs['acc_name']; ?>
                            </p>
                        </div>
                        <?php $comment_number++;
                    } ?>
                    <div class="">
                        <p id="comment" style="color:transparent">แสดงความคิดเห็น</p>
                        <button type="button" class="btn btn-secondary btn-comment" onclick="myFunction()"
                            id="btn">แสดงความคิดเห็น</button>
                        <!-- <script src="index.js"></script> -->
                        <div id="box" style="display: none;">
                            <form action="comment-webboard.php" method="post" enctype="multipart/form-data">
                                <div class="mb-3 after-hide">
                                    <div class="was-validated">
                                        <label class="label">แสดงความคิดเห็นเพิ่มเติม</label>
                                        <input class="form-control resizable" id="exampleFormControlTextarea1 textarea"
                                            name="comment_detail" required="required" pattern="[^\s].*">
                                    </div>
                                    <div class="pt-3 text-start">
                                        <label for="thread_img">เพิ่มรูปภาพ</label>
                                        <input type="file" name="img[]" id="thread_img" class="form-control" multiple>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="reset" class="btn btn-danger"
                                        onclick="window.location='webboard.php?id=<?php echo $result['postsID']; ?>'">ยกเลิก</button>
                                    <button type="submit" name="add-comment"
                                        class="btn btn-primary btn-add">เพิ่มความคิดเห็น</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php } else { ?>
                    <p id="comment">ยังไม่มีความคิดเห็น</p>
                    <button type="button" class="btn btn-secondary btn-comment" onclick="myFunction()"
                        id="btn">แสดงความคิดเห็น</button>
                    <!-- <script src="index.js"></script> -->
                    <div id="box" style="display: none;">
                        <form action="comment-webboard.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3 after-hide">
                                <div class="was-validated">
                                    <label class="label">แสดงความคิดเห็นเพิ่มเติม</label>
                                    <input class="form-control resizable" id="exampleFormControlTextarea1 textarea"
                                        name="comment_detail" required="required" pattern="[^\s].*">
                                </div>
                                <div class="pt-3 text-start">
                                    <label for="thread_img">เพิ่มรูปภาพ</label>
                                    <input type="file" name="img[]" id="thread_img" class="form-control" multiple>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="reset" class="btn btn-danger"
                                    onclick="window.location='webboard.php?id=<?php echo $result['postsID']; ?>'">ยกเลิก</button>
                                <button type="submit" name="add-comment"
                                    class="btn btn-primary btn-add">เพิ่มความคิดเห็น</button>
                            </div>
                        </form>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
        $_SESSION["count"] = $comment_count;
        $count = $_SESSION["count"];
        ?>
        <div class="back text-center">
            <button type="button" class="btn btn-warning btn-back"
                onclick="window.location='home-webboard.php'">ย้อนกลับ</button>
        </div>
    </div>
	<?php include ("../footer.php"); ?>
    <script>
        document.addEventListener("input", function () {
            const input = document.querySelector(".resizable");
            input.style.height = "auto";
            input.style.height = (input.scrollHeight) + "px";
        });
    </script>
    <script>
        function myFunction() {
            var x = document.getElementById("myDIV");
            const btn = document.getElementById('btn');
            const comment = document.getElementById('comment');

            btn.addEventListener('click', () => {
                // hide button (still takes up space on page)
                btn.style.display = 'none';
                comment.style.display = 'none';

                // show div
                const box = document.getElementById('box');
                box.style.display = 'block';
            });
        }
    </script>
</body>

</html>