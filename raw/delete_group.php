<?php
session_start();
include "../server.php";

if (isset($_POST['RawGroupId'])) {
    $rawGroupId = $_POST['RawGroupId'];
    $success = true;

    // $checkSql = "SELECT COUNT(*) AS count FROM personal_raw WHERE raw_group_id = $rawGroupId";
    // $checkResult = mysqli_query($conn, $checkSql);
    // $rowCount = mysqli_fetch_assoc($checkResult)['count'];

    // if ($rowCount > 0) {
    //     $sql_personal_raw = "DELETE FROM personal_raw WHERE raw_group_id = $rawGroupId";
    //     $resultPsRaw = mysqli_query($conn, $sql_personal_raw);
    //     $success = $success && $resultPsRaw;
    // }

    $checkSql = "SELECT COUNT(*) AS count FROM raw_material_in_group WHERE raw_group_id = $rawGroupId";
    $checkResult = mysqli_query($conn, $checkSql);
    $rowCount = mysqli_fetch_assoc($checkResult)['count'];

    if ($rowCount > 0) {
        $sql_raw_material_in_group = "DELETE FROM raw_material_in_group WHERE raw_group_id = $rawGroupId";
        $resultRawInGroup = mysqli_query($conn, $sql_raw_material_in_group);
        $success = $success && $resultRawInGroup;
    }

    // $checkSql = "SELECT COUNT(*) AS count FROM personal_ms WHERE raw_group_id = $rawGroupId";
    // $checkResult = mysqli_query($conn, $checkSql);
    // $rowCount = mysqli_fetch_assoc($checkResult)['count'];

    // if ($rowCount > 0) {
    //     $sql_personal_ms = "DELETE FROM personal_ms WHERE raw_group_id = $rawGroupId";
    //     $resultPsMs = mysqli_query($conn, $sql_personal_ms);
    //     $success = $success && $resultPsMs;
    // }

    $checkSql = "SELECT COUNT(*) AS count FROM mineral_source_in_group WHERE raw_group_id = $rawGroupId";
    $checkResult = mysqli_query($conn, $checkSql);
    $rowCount = mysqli_fetch_assoc($checkResult)['count'];

    if ($rowCount > 0) {
        $sql_mineral_source_in_group = "DELETE FROM mineral_source_in_group WHERE raw_group_id = $rawGroupId";
        $resultPsMsInGrooup = mysqli_query($conn, $sql_mineral_source_in_group);
        $success = $success && $resultPsMsInGrooup;
    }

    if ($success) {
        $sql_raw_group = "DELETE FROM raw_group WHERE raw_group_id = $rawGroupId";
        $resultRawGroup = mysqli_query($conn, $sql_raw_group);

        if ($resultRawGroup) {
            mysqli_close($conn);
            http_response_code(204); // No Content
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(["error" => "ไม่สามารถลบข้อมูลในตาราง raw_group ได้"]);
        }
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(["error" => "ไม่สามารถลบข้อมูลในตารางบางตารางได้"]);
    }
} else {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "ไม่พบ RawGroupId"]);
}
?>
