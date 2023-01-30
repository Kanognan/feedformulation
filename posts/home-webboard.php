<?php
// session_start();
include('../server.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .content-posts {
            background-color: #DBEDF2;
            margin: 2rem 1rem;
        }

        .h2-title {
            background-color: #6999C6;
            color: white;
            padding: 1rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php include("nav-category.php") ?>
        <!----------------------------------------------------------------->
        <div class="content-posts">
            <h2 class="h2-title">การเลี้ยงโค</h2>
            <div class="posts">
                <div class="d-flex justify-content-center post">
                    <div class="card mb-3" style="width: 80%">
                        <div class="row g-0 content-center">
                            <div class="col-md-4">
                                <img src="https://media.4-paws.org/e/8/2/7/e82789b9dc8a986d3b61c0aa7610affeecb93933/VIER%20PFOTEN_2015-04-27_010-1927x1333.jpg"
                                    class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">This is a wider card with supporting text below as a natural
                                        lead-in to
                                        additional content. This content is a little bit longer.</p>
                                    <h6>ชื่อผู้โพส</h6>
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex justify-content-start">
                                            <p class="card-text">
                                                <small class="text-muted">โพสเมื่อ 15/01/2566</small>
                                            </p>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <p class="card-text">
                                                <small class="text-muted">7 Comment</small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="posts">
                <div class="d-flex justify-content-center post">
                    <div class="card mb-3" style="width: 80%">
                        <div class="row g-0 content-center">
                            <div class="col-md-4">
                                <img src="https://media.4-paws.org/e/8/2/7/e82789b9dc8a986d3b61c0aa7610affeecb93933/VIER%20PFOTEN_2015-04-27_010-1927x1333.jpg"
                                    class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">This is a wider card with supporting text below as a natural
                                        lead-in to
                                        additional content. This content is a little bit longer.</p>
                                    <h6>ชื่อผู้โพส</h6>
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex justify-content-start">
                                            <p class="card-text">
                                                <small class="text-muted">โพสเมื่อ 15/01/2566</small>
                                            </p>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <p class="card-text">
                                                <small class="text-muted">7 Comment</small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!----------------------------------------------------------------->
        <hr>
        <!----------------------------------------------------------------->
        <div class="content-posts">
            <h2 class="h2-title">การเลี้ยงโค</h2>
            <div class="posts">
                <div class="d-flex justify-content-center post">
                    <div class="card mb-3" style="width: 80%">
                        <div class="row g-0 content-center">
                            <div class="col-md-4">
                                <img src="https://media.4-paws.org/e/8/2/7/e82789b9dc8a986d3b61c0aa7610affeecb93933/VIER%20PFOTEN_2015-04-27_010-1927x1333.jpg"
                                    class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">This is a wider card with supporting text below as a natural
                                        lead-in to
                                        additional content. This content is a little bit longer.</p>
                                    <h6>ชื่อผู้โพส</h6>
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex justify-content-start">
                                            <p class="card-text">
                                                <small class="text-muted">โพสเมื่อ 15/01/2566</small>
                                            </p>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <p class="card-text">
                                                <small class="text-muted">7 Comment</small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="posts">
                <div class="d-flex justify-content-center post">
                    <div class="card mb-3" style="width: 80%">
                        <div class="row g-0 content-center">
                            <div class="col-md-4">
                                <img src="https://media.4-paws.org/e/8/2/7/e82789b9dc8a986d3b61c0aa7610affeecb93933/VIER%20PFOTEN_2015-04-27_010-1927x1333.jpg"
                                    class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">This is a wider card with supporting text below as a natural
                                        lead-in to
                                        additional content. This content is a little bit longer.</p>
                                    <h6>ชื่อผู้โพส</h6>
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex justify-content-start">
                                            <p class="card-text">
                                                <small class="text-muted">โพสเมื่อ 15/01/2566</small>
                                            </p>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <p class="card-text">
                                                <small class="text-muted">7 Comment</small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!----------------------------------------------------------------->
    </div>



    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</body>

</html>