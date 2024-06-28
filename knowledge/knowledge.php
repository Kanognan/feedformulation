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
    <title>ความรู้เทคนิค</title>
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
    <h2 class="text-center pt-3">ความรู้ / เทคนิคทั้งหมด</h2>
    <?php include "category.php" ?>
    <div class="container container-foot">
        <!-- Search form -->
        <div class="search-container">
            <form method="GET" action="">
                <input type="text" placeholder="ค้นหาหมวดหมู่หรือหัวข้อ" name="search">
                <button type="submit">ค้นหา</button>
            </form>
        </div>
        <div class="row">
            <?php
            // Check if search parameter is set
            if (isset ($_GET['search'])) {
                $search = $_GET['search'];
                // Query with search condition
                $query = mysqli_query($conn, "SELECT k.*, c.category_knowledge_name 
                                FROM knowledge k 
                                JOIN category_knowledge c 
                                ON k.category_knowledge_id = c.category_knowledge_id 
                                WHERE k.knowledge_topic LIKE '%$search%' 
                                OR c.category_knowledge_name LIKE '%$search%'");
            } else {
                // Query without search condition
                $query = mysqli_query($conn, "SELECT k.*, c.category_knowledge_name 
                                FROM knowledge k 
                                JOIN category_knowledge c 
                                ON k.category_knowledge_id = c.category_knowledge_id");
            }

            if ($query && mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_assoc($query)) { ?>
                    <div class="news-article mt-3 p-4 col-12 col-sm-6 col-md-4"
                        onclick="window.location='knowledge_topic.php?id=<?php echo $row['knowledge_id']; ?>'">
                        <div>
                            <h4 style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <?php echo $row['knowledge_topic']; ?>
                            </h4>
                            <p>
                                <?php echo $row['knowledge_content']; ?>
                            </p>
                            <p class=""><b>หมวดหมู่ : </b>
                                <?php echo $row['category_knowledge_name']; ?>
                            </p>
                        </div>
                    </div>
                <?php }
            } else {
                echo '<p class="text-center">ไม่พบข้อมูลความรู้ / เทคนิคทั้งหมด</p>';
            }
            ?>
        </div>
    </div>
    <div class="mt-5">
        <?php include ("../footer.php"); ?>
    </div>
    <?php
    if (isset ($_SESSION['resultAddKnow'])) {
        $resultAddKnow = $_SESSION['resultAddKnow'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'เพิ่มข้อมูลสำเร็จ',
                        text: '" . $resultAddKnow . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
        unset($_SESSION['resultAddKnow']);
    }
    ?>
    <?php
    if (isset ($_SESSION['resultErrorKnow'])) {
        $resultErrorKnow = $_SESSION['resultErrorKnow'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: '" . $resultErrorKnow . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
        unset($_SESSION['resultErrorKnow']);
    }
    ?>
        <?php
    if (isset ($_SESSION['resultDeleteKnow'])) {
        $resultDeleteKnow = $_SESSION['resultDeleteKnow'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'ลบข้อมูลสำเร็จ',
                        text: '" . $resultDeleteKnow . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
        unset($_SESSION['resultDeleteKnow']);
    }
    ?>
</body>


</html>