<?php include "../server.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php //include("../header.php"); ?>
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Kanit', sans-serif;
        }

        body {
            padding-top: 6em;
        }

        .nav-pills li a:hover {
            background-color: #89adcf;
        }

        .hr-sidebar {
            margin: 0.2rem !important;
        }

        .sidebar {
            background-color: #6999C6;

        }

        #menu a.active {
            color: black !important;
            background-color: #bbd1e5;
        }
    </style>
</head>

<body>
    <?php include('nav-bar.php') ?>
    <div class="container-fluid menu-content">
        <div class="row">
            <div class="d-flex flex-column justify-content-between col-auto min-vh-100 sidebar position-fixed">
                <div class="mt-4">
                    <ul class="nav nav-pills flex-column mt-2 mt-sm-0" id="menu">
                        <li class="nav-item my-sm-1 my-2">
                            <a href="select_raw.php" class="nav-link text-white text-center text-sm-start menu-link" aria-current="page">
                            <i class="fa-solid fa-list-check"></i>
                                <span class="ms-2 d-none d-sm-inline">รายการวัตถุดิบ</span>
                            </a>
                        </li>
                        <hr class="text-white d-none d-sm-block hr-sidebar">
                        <li class="nav-item my-sm-1 my-2">
                            <a href="../calculate/feed.php" class="nav-link text-white text-center text-sm-start menu-link" aria-current="page">
                                <i class="fa-solid fa-square-root-variable"></i>
                                <span class="ms-2 d-none d-sm-inline">คำนวณโภชนะโค</span>
                            </a>
                        </li>
                        <hr class="text-white d-none d-sm-block hr-sidebar">
                        <li class="nav-item my-sm-1 my-2">
                            <a href="../calculate/cost.php" class="nav-link text-white text-center text-sm-start menu-link" aria-current="page">
                                <i class="fa-solid fa-sack-dollar"></i>
                                <span class="ms-2 d-none d-sm-inline">สูตรอาหารต้นทุนต่ำสุด</span>
                            </a>
                        </li>
                        <hr class="text-white d-none d-sm-block hr-sidebar">
                        <li class="nav-item my-sm-1 my-2">
                            <a href="../calculate/index_profit.php" class="nav-link text-white text-center text-sm-start menu-link" aria-current="page">
                                <i class="fa-solid fa-chart-column"></i>
                                <span class="ms-2 d-none d-sm-inline">คำนวณผลตอบแทน</span>
                            </a>
                        </li>
                        <hr class="text-white d-none d-sm-block hr-sidebar">
                        <li class="nav-item my-sm-1 my-2">
                            <a href="../calculate/repair.php" class="nav-link text-white text-center text-sm-start menu-link" aria-current="page">
                                <i class="fa-solid fa-sliders"></i>
                                <span class="ms-2 d-none d-sm-inline">ปรับปรุงสูตรอาหาร</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div> 
        </div>
    </div>
</body>

</html>