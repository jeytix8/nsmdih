<?php
require_once '../connect.php';

if (isset($_POST['id_no'])) {
    $stmt = $conn->prepare("DELETE FROM accounts WHERE id_no = ?");
    $stmt->bind_param("i", $_POST['id_no']);

    if ($stmt->execute()) {
        echo "User deleted successfully.";
    } else {
        echo "Error deleting user.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
