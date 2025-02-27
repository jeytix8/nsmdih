<?php
require_once '../connect.php';

if (isset($_POST['name'], $_POST['section'])) {
    $name = $_POST['name'];
    $section = $_POST['section'];
    $imageData = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
    }

    $stmt = $conn->prepare("INSERT INTO employees (name, section, image_data) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $section, $imageData);

    // **Fix for BLOB: Use send_long_data**
    if ($imageData !== null) {
        $stmt->send_long_data(2, $imageData); // Index `2` matches the third `?`
    }

    if ($stmt->execute()) {
        echo "✅ Employee added successfully!";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "❌ Invalid input.";
}

$conn->close();
?>
