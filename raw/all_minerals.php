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
    <title>รายการวัตถุดิบ</title>
	<link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
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
            width: 16em !important;
            padding: 0.7em;
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
    <div class="container-fluid">
        <div class="menu-add">
            <div class="d-flex justify-content-center">
                <div class="row text-center">
                    <div class="col-12 col-sm-6 col-lg-3">
                        <button type="button" class="select-add btn btn-light add"
                            onclick="window.location='all_nutrition.php'">รายการคุณค่าทางโภชนะของวัตถุดิบ</button>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <button type="button" class="select-add-active btn btn-light add"
                            onclick="window.location='all_minerals.php'">รายการปริมาณแร่ธาตุในวัตถุดิบ</button>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <button type="button" class="select-add btn btn-light add"
                            onclick="window.location='all_material.php'">รายการกรดอะมิโนในวัตถุดิบ</button>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <button type="button" class="select-add btn btn-light add"
                            onclick="window.location='all_source_minerals.php'">รายการค่าแร่ธาตุและวิตามิน</button>
                    </div>
                </div>
            </div>
        </div>
        <h1 class="mt-5 text-center">รายการปริมาณแร่ธาตุในวัตถุดิบ</h1>
        <?php
        $sqltab2 = "SELECT 
                    raw_material.raw_id, 
                    raw_material.raw_thainame,
                    raw_material.raw_engname,
                    raw_material.feed_class,
                    type_raw_material.type_raw_thainame, 
                    GROUP_CONCAT(minerals_detail.minerals_detail_id) as minerals_detail_ids
                FROM 
                    raw_material
                JOIN 
                    type_raw_material ON raw_material.type_raw_id = type_raw_material.type_raw_id
                JOIN 
                    minerals ON raw_material.raw_id = minerals.raw_id
                JOIN 
                    minerals_detail ON minerals.minerals_detail_id = minerals_detail.minerals_detail_id
                WHERE 
                    ISNULL(raw_material.deleteAt)
                GROUP BY 
                    raw_material.raw_id, raw_material.raw_thainame, raw_material.raw_engname, raw_material.feed_class, type_raw_material.type_raw_thainame";
        ?>
        <div class="bg">
            <table class="table" id="table" data-filter-control="true" data-toggle="table" data-locale="th-TH"
                data-search="true" data-flat="true" data-height="580" data-search-highlight="true" data-icons="icons">
                <thead>
                    <tr>
                        <th scope="col" data-searchable="false">ลำดับที่</th>
                        <th data-fileld="name">ชื่อ</th>
                        <th data-searchable="false">กลุ่ม</th>
                        <th data-searchable="false"></th>
                        <th data-searchable="false">Ca</th>
                        <th data-searchable="false">P</th>
                        <th data-searchable="false">Mg</th>
                        <th data-searchable="false">K</th>
                        <th data-searchable="false">S</th>
                        <th data-searchable="false">Na</th>
                        <th data-searchable="false">Cu</th>
                        <th data-searchable="false">Fe</th>
                        <th data-searchable="false">Mn</th>
                        <th data-searchable="false">Zn</th>
                    </tr>
                </thead>
                <tbody class="table-group text-center">
                    <?php
                    $result = mysqli_query($conn, $sqltab2);
                    while ($rowtab2 = mysqli_fetch_assoc($result)) {
                        $raw_id = $rowtab2['raw_id'];
                        $raw_thainame = $rowtab2['raw_thainame'];
                        $raw_engname = $rowtab2['raw_engname'];
                        $type_raw_thainame = $rowtab2['type_raw_thainame'];
                        $minerals_detail_ids = $rowtab2['minerals_detail_ids'];

                        $minerals_detail_array = explode(",", $minerals_detail_ids);
                        $num++;
                        ?>
                        <tr>
                            <td scope="row">
                                <?php echo $num; ?>
                            </td>
                            <th>
                                <?php echo $rowtab2['raw_thainame']; ?>
                                <?php echo "(" . $rowtab2['raw_engname'] . ")"; ?>
                            </th>
                            <th>
                                <?php echo $rowtab2['feed_class']; ?>
                            </th>
                            <?php
                            foreach ($minerals_detail_array as $minerals_detail_id) {
                                $sqlM = "SELECT * FROM minerals_detail WHERE minerals_detail_id = $minerals_detail_id";
                                $resultM = $conn->query($sqlM);

                                if ($resultM) {
                                    while ($row = mysqli_fetch_assoc($resultM)) {
                                        if ($row['type_detail_id'] == 1) {
                                            $dminer_per_ca_avg = $row['dminer_per_ca'];
                                            $dminer_per_p_avg = $row['dminer_per_p'];
                                            $dminer_per_mg_avg = $row['dminer_per_mg'];
                                            $dminer_per_k_avg = $row['dminer_per_k'];
                                            $dminer_per_s_avg = $row['dminer_per_s'];
                                            $dminer_per_na_avg = $row['dminer_per_na'];
                                            $dminer_kg_cu_avg = $row['dminer_kg_cu'];
                                            $dminer_kg_fe_avg = $row['dminer_kg_fe'];
                                            $dminer_kg_mn_avg = $row['dminer_kg_mn'];
                                            $dminer_kg_zn_avg = $row['dminer_kg_zn'];
                                        }
                                        if ($row['type_detail_id'] == 2) {
                                            $dminer_per_ca_sd = $row['dminer_per_ca'];
                                            $dminer_per_p_sd = $row['dminer_per_p'];
                                            $dminer_per_mg_sd = $row['dminer_per_mg'];
                                            $dminer_per_k_sd = $row['dminer_per_k'];
                                            $dminer_per_s_sd = $row['dminer_per_s'];
                                            $dminer_per_na_sd = $row['dminer_per_na'];
                                            $dminer_kg_cu_sd = $row['dminer_kg_cu'];
                                            $dminer_kg_fe_sd = $row['dminer_kg_fe'];
                                            $dminer_kg_mn_sd = $row['dminer_kg_mn'];
                                            $dminer_kg_zn_sd = $row['dminer_kg_zn'];
                                        }
                                        if ($row['type_detail_id'] == 3) {
                                            $dminer_per_ca_n = $row['dminer_per_ca'];
                                            $dminer_per_p_n = $row['dminer_per_p'];
                                            $dminer_per_mg_n = $row['dminer_per_mg'];
                                            $dminer_per_k_n = $row['dminer_per_k'];
                                            $dminer_per_s_n = $row['dminer_per_s'];
                                            $dminer_per_na_n = $row['dminer_per_na'];
                                            $dminer_kg_cu_n = $row['dminer_kg_cu'];
                                            $dminer_kg_fe_n = $row['dminer_kg_fe'];
                                            $dminer_kg_mn_n = $row['dminer_kg_mn'];
                                            $dminer_kg_zn_n = $row['dminer_kg_zn'];
                                        }

                                    }
                                }
                            } ?>
                            <th>AVG</th>
                            <td>
                                <?php echo $dminer_per_ca_avg; ?>
                            </td>
                            <td>
                                <?php echo $dminer_per_p_avg; ?>
                            </td>
                            <td>
                                <?php echo $dminer_per_mg_avg; ?>
                            </td>
                            <td>
                                <?php echo $dminer_per_k_avg; ?>
                            </td>
                            <td>
                                <?php echo $dminer_per_s_avg; ?>
                            </td>
                            <td>
                                <?php echo $dminer_per_na_avg; ?>
                            </td>
                            <td>
                                <?php echo $dminer_kg_cu_avg; ?>
                            </td>
                            <td>
                                <?php echo $dminer_kg_fe_avg; ?>
                            </td>
                            <td>
                                <?php echo $dminer_kg_mn_avg; ?>
                            </td>
                            <td>
                                <?php echo $dminer_kg_zn_avg; ?>
                            </td>
                        </tr>
                        <tr>
                            <td scope="row" rowspan="" hidden></td>
                            <th>
                                <?php echo $rowtab2['raw_thainame']; ?>
                                <?php echo "(" . $rowtab2['raw_engname'] . ")"; ?>
                            </th>
                            <th>
                                <?php echo $rowtab2['feed_class']; ?>
                            </th>
                            <th>SD</th>
                            <td>
                                <?php echo $dminer_per_ca_sd; ?>
                            </td>
                            <td>
                                <?php echo $dminer_per_p_sd; ?>
                            </td>
                            <td>
                                <?php echo $dminer_per_mg_sd; ?>
                            </td>
                            <td>
                                <?php echo $dminer_per_k_sd; ?>
                            </td>
                            <td>
                                <?php echo $dminer_per_s_sd; ?>
                            </td>
                            <td>
                                <?php echo $dminer_per_na_sd; ?>
                            </td>
                            <td>
                                <?php echo $dminer_kg_cu_sd; ?>
                            </td>
                            <td>
                                <?php echo $dminer_kg_fe_sd; ?>
                            </td>
                            <td>
                                <?php echo $dminer_kg_mn_sd; ?>
                            </td>
                            <td>
                                <?php echo $dminer_kg_zn_sd; ?>
                            </td>
                        </tr>
                        <tr>
                            <td scope="row" rowspan="" hidden></td>
                            <th>
                                <?php echo $rowtab2['raw_thainame']; ?>
                                <?php echo "(" . $rowtab2['raw_engname'] . ")"; ?>
                            </th>
                            <th>
                                <?php echo $rowtab2['feed_class']; ?>
                            </th>
                            <th>N</th>
                            <td>
                                <?php echo $dminer_per_ca_n; ?>
                            </td>
                            <td>
                                <?php echo $dminer_per_p_n; ?>
                            </td>
                            <td>
                                <?php echo $dminer_per_mg_n; ?>
                            </td>
                            <td>
                                <?php echo $dminer_per_k_n; ?>
                            </td>
                            <td>
                                <?php echo $dminer_per_s_n; ?>
                            </td>
                            <td>
                                <?php echo $dminer_per_na_n; ?>
                            </td>
                            <td>
                                <?php echo $dminer_kg_cu_n; ?>
                            </td>
                            <td>
                                <?php echo $dminer_kg_fe_n; ?>
                            </td>
                            <td>
                                <?php echo $dminer_kg_mn_n; ?>
                            </td>
                            <td>
                                <?php echo $dminer_kg_zn_n; ?>
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