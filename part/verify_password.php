<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../connect.php'; // Ensure the connection is made

// Make sure the user is logged in
if (!isset($_SESSION['secured'])) {
    echo 'error: not logged in';
    exit();
}

// Get the current logged-in user's ID from the session
$userId = $_SESSION['secured'];

// Get the entered password
$enteredPassword = $_POST['password'];

// Sanitize the input (important for security)
$enteredPassword = $conn->real_escape_string($enteredPassword);

// Retrieve the current password for the logged-in user
$query = "SELECT password FROM accounts WHERE id = ?";
if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param('s', $userId);
    $stmt->execute();
    $stmt->bind_result($storedPassword);
    
    if ($stmt->fetch()) {
        // Check if the entered password matches the stored password (hashed or plain)
        if (password_verify($enteredPassword, $storedPassword)) {
            echo 'success'; // Password is correct
        } else {
            echo 'incorrect password'; // Password is incorrect
        }
    } else {
        echo 'user not found'; // If the user doesn't exist
    }

    $stmt->close();
} else {
    echo 'error: unable to verify password';
}

$conn->close();
?>
