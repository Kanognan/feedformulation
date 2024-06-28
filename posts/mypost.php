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
$acc_id = $_SESSION['acc_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php //include("../header.php");                                               ?>
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
            padding-top: 8em;
        }

        .content-posts {
            background-color: #deefff;
            margin: 2rem 2rem;
        }

        .h2-title {
            background-color: #8db0d1;
            color: white;
            font-size: 1.8em;
            padding: 0.6rem;
            margin-bottom: 1.5em;
        }

        .img img {
            height: 10rem;
            width: 100%;
            object-fit: cover;
        }

        .contenLink:hover {
            cursor: pointer;
        }

        ul .dropdown-menu {
            padding: 0px !important;
        }

        .head-post {
            text-align: center;
            padding: 1.7em;
        }
        .container-foot {
            position: relative;
            min-height: 65vh !important;
        }
    </style>
</head>

<body>
    <?php include "nav-bar.php"; ?>
    <div class="head-post">
        <h2>
            กระทู้ของฉัน
        </h2>
    </div>
    <div class="container container-foot">
        <?php
        $ID1 = "SELECT * FROM posts WHERE acc_id = $acc_id AND deleteAt IS NULL ORDER BY postsID DESC";
        $resultID1 = $conn->query($ID1);
        ?>
        <div class="content-posts">
            <h2 class="h2-title">กระทู้ของฉันทั้งหมด</h2>
            <?php
            if ($resultID1 && $resultID1->num_rows > 0) {
                foreach ($resultID1 as $result) {
                    $idpost = $result['postsID'];
                    ?>
                    <div class="posts" onclick="window.location='webboard_history.php?id=<?php echo $result['postsID']; ?>'">
                        <div class="d-flex justify-content-center post">
                            <div class="card mb-3" style="width: 80%">
                                <div class="row g-0 content-center contenLink">
                                    <?php
                                    $sql_images = "SELECT * FROM posts_img WHERE postsID = $idpost";
                                    $result_images = mysqli_query($conn, $sql_images);
                                    $num_rows = mysqli_num_rows($result_images);

                                    if ($num_rows > 0) { ?>
                                        <div class="col-md-4 img">
                                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    <?php
                                                    $is_first = true;
                                                    while ($image_row = mysqli_fetch_assoc($result_images)) {
                                                        ?>
                                                        <div class="carousel-item <?php echo $is_first ? 'active' : ''; ?>">
                                                            <img src="../pic/<?php echo $image_row['posts_img']; ?>"
                                                                class="img-fluid rounded-start" alt="Posts Image">
                                                        </div>
                                                        <?php
                                                        $is_first = false;
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                        <?php } else { ?>
                                            <div class="col-md-12">
                                            <?php } ?>
                                            <div class="card-body">
                                                <h5 class="card-title" style="height:3em;">
                                                    <?php echo $result['posts_name']; ?>
                                                </h5>
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
                                                <div class="d-flex justify-content-between row">
                                                    <div class="col-12 col-sm-12 col-md-6 text-start p-0">
                                                        <p class="card-text">
                                                            <small class="text-muted">โพสเมื่อ
                                                                <?php echo $result['createAt']; ?>
                                                            </small>
                                                        </p>
                                                    </div>
                                                    <div class="col-12 col-sm-12 col-md-6 text-end p-0">
                                                        <?php
                                                        $sql_comments_count = "SELECT COUNT(*) AS total_comments FROM comment WHERE postsID = $idpost";
                                                        $result_comments_count = mysqli_query($conn, $sql_comments_count);
                                                        if ($result_comments_count) {
                                                            $row_comments_count = mysqli_fetch_assoc($result_comments_count);
                                                            $total_comments = $row_comments_count['total_comments'];
                                                            if ($total_comments !== null) {
                                                                $comment_text = ($total_comments == 1) ? "ความคิดเห็น" : "ความคิดเห็น";
                                                                ?>
                                                                <p class="card-text">
                                                                    <small class="text-muted">
                                                                        <?php echo $total_comments; ?>
                                                                        <?php echo $comment_text; ?>
                                                                    </small>
                                                                </p>
                                                                <?php
                                                            } else {
                                                                echo "<p class='card-text'><small class='text-muted'>No comments</small></p>";
                                                            }
                                                        } else {
                                                            echo "<p class='card-text'><small class='text-muted'>Error fetching comments</small></p>";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                }
            } else {
                echo "<h5 class='text-center pb-5'>ยังไม่มีกระทู้</h5>";
            }

            ?>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <?php include ("../footer.php"); ?>
    </div>
    <?php
    if (isset($_SESSION['resultUpdatePost'])) {
        $resultUpdatePost = $_SESSION['resultUpdatePost'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'แก้ไขสำเร็จ',
                        text: '" . $resultUpdatePost . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
        unset($_SESSION['resultUpdatePost']);
    }
    ?>
    <?php
    if (isset($_SESSION['resultDeletePost'])) {
        $resultDeletePost = $_SESSION['resultDeletePost'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'ลบสำเร็จ',
                        text: '" . $resultDeletePost . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
        unset($_SESSION['resultDeletePost']);
    }
    ?>
</body>

</html>