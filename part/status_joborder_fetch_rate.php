<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['secured'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

include('../connect.php');

// Set JSON response header
header('Content-Type: application/json');

// Handle rating submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $conn->real_escape_string($_POST['id']);

    // Define categories
    $categories = ['time_of_response', 'time_of_resolution', 'communication_clarity', 'quality_of_support', 'professionalism'];
    $total_categories = count($categories); // 5 categories

    $satisfied_count = 0;
    $unsatisfied_count = 0;

    foreach ($categories as $category) {
        if (isset($_POST[$category])) {
            if ($_POST[$category] === 'y') {
                $satisfied_count++; // Count satisfied
            } elseif ($_POST[$category] === 'n') {
                $unsatisfied_count++; // Count unsatisfied
            }
        }
    }

    // Calculate the final scores
    $satisfied_value = ($satisfied_count / $total_categories) * 100;
    $unsatisfied_value = ($unsatisfied_count / $total_categories) * 100;

    // Update the database
    $updateSql = "UPDATE records_job_order SET 
        satisfied = '$satisfied_value',
        unsatisfied = '$unsatisfied_value',
        status = 'Closed'
        WHERE id = '$id'";

    if ($conn->query($updateSql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Rating submitted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating rating: ' . $conn->error]);
    }
    exit();
}

// Fetch records for the table
$sort_by = isset($_GET['sort_by']) ? $conn->real_escape_string($_GET['sort_by']) : 'id';
$order = isset($_GET['order']) ? strtoupper($conn->real_escape_string($_GET['order'])) : 'DESC';

$user_section = $conn->real_escape_string($_SESSION['user_section']);

$sql = "SELECT id, 
            CONCAT(issue_year, ', ', issue_month, ' ', issue_day, ' | ', issue_time) AS issue_date, 
            name, section, job_order_nature, description, assign_to, status
        FROM records_job_order
        WHERE status != 'Closed' AND section = '$user_section'
        ORDER BY $sort_by $order";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode(['success' => false, 'message' => 'Error executing query: ' . $conn->error]);
    exit();
}

$rows = [];
while ($row = $result->fetch_assoc()) {
    $status = htmlspecialchars($row["status"]);

    // Determine button properties based on status
    if ($status === "Resolved") {
        $button = "<button class='rate-btn active' data-id='" . $row["id"] . "'>Rate</button>";
    } else {
        $button = "<button class='rate-btn disabled' disabled>Rate</button>";
    }

    $rows[] = [
        'id' => htmlspecialchars($row["id"]),
        'issue_date' => htmlspecialchars($row["issue_date"]),
        'name' => htmlspecialchars($row["name"]),
        'section' => htmlspecialchars($row["section"]),
        'job_order_nature' => htmlspecialchars($row["job_order_nature"]),
        'description' => htmlspecialchars($row["description"]),
        'assign_to' => htmlspecialchars($row["assign_to"]),
        'status' => $status,
        'button' => $button
    ];
}

echo json_encode(['success' => true, 'data' => $rows]);
$conn->close();
?>
