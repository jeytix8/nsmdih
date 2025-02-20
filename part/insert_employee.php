<?php
require_once '../connect.php';

if (isset($_POST['name'], $_POST['section'])) {
    $stmt = $conn->prepare("INSERT INTO employees (name, section) VALUES (?, ?)");
    $stmt->bind_param("ss", $_POST['name'], $_POST['section']);

    if ($stmt->execute()) {
        echo "Employee added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Invalid input.";
}

$conn->close();
?>
