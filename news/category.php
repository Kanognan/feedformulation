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
   
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .category {
            margin-left: 1.4rem;
            margin-right: 1.4rem;
            border-radius: 2em;
            border: 2px solid #6999C8;
            box-shadow: 5px 6px 6px 2px lightgray;
        }

        .category-content {
            margin-left: 1em;
            cursor: pointer;
            text-align: center;
            margin: 0 auto;
            color: #6999C6;
            font-weight: 600;
            padding-top: 1em;
            padding-bottom: 1em;
        }

        .category-content:hover {
            box-shadow: 5px 6px 6px 2px gray;
            background-color: #3c66ac;
            padding: 1em;
            color: #fff;
            border-radius: 2em;
        }

        .active-category {
            background-color: #3c66ac;
            color: #fff;
            border-radius: 2em;
        }
        @media (max-width: 990px) {
            .category {
            margin-left: 1.4rem;
            margin-right: 1.4rem;
            border-radius: 2em;
            border: none;
           
        }
      
        .category-content {
           
            cursor: pointer;
            text-align: center;
            margin: 0.5em 1em;
            color: #6999C6;
            font-weight: 600;
            padding-top: 1em;
            padding-bottom: 1em;
            border: 1px solid #3c66ac;
            border-radius:2em;
        }

        .category-content:hover {
            box-shadow: 5px 6px 6px 2px gray;
            background-color: #3c66ac;
            padding: 1em;
            color: #fff;
            border-radius: 2em;
        }

        .active-category {
            background-color: #3c66ac;
            color: #fff;
            border-radius: 2em;
        }
        }

    </style>
</head>

<body>
   <div class="container">
    <div class="row category">
        <div class="col-md col-sm-3 col-11 category-content <?php echo basename($_SERVER['PHP_SELF']) == 'expert-news.php' ? 'active-category' : ''; ?>"
            onclick="javascript:window.location.href='expert-news.php'">
            ทั้งหมด
        </div>
        <div class="col-md col-sm-3 col-11 category-content <?php echo basename($_SERVER['PHP_SELF']) == 'expert-news_research.php' ? 'active-category' : ''; ?>"
            onclick="javascript:window.location.href='expert-news_research.php'">
            ทั่วไป
        </div>
        <div class="col-md col-sm-3 col-11 category-content <?php echo basename($_SERVER['PHP_SELF']) == 'expert-news_techmilk.php' ? 'active-category' : ''; ?>"
            onclick="javascript:window.location.href='expert-news_techmilk.php'">
            งานวิจัยและเทคโนโลยี
        </div>
        <div class="col-md col-sm-3 col-11 category-content <?php echo basename($_SERVER['PHP_SELF']) == 'expert-news_dna.php' ? 'active-category' : ''; ?>"
            onclick="javascript:window.location.href='expert-news_dna.php'">
            พันธุกรรม/สายพันธุ์
        </div>
        <div class="col-md col-sm-3 col-11 category-content <?php echo basename($_SERVER['PHP_SELF']) == 'expert-news_pricemilk.php' ? 'active-category' : ''; ?>"
            onclick="javascript:window.location.href='expert-news_pricemilk.php'">
            ราคานมโค
        </div>
        <div class="col-md col-sm-3 col-11 category-content <?php echo basename($_SERVER['PHP_SELF']) == 'expert-news_disease.php' ? 'active-category' : ''; ?>"
            onclick="javascript:window.location.href='expert-news_disease.php'">
            โรคระบาดในโคนม
        </div>
        <div class="col-md col-sm-3 col-11 category-content <?php echo basename($_SERVER['PHP_SELF']) == 'expert-news_importcow.php' ? 'active-category' : ''; ?>"
            onclick="javascript:window.location.href='expert-news_importcow.php'">
            นำเข้า/ส่งออกโคนม
        </div>
    </div>
</div>

</body>

</html>
