<?php 
session_start();
include "../server.php";
?>
<?php require "../session/expert_session.php"; ?>
<?php
ini_set('display_errors', 0);
error_reporting(0);
?>
<?php
require_once("pagination_function.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php //include("../header.php"); ?>
    <title>Document</title>
    <script src="dselect.js"></script>
    <link rel="stylesheet" href="raw_style.css">
</head>

<body>
    <?php include("nav-bar.php") ?>

    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col content">
                <div class="container">
                    <div class="content-center">
                        <div id="menu1" class="menu1 menu-content collapse show">
                            <!-- เนื้อหาวัตถุดิบอาหารโคนม -->
                            <h1>วัตถุดิบอาหารโคนมทั้งหมด</h1>
                            <!-- Tabs navs -->
                            <ul class="nav nav-tabs nav-justified" id="ex1" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="tab-1-link" data-bs-toggle="tab" data-bs-target="#tabs-1" href="#tabs-1" role="tab"
                                        aria-controls="tabs-1" aria-selected="true" style="color:black;">คุณค่าทางโภชนะของวัตถุดิบ</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="tab-2-link" data-bs-toggle="tab" data-bs-target="#tabs-2" href="#tabs-2" role="tab"
                                        aria-controls="tabs-2" aria-selected="false" style="color:black;">ปริมาณแร่ธาตุในวัตถุดิบ</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="tab-3-link" data-bs-toggle="tab" data-bs-target="#tabs-3" href="#tabs-3" role="tab"
                                        aria-controls="tabs-3" aria-selected="false" style="color:black;">กรดอะมิโนในวัตถุดิบ</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="tab-content">
                                <div class="tab-pane fade show active" id="tabs-1" role="tabpanel"
                                    aria-labelledby="tab-1-link">
                                    <div class="table-tab overflow-auto">
                                        <div class="row">
                                            <div class="col">                  
                                                <div class="d-flex justify-content-start" style="margin-bottom:2em;">
                                                    <form action="#" method="GET" onsubmit="return handleTabSearch('1');">
                                                        <div class="input-group search">
                                                            <div class="form-outline">
                                                                <input type="hidden" name="current_tab" value="tab-1">
                                                                <input type="text" name="search1" class="form-control" id="search1" placeholder="ค้นหาวัตถุดิบ" />
                                                            </div>
                                                            <button type="submit" class="btn btn-primary" name="submit" >
                                                                <i class="bi bi-search"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <?php
                                            $search_term = isset($_GET['search1']) ? $_GET['search1'] : '';
                                            $current_tab = isset($_GET['current_tab']) ? $_GET['current_tab'] : 'tab-1';
                                            $num = 0;
                                            if ($current_tab == 'tab-1') {
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
                                                            WHERE 
                                                                raw_material.raw_id LIKE '%$search_term%' OR 
                                                                raw_material.raw_thainame LIKE '%$search_term%' OR 
                                                                raw_material.raw_engname LIKE '%$search_term%' OR 
                                                                raw_material.feed_class LIKE '%$search_term%' OR 
                                                                type_raw_material.type_raw_thainame LIKE '%$search_term%'
                                                            GROUP BY 
                                                                raw_material.raw_id, raw_material.raw_thainame, raw_material.raw_engname, raw_material.feed_class, type_raw_material.type_raw_thainame";

                                            } else {
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
                                            }

                                            $resulttab1 = $conn->query($sqltab1);
                                            $total = $resulttab1->num_rows;
                                            $count = 1;


                                            $e_page = 5; // กำหนดจำนวนรายการที่แสดงในแต่ละหน้า   
                                            $step_num = 0;
                                            if (!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] == 1)) {
                                                $_GET['page'] = 1;
                                                $step_num = 0;
                                                $s_page = 0;
                                            } else {
                                                $s_page = $_GET['page'] - 1;
                                                $step_num = $_GET['page'] - 1;
                                                $s_page = $s_page * $e_page;
                                            }
                                            $sqltab1 .= " ORDER BY nutrition_id LIMIT " . $s_page . ",$e_page";
                                            $resulttab1 = $conn->query($sqltab1); ?>
                                            <div class="col">
                                                <div class="d-flex justify-content-end m-2">
                                                    <p>มีข้อมูลทั้งหมด <?php echo $total; ?> รายการ</p>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table text-center raw_all_table" id="tabs-1-content">
                                            <thead>
                                                <tr class="tr_all_top">
                                                    <th>ลำดับที่</th>
                                                    <th>ชื่อ</th>
                                                    <th>Feed Class</th>
                                                    <th></th>
                                                    <th>DM</th>
                                                    <th>CP</th>
                                                    <th>EE</th>
                                                    <th>CF</th>
                                                    <th>Ash</th>
                                                    <th>NFE</th>
                                                    <th>NDF</th>
                                                    <th>ADF</th>
                                                    <th>ADL</th>
                                                    <th>NDICP</th>
                                                    <th>ADICP</th>
                                                    <th>NDFD</th>
                                                    <th>RUP</th>
                                                    <th>DMD</th>
                                                    <th>OMD</th>
                                                    <th>TDN</th>
                                                    <th>DE</th>
                                                    <th>ME</th>
                                                    <th>NEL</th>
                                                    <th>จัดการข้อมูล</th>
                                                </tr>
                                            </thead>
                                            <!----------------------------------------------------------->
                                            <tbody>
                                                <?php
                                                if ($resulttab1 && $resulttab1->num_rows > 0) { // คิวรี่ข้อมูลสำเร็จหรือไม่ และมีรายการข้อมูลหรือไม่
                                                    while ($rowtab1 = $resulttab1->fetch_assoc()) { // วนลูปแสดงรายการ
                                                        $raw_id = $rowtab1['raw_id'];
                                                        $raw_thainame = $rowtab1['raw_thainame'];
                                                        $raw_engname = $rowtab1['raw_engname'];
                                                        $type_raw_thainame = $rowtab1['type_raw_thainame'];
                                                        $nutrition_detail_ids = $rowtab1['nutrition_detail_ids'];

                                                        $nutrition_detail_array = explode(",", $nutrition_detail_ids);
                                                        $num++;
                                                        ?>
                                                        <tr>
                                                            <th class="text-center" scope="row" rowspan="3">
                                                                <?php echo ($step_num * $e_page) + $num; ?>
                                                            </th>
                                                            <th rowspan="3">
                                                                <?php echo $rowtab1['raw_thainame']; ?>
                                                                <?php echo "(" . $rowtab1['raw_engname'] . ")"; ?>
                                                            </th>
                                                            <th rowspan="3">
                                                                <?php echo $rowtab1['feed_class']; ?>
                                                            </th>
                                                                <?php
                                                                foreach ($nutrition_detail_array as $nutrition_detail_id) {
                                                                    $sql = "SELECT * FROM nutrition_detail WHERE nutrition_detail_id = $nutrition_detail_id";
                                                                    $result = $conn->query($sql);

                                                                    if ($result && $result->num_rows > 0) {
                                                                        while ($row = $result->fetch_assoc()) {
                                                                            // ในที่นี้คุณสามารถใช้ $row เพื่อเข้าถึงข้อมูลจากตาราง nutrition_detail
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
                                                            <td><?php echo $dnut_dm_avg; ?></td>
                                                            <td><?php echo $dnut_cp_avg; ?></td>
                                                            <td><?php echo $dnut_ee_avg; ?></td>
                                                            <td><?php echo $dnut_cf_avg; ?></td>
                                                            <td><?php echo $dnut_ash_avg; ?></td>
                                                            <td><?php echo $dnut_nfe_avg; ?></td>
                                                            <td><?php echo $dnut_ndf_avg; ?></td>
                                                            <td><?php echo $dnut_adf_avg; ?></td>
                                                            <td><?php echo $dnut_adl_avg; ?></td>
                                                            <td><?php echo $dnut_ndicp_avg; ?></td>
                                                            <td><?php echo $dnut_adicp_avg; ?></td>
                                                            <td><?php echo $dnut_ndfd_avg; ?></td>
                                                            <td><?php echo $dnut_rup_avg; ?></td>
                                                            <td><?php echo $dnut_dmd_avg; ?></td>
                                                            <td><?php echo $dnut_omd_avg; ?></td>
                                                            <td><?php echo $dnut_tdn_avg; ?></td>
                                                            <td><?php echo $dnut_de_avg; ?></td>
                                                            <td><?php echo $dnut_me_avg; ?></td>
                                                            <td><?php echo $dnut_nel_avg; ?></td>
                                                            <td rowspan="3">
                                                                <div class="row p-2 text-center d-flex justify-content-center">
                                                                    <div>
                                                                        <button class="btn btn-warning mb-2" style="width: 3em;" onclick="window.location.href='nutrition_edit.php?id=<?php echo $rowtab1['raw_id']; ?>'">
                                                                            <i class="fa-solid fa-pen-to-square" style="color: #000000;"></i>
                                                                        </button>
                                                                    </div>
                                                                    <div>       
                                                                        <button type="button" class="btn btn-danger" style="width: 3em;"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#ModalDeleteRawTab1<?php echo $rowtab1['raw_id']; ?>" 
                                                                            data-bs-toggle="tooltip" 
                                                                            title="ลบ">
                                                                            <i class="fa-solid fa-trash-can" style="color: #ffffff;"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>SD</th>
                                                            <td><?php echo $dnut_dm_sd; ?></td>
                                                            <td><?php echo $dnut_cp_sd; ?></td>
                                                            <td><?php echo $dnut_ee_sd; ?></td>
                                                            <td><?php echo $dnut_cf_sd; ?></td>
                                                            <td><?php echo $dnut_ash_sd; ?></td>
                                                            <td><?php echo $dnut_nfe_sd; ?></td>
                                                            <td><?php echo $dnut_ndf_sd; ?></td>
                                                            <td><?php echo $dnut_adf_sd; ?></td>
                                                            <td><?php echo $dnut_adl_sd; ?></td>
                                                            <td><?php echo $dnut_ndicp_sd; ?></td>
                                                            <td><?php echo $dnut_adicp_sd; ?></td>
                                                            <td><?php echo $dnut_ndfd_sd; ?></td>
                                                            <td><?php echo $dnut_rup_sd; ?></td>
                                                            <td><?php echo $dnut_dmd_sd; ?></td>
                                                            <td><?php echo $dnut_omd_sd; ?></td>
                                                            <td><?php echo $dnut_tdn_sd; ?></td>
                                                            <td><?php echo $dnut_de_sd; ?></td>
                                                            <td><?php echo $dnut_me_sd; ?></td>
                                                            <td><?php echo $dnut_nel_sd; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>N</th>
                                                            <td><?php echo $dnut_dm_n; ?></td>
                                                            <td><?php echo $dnut_cp_n; ?></td>
                                                            <td><?php echo $dnut_ee_n; ?></td>
                                                            <td><?php echo $dnut_cf_n; ?></td>
                                                            <td><?php echo $dnut_ash_n; ?></td>
                                                            <td><?php echo $dnut_nfe_n; ?></td>
                                                            <td><?php echo $dnut_ndf_n; ?></td>
                                                            <td><?php echo $dnut_adf_n; ?></td>
                                                            <td><?php echo $dnut_adl_n; ?></td>
                                                            <td><?php echo $dnut_ndicp_n; ?></td>
                                                            <td><?php echo $dnut_adicp_n; ?></td>
                                                            <td><?php echo $dnut_ndfd_n; ?></td>
                                                            <td><?php echo $dnut_rup_n; ?></td>
                                                            <td><?php echo $dnut_dmd_n; ?></td>
                                                            <td><?php echo $dnut_omd_n; ?></td>
                                                            <td><?php echo $dnut_tdn_n; ?></td>
                                                            <td><?php echo $dnut_de_n; ?></td>
                                                            <td><?php echo $dnut_me_n; ?></td>
                                                            <td><?php echo $dnut_nel_n; ?></td>
                                                        </tr>
                                                        <?php $count++; ?>
                                                    </tbody>
                                                        <!-- Modal อันนี้จ้า--> 
                                                                <div class="modal fade" id="ModalDeleteRawTab1<?php echo $rowtab1['raw_id']; ?>"
                                                                    tabindex="-1" aria-labelledby="ModalDeleteRawTab1Label" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h2 class="modal-title fs-5" id="ModalDeleteRawTab1Label">Modal
                                                                                    title</h2>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <?php echo $rowtab1['raw_id']; ?>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">Close</button>
                                                                                <button type="button" class="btn btn-primary">Save
                                                                                    changes</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- End Modal -->
                                                                <?php
                                                    }
                                                }
                                                ?>
                                        </table>
                                    </div>
                                    <div style="background-color: white;" class="mt-4">
                                        <?php
                                        page_navi($total, (isset($_GET['page'])) ? $_GET['page'] : 1, $e_page);
                                        ?>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tabs-2" role="tabpanel" aria-labelledby="tab-2-link">
                                    <div class="table-tab overflow-auto">
                                        <div class="row">
                                            <div class="col">                  
                                                <div class="d-flex justify-content-start" style="margin-bottom:2em;">
                                                    <form action="#" method="GET" onsubmit="return handleTabSearch('2');">
                                                        <div class="input-group search">
                                                            <div class="form-outline">
                                                                <input type="hidden" name="current_tab" value="tab-2">
                                                                <input type="text" name="search2" class="form-control" id="search2" placeholder="ค้นหาวัตถุดิบ" />
                                                            </div>
                                                            <button type="submit" class="btn btn-primary" name="submit" >
                                                                <i class="bi bi-search"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <?php
                                            $search_term = isset($_GET['search2']) ? $_GET['search2'] : '';
                                            $current_tab = isset($_GET['current_tab']) ? $_GET['current_tab'] : 'tab-2';
                                            $num = 0;
                                            if ($current_tab == 'tab-2') {
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
                                                                raw_material.raw_id LIKE '%$search_term%' OR 
                                                                raw_material.raw_thainame LIKE '%$search_term%' OR 
                                                                raw_material.raw_engname LIKE '%$search_term%' OR 
                                                                raw_material.feed_class LIKE '%$search_term%' OR 
                                                                type_raw_material.type_raw_thainame LIKE '%$search_term%'
                                                            GROUP BY 
                                                                raw_material.raw_id, raw_material.raw_thainame, raw_material.raw_engname, raw_material.feed_class, type_raw_material.type_raw_thainame";
                                            } else {
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
                                                            GROUP BY 
                                                                raw_material.raw_id, raw_material.raw_thainame, raw_material.raw_engname, raw_material.feed_class, type_raw_material.type_raw_thainame";
                                            }

                                            $resulttab2 = $conn->query($sqltab2);
                                            $total = $resulttab2->num_rows;
                                            $count = 1;


                                            $e_page = 5; // กำหนดจำนวนรายการที่แสดงในแต่ละหน้า   
                                            $step_num = 0;
                                            if (!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] == 1)) {
                                                $_GET['page'] = 1;
                                                $step_num = 0;
                                                $s_page = 0;
                                            } else {
                                                $s_page = $_GET['page'] - 1;
                                                $step_num = $_GET['page'] - 1;
                                                $s_page = $s_page * $e_page;
                                            }
                                            $sqltab2 .= " ORDER BY minerals_id LIMIT " . $s_page . ",$e_page";
                                            $resulttab2 = $conn->query($sqltab2); ?>
                                            <div class="col">
                                                <div class="d-flex justify-content-end m-2">
                                                    <p>มีข้อมูลทั้งหมด <?php echo $total; ?> รายการ</p>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table text-center raw_all_table"  id="tabs-2-content">
                                            <thead>
                                                <tr class="tr_all_top">
                                                    <th>ลำดับที่</th>
                                                    <th>ชื่อ</th>
                                                    <th>Feed Class</th>
                                                    <th></th>
                                                    <th>Ca</th>
                                                    <th>P</th>
                                                    <th>Mg</th>
                                                    <th>K</th>
                                                    <th>S</th>
                                                    <th>Na</th>
                                                    <th>Cu</th>
                                                    <th>Fe</th>
                                                    <th>Mn</th>
                                                    <th>Zn</th>
                                                    <th>จัดการข้อมูล</th>
                                                </tr>
                                            </thead>
                                            <!----------------------------------------------------------->
                                            <tbody>
                                                <?php
                                                if ($resulttab2 && $resulttab2->num_rows > 0) { // คิวรี่ข้อมูลสำเร็จหรือไม่ และมีรายการข้อมูลหรือไม่
                                                    while ($rowtab2 = $resulttab2->fetch_assoc()) { // วนลูปแสดงรายการ
                                                        $raw_id = $rowtab2['raw_id'];
                                                        $raw_thainame = $rowtab2['raw_thainame'];
                                                        $raw_engname = $rowtab2['raw_engname'];
                                                        $type_raw_thainame = $rowtab2['type_raw_thainame'];
                                                        $minerals_detail_ids = $rowtab2['minerals_detail_ids'];

                                                        $minerals_detail_array = explode(",", $minerals_detail_ids);
                                                        $num++;
                                                        ?>
                                                <tr>
                                                    <th class="text-center" scope="row" rowspan="3">
                                                        <?php echo ($step_num * $e_page) + $num; ?>
                                                    </th>
                                                    <th rowspan="3">
                                                        <?php echo $rowtab2['raw_thainame']; ?>
                                                        <?php echo "(" . $rowtab2['raw_engname'] . ")"; ?>
                                                    </th>
                                                    <th rowspan="3">
                                                        <?php echo $rowtab2['feed_class']; ?>
                                                    </th>
                                                    <?php
                                                    foreach ($minerals_detail_array as $minerals_detail_id) {
                                                        $sql = "SELECT * FROM minerals_detail WHERE minerals_detail_id = $minerals_detail_id";
                                                        $result = $conn->query($sql);

                                                        if ($result && $result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
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
                                                    <td><?php echo $dminer_per_ca_avg; ?></td>
                                                    <td><?php echo $dminer_per_p_avg; ?></td>
                                                    <td><?php echo $dminer_per_mg_avg; ?></td>
                                                    <td><?php echo $dminer_per_k_avg; ?></td>
                                                    <td><?php echo $dminer_per_s_avg; ?></td>
                                                    <td><?php echo $dminer_per_na_avg; ?></td>
                                                    <td><?php echo $dminer_kg_cu_avg; ?></td>
                                                    <td><?php echo $dminer_kg_fe_avg; ?></td>
                                                    <td><?php echo $dminer_kg_mn_avg; ?></td>
                                                    <td><?php echo $dminer_kg_zn_avg; ?></td>  
                                                    <td rowspan="3">
                                                        <div class="row p-2 text-center d-flex justify-content-center">
                                                            <div>
                                                                <button class="btn btn-warning mb-2" style="width: 3em;" onclick="window.location.href='minerals_edit.php?id=<?php echo $rowtab2['raw_id']; ?>'">
                                                                    <i class="fa-solid fa-pen-to-square" style="color: #000000;"></i>
                                                                </button>
                                                            </div>
                                                            <div>       
                                                                <button type="button" class="btn btn-danger" style="width: 3em;"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#ModalDeleteRawTab2<?php echo $rowtab2['raw_id']; ?>" 
                                                                    data-bs-toggle="tooltip" 
                                                                    title="ลบ">
                                                                    <i class="fa-solid fa-trash-can" style="color: #ffffff;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>SD</th>
                                                    <td><?php echo $dminer_per_ca_sd; ?></td>
                                                    <td><?php echo $dminer_per_p_sd; ?></td>
                                                    <td><?php echo $dminer_per_mg_sd; ?></td>
                                                    <td><?php echo $dminer_per_k_sd; ?></td>
                                                    <td><?php echo $dminer_per_s_sd; ?></td>
                                                    <td><?php echo $dminer_per_na_sd; ?></td>
                                                    <td><?php echo $dminer_kg_cu_sd; ?></td>
                                                    <td><?php echo $dminer_kg_fe_sd; ?></td>
                                                    <td><?php echo $dminer_kg_mn_sd; ?></td>
                                                    <td><?php echo $dminer_kg_zn_sd; ?></td>  
                                                </tr>
                                                <tr>
                                                    <th>N</th>
                                                    <td><?php echo $dminer_per_ca_n; ?></td>
                                                    <td><?php echo $dminer_per_p_n; ?></td>
                                                    <td><?php echo $dminer_per_mg_n; ?></td>
                                                    <td><?php echo $dminer_per_k_n; ?></td>
                                                    <td><?php echo $dminer_per_s_n; ?></td>
                                                    <td><?php echo $dminer_per_na_n; ?></td>
                                                    <td><?php echo $dminer_kg_cu_n; ?></td>
                                                    <td><?php echo $dminer_kg_fe_n; ?></td>
                                                    <td><?php echo $dminer_kg_mn_n; ?></td>
                                                    <td><?php echo $dminer_kg_zn_n; ?></td>  
                                                </tr>
                                                <?php $count++; ?>
                                            </tbody>
                                                <!-- Modal -->
                                                        <div class="modal fade" id="ModalDeleteRawTab2<?php echo $rowtab2['raw_id']; ?>"
                                                            tabindex="-1" aria-labelledby="ModalDeleteRawTab2Label" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h2 class="modal-title fs-5" id="ModalDeleteRawTab2Label">Modal
                                                                            title</h2>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <?php echo $rowtab2['raw_id']; ?>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button type="button" class="btn btn-primary">Save
                                                                            changes</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End Modal -->
                                                        <?php
                                                    }
                                                }
                                                ?>
                                        </table>
                                    </div>
                                    <div style="background-color: white;" class="mt-4">
                                        <?php
                                        page_navi($total, (isset($_GET['page'])) ? $_GET['page'] : 1, $e_page);
                                        ?>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="tabs-3" role="tabpanel" aria-labelledby="tab-3-link">
                                    <div class="table-tab overflow-auto">
                                        <div class="row">
                                            <div class="col">                  
                                                <div class="d-flex justify-content-start" style="margin-bottom:2em;">
                                                    <form action="#" method="GET" onsubmit="return handleTabSearch('3');">
                                                        <div class="input-group search">
                                                            <div class="form-outline">
                                                                <input type="hidden" name="current_tab" value="tab-3">
                                                                <input type="text" name="search3" class="form-control" id="search3" placeholder="ค้นหาวัตถุดิบ" />
                                                            </div>
                                                            <button type="submit" class="btn btn-primary" name="submit" >
                                                                <i class="bi bi-search"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <?php
                                            $search_term = isset($_GET['search3']) ? $_GET['search3'] : '';
                                            $current_tab = isset($_GET['current_tab']) ? $_GET['current_tab'] : 'tab-3';
                                            $num = 0;
                                            if ($current_tab == 'tab-3') {
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
                                                            WHERE 
                                                                raw_material.raw_id LIKE '%$search_term%' OR 
                                                                raw_material.raw_thainame LIKE '%$search_term%' OR 
                                                                raw_material.raw_engname LIKE '%$search_term%' OR 
                                                                raw_material.feed_class LIKE '%$search_term%' OR 
                                                                type_raw_material.type_raw_thainame LIKE '%$search_term%'
                                                            GROUP BY 
                                                                raw_material.raw_id, raw_material.raw_thainame, raw_material.raw_engname, raw_material.feed_class, type_raw_material.type_raw_thainame";

                                            } else {
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
                                            }

                                            $resulttab3 = $conn->query($sqltab3);
                                            $total = $resulttab3->num_rows;
                                            $count = 1;


                                            $e_page = 5; // กำหนดจำนวนรายการที่แสดงในแต่ละหน้า   
                                            $step_num = 0;
                                            if (!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] == 1)) {
                                                $_GET['page'] = 1;
                                                $step_num = 0;
                                                $s_page = 0;
                                            } else {
                                                $s_page = $_GET['page'] - 1;
                                                $step_num = $_GET['page'] - 1;
                                                $s_page = $s_page * $e_page;
                                            }
                                            $sqltab3 .= " ORDER BY material_id LIMIT " . $s_page . ",$e_page";
                                            $resulttab3 = $conn->query($sqltab3); ?>
                                            <div class="col">
                                                <div class="d-flex justify-content-end m-2">
                                                    <p>มีข้อมูลทั้งหมด <?php echo $total; ?> รายการ</p>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table text-center raw_all_table"  id="tabs-3-content">
                                            <thead>
                                                <tr class="tr_all_top">
                                                    <th>ลำดับที่</th>
                                                    <th>ชื่อ</th>
                                                    <th>Feed Class</th>
                                                    <th></th>
                                                    <th>Ala</th>
                                                    <th>Arg</th>
                                                    <th>Asp</th>
                                                    <th>Cys</th>
                                                    <th>Glu</th>
                                                    <th>Gly</th>
                                                    <th>His</th>
                                                    <th>Hyl</th>
                                                    <th>Hyp</th>
                                                    <th>Ile</th>
                                                    <th>Leu</th>
                                                    <th>Lys</th>
                                                    <th>Met</th>
                                                    <th>Phe</th>
                                                    <th>Pro</th>
                                                    <th>Ser</th>
                                                    <th>Thr</th>
                                                    <th>Trp</th>
                                                    <th>Try</th>
                                                    <th>Val</th>
                                                    <th>จัดการข้อมูล</th>
                                                </tr>
                                            </thead>
                                            <!----------------------------------------------------------->
                                            <tbody>
                                                <?php
                                                if ($resulttab3 && $resulttab3->num_rows > 0) { // คิวรี่ข้อมูลสำเร็จหรือไม่ และมีรายการข้อมูลหรือไม่
                                                    while ($rowtab3 = $resulttab3->fetch_assoc()) { // วนลูปแสดงรายการ
                                                        $raw_id = $rowtab3['raw_id'];
                                                        $raw_thainame = $rowtab3['raw_thainame'];
                                                        $raw_engname = $rowtab3['raw_engname'];
                                                        $type_raw_thainame = $rowtab3['type_raw_thainame'];
                                                        $material_detail_ids = $rowtab3['material_detail_ids'];

                                                        $material_detail_array = explode(",", $material_detail_ids);
                                                        $num++;
                                                        ?>
                                                <tr>
                                                    <th class="text-center" scope="row" rowspan="3">
                                                        <?php echo ($step_num * $e_page) + $num; ?>
                                                    </th>
                                                    <th rowspan="3">
                                                        <?php echo $rowtab3['raw_thainame']; ?>
                                                        <?php echo "(" . $rowtab3['raw_engname'] . ")"; ?>
                                                    </th>
                                                    <th rowspan="3">
                                                        <?php echo $rowtab3['feed_class']; ?>
                                                    </th>
                                                    <?php
                                                    foreach ($material_detail_array as $material_detail_id) {
                                                        $sql = "SELECT * FROM material_detail WHERE material_detail_id = $material_detail_id";
                                                        $result = $conn->query($sql);

                                                        if ($result && $result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
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
                                                    <td><?php echo $dmat_ala_avg; ?></td>
                                                    <td><?php echo $dmat_arg_avg; ?></td>
                                                    <td><?php echo $dmat_asp_avg; ?></td>
                                                    <td><?php echo $dmat_cys_avg; ?></td>
                                                    <td><?php echo $dmat_glu_avg; ?></td>
                                                    <td><?php echo $dmat_gly_avg; ?></td>
                                                    <td><?php echo $dmat_his_avg; ?></td>
                                                    <td><?php echo $dmat_hyl_avg; ?></td>
                                                    <td><?php echo $dmat_hyp_avg; ?></td>
                                                    <td><?php echo $dmat_ile_avg; ?></td>
                                                    <td><?php echo $dmat_leu_avg; ?></td>
                                                    <td><?php echo $dmat_lys_avg; ?></td>
                                                    <td><?php echo $dmat_met_avg; ?></td>
                                                    <td><?php echo $dmat_phe_avg; ?></td>
                                                    <td><?php echo $dmat_pro_avg; ?></td>
                                                    <td><?php echo $dmat_ser_avg; ?></td>
                                                    <td><?php echo $dmat_thr_avg; ?></td>
                                                    <td><?php echo $dmat_trp_avg; ?></td>
                                                    <td><?php echo $dmat_tyr_avg; ?></td>
                                                    <td><?php echo $dmat_val_avg; ?></td>
                                                    <td rowspan="3">
                                                        <div class="row p-2 text-center d-flex justify-content-center">
                                                            <div>
                                                                <button class="btn btn-warning mb-2" style="width: 3em;" onclick="window.location.href='material_edit.php?id=<?php echo $rowtab3['raw_id']; ?>'">
                                                                    <i class="fa-solid fa-pen-to-square" style="color: #000000;"></i>
                                                                </button>
                                                            </div>
                                                            <div>       
                                                                <button type="button" class="btn btn-danger" style="width: 3em;"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#ModalDeleteRawTab3<?php echo $rowtab3['raw_id']; ?>" 
                                                                    data-bs-toggle="tooltip" 
                                                                    title="ลบ">
                                                                    <i class="fa-solid fa-trash-can" style="color: #ffffff;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>SD</th>
                                                    <td><?php echo $dmat_ala_sd; ?></td>
                                                    <td><?php echo $dmat_arg_sd; ?></td>
                                                    <td><?php echo $dmat_asp_sd; ?></td>
                                                    <td><?php echo $dmat_cys_sd; ?></td>
                                                    <td><?php echo $dmat_glu_sd; ?></td>
                                                    <td><?php echo $dmat_gly_sd; ?></td>
                                                    <td><?php echo $dmat_his_sd; ?></td>
                                                    <td><?php echo $dmat_hyl_sd; ?></td>
                                                    <td><?php echo $dmat_hyp_sd; ?></td>
                                                    <td><?php echo $dmat_ile_sd; ?></td>
                                                    <td><?php echo $dmat_leu_sd; ?></td>
                                                    <td><?php echo $dmat_lys_sd; ?></td>
                                                    <td><?php echo $dmat_met_sd; ?></td>
                                                    <td><?php echo $dmat_phe_sd; ?></td>
                                                    <td><?php echo $dmat_pro_sd; ?></td>
                                                    <td><?php echo $dmat_ser_sd; ?></td>
                                                    <td><?php echo $dmat_thr_sd; ?></td>
                                                    <td><?php echo $dmat_trp_sd; ?></td>
                                                    <td><?php echo $dmat_tyr_sd; ?></td>
                                                    <td><?php echo $dmat_val_sd; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>N</th>
                                                    <td><?php echo $dmat_ala_n; ?></td>
                                                    <td><?php echo $dmat_arg_n; ?></td>
                                                    <td><?php echo $dmat_asp_n; ?></td>
                                                    <td><?php echo $dmat_cys_n; ?></td>
                                                    <td><?php echo $dmat_glu_n; ?></td>
                                                    <td><?php echo $dmat_gly_n; ?></td>
                                                    <td><?php echo $dmat_his_n; ?></td>
                                                    <td><?php echo $dmat_hyl_n; ?></td>
                                                    <td><?php echo $dmat_hyp_n; ?></td>
                                                    <td><?php echo $dmat_ile_n; ?></td>
                                                    <td><?php echo $dmat_leu_n; ?></td>
                                                    <td><?php echo $dmat_lys_n; ?></td>
                                                    <td><?php echo $dmat_met_n; ?></td>
                                                    <td><?php echo $dmat_phe_n; ?></td>
                                                    <td><?php echo $dmat_pro_n; ?></td>
                                                    <td><?php echo $dmat_ser_n; ?></td>
                                                    <td><?php echo $dmat_thr_n; ?></td>
                                                    <td><?php echo $dmat_trp_n; ?></td>
                                                    <td><?php echo $dmat_tyr_n; ?></td>
                                                    <td><?php echo $dmat_val_n; ?></td>
                                                </tr>
                                                <?php $count++; ?>
                                            </tbody>
                                            <!-- Modal -->
                                            <div class="modal fade" id="ModalDeleteRawTab3<?php echo $rowtab3['raw_id']; ?>"
                                                tabindex="-1" aria-labelledby="ModalDeleteRawTab3Label" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h2 class="modal-title fs-5" id="ModalDeleteRawTab3Label">Modal
                                                                title</h2>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php echo $rowtab3['raw_id']; ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save
                                                                changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Modal -->
                                            <?php
                                        }
                                    }
                                    ?>
                                        </table>
                                    </div>
                                    <div style="background-color: white;" class="mt-4">
                                        <?php
                                        page_navi($total, (isset($_GET['page'])) ? $_GET['page'] : 1, $e_page);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Tabs content -->
                        </div>
                        <div id="menu3" class="menu3 menu-content collapse">
                            <!-- คุณค่าทางโภชนะของวัตถุดิบ -->
                            <h1>เพิ่มคุณค่าทางโภชนะของวัตถุดิบ</h1>
                            <form class="" action="nutrition_detail.php" method="post" enctype="multipart/form-data"
                                id="nutrition_detail">
                                <div class="row t1-1 t22">
                                    <div class="col-6">
                                        <div class="cate-raw">
                                            <label for="type_raw_id" class="form-label">หมวดหมู่</label>
                                            <select name="type_id" id="type_raw_id" class="form-select" required>
                                                <option selected disabled>เลือกหมวดหมู่วัตถุดิบ</option>
                                                <?php
                                                $sql = "SELECT * FROM type_raw_material";
                                                $result = $conn->query($sql);

                                                while ($raw = $result->fetch_assoc()):
                                                    ?>
                                                        <option value="<?php echo $raw["type_raw_id"]; ?>">
                                                            <?php echo $raw["type_raw_thainame"]; ?>
                                                        </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="data1-1" class="form-label">Feed Class</label>
                                        <select class="form-select" aria-label="Feed Class" id="data1-1"
                                            name="feed_class" required>
                                            <option selected disabled>เลือก Feed Class</option>
                                            <option value="1">1 (พืชอาหารสัตว์หมัก สด แห้งและอาหารหยาบแห้ง)</option>
                                            <option value="2">2 (วัตถุดิบแหล่งโปรตีน)</option>
                                            <option value="3">3 (วัตถุดิบแหล่งพลังงาน)</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="data1-2" class="form-label">ชื่อสามัญภาษาไทย</label>
                                        <input type="text" class="form-control" id="data1-2" name="raw_thainame"
                                            placeholder="กรอกชื่อสามัญภาษาไทย" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="data1-3" class="form-label">ชื่อสามัญภาษาอังกฤษ</label>
                                        <input type="text" class="form-control" id="data1-3" name="raw_engname"
                                            placeholder="กรอกชื่อสามัญภาษาอังกฤษ">
                                    </div>
                                </div>
                                <div class="" id="2nd" role="tabpanel" aria-labelledby="2nd-tab" tabindex="0">
                                    <div>
                                        <p>* หากไม่มีข้อมูลในรายการนั้นให้กรอก ND (No data)</p>
                                        <p>* หากไม่สามารถตรวจวัดข้อมูลได้ให้กรอก Nd (No detect)</p>
                                    </div>
                                    <div class="table-responsive py-4 table">
                                        <table class="table table-bordered">
                                            <thead class="thead-primary ">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">AVG</th>
                                                    <th scope="col">SD</th>
                                                    <th scope="col">N</th>
                                                    <th scope="col">หน่วย</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">ค่าวัตถุแห้ง (DM)</th>
                                                    <td><input type="text" class="form-control" id="data2-1-1"
                                                            name="dnut_dm_avg"></td>
                                                    <td><input type="text" class="form-control" id="data2-1-2"
                                                            name="dnut_dm_sd"></td>
                                                    <td><input type="text" class="form-control" id="data2-1-3"
                                                            name="dnut_dm_n"></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">ค่าโปรตีนหยาบ (CP)</th>
                                                    <td><input type="text" class="form-control" id="data2-2-1"
                                                            name="dnut_cp_avg"></td>
                                                    <td><input type="text" class="form-control" id="data2-2-2"
                                                            name="dnut_cp_sd"></td>
                                                    <td><input type="text" class="form-control" id="data2-2-3"
                                                            name="dnut_cp_n"></td>
                                                    <td rowspan="8" class="text-center">% on DM</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าไขมัน (EE)</th>
                                                    <td><input type="text" class="form-control" id="data2-3-1"
                                                            name="dnut_ee_avg"></td>
                                                    <td><input type="text" class="form-control" id="data2-3-2"
                                                            name="dnut_ee_sd"></td>
                                                    <td><input type="text" class="form-control" id="data2-3-3"
                                                            name="dnut_ee_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าเยื่อใยหยาบ (CF)</th>
                                                    <td><input type="text" class="form-control" id="data2-4-1"
                                                            name="dnut_cf_avg"></td>
                                                    <td><input type="text" class="form-control" id="data2-4-2"
                                                            name="dnut_cf_sd"></td>
                                                    <td><input type="text" class="form-control" id="data2-4-3"
                                                            name="dnut_cf_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าเถ้า (Ash)</th>
                                                    <td><input type="text" class="form-control" id="data2-5-1"
                                                            name="dnut_ash_avg"></td>
                                                    <td><input type="text" class="form-control" id="data2-5-2"
                                                            name="dnut_ash_sd"></td>
                                                    <td><input type="text" class="form-control" id="data2-5-3"
                                                            name="dnut_ash_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าแป้งและน้ำตาล (NFE)</th>
                                                    <td><input type="text" class="form-control" id="data2-6-1"
                                                            name="dnut_nfe_avg"></td>
                                                    <td><input type="text" class="form-control" id="data2-6-2"
                                                            name="dnut_nfe_sd"></td>
                                                    <td><input type="text" class="form-control" id="data2-6-3"
                                                            name="dnut_nfe_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าเยื่อใยที่ไม่สามารถละลายได้ในสารฟอกที่เป็นกลาง
                                                        (NDF)</th>
                                                    <td><input type="text" class="form-control" id="data2-7-1"
                                                            name="dnut_ndf_avg"></td>
                                                    <td><input type="text" class="form-control" id="data2-7-2"
                                                            name="dnut_ndf_sd"></td>
                                                    <td><input type="text" class="form-control" id="data2-7-3"
                                                            name="dnut_ndf_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าเยื่อใยที่ไม่สามารถละลายได้ในสารฟอกที่เป็นกรด
                                                        (ADF)</th>
                                                    <td><input type="text" class="form-control" id="data2-8-1"
                                                            name="dnut_adf_avg"></td>
                                                    <td><input type="text" class="form-control" id="data2-8-2"
                                                            name="dnut_adf_sd"></td>
                                                    <td><input type="text" class="form-control" id="data2-8-3"
                                                            name="dnut_adf_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าลิกนิน (ADL)</th>
                                                    <td><input type="text" class="form-control" id="data2-9-1"
                                                            name="dnut_adl_avg"></td>
                                                    <td><input type="text" class="form-control" id="data2-9-2"
                                                            name="dnut_adl_sd"></td>
                                                    <td><input type="text" class="form-control" id="data2-9-3"
                                                            name="dnut_adl_n"></td>
                                                </tr>
                                            </tbody>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">
                                                        ค่าโปรตีนในเยื่อใยที่ไม่สามารถละลายได้ในสารฟอกที่เป็นกลาง
                                                        (NDICP)</th>
                                                    <td><input type="text" class="form-control" id="data2-10-1"
                                                            name="dnut_ndicp_avg"></td>
                                                    <td><input type="text" class="form-control" id="data2-10-2"
                                                            name="dnut_ndicp_sd"></td>
                                                    <td><input type="text" class="form-control" id="data2-10-3"
                                                            name="dnut_ndicp_n"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        ค่าโปรตีนในเยื่อใยที่ไม่สามารถละลายได้ในสารฟอกที่เป็นกรด (ADICP)
                                                    </th>
                                                    <td><input type="text" class="form-control" id="data2-11-1"
                                                            name="dnut_adicp_avg"></td>
                                                    <td><input type="text" class="form-control" id="data2-11-2"
                                                            name="dnut_adicp_sd"></td>
                                                    <td><input type="text" class="form-control" id="data2-11-3"
                                                            name="dnut_adicp_n"></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">ค่าการย่อยได้ของผนังเซลล์ (NDFD)</th>
                                                    <td><input type="text" class="form-control" id="data2-12-1"
                                                            name="dnut_ndfd_avg"></td>
                                                    <td><input type="text" class="form-control" id="data2-12-2"
                                                            name="dnut_ndfd_sd"></td>
                                                    <td><input type="text" class="form-control" id="data2-12-3"
                                                            name="dnut_ndfd_n"></td>
                                                    <td class="text-center">%of NDF</td>
                                                </tr>
                                            </tbody>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">ค่าโปรตีนที่ไม่ย่อยสลายได้ในกระเพาะหมัก (RUP)</th>
                                                    <td><input type="text" class="form-control" id="data2-13-1"
                                                            name="dnut_rup_avg"></td>
                                                    <td><input type="text" class="form-control" id="data2-13-2"
                                                            name="dnut_rup_sd"></td>
                                                    <td><input type="text" class="form-control" id="data2-13-3"
                                                            name="dnut_rup_n"></td>
                                                    <td class="text-center">%of protein</td>
                                                </tr>
                                            </tbody>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">ค่าการย่อยได้ของวัตถุแห้ง (DMD)</th>
                                                    <td><input type="text" class="form-control" id="data2-14-1"
                                                            name="dnut_dmd_avg"></td>
                                                    <td><input type="text" class="form-control" id="data2-14-2"
                                                            name="dnut_dmd_sd"></td>
                                                    <td><input type="text" class="form-control" id="data2-14-3"
                                                            name="dnut_dmd_n"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าการย่อยได้ของอันทรียวัตถุ (OMD)</th>
                                                    <td><input type="text" class="form-control" id="data2-15-1"
                                                            name="dnut_omd_avg"></td>
                                                    <td><input type="text" class="form-control" id="data2-15-2"
                                                            name="dnut_omd_sd"></td>
                                                    <td><input type="text" class="form-control" id="data2-15-3"
                                                            name="dnut_omd_n"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าโภชนะที่สามารถย่อยได้รวมมทั้งหมด (TDN)</th>
                                                    <td><input type="text" class="form-control" id="data2-16-1"
                                                            name="dnut_tdn_avg"></td>
                                                    <td><input type="text" class="form-control" id="data2-16-2"
                                                            name="dnut_tdn_sd"></td>
                                                    <td><input type="text" class="form-control" id="data2-16-3"
                                                            name="dnut_tdn_n"></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">ค่าพลังงานที่ย่อยได้ (DE)</th>
                                                    <td><input type="text" class="form-control" id="data2-17-1"
                                                            name="dnut_de_avg"></td>
                                                    <td><input type="text" class="form-control" id="data2-17-2"
                                                            name="dnut_de_sd"></td>
                                                    <td><input type="text" class="form-control" id="data2-17-3"
                                                            name="dnut_de_n"></td>
                                                    <td rowspan="3" class="text-center">Mcal/kgDM</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าพลังงานที่สามารถใช้ปนะโยชน์ได้ (ME)</th>
                                                    <td><input type="text" class="form-control" id="data2-18-1"
                                                            name="dnut_me_avg"></td>
                                                    <td><input type="text" class="form-control" id="data2-18-2"
                                                            name="dnut_me_sd"></td>
                                                    <td><input type="text" class="form-control" id="data2-18-3"
                                                            name="dnut_me_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าพลังงานสุทธิเพื่อการให้ผลผลิตน้ำนม (NEL)</th>
                                                    <td><input type="text" class="form-control" id="data2-19-1"
                                                            name="dnut_nel_avg"></td>
                                                    <td><input type="text" class="form-control" id="data2-19-2"
                                                            name="dnut_nel_sd"></td>
                                                    <td><input type="text" class="form-control" id="data2-19-3"
                                                            name="dnut_nel_n"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-center btn-more">
                                        <div class="form-group">
                                            <button type="reset" class="btn btn-cancel">ล้างข้างมูล</button>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-add confirm"
                                                name="addRaw">ยืนยัน</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="menu4" class="menu4 menu-content collapse">
                            <!-- ปริมาณแร่ธาตุในวัตถุดิบ -->
                            <h1>เพิ่มปริมาณแร่ธาตุในวัตถุดิบ</h1>
                            <form class="" action="minerals_detail.php" method="post" enctype="multipart/form-data"
                                id="myForm">
                                <div class="row t1-1 t22">
                                    <div class="col-6">
                                        <div class="cate-raw">
                                            <label for="type_raw_id" class="form-label">หมวดหมู่</label>
                                            <select name="type_id" id="type_raw_id" class="form-select" required>
                                                <option selected disabled>เลือกหมวดหมู่วัตถุดิบ</option>
                                                <?php
                                                $sql = "SELECT * FROM type_raw_material";
                                                $result = $conn->query($sql);

                                                while ($raw = $result->fetch_assoc()):
                                                    ?>
                                                                                <option value="<?php echo $raw["type_raw_id"]; ?>">
                                                                                    <?php echo $raw["type_raw_thainame"]; ?>
                                                                                </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="data4-1" class="form-label">Feed Class</label>
                                        <select class="form-select" aria-label="Feed Class" id="data4-1"
                                            name="feed_class" required>
                                            <option selected disabled>เลือก Feed Class</option>
                                            <option value="1">1 (พืชอาหารสัตว์หมัก สด แห้งและอาหารหยาบแห้ง)</option>
                                            <option value="2">2 (วัตถุดิบแหล่งโปรตีน)</option>
                                            <option value="3">3 (วัตถุดิบแหล่งพลังงาน)</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="data4-2" class="form-label">ชื่อสามัญภาษาไทย</label>
                                        <input type="text" class="form-control" id="data4-2" name="raw_thainame"
                                            placeholder="กรอกชื่อสามัญภาษาไทย" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="data4-3" class="form-label">ชื่อสามัญภาษาอังกฤษ</label>
                                        <input type="text" class="form-control" id="data4-3" name="raw_engname"
                                            placeholder="กรอกชื่อสามัญภาษาอังกฤษ">
                                    </div>
                                </div>
                                <div class="" id="4th" role="tabpanel" aria-labelledby="4th-tab" tabindex="0">
                                    <div>
                                        <p>* หากไม่มีข้อมูลในรายการนั้นให้กรอก ND (No data)</p>
                                        <p>* หากไม่สามารถตรวจวัดข้อมูลได้ให้กรอก Nd (No detect)</p>
                                    </div>
                                    <div class="table-responsive py-4 table">
                                        <table class="table table-bordered">
                                            <thead class="thead-primary ">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">AVG</th>
                                                    <th scope="col">SD</th>
                                                    <th scope="col">N</th>
                                                    <th scope="col">หน่วย</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">ค่าแคลเซียม (Ca)</th>
                                                    <td><input type="text" class="form-control" id="data4-1-1"
                                                            name="dminer_per_ca_avg"></td>
                                                    <td><input type="text" class="form-control" id="data4-1-2"
                                                            name="dminer_per_ca_sd"></td>
                                                    <td><input type="text" class="form-control" id="data4-1-3"
                                                            name="dminer_per_ca_n"></td>
                                                    <td rowspan="6" class="text-center">%</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าฟอสฟอรัส (P)</th>
                                                    <td><input type="text" class="form-control" id="data4-2-1"
                                                            name="dminer_per_p_avg"></td>
                                                    <td><input type="text" class="form-control" id="data4-2-2"
                                                            name="dminer_per_p_sd"></td>
                                                    <td><input type="text" class="form-control" id="data4-2-3"
                                                            name="dminer_per_p_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าแมกนีเซียม (Mg)</th>
                                                    <td><input type="text" class="form-control" id="data4-3-1"
                                                            name="dminer_per_mg_avg"></td>
                                                    <td><input type="text" class="form-control" id="data4-3-2"
                                                            name="dminer_per_mg_sd"></td>
                                                    <td><input type="text" class="form-control" id="data4-3-3"
                                                            name="dminer_per_mg_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าโพแทสเซียม (K)</th>
                                                    <td><input type="text" class="form-control" id="data4-4-1"
                                                            name="dminer_per_k_avg"></td>
                                                    <td><input type="text" class="form-control" id="data4-4-2"
                                                            name="dminer_per_k_sd"></td>
                                                    <td><input type="text" class="form-control" id="data4-4-3"
                                                            name="dminer_per_k_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่ากำมะถัน (S)</th>
                                                    <td><input type="text" class="form-control" id="data4-5-1"
                                                            name="dminer_per_s_avg"></td>
                                                    <td><input type="text" class="form-control" id="data4-5-2"
                                                            name="dminer_per_s_sd"></td>
                                                    <td><input type="text" class="form-control" id="data4-5-3"
                                                            name="dminer_per_s_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าโซเดียม (Na)</th>
                                                    <td><input type="text" class="form-control" id="data4-6-1"
                                                            name="dminer_per_na_avg"></td>
                                                    <td><input type="text" class="form-control" id="data4-6-2"
                                                            name="dminer_per_na_sd"></td>
                                                    <td><input type="text" class="form-control" id="data4-6-3"
                                                            name="dminer_per_na_n"></td>
                                                </tr>
                                            </tbody>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">ค่าทองแดง (Cu)</th>
                                                    <td><input type="text" class="form-control" id="data4-7-1"
                                                            name="dminer_kg_cu_avg"></td>
                                                    <td><input type="text" class="form-control" id="data4-7-2"
                                                            name="dminer_kg_cu_sd"></td>
                                                    <td><input type="text" class="form-control" id="data4-7-3"
                                                            name="dminer_kg_cu_n"></td>
                                                    <td rowspan="4" class="text-center">mg/kg</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าเหล็ก (Fe)</th>
                                                    <td><input type="text" class="form-control" id="data4-8-1"
                                                            name="dminer_kg_fe_avg"></td>
                                                    <td><input type="text" class="form-control" id="data4-8-2"
                                                            name="dminer_kg_fe_sd"></td>
                                                    <td><input type="text" class="form-control" id="data4-8-3"
                                                            name="dminer_kg_fe_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าแมงกานีส (Mn)</th>
                                                    <td><input type="text" class="form-control" id="data4-9-1"
                                                            name="dminer_kg_mn_avg"></td>
                                                    <td><input type="text" class="form-control" id="data4-9-2"
                                                            name="dminer_kg_mn_sd"></td>
                                                    <td><input type="text" class="form-control" id="data4-9-3"
                                                            name="dminer_kg_mn_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าสังกะสี (Zn)</th>
                                                    <td><input type="text" class="form-control" id="data4-10-1"
                                                            name="dminer_kg_zn_avg"></td>
                                                    <td><input type="text" class="form-control" id="data4-10-2"
                                                            name="dminer_kg_zn_sd"></td>
                                                    <td><input type="text" class="form-control" id="data4-10-3"
                                                            name="dminer_kg_zn_n"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-center btn-more">
                                        <div class="form-group">
                                            <button type="reset" class="btn btn-cancel">ล้างข้างมูล</button>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-add confirm"
                                                name="addRaw2">ยืนยัน</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="menu5" class="menu5 menu-content collapse">
                            <!-- กรดอะมิโนในวัตถุดิบ -->
                            <h1>เพิ่มกรดอะมิโนในวัตถุดิบ</h1>
                            <form class="" action="material_detail.php" method="post" enctype="multipart/form-data"
                                id="myForm">
                                <div class="row t1-1 t22">
                                    <div class="col-6">
                                        <div class="cate-raw">
                                            <label for="type_raw_id" class="form-label">หมวดหมู่</label>
                                            <select name="type_id" id="type_raw_id" class="form-select" required>
                                                <option selected disabled>เลือกหมวดหมู่วัตถุดิบ</option>
                                                <?php
                                                $sql = "SELECT * FROM type_raw_material";
                                                $result = $conn->query($sql);
                                                while ($raw = $result->fetch_assoc()):
                                                    ?>
                                                                                <option value="<?php echo $raw["type_raw_id"]; ?>">
                                                                                    <?php echo $raw["type_raw_thainame"]; ?>
                                                                                </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label for="data1-1" class="form-label">Feed Class</label>
                                        <select class="form-select" aria-label="Feed Class" id="data5-1"
                                            name="feed_class" required>
                                            <option selected disabled>เลือก Feed Class</option>
                                            <option value="1">1 (พืชอาหารสัตว์หมัก สด แห้งและอาหารหยาบแห้ง)</option>
                                            <option value="2">2 (วัตถุดิบแหล่งโปรตีน)</option>
                                            <option value="3">3 (วัตถุดิบแหล่งพลังงาน)</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="data5-2" class="form-label">ชื่อสามัญภาษาไทย</label>
                                        <input type="text" class="form-control" id="data5-2" name="raw_thainame"
                                            placeholder="กรอกชื่อสามัญภาษาไทย" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="data5-3" class="form-label">ชื่อสามัญภาษาอังกฤษ</label>
                                        <input type="text" class="form-control" id="data5-3" name="raw_engname"
                                            placeholder="กรอกชื่อสามัญภาษาอังกฤษ">
                                    </div>
                                </div>
                                <div class="" id="5th" role="tabpanel" aria-labelledby="5th-tab" tabindex="0">
                                    <div>
                                        <p>* หากไม่มีข้อมูลในรายการนั้นให้กรอก ND (No data)</p>
                                        <p>* หากไม่สามารถตรวจวัดข้อมูลได้ให้กรอก Nd (No detect)</p>
                                    </div>
                                    <div class="table-responsive py-4 table">
                                        <table class="table table-bordered">
                                            <thead class="thead-primary ">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">AVG</th>
                                                    <th scope="col">SD</th>
                                                    <th scope="col">N</th>
                                                    <th scope="col">หน่วย</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">ค่า Alanine (Ala)</th>
                                                    <td><input type="text" class="form-control" id="data5-1-1"
                                                            name="dmat_ala_avg"></td>
                                                    <td><input type="text" class="form-control" id="data5-1-2"
                                                            name="dmat_ala_sd"></td>
                                                    <td><input type="text" class="form-control" id="data5-1-3"
                                                            name="dmat_ala_n"></td>
                                                    <td rowspan="20" class="text-center">mg/100g</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่า Arginine (Arg)</th>
                                                    <td><input type="text" class="form-control" id="data5-2-1"
                                                            name="dmat_arg_avg"></td>
                                                    <td><input type="text" class="form-control" id="data5-2-2"
                                                            name="dmat_arg_sd"></td>
                                                    <td><input type="text" class="form-control" id="data5-2-3"
                                                            name="dmat_arg_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่า Aspartic acid (Asp)</th>
                                                    <td><input type="text" class="form-control" id="data5-3-1"
                                                            name="dmat_asp_avg"></td>
                                                    <td><input type="text" class="form-control" id="data5-3-2"
                                                            name="dmat_asp_sd"></td>
                                                    <td><input type="text" class="form-control" id="data5-3-3"
                                                            name="dmat_asp_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่า Cystine (Cys)</th>
                                                    <td><input type="text" class="form-control" id="data5-4-1"
                                                            name="dmat_cys_avg"></td>
                                                    <td><input type="text" class="form-control" id="data5-4-2"
                                                            name="dmat_cys_sd"></td>
                                                    <td><input type="text" class="form-control" id="data5-4-3"
                                                            name="dmat_cys_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่า Glutamic acid (Glu)</th>
                                                    <td><input type="text" class="form-control" id="data5-5-1"
                                                            name="dmat_glu_avg"></td>
                                                    <td><input type="text" class="form-control" id="data5-5-2"
                                                            name="dmat_glu_sd"></td>
                                                    <td><input type="text" class="form-control" id="data5-5-3"
                                                            name="dmat_glu_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่า Glycine (Gly)</th>
                                                    <td><input type="text" class="form-control" id="data5-6-1"
                                                            name="dmat_gly_avg"></td>
                                                    <td><input type="text" class="form-control" id="data5-6-2"
                                                            name="dmat_gly_sd"></td>
                                                    <td><input type="text" class="form-control" id="data5-6-3"
                                                            name="dmat_gly_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่า Histidine (His)</th>
                                                    <td><input type="text" class="form-control" id="data5-7-1"
                                                            name="dmat_his_avg"></td>
                                                    <td><input type="text" class="form-control" id="data5-7-2"
                                                            name="dmat_his_sd"></td>
                                                    <td><input type="text" class="form-control" id="data5-7-3"
                                                            name="dmat_his_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่า Hydroxylysine (Hyl)</th>
                                                    <td><input type="text" class="form-control" id="data5-8-1"
                                                            name="dmat_hyl_avg"></td>
                                                    <td><input type="text" class="form-control" id="data5-8-2"
                                                            name="dmat_hyl_sd"></td>
                                                    <td><input type="text" class="form-control" id="data5-8-3"
                                                            name="dmat_hyl_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่า Hydroxyproline (Hyp)</th>
                                                    <td><input type="text" class="form-control" id="data5-9-1"
                                                            name="dmat_hyp_avg"></td>
                                                    <td><input type="text" class="form-control" id="data5-9-2"
                                                            name="dmat_hyp_sd"></td>
                                                    <td><input type="text" class="form-control" id="data5-9-3"
                                                            name="dmat_hyp_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่า Isoleucine (Ile)</th>
                                                    <td><input type="text" class="form-control" id="data5-10-1"
                                                            name="dmat_ile_avg"></td>
                                                    <td><input type="text" class="form-control" id="data5-10-2"
                                                            name="dmat_ile_sd"></td>
                                                    <td><input type="text" class="form-control" id="data5-10-3"
                                                            name="dmat_ile_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่า Leucine (Leu)</th>
                                                    <td><input type="text" class="form-control" id="data5-11-1"
                                                            name="dmat_leu_avg"></td>
                                                    <td><input type="text" class="form-control" id="data5-11-2"
                                                            name="dmat_leu_sd"></td>
                                                    <td><input type="text" class="form-control" id="data5-11-3"
                                                            name="dmat_leu_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่า Lysine (Lys)</th>
                                                    <td><input type="text" class="form-control" id="data5-12-1"
                                                            name="dmat_lys_avg"></td>
                                                    <td><input type="text" class="form-control" id="data5-12-2"
                                                            name="dmat_lys_sd"></td>
                                                    <td><input type="text" class="form-control" id="data5-12-3"
                                                            name="dmat_lys_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่า Methionine (Met)</th>
                                                    <td><input type="text" class="form-control" id="data5-13-1"
                                                            name="dmat_met_avg"></td>
                                                    <td><input type="text" class="form-control" id="data5-13-2"
                                                            name="dmat_met_sd"></td>
                                                    <td><input type="text" class="form-control" id="data5-13-3"
                                                            name="dmat_met_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่า Phenylalanine (Phe)</th>
                                                    <td><input type="text" class="form-control" id="data5-14-1"
                                                            name="dmat_phe_avg"></td>
                                                    <td><input type="text" class="form-control" id="data5-14-2"
                                                            name="dmat_phe_sd"></td>
                                                    <td><input type="text" class="form-control" id="data5-14-3"
                                                            name="dmat_phe_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่า Proline (Pro)</th>
                                                    <td><input type="text" class="form-control" id="data5-15-1"
                                                            name="dmat_pro_avg"></td>
                                                    <td><input type="text" class="form-control" id="data5-15-2"
                                                            name="dmat_pro_sd"></td>
                                                    <td><input type="text" class="form-control" id="data5-15-3"
                                                            name="dmat_pro_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่า Serine (Ser)</th>
                                                    <td><input type="text" class="form-control" id="data5-16-1"
                                                            name="dmat_ser_avg"></td>
                                                    <td><input type="text" class="form-control" id="data5-16-2"
                                                            name="dmat_ser_sd"></td>
                                                    <td><input type="text" class="form-control" id="data5-16-3"
                                                            name="dmat_ser_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่า Threnine (Thr)</th>
                                                    <td><input type="text" class="form-control" id="data5-17-1"
                                                            name="dmat_thr_avg"></td>
                                                    <td><input type="text" class="form-control" id="data5-17-2"
                                                            name="dmat_thr_sd"></td>
                                                    <td><input type="text" class="form-control" id="data5-17-3"
                                                            name="dmat_thr_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่า Tryptophan (Trp)</th>
                                                    <td><input type="text" class="form-control" id="data5-18-1"
                                                            name="dmat_trp_avg"></td>
                                                    <td><input type="text" class="form-control" id="data5-18-2"
                                                            name="dmat_trp_sd"></td>
                                                    <td><input type="text" class="form-control" id="data5-18-3"
                                                            name="dmat_trp_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่า Tyrosine (Tyr)</th>
                                                    <td><input type="text" class="form-control" id="data5-19-1"
                                                            name="dmat_tyr_avg"></td>
                                                    <td><input type="text" class="form-control" id="data5-19-2"
                                                            name="dmat_tyr_sd"></td>
                                                    <td><input type="text" class="form-control" id="data5-19-3"
                                                            name="dmat_tyr_n"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่า Valine (Val)</th>
                                                    <td><input type="text" class="form-control" id="data5-20-1"
                                                            name="dmat_val_avg"></td>
                                                    <td><input type="text" class="form-control" id="data5-20-2"
                                                            name="dmat_val_sd"></td>
                                                    <td><input type="text" class="form-control" id="data5-20-3"
                                                            name="dmat_val_n"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-center btn-more">
                                        <div class="form-group">
                                            <button type="reset" class="btn btn-cancel">ล้างข้างมูล</button>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-add confirm"
                                                name="addRaw3">ยืนยัน</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div id="menu6" class="menu6 menu-content collapse show">
                            <h1>แร่ธาตุทั้งหมด</h1>
                            <ul class="nav nav-tabs nav-justified" id="ex4" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="tab-4-link" data-bs-toggle="tab" data-bs-target="#tabs-4" href="#tabs-4" role="tab"
                                        aria-controls="tabs-4" aria-selected="true" style="color:black;">ค่าแร่ธาตุของวัตถุดิบ</a>
                                </li>
                            </ul>
                            <!-- Tabs navs -->
                            <!-- Tabs content -->
                            <div class="tab-content" id="tab-content">
                                <div class="tab-pane fade show active" id="tabs-4" role="tabpanel" aria-labelledby="tab-4-link">
                                        <div class="table-tab overflow-auto">
                                            <div class="row">
                                                <div class="col">                  
                                                    <div class="d-flex justify-content-start" style="margin-bottom:2em;">
                                                        <form action="#" method="GET" onsubmit="return handleTabSearch('4');">
                                                            <div class="input-group search">
                                                                <div class="form-outline">
                                                                    <input type="hidden" name="current_tab" value="tab-4">
                                                                    <input type="text" name="search4" class="form-control" id="search4" placeholder="ค้นหาแร่ธาตุ" />
                                                                </div>
                                                                <button type="submit" class="btn btn-primary" name="submit" >
                                                                    <i class="bi bi-search"></i>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <?php
                                                $search_term = isset($_GET['search4']) ? $_GET['search4'] : '';
                                                $current_tab = isset($_GET['current_tab']) ? $_GET['current_tab'] : 'tab-4';
                                                $num = 0;
                                                if ($current_tab == 'tab-4') {
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
                                                                WHERE 
                                                                    mineral_source_raw.ms_id LIKE '%$search_term%' OR 
                                                                    mineral_source_raw.ms_thainame LIKE '%$search_term%' OR 
                                                                    mineral_source_raw.ms_engname LIKE '%$search_term%' OR 
                                                                    mineral_source_raw.feed_class LIKE '%$search_term%' OR 
                                                                    type_mineral_source_raw.type_ms_thainame LIKE '%$search_term%'
                                                                GROUP BY 
                                                                    mineral_source_raw.ms_id, mineral_source_raw.ms_thainame, mineral_source_raw.ms_engname, mineral_source_raw.feed_class, type_mineral_source_raw.type_ms_thainame";

                                                } else {
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
                                                }

                                                $resulttab4 = $conn->query($sqltab4);
                                                $total = $resulttab4->num_rows;
                                                $count = 1;


                                                $e_page = 5; // กำหนดจำนวนรายการที่แสดงในแต่ละหน้า   
                                                $step_num = 0;
                                                if (!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] == 1)) {
                                                    $_GET['page'] = 1;
                                                    $step_num = 0;
                                                    $s_page = 0;
                                                } else {
                                                    $s_page = $_GET['page'] - 1;
                                                    $step_num = $_GET['page'] - 1;
                                                    $s_page = $s_page * $e_page;
                                                }
                                                $sqltab4 .= " ORDER BY source_id LIMIT " . $s_page . ",$e_page";
                                                $resulttab4 = $conn->query($sqltab4); ?>
                                                <div class="col">
                                                    <div class="d-flex justify-content-end m-2">
                                                        <p>มีข้อมูลทั้งหมด <?php echo $total; ?> รายการ</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table text-center raw_all_table" id="tabs-1-content">
                                                <thead>
                                                    <tr class="tr_all_top">
                                                        <th>ลำดับที่</th>
                                                        <th>ชื่อ</th>
                                                        <th>Feed Class</th>
                                                        <th></th>
                                                        <th>DM</th>
                                                        <th>Ca</th>
                                                        <th>P</th>
                                                        <th>Mg</th>
                                                        <th>K</th>
                                                        <th>S</th>
                                                        <th>Na</th>
                                                        <th>Cl</th>
                                                        <th>Cu</th>
                                                        <th>Fe</th>
                                                        <th>Mn</th>
                                                        <th>Zn</th>
                                                        <th>Co</th>
                                                        <th>I</th>
                                                        <th>Se</th>
                                                        <th>จัดการข้อมูล</th>
                                                    </tr>
                                                </thead>
                                                <!----------------------------------------------------------->
                                                <tbody>
                                                    <?php
                                                    if ($resulttab4 && $resulttab4->num_rows > 0) { // คิวรี่ข้อมูลสำเร็จหรือไม่ และมีรายการข้อมูลหรือไม่
                                                        while ($rowtab4 = $resulttab4->fetch_assoc()) { // วนลูปแสดงรายการ
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
                                                                    <?php echo ($step_num * $e_page) + $num; ?>
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
                                                                        $sql = "SELECT * FROM source_minerals_detail WHERE source_detail_id = $source_detail_id";
                                                                        $result = $conn->query($sql);

                                                                        if ($result && $result->num_rows > 0) {
                                                                            while ($row = $result->fetch_assoc()) {
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
                                                                            }
                                                                        }
                                                                    } ?>
                                                                <th>โดยน้ำหนักสด</th>
                                                                <td><?php echo $ds_DM; ?></td>
                                                                <td><?php echo $ds_ca; ?></td>
                                                                <td><?php echo $ds_p; ?></td>
                                                                <td><?php echo $ds_mg; ?></td>
                                                                <td><?php echo $ds_k; ?></td>
                                                                <td><?php echo $ds_s; ?></td>
                                                                <td><?php echo $ds_na; ?></td>
                                                                <td><?php echo $ds_cl; ?></td>
                                                                <td><?php echo $ds_cu; ?></td>
                                                                <td><?php echo $ds_fe; ?></td>
                                                                <td><?php echo $ds_mn; ?></td>
                                                                <td><?php echo $ds_zn; ?></td>
                                                                <td><?php echo $ds_co; ?></td>
                                                                <td><?php echo $ds_i; ?></td>
                                                                <td><?php echo $ds_se; ?></td>
                                                                <td>
                                                                    <div class="row p-2 text-center d-flex justify-content-center">
                                                                        <div>
                                                                            <button class="btn btn-warning" style="width: 3em;" onclick="window.location.href='nutrition_edit.php?id=<?php echo $rowtab4['ms_id']; ?>'">
                                                                                <i class="fa-solid fa-pen-to-square" style="color: #000000;"></i>
                                                                            </button>     
                                                                            <button type="button" class="btn btn-danger" style="width: 3em;"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#ModalDeleteRawTab4<?php echo $rowtab4['ms_id']; ?>" 
                                                                                data-bs-toggle="tooltip" 
                                                                                title="ลบ">
                                                                                <i class="fa-solid fa-trash-can" style="color: #ffffff;"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <?php $count++; ?>
                                                        </tbody>
                                                            <!-- Modal อันนี้จ้า--> 
                                                                    <div class="modal fade" id="ModalDeleteRawTab4<?php echo $rowtab4['ms_id']; ?>"
                                                                        tabindex="-1" aria-labelledby="ModalDeleteRawTab4Label" aria-hidden="true">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h2 class="modal-title fs-5" id="ModalDeleteRawTab4Label">Modal
                                                                                        title</h2>
                                                                                    <button type="button" class="btn-close"
                                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <?php echo $rowtab4['ms_id']; ?>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary"
                                                                                        data-bs-dismiss="modal">Close</button>
                                                                                    <button type="button" class="btn btn-primary">Save
                                                                                        changes</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- End Modal -->
                                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                            </table>
                                        </div>
                                        <div style="background-color: white;" class="mt-4">
                                            <?php
                                            page_navi($total, (isset($_GET['page'])) ? $_GET['page'] : 1, $e_page);
                                            ?>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <div id="menu6-2" class="menu3 menu-content collapse">
                            <h1>เพิ่มค่าแร่ธาตุของวัตถุดิบ</h1>
                            <form class="needs-validation" action="source_minerals.php" method="post"
                                enctype="multipart/form-data" id="source_minerals" novalidate>
                                <div class="" id="general-information" role="tabpanel"
                                    aria-labelledby="general-information-tab" tabindex="0">
                                    <div class="txt-form row t1-1">
                                        <div class="col-6">
                                            <div class="cate-raw">
                                                <label for="type_ms_id" class="form-label">หมวดหมู่แร่ธาตุ</label>
                                                <select name="type_ms_id" id="type_ms_id" class="form-select" required>
                                                    <option selected disabled>เลือกหมวดหมู่แร่ธาตุ</option>
                                                    <?php
                                                    $sql = "SELECT * FROM type_mineral_source_raw";
                                                    $result = $conn->query($sql);

                                                    while ($raw = $result->fetch_assoc()):
                                                        ;
                                                        ?>
                                                            <option value="<?php echo $raw["type_ms_id"]; ?>">
                                                                <?php echo $raw["type_ms_thainame"]; ?>
                                                            </option>
                                                    <?php endwhile; ?>
                                                </select>
                                                <div class="invalid-feedback" id="error-message"></div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label for="data3-1" class="form-label">Feed Class</label>
                                            <input type="text" class="form-control" id="data3-1"
                                                placeholder="กรอกชื่อแร่ธาตุภาษาไทย" value="6 (วัตถุดิบแหล่งแร่ธาตุ)"
                                                disabled>
                                            <input type="text" name="feed_class" value="6" hidden>
                                        </div>
                                        <div class="col-6">
                                            <label for="data1-3" class="form-label">ชื่อแร่ธาตุ (ภาษาไทย)</label>
                                            <input type="text" class="form-control" id="data3-3" name="ms_thainame"
                                                placeholder="กรอกชื่อแร่ธาตุภาษาไทย">
                                        </div>
                                        <div class="col-6">
                                            <label for="data1-2" class="form-label">ชื่อแร่ธาตุ (ภาษาอังกฤษ)</label>
                                            <input type="text" class="form-control" id="data3-2" name="ms_engname"
                                                placeholder="กรอกชื่อแร่ธาตุภาษาอังกฤษ">
                                        </div>
                                    </div>
                                </div>
                                <div class="" id="3rd" role="tabpanel" aria-labelledby="3rd-tab" tabindex="0">
                                    <div>
                                        <p>* หากไม่มีข้อมูลในรายการนั้นให้กรอก ND (No data)</p>
                                        <p>* หากไม่สามารถตรวจวัดข้อมูลได้ให้กรอก Nd (No detect)</p>
                                    </div>
                                    <div class="table-responsive py-4 table">
                                        <table class="table table-bordered">
                                            <thead class="thead-primary ">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">โดยน้ำหนักสด</th>
                                                    <th scope="col">หน่วย</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">ค่าวัตถุแห้ง (DM)</th>
                                                    <td><input type="text" class="form-control" id="data3-1-1"
                                                            name="ds_DM"></td>
                                                    <td rowspan="8" class="text-center">%</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าแคลเซียม (Ca)</th>
                                                    <td><input type="text" class="form-control" id="data3-2-1"
                                                            name="ds_ca"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าฟอสฟอรัส (P)</th>
                                                    <td><input type="text" class="form-control" id="data3-3-1"
                                                            name="ds_p"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าแมกนีเซียม (Mg)</th>
                                                    <td><input type="text" class="form-control" id="data3-4-1"
                                                            name="ds_mg"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าโพแทสเซียม (K)</th>
                                                    <td><input type="text" class="form-control" id="data3-5-1"
                                                            name="ds_k"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่ากำมะถัน (S)</th>
                                                    <td><input type="text" class="form-control" id="data3-6-1"
                                                            name="ds_s"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าโซเดียม (Na)</th>
                                                    <td><input type="text" class="form-control" id="data3-7-1"
                                                            name="ds_na"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าคลอรีน (Cl)</th>
                                                    <td><input type="text" class="form-control" id="data3-8-1"
                                                            name="ds_cl"></td>
                                                </tr>
                                            </tbody>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">ค่าทองแดง (Cu)</th>
                                                    <td><input type="text" class="form-control" id="data3-9-1"
                                                            name="ds_cu"></td>
                                                    <td rowspan="7" class="text-center">mg/kg</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าเหล็ก (Fe)</th>
                                                    <td><input type="text" class="form-control" id="data3-10-1"
                                                            name="ds_fe"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าแมงกานีส (Mn)</th>
                                                    <td><input type="text" class="form-control" id="data3-11-1"
                                                            name="ds_mn"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าสังกะสี (Zn)</th>
                                                    <td><input type="text" class="form-control" id="data3-12-1"
                                                            name="ds_zn"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าโคบอลท์ (Co)</th>
                                                    <td><input type="text" class="form-control" id="data3-13-1"
                                                            name="ds_co"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าไอโอดีน (I)</th>
                                                    <td><input type="text" class="form-control" id="data3-14-1"
                                                            name="ds_i"></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">ค่าซีลีเนียม (Se)</th>
                                                    <td><input type="text" class="form-control" id="data3-15-1"
                                                            name="ds_se"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-center btn-more">
                                        <div class="form-group">
                                            <button type="reset" class="btn btn-cancel">ล้างข้างมูล</button>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-add confirm"
                                                name="addSourceM">ยืนยัน</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handleTabSearch(tab) {
            var searchValue = document.querySelector('#search' + tab).value;
            var currentTab = document.querySelector('#tab-' + tab + '-link');
            document.querySelector('input[name="current_tab"]').value = 'tab-' + tab;

            document.querySelectorAll('.tab-pane').forEach(function (content) {
                content.classList.remove('show', 'active');
            });

            var targetContent = document.querySelector('#tabs-' + tab);
            if (targetContent) {
                targetContent.classList.add('show', 'active');
            }

            document.querySelectorAll('.custom-tab .nav-link').forEach(function (link) {
                link.classList.remove('active');
            });

            if (currentTab) {
                currentTab.classList.add('active');
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'raw_mat_showall.php?tab=' + tab + '&q=' + searchValue, true);

            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 400) {
                    var data = xhr.responseText;
                    var target = document.querySelector('#tabs-' + tab + '-content');
                    if (target) {
                        target.innerHTML = data;
                    }
                }
            };

            xhr.onerror = function () {
                console.log("Request failed");
            };

            xhr.send();

            return false;
        }

        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.custom-tab .nav-link').forEach(function (tab) {
                tab.addEventListener('click', function (e) {
                    e.preventDefault();
                    var currentTab = this.getAttribute('href').substr(1);
                    handleTabSearch(currentTab);
                });
            });
        });
    </script>
    <script>
        if (window.performance) {
            if (performance.navigation.type == 1) {
                window.location.href = 'raw_material.php';
            }
        }
    </script>


</body>

</html>