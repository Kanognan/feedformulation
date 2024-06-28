<?php
session_start();
if (!isset($_SESSION["acc_id"]) || $_SESSION["acc_id"] == "") {
    $resultNoSession = "เข้าสู่ระบบก่อนใช้งาน";
    $_SESSION['resultNoSession'] = $resultNoSession;
    echo "<script type='text/javascript'>";
    echo "window.location = '../login.php'; ";
    echo "</script>";
    exit();
    // ผู้ใช้งานทั่วไป
}

require_once('../server.php');
function fetchRawMaterialOptions($conn)
{
    $sql_price_raw_ids = "SELECT raw_id FROM price";
    $result_price_raw_ids = $conn->query($sql_price_raw_ids);

    $price_raw_ids = array();
    while ($row_price_raw_ids = $result_price_raw_ids->fetch_assoc()) {
        $price_raw_ids[] = $row_price_raw_ids["raw_id"];
    }

    $sql_price_ms_ids = "SELECT ms_id FROM price_ms";
    $result_price_ms_ids = $conn->query($sql_price_ms_ids);

    $price_ms_ids = array();
    while ($row_price_ms_ids = $result_price_ms_ids->fetch_assoc()) {
        $price_ms_ids[] = $row_price_ms_ids["ms_id"];
    }

    $options = '';
    $sql_raw_material = "SELECT raw_id, raw_thainame FROM raw_material";
    $sql_mineral_source = "SELECT ms_id, ms_thainame FROM mineral_source_raw";

    $result_raw_material = $conn->query($sql_raw_material);
    $result_mineral_source = $conn->query($sql_mineral_source);

    // เก็บ ms_id ที่มีอยู่ในตาราง price_ms
    $existing_ms_ids = array();
    foreach ($result_price_ms_ids as $row_price_ms_ids) {
        $existing_ms_ids[] = $row_price_ms_ids["ms_id"];
    }

    while ($row_raw_material = $result_raw_material->fetch_assoc()) {
        $raw_id = $row_raw_material["raw_id"];
        $raw_thainame = $row_raw_material["raw_thainame"];

        if (!in_array($raw_id, $price_raw_ids) && !in_array($raw_id, $price_ms_ids)) {
            $options .= "<option value=\"$raw_id\">$raw_thainame</option>";
        }
    }

    // เพิ่ม ms_id ที่มีอยู่ในตาราง mineral_source_raw
    while ($row_mineral_source = $result_mineral_source->fetch_assoc()) {
        $ms_id = $row_mineral_source["ms_id"];
        $ms_thainame = $row_mineral_source["ms_thainame"];

        if (!in_array($ms_id, $existing_ms_ids)) {
            $options .= "<option value=\"$ms_id\">$ms_thainame</option>";
        }
    }

    echo $options;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ราคาวัตถุดิบ</title>
	<link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Kanit', sans-serif;
        }

        body {
            padding-top: 10em;

        }

        .col-3 {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 30px;
            width: 23.45%;
        }

        .col-3 img {
            margin-bottom: 10px;
        }

        .info a {
            text-decoration: none;
            color: black;
        }

        p {
            text-align: left;
            margin-left: 10px;
        }

        .col-9 {
            margin-top: 15px;
        }

        #edit {
            font-size: 12px;

        }

        #cate {
            background-color: #F5F5F5;
            margin-right: 10px;
            margin-left: 10px;
            padding-top: 15px;
            margin-top: 8px;
            border-radius: 10px;
        }


        #addraw {
            padding: 11px 12px;
            font-size: 1em;
            line-height: 1.5;
            border-radius: 8px;
            color: #fff;
            background-color: #46739C;
            border: 0;
            overflow: hidden;
            transition: 0.2s;
        }

        .pic .img {
            height: 15rem !important;
            width: 100% !important;
            object-fit: cover;
        }

        .roomimg {
            width: 18rem !important;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
            transition: transform 250ms;
        }

        .roomimg:hover {
            transform: translateY(-10px);
            cursor: pointer;
        }

        .add {
            padding-top: 2em !important;
        }

        .price {
            padding-bottom: 2em;
        }

        .btn_add_raw {
            width: 100%;
            border-radius: 20px !important;
            background-color: #5ab74c !important;
            padding: 0.5em !important;
            border: none !important;
        }

        .btn_add_raw:hover {
            background-color: #77DC67 !important;
        }

        .search {
            width: 30% !important;
        }
        .card-body {
            padding: 1.2em 0.2em !important;
        }

        @media (max-width: 576px) {
            .search {
                width: 70% !important;
                margin-left: 2em;
            }
        }
    </style>
