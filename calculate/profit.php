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
    <?php //include("../header.php"); ?>
	<link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <title>คำนวณผลตอบแทน</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Kanit', sans-serif;
        }

        .flex {
            display: flex;
        }

        .g-2 {
            flex: 1;
        }
        .content {
            padding: 3em;
            padding-left: 16em !important;
            width: 100%;
        }

        @media (max-width: 576px) {
            .content {
                padding-left: 7em !important;
            }
        }
    </style>

<body>
    <div class="flex">
        <div class="g-1">
            <?php include('sidebar.php') ?>
        </div>
        <div class="g-2">
            <div class="content">
                <!-- เนื้อหา -->
                <h2 class="text-center">คำนวณผลตอบแทน</h2>
                <form action="process_feed.php" method="post">
                    <div>
                        <label for="ingredient">วัตถุดิบ:</label>
                        <input type="text" class="form-control" name="ingredient" id="ingredient" required>
                    </div>
                    <div>
                        <label for="quantity">ปริมาณ:</label>
                        <input type="number" class="form-control" name="quantity" id="quantity" required>
                    </div>
                    <button type="submit" class="btn btn-success">คำนวณ</button>
                </form>
                <!-- เนื้อหา -->
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector("#menu a[href='profit.php']").classList.add("active");
        });
    </script>
</body>

</html>