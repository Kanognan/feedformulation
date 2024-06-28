<?php
session_start();
include "../server.php";
?>
<?php require "../session/user_session.php"; ?>
<?php
ini_set('display_errors', 0);
error_reporting(0);
require_once("pagination_function.php");
$acc_id = $_SESSION['acc_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php //include "../header.php"; ?>
	 <link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.css">
    <title>ปรับปรุงคุณภาพอาหาร</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Kanit', sans-serif;
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

        .t1-1 {
            background-color: #c6d9eb;
            padding: 2em;
            border-radius: 15px;
            /* margin: 1.8em; */
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
            height: cover;
        }

        .button-select {
            width: 100%;
            border-radius: 20px;
        }

        @media (max-width: 576px) {
            .content {
                padding-left: 7em !important;
            }
        }

        table {
            width: 100%;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
        }

        thead tr th {
            background: #A1CAE2 !important;
            padding: 1em !important;
        }

        .per-use-new,
        .price-new {
            background-color: #d5ffd5 !important;
        }
    </style>

<body>
    <div class="flex">
        <div class="g-1">
            <?php include('sidebar.php') ?>
        </div>
        <div class="g-2">
            <div class="content">
                <h2 class="text-center">ปรับปรุงสูตรอาหาร</h2>
                <form action="get_repair_data.php" method="post">
                    <div class="t1-1">
                        <div class="row">
                            <label for="breeder" class="form-label">รายการสูตรอาหาร</label>
                            <div class="col-10">
                                <select class="form-select" id="group_calculate" name="group_calculate">
                                    <option selected disabled>เลือกรายการสูตรอาหารที่ต้องการปรับปรุง</option>
                                    <?php
                                    $sql = "SELECT * FROM group_calculate WHERE acc_id = $acc_id";
                                    $result = $conn->query($sql);
                                    while ($raw = $result->fetch_assoc()):
                                        ;
                                        ?>
                                        <option value="<?php echo $raw["group_cal_id"]; ?>">
                                            <?php echo $raw["name_group"]; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-primary button-select" type="button">เลือก</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="show mt-5">
                    <table class="table text-center" id="data-table">
                        <thead>
                            <tr>
                                <th scope="col">รายการวัตถุดิบ</th>
                                <th scope="col">จำนวนที่ใช้ (%)</th>
                                <th scope="col">จำนวนที่ใช้ต่อ Intake ใหม่</th>
                                <th scope="col">จำนวนที่ใช้ต่อ Intake เดิม</th>
                                <th scope="col">ราคาต่อหน่วย (บาท/กก.)</th>
                                <th scope="col">ราคารวมทั้งหมด เดิม</th>
                                <th scope="col">ราคารวมทั้งหมด ใหม่</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr class="text-center table-secondary">
                                <th scope="row" colspan="" class="">รวม</th>
                                <th scope="row" colspan="" class="" id="percent">100%</th>
                                <th scope="row" colspan="" class="" id="new-intake">Intake</th>
                                <th scope="row" colspan="" class="">กก.</th>
                                <th scope="row" colspan="" class="">#</th>
                                <th class="text-center" id="result">0</th>
                                <th class="text-center" id="result-new">0</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        var $table = $('#table')

        $(function () {
            $table.bootstrapTable()
        })

        function queryParams(params) {
            var options = $table.bootstrapTable('getOptions')
            if (!options.pagination) {
                params.limit = options.totalRows
            }
            return params
        }
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector("#menu a[href='repair.php']").classList.add("active");
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tableBody = document.querySelector('#data-table tbody');

            // ฟังก์ชันเพื่อกำหนดข้อความ "ยังไม่มีข้อมูล" ในตาราง
            function showNoDataMessage() {
                tableBody.innerHTML = '<tr><td colspan="5">ยังไม่มีข้อมูล</td></tr>';
            }

            function updateTable(data) {
                var newRowHTML = '';
                var totalPerUseTimesDemIntake = 0;
                var totalOldPrice = 0;
                if (data.cal_raw) {
                    data.cal_raw.forEach(function (raw) {
                        newRowHTML += '<tr>' +
                            '<td>' + raw.raw_thainame + '</td>' +
                            '<td><input type="text" class="form-control per-use" value="' + raw.per_use + '"></td>' +
                            '<td><input type="text" class="form-control per-use-new" readonly></td>' +
                            '<td><input type="text" class="form-control" value="' + raw.intake_use + '" disabled></td>' +
                            '<td><input type="text" class="form-control price" value="' + raw.price + '" disabled></td>' +
                            '<td><input type="text" class="form-control" value="' + raw.intake_lc_result + '" disabled></td>' +
                            '<td><input type="text" class="form-control price-new" readonly></td>' +
                            '</tr>';
                        totalOldPrice += parseFloat(raw.intake_lc_result);
                    });
                }
                if (data.cal_ms) {
                    data.cal_ms.forEach(function (ms) {
                        newRowHTML += '<tr>' +
                            '<td>' + ms.ms_thainame + '</td>' +
                            '<td><input type="text" class="form-control per-use" value="' + ms.per_use + '"></td>' +
                            '<td><input type="text" class="form-control per-use-new" readonly></td>' +
                            '<td><input type="text" class="form-control" value="' + ms.intake_use + '" disabled></td>' +
                            '<td><input type="text" class="form-control price" value="' + ms.price + '" disabled></td>' +
                            '<td><input type="text" class="form-control" value="' + ms.intake_lc_result + '" disabled></td>' +
                            '<td><input type="text" class="form-control price-new" readonly></td>' +
                            '</tr>';
                        totalOldPrice += parseFloat(ms.intake_lc_result);
                    });
                }
                document.getElementById('result').textContent = totalOldPrice.toFixed(2) + ' บาท';
                var demIntakeValue = parseFloat(data.dem_intake);
                console.log(demIntakeValue);

                tableBody.innerHTML = newRowHTML;
                tableBody.querySelectorAll('.per-use').forEach(function (input) {
                    input.addEventListener('input', function () {
                        var perUseValue = parseFloat(input.value);
                        if (!isNaN(perUseValue)) {
                            totalPerUseTimesDemIntake = (perUseValue / 100) * demIntakeValue;
                            var perUseNewInput = input.parentElement.nextElementSibling.querySelector('.per-use-new');
                            if (perUseNewInput) {
                                perUseNewInput.value = totalPerUseTimesDemIntake.toFixed(2);
                            }

                            totalNewIntake = 0;
                            tableBody.querySelectorAll('.per-use-new').forEach(function (perUseNewInput) {
                                var perUseNewValue = parseFloat(perUseNewInput.value);
                                if (!isNaN(perUseNewValue)) {
                                    totalNewIntake += perUseNewValue;
                                }
                            });
                            document.getElementById('new-intake').textContent = 'Intake ' + totalNewIntake.toFixed(2) + ' กก.';

                            var priceInput = input.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.querySelector('.price');
                            var price = parseFloat(priceInput.value);
                            var totalPrice = totalPerUseTimesDemIntake * price;

                            var priceNewInput = input.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.querySelector('.price-new');
                            if (priceNewInput) {
                                priceNewInput.value = totalPrice.toFixed(2);
                            }

                            totalNewPrice = 0; // เริ่มต้นค่าใหม่ทุกครั้งที่มีการป้อนข้อมูลใหม่
                            tableBody.querySelectorAll('.price-new').forEach(function (priceNewInput) {
                                var priceNew = parseFloat(priceNewInput.value);
                                if (!isNaN(priceNew)) {
                                    totalNewPrice += priceNew;
                                }
                            });
                            document.getElementById('result-new').textContent = totalNewPrice.toFixed(2) + 'บาท';
                          
                        }

                        var totalPercentage = calculateTotalPercentage();
                        if (totalPercentage > 100) {
                            alert('ค่าจำนวนที่ใช้ไม่สามารถเกิน 100% ได้');
                            input.value = '';
                        } else {
                            // แสดงผลรวมใหม่ทันที
                            document.getElementById('percent').textContent = totalPercentage.toFixed(2) + '%';
                        }
                    });
                });
            }

            // เมื่อกดเลือกรายการ
            var selectButton = document.querySelector('.button-select');
            selectButton.addEventListener('click', function () {
                var selectedGroupId = document.getElementById('group_calculate').value;
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            var responseData = xhr.responseText;
                            var data = JSON.parse(responseData);
                            if (data) {
                                updateTable(data);
                                console.log(data)
                            } else {
                                showNoDataMessage(); // แสดงข้อความ "ยังไม่มีข้อมูล" ในตาราง
                            }
                        } else {
                            console.error('เกิดข้อผิดพลาดในการโหลดข้อมูล: ' + xhr.status);
                        }
                    }
                };

                xhr.open('POST', 'repair_data.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('group_calculate=' + encodeURIComponent(selectedGroupId));
            });

            // ฟังก์ชันเพื่อคำนวณผลรวมของ per_use และตรวจสอบว่าผลรวมเกิน 100% หรือไม่
            function calculateTotalPercentage() {
                var totalPercentage = 0;
                tableBody.querySelectorAll('.per-use').forEach(function (input) {
                    var perUseValue = parseFloat(input.value);
                    if (!isNaN(perUseValue)) {
                        totalPercentage += perUseValue;
                    }
                });
                return totalPercentage;
            }
        });

    </script>
</body>

</html>