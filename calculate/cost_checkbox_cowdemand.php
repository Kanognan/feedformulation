<?php
session_start();
if (!isset($_SESSION['user_status']) || ($_SESSION['user_status'] != 'Admin')) {
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
    <?php //include("../header.php"); ?>
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

        /* ----------------------------- */
        .raw hr,
        .cow hr {
            width: 50%;
        }

        .raw,
        .cow {
            margin-top: 2em !important;
        }

        .select-button {
            margin: 2em 0em !important;
        }

        button.btn-hidden {
            display: none !important;
        }

        .btn-more .btn-select {
            background-color: #4F80C0;
            color: white;
            width: 10em;
            border-radius: 20px !important;
            margin: 0em 0.3em;
            border: none;
        }

        .btn-more .btn-select:hover {
            background-color: #6999C6 !important;
        }

        .btn-more .btn-select {
            background-color: #77DC67;
            color: white;
            width: 10em;
            border-radius: 20px !important;
            margin: 0em 0.3em;
            border: none;
        }

        .btn-more .btn-select:hover {
            background-color: #6999C6 !important;
        }

        .btn-more .btn-cal {
            background-color: #4F80C0;
            color: white;
            width: 10em;
            border-radius: 20px !important;
            margin: 0em 0.3em;
            border: none;
        }

        .btn-more .btn-cal:hover {
            background-color: #6999C6 !important;
        }

        .namegroup {
            padding: 1em 0em;
            font-size: 1.2em;
        }

        .checkbox-wrapper-26 * {
            -webkit-tap-highlight-color: transparent;
            outline: none;
        }

        .checkbox-wrapper-26 input[type="checkbox"] {
            display: none;
        }

        .checkbox-wrapper-26 label {
            --size: 1.7em;
            --shadow: calc(var(--size) * .07) calc(var(--size) * .1);
            position: relative;
            display: block;
            width: var(--size);
            height: var(--size);
            margin: 0 auto;
            background-color: #dc3545;
            border-radius: 50%;
            box-shadow: 0 var(--shadow) #ffbeb8;
            cursor: pointer;
            transition: 0.2s ease transform, 0.2s ease background-color,
                0.2s ease box-shadow;
            overflow: hidden;
            z-index: 1;
        }

        .checkbox-wrapper-26 label:before {
            content: "";
            position: absolute;
            top: 50%;
            right: 0;
            left: 0;
            width: calc(var(--size) * .7);
            height: calc(var(--size) * .7);
            margin: 0 auto;
            background-color: #fff;
            transform: translateY(-50%);
            border-radius: 50%;
            box-shadow: inset 0 var(--shadow) #ffbeb8;
            transition: 0.2s ease width, 0.2s ease height;
        }
        /* #198754 */

        .checkbox-wrapper-26 label:hover:before {
            width: calc(var(--size) * .55);
            height: calc(var(--size) * .55);
            box-shadow: inset 0 var(--shadow) #ff9d96;
        }

        .checkbox-wrapper-26 label:active {
            transform: scale(0.9);
        }

        .checkbox-wrapper-26 .tick_mark {
            position: absolute;
            top: -1px;
            right: 0;
            left: calc(var(--size) * -.05);
            width: calc(var(--size) * .6);
            height: calc(var(--size) * .6);
            margin: 0 auto;
            margin-left: calc(var(--size) * .14);
            transform: rotateZ(-40deg);
        }

        .checkbox-wrapper-26 .tick_mark:before,
        .checkbox-wrapper-26 .tick_mark:after {
            content: "";
            position: absolute;
            background-color: #fff;
            border-radius: 2px;
            opacity: 0;
            transition: 0.2s ease transform, 0.2s ease opacity;
        }

        .checkbox-wrapper-26 .tick_mark:before {
            left: 0;
            bottom: 0;
            width: calc(var(--size) * .1);
            height: calc(var(--size) * .3);
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.23);
            transform: translateY(calc(var(--size) * -.68));
        }

        .checkbox-wrapper-26 .tick_mark:after {
            left: 0;
            bottom: 0;
            width: 100%;
            height: calc(var(--size) * .1);
            box-shadow: 0 3px 5px rgba(0, 0, 0, 0.23);
            transform: translateX(calc(var(--size) * .78));
        }

        .checkbox-wrapper-26 input[type="checkbox"]:checked+label {
            background-color: #198754;
            box-shadow: 0 var(--shadow) #92ff97;
        }

        .checkbox-wrapper-26 input[type="checkbox"]:checked+label:before {
            width: 0;
            height: 0;
        }

        .checkbox-wrapper-26 input[type="checkbox"]:checked+label .tick_mark:before,
        .checkbox-wrapper-26 input[type="checkbox"]:checked+label .tick_mark:after {
            transform: translate(0);
            opacity: 1;
        }

        @media (max-width: 576px) {
            .content {
                padding-left: 7em !important;
            }

            .btn-select {
                padding: 0.5em 0em !important;
                margin: 0.25em 1em !important;
            }

            .btn-select img {
                width: 2em;
            }
        }
    </style>

