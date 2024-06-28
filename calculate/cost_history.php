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
    <title>คำนวณต้นทุน</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Kanit', sans-serif;
        }

        body {
            background-color: #F5F5F5 !important;
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

        button.add {
            margin-top: 2em;
            width: 20em !important;
            padding: 1em;
            border: none;
            border-radius: 30px;
            background-color: #afc7de;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
        }

        .select-add-active {
            background-color: #7495b4 !important;
            box-shadow: none !important;
            color: white !important;
        }

        .form_add h1 {
            text-align: center;
            padding: 0.4em 1em;
            margin: 1em 0em;
        }

        .form_add table {
            background-color: white !important;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
        }

        .btn-more {
            margin: 1em 0em 1em 0em !important;
        }



        /* ------------------------- */
        .name_group {
            background-color: white;
            padding: 1em;
            width: 100%;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
            border: 0.1px solid lightgrey;
            cursor: pointer;
            margin-top: 1em !important;
            border-radius: 10px
        }

        .name_group .text-start {
            font-weight: bolder;
        }

        .cost_history h5 {
            margin-top: 3em !important;
            text-align: center;
            margin-bottom: 1.5em;
        }

        .showtable {
            display: none;
        }

        .showtable.active {
            display: block;
        }
		.btn-delete-row{
			width: 30% !important;
		}

        @media (max-width: 576px) {
            .content {
                padding-left: 4.3em !important;
				padding-right: 1em !important;
            }

            .btn-select {
                padding: 0.5em 0em !important;
                margin: 0.25em 1em !important;
            }

            .btn-select img {
                width: 2em;
            }
			button.add {
				margin-top: 2em;
				width: 19em !important;
				font-size: 0.7em;
			}
			.name_group {
				padding: 1em 0.2em;
				width: 18em!important;
			}
			.btn-delete-row{
				width: 50% !important;
			}
        }
        @media (max-width: 913px) {
            .g-2 {
                width: 95% !important;
            }
            table input{
                width: 5em !important;
            }
			.btn-delete-row{
				width: 50% !important;
			}
			button.add {
				margin-top: 2em;
				width: 19em !important;
				font-size: 0.7em;
			}
        }
		@media (max-width: 310px) {
			.g-2 {
                width: 95% !important;
            }
     		.content {
                padding-left: 4.1em !important;
				padding-right: 0.8em !important;
            }
			button.add {
				margin-top: 2em;
				width: 90%  !important;
			}
			.btn-more .btn-select {
				width: 7em !important;
			}
			.bg_form {
				padding: 0em 0.7em;
			}
			.search{
				width: 45% !important;
			}
			h5{
				font-size: 0.8em;
			}
        }
    </style>
</head>

<body>
    <?php include('navbar.php') ?>
    <div class="flex">
        <div class="g-1">
            <?php include('sidebar.php') ?>
        </div>
        <div class="g-2">
            <div class="content cost_history">
                <h2 class="text-center">สูตรอาหารต้นทุนต่ำสุด</h2>
                <div class="menu-add">
                    <div class="d-flex justify-content-center">
                        <div class="row text-center">
                            <div class="col-12 col-sm-6 p-0">
                                <button type="button" class="select-add btn btn-light add"
                                    onclick="window.location='cost.php'">คำนวณสูตรอาหารต้นทุนต่ำสุด</button>
                            </div>
                            <div class="col-12 col-sm-6 p-0">
                                <button type="button" class="select-add-active btn btn-light add"
                                    onclick="window.location='cost_history.php'">ประวัติการคำนวณสูตรอาหารต้นทุนต่ำสุด</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <hr> -->
                <h5>ประวัติการคำนวณสูตรอาหารต้นทุนต่ำสุดทั้งหมด</h5>
                <div class="search-container">
                    <form id="searchForm" method="GET">
                        <div class="input-group d-flex justify-content-start">
                            <div class="form-outline search">
                                <input type="text" name="search" class="form-control" id="search"
                                    placeholder="ค้นหาวัตถุดิบ" />
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <?php
                if (isset($_GET['search'])) {
                    $search = $_GET['search'];
                    $sql = "SELECT * FROM group_calculate WHERE acc_id = $acc_id AND name_group LIKE '%$search%' AND deleteAt IS NULL ORDER BY createAt DESC";
                } else {
                    $sql = "SELECT * FROM group_calculate WHERE acc_id = $acc_id AND deleteAt IS NULL ORDER BY createAt DESC";
                }
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $group_cal_id = $row["group_cal_id"]; ?>
                        <div class="d-flex justify-content-center" onclick="toggleTable(<?php echo $group_cal_id; ?>)">
                            <div class="name_group row" data-table-id="<?php echo $group_cal_id; ?>">
                                <div class="row">
                                    <div class="text-start col">
                                        <?php echo $row["name_group"]; ?>
                                    </div>
                                    <div class="text-end col">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </div>
                                </div>
                                <div class="showtable" id="table_<?php echo $group_cal_id; ?>">
									<div class="table-responsive">
                                    
                                    <table class="table table-striped-columns text-center mt-3 mb-3">
                                        <thead class="table-primary">
                                            <tr>
                                                <th scope="col" class="p-3">รายการวัตถุดิบ</th>
                                                <th scope="col" class="p-3">จำนวนที่ใช้ (%)</th>
                                                <th scope="col" class="p-3">จำนวนที่ใช้ต่อ Intake (กก./วัน)</th>
                                                <th scope="col" class="p-3">ราคาต่อหน่วย (บาท/กก.)</th>
                                                <th scope="col" class="p-3">ราคารวมทั้งหมด (บาท)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total_intake = 0;
                                            $total_intake_lc_result = 0;
                                            $sql_cal_raw = "SELECT * FROM cal_raw WHERE group_cal_id = $group_cal_id";
                                            $result_cal_raw = mysqli_query($conn, $sql_cal_raw);
                                            while ($row_cal_raw = mysqli_fetch_assoc($result_cal_raw)) {
                                                $raw_id = $row_cal_raw["raw_id"];
                                                $sql_raw_material = "SELECT raw_thainame FROM raw_material WHERE raw_id = $raw_id";
                                                $result_raw_material = mysqli_query($conn, $sql_raw_material);
                                                $row_raw_material = mysqli_fetch_assoc($result_raw_material);
                                                $materialName = $row_raw_material["raw_thainame"];
                                                $total_intake += $row_cal_raw["intake_use"];
                                                $total_intake_lc_result += $row_cal_raw["intake_lc_result"];
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $materialName; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row_cal_raw["per_use"]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo number_format($row_cal_raw["intake_use"], 3); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row_cal_raw["price"]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo number_format($row_cal_raw["intake_lc_result"], 3); ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>

                                            <?php
                                            $sql_cal_ms = "SELECT * FROM cal_ms WHERE group_cal_id = $group_cal_id";
                                            $result_cal_ms = mysqli_query($conn, $sql_cal_ms);
                                            while ($row_cal_ms = mysqli_fetch_assoc($result_cal_ms)) {
                                                $ms_id = $row_cal_ms["ms_id"];
                                                $sql_mineral_source_raw = "SELECT ms_thainame FROM mineral_source_raw WHERE ms_id = $ms_id";
                                                $result_mineral_source_raw = mysqli_query($conn, $sql_mineral_source_raw);
                                                $row_mineral_source_raw = mysqli_fetch_assoc($result_mineral_source_raw);
                                                $materialName = $row_mineral_source_raw["ms_thainame"];
                                                $total_intake += $row_cal_ms["intake_use"];
                                                $total_intake_lc_result += $row_cal_ms["intake_lc_result"];
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $materialName; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row_cal_ms["per_use"]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo number_format($row_cal_ms["intake_use"], 3); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row_cal_ms["price"]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo number_format($row_cal_ms["intake_lc_result"], 3); ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr class="text-center table-secondary">
                                                <th scope="row" colspan="" class="">รวม</th>
                                                <th scope="row" colspan="" class="" id="percent">100%</th>
                                                <th scope="row" colspan="" class="" id="new-intake">Intake
                                                    <?php echo $total_intake; ?> (กก./วัน)
                                                </th>
                                                <th scope="row" colspan="" class="">#</th>
                                                <th scope="row" colspan="" class="">
                                                    <?php echo number_format($total_intake_lc_result, 3); ?> บาท
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
										</div>
                                    <div class="d-flex justify-content-center">
                                        <button id="btn-delete-row"
                                            class="btn btn-danger gap-2 mx-auto btn-delete-row col-1 m-1"
                                            onclick="confirmDelete(<?php echo $group_cal_id; ?>)">
                                            <i class="bi bi-trash-fill"></i> ลบกลุ่ม
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<div class='text-center mt-4'><h5>ไม่พบประวัติการคำนวณสูตรอาหารต้นทุนต่ำสุด</h5></div>";
                }
                ?>
            </div>
        </div>
    </div>
    <?php
    if (isset($_SESSION['resultDeleteCost'])) {
        $resultDeleteCost = $_SESSION['resultDeleteCost'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'ลบสำเร็จ',
                        text: '" . $resultDeleteCost . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
        unset($_SESSION['resultDeleteCost']);
    }
    ?>
    <?php
    if (isset($_SESSION['errorDeleteCost'])) {
        $errorDeleteCost = $_SESSION['errorDeleteCost'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: '" . $errorDeleteCost . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
        unset($_SESSION['errorDeleteCost']);
    }
    ?>
    <script>
        function toggleTable(group_cal_id) {
            var table = document.querySelector('#table_' + group_cal_id);
            var icon = document.querySelector('[data-table-id="' + group_cal_id + '"] .text-end i');

            table.classList.toggle('active'); // เพิ่มหรือลบคลาส active เพื่อแสดงหรือซ่อนตาราง

            // เปลี่ยนไอคอน
            if (table.classList.contains('active')) {
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        }

    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector("#menu a[href='cost.php']").classList.add("active");
        });
    </script>
    <script>
        // เมื่อส่งแบบฟอร์มค้นหา
        document.getElementById("searchForm").addEventListener("submit", function (event) {
            event.preventDefault(); // หยุดการส่งแบบฟอร์ม
            var searchValue = document.querySelector('input[name="search"]').value; // ค่าค้นหา
            var currentUrl = window.location.href; // URL ปัจจุบัน
            var newUrl = currentUrl.split('?')[0] + '?search=' + searchValue; // URL ใหม่
            window.location.href = newUrl; // ลิ้งค์ไปยัง URL ใหม่
        });
    </script>
    <script>
        function confirmDelete(group_cal_id) {
            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: "คุณต้องการลบกลุ่มนี้หรือไม่? หากลบจะไม่สามารถย้อนกลับได้",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ใช่, ลบ!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    // ถ้าผู้ใช้กดตกลงให้ส่งค่า group_cal_id ไปยังหน้าอื่นเพื่อลบ
                    window.location.href = 'delete_cost.php?id=' + group_cal_id;
                }
            });
        }
    </script>
</body>

</html>