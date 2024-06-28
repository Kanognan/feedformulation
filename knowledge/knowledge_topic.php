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
    <title>ความรู้เทคนิค</title>
	<link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Kanit';
        }

        body {
            padding-top: 6.5em;
        }

        .container-fluid {
            padding: 0px !important;
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

        .carousel {
            width: 100%;
            margin: 0 auto;
        }


        .carousel-inner .carousel-item img {
            object-fit: cover;
            width: 100%;
            height: 20rem;
            margin: 0 auto;
            border-radius: 5px;
        }

        .topic h2 {
            margin: 2em 0em;
            text-align: center;
            font-weight: bold;
        }

        .detail {
            padding: 0em 6em;
            font-size: 1.1em;
            text-indent: 4em;
        }
    </style>
</head>

<body>
    <?php include ("nav-bar.php"); ?>
    <?php
    $knowledge_id = isset ($_GET['id']) ? $_GET['id'] : null;

    if (!empty ($knowledge_id)) {
        $safe_knowledge_id = mysqli_real_escape_string($conn, $knowledge_id);
        $query = mysqli_query($conn, "SELECT * FROM knowledge WHERE knowledge_id = $safe_knowledge_id");
        $result = mysqli_fetch_assoc($query);
        if ($result) {
            $knowledge_topic = $result['knowledge_topic'];
            $knowledge_content = $result['knowledge_content'];
            $category_knowledge_id = $result['category_knowledge_id'];
            $createAt = $result['createAt'];
            $updateAt = $result['updateAt'];
            $acc_id = $_SESSION['acc_id'];

            $sql_account = "SELECT * FROM account WHERE acc_id = $acc_id";
            $result_account = mysqli_query($conn, $sql_account);
            $account_row = mysqli_fetch_assoc($result_account);
            $acc_name = $account_row['acc_name'];

            $sql_category = "SELECT * FROM category_knowledge WHERE category_knowledge_id = $category_knowledge_id";
            $result_category = mysqli_query($conn, $sql_category);
            $category_row = mysqli_fetch_assoc($result_category);
            $category_name = $category_row['category_knowledge_name'];
            ?>
            <div class="container-fluid">
                <div class="content">
                    <div class="content-img">
                        <div id="carouselExampleControls<?php echo $knowledge_id; ?>" class="carousel slide"
                            data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php
                                $sql_images = "SELECT * FROM knowledge_img WHERE knowledge_id = $knowledge_id AND deleteAt IS NULL";
                                $result_images = mysqli_query($conn, $sql_images);
                                $is_first = true;
                                while ($image_row = mysqli_fetch_assoc($result_images)) {
                                    ?>
                                    <div class="carousel-item <?php echo $is_first ? 'active' : ''; ?>">
                                        <img src="../pic/<?php echo $image_row['knowledge_img']; ?>" class="d-block w-100"
                                            alt="knowledge img">
                                    </div>
                                    <?php
                                    $is_first = false;
                                }
                                ?>
                            </div>
                            <button class="carousel-control-prev" type="button"
                                data-bs-target="#carouselExampleControls<?php echo $knowledge_id; ?>" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                data-bs-target="#carouselExampleControls<?php echo $knowledge_id; ?>" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="topic">
                        <h2>
                            <?php echo $knowledge_topic; ?>
                        </h2>
                    </div>
                    <div class="detail container">
                        <p>
                            <?php echo $knowledge_content; ?>
                        </p>
                        <div class="text-muted fs-6 pt-5">
                            <?php if ($updateAt) { ?>
                                <div>วันที่อัพเดตล่าสุด: <?php echo date('d-m-Y H:i:s', strtotime($updateAt)); ?></div>
                                <div>เพิ่มโดย: <?php echo $acc_name; ?></div>
                            <?php } else { ?>0
                                <div>วันที่สร้าง: <?php date('d-m-Y H:i:s', strtotime($createAt)); ?></div>
                                <div>เพิ่มโดย: <?php echo $acc_name; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5 mb-5 btn-readall">
                <a href="knowledge.php" class="btn btn-outline-secondary">ทั้งหมด</a>
                <?php
                if ($_SESSION['user_status'] == 'Admin' || $_SESSION['user_status'] == 'Expert') { ?>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit"><i
                            class="bi bi-pencil-square"></i> แก้ไข</button>
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()"><i class="bi bi-trash-fill"></i>
                        ลบ</button>
                <?php } ?>
            </div>

            <div class="modal fade modal-lg" id="edit" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editLabel">แก้ไขความรู้ / เทคนิค</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="edit_knowledge_db.php" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="category_knowledge">หมวดหมู่</label>
                                        <select name="category_knowledge" id="category_knowledge" class="form-control" required>
                                            <option disabled selected>เลือกหมวดหมู่</option>
                                            <?php
                                            $sql_categories = "SELECT * FROM category_knowledge";
                                            $result_categories = mysqli_query($conn, $sql_categories);

                                            while ($category = mysqli_fetch_assoc($result_categories)) {
                                                $category_id = $category['category_knowledge_id'];
                                                $category_name = $category['category_knowledge_name'];
                                                ?>
                                                <option value="<?php echo $category_id; ?>" <?php if ($category_id == $category_knowledge_id)
                                                       echo 'selected'; ?>>
                                                    <?php echo $category_name; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="topic" class="form-label">หัวข้อความรู้/เทคนิค</label>
                                    <input type="text" class="form-control" id="topic" name="knowledge_topic"
                                        value="<?php echo $knowledge_topic; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="form-label">เนื้อหาความรู้/เทคนิค</label>
                                    <textarea name="knowledge_content" class="form-control" rows="5" cols="100"
                                        required><?php echo $knowledge_content; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="img" class="form-label">เลือกรูปภาพใหม่</label>
                                    <input type="file" class="form-control" id="img" name="knowledge_img[]" multiple>
                                </div>
                                <input type="hidden" name="knowledge_id" value="<?php echo $knowledge_id; ?>">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                <button type="submit" name="editknowledge" class="btn btn-primary">บันทึกข้อมูล</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        } else {
            echo "<p class='text-center'>ไม่พบข้อมูลข่าว</p>";
        }
    } else {
        echo "<p class='text-center'>ไม่พบรหัสข่าว</p>";
    }
    ?>
    <?php include ("../footer.php"); ?>
    <?php
    if (isset ($_SESSION['resultEditKnow'])) {
        $resultEditKnow = $_SESSION['resultEditKnow'];
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'แก้ไขข้อมูลสำเร็จ',
                        text: '" . $resultEditKnow . "',
                        confirmButtonText: 'OK',
                        showConfirmButton: false,
                        timer: 2000 
                    });
                });
            </script>";
        unset($_SESSION['resultEditKnow']);
    }
    ?>
    <script>
        function confirmDelete() {
            Swal.fire({
                title: 'ยืนยันการลบ',
                text: "คุณต้องการลบข้อมูลนี้ใช่หรือไม่? หากลบจะไม่สามารถกู้คืนได้",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = 'delete_knowledge.php?id=<?php echo $knowledge_id; ?>';
                    Swal.fire(
                        'Deleted!',
                        'ข้อมูลถูกลบเรียบร้อยแล้ว.',
                        'success'
                    )
                }
            })
        }
    </script>
</body>

</html>