<body>
    <?php $acc_id = $_SESSION['acc_id']; ?>
    <div class="flex">
        <div class="g-1">
            <?php include('sidebar.php') ?>
        </div>
        <div class="g-2">
            <div class="content">
                <h2 class="text-center">คำนวณต้นทุน</h2>
                <form action="" method="post" class="row">
                    <div class="cow col-6">
                        <h4>ข้อมูลโค</h4>
                        <hr>
                        <div class="text-end">
                            <a href="feed.php" type="button"
                                class="btn btn-outline-success mb-3 btn-sm">เพิ่มรายการคำนวณโภชนะ</a>
                        </div>
                        <div class="form-for-cows">
                            <?php
                            // $sql = "SELECT * FROM cow_demand
                            //     INNER JOIN cow ON cow_demand.cow_id = cow.cow_id
                            //     WHERE cow.acc_id = $acc_id";
                            $sql = "SELECT * FROM cow_demand
                            WHERE acc_id = $acc_id";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                echo '<select class="form-select" id="cows" data-placeholder="เลือกความต้องการโภชนะของโค" name="selectCow">';
                                echo '<option></option>';
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['dem_id'] . '">' . $row['dem_name'] . '</option>';
                                }

                                echo '</select>';
                            } else {
                                echo '<div class="text-center">คุณยังไม่มีข้อมูลโค</div>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="raw col-6">
                        <h4>คลังวัตถุดิบ</h4>
                        <hr>
                        <div class="text-end">
                            <a href="../raw/select_raw.php" type="button"
                                class="btn btn-outline-success mb-3 btn-sm">เพิ่มคลังวัตถุดิบ</a>
                        </div>
                        <div class="form-for-raw">
                            <?php
                            $sql_raw = "SELECT * FROM raw_group WHERE acc_id = $acc_id";
                            $result_raw = $conn->query($sql_raw);
                            if ($result_raw->num_rows > 0) {
                                echo '<select class="form-select" id="raw" data-placeholder="เลือกกลุ่มของวัตถุดิบ" name="selectRaw">';
                                echo '<option></option>';
                                while ($row1 = $result_raw->fetch_assoc()) {
                                    echo '<option value="' . $row1['raw_group_id'] . '">' . $row1['group_name'] . '</option>';
                                }

                                echo '</select>';
                            } else {
                                echo '<div class="text-center">คุณยังไม่มีข้อมูลคลังวัตถุดิบ</div>';
                            }
                            $conn->close();
                            ?>
                        </div>
                    </div>
                    <div class="btn-more">
                        <button type="submit"
                            class="btn btn-primary d-grid gap-2 col-2 mx-auto select-button btn-select">เลือก</button>
                    </div>
                </form>

                <form id="costForm" action="cost_data.php" method="POST">
                    <hr>
                    <div class="show">
                        <div class="material">
                            <div id="groupName"></div>
                            <div id="materialTable"></div>
                            <div class="constriant btn-hidden">
                            </div>
                        </div>
                        <div class="cowdemand">
                            <div id="groupCowdemand"></div>
                            <div id="cowdemandTable"></div>
                        </div>
                    </div>
                    <div class="btn-more">
                        <!-- <button type="button"
                            class="btn btn-primary d-grt id gap-2 col-2 mx-auto btn-cost btn-hidden btn-cal" onclick="window.location.href = 'cost_show.php'">คำนวณราคา</button> -->
                        <button type="submit"
                            class="btn btn-primary d-grid gap-2 col-2 mx-auto btn-cost btn-hidden btn-cal">คำนวณราคา</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('#cows').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
        });
        $('#raw').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector("#menu a[href='cost.php']").classList.add("active");
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector("form").addEventListener("submit", function (event) {
                event.preventDefault();

                var selectCow = document.querySelector("[name='selectCow']").value;
                var selectRaw = document.querySelector("[name='selectRaw']").value;

                if (!selectCow || !selectRaw) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'เกิดข้อผิดพลาด',
                        text: 'กรุณาเลือกความต้องการโภชนะของโคและคลังวัตถุดิบ',
                    });
                    return;
                }

                fetch("get_data.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body: "selectCow=" + encodeURIComponent(selectCow) + "&selectRaw=" + encodeURIComponent(selectRaw),
                })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById("materialTable").innerHTML = '';
                        document.getElementById("cowdemandTable").innerHTML = '';  // เพิ่มบรรทัดนี้เพื่อล้างข้อมูลเก่าของ cow_demand
                        displayMaterialData(data);
                        displayCowDemandData(data);  // เพิ่มเรียกใช้ function สำหรับแสดงข้อมูล cow_demand
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                    });

            });
        });

        function displayMaterialData(data) {
            // ตรวจสอบว่ามีข้อมูลหรือไม่
            if (data.length > 0) {
                var group = data[0];
                var groupNameDiv = document.getElementById("groupName");
                groupNameDiv.innerHTML = '<div class="namegroup"><strong>คลังวัตถุดิบ : ' + group.group_name + '</strong>&nbsp; &nbsp; &nbsp;<button type="button" class="btn btn-outline-warning btn-sm editGroup"><i class="bi bi-pencil-square"></i></button></div>';
                var editButton = document.querySelector('.editGroup');
                editButton.addEventListener('click', function () {
                    var rawGroupId = group.raw_group_id;
                    window.location.href = '../raw/select_raw_edit.php?raw_group_id=' + rawGroupId;
                });

                var index = 1;
                var table = '<table class="table text-center">';
                table += '<thead class="table-primary"><tr><th>ลำดับ</th><th>รายการวัตถุดิบและแร่ธาตุ</th><th>ราคากลาง (บาท/กิโลกรัม)</th><th>ราคาวัตถุดิบ (บาท/กิโลกรัม)</th><th>Min (%)</th><th>Max (%)</th></tr></thead>';
                table += '<tbody>';
                // แสดงข้อมูลวัตถุดิบ
                if (Array.isArray(group.materials) && group.materials.length > 0) {
                    for (var i = 0; i < group.materials.length; i++) {
                        var material = group.materials[i];
                        table += '<tr>';
                        table += '<td>' + index + '</td>';
                        table += '<td>' + material.raw_thainame + ' (' + material.raw_engname + ')' + '</td>';
                        table += '<td>' + material.price + '</td>';
                        table += '<td class="was-validated"><input type="number" step="0.01" min="0" max="999" class="form-control material-price" name="materials[' + material.raw_id + '][price]" required><div class="valid-feedback"></div><div class="invalid-feedback"></div></td>';
                        table += '<td><input type="number" class="form-control material-min" name="materials[' + material.raw_id + '][min]"></td>';
                        table += '<td><input type="number" class="form-control material-max" name="materials[' + material.raw_id + '][max]"></td>';
                        table += '</tr>';
                        index++;  // เพิ่ม index ทีละ 1
                    }
                }

                // แสดงข้อมูลแหล่งแร่
                if (Array.isArray(group.mineral_sources) && group.mineral_sources.length > 0) {
                    for (var k = 0; k < group.mineral_sources.length; k++) {
                        var MineralSource = group.mineral_sources[k];
                        table += '<tr>';
                        table += '<td>' + index + '</td>';
                        table += '<td>' + MineralSource.ms_thainame + ' (' + MineralSource.ms_engname + ')' + '</td>';
                        table += '<td>' + MineralSource.price + '</td>';
                        table += '<td class="was-validated"><input type="number" step="0.01" min="0" max="999" class="form-control mineral_sources_price" name="mineral_sources[' + MineralSource.ms_id + '][price]" required><div class="valid-feedback"></div><div class="invalid-feedback"></div></td>';
                        table += '<td><input type="number" class="form-control mineral_sources-min" name="mineral_sources[' + MineralSource.ms_id + '][min]"></td>';
                        table += '<td><input type="number" class="form-control mineral_sources-max" name="mineral_sources[' + MineralSource.ms_id + '][max]"></td>';
                        table += '</tr>';
                        index++;
                    }
                }

            } else {
                table += '<tr><td colspan="5">ไม่พบข้อมูล</td></tr>';
            }

            table += '</tbody></table>';

            document.getElementById("materialTable").innerHTML = table;
            document.querySelector('.btn-cost').classList.remove('btn-hidden');
        }

        function displayCowDemandData(data) {
            if (data.length > 0 && Array.isArray(data[0].cow_demand) && data[0].cow_demand.length > 0) {
                var group = data[0];
                var groupCowdemandDiv = document.getElementById("groupCowdemand");
                groupCowdemandDiv.innerHTML = '<div class="namegroup"><strong>ความต้องการโภชนะ : ' + group.cow_demand[0].dem_name + '</strong></div>';

                var table = '<table class="table text-center table-cow">';
                table += '<thead class="table-primary"><tr><th>เลือก</th><th>ความต้องการโภชนะ</th><th>ค่าความต้องการโภชนะ</th><th>หน่วย</th></tr></thead>';
                table += '<tbody>';

                var cowDemand = group.cow_demand[0];

                table += '<tr>';
                table += '<td><div class="checkbox-wrapper-26"><input type="checkbox" id="checkbox-dem_BW" name="checkbox-dem_BW" value="dem_BW"><label for="checkbox-dem_BW"><div class="tick_mark"></div></label></div></td>';
                table += '<td>น้ำหนักโค</td>';
                table += '<td><input type="text" class="form-control cowdemand text-center" name="cowdemand_' + cowDemand.dem_id + '" placeholder="' + cowDemand.dem_BW + '" disabled readonly ></td>';
                table += '<td>กิโลกรัม</td>';
                table += '</tr>';

                table += '<tr>';
                table += '<td><div class="checkbox-wrapper-26"><input type="checkbox" id="checkbox-dem_adg" name="checkbox-dem_adg" value="dem_adg"><label for="checkbox-dem_adg"><div class="tick_mark"></div></label></div></td>';
                table += '<td>อัตราการเจริญเติบโต</td>';
                table += '<td><input type="text" class="form-control cowdemand text-center" name="cowdemand_' + cowDemand.dem_id + '" placeholder="' + cowDemand.dem_adg + '" disabled readonly ></td>';
                table += '<td>กิโลกรัม/วัน</td>';
                table += '</tr>';

                table += '<tr>';
                table += '<td><div class="checkbox-wrapper-26"><input type="checkbox" id="checkbox-dem_intake" name="checkbox-dem_intake" value="dem_intake"><label for="checkbox-dem_intake"><div class="tick_mark"></div></label></div></td>';
                table += '<td>ปริมาณการกินได้น้ำหนักแห้ง</td>';
                table += '<td><input type="text" class="form-control cowdemand text-center" name="cowdemand_' + cowDemand.dem_id + '" placeholder="' + cowDemand.dem_intake + '" disabled readonly ></td>';
                table += '<td>กิโลกรัม/วัน</td>';
                table += '</tr>';

                table += '<tr>';
                table += '<td><div class="checkbox-wrapper-26"><input type="checkbox" id="checkbox-dem_me" name="checkbox-dem_me" value="dem_me"><label for="checkbox-dem_me"><div class="tick_mark"></div></label></div></td>';
                table += '<td>พลังงานที่ใช้ประโยชน์ได้</td>';
                table += '<td><input type="text" class="form-control cowdemand text-center" name="cowdemand_' + cowDemand.dem_id + '" placeholder="' + cowDemand.dem_me + '" disabled readonly ></td>';
                table += '<td>เมกกะแคลลอรี/วัน</td>';
                table += '</tr>';

                table += '<tr>';
                table += '<td><div class="checkbox-wrapper-26"><input type="checkbox" id="checkbox-dem_mp" name="checkbox-dem_mp" value="dem_mp"><label for="checkbox-dem_mp"><div class="tick_mark"></div></label></div></td>';
                table += '<td>โปรตีนที่ใช้ประโยชน์ได้</td>';
                table += '<td><input type="text" class="form-control cowdemand text-center" name="cowdemand_' + cowDemand.dem_id + '" placeholder="' + cowDemand.dem_mp + '" disabled readonly ></td>';
                table += '<td>กิโลกรัม/วัน</td>';
                table += '</tr>';

                table += '<tr>';
                table += '<td><div class="checkbox-wrapper-26"><input type="checkbox" id="checkbox-dem_cp" name="checkbox-dem_cp" value="dem_cp"><label for="checkbox-dem_cp"><div class="tick_mark"></div></label></div></td>';
                table += '<td>โปรตีนหยาบ</td>';
                table += '<td><input type="text" class="form-control cowdemand text-center" name="cowdemand_' + cowDemand.dem_id + '" placeholder="' + cowDemand.dem_cp + '" disabled readonly ></td>';
                table += '<td>กิโลกรัม/วัน</td>';
                table += '</tr>';

                table += '<tr>';
                table += '<td><div class="checkbox-wrapper-26"><input type="checkbox" id="checkbox-dem_ndf" name="checkbox-dem_ndf" value="dem_ndf"><label for="checkbox-dem_ndf"><div class="tick_mark"></div></label></div></td>';
                table += '<td>เยื่อใยที่ไม่ละลายในสารฟอกที่เป็นกลาง</td>';
                table += '<td><input type="text" class="form-control cowdemand text-center" name="cowdemand_' + cowDemand.dem_id + '" placeholder="' + cowDemand.dem_ndf + '" disabled readonly ></td>';
                table += '<td>>%</td>';
                table += '</tr>';

                table += '<tr>';
                table += '<td><div class="checkbox-wrapper-26"><input type="checkbox" id="checkbox-dem_adf" name="checkbox-dem_adf" value="dem_adf"><label for="checkbox-dem_adf"><div class="tick_mark"></div></label></div></td>';
                table += '<td>เยื่อใยที่ไม่ละลายในสารฟอกที่เป็นกรด</td>';
                table += '<td><input type="text" class="form-control cowdemand text-center" name="cowdemand_' + cowDemand.dem_id + '" placeholder="' + cowDemand.dem_adf + '" disabled readonly ></td>';
                table += '<td>>%</td>';
                table += '</tr>';

                table += '<tr>';
                table += '<td><div class="checkbox-wrapper-26"><input type="checkbox" id="checkbox-dem_ca" name="checkbox-dem_ca" value="dem_ca"><label for="checkbox-dem_ca"><div class="tick_mark"></div></label></div></td>';
                table += '<td>แคลเซียม</td>';
                table += '<td><input type="text" class="form-control cowdemand text-center" name="cowdemand_' + cowDemand.dem_id + '" placeholder="' + cowDemand.dem_ca + '" disabled readonly ></td>';
                table += '<td>%</td>';
                table += '</tr>';

                table += '<tr>';
                table += '<td><div class="checkbox-wrapper-26"><input type="checkbox" id="checkbox-dem_p" name="checkbox-dem_p" value="dem_p"><label for="checkbox-dem_p"><div class="tick_mark"></div></label></div></td>';
                table += '<td>ฟอสฟอรัส</td>';
                table += '<td><input type="text" class="form-control cowdemand text-center" name="cowdemand_' + cowDemand.dem_id + '" placeholder="' + cowDemand.dem_p + '" disabled readonly ></td>';
                table += '<td>%</td>';
                table += '</tr>';

                table += '<tr>';
                table += '<td><div class="checkbox-wrapper-26"><input type="checkbox" id="checkbox-dem_vitA" name="checkbox-dem_vitA" value="dem_vitA"><label for="checkbox-dem_vitA"><div class="tick_mark"></div></label></div></td>';
                table += '<td>วิตามินเอ</td>';
                table += '<td><input type="text" class="form-control cowdemand text-center" name="cowdemand_' + cowDemand.dem_id + '" placeholder="' + cowDemand.dem_vitA + '" disabled readonly ></td>';
                table += '<td>หน่วยสากล/วัน</td>';
                table += '</tr>';

                table += '<tr>';
                table += '<td><div class="checkbox-wrapper-26"><input type="checkbox" id="checkbox-dem_vitD" name="checkbox-dem_vitD" value="dem_vitD"><label for="checkbox-dem_vitD"><div class="tick_mark"></div></label></div></td>';
                table += '<td>วิตามินดี</td>';
                table += '<td><input type="text" class="form-control cowdemand text-center" name="cowdemand_' + cowDemand.dem_id + '" placeholder="' + cowDemand.dem_vitD + '" disabled readonly ></td>';
                table += '<td>หน่วยสากล/วัน</td>';
                table += '</tr>';

                table += '<tr>';
                table += '<td><div class="checkbox-wrapper-26"><input type="checkbox" id="checkbox-dem_vitE" name="checkbox-dem_vitE" value="dem_vitE"><label for="checkbox-dem_vitE"><div class="tick_mark"></div></label></div></td>';
                table += '<td>วิตามินอี</td>';
                table += '<td><input type="text" class="form-control cowdemand text-center" name="cowdemand_' + cowDemand.dem_id + '" placeholder="' + cowDemand.dem_vitE + '" disabled readonly ></td>';
                table += '<td>หน่วยสากล/วัน</td>';
                table += '</tr>';

                table += '</tbody></table>';

                document.getElementById("cowdemandTable").innerHTML = table;
            } else {
                document.getElementById("cowdemandTable").innerHTML = '<p>ไม่พบข้อมูล cow_demand</p>';
            }
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector("#costForm").addEventListener("submit", function (event) {
                event.preventDefault();

                // ดึงข้อมูลจาก input แต่ละช่อง
                var materialInputs = document.querySelectorAll('.form-control');
                var formData = {};

                // นำข้อมูลจาก input ไปใส่ใน formData
                materialInputs.forEach(function (input, index) {
                    // ถ้าไม่ใช่ตัวเลขให้ใช้ 0 แทน
                    formData[input.name] = isNaN(parseFloat(input.value)) ? 0 : parseFloat(input.value);
                });

                var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                var checkboxData = {};

                var isAnyCheckboxChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
                if (!isAnyCheckboxChecked) {
                    Swal.fire({
                        title: 'กรุณาเลือกอย่างน้อยหนึ่งรายการ',
                        text: 'กรุณาเลือกรายการความต้องการโภชนะของโค',
                        icon: 'warning',
                        confirmButtonText: 'ตกลง'
                    });
                    return;  // ออกจากฟังก์ชันเพื่อไม่ทำการ submit ฟอร์ม
                }

                checkboxes.forEach(function (checkbox) {
                    var checkboxName = checkbox.name;
                    if (checkbox.checked) {
                        formData[checkboxName] = checkbox.value;
                    }
                });

                // เพิ่มข้อมูล checkboxData ใน formData
                for (var key in checkboxData) {
                    formData[key] = checkboxData[key];
                }

                // ตรวจสอบการกรอกราคาของวัตถุดิบ
                var materialPriceInputs = document.querySelectorAll('.form-control.material-price');
                var isMaterialPriceFilled = Array.from(materialPriceInputs).every(input => input.value.trim() !== '');

                // ตรวจสอบการกรอกราคาของแหล่งแร่
                var mineralSourcesPriceInputs = document.querySelectorAll('.form-control.mineral_sources_price');
                var isMineralSourcesPriceFilled = Array.from(mineralSourcesPriceInputs).every(input => input.value.trim() !== '');

                // ถ้ามีช่องราคาว่าง ให้แจ้งเตือน
                if (!isMaterialPriceFilled || !isMineralSourcesPriceFilled) {
                    Swal.fire({
                        title: 'กรุณากรอกข้อมูลในช่องราคา',
                        text: 'กรุณากรอกราคาของวัตถุดิบให้ครบ',
                        icon: 'warning',
                        confirmButtonText: 'ตกลง'
                    });
                    return;
                }

                // เพิ่มข้อมูลเพิ่มเติมที่คุณต้องการส่งไปยัง cost_data.php ได้ที่นี่
                formData['selectRaw'] = isNaN(parseFloat(document.querySelector("[name='selectRaw']").value)) ? 0 : parseFloat(document.querySelector("[name='selectRaw']").value);
                formData['selectCow'] = isNaN(parseFloat(document.querySelector("[name='selectCow']").value)) ? 0 : parseFloat(document.querySelector("[name='selectCow']").value);

                // สร้าง hidden input สำหรับแต่ละข้อมูลใน formData
                for (var key in formData) {
                    var hiddenInput = document.createElement("input");
                    hiddenInput.type = "hidden";
                    hiddenInput.name = key;
                    hiddenInput.value = formData[key];
                    document.getElementById("costForm").appendChild(hiddenInput);
                }

                // ส่งฟอร์ม
                document.getElementById("costForm").submit();
            });
        });

    </script>



</body>

</html>