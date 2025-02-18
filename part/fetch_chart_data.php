<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

include('../connect.php');

$selectedSection = isset($_GET['section']) ? $conn->real_escape_string($_GET['section']) : '';

// Get job order count per section
$sectionCounts = [];
$querySectionCounts = "SELECT section, COUNT(*) as count FROM records_job_order GROUP BY section ORDER BY section ASC";
$resultSectionCounts = $conn->query($querySectionCounts);
while ($row = $resultSectionCounts->fetch_assoc()) {
    $sectionCounts[$row['section']] = $row['count'];
}

// Get job order nature count per section
$jobOrderCounts = [];
$queryJobOrders = "SELECT job_order_nature, COUNT(*) as count FROM records_job_order";

if (!empty($selectedSection)) {
    $queryJobOrders .= " WHERE section = '$selectedSection'";
}

$queryJobOrders .= " GROUP BY job_order_nature ORDER BY job_order_nature ASC";
$resultJobOrders = $conn->query($queryJobOrders);
while ($row = $resultJobOrders->fetch_assoc()) {
    $jobOrderCounts[$row['job_order_nature']] = $row['count'];
}

$response = [
    'sectionCounts' => $sectionCounts,
    'jobOrderCounts' => $jobOrderCounts,
    'totalJobOrders' => array_sum($sectionCounts)
];

echo json_encode($response);
?>
