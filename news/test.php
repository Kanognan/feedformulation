<?php
// เชื่อมต่อฐานข้อมูล และตรวจสอบการเชื่อมต่อ
// เชื่อมต่อไปยังฐานข้อมูล
include("../server.php");
include('../header.php');



// สร้างคำสั่ง SQL เพื่อดึงข้อมูลข่าวและรูปภาพที่เกี่ยวข้อง
$sql = "SELECT news.*, news_img.news_img
        FROM news
        LEFT JOIN news_img ON news.news_id = news_img.news_id"; // แทนที่ 1 ด้วยรหัสข่าวที่ต้องการแสดง

$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $news_id = $row['news_id'];
    $sql_images = "SELECT * FROM news_img WHERE news_id = $news_id";
    $result_images = mysqli_query($conn, $sql_images);
?>

<!-- เริ่มต้นแสดงรูปภาพ -->
<div id="carouselExampleControls<?php echo $news_id; ?>" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
        $is_first = true;
        while ($image_row = mysqli_fetch_assoc($result_images)) {
            ?>
            <div class="carousel-item <?php echo $is_first ? 'active' : ''; ?>">
                <img src="../pic/<?php echo $image_row['news_img']; ?>" class="d-block w-100" alt="News Image">
            </div>
            <?php
            $is_first = false;
        }
        ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls<?php echo $news_id; ?>" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls<?php echo $news_id; ?>" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<!-- จบการแสดงรูปภาพ -->

<?php
} else {
    echo "ไม่พบข้อมูลข่าวหรือรูปภาพที่เกี่ยวข้อง";
}
?>

