<?php
require_once '../connect.php';

if (isset($_POST['category'], $_POST['type'])) {
    $stmt = $conn->prepare("INSERT INTO category_job_order (category, type) VALUES (?, ?)");
    $stmt->bind_param("ss", $_POST['category'], $_POST['type']);
    $stmt->execute();
    echo "Category added successfully.";
} else {
    echo "Error adding category.";
}
$conn->close();
?>
