<?php
require_once '../connect.php';

if (isset($_POST['id'])) {
    $stmt = $conn->prepare("DELETE FROM category_job_order WHERE id = ?");
    $stmt->bind_param("i", $_POST['id']);
    $stmt->execute();
    echo "Category deleted successfully.";
}
$conn->close();
?>
