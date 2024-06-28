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
    <title>กระทู้ของฉัน</title>
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
            font-size: 1.3em;
        }

        .h3-title {
            background-color: #B0DFEB;
            color: black;
            padding: 1rem;
            font-size: 1.3em;
        }

        .img img {
            width: 15em;
            display: block;
            margin: 0 auto;
        }

        .end {
            background-color: #B0DFEB;
            padding: 0.5em !important;
        }

        .back {
            padding-bottom: 5em;
        }

        .btn-back,
        .btn-save {
            padding: 0.4em !important;
            border-radius: 20px !important;
            width: 8em;
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


        .resizable {
            height: auto !important;
            overflow: hidden !important;
            resize: vertical !important;
        }

        .text-end {
            margin: 0px;
        }

        @media (max-width: 576px) {
            .img img {
                width: 8.5em;
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
        <form action="edit_post.php" method="post" enctype="multipart/form-data">
            <div class="content-posts">
                <div>
                    <div class="h2-title">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" value="<?php echo $result['posts_name'] ?>"
                                    name="posts_name">
                            </div>
                            <!-- <div class="col col-md-1 d-flex justify-content-end">
                                <div class="col d-flex justify-content-end">
                                    <input type="hidden" name="postsID" id="postsID"
                                        value="<?php //echo $result['postsID'];                    ?>">
                                    <button type="button" class="btn btn-secondary ms-1" id="editPost"
                                        onclick="window.location='mypost.php'"><i class="bi bi-x-lg"></i></button>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="posts">
                    <div class="d-flex justify-content-center post">
                        <div class="mb-3" style="width: 80%">
                            <div class="content-center">
                                <div class="col img">
                                    <div class=" pt-3 pb-3">
                                        <textarea class="form-control" name="posts_content"
                                            rows="8"><?php echo $result['posts_content']; ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="thread_img" class="form-label">เลือกภาพที่ต้องการอัพโหลด</label>
                                        <input type="file" class="form-control" name="img[]" id="thread_img" multiple>
                                    </div>
                                    <div class="table-responsive">
                                        <label for="table" class="form-label">รูปภาพเดิมทั้งหมด</label>
                                        <table
                                            class="table table-light table-striped-columns text-center table-bordered"
                                            id="table">
                                            <thead class="table-danger">
                                                <tr>
                                                    <th scope="col">รูปภาพเดิม</th>
                                                    <th scope="col">จัดการรูปภาพ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql_images = "SELECT * FROM posts_img WHERE postsID = $postsID";
                                                $result_images = mysqli_query($conn, $sql_images);
                                                $num_rows = mysqli_num_rows($result_images);

                                                if ($num_rows > 0) {
                                                    while ($image_row = mysqli_fetch_assoc($result_images)) {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <img src="../pic/<?php echo $image_row['posts_img']; ?>"
                                                                    alt="Posts Image">
                                                            </td>
                                                            <td><button type="button" class="btn btn-danger"
                                                                    onclick="deleteImage(<?php echo $image_row['posts_img_id']; ?>)">ลบรูปภาพ</button>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                } else {
                                                    echo '<tr><td colspan="2">ไม่มีรูปภาพ</td></tr>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="back text-center">
                <button type="button" class="btn btn-warning btn-back"
                    onclick="window.location='mypost.php'">ย้อนกลับ</button>
                <button type="submit" class="btn btn-success btn-save">บันทึก</button>
            </div>
        </form>
    </div>
	<?php include ("../footer.php"); ?>
    <?php
    if (isset($_SESSION['resultDeleteImg'])) {
        $resultDeleteImg = $_SESSION['resultDeleteImg'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'ลบสำเร็จ',
                        text: '" . $resultDeleteImg . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
        unset($_SESSION['resultDeleteImg']);
    }
    ?>
    <script>
        function deleteImage(posts_img_id) {
            Swal.fire({
                title: 'ยืนยันการลบ',
                text: 'คุณต้องการลบรูปภาพนี้ใช่หรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ใช่, ลบ!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'delete_image.php?id=' + posts_img_id;
                }
            });
        }
    </script>

</body>

</html>