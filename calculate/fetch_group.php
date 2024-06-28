<?php
session_start();
include('../server.php');
$acc_id = $_SESSION['acc_id'];
$selectedgroupCow = $_GET['selectedgroupCow'];
$selectedgroupCow = mysqli_real_escape_string($conn, $selectedgroupCow);
$selectedgroupCow = $selectedgroupCow . '%';
// echo $selectedgroupCow;
// Initialize variables with default values
$response = [
    'avg_cow_weight' => 'Data not found',
    'avg_milk_date' => 'Data not found',
    'avg_calf_date' => 'Data not found',
    'avg_age' => 'Data not found',
    'avg_gen' => 'Data not found',
    'dominant_gender' => 'Data not found',
];

// Use a prepared statement for querying the cow table
$groupQuery = $conn->prepare("SELECT *,
    AVG(cow_weight) AS avg_cow_weight,
    AVG(milk_date) AS avg_milk_date,
    AVG(calf_date) AS avg_calf_date,
    AVG(DATEDIFF(NOW(), cow_bday)) AS avg_age,
    COUNT(*) AS gender_count
    FROM cow 
    INNER JOIN group_cow ON cow.group_id = group_cow.group_id 
    WHERE acc_id = ? AND cow.group_id = ?
    GROUP BY cow_gender");

// Bind parameters to the prepared statement
$groupQuery->bind_param("is", $acc_id, $selectedgroupCow);

// Execute the prepared statement
$groupQueryResult = $groupQuery->execute();

// Check if the query was successful
if ($groupQueryResult) {
    // Get the result set
    $result = $groupQuery->get_result();

    // Check if there are rows in the result set
    if ($result->num_rows > 0) {
        // Initialize variables to store gender counts
        $maleCount = 0;
        $femaleCount = 0;

        // Fetch data from the result set
        while ($row = $result->fetch_assoc()) {
            // Extract values from the fetched data
            $gender = $row['cow_gender'];
            $genderCount = $row['gender_count'];

            // Update gender counts
            if ($gender === 'เพศผู้') {
                $maleCount = $genderCount;
            } elseif ($gender === 'เพศเมีย') {
                $femaleCount = $genderCount;
            }

            // Convert avg_age to human-readable format (day, month, year)
            $avgAgeDays = $row['avg_age'];
            $avgAge = convertDaysToYearsMonthsDays($avgAgeDays);

            // Calculate generation
            $avg_gen = calculateGen($avgAgeDays, $row['avg_milk_date'], $row['avg_calf_date']);


            // Update the response for each iteration
            $response = [
                'cow_bday' => $row['cow_bday'],
                'cow_activity' => $row['cow_activity'],
                'cow_milk_status' => $row['cow_milk_status'],
                'cow_breed_status' => $row['cow_breed_status'],
                'avg_cow_weight' => $row['avg_cow_weight'],
                'avg_milk_date' => $row['avg_milk_date'],
                'avg_calf_date' => $row['avg_calf_date'],
                'avg_age' => $avgAge,
                'avg_gen' => $avg_gen,
                'dominant_gender' => ($femaleCount > $maleCount) ? 'เพศเมีย' : 'เพศผู้',
            ];
        }
    }
}

// Echo the JSON response
echo json_encode($response);

// Close the prepared statement
$groupQuery->close();

// Function to convert days to years, months, days
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
        }
        elseif ($calf_date >= 0 ) {
            if($milk_date > 0 && $milk_date <= 100){
                $gen = "โครีดนมช่วงต้น";
            }
            elseif($milk_date >= 101 && $milk_date <= 200){
                $gen = "โครีดนมช่วงกลาง";
            }
            elseif($milk_date > 201){
                $gen = "โครีดนมช่วงปลาย";
            }
            elseif($milk_date == 0){
                $gen = "โคท้อง";
            }
        } 
                                            // elseif ($calf_date > 226 && $calf_date < 285){
                                            //     $gen = "โคพักรีด";
                                            // }
    } 
                                        
    return  $gen ." ". $milkPeriod;
}
?>
