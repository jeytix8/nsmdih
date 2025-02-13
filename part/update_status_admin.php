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
            timestamp_resolved = '$timestamp_now'
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

$sql = "SELECT id, 
            CONCAT(issue_year, ', ', issue_month, ' ', issue_day, ' | ', issue_time) AS issue_date, 
            name, section, job_order_nature, description, assign_to, status, 
            timestamp_received, computer_name, model, ip_address, operating_system, remarks, 
            timestamp_resolved, satisfied, unsatisfied
        FROM records_job_order
        WHERE assign_to IS NOT NULL AND assign_to != ''  
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
            <td>" . htmlspecialchars($row["timestamp_resolved"]) . "</td>
            <td>" . htmlspecialchars($row["satisfied"]) . "</td>
            <td>" . htmlspecialchars($row["unsatisfied"]) . "</td>
        </tr>";
    }
}


$conn->close();
?>
