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
    <title>ประวัติการคำนวณโภชนะโค</title>
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
            padding-left: 16em !important;
            width: 100%;

        }


        .top {
            margin-top: 7em;
            height: cover;

        }

        .title-detail {
            text-align: center;
            margin-bottom: 1.5em;
        }

        .main {
            margin-top: 3rem;
            padding: 0.5rem;
            width: 100%;

        }

        .table {
            box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px !important;
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


        .addcal .btn:hover,
        .addcal .btn:focus:hover {
            background-color: #92CA68;
            color: black;
        }

        .addmore .btn:hover,
        .addmore .btn:focus:hover {
            background-color: #DBEDF2;
            color: black;
        }




        .content-edible {
            height: 15em;
            padding: 1.5em;

        }

        .pspan {
            color: gray;
        }

        .btn-more {
            margin: 1em 0em 1em 0em;
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

        #menu a.active {
            color: black !important;
            background-color: #bbd1e5;
        }

        .breed {
            color: white;
            width: 100%;
            padding: 1em;
            border-radius: 20px !important;
            font-size: 1em;
            margin: 1.5em 0.2em 0em 1.6em;
            border: 1px solid lightgray;

        }

        @media (max-width: 576px) {
            .content {
                padding-left: 5.5em !important;
            }
			.g-2{
                width:93%;
            }
            .no-data-message {
                text-align: left !important;
                padding: 2em !important;
                
            }
        }
        
        @media (min-width: 786px) {
        .content {
            padding-left: 16em !important;
            padding-right: 2.5em !important;
        }
      
        .g-2 {
            width: 95% !important;
        }
        .no-data-message {
                
                padding: 2em !important;
                
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
            <?php include('sidebar.php') ?>
        </div>
        <div class="g-2">
            <div class="content">
                <!-- เนื้อหา -->
                <h2 class="text-center">ประวัติการคำนวณโภชนะโค</h2>

                <!-- ดึงข้อมูลจากดาต้าเบส -->
                <?php
                $num = 0;
                $sql = "SELECT *
                            FROM cow_demand
                            WHERE cow_demand.acc_id = $acc_id
                            ORDER BY createAt DESC";
                $result = $conn->query($sql);
                ?>
                <!-- ---------------------------------------------------------------------------------------------------------- -->

                <table class="table " id="table" data-filter-control="true" data-pagination="true"
                    data-pagination-loop="false" data-locale="th-TH" data-flat="true" data-icons="icons"
                    data-toggle="table" data-search="true" data-search-highlight="true" data-maintain-meta-data="true">
                    <thead>

                        <tr style="text-align:center; background-color:#9cbbd8;">
                            <th scope="col">BW</th>
                            <th scope="col">THI</th>
                            <th scope="col">Milk</th>
                            <th scope="col">Fat</th>
                            <th scope="col">Protein</th>
                            <th scope="col">ADG</th>
                            <th scope="col">BW C</th>
                            <th scope="col">Intake</th>
                            <th scope="col">NEL</th>
                            <th scope="col">ME</th>
                            <th scope="col">DE</th>
                            <th scope="col">TDN</th>
                            <th scope="col">MP</th>
                            <th scope="col">RDP</th>
                            <th scope="col">RUP</th>
                            <th scope="col">CP</th>
                            <th scope="col">Ca</th>
                            <th scope="col">P</th>
                            <th scope="col">VitA</th>
                            <th scope="col">VitD</th>
                            <th scope="col">VitE</th>
                            <th data-searchable="false" rowspan="2">จัดการ</th>
                        </tr>
                        <tr style="text-align:center; background-color:#9cbbd8;">
                            <th colspan='1'>Kg</th>
                            <th colspan='4'>%</th>
                            <th colspan='3'>Kg/d</th>
                            <th colspan='3'>Mcal/Kg</th>
                            <th colspan='7'>%</th>
                            <th colspan='3'>IU/Kg</th>
                        </tr>

                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr style="background-color:#dff0ff;">
                                    <th colspan="18">ชื่อ :
                                        <?php echo $row["dem_name"], " "; ?>
                                    </th>
                                    <td colspan="4">สร้างเมื่อ :
                                        <?php
                                        echo date("d-m-Y H:i:s", strtotime($row["createAt"])); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:center">
                                        <?php echo $row["dem_thi"], " "; ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?php echo $row["dem_BW"]; ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?php echo $row["dem_milk"]; ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?php echo $row["dem_adg"]; ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?php echo $row["dem_fat"]; ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?php echo $row["dem_bdc"]; ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?php echo $row["dem_protein"]; ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?php echo $row["dem_intake"]; ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?php echo $row["dem_nel"]; ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?php echo $row["dem_me"]; ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?php echo $row["dem_de"]; ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?php echo $row["dem_tdn"]; ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?php echo $row["dem_mp"]; ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?php echo $row["dem_rdp"]; ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?php echo $row["dem_rup"]; ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?php echo $row["dem_cp"]; ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?php echo $row["dem_ca"]; ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?php echo $row["dem_p"]; ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?php echo number_format($row["dem_vitA"]); ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?php echo number_format($row["dem_vitD"]); ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?php echo number_format($row["dem_vitE"]); ?>
                                    </td>
                                    <td style="text-align:center">
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#demdel<?php echo $row['dem_id']; ?>">
                                            <span class="glyphicon glyphicon-trash"></span><img src="../pic/delete.png" alt=""
                                                style="width:12px; height:12px; " title="ลบข้อมูลโค"></button>
                                        <?php include('delete_demand.php'); ?>
                                    </td>
                                    </tr>
                                <?php
                                
                            } 
                        } else {
                            echo "<td colspan='22' class='no-data-message' style='text-align:center; margin-top:5em; color:gray;'>ยังไม่มีข้อมูลโภชนะ <a href='feed.php'> เพิ่มข้อมูลการคำนวณโภชนะ</a></td> ";
                            echo "<br><br>";
                        }
                        ?>
                    </tbody>
                    </table>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector("#menu a[href='feed.php']").classList.add("active");
        });
    </script>










</body>

</html>