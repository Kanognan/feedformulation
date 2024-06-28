<?php
session_start();
if (!isset ($_SESSION["acc_id"]) || $_SESSION["acc_id"] == "") {
    $resultNoSession = "เข้าสู่ระบบก่อนใช้งาน";
    $_SESSION['resultNoSession'] = $resultNoSession;
    echo "<script type='text/javascript'>";
    echo "window.location = '../login.php'; ";
    echo "</script>";
    exit();
    // ผู้ใช้งานทั่วไป
}
include "../server.php";
?>
<?php
ini_set('display_errors', 0);
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <title>เกี่ยวกับโค</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'kanit';
            /* color:black; */
        }

        .cow,
        .row .headcow {
            width: 75%;
            margin: 4em 20em;

        }

        .breed {
            text-align: center;
            padding: 0.2em 0em;
            /* width: 13em; */
            margin: 0.5em;
            border-radius: 15px;
            /* display: flex; */
        }

        .bg-del {
            background-color: #F8F9FA;
            box-shadow: 2px 3px 10px lightgray;
            margin: 3em 0.2em 0.5em 0.2em;
            border-radius: 10px;
            height: cover;
            padding: 0.5em;
            box-shadow: rgba(0, 0, 0, 0.07) 0px 1px 2px, rgba(0, 0, 0, 0.07) 0px 2px 4px, rgba(0, 0, 0, 0.07) 0px 4px 8px, rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.07) 0px 16px 32px, rgba(0, 0, 0, 0.07) 0px 32px 64px;
            transition: transform 250ms;
            /* width:25%; */

        }

        .card-img-top:hover {
            transform: translateY(-10px);
            cursor: pointer;

        }

        .card-img-top img {
            height: 100% !important;
            width: 100% !important;
        }

        img.card-img-top {
            border-radius: 20px !important;
            height: 13rem !important;
            width: 100% !important;
            overflow: hidden;
        }


        .card-text p {
            text-align: center;
            margin-top: 1.2em;
        }

        .col-3 #right {
            display: inline;
        }

        .add .btn {
            background-color: #4F80C0;
            color: white;
            width: 10.5em;
            padding: 0.5em;
            border-radius: 20px;
            font-size: 1em;
            margin: 0.5em 0.2em 2em 0.6em;

        }

        .add .btn:hover,
        .add .btn:focus,
        button[type=submit]:hover {
            background-color: #AACCE2;
            color: black;
        }

        .flex {
            display: flex;
        }

        .g-2 {
            flex: 1;
        }

        .content {
            padding: 3em;
            padding-left: 16em !important;
            width: 100%;
        }

        .else {
            text-align: center;
            font-size: 1.2em;
            padding-top: 4em;
        }
        @media (max-width: 576px) {
            .content {
                padding-left: 4.5em !important;
                padding-right: 1.5em !important;
            }

            .col-2 {
                display: none;
                width: 100%;
            }

            .g-2 {
                width: 90%;

            }

            .row .col-md-7 {
                text-align: center;
            }

            .row .col-md-5 {
                margin-left: 0;
            }

            .ser {
                margin-top: 10px;
            }

            .ser .col-9 {
                margin-bottom: 10px;
            }

            .second {
                margin-top: 10px;
            }

            .second .col-10,
            .second .col-2 {
                text-align: center;
            }

            .add .btn {
                width: 8.5em;
                margin-bottom: 1em;
                margin-left: 0;

            }

            .add {
                margin-top: 1em;
            }

            .bg-del {
                margin-top: 2em;
            }

            .btn-group {
                margin: 0 0.5em;
            }
			 .else {
            text-align: center;
            font-size: 1.2em;
            padding-top: 4em;
        }
        }
    </style>
</head>

