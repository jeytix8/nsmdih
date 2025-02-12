<?php
session_start();
require_once "../connect.php"; // Ensure correct path to your database connection

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Log the user out and log the logout action
    if (isset($_SESSION['secured'])) {
        $user_id = $_SESSION['secured'];  // Get user ID from session
    }

    // Clear session and destroy
    session_unset();
    session_destroy();
    
    // Redirect to login page
    header("Location: login.php?logged_out=1");
    exit();
} else {
    // If method is not POST, redirect to login or show an error
    header("Location: login.php");
    exit();
}
?>
