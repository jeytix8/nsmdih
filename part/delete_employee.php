<?php
require_once '../connect.php';

if (isset($_POST['id'])) {
    $stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
    $stmt->bind_param("i", $_POST['id']);

    if ($stmt->execute()) {
        echo "Employee deleted successfully.";
    } else {
        echo "Error deleting employee.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
