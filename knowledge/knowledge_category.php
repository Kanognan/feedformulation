<?php
// session_start();
include('../server.php');
include("../session/user_session.php");
$acc_id = $_SESSION['acc_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .crad-content {
            width: 100%;
        }


        .cards {
            transition: all 0.2s ease;
            cursor: pointer;
            background-color: #DBEDF2;
            border-radius: 1rem;
        }

        .cards:hover {
            box-shadow: 5px 6px 6px 2px gray;
            background-color: #fff;
            transform: scale(1.1);
            border-radius: 1rem;
        }

        .left .content,
        .right .content {
            padding: 0 !important;
        }

        .left .content {
            background-color: #DBEDF2;
            border-radius: 1rem;
        }
        .right {
            background-color: #DBEDF2;
            margin-left: 0.1rem;
            border-radius: 1rem;
        }
        .content h6{
            margin: 0px !important;
        }
        .row .left{
            margin-left: 0px !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="container mt-4 d-flex justify-content-center">
            <div class="row g-0 crad-content ">
                <div class="row col-md-2 left">
                    <div class="col-md-12 border-left content"
                        onclick="window.location.href='add_knowledge.php'">
                        <div class="cards">
                            <div class="first p-4 text-center">
                                <h6>เพิ่มความรู้</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row col-md-2 left">
                    <div class="col-md-12 border-left content"
                        onclick="window.location.href='knowledge.php'">
                        <div class="cards">
                            <div class="first p-4 text-center">
                                <h6>ทั้งหมด</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row col-md-8 right">
                    <div class="col-md-3 border-right content" onclick="window.location.href='knowledge_feed.php'">
                        <div class="cards">
                            <div class=" second p-4 text-center">
                                <h6>การให้อาหาร</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 content " onclick="window.location.href='knowledge_breed.php'">
                        <div class="cards">
                            <div class=" third p-4 text-center" >
                                <h6>พันธุ์โคนม</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 content " onclick="window.location.href='knowledge_diease.php'">
                        <div class="cards">
                            <div class=" third p-4 text-center" >
                                <h6>โรคในโคนม</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 content " onclick="window.location.href='knowledge_milk.php'">
                        <div class="cards">
                            <div class=" third p-4 text-center">
                                <h6>ราคานมโค</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>