<?php
include('../connect.php');

$sections = isset($_POST['sections']) ? $_POST['sections'] : [];
$natures = isset($_POST['natures']) ? $_POST['natures'] : [];

$query = "SELECT * FROM records_job_order WHERE 1"; // Base query

// Add section filter if selected
if (!empty($sections)) {
    $sectPlaceholders = implode("','", $sections);
    $query .= " AND section IN ('$sectPlaceholders')";
}

// Add Job Order Nature filter if selected
if (!empty($natures)) {
    $naturePlaceholders = implode("','", $natures);
    $query .= " AND job_order_nature IN ('$naturePlaceholders')";
}

$query .= " ORDER BY id ASC";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['issue_year']}-{$row['issue_month']}-{$row['issue_day']} {$row['issue_time']}</td>
                <td>{$row['name']}</td>
                <td>{$row['section']}</td>
                <td>{$row['job_order_nature']}</td>
                <td>{$row['description']}</td>
                <td>{$row['satisfied']}</td>
                <td>{$row['unsatisfied']}</td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='8'>No records found.</td></tr>";
}
?>
