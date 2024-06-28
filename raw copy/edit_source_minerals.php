<?php
session_start();
include "../server.php";
?>
<?php require "../session/expert_session.php"; ?>
<?php
ini_set('display_errors', 0);
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hello, Bootstrap Table!</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.css">
    <!-- <link rel="stylesheet" href="raw_style.css"> -->
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

        button.add {
            margin-top: 2em;
            width: 17em !important;
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

        thead th {
            background-color: #9cc0e2 !important;
            padding: 0.2em !important;
            text-align: center;
        }

        .form_add table {
            background-color: white !important;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
        }

        .bg {
            margin-top: 3em !important;
            margin-bottom: 5em !important;
            background-color: white !important;
            padding: 1em !important;
            border-radius: 20px;
        }

        ul.dropdown-menu.dropdown-pro.show {
            padding: 0px !important;
        }
    </style>
</head>

<body>
    <?php include "nav-bar.php"; ?>
    <div class="container">
        <div class="menu-add">
            <div class="d-flex justify-content-center">
                <div class="row text-center">
                    <div class="col-md-3 col-sm-6 col-12">
                        <button type="button" class="select-add btn btn-light add"
                            onclick="window.location='edit_nutrition.php'">จัดการคุณค่าทางโภชนะของวัตถุดิบ</button>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <button type="button" class="select-add btn btn-light add"
                            onclick="window.location='edit_minerals.php'">จัดการปริมาณแร่ธาตุในวัตถุดิบ</button>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <button type="button" class="select-add btn btn-light add"
                            onclick="window.location='edit_material.php'">จัดการกรดอะมิโนในวัตถุดิบ</button>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <button type="button" class="select-add-active btn btn-light add"
                            onclick="window.location='edit_source_minerals.php'">จัดการค่าแร่ธาตุของวัตถุดิบ</button>
                    </div>
                </div>
            </div>
        </div>
        <h1 class="mt-5 text-center">จัดการค่าแร่ธาตุของวัตถุดิบ</h1>
        <?php
        $sqltab4 = "SELECT 
                mineral_source_raw.ms_id, 
                mineral_source_raw.ms_thainame,
                mineral_source_raw.ms_engname,
                mineral_source_raw.feed_class,
                type_mineral_source_raw.type_ms_thainame, 
                GROUP_CONCAT(source_minerals_detail.source_detail_id) as source_detail_ids
            FROM 
                mineral_source_raw
            JOIN 
                type_mineral_source_raw ON mineral_source_raw.type_ms_id = type_mineral_source_raw.type_ms_id
            JOIN 
                source_minerals ON mineral_source_raw.ms_id = source_minerals.ms_id
            JOIN 
                source_minerals_detail ON source_minerals.source_detail_id = source_minerals_detail.source_detail_id
            GROUP BY 
                mineral_source_raw.ms_id, mineral_source_raw.ms_thainame, mineral_source_raw.ms_engname, mineral_source_raw.feed_class, type_mineral_source_raw.type_ms_thainame";
        ?>
        <div class="bg">
            <table class="table" id="table" data-filter-control="true" data-toggle="table" data-pagination="true"
                data-filter-control="true" data-locale="th-TH" data-search="true" data-flat="true" data-height="580"
                data-search-highlight="true" data-icons="icons">
                <thead>
                    <tr>
                        <th scope="col" data-searchable="false">ลำดับที่</th>
                        <th data-fileld="name">ชื่อ</th>
                        <th data-searchable="false">กลุ่ม</th>
                        <th data-searchable="false"></th>
                        <th data-searchable="false">DM</th>
                        <th data-searchable="false">Ca</th>
                        <th data-searchable="false">P</th>
                        <th data-searchable="false">Mg</th>
                        <th data-searchable="false">K</th>
                        <th data-searchable="false">S</th>
                        <th data-searchable="false">Na</th>
                        <th data-searchable="false">Cl</th>
                        <th data-searchable="false">Cu</th>
                        <th data-searchable="false">Fe</th>
                        <th data-searchable="false">Mn</th>
                        <th data-searchable="false">Zn</th>
                        <th data-searchable="false">Co</th>
                        <th data-searchable="false">I</th>
                        <th data-searchable="false">Se</th>
                        <th data-searchable="false">Vit A</th>
                        <th data-searchable="false">Vit D</th>
                        <th data-searchable="false">Vit E</th>
                        <th data-searchable="false">จัดการข้อมูล</th>
                    </tr>
                </thead>
                <tbody class="table-group text-center">
                    <?php
                    $result = mysqli_query($conn, $sqltab4);
                    while ($rowtab4 = mysqli_fetch_assoc($result)) {
                        $ms_id = $rowtab4['ms_id'];
                        $ms_thainame = $rowtab4['ms_thainame'];
                        $ms_engname = $rowtab4['ms_engname'];
                        $type_ms_thainame = $rowtab4['type_ms_thainame'];
                        $source_detail_ids = $rowtab4['source_detail_ids'];

                        $source_detail_array = explode(",", $source_detail_ids);
                        $num++;
                        ?>
                        <tr>
                            <th class="text-center" scope="row">
                                <?php echo $num; ?>
                            </th>
                            <th>
                                <?php echo $rowtab4['ms_thainame']; ?>
                                <?php echo "(" . $rowtab4['ms_engname'] . ")"; ?>
                            </th>
                            <th>
                                <?php echo $rowtab4['feed_class']; ?>
                            </th>
                            <?php
                            foreach ($source_detail_array as $source_detail_id) {
                                $sqlMs = "SELECT * FROM source_minerals_detail WHERE source_detail_id = $source_detail_id";
                                $resultMs = $conn->query($sqlMs);

                                if ($resultMs) {
                                    while ($row = mysqli_fetch_assoc($resultMs)) {
                                        $ds_DM = $row['ds_DM'];
                                        $ds_ca = $row['ds_ca'];
                                        $ds_p = $row['ds_p'];
                                        $ds_mg = $row['ds_mg'];
                                        $ds_k = $row['ds_k'];
                                        $ds_s = $row['ds_s'];
                                        $ds_na = $row['ds_na'];
                                        $ds_cl = $row['ds_cl'];
                                        $ds_cu = $row['ds_fe'];
                                        $ds_fe = $row['ds_fe'];
                                        $ds_mn = $row['ds_mn'];
                                        $ds_zn = $row['ds_zn'];
                                        $ds_co = $row['ds_co'];
                                        $ds_i = $row['ds_i'];
                                        $ds_se = $row['ds_se'];
                                        $vitA = $row['ds_vitA'];
                                        $vitD = $row['ds_vitD'];
                                        $vitE = $row['ds_vitE'];
                                    }
                                }
                            } ?>

                            <th>โดยน้ำหนักสด</th>
                            <td>
                                <?php echo $ds_DM; ?>
                            </td>
                            <td>
                                <?php echo $ds_ca; ?>
                            </td>
                            <td>
                                <?php echo $ds_p; ?>
                            </td>
                            <td>
                                <?php echo $ds_mg; ?>
                            </td>
                            <td>
                                <?php echo $ds_k; ?>
                            </td>
                            <td>
                                <?php echo $ds_s; ?>
                            </td>
                            <td>
                                <?php echo $ds_na; ?>
                            </td>
                            <td>
                                <?php echo $ds_cl; ?>
                            </td>
                            <td>
                                <?php echo $ds_cu; ?>
                            </td>
                            <td>
                                <?php echo $ds_fe; ?>
                            </td>
                            <td>
                                <?php echo $ds_mn; ?>
                            </td>
                            <td>
                                <?php echo $ds_zn; ?>
                            </td>
                            <td>
                                <?php echo $ds_co; ?>
                            </td>
                            <td>
                                <?php echo $ds_i; ?>
                            </td>
                            <td>
                                <?php echo $ds_se; ?>
                            </td>
                            <td>
                                <?php echo $vitA; ?>
                            </td>
                            <td>
                                <?php echo $vitD; ?>
                            </td>
                            <td>
                                <?php echo $vitE; ?>
                            </td>
                            <td>
                                <div class="row p-2 text-center d-flex justify-content-center">
                                    <div>
                                        <button class="btn btn-warning mb-2" style="width: 3em;"
                                            onclick="window.location.href='source_minerals_edit.php?id=<?php echo $rowtab4['ms_id']; ?>'">
                                            <i class="fa-solid fa-pen-to-square" style="color: #000000;"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger" style="width: 3em;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#ModalDeleteRawTab4<?php echo $rowtab4['ms_id']; ?>"
                                            data-bs-toggle="tooltip" title="ลบ">
                                            <i class="fa-solid fa-trash-can" style="color: #ffffff;"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include "../footer.php"; ?>
    <?php
    if (isset($_SESSION['resultData'])) {
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
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.1/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.2/dist/bootstrap-table-locale-all.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.3/dist/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>
    <script>
        $(function () {
            $('#table').bootstrapTable()
        })
        $(document).ready(function () {
            $("input.form-control.search-input").attr('placeholder', 'ค้นหาชื่อวัตถุดิบ');
        });
    </script>
</body>

</html>