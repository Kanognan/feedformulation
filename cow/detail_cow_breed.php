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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <?php include "../header.php"; ?>
    <title>ข้อมูลทั่วไปของโค</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'kanit';

        }

        .add .btn {
            background-color: #4F80C0;
            color: white;
            width: 8.8em;
            padding: 0.5em;
            border-radius: 20px;
            font-size: 1em;
            margin: 0.5em 0.2em 0.5em 0.2em;

        }

        .add .btn:hover,
        .add .btn:focus,
        button[type=submit]:hover {
            background-color: #AACCE2;
            color: black;
        }

        .cow {
            width: 100%;
            margin-top: 9em;
        }


        .cowpic {
            margin: 0 auto;
            border-radius: 15px !important;
            width: 16em;
            height: 16em;
            overflow: hidden;

        }

        .cowpic img {
            align-items: center;
            width: 100%;
            height: 100%;
            padding: 1em;
            /* display: block; */
            /* margin: 0 auto; */
            border-radius: 30px;
        }

        .ms1 {
            text-indent: 0.5em;

        }

        #box {
            border-radius: 8px;
            padding: 1.2em;
            cursor: pointer;

        }

        .title-detail {
            text-align: center;
            margin-bottom: 1.5em;
        }

        .detail {
            margin-top: 1.2em;
            background-color: #c6d9eb !important;
            padding: 0.8em;
            border-radius: 5px;
            height: cover;

        }

        .detail-topic {
            font-size: 1.2em;
            font-weight: 500;
            margin-bottom: 1em;
            background-color: #6999C6;
            padding: 0.8em;
            border-radius: 5px;
            color: white;
        }

        .col-12-topic {
            padding: 0.3em;
        }

        .col-12-topic input {
            font-size: 16px;
            padding: 0.3em;
            width: 100%;


        }

        #menu a.active {
            color: black !important;
            background-color: #bbd1e5;
        }

        .rg {
            padding: 1em 1.3em;

        }

        .other {
            border-radius: 5px;
            background-color: #fffff0;
            width: 100%;
            margin: 0em auto;
            padding: .6em;
            min-height: 3em;

        }

        .topic-other {
            background-color: #9fd4a3;
            border-radius: 5px;
            padding: 0.4em;
            margin-bottom: 0.5em;
            font-size: 1.2em;
            font-weight: 500;
            color: white;

        }

        .flex {
            display: flex;
        }

        .g-2 {
            flex: 1;
        }

        .content {
            padding: 3em;
            padding-left: 16em !important;
            width: 100%;
            /* margin:0 auto; */
        }

        .mychart {
            margin: 0 auto;
            width: 60%;
        }



        @media (max-width: 576px) {
            .content {
                padding-left: 4.5em !important;
                padding-right: 1.5em !important;

            }

            .g-2 {
                width: 95%;
            }

            .cowpic {
                display: none;
            }

            .ms1 {
                margin-top: 20px;
            }

            .ms1 .detail {
                padding: 15px;
            }

            .ms1 .row {
                display: flex;
                flex-wrap: wrap;
            }

            .ms1 .col-4,
            .ms1 .col-5 {
                width: 100%;
            }

            .ms1 .col-4 .ms1,
            .ms1 .col-5 {
                display: flex;
                flex-direction: column;
            }

            .ms1 .col-4 .ms1 p,
            .ms1 .col-5 p {
                margin-bottom: 10px;
            }

            .ms1 .detail-topic {
                font-size: 18px;
                font-weight: bold;
                margin-bottom: 10px;
            }

            .ms1 .other {
                margin-bottom: 10px;

            }

            .ms1 .text-other {
                font-size: 14px;
            }

            .ms1 p {
                font-size: 14px;
            }

            .ms1 .row.rg {
                flex-direction: column;
                padding: 2.5px;
            }

            .ms1 .col-6 {
                width: 100%;
                flex: 0 0 auto;
                max-width: 100%;
            }

            .ms1 .topic-other {
                font-size: 14px;
            }

        }
    </style>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.3/dist/bootstrap-table.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.1/dist/bootstrap-table.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.2/dist/bootstrap-table-locale-all.min.js"></script>

<body>
    <? $acc_id = $_SESSION['acc_id']; ?>
    <div class="flex">
        <div class="g-1">
            <?php include ('sidebar.php') ?>
        </div>
        <div class="g-2">
            <!-- -------------------------------------------------------- -->
            <div class="content">
                <h3 class="text-center">ข้อมูลการผสมพันธุ์</h3>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <?php
                            $cow_id = mysqli_real_escape_string($conn, $_GET['id']);
                            $sqltab2 = "SELECT breed_status, COUNT(*) AS status_count
                                            FROM cow_breed
                                            INNER JOIN cow ON cow_breed.cow_id = cow.cow_id
                                            WHERE cow.acc_id = $acc_id AND cow.cow_id = '$cow_id'
                                            AND breed_status IN ('แท้ง', 'ผสมไม่ติด', 'คลอดปกติ', 'ตั้งท้อง')
                                            GROUP BY breed_status";
                            $resultchart = mysqli_query($conn, $sqltab2);
                            $status_counts = array('แท้ง' => 0, 'ผสมไม่ติด' => 0, 'คลอดปกติ' => 0, 'คลอดก่อนกำหนด' => 0);
                            while ($row = mysqli_fetch_assoc($resultchart)) {
                                $status_counts[$row['breed_status']] = $row['status_count'];
                            }
                            ?>

                            <div class="myChart">
                                <div>
                                    <canvas id="myChart" width="678" height="300"
                                        style="display: block; box-sizing: border-box; height: 400px; width: 339px;"></canvas>
                                </div>
                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                <script>
                                    const ctx = document.getElementById('myChart');
                                    const myChart = new Chart(ctx, {
                                        type: 'bar',
                                        data: {
                                            labels: ['แท้ง', 'ผสมไม่ติด', 'คลอดปกติ', 'คลอดก่อนกำหนด'],
                                            datasets: [{
                                                label: 'จำนวนครั้ง',
                                                data: [<?= $status_counts['แท้ง'] ?>,
                                                    <?= $status_counts['ผสมไม่ติด'] ?>,
                                                    <?= $status_counts['คลอดปกติ'] ?>,
                                                    <?= $status_counts['คลอดก่อนกำหนด'] ?>
                                                ],
                                                backgroundColor: ['rgba(255, 99, 132, 0.5)',
                                                    'rgba(255, 206, 86, 0.5)',
                                                    'rgba(54, 162, 235, 0.5)', 'rgba(75, 192, 192, 0.5)'
                                                ],
                                                borderColor: ['rgba(255, 99, 132, 1)',
                                                    'rgba(255, 206, 86, 1)', 'rgba(54, 162, 235, 1)',
                                                    'rgba(75, 192, 192, 1)'
                                                ],
                                                borderWidth: 1
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
                                                    display: false
                                                }
                                            },
                                            layout: {
                                                padding: {
                                                    left: 2,
                                                    right: 10,
                                                    top: 10,
                                                    bottom: 10
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
                                                    }
                                                    myChart.update();
                                                }
                                            }
                                        }
                                    });


                                </script>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector("#menu a[href='cow.php']").classList.add("active");
    });
</script>

</html>