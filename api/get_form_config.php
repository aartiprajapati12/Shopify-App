<?php
// Turn off output buffering
ob_clean();

// Ensure no errors are output
error_reporting(0);
ini_set('display_errors', 0);

// Set correct headers
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Accept");

// Database connection

$servername = "localhost";
$username = "root";  // Change if needed
$password = "";      // Change if needed
$database = "learn";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed"]));
}

// Fetch form configuration
$sql = "SELECT * FROM form_configurations"; // Change table name if different
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $formConfig = [];
    while ($row = $result->fetch_assoc()) {
        $formConfig[] = $row;
    }
    echo json_encode(["success" => true, "data" => $formConfig]);
} else {
    echo json_encode(["success" => false, "message" => "No data found"]);
}

$conn->close();
?>
