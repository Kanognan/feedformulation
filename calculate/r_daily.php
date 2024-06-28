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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <title>คำนวณผลตอบแทนรายวัน</title>
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
        }

        .charge {
            background-color: #e1fddb;
            margin: 2em;
        }

        .receipts {
            background-color: #fffacc;
            ;
            margin: 2em;
        }

        .content-profit {
            padding: 2em;
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
            padding: 0.7em;
            background-color: #ffe792;
        }

        .head-profit-charge {
            padding: 0.7em;
            background-color: #73c088;

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

        canvas {
            width: 800px;
            height: 300px;
        }
        @media (max-width: 576px) {
            
            .content {
                padding-left: 3.5em !important;
                padding-right: .5em !important;

            }

            .g-2 {
                width: 90%;
                margin: 0;
            }

            .cat,
            .cat-active {
                margin: 0.5em auto;
                width: 100%;
            }

            .cat-form {
                margin: 0.5em auto;
                width: 100%;
            }
            
            .content-box {
                margin: 0 auto;
                width: 100%;
                /* padding: 1.2em; */
            }

            .keyword-row .col-1 {
                display: flex;
                align-items: center;
                justify-content: center;
                
            }

            .keyword-row .col-7 {
                display: flex;
                align-items: center;
               
            }

            .keyword-row .col-3 {
                display: flex;
                align-items: center;
                justify-content: flex-start;
               
                /* สำหรับจัดเรียงจากซ้ายไปขวา */
            }

            .keyword-row .col-1 {
                display: flex;
                align-items: center;
               
            }

            .remove-keyword-btn {
                width: 100%;
                
            }
            .content-box .row>* {
                padding-left: calc(var(--bs-gutter-x)* .2) !important;
                padding-right: calc(var(--bs-gutter-x)* .3) !important;
                font-size: 14px;
            }



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
                    <div class="col-12 col-lg col-md-6"><button type="button"
                            onclick="window.location='form_statement.php'" class="cat-form">+
                            เพิ่มรายรับ/รายจ่าย</button></div>
                    <div class="col-12 col-lg col-md-6"><button type="button"
                            onclick="window.location='index_profit.php'" class="cat">สรุปรายรับ/รายจ่าย</button> </div>
                    <div class="col-12 col-lg col-md-6"><button type="button" onclick="window.location='r_daily.php'"
                            class="cat-active">ผลตอบแทนรายวัน</button> </div>
                    <div class="col-12 col-lg col-md-6"><button type="button" onclick="window.location='r_monthy.php'"
                            class="cat">ผลตอบแทนรายเดือน</button> </div>
                    <div class="col-12 col-lg col-md-6"><button type="button" onclick="window.location='r_yearly.php'"
                            class="cat">ผลตอบแทนรายปี</button> </div>
                </div>
                <!-- เนื้อหา -->
                <!-- ผลตอบแทนรายวัน -->
                <br>
                <h3 class="text-center">ผลตอบแทนรายวัน</h3><br>
                <div class="container">
                    <div class="row box1">
                        <form action="r_daily.php" method="get" class="d-flex justify-content-center">
                            <div class="row">
                                <form class="d-flex justify-content-center">
                                    <div class="col-md-4 col-lg-4 col-12 mt-2">
                                        <input type="date" name="start_date" class="form-control">
                                    </div>
                                    <div class="col-md-1 align-self-center">
                                        <span>ถึง</span>
                                    </div>
                                    <div class="col-md-4 col-lg-4 col-12 mt-2">
                                        <input type="date" name="end_date" class="form-control">
                                    </div>
                                    <div class="col-md-3 col-lg-3 col-12 mt-2">
                                        <button type="search" class="btn btn-primary ">ค้นหา</button>
                                    </div>
                                </form>
                            </div>


                            <?php
                            if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
                                $query_chart = "SELECT *,
                                DATE_FORMAT(statement_date, '%d/%m/%Y') AS statement_date,
                                SUM(CASE WHEN statement_status = 'รายรับ' THEN statement_amount ELSE 0 END) AS total_revenue,
                                SUM(CASE WHEN statement_status = 'รายจ่าย' THEN statement_amount ELSE 0 END) AS total_expense,
                                SUM(CASE WHEN statement_status = 'รายรับ' THEN statement_amount ELSE 0 END) - 
                                SUM(CASE WHEN statement_status = 'รายจ่าย' THEN statement_amount ELSE 0 END) AS balance
                                FROM
                                statement
                                WHERE acc_id = $acc_id AND
                                DATE_FORMAT(statement_date, '%d/%m/%Y') BETWEEN '" . $_GET['start_date'] . "' AND '" . $_GET['end_date'] . "'
                                GROUP BY
                                DATE_FORMAT(statement_date, '%d/%m/%Y')
                                ORDER BY
                                DATE_FORMAT(statement_date, '%d/%m/%Y')";

                                // SQL Query to retrieve data
                                $sqltab2 = "SELECT *,
                                DATE_FORMAT(statement_date, '%d/%m/%Y') AS statement_date,
                                statement_status = 'รายรับ' AS revenue,
                                statement_status = 'รายจ่าย' AS expense,
                                SUM(CASE WHEN statement_status = 'รายรับ' THEN statement_amount ELSE 0 END) AS
                                total_revenue,
                                SUM(CASE WHEN statement_status = 'รายจ่าย' THEN statement_amount ELSE 0 END) AS
                                total_expense,
                                (SUM(CASE WHEN statement_status = 'รายรับ' THEN statement_amount ELSE 0 END) -
                                SUM(CASE WHEN statement_status = 'รายจ่าย' THEN statement_amount ELSE 0 END)) AS balance
                                FROM statement
                                WHERE acc_id = $acc_id AND
                                DATE_FORMAT(statement_date, '%d/%m/%Y') BETWEEN '" . $_GET['start_date'] . "' AND '" . $_GET['end_date'] . "'
                                GROUP BY DATE_FORMAT(statement_date, '%d/%m/%Y')
                                ORDER BY DATE_FORMAT(statement_date, '%d/%m/%Y')";
                                ?><br>
                                <p><b>ผลตอบแทนของวันที่ :</b>
                                    <?= date('d/m/Y', strtotime($_GET['start_date'])); ?>
                                    ถึง
                                    <?= date('d/m/Y', strtotime($_GET['end_date'])); ?>
                                </p><br>
                                <?php
                            } else {
                                // ถ้าไม่มีการค้นหาให้แสดงทั้งหมด
                                $query_chart = "SELECT *,
                                        DATE_FORMAT(statement_date, '%d/%m/%Y') AS statement_date,
                                        SUM(CASE WHEN statement_status = 'รายรับ' THEN statement_amount ELSE 0 END) AS total_revenue,
                                        SUM(CASE WHEN statement_status = 'รายจ่าย' THEN statement_amount ELSE 0 END) AS total_expense,
                                        SUM(CASE WHEN statement_status = 'รายรับ' THEN statement_amount ELSE 0 END) - 
                                        SUM(CASE WHEN statement_status = 'รายจ่าย' THEN statement_amount ELSE 0 END) AS balance
                                        FROM
                                        statement
                                        WHERE acc_id = $acc_id AND
                                        DATE_FORMAT(statement_date, '%d/%m/%Y')
                                        GROUP BY
                                        DATE_FORMAT(statement_date, '%d/%m/%Y')
                                        ORDER BY
                                        DATE_FORMAT(statement_date,'%d/%m/%Y')
                                    ";

                                // SQL Query to retrieve data
                                $sqltab2 = "SELECT *,
                                    DATE_FORMAT(statement_date, '%d/%m/%Y') AS statement_date,
                                    statement_status = 'รายรับ' AS revenue,
                                    statement_status = 'รายจ่าย' AS expense,
                                    SUM(CASE WHEN statement_status = 'รายรับ' THEN statement_amount ELSE 0 END) AS
                                    total_revenue,
                                    SUM(CASE WHEN statement_status = 'รายจ่าย' THEN statement_amount ELSE 0 END) AS
                                    total_expense,
                                    (SUM(CASE WHEN statement_status = 'รายรับ' THEN statement_amount ELSE 0 END) -
                                    SUM(CASE WHEN statement_status = 'รายจ่าย' THEN statement_amount ELSE 0 END)) AS balance
                                    FROM statement
                                    WHERE acc_id = $acc_id AND
                                    DATE_FORMAT(statement_date, '%d/%m/%Y')
                                    GROUP BY DATE_FORMAT(statement_date,'%d/%m/%Y')
                                    ORDER BY DATE_FORMAT(statement_date, '%d/%m/%Y')";

                            }
                            $resultchart = mysqli_query($conn, $query_chart);
                            //for chart
                            $statement_date = array();
                            $total_expense = array();
                            $total_revenue = array();
                            $balance = array();
                            while ($ms = mysqli_fetch_array($resultchart)) {
                                $statement_date[] = "\"" . $ms['statement_date'] . "\"";
                                $total_revenue[] = "\"" . $ms['total_revenue'] . "\"";
                                $total_expense[] = "\"" . $ms['total_expense'] . "\"";
                                $balance[] = "\"" . $ms['balance'] . "\"";
                            }

                            $statement_date = implode(",", $statement_date);
                            $total_expense = implode(",", $total_expense);
                            $total_revenue = implode(",", $total_revenue);
                            $balance = implode(",", $balance);
                            ?>
                            <div class="col-12 col-md-12">
                                <script type="text/javascript"
                                    src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js"></script>
                                <br>
                                <canvas id="Chartformonth"></canvas>
                                <script>
                                    var ctm = document.getElementById("Chartformonth").getContext('2d');
                                    var Chartformonth = new Chart(ctm, {
                                        type: 'line',
                                        data: {
                                            labels: [<?php echo $statement_date; ?>],
                                            datasets: [{
                                                label: 'ตอบแทน',
                                                data: [<?php echo $balance; ?>],
                                                borderColor: '#42B9B7',
                                                borderWidth: 4,
                                                fill: false
                                            }, {
                                                label: 'จ่าย',
                                                data: [<?php echo $total_expense; ?>],
                                                borderColor: '#FF587A',
                                                borderWidth: 4,
                                                fill: false
                                            }, {
                                                label: 'รับ',
                                                data: [<?php echo $total_revenue; ?>],
                                                borderColor: '#FFC64C',
                                                borderWidth: 4,
                                                fill: false
                                            }]
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            },
                                            plugins: {
                                                legend: {
                                                    display: true,
                                                    position: 'left'
                                                }
                                            },
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            animation: {
                                                onComplete: function () {
                                                    if (myChart.width > 577) {
                                                        myChart.options.maxBarThickness = 150;
                                                        myChart.options.barThickness = 150;
                                                    } else {
                                                        myChart.options.maxBarThickness = 50;
                                                        myChart.options.barThickness = 50;
                                                        myChart.options.plugins.legend.labels.maxWidth = 20;
                                                    }
                                                    myChart.update();
                                                }
                                            }
                                        }
                                    });
                                </script>
                            </div>

                            <div class="col-12 mt-5">
                                <h3 class="text-center">รายละเอียดผลตอบแทนรายวัน</h3><br>
                                <?php
                                $result = mysqli_query($conn, $sqltab2);
                                ?>
                                <div class="bg">
                                    <table class="table " id="table" data-filter-control="true" data-toggle="table"
                                        data-pagination="true" data-locale="th-TH" data-flat="true" data-icons="icons"
                                        data-toggle="table" data-maintain-meta-data="true">
                                        <thead>
                                            <tr style='text-align:center;'>
                                                <th data-field="statement_date">
                                                    <?php echo date('d-m-Y', strtotime('statement_date')); ?>
                                                </th>
                                                <th data-field="expense" data-searchable="false">รายละเอียดรายจ่าย</th>
                                                <th data-field="revenue" data-searchable="false">รายละเอียดรายรับ</th>
                                                <th data-field="total_revenue" data-searchable="false">รายรับทั้งหมด
                                                    (บาท)
                                                </th>
                                                <th data-field="total_expense" data-searchable="false">รายจ่ายทั้งหมด
                                                    (บาท)
                                                </th>
                                                <th class="table-success" data-field="balance" data-searchable="false">
                                                    ผลตอบแทน (บาท)</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-group text-center">
                                            <?php
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $row['statement_date']; ?>
                                                    </td>
                                                    <!-- <td><?php echo $row['statement_amount']; ?></td> -->
                                                    <td style='text-align:left;'>
                                                        <?php
                                                        $date = $row['statement_date'];
                                                        $sql_details = "SELECT * FROM statement WHERE 
                                                acc_id = $acc_id AND
                                                DATE_FORMAT(statement_date, '%d/%m/%Y'
												) = '$date' 
                                                AND statement_status = 'รายจ่าย'";
                                                        $result_details = mysqli_query($conn, $sql_details);
                                                        while ($row_details = mysqli_fetch_assoc($result_details)) {
                                                            echo "- " . $row_details['statement_detail'] . ' ' . $row_details['statement_amount'], " บาท", '<br>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td style='text-align:left;'>
                                                        <?php
                                                        $date = $row['statement_date'];
                                                        $sql_details = "SELECT *,statement_status = 'รายรับ' AS income,statement_status = 'รายจ่าย' AS exp FROM statement 
                                                WHERE 
                                                acc_id = $acc_id AND
                                                DATE_FORMAT(statement_date, '%d/%m/%Y') = '$date' 
                                                AND statement_status = 'รายรับ'";
                                                        $result_details = mysqli_query($conn, $sql_details);
                                                        while ($row_details = mysqli_fetch_assoc($result_details)) {
                                                            echo "- " . $row_details['statement_detail'] . ' ' . $row_details['statement_amount'], " บาท", '<br>';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['total_revenue']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['total_expense']; ?>
                                                    </td>
                                                    <td class="table-success">
                                                        <?php echo $row['balance']; ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                </div>
                <!-- เนื้อหา -->
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector("#menu a[href='index_profit.php']").classList.add("active");
        });
    </script>
</body>

</html>