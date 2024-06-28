<?php
require_once('../server.php');
if (isset($_GET['q'])) {
    $tab = $_GET['tab'];
    $search = $_GET['q'];


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

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
}
?>
