<div class="modal" id="demdel<?php echo $row['dem_id']; ?>" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="Label"><b>ยืนยันการลบข้อมูลโค</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    $dem = mysqli_query($conn, "select * from cow_demand where dem_id='" . $row['dem_id'] . "'");
                    $ddem = mysqli_fetch_array($dem);
                    ?>
                    <div class="container-fluid text-center">
                        คุณต้องการลบรายการ : <strong>
                            <?php echo $ddem['dem_name']; ?>
                        </strong> ใช่หรือไม่
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span
                            class="glyphicon glyphicon-remove"></span> Cancel</button>
                    <a href="del_dm.php?dem_id=<?php echo $row['dem_id']; ?>" class="btn btn-danger"><span
                            class="glyphicon glyphicon-trash"></span> Delete</a>
                </div>
            </div>
        </div>
    </div>