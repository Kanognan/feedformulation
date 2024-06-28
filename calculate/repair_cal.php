<?php
session_start();
include "../server.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="shortcut icon" href="../Images/logofeeds.ico">
    <link rel="icon" type="image/ico" href="../Images/logofeeds.ico">
    <?php //include "../header.php"; ?>
    <title>Document</title>
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['per_use'])) {
            $per_use = $_POST['per_use'];
            $data = $_SESSION['cal_data'];
            $acc_id = $_SESSION['acc_id'];
            $name_group = $_POST['name_group'];
            $group_cal_id_cal_raw = $data['cal_raw'][0]['group_cal_id'];
            $dem_id = $data['dem_id'];
            $dem_intake = $data['dem_intake'];

            // เช็คว่าชื่อกลุ่มซ้ำหรือไม่
            $sqlCheckGroup = "SELECT * FROM group_calculate WHERE acc_id = $acc_id AND name_group = '$name_group'";
            $resultCheckGroup = $conn->query($sqlCheckGroup);

            if ($resultCheckGroup->num_rows > 0) {
                $resultName = "โปรดกรอกชื่อสูตรอาหารใหม่อีกครั้ง";
                $_SESSION['resultName'] = $resultName;
                echo "<script type='text/javascript'>";
                echo "window.location = 'repair.php'; ";
                echo "</script>";
            } else {
                $sqlInsertGroup = "INSERT INTO group_calculate (acc_id, dem_id, name_group) VALUES ('$acc_id', '$dem_id', '$name_group')";
                if ($conn->query($sqlInsertGroup) === TRUE) {
                    $last_inserted_id = mysqli_insert_id($conn);

                    if (is_array($per_use)) {
                        foreach ($per_use as $key => $value) {
                            $id = $key;
                            $usenew = $value;

                            $sql = "SELECT * FROM cal_ms WHERE group_cal_id = $group_cal_id_cal_raw AND ms_id = $id";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $price = $row['price'];
                                $new_intake_use = ($usenew * $dem_intake) / 100;
                                $new_intake_lc_result = $new_intake_use * $price;

                                $sqlInsertCalMs = "INSERT INTO cal_ms (group_cal_id, ms_id, per_use, intake_use, price, intake_lc_result) VALUES ('$last_inserted_id', '$id', '$usenew', '$new_intake_use', '$price', '$new_intake_lc_result')";
                                if ($conn->query($sqlInsertCalMs) === TRUE) {
                                    $resultData = "บันทึกข้อมูลสำเร็จ";
                                    $_SESSION['resultData'] = $resultData;
                                    echo "<script type='text/javascript'>";
                                    echo "window.location = 'repair.php'; ";
                                    echo "</script>";
                                } else {
                                    echo "Error inserting record into cal_ms: " . $conn->error;
                                }
                            }

                            $sql = "SELECT * FROM cal_raw WHERE group_cal_id = $group_cal_id_cal_raw AND raw_id = $id";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $price = $row['price'];
                                $new_intake_use = ($usenew * $dem_intake) / 100;
                                $new_intake_lc_result = $new_intake_use * $price;

                                $sqlInsertCalRaw = "INSERT INTO cal_raw (group_cal_id, raw_id, per_use, intake_use, price, intake_lc_result) VALUES ('$last_inserted_id', '$id', '$usenew', '$new_intake_use', '$price', '$new_intake_lc_result')";
                                if ($conn->query($sqlInsertCalRaw) === TRUE) {
                                    $resultData = "บันทึกข้อมูลสำเร็จ";
                                    $_SESSION['resultData'] = $resultData;
                                    echo "<script type='text/javascript'>";
                                    echo "window.location = 'repair.php'; ";
                                    echo "</script>";
                                } else {
                                    echo "Error inserting record into cal_raw: " . $conn->error;
                                }
                            }
                        }
                    }
                } else {
                    echo "Error inserting record: " . $conn->error;
                }
            }
        }
    }
    ?>
</body>

</html>