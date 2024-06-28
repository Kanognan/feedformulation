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
                        <button type="button" class="select-add-active btn btn-light add"
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
                        <button type="button" class="select-add btn btn-light add"
                            onclick="window.location='edit_source_minerals.php'">จัดการค่าแร่ธาตุของวัตถุดิบ</button>
                    </div>
                </div>
            </div>
        </div>
        <h1 class="mt-5 text-center">จัดการคุณค่าทางโภชนะของวัตถุดิบ</h1>
        <?php
        $sqltab1 = "SELECT 
                        raw_material.raw_id, 
                        raw_material.raw_thainame,
                        raw_material.raw_engname,
                        raw_material.feed_class,
                        type_raw_material.type_raw_thainame, 
                        GROUP_CONCAT(nutrition_detail.nutrition_detail_id) as nutrition_detail_ids
                    FROM 
                        raw_material
                    JOIN 
                        type_raw_material ON raw_material.type_raw_id = type_raw_material.type_raw_id
                    JOIN 
                        nutrition ON raw_material.raw_id = nutrition.raw_id
                    JOIN 
                        nutrition_detail ON nutrition.nutrition_detail_id = nutrition_detail.nutrition_detail_id
                    GROUP BY 
                        raw_material.raw_id, raw_material.raw_thainame, raw_material.raw_engname, raw_material.feed_class, type_raw_material.type_raw_thainame";
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
                        <th data-searchable="false">CP</th>
                        <th data-searchable="false">EE</th>
                        <th data-searchable="false">CF</th>
                        <th data-searchable="false">Ash</th>
                        <th data-searchable="false">NFE</th>
                        <th data-searchable="false">NDF</th>
                        <th data-searchable="false">ADF</th>
                        <th data-searchable="false">ADL</th>
                        <th data-searchable="false">NDICP</th>
                        <th data-searchable="false">ADICP</th>
                        <th data-searchable="false">NDFD</th>
                        <th data-searchable="false">RUP</th>
                        <th data-searchable="false">DMD</th>
                        <th data-searchable="false">OMD</th>
                        <th data-searchable="false">TDN</th>
                        <th data-searchable="false">DE</th>
                        <th data-searchable="false">ME</th>
                        <th data-searchable="false">NEL</th>
                        <th data-searchable="false">จัดการข้อมูล</th>
                    </tr>
                </thead>
                <tbody class="table-group text-center">
                    <?php
                    $result = mysqli_query($conn, $sqltab1);
                    while ($rowtab1 = mysqli_fetch_assoc($result)) {
                        $raw_id = $rowtab1['raw_id'];
                        $raw_thainame = $rowtab1['raw_thainame'];
                        $raw_engname = $rowtab1['raw_engname'];
                        $type_raw_thainame = $rowtab1['type_raw_thainame'];
                        $nutrition_detail_ids = $rowtab1['nutrition_detail_ids'];
                        $nutrition_detail_array = explode(",", $nutrition_detail_ids);
                        $num++;
                        ?>
                        <tr>
                            <td scope="row">
                                <?php echo $num; ?>
                            </td>
                            <th>
                                <?php echo $rowtab1['raw_thainame']; ?>
                                <?php echo "(" . $rowtab1['raw_engname'] . ")"; ?>
                            </th>
                            <th>
                                <?php echo $rowtab1['feed_class']; ?>
                            </th>
                            <?php
                            foreach ($nutrition_detail_array as $nutrition_detail_id) {
                                $sqlN = "SELECT * FROM nutrition_detail WHERE nutrition_detail_id = $nutrition_detail_id";
                                $resultN = $conn->query($sqlN);
                                if ($resultN) {
                                    while ($row = mysqli_fetch_assoc($resultN)) {
                                        if ($row['type_detail_id'] == 1) {
                                            $dnut_dm_avg = $row['dnut_dm'];
                                            $dnut_cp_avg = $row['dnut_cp'];
                                            $dnut_ee_avg = $row['dnut_ee'];
                                            $dnut_cf_avg = $row['dnut_cf'];
                                            $dnut_ash_avg = $row['dnut_ash'];
                                            $dnut_nfe_avg = $row['dnut_nfe'];
                                            $dnut_ndf_avg = $row['dnut_ndf'];
                                            $dnut_adf_avg = $row['dnut_adf'];
                                            $dnut_adl_avg = $row['dnut_adl'];
                                            $dnut_ndicp_avg = $row['dnut_ndicp'];
                                            $dnut_adicp_avg = $row['dnut_adicp'];
                                            $dnut_ndfd_avg = $row['dnut_ndfd'];
                                            $dnut_rup_avg = $row['dnut_rup'];
                                            $dnut_dmd_avg = $row['dnut_dmd'];
                                            $dnut_omd_avg = $row['dnut_omd'];
                                            $dnut_tdn_avg = $row['dnut_tdn'];
                                            $dnut_de_avg = $row['dnut_de'];
                                            $dnut_me_avg = $row['dnut_me'];
                                            $dnut_nel_avg = $row['dnut_nel'];
                                        }
                                        if ($row['type_detail_id'] == 2) {
                                            $dnut_dm_sd = $row['dnut_dm'];
                                            $dnut_cp_sd = $row['dnut_cp'];
                                            $dnut_ee_sd = $row['dnut_ee'];
                                            $dnut_cf_sd = $row['dnut_cf'];
                                            $dnut_ash_sd = $row['dnut_ash'];
                                            $dnut_nfe_sd = $row['dnut_nfe'];
                                            $dnut_ndf_sd = $row['dnut_ndf'];
                                            $dnut_adf_sd = $row['dnut_adf'];
                                            $dnut_adl_sd = $row['dnut_adl'];
                                            $dnut_ndicp_sd = $row['dnut_ndicp'];
                                            $dnut_adicp_sd = $row['dnut_adicp'];
                                            $dnut_ndfd_sd = $row['dnut_ndfd'];
                                            $dnut_rup_sd = $row['dnut_rup'];
                                            $dnut_dmd_sd = $row['dnut_dmd'];
                                            $dnut_omd_sd = $row['dnut_omd'];
                                            $dnut_tdn_sd = $row['dnut_tdn'];
                                            $dnut_de_sd = $row['dnut_de'];
                                            $dnut_me_sd = $row['dnut_me'];
                                            $dnut_nel_sd = $row['dnut_nel'];
                                        }
                                        if ($row['type_detail_id'] == 3) {
                                            $dnut_dm_n = $row['dnut_dm'];
                                            $dnut_cp_n = $row['dnut_cp'];
                                            $dnut_ee_n = $row['dnut_ee'];
                                            $dnut_cf_n = $row['dnut_cf'];
                                            $dnut_ash_n = $row['dnut_ash'];
                                            $dnut_nfe_n = $row['dnut_nfe'];
                                            $dnut_ndf_n = $row['dnut_ndf'];
                                            $dnut_adf_n = $row['dnut_adf'];
                                            $dnut_adl_n = $row['dnut_adl'];
                                            $dnut_ndicp_n = $row['dnut_ndicp'];
                                            $dnut_adicp_n = $row['dnut_adicp'];
                                            $dnut_ndfd_n = $row['dnut_ndfd'];
                                            $dnut_rup_n = $row['dnut_rup'];
                                            $dnut_dmd_n = $row['dnut_dmd'];
                                            $dnut_omd_n = $row['dnut_omd'];
                                            $dnut_tdn_n = $row['dnut_tdn'];
                                            $dnut_de_n = $row['dnut_de'];
                                            $dnut_me_n = $row['dnut_me'];
                                            $dnut_nel_n = $row['dnut_nel'];
                                        }

                                    }
                                }
                            } ?>
                            <th>AVG</th>
                            <td>
                                <?php echo $dnut_dm_avg; ?>
                            </td>
                            <td>
                                <?php echo $dnut_cp_avg; ?>
                            </td>
                            <td>
                                <?php echo $dnut_ee_avg; ?>
                            </td>
                            <td>
                                <?php echo $dnut_cf_avg; ?>
                            </td>
                            <td>
                                <?php echo $dnut_ash_avg; ?>
                            </td>
                            <td>
                                <?php echo $dnut_nfe_avg; ?>
                            </td>
                            <td>
                                <?php echo $dnut_ndf_avg; ?>
                            </td>
                            <td>
                                <?php echo $dnut_adf_avg; ?>
                            </td>
                            <td>
                                <?php echo $dnut_adl_avg; ?>
                            </td>
                            <td>
                                <?php echo $dnut_ndicp_avg; ?>
                            </td>
                            <td>
                                <?php echo $dnut_adicp_avg; ?>
                            </td>
                            <td>
                                <?php echo $dnut_ndfd_avg; ?>
                            </td>
                            <td>
                                <?php echo $dnut_rup_avg; ?>
                            </td>
                            <td>
                                <?php echo $dnut_dmd_avg; ?>
                            </td>
                            <td>
                                <?php echo $dnut_omd_avg; ?>
                            </td>
                            <td>
                                <?php echo $dnut_tdn_avg; ?>
                            </td>
                            <td>
                                <?php echo $dnut_de_avg; ?>
                            </td>
                            <td>
                                <?php echo $dnut_me_avg; ?>
                            </td>
                            <td>
                                <?php echo $dnut_nel_avg; ?>
                            </td>
                            <td rowspan="3">
                                <div class="row p-2 text-center d-flex justify-content-center">
                                    <div>
                                        <button class="btn btn-warning mb-2" style="width: 3em;"
                                            onclick="window.location.href='nutrition_edit.php?id=<?php echo $rowtab1['raw_id']; ?>'">
                                            <i class="fa-solid fa-pen-to-square" style="color: #000000;"></i>
                                        </button>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-danger" style="width: 3em;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#ModalDeleteRawTab1<?php echo $rowtab1['raw_id']; ?>"
                                            data-bs-toggle="tooltip" title="ลบ">
                                            <i class="fa-solid fa-trash-can" style="color: #ffffff;"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td scope="row" rowspan="" hidden></td>
                            <th>
                                <?php echo $rowtab1['raw_thainame']; ?>
                                <?php echo "(" . $rowtab1['raw_engname'] . ")"; ?>
                            </th>
                            <th>
                                <?php echo $rowtab1['feed_class']; ?>
                            </th>
                            <th>SD</th>
                            <td>
                                <?php echo $dnut_dm_sd; ?>
                            </td>
                            <td>
                                <?php echo $dnut_cp_sd; ?>
                            </td>
                            <td>
                                <?php echo $dnut_ee_sd; ?>
                            </td>
                            <td>
                                <?php echo $dnut_cf_sd; ?>
                            </td>
                            <td>
                                <?php echo $dnut_ash_sd; ?>
                            </td>
                            <td>
                                <?php echo $dnut_nfe_sd; ?>
                            </td>
                            <td>
                                <?php echo $dnut_ndf_sd; ?>
                            </td>
                            <td>
                                <?php echo $dnut_adf_sd; ?>
                            </td>
                            <td>
                                <?php echo $dnut_adl_sd; ?>
                            </td>
                            <td>
                                <?php echo $dnut_ndicp_sd; ?>
                            </td>
                            <td>
                                <?php echo $dnut_adicp_sd; ?>
                            </td>
                            <td>
                                <?php echo $dnut_ndfd_sd; ?>
                            </td>
                            <td>
                                <?php echo $dnut_rup_sd; ?>
                            </td>
                            <td>
                                <?php echo $dnut_dmd_sd; ?>
                            </td>
                            <td>
                                <?php echo $dnut_omd_sd; ?>
                            </td>
                            <td>
                                <?php echo $dnut_tdn_sd; ?>
                            </td>
                            <td>
                                <?php echo $dnut_de_sd; ?>
                            </td>
                            <td>
                                <?php echo $dnut_me_sd; ?>
                            </td>
                            <td>
                                <?php echo $dnut_nel_sd; ?>
                            </td>
                        </tr>
                        <tr>
                            <td scope="row" rowspan="" hidden></td>
                            <th>
                                <?php echo $rowtab1['raw_thainame']; ?>
                                <?php echo "(" . $rowtab1['raw_engname'] . ")"; ?>
                            </th>
                            <th>
                                <?php echo $rowtab1['feed_class']; ?>
                            </th>
                            <th>N</th>
                            <td>
                                <?php echo $dnut_dm_n; ?>
                            </td>
                            <td>
                                <?php echo $dnut_cp_n; ?>
                            </td>
                            <td>
                                <?php echo $dnut_ee_n; ?>
                            </td>
                            <td>
                                <?php echo $dnut_cf_n; ?>
                            </td>
                            <td>
                                <?php echo $dnut_ash_n; ?>
                            </td>
                            <td>
                                <?php echo $dnut_nfe_n; ?>
                            </td>
                            <td>
                                <?php echo $dnut_ndf_n; ?>
                            </td>
                            <td>
                                <?php echo $dnut_adf_n; ?>
                            </td>
                            <td>
                                <?php echo $dnut_adl_n; ?>
                            </td>
                            <td>
                                <?php echo $dnut_ndicp_n; ?>
                            </td>
                            <td>
                                <?php echo $dnut_adicp_n; ?>
                            </td>
                            <td>
                                <?php echo $dnut_ndfd_n; ?>
                            </td>
                            <td>
                                <?php echo $dnut_rup_n; ?>
                            </td>
                            <td>
                                <?php echo $dnut_dmd_n; ?>
                            </td>
                            <td>
                                <?php echo $dnut_omd_n; ?>
                            </td>
                            <td>
                                <?php echo $dnut_tdn_n; ?>
                            </td>
                            <td>
                                <?php echo $dnut_de_n; ?>
                            </td>
                            <td>
                                <?php echo $dnut_me_n; ?>
                            </td>
                            <td>
                                <?php echo $dnut_nel_n; ?>
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