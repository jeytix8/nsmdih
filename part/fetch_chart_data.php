<?php
require_once 'connect.php'; // Ensure correct DB connection

$type = isset($_GET['type']) ? $_GET['type'] : '';

$response = [];

if ($type === 'job_order_per_department') {
    // Count Job Orders per Department
    $query = "SELECT department, COUNT(*) AS count FROM records_job_order GROUP BY department";
} elseif ($type === 'job_order_by_type') {
    // Count Job Orders by Type
    $query = "SELECT job_order_nature, COUNT(*) AS count FROM records_job_order GROUP BY job_order_nature";
} elseif ($type === 'satisfaction_survey') {
    // Calculate Average Satisfaction per Department
    $query = "SELECT department, ROUND(SUM(satisfied) / COUNT(*), 2) AS avg_satisfaction 
              FROM records_job_order 
              GROUP BY department";
} else {
    echo json_encode(['error' => 'Invalid type']);
    exit();
}

$result = mysqli_query($conn, $query);
if (!$result) {
    die(json_encode(['error' => mysqli_error($conn)]));
}

while ($row = mysqli_fetch_assoc($result)) {
    $response[] = $row;
}

echo json_encode($response);
?>
