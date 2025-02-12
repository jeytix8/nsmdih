<?php
require_once '../connect.php';

if (isset($_POST['category'])) {
    $stmt = $conn->prepare("INSERT INTO category_job_order (category) VALUES (?)");
    $stmt->bind_param("s", $_POST['category']);
    $stmt->execute();
    echo "Category added successfully.";
} else {
    echo "Error adding category.";
}
$conn->close();
?>
