<?php
// connect.php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'nsmdih_it';

try {
    // Enable exception mode for mysqli
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
    // Attempt connection
    $conn = new mysqli($host, $username, $password, $dbname);

} catch (Exception $e) {
    // Handle connection failure
    echo "<h2 style='color: red; text-align: center;'>🚧 Database Server is Down 🚧</h2>";
    echo "<p style='text-align: center;'>We are currently performing maintenance. Please try again later.</p>";
    exit(); // Stop execution to prevent further errors
}
?>
