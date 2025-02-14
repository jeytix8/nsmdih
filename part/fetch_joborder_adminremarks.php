<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['secured'])) {
    header("Content-Type: application/json");
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit();
}

include("../connect.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $id = $conn->real_escape_string($_POST["id"]);

    $sql = "SELECT computer_name, model, ip_address, operating_system, remarks 
            FROM records_job_order 
            WHERE id = '$id'";

    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        echo json_encode([
            "success" => true,
            "computer_name" => $row["computer_name"],
            "model" => $row["model"],
            "ip_address" => $row["ip_address"],
            "operating_system" => $row["operating_system"],
            "remarks" => $row["remarks"]
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "No data found."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}

$conn->close();
?>
