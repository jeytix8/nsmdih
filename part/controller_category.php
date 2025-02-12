<?php
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = (new Connect())->getConnection();
    $id = $_POST['id'];
    $category = $_POST['category'];

    $stmt = $conn->prepare("UPDATE category_job_order SET category = ? WHERE id = ?");
    $stmt->bind_param("si", $category, $id);

    if ($stmt->execute()) {
        echo "Category updated successfully.";
    } else {
        echo "Error updating category.";
    }
}
?>
