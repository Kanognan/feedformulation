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
<html lang="th">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <title>รายการรายรับ/รายจ่าย</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Kanit', sans-serif;
    }

    .flex {
        display: flex;
    }

    .g-2 {
        flex: 1;
    }

    .content {
        padding: 3em;
        padding-left: 17em !important;
        width: 100%;
        height: cover;
    }

    .charge {
        background-color: #f3fded;
        border-radius: 15px;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
    }

    .receipts {
        background-color: #fffdec;
        border-radius: 15px;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;

    }

    .content-profit {
        padding: 1.2em;
        /* height: 30em; */

    }

    .addmore .btn {
        display: block;
        background-color: #92CA68;
        color: white;
        padding: 0.5em;
        width: 6em;
        margin: 0 auto;
        border-radius: 20px;
        font-size: 1em;
    }

    .addmore .btn:hover,
    .addmore .btn:focus:hover {
        background-color: #DBEDF2;
        color: black;
    }

    .btn-more {
        margin: 1em 0;
    }

    .btn-more .btn-add {
        background-color: #77DC67;
        color: white;
        width: 8em;
        border-radius: 20px !important;
        margin: 0em 0.3em;
    }

    .btn-more .btn-add:hover {
        background-color: #6999C6 !important;
    }

    .btn-more .btn-cancel {
        background-color: #FE5E5E;
        color: white;
        width: 8em;
        border-radius: 20px !important;
        margin: 0em 0.3em;
    }

    .btn-more .btn-cancel:hover {
        background-color: #6999C6 !important;
    }

    .head-profit-receipts {
        padding: 0.8em;
        background-color: #ffe792;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .head-profit-charge {
        padding: 0.8em;
        background-color: #bbe8c7;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    #exampleModal.modal.fade.show {
        background-color: #0000003d !important;
    }



    .cat {
        margin: 0.5em auto;
        background-color: #f5f5f5;
        border-radius: 30px;
        text-align: center;
        border-radius: 30px;
        padding: 1.2em;
        border: none;
        width: 13.5em;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
    }

    .cat:hover {
        background-color: lightgray;
    }

    .cat-form {
        margin: 0.5em auto;
        background-color: #c8ead1;
        border-radius: 30px;
        text-align: center;
        border-radius: 30px;
        padding: 1.2em;
        border: none;
        width: 13.5em;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
    }

    .cat-active {
        margin: 0.5em auto;
        background-color: #A1CAE2;
        border-radius: 30px;
        text-align: center;
        border-radius: 30px;
        padding: 1.2em;
        border: none;
        width: 13.5em;
        color: white;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
    }

    .box1 {
        height: 25em;
        border: 1px solid gray;
    }



    .content-detail-name {
        background-color: #b0c6d9;
        padding: 0.5em;
    }

    .bg-content {
        background-color: #DBEDF2;
        /* max-height: 9em; */
        /* overflow: auto; */
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

    .nav-pills .nav-link.active {
        background-color: #bbd1e5 !important;
    }



    @media (max-width: 576px) {
        .content {
            padding-left: 3.5em !important;
            padding-right: .5em !important;

        }

        .g-2 {
            width: 90%;
        }

        .content .row {
            flex-direction: column;
            align-items: center;

        }

        .content .col {
            width: 100%;
            

        }

        .table-scroll {
            overflow-x: auto;
            /* เพิ่มการสำรองที่เลื่อนแนวนอนในกรณีของตารางที่มีข้อมูลมาก */
        }

        .table-scroll table {
            min-width: 100%;
            /* ให้ตารางยืดออกตามขนาดของข้อมูล */
        }

        /* .align-self-center {
            text-align: center;
        } */

        .cat,
        .cat-active {
            margin: 0.5em auto;
            width:100%;
        }

        .cat-form {
            margin: 0.5em auto;
            width:100%;
            
        }

        .tab-content {
            padding: 0;
        }
        /* .row>*{
                padding-right: calc(var(--bs-gutter-x)* .1)!important;
                margin-top: 0.5em;
            } */
    }
    @media (min-width: 768px) {
            /* .col-md-6{
                width:100% !important;
            } */
            .g-2{
                width:92% !important;
            }
            .tab-content{
                padding:0;
            }
           
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.3/dist/bootstrap-table.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.1/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.2/dist/bootstrap-table-locale-all.min.js"></script>
    </script>

<body>
    <div class="flex">
        <div class="g-1">
            <?php include ('sidebar.php') ?>
        </div>
        <div class="g-2">
            <div class="content">
                <!-- เนื้อหา -->
                <div class="row text-center">
                    <div class="col-12 col-lg col-md-6 col-sm-12">
                        <button type="button" onclick="window.location='form_statement.php'" class="cat-form">+
                            เพิ่มรายรับ/รายจ่าย</button>
                    </div>
                    <div class="col-12 col-lg col-md-6 col-sm-12">
                        <button type="button" onclick="window.location='index_profit.php'"
                            class="cat-active">สรุปรายรับ/รายจ่าย</button>
                    </div>
                    <div class="col-12 col-lg col-md-6 col-sm-12">
                        <button type="button" onclick="window.location='r_daily.php'"
                            class="cat">ผลตอบแทนรายวัน</button>
                    </div>
                    <div class="col-12 col-lg col-md-6 col-sm-12">
                        <button type="button" onclick="window.location='r_monthy.php'"
                            class="cat">ผลตอบแทนรายเดือน</button>
                    </div>
                    <div class="col-12 col-lg col-md-6 col-sm-12">
                        <button type="button" onclick="window.location='r_yearly.php'"
                            class="cat">ผลตอบแทนรายปี</button>
                    </div>
                </div>

                <br>
                <h3 class="text-center">สรุปรายรับ/รายจ่าย</h3><br>
                <div class="container">
                    <ul class="nav nav-tabs nav-pills nav-fill" id="month" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active text-black fs-5" id="month" data-bs-toggle="tab"
                                data-bs-target="#month-pane" type="button" role="tab" aria-controls="month-pane"
                                aria-selected="false">สรุปรายรับ/รายจ่ายประจำเดือน</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-black fs-5" id="all" data-bs-toggle="tab"
                                data-bs-target="#all-pane" type="button" role="tab" aria-controls="all-pane"
                                aria-selected="true">สรุปรายรับ/รายจ่ายทั้งหมด</button>
                        </li>
                    </ul>
                    <div class="tab-content bg-white" id="monthContent">
                        <div class="tab-pane fade show active" id="month-pane" role="tabpanel" aria-labelledby="month"
                            tabindex="0">
                            <div class="row">
                                <div class="col-md-12 col-lg-6 col-12 mt-5">
                                    <div class="receipts">
                                        <?php
                                        // ตัวแปรสำหรับเก็บชื่อเดือนภาษาไทยเต็ม
                                        $thai_months_full = [
                                            'มกราคม',
                                            'กุมภาพันธ์',
                                            'มีนาคม',
                                            'เมษายน',
                                            'พฤษภาคม',
                                            'มิถุนายน',
                                            'กรกฎาคม',
                                            'สิงหาคม',
                                            'กันยายน',
                                            'ตุลาคม',
                                            'พฤศจิกายน',
                                            'ธันวาคม'
                                        ];
                                        // ตัวแปรสำหรับเก็บชื่อเดือนภาษาไทยเต็ม
                                        // $thai_months_short = [
                                        //     'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.',
                                        //     'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'
                                        // ];
                                        
                                        // เดือนปัจจุบันในรูปแบบตัวเลข (1 = มกราคม, 2 = กุมภาพันธ์, ... , 12 = ธันวาคม)
                                        $current_month_number = date('n');

                                        // ชื่อเดือนภาษาไทยเต็มของเดือนปัจจุบัน
                                        $thai_current_month_full = $thai_months_full[$current_month_number - 1];
                                        // ชื่อเดือนภาษาไทยสั้นของเดือนปัจจุบัน
                                        // $thai_current_month_short = $thai_months_short[$current_month_number - 1];
                                        // แสดงผล
                                        // echo "เดือนปัจจุบันภาษาไทย (เต็ม): " . $thai_current_month_full . "<br>";
                                        // echo "เดือนปัจจุบันภาษาไทย (สั้น): " . $thai_current_month_short . "<br>";
                                        ?>
                                        <h4 class='head-profit-receipts'>รายจ่ายประจำเดือน
                                            <?php echo $thai_current_month_full; ?>
                                        </h4>
                                        <div class="content-profit">
                                            <div class="row">
                                                <div class="col-10">
                                                    <h5>รายการทั้งหมด</h5>
                                                </div>
                                            </div>

                                            <table class="table " id="table" data-filter-control="true"
                                                data-toggle="table" data-locale="th-TH" data-flat="true"
                                                data-icons="icons" data-toggle="table" data-maintain-meta-data="true"
                                                data-height="460">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>วัน/เดือน/ปี</th>
                                                        <th>รายละเอียด</th>
                                                        <th>จำนวนเงิน(บาท)</th>
                                                        <th>จัดการ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $amount_total = 0;
                                                    $sql = "SELECT * FROM statement WHERE statement_status = 'รายจ่าย' AND MONTH(statement_date) = MONTH(CURRENT_DATE()) AND YEAR(statement_date) = YEAR(CURRENT_DATE()) AND acc_id = $acc_id ORDER BY statement_id DESC";
                                                    $result2 = mysqli_query($conn, $sql);
                                                    while ($row2 = mysqli_fetch_array($result2)) { ?>
                                                    <tr class="text-center">
                                                        <td>
                                                            <?php echo date("d/m/Y", strtotime($row2["statement_date"])); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row2['statement_detail']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo number_format($row2['statement_amount'], 2); ?>
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="d-grid gap-2 d-md-flex justify-content-md-center">
                                                                <div onclick="window.location.href='edit_form_statement.php?statement_id=<?php echo $row2['statement_id']; ?>'"
                                                                    data-bs-toggle="modal" class="btn btn-warning"><i
                                                                        class="fa-solid fa-pen"></i></div>
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#delstatement<?php echo $row2['statement_id']; ?>"><i
                                                                        class="fa-solid fa-trash"></i></button>
                                                                <!-- Modal -->
                                                                <div class="modal"
                                                                    id="delstatement<?php echo $row2['statement_id']; ?>"
                                                                    tabindex="-1" aria-labelledby="delstatementLabel"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="delstatementLabel">
                                                                                    ลบข้อมูลรายรับ
                                                                                </h5>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <?php
                                                                                    $sm = mysqli_query($conn, "select * from statement where statement_id='" . $row2['statement_id'] . "'");
                                                                                    $qsm = mysqli_fetch_array($sm);
                                                                                    ?>
                                                                                <div
                                                                                    class="container-fluid text-center">
                                                                                    คุณต้องการลบรายการ : <strong>
                                                                                        <?php echo $qsm['statement_detail']; ?>
                                                                                    </strong> ใช่หรือไม่
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">ปิด</button>
                                                                                <a href="del_statement.php?statement_id=<?php echo $row2['statement_id']; ?>"
                                                                                    class="btn btn-danger"><span
                                                                                        class="glyphicon glyphicon-trash"></span>
                                                                                    ยืนยัน</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php @$amount_total += $row2['statement_amount'];
                                                    }
                                                    ?>

                                                </tbody>

                                            </table>
                                            <table class="table table-hover table-warning">
                                                <tr>
                                                    <td width="10%"></td>
                                                    <td width="20%">รวม</td>
                                                    <td width="20%" style="text-align:center">
                                                        <b>
                                                            <?php echo number_format($amount_total, 2); ?>
                                                        </b>
                                                    </td>
                                                    <td width="10%"></td>
                                                </tr>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                                <!-- รายรับประจำเดือน -->
                                <div class="col-md-12 col-lg-6 col-12 mt-5">
                                    <div class="charge">
                                        <h4 class='head-profit-charge'>รายรับประจำเดือน
                                            <?php echo $thai_current_month_full; ?>
                                        </h4>
                                        <div class="content-profit">
                                            <div class="row">
                                                <div class="col-10">
                                                    <h5>รายการทั้งหมด</h5>
                                                </div>
                                            </div>
                                            <table class="table " id="table" data-filter-control="true"
                                                data-toggle="table" data-locale="th-TH" data-flat="true"
                                                data-icons="icons" data-toggle="table" data-maintain-meta-data="true"
                                                data-height="460">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>วัน/เดือน/ปี</th>
                                                        <th>รายละเอียด</th>
                                                        <th>จำนวนเงิน(บาท)</th>
                                                        <th>จัดการ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sql = "SELECT * FROM statement WHERE statement_status = 'รายรับ' AND MONTH(statement_date) = MONTH(CURRENT_DATE()) AND YEAR(statement_date) = YEAR(CURRENT_DATE()) AND acc_id = $acc_id ORDER BY statement_id DESC";
                                                    $result2 = mysqli_query($conn, $sql); 
                                                    while ($row2 = mysqli_fetch_array($result2)) { ?>
                                                    <tr class="text-center">
                                                        <td>
                                                            <?php echo date("d/m/Y", strtotime($row2["statement_date"])); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row2['statement_detail']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo number_format($row2['statement_amount'], 2); ?>
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="d-grid gap-2 d-md-flex justify-content-md-center">
                                                                <div onclick="window.location.href='edit_form_statement.php?statement_id=<?php echo $row2['statement_id']; ?>'"
                                                                    data-bs-toggle="modal" class="btn btn-warning"><i
                                                                        class="fa-solid fa-pen"></i></div>
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#delstatement<?php echo $row2['statement_id']; ?>"><i
                                                                        class="fa-solid fa-trash"></i></button>
                                                                <!-- Modal -->
                                                                <div class="modal"
                                                                    id="delstatement<?php echo $row2['statement_id']; ?>"
                                                                    tabindex="-1" aria-labelledby="delstatementLabel"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="delstatementLabel">
                                                                                    ลบข้อมูลรายรับ
                                                                                </h5>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <?php
                                                                                    $sm = mysqli_query($conn, "select * from statement where statement_id='" . $row2['statement_id'] . "'");
                                                                                    $qsm = mysqli_fetch_array($sm);
                                                                                    ?>
                                                                                <div
                                                                                    class="container-fluid text-center">
                                                                                    คุณต้องการลบรายการ : <strong>
                                                                                        <?php echo $qsm['statement_detail']; ?>
                                                                                    </strong> ใช่หรือไม่
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">ปิด</button>
                                                                                <a href="del_statement.php?statement_id=<?php echo $row2['statement_id']; ?>"
                                                                                    class="btn btn-danger"><span
                                                                                        class="glyphicon glyphicon-trash"></span>
                                                                                    ยืนยัน</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php @$amount_total += $row2['statement_amount'];
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>

                                            <table class="table table-hover table-success">
                                                <tr>
                                                    <td width="10%"></td>
                                                    <td width="20%">รวม</td>
                                                    <td width="20%" style="text-align:center">
                                                        <b>
                                                            <?php echo number_format($amount_total, 2); ?>
                                                        </b>
                                                    </td>
                                                    <td width="10%"></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="all-pane" role="tabpanel" aria-labelledby="all" tabindex="0">
                            <div class="row">
                                <div class="col-md-12 col-lg-6 col-12 mt-5">
                                    <div class="receipts">
                                        <h4 class='head-profit-receipts'>รายจ่ายทั้งหมด</h4>
                                        <div class="content-profit">
                                            <div class="row">
                                                <div class="col-10">
                                                    <h5>รายการทั้งหมด</h5>
                                                </div>
                                            </div>
                                            <table class="table " id="table" data-filter-control="true"
                                                data-toggle="table" data-locale="th-TH" data-flat="true"
                                                data-icons="icons" data-toggle="table" data-maintain-meta-data="true"
                                                data-height="460">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>วัน/เดือน/ปี</th>
                                                        <th>รายละเอียด</th>
                                                        <th>จำนวนเงิน(บาท)</th>
                                                        <th>จัดการ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sql = "SELECT * FROM statement WHERE statement_status = 'รายจ่าย' AND acc_id = $acc_id ORDER BY createAt DESC";
                                                    $result2 = mysqli_query($conn, $sql);
                                                    while ($row2 = mysqli_fetch_array($result2)) { ?>
                                                    <tr class="text-center">
                                                        <td>
                                                            <?php echo date("d/m/Y", strtotime($row2["statement_date"])); ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row2['statement_detail']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo number_format($row2['statement_amount'], 2); ?>
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="d-grid gap-2 d-md-flex justify-content-md-center">
                                                                <div onclick="window.location.href='edit_form_statement.php?statement_id=<?php echo $row2['statement_id']; ?>'"
                                                                    data-bs-toggle="modal" class="btn btn-warning"><i
                                                                        class="fa-solid fa-pen"></i></div>
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#delstatement<?php echo $row2['statement_id']; ?>"><i
                                                                        class="fa-solid fa-trash"></i></button>
                                                                <!-- Modal -->
                                                                <div class="modal"
                                                                    id="delstatement<?php echo $row2['statement_id']; ?>"
                                                                    tabindex="-1" aria-labelledby="delstatementLabel"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="delstatementLabel">
                                                                                    ลบข้อมูลรายรับ
                                                                                </h5>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <?php
                                                                                    $sm = mysqli_query($conn, "select * from statement where statement_id='" . $row2['statement_id'] . "' ");
                                                                                    $qsm = mysqli_fetch_array($sm);
                                                                                    ?>
                                                                                <div
                                                                                    class="container-fluid text-center">
                                                                                    คุณต้องการลบรายการ : <strong>
                                                                                        <?php echo $qsm['statement_detail']; ?>
                                                                                    </strong> ใช่หรือไม่
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">ปิด</button>
                                                                                <a href="del_statement.php?statement_id=<?php echo $row2['statement_id']; ?>"
                                                                                    class="btn btn-danger"><span
                                                                                        class="glyphicon glyphicon-trash"></span>
                                                                                    ยืนยัน</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php @$amount_total += $row2['statement_amount'];
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-6 col-12 mt-5">
                                    <div class="charge">
                                        <h4 class='head-profit-charge'>รายรับทั้งหมด</h4>
                                        <div class="content-profit">
                                            <div class="row">
                                                <div class="col-10">
                                                    <?php
                                                    $sql = "SELECT * FROM statement WHERE statement_status = 'รายรับ' AND acc_id = $acc_id ORDER BY createAt DESC";
                                                    $result2 = mysqli_query($conn, $sql);
                                                    ?>
                                                    <h5>รายการทั้งหมด</h5>
                                                </div>
                                            </div>
                                            <table class="table " id="table" data-filter-control="true"
                                                data-toggle="table" data-locale="th-TH" data-flat="true"
                                                data-icons="icons" data-toggle="table" data-maintain-meta-data="true"
                                                data-height="460">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>วัน/เดือน/ปี</th>
                                                        <th>รายละเอียด</th>
                                                        <th>จำนวนเงิน(บาท)</th>
                                                        <th>จัดการ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    while ($row2 = mysqli_fetch_array($result2)) { ?>
                                                    <tr class="text-center">
                                                        <td width="22%">
                                                            <?php echo date("d/m/Y", strtotime($row2["statement_date"])); ?>
                                                        </td>
                                                        <td width="30%">
                                                            <?php echo $row2['statement_detail']; ?>
                                                        </td>
                                                        <td width="20%" style="text-align:center;">
                                                            <?php echo number_format($row2['statement_amount'], 2); ?>
                                                        </td>
                                                        <td width="10%">
                                                            <div
                                                                class="d-grid gap-2 d-md-flex justify-content-md-center">
                                                                <div onclick="window.location.href='edit_form_statement.php?statement_id=<?php echo $row2['statement_id']; ?>'"
                                                                    data-bs-toggle="modal" class="btn btn-warning"><i
                                                                        class="fa-solid fa-pen"></i></div>
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#delstatement<?php echo $row2['statement_id']; ?>"><i
                                                                        class="fa-solid fa-trash"></i></button>
                                                                <!-- Modal -->
                                                                <div class="modal"
                                                                    id="delstatement<?php echo $row2['statement_id']; ?>"
                                                                    tabindex="-1" aria-labelledby="delstatementLabel"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="delstatementLabel">
                                                                                    ลบข้อมูลรายรับ
                                                                                </h5>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <?php
                                                                                    $sm = mysqli_query($conn, "select * from statement where statement_id='" . $row2['statement_id'] . "'");
                                                                                    $qsm = mysqli_fetch_array($sm);
                                                                                    ?>
                                                                                <div
                                                                                    class="container-fluid text-center">
                                                                                    คุณต้องการลบรายการ : <strong>
                                                                                        <?php echo $qsm['statement_detail']; ?>
                                                                                    </strong> ใช่หรือไม่
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">ปิด</button>
                                                                                <a href="del_statement.php?statement_id=<?php echo $row2['statement_id']; ?>"
                                                                                    class="btn btn-danger"><span
                                                                                        class="glyphicon glyphicon-trash"></span>
                                                                                    ยืนยัน</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php @$amount_total += $row2['statement_amount'];
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- เนื้อหา -->
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
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector("#menu a[href='index_profit.php']").classList.add("active");
    });
    </script>
</body>

</html>