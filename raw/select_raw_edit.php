<?php
session_start();
if (!isset($_SESSION["acc_id"]) || $_SESSION["acc_id"] == "") {
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
<?php
if (isset($_GET['raw_group_id'])) {
    $acc_id = $_SESSION['acc_id'];
    $rawGroupId = $_GET['raw_group_id'];

    // ตั้งตัวแปร $group
    $group = array();

    // คำสั่ง SQL สำหรับดึงข้อมูลจาก raw_group
    $sqlGroups = "SELECT DISTINCT * FROM raw_group WHERE acc_id = $acc_id AND raw_group.raw_group_id = $rawGroupId ORDER BY raw_group_id";
    $resultGroups = $conn->query($sqlGroups);

    if ($resultGroups && $resultGroups->num_rows > 0) {
        while ($groupData = $resultGroups->fetch_assoc()) {
            $group = $groupData;
        }

        // $sqlPersonalRaw = "SELECT * FROM personal_raw WHERE raw_group_id = $rawGroupId";
        // $resultPersonalRaw = $conn->query($sqlPersonalRaw);

        // if ($resultPersonalRaw) {
        //     $personalRawData = $resultPersonalRaw->fetch_all(MYSQLI_ASSOC);
        //     $group['personal_raw'] = $personalRawData;
        // } else {
        //     echo 'Error fetching personal_raw: ' . $conn->error;
        // }

        // $sqlPersonalMs = "SELECT * FROM personal_ms WHERE raw_group_id = $rawGroupId";
        // $resultPersonalMs = $conn->query($sqlPersonalMs);

        // if ($resultPersonalMs) {
        //     $personalMsData = $resultPersonalMs->fetch_all(MYSQLI_ASSOC);
        //     $group['personal_ms'] = $personalMsData;
        // } else {
        //     echo 'Error fetching personal_ms: ' . $conn->error;
        // }

        $sqlMaterials = "SELECT 
                            raw_material_in_group.raw_group_id, 
                            raw_material.raw_id, 
                            raw_material.raw_thainame, 
                            raw_material.raw_engname
                        FROM 
                            raw_material_in_group
                        INNER JOIN 
                            raw_material ON raw_material_in_group.raw_id = raw_material.raw_id
                        WHERE 
                            raw_material_in_group.raw_group_id = $rawGroupId
                        ORDER BY raw_material_in_group.raw_group_id";

        $resultMaterials = $conn->query($sqlMaterials);

        if ($resultMaterials) {
            $materials = $resultMaterials->fetch_all(MYSQLI_ASSOC);
            $group['materials'] = $materials;
        } else {
            echo 'Error fetching materials: ' . $conn->error;
        }

        // คำสั่ง SQL สำหรับดึงข้อมูลจาก mineral_source_in_group
        $sqlMineralSourceInGroup = "SELECT 
                                        mineral_source_in_group.ingroup_ms_id, 
                                        mineral_source_in_group.ms_id, 
                                        mineral_source_raw.ms_thainame AS ms_thainame, 
                                        mineral_source_raw.ms_engname AS ms_engname, 
                                        mineral_source_in_group.raw_group_id
                                    FROM 
                                        mineral_source_in_group
                                    INNER JOIN 
                                        mineral_source_raw ON mineral_source_in_group.ms_id = mineral_source_raw.ms_id
                                    WHERE 
                                        mineral_source_in_group.raw_group_id = $rawGroupId
                                    ORDER BY 
                                        mineral_source_in_group.ingroup_ms_id";

        $resultMineralSourceInGroup = $conn->query($sqlMineralSourceInGroup);

        if ($resultMineralSourceInGroup) {
            $mineralSourceInGroupData = $resultMineralSourceInGroup->fetch_all(MYSQLI_ASSOC);
            $group['mineral_source_in_group'] = $mineralSourceInGroupData;
        } else {
            echo 'Error fetching mineral_source_in_group: ' . $conn->error;
        }


    } else {
        echo 'Error fetching groups: ' . $conn->error;
    }
} else {
    echo 'Missing Raw Group ID';
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hello, Bootstrap Table!</title>
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

        @media (max-width: 577px) {

            .selectRaw,
            .selectMineral,
            .detail {
                padding: 1em;
            }
        }
    </style>
</head>

<body>
    <?php include "nav-bar.php"; ?>
    <h1 class="text-center mb-5 mt-4">แก้ไขคลังวัตถุดิบ</h1>
    <div class="container">
        <div>
            <form method="POST" action="select_raw_editdb.php" id="myForm">
                <input type="hidden" name="rawGroupId" value="<?php echo $rawGroupId; ?>">
                <div class="details">
                    <h4>รายละเอียดคลังวัตถุดิบ</h4>
                    <div class="detail">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <label for="namedetail" class="form-label fs-5 fw-medium">ชื่อกลุ่มวัตถุดิบ</label>
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="กรอกชื่อกลุ่มวัตถุดิบ" id="namedetail"
                                        name="namedetail" required><?php echo $group['group_name'] ?></textarea>
                                    <label for="namedetail" class="text-secondary">กรอกชื่อกลุ่มวัตถุดิบ</label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <label for="nameRaw" class="form-label fs-5 fw-medium">รายละเอียดกลุ่ม</label>
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="กรอกรายละเอียดกลุ่มวัตถุดิบ"
                                        id="detailRaw"
                                        name="detailRaw"><?php echo $group['group_description']; ?></textarea>
                                    <label for="detailRaw" class="text-secondary">กรอกรายละเอียดกลุ่มวัตถุดิบ</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="raw mt-5">
                    <h4>เลือกรายการวัตถุดิบ</h4>
                    <div class="selectRaw">
                        <label class="form-label fs-5 fw-medium">รายการวัตถุดิบเดิม</label>
                        <div class="table-responsive">
                            <table class="table table-light table-striped-columns text-center">
                                <thead class="table-danger">
                                    <tr>
                                        <th scope="col">ลำดับ</th>
                                        <th scope="col">รายชื่อวัตถุดิบ</th>
                                        <th scope="col">การจัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $counter = 1;
                                    foreach ($group['materials'] as $material) {
                                        $existingRawIDs[] = $material['raw_id'];
                                        echo '<tr>';
                                        echo '<th scope="row">' . $counter . '</th>';
                                        echo '<td>' . $material['raw_thainame'] . ' (' . $material['raw_engname'] . ')' . '</td>';
                                        echo '<td>'; ?>
                                        <button type="button" class="btn btn-danger btn-sm btn-delete-raw"
                                            data-raw-id="<?php echo $material['raw_id']; ?>"
                                            data-raw-group-id="<?php echo $rawGroupId; ?>">
                                            <i class="bi bi-trash-fill"></i> ลบรายชื่อ
                                        </button>

                                        <?php echo '</td>';
                                        echo '</tr>';
                                        $counter++;
                                    }
                                    if (empty($group['materials'])) {
                                        echo '<tr>';
                                        echo '<td colspan="3">ไม่มีข้อมูลรายการวัตถุดิบเดิม</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <label for="selectRaw" class="form-label fs-5 fw-medium">เลือกวัตถุดิบเพิ่มเติม</label>
                        <select class="form-select" id="selectRaw" data-placeholder="ค้นหาหรือเลือกวัตถุดิบ"
                            name="selectRaw[]" multiple>
                            <?php
                            $sqlRaw = "SELECT * FROM raw_material";
                            $resultRaw = mysqli_query($conn, $sqlRaw);
                            while ($rowRaw = mysqli_fetch_assoc($resultRaw)) {
                                $rawID = $rowRaw['raw_id'];
                                if (!in_array($rawID, $existingRawIDs)) {
                                    echo '<option value="' . $rawID . '">' . $rowRaw['raw_thainame'] . ' (' . $rowRaw['raw_engname'] . ')' . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <!-- <hr class="mt-4 mb-3">
                        <label class="form-label fs-5 fw-medium">รายการวัตถุดิบเดิม</label>
                        <table class="table table-light table-striped-columns text-center">
                            <thead class="table-warning">
                                <tr>
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">รายชื่อวัตถุดิบ</th>
                                    <th scope="col">การจัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (empty($personalRawData)) {
                                    echo '<tr><td colspan="3">ไม่มีข้อมูลรายการ</td></tr>';
                                } else {
                                    $counter = 1;
                                    foreach ($personalRawData as $personalRaw) {
                                        ?>
                                        <tr>
                                            <th scope="row">
                                                <?php echo $counter; ?>
                                            </th>
                                            <td>
                                                <?php echo $personalRaw['p_raw_name']; ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm m-1"
                                                    onclick="openEditModal(<?php echo $personalRaw['personal_raw_id']; ?>, '<?php echo $personalRaw['p_raw_name']; ?>', '<?php echo $rawGroupId; ?>')">
                                                    <i class="bi bi-pencil-square"></i> แก้ไขรายชื่อ
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm m-1 btn-delete"
                                                    data-id="<?php echo $personalRaw['personal_raw_id']; ?>"
                                                    data-type="personal_raw">
                                                    <i class="bi bi-trash-fill"></i> ลบรายชื่อ
                                                </button>
                                            </td>
                                        </tr>
                                        <?php $counter++; ?>
                                    <?php }
                                } ?>
                            </tbody>
                        </table>
                        <div class="listRaw">
                            <label for="addRaw" class="form-label fs-5 fw-medium mt-3">เพิ่มวัตถุดิบที่ต้องการ</label>
                            <div class="keyword-listRaw" id="keywordListRaw">
                                <div class="keyword-row">
                                    <div class="row">
                                        <div class="col-11">
                                            <input type="text" class="form-control "
                                                placeholder="กรอกวัตถุดิบที่ต้องการเพิ่มเติม" name="addRawKey[]">
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
                <div class="mineral mt-5">
                    <h4>เลือกรายการแร่ธาตุ</h4>
                    <div class="selectMineral">
                        <label class="form-label fs-5 fw-medium">รายการแร่ธาตุเดิม</label>
                        <div class="table-responsive">
                            <table class="table table-light table-striped-columns text-center">
                                <thead class="table-danger">
                                    <tr>
                                        <th scope="col">ลำดับ</th>
                                        <th scope="col">รายชื่อแร่ธาตุ</th>
                                        <th scope="col">การจัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $counter = 1;
                                    foreach ($group['mineral_source_in_group'] as $mineral_source) {
                                        $existingMsIDs[] = $mineral_source['ms_id'];
                                        echo '<tr>';
                                        echo '<th scope="row">' . $counter . '</th>';
                                        echo '<td>' . $mineral_source['ms_thainame'] . ' (' . $mineral_source['ms_engname'] . ')' . '</td>';
                                        echo '<td>'; ?>

                                        <button type="button" class="btn btn-danger btn-sm btn-delete-ms"
                                            data-ms-id="<?php echo $mineral_source['ms_id']; ?>"
                                            data-ms-group-id="<?php echo $rawGroupId; ?>">
                                            <i class="bi bi-trash-fill"></i> ลบรายชื่อ
                                        </button>

                                        <?php echo '</td>';
                                        echo '</tr>';
                                        $counter++;
                                    }
                                    if (empty($group['mineral_source_in_group'])) {
                                        echo '<tr>';
                                        echo '<td colspan="3">ไม่มีข้อมูลรายการแร่ธาตุเดิม</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>

                            </table>
                        </div>
                        <label for="selectMineral" class="form-label fs-5 fw-medium">เลือกแร่ธาตุ</label>
                        <select class="form-select" id="selectMineral" data-placeholder="ค้นหาหรือเลือกแร่ธาตุ"
                            name="selectMineral[]" multiple>
                            <?php
                            $sqlMineral = "SELECT * FROM mineral_source_raw";
                            $resultMineral = mysqli_query($conn, $sqlMineral);

                            while ($rowMineral = mysqli_fetch_assoc($resultMineral)) {
                                $ms_id = $rowMineral['ms_id'];
                                if (!in_array($ms_id, $existingMsIDs)) {
                                    echo '<option value="' . $ms_id . '">' . $rowMineral['ms_thainame'] . ' (' . $rowMineral['ms_engname'] . ')' . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <!-- <hr class="mt-4 mb-3">
                        <label class="form-label fs-5 fw-medium">รายการแร่ธาตุเดิม</label>
                        <table class="table table-light table-striped-columns text-center">
                            <thead class="table-warning">
                                <tr>
                                    <th scope="col">ลำดับ</th>
                                    <th scope="col">รายชื่อวัตถุดิบ</th>
                                    <th scope="col">การจัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (empty($personalMsData)) {
                                    echo '<tr><td colspan="3">ไม่มีข้อมูลรายการ</td></tr>';
                                } else {
                                    $counter = 1;
                                    foreach ($personalMsData as $personalMs) {
                                        ?>
                                        <tr>
                                            <th scope="row">
                                                <?php echo $counter; ?>
                                            </th>
                                            <td>
                                                <?php echo $personalMs['p_ms_name']; ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm m-1"
                                                    onclick="openMSEditModal(<?php echo $personalMs['personal_ms_id']; ?>, '<?php echo $personalMs['p_ms_name']; ?>', '<?php echo $rawGroupId; ?>')">
                                                    <i class="bi bi-pencil-square"></i> แก้ไขรายชื่อ
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm m-1 btn-delete"
                                                    data-id="<?php echo $personalMs['personal_ms_id']; ?>"
                                                    data-type="personal_ms">
                                                    <i class="bi bi-trash-fill"></i> ลบรายชื่อ
                                                </button>
                                            </td>
                                        </tr>
                                        <?php $counter++; ?>
                                    <?php }
                                } ?>
                            </tbody>
                        </table>
                        <div class="listMineral">
                            <label for="addMineral"
                                class="form-label fs-5 fw-medium mt-3">เพิ่มแร่ธาตุที่ต้องการ</label>
                            <div class="keyword-listMineral" id="keywordListMineral">
                                <div class="keyword-rowMineral">
                                    <div class="row">
                                        <div class="col-11">
                                            <input type="text" class="form-control"
                                                placeholder="กรอกแร่ธาตุที่ต้องการเพิ่มเติม" name="addMineralKey[]">
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
                <div class="form-group d-flex justify-content-center mt-5 mb-5 sentbtn">
                    <button type="reset" class="btn btn-danger btn-reset"
                        onclick="window.location.href = 'select_raw.php'">ย้อนกลับ</button>
                    <button type="submit" class="btn btn-primary btn-submit">ยืนยัน</button>
                </div>
            </form>
        </div>
    </div>

    <!-- <div class="modal fade" id="editPersonalRawModal" tabindex="-1" aria-labelledby="editPersonalRawModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPersonalRawModalLabel">แก้ไขรายชื่อวัตถุดิบ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editPersonalRawForm" action="personalraw_update.php" method="POST">
                    <input type="hidden" name="personalRawId" id="editPersonalRawId">
                    <input type="hidden" name="raw_group_id" id="raw_group_id">
                    <div class="modal-body">
                        <input class="form-control" type="text" name="new_p_raw_name" id="editPersonalRawName">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-success">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editPersonalMsModal" tabindex="-1" aria-labelledby="editPersonalMsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPersonalMsModalLabel">แก้ไขรายชื่อวัตถุดิบ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editPersonalMsForm" action="personalms_update.php" method="POST">
                    <input type="hidden" name="personalMsId" id="editPersonalMsId">
                    <input type="hidden" name="rawMs_group_id" id="rawMs_group_id">
                    <div class="modal-body">
                        <input class="form-control" type="text" name="new_p_ms_name" id="editPersonalMsName">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-success">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div> -->

    <?php
    if (isset($_GET['resultData'])) {
        $resultData = urldecode($_GET['resultData']);
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
    }
    if (isset($_SESSION['resultUp'])) {
        $resultUp = $_SESSION['resultUp'];

        // ในส่วนของ JavaScript ที่อยู่ในหน้า select_raw.php
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'ข้อมูลถูกอัพเดตเรียบร้อย',
                        text: '" . $resultUp . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
        unset($_SESSION['resultUp']);
    }
    ?>

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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- <script>
        function openEditModal(personalRawId, pRawName, rawGroupId) {
            $('#editPersonalRawId').val(personalRawId);
            $('#editPersonalRawName').val(pRawName);
            $('#raw_group_id').val(rawGroupId);

            $('#editPersonalRawModal').modal('show');
        }

        function editPersonalRaw() {
            var personalRawId = $('#editPersonalRawId').val();
            var newPRawName = $('#editPersonalRawName').val();
            var rawGroupId = $('#raw_group_id').val();

            $('#editPersonalRawModal').modal('hide');
        }
    </script> -->
    <!-- <script>
        function openMSEditModal(personalMsId, pMsName, rawGroupId) {
            $('#editPersonalMsId').val(personalMsId);
            $('#editPersonalMsName').val(pMsName);
            $('#rawMs_group_id').val(rawGroupId);

            $('#editPersonalMsModal').modal('show');
        }

        function editPersonalMs() {
            var personalMsId = $('#editPersonalMsId').val();
            var newPMsName = $('#editPersonalMsName').val();
            var rawGroupId = $('#rawMs_group_id').val();

            $('#editPersonalMsModal').modal('hide');
        }
    </script> -->
    <script>
        $(document).ready(function () {
            function confirmDelete(id, dataType, rawGroupId) {
                Swal.fire({
                    title: 'คุณแน่ใจหรือไม่?',
                    text: 'คุณต้องการลบรายชื่อนี้หรือไม่?',
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
                            url: 'delete_raw.php',
                            data: { RawId: id, DataType: dataType, RawGroupId: rawGroupId },
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

            $('.btn-delete-raw').click(function () {
                var rawId = $(this).data('raw-id');
                var rawGroupId = $(this).data('raw-group-id');
                confirmDelete(rawId, 'raw', rawGroupId);
            });

            $('.btn-delete-ms').click(function () {
                var msId = $(this).data('ms-id');
                var rawGroupId = $(this).data('ms-group-id');
                confirmDelete(msId, 'ms', rawGroupId);
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            function confirmDelete(personalId, dataType) {
                Swal.fire({
                    title: 'คุณแน่ใจหรือไม่?',
                    text: 'คุณต้องการลบรายชื่อนี้หรือไม่?',
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
                            url: 'delete_p_raw.php',
                            data: { personalId: personalId, dataType: dataType },
                            success: function (response) {
                                console.log('Response from delete_p_raw.php:', response);
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

            $('.btn-delete').click(function () {
                var personalId = $(this).data('id');
                var dataType = $(this).data('type');
                confirmDelete(personalId, dataType);
            });
        });
    </script>

</body>

</html>