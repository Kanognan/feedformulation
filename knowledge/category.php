<?php
session_start();
if (!isset($_SESSION["acc_id"]) || $_SESSION["acc_id"] == "") {
    $resultNoSession = "เข้าสู่ระบบก่อนใช้งาน";
    $_SESSION['resultNoSession'] = $resultNoSession;
    echo "<script type='text/javascript'>";
    echo "window.location = '../login.php'; ";
    echo "</script>";
    exit();
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
            box-sizing: border-box;
            font-family: 'Kanit', sans-serif;
        }

        .menu {
            padding: 1em;
            width: 11em;
            color: #3c66ac;
            background-color: white;
            margin: 1em;
            border: 2px solid #3c66ac;
            box-shadow: rgba(50, 50, 105, 0.15) 0px 2px 5px 0px, rgba(0, 0, 0, 0.05) 0px 1px 1px 0px;
            cursor: pointer;
        }

        .menu h6 {
            margin: 0px !important;
            text-align: center;
        }

        .active {
            background-color: #3c66ac !important;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="mt-4 d-flex justify-content-center">
            <div class="row d-flex justify-content-center">
                <?php if ($_SESSION['user_status'] == 'Admin' || $_SESSION['user_status'] == 'Expert') : ?>
                    <div class="col-6 col-sm-4 col-md-2 menu add_knowledge <?php echo (basename($_SERVER['REQUEST_URI']) == 'add_knowledge.php') ? 'active' : ''; ?>"
                        onclick="window.location.href='add_knowledge.php'">
                        <h6><i class="bi bi-plus"></i> เพิ่มความรู้</h6>
                    </div>
                <?php endif; ?>
                <div class="col-6 col-sm-4 col-md-2 menu <?php echo (basename($_SERVER['REQUEST_URI']) == 'knowledge.php') ? 'active' : ''; ?>"
                    onclick="window.location.href='knowledge.php'">
                    <h6>ทั้งหมด</h6>
                </div>
                <div class="col-6 col-sm-4 col-md-2 menu <?php echo (basename($_SERVER['REQUEST_URI']) == 'knowledge_feed.php') ? 'active' : ''; ?>"
                    onclick="window.location.href='knowledge_feed.php'">
                    <h6>การให้อาหาร</h6>
                </div>
                <div class="col-6 col-sm-4 col-md-2 menu <?php echo (basename($_SERVER['REQUEST_URI']) == 'knowledge_breed.php') ? 'active' : ''; ?>"
                    onclick="window.location.href='knowledge_breed.php'">
                    <h6>พันธุ์โคนม</h6>
                </div>
                <div class="col-6 col-sm-4 col-md-2 menu <?php echo (basename($_SERVER['REQUEST_URI']) == 'knowledge_diease.php') ? 'active' : ''; ?>"
                    onclick="window.location.href='knowledge_diease.php'">
                    <h6>โรคในโคนม</h6>
                </div>
                <div class="col-6 col-sm-4 col-md-2 menu <?php echo (basename($_SERVER['REQUEST_URI']) == 'knowledge_milk.php') ? 'active' : ''; ?>"
                    onclick="window.location.href='knowledge_milk.php'">
                    <h6>ราคานมโค</h6>
                </div>

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
