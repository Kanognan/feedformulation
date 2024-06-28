<?php
session_start();
include "../server.php";
?>
<?php require "../session/user_session.php"; ?>
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
                            onclick="window.location='all_nutrition.php'">รายการคุณค่าทางโภชนะของวัตถุดิบ</button>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <button type="button" class="select-add btn btn-light add"
                            onclick="window.location='all_minerals.php'">รายการปริมาณแร่ธาตุในวัตถุดิบ</button>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <button type="button" class="select-add-active btn btn-light add"
                            onclick="window.location='all_material.php'">รายการกรดอะมิโนในวัตถุดิบ</button>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                        <button type="button" class="select-add btn btn-light add"
                            onclick="window.location='all_source_minerals.php'">รายการค่าแร่ธาตุของวัตถุดิบ</button>
                    </div>
                </div>
            </div>
        </div>
        <h1 class="mt-5 text-center">รายการกรดอะมิโนในวัตถุดิบ</h1>
        <?php
        $sqltab3 = "SELECT 
                        raw_material.raw_id, 
                        raw_material.raw_thainame,
                        raw_material.raw_engname,
                        raw_material.feed_class,
                        type_raw_material.type_raw_thainame, 
                        GROUP_CONCAT(material_detail.material_detail_id) as material_detail_ids
                    FROM 
                        raw_material
                    JOIN 
                        type_raw_material ON raw_material.type_raw_id = type_raw_material.type_raw_id
                    JOIN 
                        material ON raw_material.raw_id = material.raw_id
                    JOIN 
                        material_detail ON material.material_detail_id = material_detail.material_detail_id
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
                        <th data-searchable="false">Ala</th>
                        <th data-searchable="false">Arg</th>
                        <th data-searchable="false">Asp</th>
                        <th data-searchable="false">Cys</th>
                        <th data-searchable="false">Glu</th>
                        <th data-searchable="false">Gly</th>
                        <th data-searchable="false">His</th>
                        <th data-searchable="false">Hyl</th>
                        <th data-searchable="false">Hyp</th>
                        <th data-searchable="false">Ile</th>
                        <th data-searchable="false">Leu</th>
                        <th data-searchable="false">Lys</th>
                        <th data-searchable="false">Met</th>
                        <th data-searchable="false">Phe</th>
                        <th data-searchable="false">Pro</th>
                        <th data-searchable="false">Ser</th>
                        <th data-searchable="false">Thr</th>
                        <th data-searchable="false">Trp</th>
                        <th data-searchable="false">Try</th>
                        <th data-searchable="false">Val</th>
                    </tr>
                </thead>
                <tbody class="table-group text-center">
                    <?php
                    $result = mysqli_query($conn, $sqltab3);
                    while ($rowtab3 = mysqli_fetch_assoc($result)) {
                        $raw_id = $rowtab3['raw_id'];
                        $raw_thainame = $rowtab3['raw_thainame'];
                        $raw_engname = $rowtab3['raw_engname'];
                        $type_raw_thainame = $rowtab3['type_raw_thainame'];
                        $material_detail_ids = $rowtab3['material_detail_ids'];

                        $material_detail_array = explode(",", $material_detail_ids);
                        $num++;
                        ?>
                        <tr>
                            <td scope="row">
                                <?php echo $num; ?>
                            </td>
                            <th>
                                <?php echo $rowtab3['raw_thainame']; ?>
                                <?php echo "(" . $rowtab3['raw_engname'] . ")"; ?>
                            </th>
                            <th>
                                <?php echo $rowtab3['feed_class']; ?>
                            </th>
                            <?php
                            foreach ($material_detail_array as $material_detail_id) {
                                $sqlMt = "SELECT * FROM material_detail WHERE material_detail_id = $material_detail_id";
                                $resultMt = $conn->query($sqlMt);

                                if ($resultMt) {
                                    while ($row = mysqli_fetch_assoc($resultMt)) {
                                        if ($row['type_detail_id'] == 1) {
                                            $dmat_ala_avg = $row['dmat_ala'];
                                            $dmat_arg_avg = $row['dmat_arg'];
                                            $dmat_asp_avg = $row['dmat_asp'];
                                            $dmat_cys_avg = $row['dmat_cys'];
                                            $dmat_glu_avg = $row['dmat_glu'];
                                            $dmat_gly_avg = $row['dmat_gly'];
                                            $dmat_his_avg = $row['dmat_his'];
                                            $dmat_hyl_avg = $row['dmat_hyl'];
                                            $dmat_hyp_avg = $row['dmat_hyp'];
                                            $dmat_ile_avg = $row['dmat_ile'];
                                            $dmat_leu_avg = $row['dmat_leu'];
                                            $dmat_lys_avg = $row['dmat_lys'];
                                            $dmat_met_avg = $row['dmat_met'];
                                            $dmat_phe_avg = $row['dmat_phe'];
                                            $dmat_pro_avg = $row['dmat_pro'];
                                            $dmat_ser_avg = $row['dmat_ser'];
                                            $dmat_thr_avg = $row['dmat_thr'];
                                            $dmat_trp_avg = $row['dmat_trp'];
                                            $dmat_tyr_avg = $row['dmat_tyr'];
                                            $dmat_val_avg = $row['dmat_val'];
                                        }
                                        if ($row['type_detail_id'] == 2) {
                                            $dmat_ala_sd = $row['dmat_ala'];
                                            $dmat_arg_sd = $row['dmat_arg'];
                                            $dmat_asp_sd = $row['dmat_asp'];
                                            $dmat_cys_sd = $row['dmat_cys'];
                                            $dmat_glu_sd = $row['dmat_glu'];
                                            $dmat_gly_sd = $row['dmat_gly'];
                                            $dmat_his_sd = $row['dmat_his'];
                                            $dmat_hyl_sd = $row['dmat_hyl'];
                                            $dmat_hyp_sd = $row['dmat_hyp'];
                                            $dmat_ile_sd = $row['dmat_ile'];
                                            $dmat_leu_sd = $row['dmat_leu'];
                                            $dmat_lys_sd = $row['dmat_lys'];
                                            $dmat_met_sd = $row['dmat_met'];
                                            $dmat_phe_sd = $row['dmat_phe'];
                                            $dmat_pro_sd = $row['dmat_pro'];
                                            $dmat_ser_sd = $row['dmat_ser'];
                                            $dmat_thr_sd = $row['dmat_thr'];
                                            $dmat_trp_sd = $row['dmat_trp'];
                                            $dmat_tyr_sd = $row['dmat_tyr'];
                                            $dmat_val_sd = $row['dmat_val'];
                                        }
                                        if ($row['type_detail_id'] == 3) {
                                            $dmat_ala_n = $row['dmat_ala'];
                                            $dmat_arg_n = $row['dmat_arg'];
                                            $dmat_asp_n = $row['dmat_asp'];
                                            $dmat_cys_n = $row['dmat_cys'];
                                            $dmat_glu_n = $row['dmat_glu'];
                                            $dmat_gly_n = $row['dmat_gly'];
                                            $dmat_his_n = $row['dmat_his'];
                                            $dmat_hyl_n = $row['dmat_hyl'];
                                            $dmat_hyp_n = $row['dmat_hyp'];
                                            $dmat_ile_n = $row['dmat_ile'];
                                            $dmat_leu_n = $row['dmat_leu'];
                                            $dmat_lys_n = $row['dmat_lys'];
                                            $dmat_met_n = $row['dmat_met'];
                                            $dmat_phe_n = $row['dmat_phe'];
                                            $dmat_pro_n = $row['dmat_pro'];
                                            $dmat_ser_n = $row['dmat_ser'];
                                            $dmat_thr_n = $row['dmat_thr'];
                                            $dmat_trp_n = $row['dmat_trp'];
                                            $dmat_tyr_n = $row['dmat_tyr'];
                                            $dmat_val_n = $row['dmat_val'];
                                        }

                                    }
                                }
                            } ?>
                            <th>AVG</th>

                            <td>
                                <?php echo $dmat_ala_avg; ?>
                            </td>
                            <td>
                                <?php echo $dmat_arg_avg; ?>
                            </td>
                            <td>
                                <?php echo $dmat_asp_avg; ?>
                            </td>
                            <td>
                                <?php echo $dmat_cys_avg; ?>
                            </td>
                            <td>
                                <?php echo $dmat_glu_avg; ?>
                            </td>
                            <td>
                                <?php echo $dmat_gly_avg; ?>
                            </td>
                            <td>
                                <?php echo $dmat_his_avg; ?>
                            </td>
                            <td>
                                <?php echo $dmat_hyl_avg; ?>
                            </td>
                            <td>
                                <?php echo $dmat_hyp_avg; ?>
                            </td>
                            <td>
                                <?php echo $dmat_ile_avg; ?>
                            </td>
                            <td>
                                <?php echo $dmat_leu_avg; ?>
                            </td>
                            <td>
                                <?php echo $dmat_lys_avg; ?>
                            </td>
                            <td>
                                <?php echo $dmat_met_avg; ?>
                            </td>
                            <td>
                                <?php echo $dmat_phe_avg; ?>
                            </td>
                            <td>
                                <?php echo $dmat_pro_avg; ?>
                            </td>
                            <td>
                                <?php echo $dmat_ser_avg; ?>
                            </td>
                            <td>
                                <?php echo $dmat_thr_avg; ?>
                            </td>
                            <td>
                                <?php echo $dmat_trp_avg; ?>
                            </td>
                            <td>
                                <?php echo $dmat_tyr_avg; ?>
                            </td>
                            <td>
                                <?php echo $dmat_val_avg; ?>
                            </td>
                        </tr>
                        <tr>
                            <td scope="row" rowspan="" hidden></td>
                            <th>
                                <?php echo $rowtab3['raw_thainame']; ?>
                                <?php echo "(" . $rowtab3['raw_engname'] . ")"; ?>
                            </th>
                            <th>
                                <?php echo $rowtab3['feed_class']; ?>
                            </th>
                            <th>SD</th>
                            <td>
                                <?php echo $dmat_ala_sd; ?>
                            </td>
                            <td>
                                <?php echo $dmat_arg_sd; ?>
                            </td>
                            <td>
                                <?php echo $dmat_asp_sd; ?>
                            </td>
                            <td>
                                <?php echo $dmat_cys_sd; ?>
                            </td>
                            <td>
                                <?php echo $dmat_glu_sd; ?>
                            </td>
                            <td>
                                <?php echo $dmat_gly_sd; ?>
                            </td>
                            <td>
                                <?php echo $dmat_his_sd; ?>
                            </td>
                            <td>
                                <?php echo $dmat_hyl_sd; ?>
                            </td>
                            <td>
                                <?php echo $dmat_hyp_sd; ?>
                            </td>
                            <td>
                                <?php echo $dmat_ile_sd; ?>
                            </td>
                            <td>
                                <?php echo $dmat_leu_sd; ?>
                            </td>
                            <td>
                                <?php echo $dmat_lys_sd; ?>
                            </td>
                            <td>
                                <?php echo $dmat_met_sd; ?>
                            </td>
                            <td>
                                <?php echo $dmat_phe_sd; ?>
                            </td>
                            <td>
                                <?php echo $dmat_pro_sd; ?>
                            </td>
                            <td>
                                <?php echo $dmat_ser_sd; ?>
                            </td>
                            <td>
                                <?php echo $dmat_thr_sd; ?>
                            </td>
                            <td>
                                <?php echo $dmat_trp_sd; ?>
                            </td>
                            <td>
                                <?php echo $dmat_tyr_sd; ?>
                            </td>
                            <td>
                                <?php echo $dmat_val_sd; ?>
                            </td>

                        </tr>
                        <tr>
                            <td scope="row" rowspan="" hidden></td>
                            <th>
                                <?php echo $rowtab3['raw_thainame']; ?>
                                <?php echo "(" . $rowtab3['raw_engname'] . ")"; ?>
                            </th>
                            <th>
                                <?php echo $rowtab3['feed_class']; ?>
                            </th>
                            <th>N</th>
                            <td>
                                <?php echo $dmat_ala_n; ?>
                            </td>
                            <td>
                                <?php echo $dmat_arg_n; ?>
                            </td>
                            <td>
                                <?php echo $dmat_asp_n; ?>
                            </td>
                            <td>
                                <?php echo $dmat_cys_n; ?>
                            </td>
                            <td>
                                <?php echo $dmat_glu_n; ?>
                            </td>
                            <td>
                                <?php echo $dmat_gly_n; ?>
                            </td>
                            <td>
                                <?php echo $dmat_his_n; ?>
                            </td>
                            <td>
                                <?php echo $dmat_hyl_n; ?>
                            </td>
                            <td>
                                <?php echo $dmat_hyp_n; ?>
                            </td>
                            <td>
                                <?php echo $dmat_ile_n; ?>
                            </td>
                            <td>
                                <?php echo $dmat_leu_n; ?>
                            </td>
                            <td>
                                <?php echo $dmat_lys_n; ?>
                            </td>
                            <td>
                                <?php echo $dmat_met_n; ?>
                            </td>
                            <td>
                                <?php echo $dmat_phe_n; ?>
                            </td>
                            <td>
                                <?php echo $dmat_pro_n; ?>
                            </td>
                            <td>
                                <?php echo $dmat_ser_n; ?>
                            </td>
                            <td>
                                <?php echo $dmat_thr_n; ?>
                            </td>
                            <td>
                                <?php echo $dmat_trp_n; ?>
                            </td>
                            <td>
                                <?php echo $dmat_tyr_n; ?>
                            </td>
                            <td>
                                <?php echo $dmat_val_n; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include "../footer.php"; ?>
  
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