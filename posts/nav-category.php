<?php
include ('../server.php');
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

        .content {
            padding: 0 !important;
        }

        .cards {
            transition: all 0.2s ease;
            cursor: pointer;
            background-color: #DBEDF2;
            border-radius: 2rem;
        }

        .cards:hover {
            box-shadow: 5px 6px 6px 2px gray;
            background-color: #fff;
            transform: scale(1.1);
            border-radius: 2rem;
        }

        .left .content,
        .right .content {
            padding: 0 !important;
        }

        .left .content {
            background-color: #DBEDF2;
            margin-right: 1rem;
            border-radius: 2rem;
        }

        .right {
            background-color: #DBEDF2;
            margin-left: 1rem;
            border-radius: 2rem;
        }

        .cards h6 {
            margin-top: 1rem;
        }

        @media (max-width: 768px) {
            .crad-content {
                width: 100%;
            }


            .cards {
                transition: all 0.2s ease;
                cursor: pointer;
                border-radius: 2rem;
            }

            .left {
                margin-left: 0.2em;
                width: 100%;
            }

            .right {
                background: none !important;
                margin: 0 auto;
                width: 100%;
                border-radius: 2rem;
            }

            .first img {
                width: 2em !important;
            }

            .second img,
            .third img {
                width: 2em !important;
            }

            .second,
            .third {
                margin-top: 0.8em;
            }

            .navPosts {
                background-color: #DBEDF2;
                padding: 0.5em !important;
                border-radius: 15px;
                box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
                flex-direction: column;
                align-items: flex-start;
                text-align: left;
                height: 5.5em;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .navPosts img{
                padding-top: 0.6em;
            }

            .navPosts h6 {
                margin: 0;
            }
        }

        .cards h6 {
            margin-top: 0;
        }

    </style>
</head>

<body>
    <div class="container">
        <div class="container mt-4 d-flex justify-content-center">
            <div class="row g-0 crad-content ">
                <div class="row col-md-3 left">
                    <div class="col-md-12 border-left content" onclick="window.location.href='new-posts.php'">
                        <div class="cards">
                            <div class="first p-3 text-center navPosts">
                                <img src="../Images/add-posts.png" style="width: 4rem;" />
                                <h6>เพิ่มกระทู้</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row col-md-9 right">
                    <div class="col-6 col-sm-6 col-md-3 border-right content"
                        onclick="window.location.href='home-webboard-cat1.php'">
                        <div class="cards">
                            <div class=" second p-3 text-center navPosts">
                                <img src="../Images/raise-cow.png" style="width: 4rem;" />
                                <h6>การเลี้ยงโค</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-3 content ">
                        <div class="cards">
                            <div class=" third p-3 text-center navPosts"
                                onclick="window.location.href='home-webboard-cat2.php'">
                                <img src="../Images/milk-storage.png" style="width: 4rem;" />
                                <h6>การรีดนม</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-3 content ">
                        <div class="cards">
                            <div class=" third p-3 text-center navPosts"
                                onclick="window.location.href='home-webboard-cat3.php'">
                                <img src="../Images/cow-breed.png" style="width: 4rem;" />
                                <h6>การผสมพันธุ์</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 col-md-3 content ">
                        <div class="cards">
                            <div class=" third p-3 text-center navPosts" style="overflow: hidden;"
                                onclick="window.location.href='home-webboard-cat4.php'">
                                <img src="../Images/milk-process.png" style="width: 4rem;" />
                                <h6>การแปรรูปผลผลิต</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>