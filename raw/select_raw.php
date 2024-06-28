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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>เลือกรายการวัตถุดิบ</title>
	<link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <?php //include("../header.php");         ?>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #F5F5F5 !important;
            font-family: 'Kanit', sans-serif;
            padding-top: 8em;
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
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
            height: cover;
        }

        .button-select {
            width: 100%;
            border-radius: 20px;
        }

        .selectRaw,
        .selectMineral,
        .detail {
            background-color: #DBEDF2;
            padding: 1em 3em 2em;
        }

        .raw h4,
        .mineral h4,
        .details h4 {
            background-color: #6999C6;
            margin: 0em !important;
            padding: 0.5em 2em;
        }

        .sentbtn .btn {
            border-radius: 20px;
            margin: 0em 0.5em;
            width: 9em;
            border: none;
            font-size: 1.125em;
        }

        .btn-submit {
            background-color: #004c6d !important;
        }

        .btn-submit:hover {
            background-color: #64839b !important;
        }

        .btn-reset {
            background-color: #FE5E5E !important;
        }

        .btn-reset:hover {
            background-color: #ff9f9f !important;
        }

        p.content-detail-name {
            margin: 0px !important;
        }

        .content-detail-name {
            background-color: #b0c6d9;
            padding: 0.5em;
        }

        .bg-content {
            background-color: #DBEDF2;
            padding: 0.5em;
            min-height: 9em;
            max-height: 9em;
            overflow: auto;
        }

        .bg {
            background-color: #F5F5F5 !important;
        }

        .detail-view td {
            padding: 0px !important;
        }

        .selected-row {
            background-color: #90b3d3;
        }

        td {
            cursor: pointer;
        }

        .tab-content {
            padding: 2em;
            margin-bottom: 5em;
        }

        .nav-select .nav-link.active {
            background-color: white !important;
        }

        .box {
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
        }
		
		.btn-edit-table,
        .btn-delete-row {
            width: 8em !important;
        }

        @media (max-width: 577px) {
            .content {
                padding-left: 4em !important;
                padding-right: 1em !important;
            }

            .selectRaw,
            .selectMineral,
            .detail {
                padding: 1em;
            }

            .raw h4,
            .mineral h4,
            .details h4 {
                font-size: 1em !important;
                text-align: center;
            }

            .g-2 {
                width: 95%;
                margin: 0px;
            }

            .btn-reset,
            .btn-submit {
                width: 100%;
            }

            .bg-white {
                padding: 1em !important;
            }

            .fs-5 {
                font-size: 0.75rem !important;
                /* color: #6999C6; */
            }
			.nav-select .color{
                border: 1px solid #6999C6 !important;
                margin-bottom: 1em !important;
            }
            .nav-select .color.active {
                background-color: #6999C6 !important;
                color: white !important;
            }

        }

        .nav-pills .color {
            color: #6999C6 !important;
        }
    </style>
</head>

