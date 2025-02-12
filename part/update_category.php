<?php
require_once '../connect.php';

if (isset($_POST['id'], $_POST['category'], $_POST['type'])) {
    $stmt = $conn->prepare("UPDATE category_job_order SET category = ?, type = ? WHERE id = ?");
    $stmt->bind_param("ssi", $_POST['category'], $_POST['type'], $_POST['id']);
    $stmt->execute();
    echo "Category updated successfully.";
}
$conn->close();
?>
