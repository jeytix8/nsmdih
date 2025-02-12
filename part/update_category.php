<?php
require_once '../connect.php';

if (isset($_POST['id'], $_POST['category'])) {
    $stmt = $conn->prepare("UPDATE category_job_order SET category = ? WHERE id = ?");
    $stmt->bind_param("si", $_POST['category'], $_POST['id']);
    $stmt->execute();
    echo "Category updated successfully.";
}
$conn->close();
?>