<body>
    <div class="flex">
        <div class="g-1">
            <?php include ('sidebar.php') ?>
        </div>
        <div class="g-2">
            <div class="content">
                <h1 class="text-center mb-5 mt-4">รายการวัตถุดิบ</h1>
                <div class="container">
                    <ul class="nav nav-tabs nav-select nav-pills nav-fill" id="myRaw" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link color active fs-5" id="add-raw" data-bs-toggle="tab"
                                data-bs-target="#add-raw-pane" type="button" role="tab" aria-controls="add-raw-pane"
                                aria-selected="false">เพิ่มรายการวัตถุดิบ</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link color fs-5" id="my-raw" data-bs-toggle="tab"
                                data-bs-target="#my-raw-pane" type="button" role="tab" aria-controls="my-raw-pane"
                                aria-selected="true">รายการวัตถุดิบของฉัน</button>
                        </li>
                    </ul>
                    <div class="tab-content bg-white" id="myRawContent">
                        <div class="tab-pane fade show active" id="add-raw-pane" role="tabpanel"
                            aria-labelledby="add-raw" tabindex="0">
                            <div>
                                <!-- <button type="button" class="btn btn-secondary mb-4"
                                    onclick="window.location.href = 'all_nutrition.php';">รายการวัตถุดิบทั้งหมด</button> -->
                                <form method="POST" action="select_raw_db.php" id="myForm">
                                    <div class="details box">
                                        <h4>รายละเอียด</h4>
                                        <div class="detail">
                                            <div class="row">
                                                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                    <label for="namedetail"
                                                        class="form-label fw-medium">ชื่อกลุ่มวัตถุดิบ</label>
                                                    <div class="form-floating was-validated">
                                                        <input class="form-control"
                                                            placeholder="กรอกชื่อคลังการวัตถุดิบ" id="namedetail"
                                                            name="namedetail" required pattern="[ก-๙a-zA-Z0-9].*">
                                                        <label for="namedetail"
                                                            class="text-secondary">กรอกชื่อกลุ่มวัตถุดิบ</label>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                                    <label for="nameRaw"
                                                        class="form-label fw-medium">รายละเอียดกลุ่ม</label>
                                                    <div class="form-floating">
                                                        <textarea class="form-control"
                                                            placeholder="กรอกรายละเอียดรายการวัตถุดิบ" id="detailRaw"
                                                            name="detailRaw" pattern="[ก-๙a-zA-Z0-9].*"></textarea>
                                                        <label for="detailRaw"
                                                            class="text-secondary">กรอกรายละเอียดกลุ่มวัตถุดิบ</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="raw mt-5 box">
                                        <h4>เลือกรายการวัตถุดิบ</h4>
                                        <div class="selectRaw">
                                            <label for="selectRaw" class="form-label fw-medium">เลือกวัตถุดิบ</label>
                                            <select class="form-select" id="selectRaw"
                                                data-placeholder="ค้นหาหรือเลือกวัตถุดิบ" name="selectRaw[]" multiple>
                                                <?php
                                                $sqlRaw = "SELECT * FROM raw_material WHERE ISNULL(raw_material.deleteAt)";
                                                $resultRaw = mysqli_query($conn, $sqlRaw);
                                                while ($rowRaw = mysqli_fetch_assoc($resultRaw)) {
                                                    echo '<option value="' . $rowRaw['raw_id'] . '">' . $rowRaw['raw_thainame'] . ' (' . $rowRaw['raw_engname'] . ')' . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <!-- <div class="listRaw">
                                    <label for="addRaw"
                                        class="form-label fs-5 fw-medium mt-3">เพิ่มวัตถุดิบที่ต้องการ</label>
                                    <div class="keyword-listRaw" id="keywordListRaw">
                                        <div class="keyword-row">
                                            <div class="row">
                                                <div class="col-11">
                                                    <input type="text" class="form-control "
                                                        placeholder="กรอกวัตถุดิบที่ต้องการเพิ่มเติม"
                                                        name="addRawKey[]">
                                                </div>
                                                <div class="col-1">
                                                    <button class="btn btn-danger w-100 " type="reset">-</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-grid gap-2 col-2 mx-auto addbtn mt-3">
                                            <button class="btn btn-warning add-keyword-btn" type="button"
                                                data-bs-toggle="tooltip" title="เพิ่มช่องกรอกวัตถุดิบเพิ่มเติม">
                                                <i class="bi bi-plus-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div> -->
                                        </div>
                                    </div>
                                    <div class="mineral mt-5 box">
                                        <h4>เลือกรายการแร่ธาตุและวิตามิน</h4>
                                        <div class="selectMineral">
                                            <label for="selectMineral"
                                                class="form-label fw-medium">เลือกแร่ธาตุและวิตามิน</label>
                                            <select class="form-select" id="selectMineral"
                                                data-placeholder="ค้นหาหรือเลือกแร่ธาตุ" name="selectMineral[]"
                                                multiple>
                                                <?php
                                                $sqlMineral = "SELECT * FROM mineral_source_raw WHERE ISNULL(mineral_source_raw.deleteAt)";
                                                $resultMineral = mysqli_query($conn, $sqlMineral);
                                                while ($rowMineral = mysqli_fetch_assoc($resultMineral)) {
                                                    echo '<option value="' . $rowMineral['ms_id'] . '">' . $rowMineral['ms_thainame'] . ' (' . $rowMineral['ms_engname'] . ')' . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <!-- <div class="listMineral">
                                    <label for="addMineral"
                                        class="form-label fs-5 fw-medium mt-3">เพิ่มแร่ธาตุและวิตามินที่ต้องการ</label>
                                    <div class="keyword-listMineral" id="keywordListMineral">
                                        <div class="keyword-rowMineral">
                                            <div class="row">
                                                <div class="col-11">
                                                    <input type="text" class="form-control"
                                                        placeholder="กรอกแร่ธาตุที่ต้องการเพิ่มเติม"
                                                        name="addMineralKey[]">
                                                </div>
                                                <div class="col-1">
                                                    <button class="btn btn-danger w-100 " type="reset">-</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-grid gap-2 col-2 mx-auto addbtnMineral mt-3">
                                            <button class="btn btn-warning add-keywordMineral-btn" type="button"
                                                data-bs-toggle="tooltip" title="เพิ่มช่องกรอกแร่ธาตุเพิ่มเติม">
                                                <i class="bi bi-plus-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div> -->
                                        </div>
                                    </div>
                                    <div class="form-group d-flex justify-content-center mt-5 mb-3 sentbtn">
                                        <button type="reset" class="btn btn-danger btn-reset"
                                            name="back">ล้างข้อมูล</button>
                                        <button type="submit" class="btn btn-primary btn-submit">ยืนยัน</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="my-raw-pane" role="tabpanel" aria-labelledby="my-raw"
                            tabindex="0">
                            <h4>คลังวัตถุดิบทั้งหมดของฉัน</h4>
                            <table id="table-data" data-pagination="true" data-unique-id="raw_group_id"
                                data-detail-view="true" data-detail-formatter="detailFormatter" data-search="true"
                                data-search-highlight="true" data-detail-view-by-click="true" data-locale="th-TH"
                                data-url="select_raw_getdata.php">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th data-field="raw_group_id" data-formatter="indexFormatter" scope="col"
                                            class="text-center">
                                            ลำดับ</th>
                                        <th data-field="group_name" scope="col">ชื่อกลุ่ม</th>
                                        <th data-field="group_description" scope="col">ชื่อกลุ่ม</th>
                                        <th data-field="createdAt" scope="col" class="text-center">สร้างเมื่อ</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector("#menu a[href='select_raw.php']").classList.add("active");
        });
    </script>
    <!-- Scripts -->
    <script>
        $('#selectRaw').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
            allowClear: true,
        });
        $('#selectMineral').select2({
            theme: "bootstrap-5",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
            allowClear: true,
        });
    </script>
    <!---------------------------------------------------------------------------->
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.1/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.2/dist/bootstrap-table-locale-all.min.js"></script>
    <!---------------------------------------------------------------------------->
    <script>
        function detailFormatter(index, row) {
            var html = [];
            html.push('<div class="bg"><div class="row p-4"><div class="col"><p class="content-detail-name"><b>รายการวัตถุดิบเดิม</b></p>');
            html.push('<div class="bg-content"><ul>');

            if (Array.isArray(row.materials) && row.materials.length > 0) {
                row.materials.forEach(function (material) {
                    html.push('<li>' + material.raw_thainame + ' (' + material.raw_engname + ')</li>');
                });
            } else {
                html.push('<li>ไม่มีข้อมูล</li>');
            }

            html.push('</ul></div></div>');

            // html.push('<p class="content-detail-name"><b>รายการวัตถุดิบเพิ่มเติมเดิม</b></p>');
            // html.push('<div class="bg-content"><ul>');

            // if (Array.isArray(row.personal_raw) && row.personal_raw.length > 0) {
            //     row.personal_raw.forEach(function (personalRaw) {
            //         html.push('<li>' + personalRaw.p_raw_name + '</li>');
            //     });
            // } else {
            //     html.push('<li>ไม่มีข้อมูล</li>');
            // }

            // html.push('</ul></div></div>');

            html.push('<div class="col"><p class="content-detail-name"><b>รายการแร่ธาตุเดิม</b></p>');
            html.push('<div class="bg-content"><ul>');

            if (Array.isArray(row.mineral_sources) && row.mineral_sources.length > 0) {
                row.mineral_sources.forEach(function (mineralSource) {
                    html.push('<li>' + mineralSource.ms_thainame + '</li>');
                });
            } else {
                html.push('<li>ไม่มีข้อมูล</li>');
            }

            html.push('</ul></div></div></div>');

            // html.push('<p class="content-detail-name"><b>รายการแร่ธาตุเพิ่มเติมเดิม</b></p>');
            // html.push('<div class="bg-content"><ul>');

            // if (Array.isArray(row.personal_ms) && row.personal_ms.length > 0) {
            //     row.personal_ms.forEach(function (personalMS) {
            //         html.push('<li>' + personalMS.p_ms_name + '</li>');
            //     });
            // } else {
            //     html.push('<li>ไม่มีข้อมูล</li>');
            // }

            // html.push('</ul></div></div></div>');

            html.push('<div class="row d-flex justify-content-center pb-4"><button class="btn btn-warning btn-edit-table col-1 m-1" data-raw-group-id="' + row.raw_group_id + '"><i class="bi bi-pencil-square"></i> แก้ไข</button>');
            html.push('<button id="btn-delete-row" class="btn btn-danger btn-delete-row col-1 m-1" data-raw-group-id="' + row.raw_group_id + '"><i class="bi bi-trash-fill"></i> ลบกลุ่ม</button></div></div>');

            return html.join('');
        }

        function indexFormatter(value, row, index) {
            return index + 1;
        }

        $(document).ready(function () {
            $('#table-data').bootstrapTable({
                columns: [
                    { field: 'raw_group_id', title: 'ลำดับ', formatter: 'indexFormatter' },
                    { field: 'group_name', title: 'ชื่อกลุ่ม' },
                    { field: 'group_description', title: 'รายละเอียดกลุ่ม' },
                    { field: 'createdAt', title: 'สร้างเมื่อ' },
                ],
                ajax: function (params) {
                    $.ajax({
                        url: 'select_raw_getdata.php',
                        dataType: 'json',
                        success: function (data) {
                            params.success(data);
                        },
                        error: function (error) {
                            params.error(error);
                        }
                    });
                },
                onPostBody: function () {
                    $('#table-data').on('click-row.bs.table', function (e, row, $element) {
                        $('#table-data').find('tbody tr').removeClass('selected-row');
                        $element.addClass('selected-row');
                        $('#table-data').find('tbody tr.expanded').addClass('selected-row');
                    });

                    $(document).on('click', '.btn-edit-table', function () {
                        var rawGroupId = $(this).data('raw-group-id');
                        window.location.href = 'select_raw_edit.php?raw_group_id=' + rawGroupId;
                    });

                    $(document).on('click', '.btn-delete-row', function () {
                        var rawGroupId = $(this).data('raw-group-id');
                        Swal.fire({
                            title: 'คุณแน่ใจหรือไม่?',
                            text: 'หากกดยืนยันกลุ่มจะถูกลบถาวรไม่สามารถกู้คืนได้',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'ใช่, ลบ!',
                            cancelButtonText: 'ยกเลิก'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: 'POST',
                                    url: 'delete_group.php',
                                    data: { RawGroupId: rawGroupId },
                                    success: function (response) {
                                        console.log('Response from delete_raw.php:', response);
                                        Swal.fire({
                                            title: 'ลบสำเร็จ',
                                            text: 'รายชื่อวัตถุดิบถูกลบเรียบร้อยแล้ว',
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        }).then(() => {
                                            $('#table-data').bootstrapTable('remove', {
                                                field: 'raw_group_id',
                                                values: [rawGroupId]
                                            });
                                            location.reload();
                                        });
                                    },
                                    error: function (error) {
                                        console.log('เกิดข้อผิดพลาดในการส่งข้อมูล:', error);
                                        Swal.fire({
                                            title: 'เกิดข้อผิดพลาด',
                                            text: 'ไม่สามารถลบรายชื่อได้',
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                });
                            }
                        });
                    });
                }
            });
        });
    </script>
    <!---------------------------------------------------------------------------->
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const keywordListRaw = document.querySelector("#keywordListRaw");

            keywordListRaw.addEventListener("click", function (event) {
                if (event.target.classList.contains("add-keyword-btn")) {
                    const keywordRow = createKeywordRow("addRawKey[]", "กรอกวัตถุดิบที่ต้องการเพิ่มเติม");
                    keywordListRaw.insertBefore(keywordRow, document.querySelector(".addbtn"));
                } else if (event.target.classList.contains("remove-keyword-btn")) {
                    const rowToRemove = event.target.closest(".keyword-row");
                    keywordListRaw.removeChild(rowToRemove);
                }
            });

            function createKeywordRow(inputName, placeholder) {
                const keywordRow = document.createElement("div");
                keywordRow.className = "row keyword-row mt-2";

                const keywordInputCol = document.createElement("div");
                keywordInputCol.className = "col-11";

                const keywordInput = document.createElement("input");
                keywordInput.type = "text";
                keywordInput.className = "form-control";
                keywordInput.name = inputName;
                keywordInput.placeholder = placeholder;
                keywordInput.required = true;

                keywordInputCol.appendChild(keywordInput);
                keywordRow.appendChild(keywordInputCol);

                const removeKeywordButtonCol = document.createElement("div");
                removeKeywordButtonCol.className = "col-1";

                const removeKeywordButton = document.createElement("button");
                removeKeywordButton.textContent = "-";
                removeKeywordButton.type = "button";
                removeKeywordButton.className = "btn btn-danger remove-keyword-btn w-100";

                removeKeywordButtonCol.appendChild(removeKeywordButton);
                keywordRow.appendChild(removeKeywordButtonCol);

                return keywordRow;
            }
        });

    </script>
    <!-- Scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const keywordListMineral = document.querySelector("#keywordListMineral");

            keywordListMineral.addEventListener("click", function (event) {
                if (event.target.classList.contains("add-keywordMineral-btn")) {
                    const keywordRow = createKeywordRow("addMineralKey[]", "กรอกแร่ธาตุที่ต้องการเพิ่มเติม");
                    keywordListMineral.insertBefore(keywordRow, document.querySelector(".addbtnMineral"));
                } else if (event.target.classList.contains("remove-keyword-btn")) {
                    const rowToRemove = event.target.closest(".keyword-row");
                    keywordListMineral.removeChild(rowToRemove);
                }
            });

            function createKeywordRow(inputName, placeholder) {
                const keywordRow = document.createElement("div");
                keywordRow.className = "row keyword-row mt-2";  // เปลี่ยน .keyword-rowMineral เป็น .keyword-row

                const keywordInputCol = document.createElement("div");
                keywordInputCol.className = "col-11";

                const keywordInput = document.createElement("input");
                keywordInput.type = "text";
                keywordInput.className = "form-control";
                keywordInput.name = inputName;
                keywordInput.placeholder = placeholder;
                keywordInput.required = true;

                keywordInputCol.appendChild(keywordInput);
                keywordRow.appendChild(keywordInputCol);

                const removeKeywordButtonCol = document.createElement("div");
                removeKeywordButtonCol.className = "col-1";

                const removeKeywordButton = document.createElement("button");
                removeKeywordButton.textContent = "-";
                removeKeywordButton.type = "button";
                removeKeywordButton.className = "btn btn-danger remove-keyword-btn w-100";

                removeKeywordButtonCol.appendChild(removeKeywordButton);
                keywordRow.appendChild(removeKeywordButtonCol);

                return keywordRow;
            }
        });
    </script>

</body>

</html>