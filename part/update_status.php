<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['secured'])) {
    header('Location: login.php');
    exit();
}

include('../connect.php');

// Fetch job orders
$sql = "
    SELECT 
        id,
        CONCAT(issue_year, ', ', issue_month, ' ', issue_day, ' | ', issue_time) AS issue_date,
        name,
        section,
        job_order_nature,
        description,
        assign_to,
        status,
        satisfied,
        unsatisfied
    FROM records_job_order";

// Apply filtering
if (isset($_GET['filter_by'], $_GET['filter_value'])) {
    $valid_columns = ['name', 'section', 'job_order_nature', 'status'];
    $filter_by = $conn->real_escape_string($_GET['filter_by']);
    $filter_value = $conn->real_escape_string($_GET['filter_value']);

    if ($filter_value !== 'All' && in_array($filter_by, $valid_columns)) {
        $sql .= " WHERE $filter_by = '$filter_value'";
    }
}

// Apply sorting
if (isset($_GET['sort_by'], $_GET['order'])) {
    $valid_sort_columns = ['id', 'issue_date', 'name', 'section', 'job_order_nature', 'status'];
    $sort_by = $conn->real_escape_string($_GET['sort_by']);
    $order = strtoupper($conn->real_escape_string($_GET['order']));

    if (in_array($sort_by, $valid_sort_columns) && in_array($order, ['ASC', 'DESC'])) {
        $sql .= " ORDER BY $sort_by $order";
    }
} else {
    $sql .= " ORDER BY id DESC";  // Default sorting
}

// Execute query
$result = $conn->query($sql);
if (!$result) {
    die("Error executing query: " . $conn->error);
}

// Generate table rows
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
            <td>" . htmlspecialchars($row["status"]) . "</td>  <!-- Status is now plain text -->
            <td>" . htmlspecialchars($row["satisfied"]) . "</td>
            <td>" . htmlspecialchars($row["unsatisfied"]) . "</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='10'>No results found</td></tr>";
}

$conn->close();
?>
