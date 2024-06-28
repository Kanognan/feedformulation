<?php
require_once('../server.php');
require_once("pagination_function.php");
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Document</title>
    <?php //include("../header.php"); ?>
</head>

<body>
    <div class="container">
        <div class="table-responsive-sm">
            <table class="table table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr class="table-primary">
                        <th class="text-center" scope="col" width="30">#</th>
                        <th class="text-left" scope="col">ชื่อวัตถุดิบ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $num = 0;
                    $sql = "SELECT * FROM raw_material WHERE 1";
                    $result = $conn->query($sql);
                    $total = $result->num_rows;

                    $e_page = 10; // กำหนด จำนวนรายการที่แสดงในแต่ละหน้า   
                    $step_num = 0;
                    if (!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] == 1)) {
                        $_GET['page'] = 1;
                        $step_num = 0;
                        $s_page = 0;
                    } else {
                        $s_page = $_GET['page'] - 1;
                        $step_num = $_GET['page'] - 1;
                        $s_page = $s_page * $e_page;
                    }
                    $sql .= " ORDER BY raw_id LIMIT " . $s_page . ",$e_page";
                    $result = $conn->query($sql);
                    if ($result && $result->num_rows > 0) { // คิวรี่ข้อมูลสำเร็จหรือไม่ และมีรายการข้อมูลหรือไม่
                        while ($row = $result->fetch_assoc()) { // วนลูปแสดงรายการ
                            $num++;
                            ?>
                            <tr>
                                <th class="text-center" scope="row">
                                    <?php echo ($step_num * $e_page) + $num; ?>
                                </th>
                                <td class="text-left">
                                    <?php echo $row['raw_id']; ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <?php
            page_navi($total, (isset($_GET['page'])) ? $_GET['page'] : 1, $e_page);
            ?>
        </div>

        <br>
    </div>

    <script type="text/javascript">
        $(function () {

        });
    </script>
</body>

</html>