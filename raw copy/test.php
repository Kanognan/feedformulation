<?php
require_once('../server.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php //include("../header.php"); ?>
    <title>Document</title>
    <script src="dselect.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: white !important;
            font-family: 'Kanit', sans-serif;
            padding-top: 7em;
        }

        .con {
            padding: 0rem !important;
        }

        .no-p {
            padding: 0rem !important;
        }

        .bg {
            background-color: #6999c6;
        }

        .sidenav {
            padding: 1em !important;
        }

        /* .paddingSide{
            padding: 0em 1em;
        } */
        .nav a:link {
            color: white;
        }

        .nav a:hover {
            color: white;
            border-bottom: 2px solid transparent;
            border-image: linear-gradient(90deg, rgba(255, 255, 255, 1) 0%, rgba(254, 254, 254, 1) 0%, rgba(253, 253, 253, 0.9473039215686274) 11%, rgba(250, 250, 250, 0) 100%);
            border-image-slice: 1;
            border-radius: 0 !important;
        }

        .nav a:active {
            color: white;

        }

        .nav a:visited {
            color: white;
            /* border-bottom: 1px solid white; */
        }

        .ulpadding {
            padding: 2em !important;
        }

        .content-center {
            padding-top: 2em;
        }

        /* -------------------------------------------------------- */
        .cate-raw {
            width: 100%;
        }

        .col-5 {
            margin-top: 20px;
        }

        #submit {
            margin-top: 15px
        }

        .nav-2 {
            margin-left: 2rem;
        }

        .btn-more {
            margin: 1em 0em;
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

        .form-group {
            margin: 0em 0em 1.5em 0em;
        }

        .nav-tabs-css .nav-item.show .nav-link,
        .nav-tabs-css .nav-link.active {
            background-color: #9cc0e2 !important;
        }

        .t1-1 {
            background-color: #c6d9eb;
            padding: 2em;
            border-radius: 15px;
            margin-bottom: 1em;
        }

        .butimg button {
            border: none !important;
            border-radius: 10px;
            padding: 1em;
        }

        /* ----------------------------- */
        .dropdown-menu.show {
            width: 100%;
            padding: 0rem;

        }
    </style>
</head>

<body>
    <?php include("nav-bar.php") ?>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-0 bg position-fixed overflow-auto">
                <div class="ulpadding d-flex flex-column align-items-center align-items-sm-start text-white min-vh-100">
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                        id="menu">
                        <li class="paddingSide">
                            <a href="#submenu1" data-bs-toggle="collapse"
                                class="nav-link no-p px-0 align-middle sidenav" id="defaulOpen">
                                <i class="fa-solid fa-file-circle-plus"></i>
                                <span class="ms-1 d-none d-sm-inline">วัตถุดิบอาหารโคนม</span>
                                <i class="bi bi-chevron-down"></i>
                            </a>
                            <div class="collapse show" id="submenu1">
                                <ul class="nav flex-column ms-1">
                                    <li>
                                        <a href="#submenu3" data-bs-toggle="collapse" data-bs-target="#menu3"
                                            class="nav-link no-p px-0 align-middle sidenav">
                                            <span class="ms-1 d-none d-sm-inline">คุณค่าทางโภชนะของวัตถุดิบ</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#submenu4" data-bs-toggle="collapse" data-bs-target="#menu4"
                                            class="nav-link no-p px-0 align-middle sidenav">
                                            <span class="ms-1 d-none d-sm-inline">ปริมาณแร่ธาตุในวัตถุดิบ</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#submenu66" data-bs-toggle="collapse"
                                class="nav-link no-p px-0 align-middle sidenav">
                                <i class="fa-solid fa-file-circle-plus"></i>
                                <span class="ms-1 d-none d-sm-inline">ค่าแร่ธาตุของวัตถุดิบ</span>
                                <i class="bi bi-chevron-down"></i>
                            </a>
                            <div class="collapse" id="submenu66">
                                <ul class="nav flex-column ms-1">
                                    <li>
                                        <a href="#submenu33" data-bs-toggle="collapse" data-bs-target="#menu61"
                                            class="nav-link no-p px-0 align-middle sidenav">
                                            <span class="ms-1 d-none d-sm-inline">คุณค่าทางโภชนะของวัตถุดิบ</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#submenu44" data-bs-toggle="collapse" data-bs-target="#menu62"
                                            class="nav-link no-p px-0 align-middle sidenav">
                                            <span class="ms-1 d-none d-sm-inline">ปริมาณแร่ธาตุในวัตถุดิบ</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <hr>
                </div>
            </div>
            <div class="col-auto col-md-3 col-xl-2 px-0 bg"></div>
            <div class="col con">
                <div class="bg"></div>
                <div class="container">
                    <div class="content-center">
                        <!-- เนื้อหาที่เรียกโดยเมนู -->
                        <div id="menu1" class="menu1 menu-content collapse show">
                            <!-- เนื้อหาวัตถุดิบอาหารโคนม -->
                            <p>เนื้อหาวัตถุดิบอาหารโคนมทั้งหมด</p>
                            <?php 
                              $sqltab1 = "SELECT 
                              raw_material.raw_id, 
                              raw_material.raw_thainame,
                              raw_material.raw_engname,
                              type_raw_material.type_raw_thainame, 
                              GROUP_CONCAT(nutrition_detail.nutrition_detail_id) as nutrition_detail_ids
                          FROM 
                              raw_material
                          JOIN 
                              type_raw_material ON raw_material.type_raw_id = type_raw_material.type_raw_id
                          JOIN 
                              nutrition ON raw_material.raw_id = nutrition.raw_id
                          JOIN 
                              nutrition_detail ON nutrition.nutrition_detail_id = nutrition_detail.nutrition_detail_id
                          GROUP BY 
                              raw_material.raw_id, raw_material.raw_thainame, raw_material.raw_engname, type_raw_material.type_raw_thainame";

                            $resulttab1 = $conn->query($sqltab1);

                            if ($resulttab1 && $resulttab1->num_rows > 0) {
                                while ($rowtab1 = $resulttab1->fetch_assoc()) {
                                    $raw_id = $rowtab1['raw_id'];
                                    $raw_thainame = $rowtab1['raw_thainame'];
                                    $raw_engname = $rowtab1['raw_engname'];
                                    $type_raw_thainame = $rowtab1['type_raw_thainame'];
                                    $nutrition_detail_ids = $rowtab1['nutrition_detail_ids'];

                                    $nutrition_detail_array = explode(",", $nutrition_detail_ids);
                                    echo $raw_thainame;
                                    echo $raw_engname;
                                    foreach ($nutrition_detail_array as $nutrition_detail_id) {
                                        $sql = "SELECT * FROM nutrition_detail WHERE nutrition_detail_id = $nutrition_detail_id";
                                        $result = $conn->query($sql);
                                        
                                        if ($result && $result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                // ในที่นี้คุณสามารถใช้ $row เพื่อเข้าถึงข้อมูลจากตาราง nutrition_detail
                                                echo "ID: " . $row['nutrition_detail_id'] . "<br>";
                                                echo "dnut_dm: " . $row['dnut_dm'] . "<br>";
                                                // ... และอื่นๆ
                                            }
                                        }
                                    }
                                }
                            } else {
                                echo "ไม่พบข้อมูล";
                            }

                            ?>
                            <ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="ex3-tab-1" data-bs-toggle="tab" href="#ex3-tabs-1"
                                        role="tab" aria-controls="ex3-tabs-1" aria-selected="true">Link</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="ex3-tab-2" data-bs-toggle="tab" href="#ex3-tabs-2"
                                        role="tab" aria-controls="ex3-tabs-2" aria-selected="false">Very very very very
                                        long link</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="ex3-tab-3" data-bs-toggle="tab" href="#ex3-tabs-3"
                                        role="tab" aria-controls="ex3-tabs-3" aria-selected="false">Another link</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="ex2-content">
                                <div class="tab-pane fade show active" id="ex3-tabs-1" role="tabpanel"
                                    aria-labelledby="ex3-tab-1">
                                    Tab 1 content Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptates,
                                    doloremque
                                    minima mollitia sapiente illo ut harum fugit explicabo error perspiciatis at cumque
                                    nisi eaque
                                    commodi culpa est sed ad amet.
                                </div>
                                <div class="tab-pane fade" id="ex3-tabs-2" role="tabpanel" aria-labelledby="ex3-tab-2">
                                    Tab 2 content Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptates,
                                    doloremque
                                    minima mollitia sapiente illo ut harum fugit explicabo error perspiciatis at cumque
                                    nisi eaque
                                    commodi culpa est sed ad amet.
                                </div>
                                <div class="tab-pane fade" id="ex3-tabs-3" role="tabpanel" aria-labelledby="ex3-tab-3">
                                    Tab 3 content Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptates,
                                    doloremque
                                    minima mollitia sapiente illo ut harum fugit explicabo error perspiciatis at cumque
                                    nisi eaque
                                    commodi culpa est sed ad amet.
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 search">
                                    <?php
                                    $query = "SELECT raw_thainame FROM raw_material ORDER BY raw_thainame ASC";
                                    $result = $conn->query($query);
                                    ?>
                                    <label for="type_datail" class="form-label">เลือกหมวดหมู่วัตถุดิบ</label>
                                    <select name="raw_id" class="form-select" id="select_box1">
                                        <option value="">หมวดหมู่วัตถุดิบ</option>
                                        <?php
                                        foreach ($result as $row) {
                                            echo '<option value="' . $row["raw_thainame"] . '">' . $row["raw_thainame"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-6 ">
                                    <div class="cate-raw">
                                        <label for="type_datail" class="form-label">ประเภทของข้อมูล</label>
                                        <select name="type_detail_id" id="type_detail" class="form-control">
                                            <?php
                                            $sql1 = "SELECT * FROM type_detail";
                                            $result1 = $conn->query($sql1);

                                            while ($raw1 = $result1->fetch_assoc()):
                                                ;
                                                ?>
                                                <option value="<?php echo $raw1["type_detail_id"]; ?>">
                                                    <?php echo $raw1["type_detail_name"]; ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="menu3" class="menu3 menu-content collapse">
                            <!-- คุณค่าทางโภชนะของวัตถุดิบ -->
                            <p>คุณค่าทางโภชนะของวัตถุดิบ</p>

                        </div>
                        <div id="menu4" class="menu4 menu-content collapse">
                            <!-- ปริมาณแร่ธาตุในวัตถุดิบ -->
                            <p>ปริมาณแร่ธาตุในวัตถุดิบ</p>
                        </div>
                        <div id="menu6" class="menu6 menu-content collapse menu-content">
                            <!-- เนื้อหาสำหรับเมนู "ค่าแร่ธาตุของวัตถุดิบ" -->
                            <p>ค่าแร่ธาตุของวัตถุดิบ</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script>
            // สร้างองค์ประกอบตัวเลือก
            var select_box_element1 = document.querySelector('#select_box1');
            var select_box_element2 = document.querySelector('#select_box2');
            var select_box_element3 = document.querySelector('#select_box3');
            var select_box_element4 = document.querySelector('#select_box4');

            // เรียก dselect สำหรับแต่ละองค์ประกอบ
            dselect(select_box_element1, { search: true });
            dselect(select_box_element2, { search: true });
            dselect(select_box_element3, { search: true });
            dselect(select_box_element4, { search: true });

            document.addEventListener("DOMContentLoaded", function () {
                // หาตัวอ้างอิงของรายการเมนู
                const menuItems = document.querySelectorAll(".sidenav");
                const contentContainers = document.querySelectorAll(".menu-content");

                // ตัวแปรสำหรับติดตามสถานะปัจจุบันของเมนู
                const menuStatus = Array.from(menuItems).fill(false);

                // ซ่อนเนื้อหาทั้งหมดใน container โดยใช้ CSS
                contentContainers.forEach(function (container) {
                    container.style.display = "none";
                });

                // ดักเหตุการณ์คลิกเมนู
                menuItems.forEach(function (menuItem, index) {
                    menuItem.addEventListener("click", function (event) {
                        event.preventDefault(); // ยกเลิกการทำงานของลิงก์

                        // สลับสถานะเมนู
                        menuStatus[index] = !menuStatus[index];

                        // ซ่อนเนื้อหาทั้งหมดก่อนหน้า
                        contentContainers.forEach(function (container) {
                            container.style.display = "none";
                        });

                        // แสดงเนื้อหาที่ถูกเลือก
                        contentContainers[index].style.display = "block";
                    });
                });

                // คลิกที่ปุ่ม #defaultOpen เมื่อหน้าเว็บโหลดเสร็จ
                document.getElementById("defaulOpen").click();
            });
        </script>
</body>

</html>