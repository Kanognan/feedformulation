<?php
session_start();

// if (!isset($_SESSION['username'])) {
//     $_SESSION['msg'] = "You must log in first";
//     header('location: login.php');
// }

// if (isset($_GET['logout'])) {
//     session_destroy();
//     unset($_SESSION['username']);
//     header('location: login.php');
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- 
    <link rel="stylesheet" href="style.css"> -->
    <style>
        body {
            /* height: 1000rem; */
        }

        .heading {
            font-size: 20px;
            font-weight: 600;
            color: #3D5AFE;
        }

        .crad-content {
            width: 250rem;
        }

        .content {
            /* background-color: #e9ecef; */

        }

        .cards {
            transition: all 0.2s ease;
            cursor: pointer;
            margin-top: 7rem;
            margin-bottom: 7rem;
        }

        .cards:hover {
            box-shadow: 5px 6px 6px 2px gray;
            background-color: #d5e6fc;
            transform: scale(1.1);
            border-radius: 2rem;
        }
    </style>
</head>

<body>

    <?php include("nav-user.php") ?>
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://www.fossanalytics.com/-/media/images/segments/raw-milk-testing/articletop/cows-1480x550.jpg"
                    class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://www.fossanalytics.com/-/media/images/segments/raw-milk-testing/articletop/cows-1480x550.jpg"
                    class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="https://www.fossanalytics.com/-/media/images/segments/raw-milk-testing/articletop/cows-1480x550.jpg"
                    class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container mt-4 d-flex justify-content-center">
        <div class="row g-0 crad-content ">
            <div class="col-md-4 border-right content">
                <div class="cards">
                    <div class="first p-4 text-center">
                        <img src="Images/Test.png" style="width: 8rem;" />
                        <h5>ข่าวสารทั้งหมด</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 border-right content">
                <div class="cards">
                    <div class="second p-4 text-center">
                        <img src="Images/Test.png" style="width: 8rem;" />
                        <h5>ราคาวัตถุดิบ</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 content ">
                <div class="cards">
                    <div class="third p-4 text-center">
                        <img src="Images/Test.png" style="width: 8rem;" />
                        <h5>ความรู้ / เทคนิค</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <hr>
        <div>
            <h1>ข่าวสารที่น่าสนใจ</h1>
        </div>
    </div>
    <div class="homecontent">
        <!--  notification message -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="success">
                <h3>
                    <?php
                    // echo $_SESSION['success'];
                    // unset($_SESSION['success']);
                    ?>
                </h3>
            </div>
        <?php endif ?>

        <!-- logged in user information -->
        <?php if (isset($_SESSION['username'])): ?>
            <p>Welcome <strong>
                    <?php echo $_SESSION['username']; ?>
                </strong></p>
            <p><a href="index.php?logout='1'" style="color: red;">Logout</a></p>
        <?php endif ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>

</body>

</html>