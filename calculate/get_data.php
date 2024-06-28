<?php
session_start();
include "../server.php";

$acc_id = $_SESSION['acc_id'];
if (isset($_POST['selectCow']) && isset($_POST['selectRaw'])) {
    $groupId = $_POST['selectRaw'];
    $selectCow = $_POST['selectCow'];


    $sqlGroups = "SELECT * FROM raw_group WHERE raw_group_id = $groupId";
    $resultGroups = $conn->query($sqlGroups);

    $data = array();

    if ($resultGroups) {
        while ($group = $resultGroups->fetch_assoc()) {
            $groupId = $group['raw_group_id'];

            // ดึงข้อมูล cow_demand
            $sqlCowDemand = "SELECT * FROM cow_demand WHERE dem_id = $selectCow";
            $resultCowDemand = $conn->query($sqlCowDemand);

            $cowDemandData = array();
            while ($rowCowDemand = $resultCowDemand->fetch_assoc()) {
                $cowDemandData[] = $rowCowDemand;
            }

            // ดึงข้อมูลวัตถุดิบ
            $sqlMaterials = "SELECT 
                                raw_material_in_group.raw_group_id, 
                                raw_material.raw_id, 
                                raw_material.raw_thainame, 
                                raw_material.raw_engname,
                                price.price
                            FROM 
                                raw_material_in_group
                            INNER JOIN 
                                raw_material ON raw_material_in_group.raw_id = raw_material.raw_id
                            LEFT JOIN
                                price ON raw_material.raw_id = price.raw_id
                            WHERE 
                                raw_material_in_group.raw_group_id = $groupId
                            ORDER BY raw_material_in_group.raw_group_id";

            $resultMaterials = $conn->query($sqlMaterials);

            // ดึงข้อมูลจากตาราง mineral_sources
            $sqlMineralSourcesRaw = "SELECT 
                                        mineral_source_in_group.raw_group_id, 
                                        mineral_source_raw.ms_id, 
                                        mineral_source_raw.ms_thainame, 
                                        mineral_source_raw.ms_engname,
                                        price_ms.price
                                    FROM 
                                        mineral_source_in_group
                                    INNER JOIN 
                                        mineral_source_raw ON mineral_source_in_group.ms_id = mineral_source_raw.ms_id
                                    LEFT JOIN
                                        price_ms ON mineral_source_raw.ms_id = price_ms.ms_id
                                    WHERE 
                                        mineral_source_in_group.raw_group_id = $groupId
                                    ORDER BY mineral_source_in_group.raw_group_id";

            $resultMineralSourcesRaw = $conn->query($sqlMineralSourcesRaw);

            $groupData = array(
                'raw_group_id' => $groupId,
                'group_name' => $group['group_name'],
                'group_description' => $group['group_description'],
                'createdAt' => $group['createAt'],
                'updatedAt' => $group['updateAt'],
                'materials' => array(),
                'mineral_sources' => array(),
                'cow_demand' => $cowDemandData
            );

            while ($row = $resultMaterials->fetch_assoc()) {
                $price = ($row['price'] !== null) ? $row['price'] : "ไม่มีข้อมูลราคา";
                $groupData['materials'][] = array(
                    'raw_id' => $row['raw_id'],
                    'raw_thainame' => $row['raw_thainame'],
                    'raw_engname' => $row['raw_engname'],
                    'price' => $price
                );
            }

            while ($rowMineralSourcesRaw = $resultMineralSourcesRaw->fetch_assoc()) {
                $price = ($rowMineralSourcesRaw['price'] !== null) ? $rowMineralSourcesRaw['price'] : "ไม่มีข้อมูลราคา";
                $groupData['mineral_sources'][] = array(
                    'ms_id' => $rowMineralSourcesRaw['ms_id'],
                    'ms_thainame' => $rowMineralSourcesRaw['ms_thainame'],
                    'ms_engname' => $rowMineralSourcesRaw['ms_engname'],
                    'price' => $price
                );
            }

            if (empty($groupData['materials'])) {
                $groupData['materials'] = "ไม่มีข้อมูลวัตถุดิบในกลุ่มนี้";
            }
            if (empty($groupData['mineral_sources'])) {
                $groupData['mineral_sources'] = "ไม่มีข้อมูลวัตถุดิบในกลุ่มนี้";
            }

            $data[] = $groupData;
        }

        if (empty($data)) {
            echo json_encode(array('message' => 'ไม่มีข้อมูล'));
        } else {
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    } else {
        echo "Error in SQL Groups: " . $conn->error;
    }
} else {
    echo json_encode(array('error' => 'No data sent'));
}
?>