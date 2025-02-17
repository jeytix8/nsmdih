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

    // If "On Hold" or "Resolved", update all details
    if (($status === "Resolved" || $status === "On Hold") && isset($_POST['remarks'])) {
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
            $update_received";

        $updateSql .= " WHERE id = '$id'";

    } else {
        // If any other status is selected, only update status and timestamp_received if needed
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
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

$sql = "SELECT id, 
            CONCAT(issue_year, ', ', issue_month, ' ', issue_day, ' | ', issue_time) AS issue_date, 
            name, section, job_order_nature, description, assign_to, status, 
            timestamp_received, computer_name, model, ip_address, operating_system, remarks, 
            timestamp_remarks
        FROM records_job_order
        WHERE assign_to IS NOT NULL 
          AND assign_to != ''  
          AND (id LIKE '%$search%'
          OR name LIKE '%$search%'
          OR section LIKE '%$search%'
          OR job_order_nature LIKE '%$search%'
          OR description LIKE '%$search%'
          OR assign_to LIKE '%$search%'
          OR status LIKE '%$search%'
          OR timestamp_received LIKE '%$search%'
          OR computer_name LIKE '%$search%'
          OR model LIKE '%$search%'
          OR ip_address LIKE '%$search%'
          OR operating_system LIKE '%$search%'
          OR remarks LIKE '%$search%'
          OR timestamp_remarks LIKE '%$search%')
        ORDER BY $sort_by $order";

$result = $conn->query($sql);

if (!$result) {
    die("Error executing query: " . $conn->error);
}

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
            <td>
                <select class='status-dropdown' data-id='" . $row["id"] . "'>
                    <option value='Assigned' " . ($row["status"] == "Assigned" ? "selected" : "") . ">Assigned</option>
                    <option value='In Progress' " . ($row["status"] == "In Progress" ? "selected" : "") . ">In Progress</option>
                    <option value='On Hold' " . ($row["status"] == "On Hold" ? "selected" : "") . ">On Hold</option>
                    <option value='Resolved' " . ($row["status"] == "Resolved" ? "selected" : "") . ">Resolved</option>
                </select>
            </td>
            <td>" . htmlspecialchars($row["timestamp_received"]) . "</td>
            <td>" . htmlspecialchars($row["computer_name"]) . "</td>
            <td>" . htmlspecialchars($row["model"]) . "</td>
            <td>" . htmlspecialchars($row["ip_address"]) . "</td>
            <td>" . htmlspecialchars($row["operating_system"]) . "</td>
            <td>" . htmlspecialchars($row["remarks"]) . "</td>
            <td>" . htmlspecialchars($row["timestamp_remarks"]) . "</td>
        </tr>";
    }
}

$conn->close();
?>
