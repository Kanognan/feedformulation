<?php
include("../server.php");
$acc_id = $_SESSION['acc_id'];
$user_status = $_SESSION['user_status'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php include("../header.php"); ?>
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
            border-radius: 20px;
            font-size: 1em;
        }

        .hnav li a:hover,
        .hnav a:hover {
            color: #46739C;
            background-color: white;
        }

        .dropdown .btn2 {
            background-color: white;
            color: #46739C;
            width: 100%;
            font-size: 1em;
            padding: 0.5em;
        }

        .dropdown .btn2:hover,
        .dropdown .btn2:focus {
            background-color: #b1bfcc;
            color: white;
        }

        .btn-group .btn1,
        .btn-group .btn1:active {
            border-color: transparent !important;
        }

        .dropa a {
            color: black !important;
        }

        .dropa a:hover {
            color: white !important;
        }

        .hr1 {
            margin: 0;
        }

        .dropdown-pro {
            padding: 0;
        }

        .btn1 img {
            width: 3em !important;
            height: 3em !important;
            border-radius: 50%;
            object-fit: cover;
        }
        ul.dropdown-menu.dropdown-pro.show {
            padding: 0px !important;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg p-3 fixed-top ">
        <div class="container hnav">
            <img src="../Images/logo.png" alt="logo" style="width: 5rem; height: 5rem;">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse align-self-center navdrop" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <?php
                        if ($user_status === 'Expert') { ?>
                            <a class="nav-link mx-2" aria-current="page" href="../expert/expert_index.php">หน้าหลัก</a>
                        <?php } elseif ($user_status === 'Admin') { ?>
                            <a class="nav-link mx-2" aria-current="page" href="../admin/admin_index.php">หน้าหลัก</a>
                        <?php } else { ?>
                            <a class="nav-link mx-2" aria-current="page" href="../user/user_index.php">หน้าหลัก</a>
                        <?php }
                        ?>
                    </li>
                    <li class="nav-item">
                        <?php
                        if ($user_status === 'Expert') { ?>
                            <a class="nav-link mx-2" href="../news/expert-news.php">ข่าวสาร</a>
                        <?php } elseif ($user_status === 'Admin') { ?>
                            <a class="nav-link mx-2" href="../news/expert-news.php">ข่าวสาร</a>
                        <?php } else { ?>
                            <a class="nav-link mx-2" href="../news/user-news.php">ข่าวสาร</a>
                        <?php }
                        ?>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="../raw/select_raw.php">คำนวณ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="../raw/all_nutrition.php">คลังวัตถุดิบ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="../cow/cow.php">เกี่ยวกับโค</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-2" href="../posts/home-webboard.php">กระทู้</a>
                    </li>
                    <li class="nav-item">
                        <?php
                        if ($user_status === 'Expert') { ?>
                            <a class="nav-link mx-2" href="../email/index.php">ติดต่อเรา</a>
                        <?php } elseif ($user_status === 'Admin') { ?>
                            <a class="nav-link mx-2" href="../email/index.php" style="display:none;">ติดต่อเรา</a>
                        <?php } else { ?>
                            <a class="nav-link mx-2" href="../email/index.php">ติดต่อเรา</a>
                        <?php }
                        ?>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <div class="btn-group">
                        <?php
                        if (isset($_SESSION['acc_id'])) {

                            $sql = "SELECT * FROM account WHERE acc_id = $acc_id";
                            $result = $conn->query($sql);

                            if ($result && $result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $acc_image = $row["acc_image"];

                                if ($acc_image) {
                                    echo "<div class='btn1' type='button' data-bs-toggle='dropdown' aria-expanded='false'>";
                                    echo "<img src='../pic/$acc_image' alt='profile image'>";
                                    echo "</div>";
                                } else {
                                    echo "<div class='btn1' type='button' data-bs-toggle='dropdown' aria-expanded='false'>";
                                    echo "<img src='../pic/profile.jpg' alt='default profile image'>";
                                    echo "</div>";
                                }

                                // ตรวจสอบสถานะของผู้ใช้
                                if (isset($_SESSION['user_status'])) {
                                    if ($user_status == 'Admin') {
                                        echo '<ul class="dropdown-menu dropdown-pro">';
                                        echo '<li class="nav-item dropdown">';
                                        echo '<button type="button" class="btn btn2" onclick="document.location=\'../admin/profile.php\'">โปรไฟล์</button>';
                                        echo '</li>';
                                        echo '<hr class="hr1">';
                                        echo '<li class="nav-item dropdown">';
                                        echo '<button type="button" class="btn btn2" onclick="document.location=\'../logout.php\'">ออกจากระบบ</button>';
                                        echo '</li>';
                                        echo '</ul>';
                                    } elseif ($user_status == 'User') {
                                        echo '<ul class="dropdown-menu dropdown-pro">';
                                        echo '<li class="nav-item dropdown">';
                                        echo '<button type="button" class="btn btn2" onclick="document.location=\'../user/profile.php\'">โปรไฟล์</button>';
                                        echo '</li>';
                                        echo '<hr class="hr1">';
                                        echo '<li class="nav-item dropdown">';
                                        echo '<button type="button" class="btn btn2" onclick="document.location=\'../logout.php\'">ออกจากระบบ</button>';
                                        echo '</li>';
                                        echo '</ul>';
                                    } elseif ($user_status == 'Expert') {
                                        echo '<ul class="dropdown-menu dropdown-pro">';
                                        echo '<li class="nav-item dropdown">';
                                        echo '<button type="button" class="btn btn2" onclick="document.location=\'../expert/profile.php\'">โปรไฟล์</button>';
                                        echo '</li>';
                                        echo '<hr class="hr1">';
                                        echo '<li class="nav-item dropdown">';
                                        echo '<button type="button" class="btn btn2" onclick="document.location=\'../logout.php\'">ออกจากระบบ</button>';
                                        echo '</li>';
                                        echo '</ul>';
                                    } else {
                                        echo 'สถานะไม่ถูกต้อง';
                                    }
                                }
                            } else {
                                echo "ไม่พบข้อมูลผู้ใช้";
                            }
                        } else {
                            echo "<div class='btn1' type='button' data-bs-toggle='dropdown' aria-expanded='false'>";
                            echo "<img src='../pic/profile.jpg' alt='default profile image'>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </ul>
            </div>
        </div>
    </nav>
</body>

</html>