<?php
session_start();
if (!isset($_SESSION['user_status']) || ($_SESSION['user_status'] != 'Admin')) {
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linear Programming Minimization</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://unpkg.com/javascript-lp-solver/prod/solver.js"></script>

</head>

<body>
    <div class="container">
        <h1>Data Display</h1>
        <?php
        $jsonData = isset($_SESSION['jsonData']) ? $_SESSION['jsonData'] : '';
        $data = json_decode($jsonData, true);
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <script>
        const data = <?php echo json_encode($data); ?>;
        const materials = data.materials;
        const mineral_sources = data.mineral_sources;

        const constraints = {
            โปรตีน: { min: 12, max: 60 },
            วิตามิน: { min: 0, max: 60 },
            ธาตุ: { min: 0, max: 40 },
            ไขมัน: { min: 0, max: 60 },
            เยือใย: { min: 25, max: 100 },
        };

        materials.forEach(material => {
            constraints[material.raw_thainame] = { max: material.max };
        });

        mineral_sources.forEach(source => {
            constraints[source.ms_thainame] = { max: source.max };
        });

        const variables = {};

        materials.forEach(material => {
            // const dnut_cp = material.checkbox.checkbox_nutrition.find(item => item.hasOwnProperty('dnut_cp'));
            // const proteinValue = dnut_cp ? parseFloat(dnut_cp.dnut_cp) : 0;
            variables[material.raw_thainame] = {
                โปรตีน: 10,
                วิตามิน: 0,
                ธาตุ: 3,
                ไขมัน: 5,
                เยือใย: 0,
                cost: [material.price],
                [material.raw_thainame]: material.min
            };
        });

        mineral_sources.forEach(source => {
            variables[source.ms_thainame] = {
                โปรตีน: 0,
                วิตามิน: 0,
                ธาตุ: 3,
                ไขมัน: 5,
                เยือใย: 5,
                cost: [source.price],
                [source.ms_thainame]: source.min
            };
        });

        const model = {
            optimize: "cost",
            opType: "min",
            constraints: constraints,
            variables: variables,
        };

        const results = solver.Solve(model);

        console.log(results);
        if (results.feasible && results.bounded) {
            console.log("The solution is feasible and within bounds.");
            // document.body.innerHTML = JSON.stringify(results, null, 2);
        } else {
            console.log("The solution is infeasible or not within bounds.");
        }
    </script>

    <?php // unset($_SESSION['jsonData']);   ?>
</body>