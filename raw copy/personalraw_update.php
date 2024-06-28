<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php //include("../header.php"); ?>
    <title>Document</title>
</head>

<body>

    <?php
    include "../server.php";
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['personalRawId']) && isset($_POST['new_p_raw_name']) && isset($_POST['raw_group_id'])) {
            $personalRawId = $_POST['personalRawId'];
            $newPRawName = $_POST['new_p_raw_name'];
            $raw_group_id = $_POST['raw_group_id'];
            
            $sqlUpdate = "UPDATE personal_raw SET p_raw_name = '$newPRawName' WHERE personal_raw_id = $personalRawId";
            $resultUpdate = mysqli_query($conn, $sqlUpdate);

            if ($resultUpdate) {
                $resultUp = "ข้อมูลถูกอัพเดตเรียบร้อย";
                $_SESSION['resultUp'] = $resultUp;
                header("Location: select_raw_edit.php?raw_group_id=$raw_group_id");
                exit();
            } else {
                echo "Error updating data: " . mysqli_error($conn);
            }
        } else {
            echo 'Missing data!';
        }
    } else {
        echo 'Invalid request!';
    }
    ?>
</body>

</html>