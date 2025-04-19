<?php
// Ensure proper output buffering and response format
ob_clean();
header("Content-Type: application/json");

// Set CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Disable error display for security but log errors
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.txt'); // Log errors to a file

try {
    // Database configuration
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "learn";

    // Create database connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check database connection
    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }

    // Fetch data from `csv_data` table
    $sql = "SELECT * FROM csv_data";
    $result = $conn->query($sql);

    // Check for query execution failure
    if ($result === false) {
        throw new Exception("Query failed: " . $conn->error);
    }

    // Process result
    $formConfig = [];
    while ($row = $result->fetch_assoc()) {
        $formConfig[] = $row;
    }

    // Close database connection
    $conn->close();

    // Send response
    echo json_encode([
        "success" => true,
        "data" => $formConfig,
        "count" => count($formConfig)
    ], JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    // Send error response
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "An error occurred",
        "error" => $e->getMessage(),
        "file" => $e->getFile(),
        "line" => $e->getLine()
    ], JSON_PRETTY_PRINT);
}
?>
