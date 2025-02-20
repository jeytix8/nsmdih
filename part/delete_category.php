<?php
require_once '../connect.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']); // Ensure it's an integer

    $stmt = $conn->prepare("DELETE FROM category_job_order WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Category deleted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
