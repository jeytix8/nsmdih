<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['secured'])) {
    header('Location: login.php');
    exit();
}

include('../connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['status'])) {
    $id = $conn->real_escape_string($_POST['id']);
    $status = $conn->real_escape_string($_POST['status']);

    // Check if `timestamp_received` needs to be updated
    $timestamp_received_check = $conn->query("SELECT timestamp_received FROM records_job_order WHERE id = '$id'");
    $row = $timestamp_received_check->fetch_assoc();
    $current_timestamp_received = $row['timestamp_received'];

    $timestamp_now = date("Y, F j | H:i:s");

    if (empty($current_timestamp_received)) {
        $update_received = ", timestamp_received = '$timestamp_now'";
    } else {
        $update_received = "";
    }

    // If status is Resolved, update additional details
    if ($status === "Resolved" && isset($_POST['computer_name'], $_POST['model'], $_POST['ip_address'], $_POST['operating_system'], $_POST['remarks'])) {
        $computer_name = $conn->real_escape_string($_POST['computer_name']);
        $model = $conn->real_escape_string($_POST['model']);
        $ip_address = $conn->real_escape_string($_POST['ip_address']);
        $operating_system = $conn->real_escape_string($_POST['operating_system']);
        $remarks = $conn->real_escape_string($_POST['remarks']);

        $updateSql = "UPDATE records_job_order SET 
            status = '$status',
            computer_name = '$computer_name',
            model = '$model',
            ip_address = '$ip_address',
            operating_system = '$operating_system',
            remarks = '$remarks',
            timestamp_remarks = '$timestamp_now'
            $update_received
            WHERE id = '$id'";
    } else {
        $updateSql = "UPDATE records_job_order SET 
            status = '$status'
            $update_received
            WHERE id = '$id'";
    }

    if ($conn->query($updateSql) === TRUE) {
        echo json_encode(['message' => 'Status updated successfully']);
    } else {
        echo json_encode(['message' => 'Error updating status: ' . $conn->error]);
    }
    exit();
}


// Fetch records for the table
$sort_by = isset($_GET['sort_by']) ? $conn->real_escape_string($_GET['sort_by']) : 'id';
$order = isset($_GET['order']) ? strtoupper($conn->real_escape_string($_GET['order'])) : 'DESC';
$search = isset($_GET['search']) ? trim($conn->real_escape_string($_GET['search'])) : '';

// Search condition, apply if search term exists
$searchCondition = "";
if (!empty($search)) {
    $searchCondition = "AND (
        id LIKE '%$search%' OR 
        CONCAT(issue_year, ', ', issue_month, ' ', issue_day, ' | ', issue_time) LIKE '%$search%' OR
        name LIKE '%$search%' OR
        section LIKE '%$search%' OR
        job_order_nature LIKE '%$search%' OR
        description LIKE '%$search%' OR
        assign_to LIKE '%$search%' OR
        status LIKE '%$search%' OR
        timestamp_received LIKE '%$search%' OR
        computer_name LIKE '%$search%' OR
        model LIKE '%$search%' OR
        ip_address LIKE '%$search%' OR
        operating_system LIKE '%$search%' OR
        remarks LIKE '%$search%' OR
        timestamp_remarks LIKE '%$search%' OR
        satisfied LIKE '%$search%' OR
        unsatisfied LIKE '%$search%'
    )";
}

// Handle filters if they are present in the GET request
$filterConditions = [];

// Loop through each filter type and build conditions based on selected values
if (isset($_GET['year_month']) && !empty($_GET['year_month'])) {
    $yearMonth = $_GET['year_month'];
    if (!is_array($yearMonth)) $yearMonth = [$yearMonth]; // Ensure it's an array
    $filterParts = [];
    foreach ($yearMonth as $ym) {
        list($year, $month) = explode(', ', trim($ym, "'"));
        $filterParts[] = "(issue_year = '$year' AND issue_month = '$month')";
    }
    $filterConditions[] = "(" . implode(" OR ", $filterParts) . ")";
}

if (isset($_GET['section']) && !empty($_GET['section'])) {
    $sections = $_GET['section'];
    if (!is_array($sections)) $sections = [$sections]; // Ensure it's an array
    $escapedSections = array_map(fn($v) => "'" . $conn->real_escape_string($v) . "'", $sections);
    $filterConditions[] = "section IN (" . implode(',', $escapedSections) . ")";
}

if (isset($_GET['nature']) && !empty($_GET['nature'])) {
    $natures = $_GET['nature'];
    if (!is_array($natures)) $natures = [$natures]; // Ensure it's an array
    $escapedNatures = array_map(fn($v) => "'" . $conn->real_escape_string($v) . "'", $natures);
    $filterConditions[] = "job_order_nature IN (" . implode(',', $escapedNatures) . ")";
}

if (isset($_GET['assign']) && !empty($_GET['assign'])) {
    $assigns = $_GET['assign'];
    if (!is_array($assigns)) $assigns = [$assigns]; // Ensure it's an array
    $escapedAssigns = array_map(fn($v) => "'" . $conn->real_escape_string($v) . "'", $assigns);
    $filterConditions[] = "assign_to IN (" . implode(',', $escapedAssigns) . ")";
}

if (isset($_GET['status']) && !empty($_GET['status'])) {
    $statuses = $_GET['status'];
    if (!is_array($statuses)) $statuses = [$statuses]; // Ensure it's an array
    $escapedStatuses = array_map(fn($v) => "'" . $conn->real_escape_string($v) . "'", $statuses);
    $filterConditions[] = "status IN (" . implode(',', $escapedStatuses) . ")";
}

// Combine the filters and search conditions
$whereClause = count($filterConditions) > 0 ? "AND (" . implode(" AND ", $filterConditions) . ")" : "";

// Main query with filters and search applied
$sql = "SELECT id, 
            CONCAT(issue_year, ', ', issue_month, ' ', issue_day, ' | ', issue_time) AS issue_date, 
            name, section, job_order_nature, description, assign_to, status, 
            timestamp_received, computer_name, model, ip_address, operating_system, remarks, 
            timestamp_remarks, satisfied, unsatisfied
        FROM records_job_order
        WHERE 1=1
        $whereClause
        $searchCondition
        ORDER BY $sort_by $order";


$result = $conn->query($sql);

if (!$result) {
    die("Error executing query: " . $conn->error);
}

// Output results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>" . htmlspecialchars($row["id"]) . "</td>
            <td>" . htmlspecialchars($row["issue_date"]) . "</td>
            <td>" . htmlspecialchars($row["name"]) . "</td>
            <td>" . htmlspecialchars($row["section"]) . "</td>
            <td>" . htmlspecialchars($row["job_order_nature"]) . "</td>
            <td>" . htmlspecialchars($row["description"]) . "</td>
            <td>" . htmlspecialchars($row["assign_to"]) . "</td>
            <td>" . htmlspecialchars($row["status"]) . "</td>
            <td>" . htmlspecialchars($row["timestamp_received"]) . "</td>
            <td>" . htmlspecialchars($row["computer_name"]) . "</td>
            <td>" . htmlspecialchars($row["model"]) . "</td>
            <td>" . htmlspecialchars($row["ip_address"]) . "</td>
            <td>" . htmlspecialchars($row["operating_system"]) . "</td>
            <td>" . htmlspecialchars($row["remarks"]) . "</td>
            <td>" . htmlspecialchars($row["timestamp_remarks"]) . "</td>
            <td>" . htmlspecialchars($row["satisfied"]) . "</td>
            <td>" . htmlspecialchars($row["unsatisfied"]) . "</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='17'>No records found</td></tr>";
}

$conn->close();
?>