<body>

    <?php
    $acc_id = $_SESSION['acc_id'];
    ?>
    <div class="flex">
        <div class="g-1">
            <?php include ('sidebar.php') ?>
        </div>
        <div class="g-2">
            <div class="content">
                <div class="row">
                    <div class="col-md-4">
                        <h3>ข้อมูลโค</h3>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-md-end justify-content-center flex-wrap">
                            <a href="group.php" class="add"><button type="button" class="btn">กลุ่มโค</button></a>
                            <a href="addcow.php" class="add"><button type="button"
                                    class="btn">เพิ่มข้อมูลโค</button></a>
                        </div>
                    </div>
                </div>
                <div class="row second">
                    <div class="col-md-6">
                        <form action="cow.php" method="post">
                            <div class="input-group">
                                <input class="form-control" type="text" name="search"
                                    placeholder="ป้อนรหัส/ชื่อโคที่ต้องการค้นหา">
                                <button type="submit" class="btn btn-primary">ค้นหา</button>
                            </div>
                        </form>
                    </div>
                    <?php
                    $sql = "SELECT * FROM cow WHERE acc_id = $acc_id AND deleteAt IS NULL";
                    // Check if the search query is submitted
                    if (isset ($_POST['search'])) {
                        $search_query = mysqli_real_escape_string($conn, $_POST['search']);
                        // Modify the SQL query to include the search condition
                        $sql .= " AND (cow.cow_id LIKE '%$search_query%' OR cow.cow_name LIKE '%$search_query%')";
                        echo "<p style='color:gray; margin-left:1em;'>ผลลัพธ์การค้นหาจาก : $search_query </p>";
                    }

                    $sql .= " ORDER BY createAt DESC";

                    $result = $conn->query($sql);

                    if (!$result) {
                        die ("Query failed: " . $conn->error);
                    }
                    ?>
                    <div class="col-md-6 col-sm-6 d-flex justify-content-end">
                        <span>มีข้อมูลทั้งหมด
                            <?php echo mysqli_num_rows($result) ?> รายการ
                        </span>
                    </div>
                </div>
               
                <div class="row">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <div class="col-12 col-lg-4 col-xl-3 col-md-6 col-sm-12 top">
                                <div class="bg-del">
                                    <div class="cow-border">
                                        <div class="x"
                                            onclick="window.location='index_infor_cow.php?id=<?php echo $row['cow_id']; ?>'">
                                            <img class="card-img-top" src="../pic/<?php echo $row["cow_img"]; ?>" />
                                            <div class="card-body">
                                                <div class="card-text">
                                                    <p><b>
                                                            <?php echo $row["cow_id"], "<br>" . $row["cow_name"], " "; ?>
                                                        </b></p>
                                                    <div class="breed" style="background-color:
                                    <?php
                                    $color = ($row["cow_breed_status"] === 'ตั้งท้อง') ? '#73C088' :
                                        (($row["cow_breed_status"] === 'รอตรวจท้อง') ? '#FBD741' :
                                            (($row["cow_breed_status"] === 'แท้ง') ? '#EA6D75' : '#9999CC'));
                                    echo $color;
                                    ?>;
                                    color: <?php echo ($row["cow_breed_status"] !== 'รอตรวจท้อง') ? 'white' : 'black'; ?>;
                                ">
                                                        <?php echo $row["cow_breed_status"]; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                        <div class="btn-group" role="group">
                                            <div onclick="window.location='edit_cow_modal.php?cow_id=<?php echo $row['cow_id']; ?>'"
                                                data-toggle="modal" class="btn btn-warning"><span
                                                    class="glyphicon glyphicon-edit"></span><img src="../pic/edit.png" alt=""
                                                    style="width:1em; height:15px; margin:5px" title="แก้ไขข้อมูลโค"></div>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#cowdel<?php echo $row['cow_id']; ?>">
                                                <span class="glyphicon glyphicon-trash"></span><img src="../pic/delete.png"
                                                    alt="" style="width:1em; height:15px; margin:5px" title="ลบข้อมูลโค">
                                            </button>
                                        </div>
                                        <?php include ('cow_update_model.php'); ?>
                                    </div>


                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<div class='else'><p>" . (isset ($search_query) ? "ไม่พบรายการค้นหาจาก : $search_query" : "ไม่มีรายการข้อมูลโค") . "</p></div>";
                    }
                    ?>
                </div>
            </div>
        </div>
</body>
<?php
if (isset ($_SESSION['resultData'])) {
    $resultData = $_SESSION['resultData'];
    echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'เพิ่มข้อมูลสำเร็จ',
                        text: '" . $resultData . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
    unset($_SESSION['resultData']);
}


if (isset ($_SESSION['editData'])) {
    $editData = $_SESSION['editData'];
    echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'แก้ไขข้อมูลสำเร็จ',
                        text: '" . $editData . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
    unset($_SESSION['editData']);
}
?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector("#menu a[href='cow.php']").classList.add("active");
    });
</script>

</html>