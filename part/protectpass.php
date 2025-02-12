<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../connect.php';

// Check if the user is logged in
if (!isset($_SESSION['secured'])) {
    echo 'Not logged in';
    exit();
}

// Debugging session value
echo 'Session ID: ' . $_SESSION['secured'];  // Debugging line to check the session

// Get the logged-in user's ID and password from POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['password'])) {
    $id = $_SESSION['secured']; // Get the logged-in user's ID from the session
    $password = $_POST['password']; // Get the password from the form

    // Fetch the user's hashed password from the database
    $query = "SELECT password FROM accounts WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $hashed_password = $row['password'];

        // Debugging hash and entered password
        echo 'Hashed Password: ' . $hashed_password . '<br>';
        echo 'Entered Password: ' . $password . '<br>';

        // Verify the entered password against the stored hashed password
        if (password_verify($password, $hashed_password)) {
            echo 'Login successful'; // Password is correct
        } else {
            echo 'Invalid password'; // Password is incorrect
        }
    } else {
        echo 'User not found'; // If the user is not found in the database
    }
} else {
    echo 'Password not provided'; // If no password is provided
}
?>
