<?php
require_once '../connect.php';

if (isset($_POST['id_no'], $_POST['id'], $_POST['section'])) {
    $id_no = $_POST['id_no'];
    $id = trim($_POST['id']);
    $section = trim($_POST['section']);

    if ($id === "" || $section === "") {
        echo "All fields except password are required.";
        exit();
    }

    // Check if a new password is provided
    if (!empty($_POST['password'])) {
        $password = trim($_POST['password']);
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Update with password change
        $stmt = $conn->prepare("UPDATE accounts SET id = ?, password = ?, section = ? WHERE id_no = ?");
        $stmt->bind_param("sssi", $id, $hashedPassword, $section, $id_no);
    } else {
        // Update without changing password
        $stmt = $conn->prepare("UPDATE accounts SET id = ?, section = ? WHERE id_no = ?");
        $stmt->bind_param("ssi", $id, $section, $id_no);
    }

    if ($stmt->execute()) {
        echo "User updated successfully.";
    } else {
        echo "Error updating user: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid input.";
}

$conn->close();
?>
