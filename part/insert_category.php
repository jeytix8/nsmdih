<?php
require_once '../connect.php';

if (isset($_POST['category'])) {
    $category = trim($_POST['category']); // Trim spaces
    if ($category === "") {
        echo "Category name cannot be empty.";
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO category_job_order (category) VALUES (?)");
    $stmt->bind_param("s", $category);

    if ($stmt->execute()) {
        echo "Category added successfully.";
    } else {
        echo "Error: " . $stmt->error; // Show error message if something goes wrong
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
