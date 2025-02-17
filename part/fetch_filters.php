<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['secured'])) {
    header('Location: login.php');
    exit();
}

require_once '../connect.php';

$filters = [
    'year_month' => [],
    'section' => [],
    'nature' => [],
    'assign' => [],
    'status' => []
];

$result = $conn->query("SELECT DISTINCT issue_year, issue_month FROM records_job_order ORDER BY issue_year DESC, issue_month ASC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $filters['year_month'][] = $row['issue_year'] . ', ' . $row['issue_month'];
    }
}

$result = $conn->query("SELECT DISTINCT section FROM records_job_order ORDER BY section ASC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $filters['section'][] = $row['section'];
    }
}

$result = $conn->query("SELECT DISTINCT job_order_nature FROM records_job_order ORDER BY job_order_nature ASC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $filters['nature'][] = $row['job_order_nature'];
    }
}

$result = $conn->query("SELECT DISTINCT assign_to FROM records_job_order ORDER BY assign_to ASC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $filters['assign'][] = $row['assign_to'];
    }
}

$result = $conn->query("SELECT DISTINCT status FROM records_job_order ORDER BY status ASC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $filters['status'][] = $row['status'];
    }
}

echo json_encode($filters);

?>