</head>

<body>
    <?php include "nav-bar.php"; ?>
    <div class="container">
        <div class="add">
            <div class="row">
                <div class="col text-center mb-5">
                    <h1>ราคาวัตถุดิบ</h1>
                </div>
            </div>
        </div>

        <form action="" method="GET">
            <div class="input-group">
                <div class="form-outline search">
                    <input type="text" name="search" class="form-control" id="search" placeholder="ค้นหาวัตถุดิบ" />
                </div>
                <button type="submit" class="btn btn-primary" name="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
        <?php
        $searchTerm = "";
        if (isset($_GET['submit'])) {
            $searchTerm = $_GET['search'];
        }

        $sql = "SELECT *, 
                IF(price.updateAt IS NULL, DATE(price.createAt), DATE(price.updateAt)) AS displayDate
                FROM raw_material 
                INNER JOIN price ON raw_material.raw_id = price.raw_id ";


        $sqlMs = "SELECT *, 
                IF(price_ms.updateAt IS NULL, DATE(price_ms.createAt), DATE(price_ms.updateAt)) AS displayDateMs
                FROM mineral_source_raw 
                INNER JOIN price_ms ON mineral_source_raw.ms_id = price_ms.ms_id ";

        if (!empty($searchTerm)) {
            $sql .= "WHERE raw_material.raw_thainame LIKE ? ";
            $sqlMs .= "WHERE mineral_source_raw.ms_thainame LIKE ? ";
        }

        $sql .= "ORDER BY DATE_FORMAT(displayDate, '%Y-%m-%d') DESC, raw_material.raw_id";
        $sqlMs .= "ORDER BY DATE_FORMAT(displayDateMs, '%Y-%m-%d') DESC, mineral_source_raw.ms_id";

        $stmt = $conn->prepare($sql);

        if (!empty($searchTerm)) {
            $searchTerm = '%' . $searchTerm . '%';
            $stmt->bind_param("s", $searchTerm);
        }
        $stmt->execute();
        $result = $stmt->get_result();


        $stmtMs = $conn->prepare($sqlMs);
        if (!empty($searchTerm)) {
            $stmtMs->bind_param("s", $searchTerm);
        }
        $stmtMs->execute();
        $resultMs = $stmtMs->get_result();

        ?>
        <div class="row">
            <?php
            if ($result->num_rows == 0 && $resultMs->num_rows == 0) {
                echo "<h4 class='text-center mt-5'>ไม่พบข้อมูลรายการวัตถุดิบที่ค้นหา</h4>";
            } else {
                if ($result) {
                    if ($result->num_rows > 0) { ?>
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <div class="price col col-sm-6 col-md-4 col-lg-4 col-xl-3">
                                <div class="recom">
                                    <div class="mt-5 d-flex justify-content-center text-center d-grid gap-4">
                                        <?php
                                        $idprice = $row["price_id"];
                                        $sesprice = $idprice;

                                        $displayDate = $row["displayDate"];
                                        $dateParts = explode("-", $displayDate);
                                        $day = $dateParts[2];
                                        $monthNumber = $dateParts[1];
                                        $year = $dateParts[0];
                                        $buddhistYear = $year + 543;

                                        $thaiMonths = array(
                                            '01' => 'มกราคม',
                                            '02' => 'กุมภาพันธ์',
                                            '03' => 'มีนาคม',
                                            '04' => 'เมษายน',
                                            '05' => 'พฤษภาคม',
                                            '06' => 'มิถุนายน',
                                            '07' => 'กรกฎาคม',
                                            '08' => 'สิงหาคม',
                                            '09' => 'กันยายน',
                                            '10' => 'ตุลาคม',
                                            '11' => 'พฤศจิกายน',
                                            '12' => 'ธันวาคม'
                                        );
                                        $monthThai = $thaiMonths[$monthNumber];
                                        ?>
                                        <div class="card p-2 bg-light border roomimg pic">
                                            <img src="../pic/<?php echo $row['raw_img'] ?>" class="card-img-top img " alt="">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <?php echo $row['raw_thainame']; ?>
                                                </h5>
                                                <p class="card-text">
                                                    ราคา
                                                    <?php echo $row["price"], " "; ?>บาท / กิโลกรัม
                                                <p>
                                                    <?php
                                                    echo "วันที่อัปเดต : $day $monthThai $buddhistYear";
                                                    ?>
                                                </p>

                                                <!-- <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                        data-bs-target="#staticBackdrop<?php echo $idprice; ?>">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#delete<?php echo $idprice; ?>">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
                if ($resultMs) {
                    if ($resultMs->num_rows > 0) { ?>
                        <?php
                        while ($rowMs = $resultMs->fetch_assoc()) {
                            ?>
                            <div class="price col col-sm-6 col-md-4 col-lg-4 col-xl-3">
                                <div class="recom">
                                    <div class="mt-5 d-flex justify-content-center text-center d-grid gap-4">
                                        <?php
                                        $idprice = $rowMs["price_ms_id"];
                                        $sesprice = $idprice;
                                        $displayDateMs = $rowMs["displayDateMs"];
                                        $dateParts = explode("-", $displayDateMs);
                                        $day = $dateParts[2];
                                        $monthNumber = $dateParts[1];
                                        $year = $dateParts[0];
                                        $buddhistYear = $year + 543;

                                        $thaiMonths = array(
                                            '01' => 'มกราคม',
                                            '02' => 'กุมภาพันธ์',
                                            '03' => 'มีนาคม',
                                            '04' => 'เมษายน',
                                            '05' => 'พฤษภาคม',
                                            '06' => 'มิถุนายน',
                                            '07' => 'กรกฎาคม',
                                            '08' => 'สิงหาคม',
                                            '09' => 'กันยายน',
                                            '10' => 'ตุลาคม',
                                            '11' => 'พฤศจิกายน',
                                            '12' => 'ธันวาคม'
                                        );
                                        $monthThai = $thaiMonths[$monthNumber];
                                        ?>
                                        <div class="card p-2 bg-light border roomimg pic">
                                            <img src="../pic/<?php echo $rowMs['raw_img'] ?>" class="card-img-top img " alt="">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <?php echo $rowMs['ms_thainame']; ?>
                                                </h5>
                                                <p class="card-text">
                                                    ราคา
                                                    <?php echo $rowMs["price"], " "; ?>บาท / กิโลกรัม
                                                <p>
                                                    <?php
                                                    echo "วันที่อัปเดต : $day $monthThai $buddhistYear";
                                                    ?>
                                                </p>
                                                <!-- <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                        data-bs-target="#staticBackdrop<?php echo $idprice; ?>">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#delete<?php echo $idprice; ?>">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-------------------------------------->
                            <?php
                        }
                    }

                } else {
                    echo "Query execution failed.";
                }
            }
            ?>
        </div>
        <!-- Modal เพิ่มราคาวัตถุดิบ -->
        <div class="modal fade" id="addPriceModal" tabindex="-1" aria-labelledby="addPrice" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addPrice">เพิ่มราคาวัตถุดิบ</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="process_add_price.php" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group material">
                                <label for="raw_id" class="form-label">เลือกวัตถุดิบที่ต้องการเพิ่มราคา</label>
                                <select name="raw_id" id="raw_id" class="form-control">
                                    <?php
                                    fetchRawMaterialOptions($conn);
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="price">ราคา : </label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="raw_img">รูปภาพ : </label>
                                <input type="file" class="form-control" id="raw_img" name="raw_img" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary" name="addprice">ยืนยัน</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
 <?php include("../footer.php"); ?>
    <?php
    if (isset($_SESSION['resultData'])) {
        $resultData = $_SESSION['resultData'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'อัปเดตราคาสำเร็จ',
                        text: '" . $resultData . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
        unset($_SESSION['resultData']);
    }
    ?>
    <?php
    if (isset($_SESSION['resultAddRaw'])) {
        $resultAddRaw = $_SESSION['resultAddRaw'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'เพิ่มราคาวัตถุดิบสำเร็จ',
                        text: '" . $resultAddRaw . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
        unset($_SESSION['resultAddRaw']);
    }
    ?>
    <?php
    if (isset($_SESSION['resultDelete'])) {
        $resultDelete = $_SESSION['resultDelete'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'ลบราคาวัตถุดิบสำเร็จ',
                        text: '" . $resultDelete . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
        unset($_SESSION['resultDelete']);
    }
    ?>

</body>

</html>