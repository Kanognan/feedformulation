<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
    <title>Index</title>
    <style>
        @import url(https://unpkg.com/@webpixels/css@1.0/dist/index.css);
        @import url('https://fonts.googleapis.com/css2?family=Kanit&display=swap');

        * {
            font-family: 'Kanit', sans-serif;
        }

        .navbar-nav a {
            width: 7rem;
            text-align: center;
            box-shadow: inset 0 0 0 0 #fff;
            color: #fff !important;
            border-radius: 10rem !important;
            transition: color 3s ease-in-out, box-shadow 3s ease-in-out;
        }

        .navbar-nav a:hover {
            color: #46739C !important;
            border-radius: 10rem !important;
            box-shadow: inset 150px 0 0 0 #fff;
            ;
        }
        .navbar-nav a:active {
            color: #46739C !important;
            border-radius: 10rem !important;
            box-shadow: inset 150px 0 0 0 rgba(255, 255, 255, 0.581);
            ;
        }

        /* Presentational styles */
        .navbar-nav a {
            color: #46739C;
            font-size: 27rem;
            font-weight: 700;
            line-height: 1.5;
            border-radius: 10rem !important;
            text-decoration: none;
        }
        .test{
            position: relative;
            align-items: center;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg px-0 py-3" style="background-color:#46739C ;">
            <div class="container-xl">
                <!-- Logo -->
                <a class="navbar-brand" href="#">
                    <img src="Images/logo.png" class="" alt="..." style="width: 5rem; height: 5rem;">
                </a>
                <!-- Navbar toggle -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Collapse -->
                <div class="collapse navbar-collapse " id="navbarCollapse">
                    <!-- Nav -->
                    <div class="navbar-nav mx-lg-auto test">
                        <a class="nav-item nav-link  active" href="#" aria-current="page">หน้าหลัก</a>
                        <a class="nav-item nav-link " href="#">คำนวณ</a>
                        <a class="nav-item nav-link " href="#">คลังวัตถุดิบ</a>
                        <a class="nav-item nav-link " href="#">เกี่ยวกับโค</a>
                        <a class="nav-item nav-link " href="#">กระทู้</a>
                        <a class="nav-item nav-link " href="#">ติดต่อเรา</a>
                    </div>
                    <!-- Right navigation -->
                    <div class="navbar-nav ms-lg-4 test">
                        <a class="nav-item nav-link text-light " href="#">ลงทะเบียน</a>
                        <a class="nav-item nav-link text-light " href="#">เข้าสู่ระบบ</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>

</body>

</html>