<?php
session_start();
require_once('server.php');
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Kanit';
        }

        body {
            padding-top: 6.5em;
        }

        .imghead {
            height: 20rem;
            position: relative;
            overflow: hidden;
        }

        .imghead img {
            height: 20rem;
            width: 100%;
            object-fit: cover;
            filter: blur(2px);
        }

        .imghead h1 {
            position: absolute;
            color: white;
            top: 40%;
            text-align: center;
            font-weight: bold;
            width: 100%;
            text-shadow: -1px 1px 6px rgba(0, 0, 0, 0.79);
        }

        .content-img img {
            width: 35em;
            display: block;
            margin: auto auto;
        }

        .topic h2 {
            margin: 2em 0em;
            text-align: center;
            font-weight: bold;
        }

        .detail p {
            margin: 2em 10em;
            font-size: 1.3em;
        }
    </style>
</head>

<body>
    <?php include("nav-bar.php"); ?>
    <?php
    $news_id = $_GET['news_id'];
    $query = mysqli_query($conn, "select * from news WHERE news_id = $news_id");
    $result = mysqli_fetch_assoc($query);
    ?>
    <div class="imghead">
        <img src="Images/news-head.jpg" alt="room" class="img">
        <h1>
            ข่าวสาร
        </h1>
    </div>
    <div class="container">
        <div class="content">
            <div class="topic">
                <h2>
                    <?php echo $result['news_topic']; ?>
                </h2>
            </div>
            <div class="content-img">
                <img src="pic/<?php echo $result['news_img']; ?>" alt="">
            </div>

            <div class="detail">
                <p>
                    <?php echo $result['news_detail']; ?>
                </p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
        integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD"
        crossorigin="anonymous"></script>
</body>

</html>