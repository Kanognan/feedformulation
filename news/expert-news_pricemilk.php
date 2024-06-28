<?php
session_start();
if (!isset($_SESSION['user_status']) || ($_SESSION['user_status'] != 'Admin' && $_SESSION['user_status'] != 'Expert')) {
    $resultNoSessionExpert = "สำหรับผู้ดูแลระบบและผู้เชี่ยวชาญเท่านั้น";
    $_SESSION['resultNoSessionExpert'] = $resultNoSessionExpert;
    echo "<script type='text/javascript'>";
    echo "window.location = '../login.php'; ";
    echo "</script>";
    exit();
    // ผู้เชี่ยวชาญ
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
    <title>ข่าวสารราคานมโค</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Kanit', sans-serif;
        }

        body {
            padding-top: 7em;
        }
        .content-news {
        border: 2px solid #f5f5f5;
        margin: 2rem auto;
        padding: 1.2em;
        width: 95%;
        box-shadow: 5px 6px 6px 2px lightgray;
        
    }

    .contenLink:hover {
        cursor: pointer;
    }

    .addnews {
        margin: 2em 0em 2em 2em;

    }

    .button-add {
        padding: 0.8em;
        border-radius: 2em;
        width: 10em;
        background-color: #77DC67;
        border: none;
        color: #fff;
        margin-right: 2em;

    }
        .imghead {
            height: 20rem;
            position: relative;
            overflow: hidden;
           
        }

        .imghead img {
            height: 20rem;
            width: 100%;
            object-fit: cover;
            filter: blur(2px);
        }

        .imghead h1 {
            position: absolute;
            color: white;
            top: 40%;
            text-align: center;
            font-weight: bold;
            width: 100%;
            text-shadow: -1px 1px 6px rgba(0, 0, 0, 0.79);
        }
        .left{
            padding-top: 4em ;
            width: 100%;
           padding-left: 10em;
           padding-bottom: -10em;
           
        }
    </style>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.3/dist/bootstrap-table.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.1/dist/bootstrap-table.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.2/dist/bootstrap-table-locale-all.min.js"></script>
<body>
<?php include "nav-bar.php"
        ?>
        <div class="imghead">
        <img src="../Images/news-head.jpg" alt="room" class="img">
        <h1>
            ข่าวสาร
        </h1>
    </div><br><br>
    <div class="container">
        <?php include("category.php") ?>
        <div class="d-flex justify-content-between align-items-center addnews">
            <h3 class="ml-5">ราคานมโค</h3>
            <button class="button-add" type="button" onclick="javascript:window.location.href='formnews.php'">+
                เพิ่มข่าวสาร</button>
        </div>
        <!----------------------------------------------------------------->
        <?php
        $num = 0;
        $ID4 = "SELECT * FROM news  WHERE category_news_id= '4'";
        $resultID4 = $conn->query($ID4);
       
        ?>
        
        <!----------------------------------------------------------------->
        <div class="content-news">
            <table class="table" id="table" data-filter-control="true" data-toggle="table"
                        data-pagination="true" data-locale="th-TH" data-flat="true" data-icons="icons"
                        data-toggle="table" data-search="true" data-search-highlight="true">
                <thead>
                    <tr style="border-bottom:2px solid #6666">
                        <th class="text-center" scope="col">ลำดับ</th>
                        <th scope="col">หัวข้อข่าว</th>
                        <th class="text-center" scope="col">สร้างเมื่อ</th>
                        <!-- <th scope="col">หมวดหมู่</th> -->
                        <th class="text-center" scope="col">จัดการ</th>
                    </tr>
                </thead>
        
                <?php
                if ($resultID4 && $resultID4->num_rows > 0) {
                    foreach ($resultID4 as $result) {
                        $news_id = $result['news_id'];
                        $num++;
                        ?>
        
                        <tbody>
        
                            <tr>
                                <th class="text-center" scope="row">
                                    <?php echo $num; ?>
                                </th>
                                <td>
                                    <?php echo $result['news_topic'] ?>
                                </td>
                                <td class="text-center">
                            <?php  echo date("d-m-Y H:i:s", strtotime($result["createAt"]));  ?>
                        </td>
                                <td class="text-center">
                            <div onclick="window.location='edit_news.php?news_id=<?php echo $news_id; ?>'"
                                data-toggle="modal" class="btn btn-warning"><span
                                    class="glyphicon glyphicon-edit"></span><img src="../pic/edit.png" alt=""
                                    style="width:15px; height:15px; margin:5px" title="แก้ไขข้อมูลโค">
                            </div>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#del<?php echo $row['news_id']; ?>">
                                <span class="glyphicon glyphicon-trash"></span><img src="../pic/delete.png" alt=""
                                    style="width:15px; height:15px; margin-right:5px">
                            </button>

                            <div class="modal fade" id="del<?php echo $row['news_id']; ?>" tabindex="-1" role="dialog"
                                aria-labelledby="del" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="del<?php echo $row['news_id']; ?>">
                                                <b>ยืนยันการลบข่าวสาร</b>
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                                            $del = mysqli_query($conn, "select * from news where news_id='" . $row['news_id'] . "'");
                                                            $drow = mysqli_fetch_array($del);
                                                            ?>
                                            <div class="container-fluid text-center">
                                                คุณต้องการยกเลิก : <strong><?php echo $drow['news_topic']; ?></strong>
                                                ใช่หรือไม่
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">ปิด</button>
                                            <a href="delete.php?news_id=<?php echo $news_id; ?>"
                                                class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span>
                                                ลบ</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                            </tr>
        
                       
                        
                    <?php
                }
            } else {
                echo "<td class='mt-5'>ไม่มีข้อมูล</td>";
            }
            ?>
             </tbody>
            </table>
          
        </div>
       
    </div>
    </div>
	 <?php include("../footer.php"); ?>

</body>

</html>