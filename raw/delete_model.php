<?php
// session_start();
include('../server.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php //include("header.php");     ?>

</head>

<body>
    <div class="modal fade" id="ModalDeleteRaw1<?php echo $rowtab1['raw_id']; ?>" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Label"><b>ยืนยันการลบคุณค่าทางโภชนะของวัตถุดิบ</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid text-center">
                        คุณต้องการลบ
                        <strong>
                            <?php echo $rowtab1['raw_thainame']; ?>
                        </strong> ใช่หรือไม่
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <a href="delete_raw_material.php?raw_id=<?php echo $rowtab1['raw_id']; ?>"
                        class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> ยืนยัน</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ModalDeleteRaw2<?php echo $rowtab2['raw_id']; ?>" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Label"><b>ยืนยันการลบคุณค่าทางโภชนะของวัตถุดิบ</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid text-center">
                        คุณต้องการลบ
                        <strong>
                            <?php echo $rowtab2['raw_thainame']; ?>
                        </strong> ใช่หรือไม่
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <a href="delete_raw_material.php?raw_id=<?php echo $rowtab2['raw_id']; ?>"
                        class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> ยืนยัน</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ModalDeleteRaw3<?php echo $rowtab3['raw_id']; ?>" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Label"><b>ยืนยันการลบคุณค่าทางโภชนะของวัตถุดิบ</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid text-center">
                        คุณต้องการลบ
                        <strong>
                            <?php echo $rowtab3['raw_thainame']; ?>
                        </strong> ใช่หรือไม่
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <a href="delete_raw_material.php?raw_id=<?php echo $rowtab3['raw_id']; ?>"
                        class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> ยืนยัน</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ModalDeleteMs<?php echo $rowtab4['ms_id']; ?>" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Label"><b>ยืนยันการลบคุณค่าทางโภชนะของวัตถุดิบ</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid text-center">
                        คุณต้องการลบ
                        <strong>
                            <?php echo $rowtab4['ms_thainame']; ?>
                        </strong> ใช่หรือไม่
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <a href="delete_ms.php?ms_id=<?php echo $rowtab4['ms_id']; ?>"
                        class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> ยืนยัน</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>