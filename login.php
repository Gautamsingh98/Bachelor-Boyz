<?php
header('Content-Type: application/json');

$servername = "localhost";
$dbusername = "root"; // your MySQL username
$dbpassword = "";     // your MySQL password
$dbname = "student_portal";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed"]));
}

// Get POST data
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';

if (empty($username) || empty($email)) {
    echo json_encode(["status" => "error", "message" => "Username and email are required"]);
    exit;
}

// Optional: Check if user already exists
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $email);
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "User logged in successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to save user"]);
    }
} else {
    echo json_encode(["status" => "success", "message" => "User already exists"]);
}

$conn->close();
?>
