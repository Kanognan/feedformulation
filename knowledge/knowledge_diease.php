<?php
session_start();
if (!isset ($_SESSION["acc_id"]) || $_SESSION["acc_id"] == "") {
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
    <title>โรคในโคนม</title>
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

        .header-know {
            color: black;
            text-align: center;
            padding: 0.5em;
            margin-bottom: 20px;
        }

        .nav-know {
            background-color: #f1f1f1;
            overflow: hidden;
        }

        .news-article {
            background-color: white;
            border: 1px solid #ddd;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .news-article p {
            margin: 0px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }


        /* -------------------------------search--------------------------------------- */
        .search-container {
            text-align: center;
            margin: 1em 0em;
        }

        .search-container input[type=text] {
            padding: 8px;
            margin: 10px;
            width: 30%;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .search-container button {
            padding: 8px 12px;
            margin: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f1f1f1;
            cursor: pointer;
        }

        /* -------------------------------search--------------------------------------- */
		.container-foot {
            position: relative;
            min-height: 65vh !important;
        }
    </style>
</head>

<body>
    <?php include "nav-bar.php" ?>
    <h2 class="text-center pt-3">ความรู้ / เทคนิคโรคในโคนม</h2>
    <?php include ("category.php") ?>
    <div class="container container-foot">
        <div class="search-container">
            <form method="GET" action="">
                <input type="text" placeholder="ค้นหาหมวดหมู่หรือหัวข้อ" name="search">
                <button type="submit">ค้นหา</button>
            </form>
        </div>
        <!----------------------------------------------------------------->
        <?php

        if (isset ($_GET['search']) && !empty ($_GET['search'])) {
            $search = $_GET['search'];
            $search_query = "SELECT * FROM knowledge WHERE category_knowledge_id = '4' AND knowledge_topic LIKE '%$search%' ORDER BY knowledge_id DESC";
            $result_kn = $conn->query($search_query);
        } else {
            $ID1 = "SELECT * FROM knowledge WHERE category_knowledge_id = '4' ORDER BY knowledge_id DESC";
            $result_kn = $conn->query($ID1);
        }
        ?>
        <!----------------------------------------------------------------->
        <div class="row">
            <?php
            if (isset ($_GET['search'])) {
                $search = $_GET['search'];
                // Query with search condition
                $query = mysqli_query($conn, "SELECT k.*, c.category_knowledge_name 
                    FROM knowledge k 
                    JOIN category_knowledge c 
                    ON k.category_knowledge_id = c.category_knowledge_id 
                    WHERE (k.knowledge_topic LIKE '%$search%' OR c.category_knowledge_name LIKE '%$search%')
                    AND k.category_knowledge_id = '3'");
            } else {
                // Query without search condition
                $query = mysqli_query($conn, "SELECT k.*, c.category_knowledge_name 
                    FROM knowledge k 
                    JOIN category_knowledge c 
                    ON k.category_knowledge_id = c.category_knowledge_id 
                    WHERE k.category_knowledge_id = '3'");
            }

            if ($query && mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_assoc($query)) { ?>
            <div class="news-article mt-3 p-4 col-12 col-sm-6 col-md-4"
                onclick="window.location='knowledge_topic.php?id=<?php echo $row['knowledge_id']; ?>'">
                <h4 style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    <?php echo $row['knowledge_topic']; ?>
                </h4>
                <p>
                    <?php echo $row['knowledge_content']; ?>
                </p>
                <p class="align-items-end"><b>หมวดหมู่ : </b>
                    <?php echo $row['category_knowledge_name']; ?>
                </p>

            </div>
            <?php }
            } else {
                echo '<p class="text-center">ไม่พบข้อมูลความรู้ / เทคนิคโรคในโคนม</p>';
            }
            ?>
        </div>
    </div>
	<div class="mt-5">
        <?php include ("../footer.php"); ?>
    </div>
</body>

</html>