<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hello, Bootstrap Table!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.css">

    <style>
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
    </style>
</head>

<body>
    <table id="table-data" data-pagination="true" data-unique-id="raw_group_id" data-detail-view="true"
        data-detail-formatter="detailFormatter" data-search="true" data-search-highlight="true"
        data-detail-view-by-click="true" data-url="raw/select_raw_getdata.php">
        <thead class="table-light text-center">
            <tr>
                <th data-field="raw_group_id" data-formatter="indexFormatter" scope="col" class="text-center">ลำดับ</th>
                <th data-field="group_name" scope="col">ชื่อกลุ่ม</th>
                <th data-field="group_description" scope="col">ชื่อกลุ่ม</th>
                <th data-field="createdAt" scope="col" class="text-center">สร้างเมื่อ</th>
            </tr>
        </thead>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.1/dist/bootstrap-table.min.js"></script>


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

            html.push('</ul></div>');

            html.push('<p class="content-detail-name"><b>รายการวัตถุดิบเพิ่มเติมเดิม</b></p>');
            html.push('<div class="bg-content"><ul>');

            if (Array.isArray(row.personal_raw) && row.personal_raw.length > 0) {
                row.personal_raw.forEach(function (personalRaw) {
                    html.push('<li>' + personalRaw.p_raw_name + '</li>');
                });
            } else {
                html.push('<li>ไม่มีข้อมูล</li>');
            }

            html.push('</ul></div></div>');

            html.push('<div class="col"><p class="content-detail-name"><b>รายการแร่ธาตุเดิม</b></p>');
            html.push('<div class="bg-content"><ul>');

            if (Array.isArray(row.mineral_sources) && row.mineral_sources.length > 0) {
                row.mineral_sources.forEach(function (mineralSource) {
                    html.push('<li>' + mineralSource.ms_thainame + '</li>');
                });
            } else {
                html.push('<li>ไม่มีข้อมูล</li>');
            }

            html.push('</ul></div>');

            html.push('<p class="content-detail-name"><b>รายการแร่ธาตุเพิ่มเติมเดิม</b></p>');
            html.push('<div class="bg-content"><ul>');

            if (Array.isArray(row.personal_ms) && row.personal_ms.length > 0) {
                row.personal_ms.forEach(function (personalMS) {
                    html.push('<li>' + personalMS.p_ms_name + '</li>');
                });
            } else {
                html.push('<li>ไม่มีข้อมูล</li>');
            }

            html.push('</ul></div></div></div>');

            html.push('<div class="row d-flex justify-content-center pb-4"><button class="btn btn-warning btn-edit-table col-1 m-1" data-raw-group-id="' + row.raw_group_id + '"><i class="bi bi-pencil-square"></i> แก้ไข</button>');
            html.push('<button class="btn btn-danger btn-delete-row col-1 m-1" data-raw-group-id="' + row.raw_group_id + '"><i class="bi bi-trash-fill"></i> ลบกลุ่ม</button></div></div>');

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
                        url: 'raw/select_raw_getdata.php',
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
                        window.location.href = 'raw/select_raw_edit.php?raw_group_id=' + rawGroupId;
                    });

                    // -----------------------------------------------


                    $(document).ready(function () {
                        function confirmDelete(id, rawGroupId) {
                            Swal.fire({
                                title: 'คุณแน่ใจหรือไม่?',
                                text: 'คุณต้องการลบรายชื่อนี้หรือไม่? (ID: ' + rawGroupId + ')',
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
                                        data: { RawId: id, RawGroupId: rawGroupId },
                                        success: function (response) {
                                            console.log('Response from delete_raw.php:', response);
                                            Swal.fire({
                                                title: 'ลบสำเร็จ',
                                                text: 'รายชื่อวัตถุดิบถูกลบเรียบร้อยแล้ว',
                                                icon: 'success',
                                                confirmButtonText: 'OK'
                                            }).then(() => {
                                                window.location.reload();
                                            });
                                        },
                                        error: function (error) {
                                            console.log('เกิดข้อผิดพลาดในการส่งข้อมูล:', error);
                                        }
                                    });
                                }
                            });
                        }

                        $('.btn-delete-row').click(function () {
                            var rawGroupId = $(this).data('raw-group-id');
                            confirmDelete('raw', rawGroupId);
                        });
                    });
                }
            });
        });
    </script>

</body>

</html>