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
    <?php //include("../header.php");                                      ?>
    <title>กระทู้</title>
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
            margin: 2rem 2rem;
        }

        .h2-title {
            background-color: #6999C6;
            color: white;
            padding: 1rem;
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
    </style>
</head>

<body>
    <?php include "nav-bar.php"; ?>
    <div class="container">
        <?php include ("nav-category.php"); ?>
        <!----------------------------------------------------------------->
        <?php


        $ID1 = "SELECT * FROM posts WHERE category_id= '1' AND deleteAt IS NULL ORDER BY postsID DESC";
        $resultID1 = $conn->query($ID1);

        $ID2 = "SELECT * FROM posts WHERE category_id= '2' AND deleteAt IS NULL ORDER BY postsID DESC";
        $resultID2 = $conn->query($ID2);

        $ID3 = "SELECT * FROM posts WHERE category_id= '3' AND deleteAt IS NULL ORDER BY postsID DESC";
        $resultID3 = $conn->query($ID3);

        $ID4 = "SELECT * FROM posts WHERE category_id= '4' AND deleteAt IS NULL ORDER BY postsID DESC";
        $resultID4 = $conn->query($ID4);

        ?>
        <div class="content-posts">
            <h2 class="h2-title">การเลี้ยงโค</h2>
            <?php
            $x = 3;
            if ($resultID1) {
                foreach ($resultID1 as $result) {
                    $idpost = $result['postsID'];
                    $x = $x - 1;
                    if ($x >= 0) {
                        ?>
            <div class="posts" onclick="window.location='webboard.php?id=<?php echo $result['postsID']; ?>'">
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
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex justify-content-start">
                                                <p class="card-text">
                                                    <small class="text-muted">โพสเมื่อ
                                                        <?php echo $result['createAt']; ?>
                                                    </small>
                                                </p>
                                            </div>
                                            <div class="d-flex justify-content-end">
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
                }
            }
            ?>
            </div>

            <!----------------------------------------------------------------->
            <div class="content-posts">
                <h2 class="h2-title">การรีดนม</h2>
                <?php
                $x = 3;
                if ($resultID2) {
                    foreach ($resultID2 as $result) {
                        $idpost = $result['postsID'];
                        $x = $x - 1;
                        if ($x >= 0) {
                            ?>
                <div class="posts" onclick="window.location='webboard.php?id=<?php echo $result['postsID']; ?>'">
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
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex justify-content-start">
                                                    <p class="card-text">
                                                        <small class="text-muted">โพสเมื่อ
                                                            <?php echo $result['createAt']; ?>
                                                        </small>
                                                    </p>
                                                </div>
                                                <div class="d-flex justify-content-end">
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
                    }
                }
                ?>
                </div>

                <!----------------------------------------------------------------->
                <div class="content-posts">
                    <h2 class="h2-title">การผสมพันธุ์</h2>
                    <?php
                    $x = 3;
                    if ($resultID3) {
                        foreach ($resultID3 as $result) {
                            $idpost = $result['postsID'];
                            $x = $x - 1;
                            if ($x >= 0) {
                                ?>
                    <div class="posts" onclick="window.location='webboard.php?id=<?php echo $result['postsID']; ?>'">
                        <div class="d-flex justify-content-center post">
                            <div class="card mb-3" style="width: 80%">
                                <div class="row g-0 content-center contenLink">
                                    <?php
                                    $sql_images = "SELECT * FROM posts_img WHERE postsID = $idpost";
                                    $result_images = mysqli_query($conn, $sql_images);
                                    $num_rows = mysqli_num_rows($result_images);

                                    if ($num_rows > 0) { ?>
                                    <div class="col-md-4 img">
                                        <div id="carouselExampleIndicators" class="carousel slide"
                                            data-bs-ride="carousel">
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
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex justify-content-start">
                                                        <p class="card-text">
                                                            <small class="text-muted">โพสเมื่อ
                                                                <?php echo $result['createAt']; ?>
                                                            </small>
                                                        </p>
                                                    </div>
                                                    <div class="d-flex justify-content-end">
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
                        }
                    }
                    ?>
                    </div>

                    <!----------------------------------------------------------------->

                    <div class="content-posts">
                        <h2 class="h2-title">การแปรรูปผลผลิต</h2>
                        <?php
                        $x = 3;
                        if ($resultID4) {
                            foreach ($resultID4 as $result) {
                                $idpost = $result['postsID'];
                                $x = $x - 1;
                                if ($x >= 0) {
                                    ?>
                        <div class="posts"
                            onclick="window.location='webboard.php?id=<?php echo $result['postsID']; ?>'">
                            <div class="d-flex justify-content-center post">
                                <div class="card mb-3" style="width: 80%">
                                    <div class="row g-0 content-center contenLink">
                                        <?php
                                        $sql_images = "SELECT * FROM posts_img WHERE postsID = $idpost";
                                        $result_images = mysqli_query($conn, $sql_images);
                                        $num_rows = mysqli_num_rows($result_images);

                                        if ($num_rows > 0) { ?>
                                        <div class="col-md-4 img">
                                            <div id="carouselExampleIndicators" class="carousel slide"
                                                data-bs-ride="carousel">
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
                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex justify-content-start">
                                                            <p class="card-text">
                                                                <small class="text-muted">โพสเมื่อ
                                                                    <?php echo $result['createAt']; ?>
                                                                </small>
                                                            </p>
                                                        </div>
                                                        <div class="d-flex justify-content-end">
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
                            }
                        }
                        ?>
                        </div>

                        <!----------------------------------------------------------------->
                    </div>
					      <?php include ("../footer.php"); ?>

</body>

</html>