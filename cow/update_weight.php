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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <title>แก้ไขน้ำหนักโค</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        font-family: 'kanit';
        /* color:black; */

    }

    .card-img-top img {
        height: 16rem !important;
        width: 100% !important;
        object-fit: cover;
    }

    img.card-img-top {
        border-radius: 20px !important;
        height: 13rem !important;
        width: 100% !important;
    }


    .card-text p {
        text-align: center;
        margin-top: 1.2em;
    }

    .col-3 #right {
        display: inline;
    }


    .cow {
        width: 100%;
        margin-top: 9em;
    }

    .cow-border {
        margin: 0.3em 0.8em 0.5em 0em;
        /* padding: 2em; */
        border-radius: 20px;
        height: 20em;

    }

    th,
    td {
        padding: 2em;
    }

    .cow-border img {
        align-items: center;
        border-radius: 50%;
        width: 4.5em;
        height: 4.5em;
    }

    .col-3 #right {
        display: inline;
    }

    .btn-more .btn-add {
        background-color: #77DC67;
        color: white;
        width: 8em;
        border-radius: 20px !important;
        margin: 2em 0.3em;
    }

    .btn-more .btn-add:hover {
        background-color: #6999C6 !important;
    }

    .btn-more .btn-cancel {
        background-color: #FE5E5E;
        color: white;
        width: 15em;
        border-radius: 20px !important;
        margin: 0em 0.3em;
    }

    .btn-more .btn-cancel:hover {
        background-color: #6999C6 !important;
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
        /* padding: 1.2em; */
        border-radius: 15px;
        height: 30em;

    }

    .detail-topic {
        font-size: 1.2em;
        font-weight: 500;
        margin-bottom: 1em;
        background-color: #6999C6;
        padding: 0.8em;
        border-radius: 15px;
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

    @media (max-width: 576px) {
        .content {
            padding-left: 4.5em !important;
            padding-right: 1em !important;
        }
        .g-2{
            width: 91%;
        }
		#box{
			padding:0.4em;
		}
        .no-data-message {
                text-align: left !important; 
                padding: 2em;
    }
        
    }
    @media (min-width: 768px) {
            .col-md-6{
                width:100% !important;
            }
            .g-2{
                width:92% !important;
            }
           
        }

    /*  */
    </style>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.3/dist/bootstrap-table.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.1/dist/bootstrap-table.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.2/dist/bootstrap-table-locale-all.min.js"></script>

<body>
    <div class="flex">
        <div class="g-1">
            <?php include('sidebar.php'); ?>
        </div>
        <div class="g-2">
            <div class="content">
                <div class="col-12 col-md-6 col-lg-12 mb-3" id="box">
                    <h3 class="title-detail">อัพเดตน้ำหนักของโค</h3>
                    <div class="cow-border">
                    <form action="w_db.php" method="post">
                        <table class="table" id="table" data-filter-control="true" data-toggle="table"
                            data-pagination="true" data-locale="th-TH" data-flat="true" data-icons="icons"
                            data-toggle="table" data-search="true" data-search-highlight="true">
                            <thead>
                                <tr class="table table-primary" style='text-align:center;'>
                                    <th>รูปภาพ</th>
                                    <th>หมายเลขประจำตัวโค</th>
                                    <th>ชื่อ</th>
                                    <th>เพศ</th>
                                    <th>น้ำหนัก (กิโลกรัม)</th>
                                    <th>วันที่อัพเดทล่าสุด</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                            $sql = "SELECT * FROM cow  WHERE acc_id = $acc_id AND deleteAt IS NULL order by createAt DESC";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                foreach ($result as $cow): ?>
                                <tr style='text-align:center;'>
                                    <td><img class="img-circle" src="../pic/<?php echo $cow["cow_img"]; ?>" /></td>
                                    <td>
                                        <input type="hidden" name="cow_id[]" value="<?php echo $cow['cow_id']; ?>">
                                        <label for="cow_weight<?php echo $cow['cow_id']; ?>">
                                            <?php echo $cow['cow_id']; ?></label>
                                    </td>
                                    <td><?php echo $cow["cow_name"], " "; ?></td>
                                    <td><?php echo $cow["cow_gender"], " ", " "; ?></td>
                                    <td><input  type="number" step="0.01" min="0" max="999" class="form-control"
                                            id="cow_weight<?php echo $cow['cow_id']; ?>" name="cow_weight[]"
                                            value="<?php echo $cow['cow_weight']; ?>"></td>
                                    <td>
                                        <?php
                                        if (is_null($cow['updateAt'])) {
                                            echo date("d-m-Y", strtotime($cow["createAt"]));
                                        } else {
                                            echo date("d-m-Y", strtotime($cow["updateAt"]));
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php endforeach;
                                } else if ($result->num_rows === 0) {
                                    echo "<tr><td colspan='6' class='no-data-message' style='text-align:center;   color:gray; padding:2em'> คุณยังไม่มีข้อมูลโค ? <span><a style='text-decoration: underline; color:#6999C6' href='../cow/addcow.php'> เพิ่มข้อมูลโค</a></span></td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                         <div class="d-flex justify-content-center btn-more">
                        <div class="form-group">
                                <button type="submit" class="btn btn-add confirm" name="updatecow">บันทึกข้อมูล</button>
                            </div>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    
    <?php

    if (isset($_SESSION['editData'])) {
        $editData = $_SESSION['editData'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'แก้ไขข้อมูลสำเร็จ',
                        text: '" . $editData . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
        unset($_SESSION['editData']);
    }
    ?>

</body>
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector("#menu a[href='update_weight.php']").classList.add("active");
});
</script>

</html>