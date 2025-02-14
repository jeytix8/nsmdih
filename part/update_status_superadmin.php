<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['secured'])) {
    header('Location: login.php');
    exit();
}

include('../connect.php');

// Handle assignment update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['assign_to'])) {
    $id = $conn->real_escape_string($_POST['id']);
    $assign_to = $conn->real_escape_string($_POST['assign_to']);

    // Determine new status
    $status = empty($assign_to) ? "In Queue" : "Assigned";

    // Update query
    $updateSql = "UPDATE records_job_order SET assign_to = '$assign_to', status = '$status' WHERE id = '$id'";

    if ($conn->query($updateSql) === TRUE) {
        echo json_encode(['message' => 'Assignment updated successfully', 'status' => $status]);
    } else {
        echo json_encode(['message' => 'Error updating assignment: ' . $conn->error]);
    }
    exit();
}

// Fetch IT & Communication employees
$employees_sql = "SELECT name FROM employees WHERE section = 'IT & Communication'";
$employees_result = $conn->query($employees_sql);
$employees = [];
while ($row = $employees_result->fetch_assoc()) {
    $employees[] = $row['name'];
}

// Fetch job orders with filtering, sorting, and searching
$sort_by = isset($_GET['sort_by']) ? $conn->real_escape_string($_GET['sort_by']) : 'id';
$order = isset($_GET['order']) ? strtoupper($conn->real_escape_string($_GET['order'])) : 'DESC';
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

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
        timestamp_received,
        remarks,
        timestamp_remarks
    FROM records_job_order
    WHERE name LIKE '%$search%' 
       OR section LIKE '%$search%' 
       OR job_order_nature LIKE '%$search%' 
       OR status LIKE '%$search%'
       OR assign_to LIKE '%$search%'  -- ✅ Include search by assigned employee
    ORDER BY $sort_by $order";

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
            <td>
                <select class='assign-to-dropdown' data-id='" . $row["id"] . "'>
                    <option value=''>-- Unassign --</option>";

        foreach ($employees as $employee) {
            $selected = ($row["assign_to"] == $employee) ? "selected" : "";
            echo "<option value='$employee' $selected>$employee</option>";
        }

        echo "</select>
            </td>
            <td class='status-column' data-id='" . $row["id"] . "'>" . htmlspecialchars($row["status"]) . "</td>
            <td>" . htmlspecialchars($row["timestamp_received"]) . "</td>
            <td>" . htmlspecialchars($row["remarks"]) . "</td>
            <td>" . htmlspecialchars($row["timestamp_remarks"]) . "</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='10'>No results found</td></tr>";
}

$conn->close();
?>
