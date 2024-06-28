<?php require_once('../server.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แสดงตัวอย่าง</title>
    <!-- ตรงนี้คือ CSS สำหรับ Tabs และเพื่อให้เว็บไซต์ของคุณดูดี -->
    <?php //include("../header.php"); ?>
</head>

<body>
    <!-- แท็บ -->
    <ul class="custom-tab nav nav-pills">
        <li class="nav-item">
            <a class="nav-link active" id="tab-1-link" data-bs-toggle="pill" data-bs-target="#tabs-1" href="#tabs-1">Tab 1</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab-2-link" data-bs-toggle="pill" data-bs-target="#tabs-2" href="#tabs-2">Tab 2</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="tab-3-link" data-bs-toggle="pill" data-bs-target="#tabs-3" href="#tabs-3">Tab 3</a>
        </li>
    </ul>


    <!-- เนื้อหาแต่ละแท็บ -->
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="tabs-1" role="tabpanel" aria-labelledby="tab-1-link">
            <h3>Tab 1</h3>
            <!-- แบบฟอร์มสำหรับค้นหา -->
            <form action="#" method="GET" onsubmit="return handleTabSearch('1');">
                <div class="input-group search">
                    <div class="form-outline">
                        <input type="hidden" name="current_tab" value="tab-1">
                        <input type="text" name="search1" class="form-control" id="search1" placeholder="ค้นหาวัตถุดิบ" />
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
            <!-- นำเสนอข้อมูลที่ค้นหาได้ -->
            <div id="tabs-1-content">
                <?php
                if (isset($_GET['search1'])) {
                    $search = $_GET['search1'];
                    echo "Search Term: " . $search; // บรรทัดใหม่นี้ถูกเพิ่มเข้ามา
                    $sql = "SELECT * FROM nutrition WHERE nutrition_id LIKE '%$search%'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo "<table><tr><th>ID</th><th>Name</th></tr>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr><td>" . $row["nutrition_id"] . "</td><td>" . $row["raw_id"] . "</td></tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "0 results";
                    }
                } else {
                    $sql = "SELECT * FROM nutrition";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo "<table><tr><th>ID</th><th>Name</th></tr>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr><td>" . $row["nutrition_id"] . "</td><td>" . $row["raw_id"] . "</td></tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "0 results";
                    }
                }
                ?>
            </div>
        </div>
        <div class="tab-pane fade" id="tabs-2" role="tabpanel" aria-labelledby="tab-2-link">
            <h3>Tab 2</h3>
            <!-- แบบฟอร์มสำหรับค้นหา -->
            <form action="#" method="GET" onsubmit="return handleTabSearch('2');">
                <div class="input-group search">
                    <div class="form-outline">
                        <input type="hidden" name="current_tab" value="tab-2">
                        <input type="text" name="search2" class="form-control" id="search2" placeholder="ค้นหาวัตถุดิบ" />
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
            <!-- นำเสนอข้อมูลที่ค้นหาได้ -->
            <div id="tabs-2-content">
                <?php
                if (isset($_GET['search2'])) {
                    $search = $_GET['search2'];
                    echo "Search Term: " . $search;
                    $sql = "SELECT * FROM nutrition WHERE nutrition_id LIKE '%$search%'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo "<table><tr><th>ID</th><th>Name</th></tr>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr><td>" . $row["nutrition_id"] . "</td><td>" . $row["raw_id"] . "</td></tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "0 results";
                    }
                } else {
                    $sql = "SELECT * FROM nutrition";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo "<table><tr><th>ID</th><th>Name</th></tr>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr><td>" . $row["nutrition_id"] . "</td><td>" . $row["raw_id"] . "</td></tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "0 results";
                    }
                }
                ?>
            </div>
        </div>
        <div class="tab-pane fade" id="tabs-3" role="tabpanel" aria-labelledby="tab-3-link">
            <h3>Tab 3</h3>
            <!-- แบบฟอร์มสำหรับค้นหา -->
            <form action="#" method="GET" onsubmit="return handleTabSearch('3');">
                <div class="input-group search">
                    <div class="form-outline">
                        <input type="hidden" name="current_tab" value="tab-3">
                        <input type="text" name="search3" class="form-control" id="search3" placeholder="ค้นหาวัตถุดิบ" />
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
            <!-- นำเสนอข้อมูลที่ค้นหาได้ -->
            <div id="tabs-3-content">
                <?php
                if (isset($_GET['search3'])) {
                    $search = $_GET['search3'];
                    echo "Search Term: " . $search;
                    $sql = "SELECT * FROM nutrition WHERE nutrition_id LIKE '%$search%'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo "<table><tr><th>ID</th><th>Name</th></tr>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr><td>" . $row["nutrition_id"] . "</td><td>" . $row["raw_id"] . "</td></tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "0 results";
                    }
                } else {
                    $sql = "SELECT * FROM nutrition";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo "<table><tr><th>ID</th><th>Name</th></tr>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr><td>" . $row["nutrition_id"] . "</td><td>" . $row["raw_id"] . "</td></tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "0 results";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <!-- ตรงนี้คือ JavaScript -->
    <script>
        function handleTabSearch(tab) {
            var searchValue = document.querySelector('#search' + tab).value;
            var currentTab = document.querySelector('#tab-' + tab + '-link');
            document.querySelector('input[name="current_tab"]').value = 'tab-' + tab;

            document.querySelectorAll('.tab-pane').forEach(function (content) {
                content.classList.remove('show', 'active');
            });

            var targetContent = document.querySelector('#tabs-' + tab);
            if (targetContent) {
                targetContent.classList.add('show', 'active');
            }

            document.querySelectorAll('.custom-tab .nav-link').forEach(function (link) {
                link.classList.remove('active');
            });

            if (currentTab) {
                currentTab.classList.add('active');
            }

            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'test33.php?tab=' + tab + '&q=' + searchValue, true);

            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 400) {
                    var data = xhr.responseText;
                    var target = document.querySelector('#tabs-' + tab + '-content');
                    if (target) {
                        target.innerHTML = data;
                    }
                }
            };

            xhr.onerror = function () {
                console.log("Request failed");
            };

            xhr.send();

            return false;
        }

        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.custom-tab .nav-link').forEach(function (tab) {
                tab.addEventListener('click', function (e) {
                    e.preventDefault();
                    var currentTab = this.getAttribute('href').substr(1);
                    handleTabSearch(currentTab);
                });
            });
        });
    </script>
        <script>
        if (window.performance) {
            if (performance.navigation.type == 1) {
                window.location.href = 'test3.php';
            }
        }
    </script>
</body>

</html>
