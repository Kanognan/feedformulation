<?php
session_start();
require_once('../server.php');
require_once("pagination_function.php");

if (isset($_GET['q'])) {
    // ดึงค่า tab และ search จาก URL
    $tab = $_GET['tab'];
    $search = $_GET['q'];
    $num = 0;

    // ดึงข้อมูลตาม tab และคำค้นหา
    if ($tab == 1) {
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
                        raw_material.raw_id LIKE '%$search%' OR 
                        raw_material.raw_thainame LIKE '%$search%' OR 
                        raw_material.raw_engname LIKE '%$search%' OR 
                        raw_material.feed_class LIKE '%$search%' OR 
                        type_raw_material.type_raw_thainame LIKE '%$search%'
                    GROUP BY 
                        raw_material.raw_id, raw_material.raw_thainame, raw_material.raw_engname, raw_material.feed_class, type_raw_material.type_raw_thainame";


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
                        <?php echo $raw_thainame; ?>
                        <?php echo "(" . $raw_engname . ")"; ?>
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
                    }
                    ?>
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
                                <button type="button" class="btn btn-warning mb-2" style="width: 3em;" data-bs-toggle="modal"
                                    data-bs-target="#ModalEditRawTab1<?php echo $rowtab1['raw_id']; ?>" data-bs-toggle="tooltip"
                                    title="แก้ไข">
                                    <i class="fa-solid fa-pen-to-square" style="color: #000000;"></i>
                                </button>
                            </div>
                            <div>
                                <button type="button" class="btn btn-danger" style="width: 3em;" data-bs-toggle="modal"
                                    data-bs-target="#ModalDeleteRawTab1<?php echo $rowtab1['raw_id']; ?>" data-bs-toggle="tooltip"
                                    title="ลบ">
                                    <i class="fa-solid fa-trash-can" style="color: #ffffff;"></i>
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
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
                <?php $count++; ?>
                </tbody>
                <!-- Modal -->
                <!-- Modal for Editing Raw Data -->
                <div class="modal fade" id="ModalEditRawTab1<?php echo $rowtab1['raw_id']; ?>" tabindex="-1"
                    aria-labelledby="ModalEditRawTab1Label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title fs-5" id="ModalEditRawTab1Label">Modal
                                    title
                                </h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php echo $rowtab1['raw_id']; ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save
                                    changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal for Deleting Raw Data -->
                <div class="modal fade" id="ModalDeleteRawTab1<?php echo $rowtab1['raw_id']; ?>" tabindex="-1"
                    aria-labelledby="ModalDeleteRawTab1Label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title fs-5" id="ModalDeleteRawTab1Label">Modal
                                    title</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php echo $rowtab1['raw_id']; ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    }
    if ($tab == 2) {
        $search = $_GET['q'];
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
                raw_material.raw_id LIKE '%$search%' OR 
                raw_material.raw_thainame LIKE '%$search%' OR 
                raw_material.raw_engname LIKE '%$search%' OR 
                raw_material.feed_class LIKE '%$search%' OR 
                type_raw_material.type_raw_thainame LIKE '%$search%'
            GROUP BY 
                raw_material.raw_id, raw_material.raw_thainame, raw_material.raw_engname, raw_material.feed_class, type_raw_material.type_raw_thainame";


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
        <?php if ($resulttab2 && $resulttab2->num_rows > 0) { // คิวรี่ข้อมูลสำเร็จหรือไม่ และมีรายการข้อมูลหรือไม่
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
                        <?php echo $raw_thainame; ?>
                        <?php echo "(" . $raw_engname . ")"; ?>
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
                    }
                    ?>
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
                    <td rowspan="3">
                        <div class="row p-2 text-center d-flex justify-content-center">
                            <div>
                                <button type="button" class="btn btn-warning mb-2" style="width: 3em;" data-bs-toggle="modal"
                                    data-bs-target="#ModalEditRawTab2<?php echo $rowtab1['raw_id']; ?>" data-bs-toggle="tooltip"
                                    title="แก้ไข">
                                    <i class="fa-solid fa-pen-to-square" style="color: #000000;"></i>
                                </button>
                            </div>
                            <div>
                                <button type="button" class="btn btn-danger" style="width: 3em;" data-bs-toggle="modal"
                                    data-bs-target="#ModalDeleteRawTab2<?php echo $rowtab1['raw_id']; ?>" data-bs-toggle="tooltip"
                                    title="ลบ">
                                    <i class="fa-solid fa-trash-can" style="color: #ffffff;"></i>
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
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
                <?php $count++; ?>
                </tbody>
                <!-- Modal -->
                <!-- Modal for Editing Raw Data -->
                <div class="modal fade" id="ModalEditRawTab2<?php echo $rowtab2['raw_id']; ?>" tabindex="-1"
                    aria-labelledby="ModalEditRawTab2Label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title fs-5" id="ModalEditRawTab2Label">Modal
                                    title
                                </h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php echo $rowtab2['raw_id']; ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save
                                    changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="ModalDeleteRawTab2<?php echo $rowtab2['raw_id']; ?>" tabindex="-1"
                    aria-labelledby="ModalDeleteRawTab3Label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title fs-5" id="ModalDeleteRawTab2Label">Modal
                                    title</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php echo $rowtab2['raw_id']; ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    }
    if ($tab == 3) {
        $search = $_GET['q'];
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
                        raw_material.raw_id LIKE '%$search%' OR 
                        raw_material.raw_thainame LIKE '%$search%' OR 
                        raw_material.raw_engname LIKE '%$search%' OR 
                        raw_material.feed_class LIKE '%$search%' OR 
                        type_raw_material.type_raw_thainame LIKE '%$search%'
                    GROUP BY 
                        raw_material.raw_id, raw_material.raw_thainame, raw_material.raw_engname, raw_material.feed_class, type_raw_material.type_raw_thainame";



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
        <?php if ($resulttab3 && $resulttab3->num_rows > 0) { // คิวรี่ข้อมูลสำเร็จหรือไม่ และมีรายการข้อมูลหรือไม่
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
                        <?php echo $raw_thainame; ?>
                        <?php echo "(" . $raw_engname . ")"; ?>
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
                    }
                    ?>
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
                    <td rowspan="3">
                        <div class="row p-2 text-center d-flex justify-content-center">
                            <div>
                                <button type="button" class="btn btn-warning mb-2" style="width: 3em;" data-bs-toggle="modal"
                                    data-bs-target="#ModalEditRawTab3<?php echo $rowtab1['raw_id']; ?>" data-bs-toggle="tooltip"
                                    title="แก้ไข">
                                    <i class="fa-solid fa-pen-to-square" style="color: #000000;"></i>
                                </button>
                            </div>
                            <div>
                                <button type="button" class="btn btn-danger" style="width: 3em;" data-bs-toggle="modal"
                                    data-bs-target="#ModalDeleteRawTab3<?php echo $rowtab1['raw_id']; ?>" data-bs-toggle="tooltip"
                                    title="ลบ">
                                    <i class="fa-solid fa-trash-can" style="color: #ffffff;"></i>
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
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
                <?php $count++; ?>
                </tbody>
                <!-- Modal -->
                <!-- Modal for Editing Raw Data -->
                <div class="modal fade" id="ModalEditRawTab1<?php echo $rowtab1['raw_id']; ?>" tabindex="-1"
                    aria-labelledby="ModalEditRawTab1Label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title fs-5" id="ModalEditRawTab1Label">Modal
                                    title
                                </h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php echo $rowtab1['raw_id']; ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save
                                    changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal for Deleting Raw Data -->
                <div class="modal fade" id="ModalEditRawTab3<?php echo $rowtab3['raw_id']; ?>" tabindex="-1"
                    aria-labelledby="ModalEditRawTab3Label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title fs-5" id="ModalEditRawTab3Label">Modal
                                    title
                                </h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php echo $rowtab3['raw_id']; ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save
                                    changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="ModalDeleteRawTab3<?php echo $rowtab3['raw_id']; ?>" tabindex="-1"
                    aria-labelledby="ModalDeleteRawTab3Label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title fs-5" id="ModalDeleteRawTab3Label">Modal
                                    title</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php echo $rowtab3['raw_id']; ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    }
    if ($tab == 4) {
        $search = $_GET['q'];
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
        <?php if ($resulttab4 && $resulttab4->num_rows > 0) { // คิวรี่ข้อมูลสำเร็จหรือไม่ และมีรายการข้อมูลหรือไม่
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
                    }
                    ?>
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
                <!-- Modal -->
                <!-- Modal for Editing Raw Data -->
                <div class="modal fade" id="ModalEditRawTab2<?php echo $rowtab2['raw_id']; ?>" tabindex="-1"
                    aria-labelledby="ModalEditRawTab2Label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title fs-5" id="ModalEditRawTab2Label">Modal
                                    title
                                </h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php echo $rowtab2['raw_id']; ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save
                                    changes</button>
                            </div>
                        </div>
                    </div>
                </div>
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
    }
}
?>