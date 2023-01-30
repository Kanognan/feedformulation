<?php
session_start();
include('../server.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
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
            /* padding: 0 !important; */
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
            /* margin-left: 1rem; */
            border-radius: 2rem;
        }

        .right {
            background-color: #DBEDF2;
            /* margin-right: 1rem; */
            margin-left: 1rem;
            border-radius: 2rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="container mt-4 d-flex justify-content-center">
            <div class="row g-0 crad-content ">
                <div class="row col-md-3 left">
                    <div class="col-md-12 border-left content">
                        <div class="cards">
                            <div class="first p-4 text-center">
                                <img src="../Images/add-posts.png" style="width: 5rem;" />
                                <h5>เพิ่มกระทู้</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row col-md-9 right">
                    <div class="col-md-3 border-right content" onclick="javascript:window.location.href='../index.php'">
                        <div class="cards">
                            <div class=" second p-4 text-center">
                                <img src="../Images/raise-cow.png" style="width: 5rem;" />
                                <h5>การเลี้ยงโค</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 content ">
                        <div class="cards">
                            <div class=" third p-4 text-center">
                                <img src="../Images/milk-storage.png" style="width: 5rem;" />
                                <h5>การเก็บนม</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 content ">
                        <div class="cards">
                            <div class=" third p-4 text-center">
                                <img src="../Images/cow-breed.png" style="width: 5rem;" />
                                <h5>การผสมพันธุ์</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 content ">
                        <div class="cards">
                            <div class=" third p-4 text-center">
                                <img src="../Images/milk-process.png" style="width: 5rem;" />
                                <h5>การแปรรูปผลผลิต</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</body>

</html>