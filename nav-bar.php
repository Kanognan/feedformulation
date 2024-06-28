<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php include('header.php'); ?>
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Kanit';
        }

        nav {
            background-color: #46739C;

        }

        .hnav li a,
        .hnav a {
            color: white;
            /* width: 9em; */
            /* text-align: center; */
            border-radius: 20px;
            font-size: 1em;


        }

        .hnav li a:hover,
        .hnav a:hover {
            color: #46739C;
            background-color: white;
        }

        .dropdown .btn {
            background-color: white;
            color: #46739C;
            width: 6em;
            border-radius: 20px !important;
            font-size: 1em;
            margin: 0.2em;
        }

        .dropdown .btn:hover,
        .dropdown .btn:focus {
            background-color: #b1bfcc;
            color: white;
        }

        .dropa a {
            color: black !important;
        }

        .dropa a:hover {
            color: white !important;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg p-3 fixed-top ">
        <div class="container hnav">
            <img src="Images/logo.png" alt="logo" style="width: 5rem; height: 5rem;">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse align-self-center navdrop" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link mx-2" aria-current="page" href="index.php">หน้าหลัก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="news/user-news.php">ข่าวสาร</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="raw/select_raw.php">คำนวณ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="raw/all_nutrition.php">คลังวัตถุดิบ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="cow/cow.php">เกี่ยวกับโค</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="posts/home-webboard.php">กระทู้</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="email/index.php">ติดต่อเรา</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <button type="button" class="btn"
                            onclick="document.location='select_user_type.php'">ลงทะเบียน</button>
                    </li>
                    <li class="nav-item dropdown">
                        <button type="button" class="btn" onclick="document.location='login.php'">เข้าสู่ระบบ</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


</body>

</html>