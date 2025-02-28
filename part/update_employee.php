<?php
require_once '../connect.php';

if (isset($_POST['id'], $_POST['name'], $_POST['section'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $section = $_POST['section'];
    $imageData = null;
    
    // Check if an image was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
    }

    // Prepare the query
    if ($imageData !== null) {
        $stmt = $conn->prepare("UPDATE employees SET name = ?, section = ?, image_data = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $section, $imageData, $id);
        $stmt->send_long_data(2, $imageData); // Fix for BLOB storage
    } else {
        $stmt = $conn->prepare("UPDATE employees SET name = ?, section = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $section, $id);
    }

    // Execute query
    if ($stmt->execute()) {
        echo "✅ Employee updated successfully!";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "❌ Invalid input.";
}

$conn->close();
?>
