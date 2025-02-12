<?php
session_start();
require_once __DIR__ . '/../connect.php';

// Redirect if the user is already logged in
if (isset($_SESSION['secured'])) {
    header('Location: ../index.php');
    exit();
}

$message = "";

// Check for logout message
if (isset($_GET['logged_out']) && $_GET['logged_out'] == 1) {
    $message = "You have been logged out successfully.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST["id"]); // Sanitize input
    $password = $_POST["password"];

    // Validate input
    if (empty($id) || empty($password)) {
        $message = "Please enter a valid username and password.";
    } else {
        // Query to fetch account details
        $query = "SELECT id, password, type, status FROM accounts WHERE id = ? LIMIT 1";
        $stmt = mysqli_prepare($conn, $query);

        if (!$stmt) {
            die('Query preparation failed: ' . htmlspecialchars(mysqli_error($conn)));
        }

        // Bind parameters and execute the query
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Check if account is archived
            if (($row["status"]) === 'Inactive') {
                $message = "This account is archived and cannot be used for login.";
            } else {
                // Verify password
                if (password_verify($password, $row["password"])) {
                    $user_type = $row["type"];

                    // Restrict access for specific user types
                    if ($user_type === 'student' || $user_type === 'faculty') {
                        $message = "Student and Faculty accounts cannot log in.";
                    } else {
                        // Regenerate session ID to prevent session fixation
                        session_regenerate_id(true);

                        // Store user information in session
                        $_SESSION['secured'] = $row["id"];
                        $_SESSION['user_type'] = $user_type;
                        $_SESSION['last_activity'] = time(); // Set last activity time


                        // Redirect to the dashboard or home page
                        header('Location: ../index.php');
                        exit();
                    }
                } else {
                    $message = "Invalid password.";
                }
            }
        } else {
            $message = "Invalid username or account does not exist.";
        }

        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="../assets/css/style.bundle.css" rel="stylesheet">
    <style>
        body {
            background: url('../background.jpg') no-repeat top center fixed; /* Align to the top */
            background-size: cover; /* Ensure the whole image is visible while maintaining aspect ratio */
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-form {
            background-color: rgba(255, 255, 255, 1);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 100%;
            height: 320px;
        }
        .error-message {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }
        #buttonw:hover {
            background-color: #1a0c80!important;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h3 class="text-center">Login</h3><hr>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="id" name="id" placeholder="Enter your username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="d-grid">
                <button style="background-color: #090145; color: whitesmoke; margin-top: 13px;" id="buttonw" type="submit" name="submit" id="buttonw" class="btn btn-success">Login</button>
            </div>
            <!-- Display the message here -->
            <?php if (!empty($message)): ?>
                <div style="margin-top: 7px; font-size: 8pt" class="error-message" id="logoutMessage"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
        </form>
    </div>

    <script src="../assets/js/scripts.bundle.js"></script>
    <script>
        window.onload = function() {
            var logoutMessage = document.getElementById('logoutMessage');
            if (logoutMessage) {
                // Hide the message after 3 seconds
                setTimeout(function() {
                    logoutMessage.style.display = 'none';
                }, 3000);  // Adjust the time in milliseconds (3000 ms = 3 seconds)
            }
        };
    </script>
</body>
</html>
