<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

include('../connect.php');

$selectedSection = isset($_GET['section']) ? $conn->real_escape_string($_GET['section']) : '';
$selectedDate = isset($_GET['date']) ? $conn->real_escape_string($_GET['date']) : '';

$whereClauses = ["1=1"]; // Always true condition for easier filtering
if (!empty($selectedSection)) {
    $whereClauses[] = "section = '$selectedSection'";
}
if (!empty($selectedDate)) {
    list($year, $month) = explode('-', $selectedDate);
    $whereClauses[] = "issue_year = '$year' AND issue_month = '$month'";
}
$whereSQL = count($whereClauses) > 0 ? 'WHERE ' . implode(' AND ', $whereClauses) : '';

// ✅ Get total job orders with filters
$queryTotal = "SELECT COUNT(*) as total FROM records_job_order $whereSQL";
$resultTotal = $conn->query($queryTotal);
$totalJobOrders = ($resultTotal && $rowTotal = $resultTotal->fetch_assoc()) ? $rowTotal['total'] : 0;

// ✅ Get job order count per section
$querySectionCounts = "SELECT section, COUNT(*) as count FROM records_job_order $whereSQL GROUP BY section ORDER BY section ASC";
$resultSectionCounts = $conn->query($querySectionCounts);
$sectionCounts = [];
while ($row = $resultSectionCounts->fetch_assoc()) {
    $sectionCounts[$row['section']] = $row['count'];
}

// ✅ Get job order nature count per section
$queryJobOrders = "SELECT job_order_nature, COUNT(*) as count FROM records_job_order $whereSQL GROUP BY job_order_nature ORDER BY job_order_nature ASC";
$resultJobOrders = $conn->query($queryJobOrders);
$jobOrderCounts = [];
while ($row = $resultJobOrders->fetch_assoc()) {
    $jobOrderCounts[$row['job_order_nature']] = $row['count'];
}

// ✅ Get satisfaction counts per section
$querySatisfaction = "SELECT section, SUM(satisfied) as total_satisfied, COUNT(*) as count_satisfied 
                      FROM records_job_order 
                      $whereSQL 
                      AND TRIM(satisfied) <> '' 
                      AND satisfied IS NOT NULL
                      GROUP BY section ORDER BY section ASC";
$resultSatisfaction = $conn->query($querySatisfaction);
$satisfactionCounts = [];
$totalSatisfiedRecords = 0;

while ($row = $resultSatisfaction->fetch_assoc()) {
    $section = $row['section'];
    $sumSatisfied = $row['total_satisfied'];
    $countSatisfied = $row['count_satisfied'];

    // Prevent division by zero
    $satisfactionCounts[$section] = ($countSatisfied > 0) ? round(($sumSatisfied / $countSatisfied), 2) : 0;
    $totalSatisfiedRecords += $countSatisfied;
}

// ✅ Return JSON data
$response = [
    'sectionCounts' => $sectionCounts,
    'jobOrderCounts' => $jobOrderCounts,
    'satisfactionCounts' => $satisfactionCounts,
    'totalJobOrders' => (int) $totalJobOrders,
    'totalSatisfiedRecords' => (int) $totalSatisfiedRecords,
    'selectedSection' => !empty($selectedSection) ? $selectedSection : "Overall"
];

echo json_encode($response);
