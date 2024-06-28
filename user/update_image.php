<?php
session_start();
include('../server.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_SESSION['acc_id'];
$updateAt = date('Y-m-d H:i:s', time());

if (isset($_POST['imgUpdate'])) {
    $date = date("Ymd");
    $numrand = (mt_rand());

    $ex_edu_qualification = $_FILES['ex_edu_qualification'];
    $ex_profes_license = $_FILES['ex_profes_license'];
    $ex_other = $_FILES['ex_other'];
    $ex_note = $_POST['ex_note'];
    $update_status = "No";

    $path = "../pic/";

    if ($ex_edu_qualification['name'] != '') {
        $add = "11";
        $type = strrchr($ex_edu_qualification["name"], ".");
        $newname1 = $date . $numrand . $add . $type;
        $file_img = $path . $newname1;

        if (move_uploaded_file($ex_edu_qualification["tmp_name"], $file_img)) {
            echo "ไฟล์ภาพชื่อ" . $newname1 . "อัพโหลดแล้ว";
            $ex_edu_qualification_db = $newname1;

            $sql_img = "SELECT ex_edu_qualification FROM expert WHERE acc_id = '$id'";
            $result_img = $conn->query($sql_img);

            if ($result_img->num_rows > 0) {
                $row = $result_img->fetch_assoc();
                $old_image = $row['ex_edu_qualification'];

                if ($old_image && file_exists($path . $old_image)) {
                    unlink($path . $old_image);
                }
            }
        } else {
            echo "เกิดข้อผิดพลาด";
        }
    } else {
        $sql_img = "SELECT ex_edu_qualification FROM expert WHERE acc_id = '$id'";
        $result_img = $conn->query($sql_img);

        if ($result_img->num_rows > 0) {
            $row = $result_img->fetch_assoc();
            $ex_edu_qualification_db = $row['ex_edu_qualification'];
        }
    }

    if ($ex_profes_license['name'] != '') {
        $add = "22";
        $type = strrchr($ex_profes_license["name"], ".");
        $newname2 = $date . $numrand . $add . $type;
        $file_img = $path . $newname2;

        if (move_uploaded_file($ex_profes_license["tmp_name"], $file_img)) {
            echo "ไฟล์ภาพชื่อ" . $newname2 . "อัพโหลดแล้ว";
            $ex_profes_license_db = $newname2;

            $sql_img = "SELECT ex_profes_license FROM expert WHERE acc_id = '$id'";
            $result_img = $conn->query($sql_img);

            if ($result_img->num_rows > 0) {
                $row = $result_img->fetch_assoc();
                $old_image = $row['ex_profes_license'];

                if ($old_image && file_exists($path . $old_image)) {
                    unlink($path . $old_image);
                }
            }

        } else {
            echo "เกิดข้อผิดพลาด";
        }
    } else {
        $sql_img = "SELECT ex_profes_license FROM expert WHERE acc_id = '$id'";
        $result_img = $conn->query($sql_img);

        if ($result_img->num_rows > 0) {
            $row = $result_img->fetch_assoc();
            $ex_profes_license_db = $row['ex_profes_license'];
        }
    }

    if ($ex_other['name'] != '') {
        $add = "33";
        $type = strrchr($ex_other["name"], ".");
        $newname3 = $date . $numrand . $add . $type;
        $file_img = $path . $newname3;

        if (move_uploaded_file($ex_other["tmp_name"], $file_img)) {
            echo "ไฟล์ภาพชื่อ" . $newname3 . "อัพโหลดแล้ว";
            $ex_other_db = $newname3;

            $sql_img = "SELECT ex_other FROM expert WHERE acc_id = '$id'";
            $result_img = $conn->query($sql_img);

            if ($result_img->num_rows > 0) {
                $row = $result_img->fetch_assoc();
                $old_image = $row['ex_other'];

                if ($old_image && file_exists($path . $old_image)) {
                    unlink($path . $old_image);
                }
            }
        } else {
            $sql_img = "SELECT ex_other FROM expert WHERE acc_id = '$id'";
            $result_img = $conn->query($sql_img);

            if ($result_img->num_rows > 0) {
                $row = $result_img->fetch_assoc();
                $ex_profes_license_db = $row['ex_other'];
            }
        }
    }

    $sqlUpdate = "UPDATE expert
    SET ex_status='$update_status', ex_note='$ex_note', ex_edu_qualification='$ex_edu_qualification_db', ex_profes_license='$ex_profes_license_db', ex_other='$ex_other_db', updateAt='$updateAt' 
    WHERE acc_id = '$id'";
    $resql = $conn->query($sqlUpdate);

    if ($resql) {
        header("location: profile.php");
        exit();
    } else {
        echo "เกิดข้อผิดพลาด";
    }
}