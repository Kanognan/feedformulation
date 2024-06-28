<?php 
include "../server.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
     		height: 100% !important;
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
                            <a href="cow.php" class="nav-link text-white text-center text-sm-start menu-link" aria-current="page">
                            <i class="fa-solid fa-cow"></i>
                                <span class="ms-2 d-none d-sm-inline">ข้อมูลทั่วไปของโค</span>
                            </a>
                        </li>
                        <hr class="text-white d-none d-sm-block hr-sidebar">
                        <li class="nav-item my-sm-1 my-2">
                            <a href="update_weight.php" class="nav-link text-white text-center text-sm-start menu-link" aria-current="page">
                            <i class="fa-solid fa-weight-scale"></i>
                                <span class="ms-2 d-none d-sm-inline">อัปเดตน้ำหนักของโค</span>
                            </a>
                        </li>
                        <hr class="text-white d-none d-sm-block hr-sidebar">
                        <li class="nav-item my-sm-1 my-2">
                            <a href="index_dianosis_cow.php" class="nav-link text-white text-center text-sm-start menu-link" aria-current="page">
                            <i class="fa-solid fa-suitcase-medical"></i>
                                <span class="ms-2 d-none d-sm-inline">การตรวจโรคประจำปี</span>
                            </a>
                        </li>
                        <hr class="text-white d-none d-sm-block hr-sidebar">
                        <li class="nav-item my-sm-1 my-2">
                            <a href="index_vaccine_cow.php" class="nav-link text-white text-center text-sm-start menu-link" aria-current="page">
                            <i class="fa-solid fa-syringe"></i>
                                <span class="ms-2 d-none d-sm-inline">การฉีดวัคซีน</span>
                            </a>
                        </li>
                        <hr class="text-white d-none d-sm-block hr-sidebar">
                        <li class="nav-item my-sm-1 my-2">
                            <a href="index_health_cow.php" class="nav-link text-white text-center text-sm-start menu-link" aria-current="page">
                            <i class="fa-solid fa-virus-covid"></i>
                                <span class="ms-2 d-none d-sm-inline">การเจ็บป่วยของโค</span>
                            </a>
                        </li>
                        <hr class="text-white d-none d-sm-block hr-sidebar">
                        <li class="nav-item my-sm-1 my-2">
                            <a href="index_breed_cow.php" class="nav-link text-white text-center text-sm-start menu-link" aria-current="page">
                            <i class="fa-solid fa-venus-mars"></i>
                                <span class="ms-2 d-none d-sm-inline">การผสมพันธุ์</span>
                            </a>
                        </li>
                        <hr class="text-white d-none d-sm-block hr-sidebar">
                        <li class="nav-item my-sm-1 my-2">
                            <a href="index_milk_cow.php" class="nav-link text-white text-center text-sm-start menu-link" aria-current="page">
                            <i class="fa-solid fa-bottle-droplet"></i>
                                <span class="ms-2 d-none d-sm-inline">ผลผลิตของโค</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div> 
        </div>
    </div>
</body>
</html>