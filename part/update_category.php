<?php
require_once '../connect.php';

if (isset($_POST['id'], $_POST['category'])) {
    $id = intval($_POST['id']); // Ensure it's an integer
    $category = trim($_POST['category']); // Trim input

    if ($category === "") {
        echo "Category name cannot be empty.";
        exit();
    }

    $stmt = $conn->prepare("UPDATE category_job_order SET category = ? WHERE id = ?");
    $stmt->bind_param("si", $category, $id);

    if ($stmt->execute()) {
        echo "Category updated successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
