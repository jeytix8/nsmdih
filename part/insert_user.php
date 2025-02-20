<?php
require_once '../connect.php';

if (isset($_POST['id'], $_POST['password'], $_POST['section'])) {
    $id = trim($_POST['id']);
    $password = trim($_POST['password']);
    $section = trim($_POST['section']);

    if ($id === "" || $password === "" || $section === "") {
        echo "All fields are required.";
        exit();
    }

    // Check if the user ID already exists
    $checkStmt = $conn->prepare("SELECT id FROM accounts WHERE id = ?");
    $checkStmt->bind_param("s", $id);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo "Error: User ID already exists.";
        exit();
    }

    $checkStmt->close();

    // Hash password using BCRYPT
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO accounts (id, password, section) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $id, $hashedPassword, $section);

    if ($stmt->execute()) {
        echo "User added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid input.";
}

$conn->close();
?>
