<?php
require_once '../connect.php';

$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'id';
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';

// Ensure only valid column names are used
$allowed_columns = ['id', 'issue_timestamp', 'name', 'department', 'job_order_nature', 'description', 'satisfied', 'unsatisfied'];
if (!in_array($sort_by, $allowed_columns)) {
    $sort_by = 'id';
}

// Ensure order is ASC or DESC
$order = ($order === 'desc') ? 'DESC' : 'ASC';

// Fetch data with a proper timestamp
$query = "SELECT id, 
                 CONCAT(issue_year, ', ', issue_month, ' ', issue_day, ' | ', issue_time) AS issue_timestamp, 
                 name, department, job_order_nature, description, satisfied, unsatisfied 
          FROM records_job_order 
          ORDER BY $sort_by $order";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}

$output = '';

while ($row = mysqli_fetch_assoc($result)) {
    $output .= "
        <tr>
            <td>{$row['id']}</td>
            <td>{$row['issue_timestamp']}</td>
            <td>{$row['name']}</td>
            <td>{$row['department']}</td>
            <td>{$row['job_order_nature']}</td>
            <td>{$row['description']}</td>
            <td>{$row['satisfied']}%</td>
            <td>{$row['unsatisfied']}%</td>
        </tr>";
}

echo $output;
?>
