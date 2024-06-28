<?php
include "../server.php";
session_start(); ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Linear Programming Minimization</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>

<body>
    <?php
    function getRawThainameById($conn, $raw_id)
    {
        $sql = "SELECT * FROM raw_material WHERE raw_id = $raw_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row["raw_thainame"];
        } else {
            return "ไม่พบข้อมูล";
        }
    }
    function checkRawIdTable($conn, $raw_id)
    {
        // ดึงชื่อ raw_thainame โดยใช้ฟังก์ชัน getRawThainameById
        $raw_thainame = getRawThainameById($conn, $raw_id);
        
        // เช็คว่า raw_thainame ถูกสร้างหรือไม่
        if ($raw_thainame === "ไม่พบข้อมูล") {
            return "ไม่สามารถหา raw_thainame ได้";
        }
        
        $sql = "SELECT 'minerals' AS table_name FROM minerals WHERE raw_id = $raw_id
                UNION
                SELECT 'nutrition' AS table_name FROM nutrition WHERE raw_id = $raw_id
                UNION
                SELECT 'material' AS table_name FROM material WHERE raw_id = $raw_id";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $tables = array();
            while ($row = $result->fetch_assoc()) {
                $tables[] = $row["table_name"];
            }
            return $tables;
        } else {
            return "ไม่พบข้อมูลในตารางใดๆ";
        }
    }
    function getMSrawById($conn, $ms_id)
    {
        $sql = "SELECT * FROM mineral_source_raw WHERE ms_id = $ms_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row["ms_thainame"];
        } else {
            return "ไม่พบข้อมูล";
        }
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $selectCow = $_POST["selectCow"];
        $raw_group_id = $_POST["selectRaw"];

        $materials = isset($_POST['materials']) ? $_POST['materials'] : [];
        $mineral_sources = isset($_POST['mineral_sources']) ? $_POST['mineral_sources'] : [];

        $tdn = isset($_POST['checkbox-tdn']) ? $_POST['checkbox-tdn'] : null;
        $de = isset($_POST['checkbox-de']) ? $_POST['checkbox-de'] : null;
        $me = isset($_POST['checkbox-me']) ? $_POST['checkbox-me'] : null;
        $nel = isset($_POST['checkbox-nel']) ? $_POST['checkbox-nel'] : null;
        $fat = isset($_POST['checkbox-fat']) ? $_POST['checkbox-fat'] : null;
        $cp = isset($_POST['checkbox-cp']) ? $_POST['checkbox-cp'] : null;
        $cf = isset($_POST['checkbox-cf']) ? $_POST['checkbox-cf'] : null;
        $adf = isset($_POST['checkbox-adf']) ? $_POST['checkbox-adf'] : null;
        $ndf = isset($_POST['checkbox-ndf']) ? $_POST['checkbox-ndf'] : null;
        $nfe = isset($_POST['checkbox-nfe']) ? $_POST['checkbox-nfe'] : null;
        $ash = isset($_POST['checkbox-ash']) ? $_POST['checkbox-ash'] : null;
        $ca = isset($_POST['checkbox-ca']) ? $_POST['checkbox-ca'] : null;
        $p = isset($_POST['checkbox-p']) ? $_POST['checkbox-p'] : null;

        if (isset($tdn)) {
            echo " tdn: " . $tdn;
        }

        if (isset($de)) {
            echo " de: " . $de;
        }

        if (isset($me)) {
            echo " me: " . $me;
        }

        if (isset($nel)) {
            echo " nel: " . $nel;
        }

        if (isset($fat)) {
            echo " fat: " . $fat;
        }

        if (isset($cp)) {
            echo " cp: " . $cp;
        }

        if (isset($cf)) {
            echo " cf: " . $cf;
        }

        if (isset($adf)) {
            echo " adf: " . $adf;
        }

        if (isset($ndf)) {
            echo " ndf: " . $ndf;
        }

        if (isset($nfe)) {
            echo " nfe: " . $nfe;
        }

        if (isset($ash)) {
            echo " ash: " . $ash;
        }

        if (isset($ca)) {
            echo " ca: " . $ca;
        }

        if (isset($p)) {
            echo " p: " . $p;
        }

    
        $outputData = array(
            'selectCow' => $selectCow,
            'raw_group_id' => $raw_group_id,
            'materials' => array(),
            'mineral_sources' => array(),
        );

        // รวบรวมข้อมูลวัตถุดิบ
        foreach ($materials as $raw_id => $materialData) {
            $price = isset($materialData['price']) ? floatval($materialData['price']) : 0;
            $min = isset($materialData['min']) ? floatval($materialData['min']) : 0;
            $max = isset($materialData['max']) ? floatval($materialData['max']) : 0;

            $raw_thainame = getRawThainameById($conn, $raw_id);

            $outputData['materials'][] = array(
                'raw_id' => $raw_id,
                'raw_thainame' => $raw_thainame,
                'price' => $price,
                'min' => $min,
                'max' => $max,
            );
        }

        // รวบรวมข้อมูลวิตามินและแร่ธาตุ
        foreach ($mineral_sources as $ms_id => $mineralSourceData) {
            $price = isset($mineralSourceData['price']) ? floatval($mineralSourceData['price']) : 0;
            $min = isset($mineralSourceData['min']) ? floatval($mineralSourceData['min']) : 0;
            $max = isset($mineralSourceData['max']) ? floatval($mineralSourceData['max']) : 0;

            $ms_thainame = getMSrawById($conn, $ms_id);

            $outputData['mineral_sources'][] = array(
                'ms_id' => $ms_id,
                'ms_thainame' => $ms_thainame,
                'price' => $price,
                'min' => $min,
                'max' => $max,
            );
        }


        // แปลงข้อมูลเป็น JSON
        $jsonOutput = json_encode($outputData, JSON_PRETTY_PRINT);

        header('Content-Type: application/json');
        echo json_encode($outputData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $_SESSION['jsonData'] = $jsonOutput;
        // header("Location: least_cost.php");
    
    } else {
        echo "No data received.";
    }

    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/javascript-lp-solver/prod/solver.js"></script>
    <script>
        const model = {
            optimize: "cost",
            opType: "min",
            constraints: {
                โปรตีน: { min: 12, max: 60 },
                วิตามิน: { min: 0, max: 60 },
                ธาตุ: { min: 0, max: 40 },
                ไขมัน: { min: 0, max: 60 },
                เยือใย: { min: 25, max: 100 },
                <?php foreach ($outputData['materials'] as $material): ?>
                <?php echo $material['raw_thainame']; ?>: { max: <?php echo $material['max']; ?> },
                <?php endforeach; ?>
            
            <?php foreach ($outputData['mineral_sources'] as $source): ?>
                <?php echo $source['ms_thainame']; ?>: { max: <?php echo $source['max']; ?> },
                <?php endforeach; ?>
            },
            variables: {

                <?php foreach ($outputData['materials'] as $material): ?>
                <?php echo $material['raw_thainame']; ?>: {
                        โปรตีน: 12,
                        วิตามิน: 0,
                        ธาตุ: 3,
                        ไขมัน: 5,
                        เยือใย: 15,
                        cost: 12,
                        <?php echo $material['raw_thainame']; ?>: <?php echo $material['min']; ?>
                    },
                <?php endforeach; ?>

            <?php foreach ($outputData['mineral_sources'] as $source): ?>
                <?php echo $source['ms_thainame']; ?>: {
                        โปรตีน: 12,
                        วิตามิน: 0,
                        ธาตุ: 3,
                        ไขมัน: 5,
                        เยือใย: 15,
                        cost: 12,
                        <?php echo $source['ms_thainame']; ?>: <?php echo $source['min']; ?>
                    },
                <?php endforeach; ?>
            },
        };

        const results = solver.Solve(model);

        console.log(results);
        if (results.feasible && results.bounded) {
            console.log("The solution is feasible and within bounds.");
            document.body.innerHTML = JSON.stringify(results, null, 2);
        } else {
            console.log("The solution is infeasible or not within bounds.");
        }
    </script>


</body>