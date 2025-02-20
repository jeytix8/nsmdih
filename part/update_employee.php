<?php
require_once '../connect.php';

if (isset($_POST['id'], $_POST['name'], $_POST['section'])) {
    $stmt = $conn->prepare("UPDATE employees SET name = ?, section = ? WHERE id = ?");
    $stmt->bind_param("ssi", $_POST['name'], $_POST['section'], $_POST['id']);

    if ($stmt->execute()) {
        echo "Employee updated successfully.";
    } else {
        echo "Error updating employee.";
    }
} else {
    echo "Invalid input.";
}

$conn->close();
?>
