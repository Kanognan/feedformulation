<?php 
// session_start();
include('../server.php');
// include("../session/expert_session.php");
// $acc_id = $_SESSION['acc_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include("../header.php"); ?>
    <style>
        .modal{
            background-color:white;
        }
        label{
            text-align:left;
        }
    </style>
</head>

<body>
    <div class="modal fade" id="del<?php echo $row['news_id']; ?>" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><b>ยืนยันการลบข่าวสาร</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <?php
                        $del = mysqli_query($conn, "select * from news where news_id='" . $row['news_id'] . "'");
                        $drow = mysqli_fetch_array($del);
                        ?>
                    <div class="container-fluid text-center">
                        คุณต้องการยกเลิก : <strong><?php echo $drow['news_topic']; ?></strong> ใช่หรือไม่
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span
                            class="glyphicon glyphicon-remove"></span> Cancel</button>
                    <a href="delete.php?news_id=<?php echo $row['news_id']; ?>" class="btn btn-danger"><span
                            class="glyphicon glyphicon-trash"></span> Delete</a>
                </div>
            </div>
        </div>
    </div>


    <!-- แก้ไข -->
    <div class="modal fade" id="edit<?php echo $row['news_id']; ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>แก้ไขข้อมูลข่าวสาร</b></h5>
                </div>
                <div class="modal-body">
                    <?php
        $edit = mysqli_query($conn, "select * from news where news_id='" . $row['news_id'] . "'");
        $erow = mysqli_fetch_array($edit);
        ?>
                    <form action="update.php?news_id=<?php echo $erow['news_id']; ?>" method="post">
                        <div class="mb-3" >
                            <label class="form-label">หมวดหมู่</label>
                            <select class="form-select" aria-label="Default select example" name="news_category"  value="<?php echo $erow['news_category']; ?>" >
                                <option value="การเลี้ยงโค">การเลี้ยงโค</option>
                                <option value="การเก็บนม">การเก็บนม</option>
                                <option value="การผสมพันธุ์">การผสมพันธุ์</option>
                                <option value="การแปรรูปผลผลิต">การแปรรูปผลผลิต</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">หัวข้อเรื่อง</label>
                            <input type="text" class="form-control" name="news_topic"
                                value="<?php echo $erow['news_topic']; ?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">รายละเอียด</label>
                            <input class="form-control" name="news_detail"
                                value="<?php echo $erow['news_detail']; ?>"></input>
                        </div>
                        <!-- <div class="mb-3">
                        <label class="form-label">รูปภาพ</label>
                        <input type="file" class="formFile" name="Product_Qty"
                            value="<?php echo $erow['news_img_']; ?>" />
                    </div> -->
                        <div class="mb-3">
                            <label class="form-label">รูปภาพ</label><br>
                            <input type="file" class="formFile" name="news_img"
                                value="<?php echo $erow['news_img']; ?>" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><span
                                    class="glyphicon glyphicon-remove"></span> Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


</body>
</html>