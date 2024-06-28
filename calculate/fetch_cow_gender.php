<?php
session_start();
include('../server.php');
$acc_id = $_SESSION['acc_id'];
$selectedCow = $_GET['selectedCow'];

// Initialize variables with default values
$response = [
    'cow_gender' => 'Data not found',
    'avg_age' => 'Data not found',
    'avg_gen' => 'Data not found',
    'cow_weight' => 'Data not found',
    'cow_activity' => 'Data not found',
    'cow_breed_status' => 'Data not found',
    'cow_milk_status' => 'Data not found',
    'calf_date' => 'Data not found',
    'milk_date' => 'Data not found'
];

// Check if $selectedCow is set
if (isset($selectedCow)) {
    // Sanitize the input to prevent SQL injection
    $selectedCow = mysqli_real_escape_string($conn, $selectedCow);

    // Add wildcard character (%) to search for data that matches the end with a number or character
    $selectedCow = $selectedCow . '%';

    // Use a prepared statement for querying the cow table
    $cowQuery = $conn->prepare("SELECT *,
    AVG(DATEDIFF(NOW(), cow_bday)) AS avg_age
    FROM cow 
    WHERE acc_id = ? AND cow_id LIKE ?");
    $cowQuery->bind_param("is", $acc_id, $selectedCow);

    // Execute the prepared statement
    $cowQueryResult = $cowQuery->execute();

    // Check if the query was successful
    if ($cowQueryResult) {
        // Get the result set
        $result1 = $cowQuery->get_result();

        // Check if there are rows in the result set
        if ($result1->num_rows > 0) {
            // Fetch data from the cow table
            $row1 = $result1->fetch_assoc();

            $avgAgeDays = $row1['avg_age'];
            $avgAge = convertDaysToYearsMonthsDays($avgAgeDays);

            $avg_gen = calculateGen($avgAgeDays, $row1['milk_date'], $row1['calf_date']);

            // Set milk_date to 0 if it's a dry period cow
            if ($avg_gen === "โคพักรีด") {
                $row1['milk_date'] = 0;
            }

            // Extract values from the fetched data
            $response = [
                'cow_gender' => $row1['cow_gender'],
                'avg_age' => $avgAge,
                'avg_gen' => $avg_gen,
                'cow_weight' => $row1['cow_weight'],
                'cow_activity' => $row1['cow_activity'],
                'cow_milk_status' => $row1['cow_milk_status'],
                'cow_breed_status' => $row1['cow_breed_status'],
                'calf_date' => $row1['calf_date'],
                'milk_date' => $row1['milk_date']
            ];
        }
    }
}

// Echo the JSON response
echo json_encode($response);

// Close the prepared statement
$cowQuery->close();

function convertDaysToYearsMonthsDays($days)
{
    $years = floor($days / 365);
    $months = floor(($days % 365) / 30);
    $remainingDays = $days % 30;

    return "$years ปี $months เดือน $remainingDays วัน";
}

// Function to calculate generation
function calculateGen($avgAgeDays, $milk_date, $calf_date)
{
    $gen = "ไม่พบรุ่น";
    $milkPeriod = "";

    if ($avgAgeDays >= 0 && $avgAgeDays <= 89) {
        $gen = "ลูกโค";
    } elseif ($avgAgeDays >= 90 && $avgAgeDays <= 149) {
        $gen = "โคหย่านม";
    } elseif ($avgAgeDays >= 150 && $avgAgeDays <= 269) {
        $gen = "โครุ่น";
    } elseif ($avgAgeDays >= 270) {
        if ($calf_date == 0 && $milk_date == 0) {
            $gen = "โคสาว";
        } elseif ($calf_date >= 0 && $calf_date < 226) {
            if ($milk_date >=1 && $milk_date <= 100) {
                $gen = "โครีดนมช่วงต้น";
            } elseif ($milk_date >= 101 && $milk_date <= 200) {
                $gen = "โครีดนมช่วงกลาง";
            } elseif ($milk_date > 201) {
                $gen = "โครีดนมช่วงปลาย";
            } elseif ($milk_date == 0) {
                $gen = "โคท้อง";
            }
        }
        elseif ($calf_date >= 226 && $calf_date < 285){
            $gen = "โคพักรีด";
        }
    }

    return $gen . " " . $milkPeriod;
}
?>
