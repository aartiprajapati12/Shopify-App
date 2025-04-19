<?php
include "include/shopify-data.php";

$shared_secret = $_API_SECRET;
$servername = "localhost";
$username = "thevizji_formbuilder";
$password = "formbuilder@2025";
$database = "thevizji_formbuilder";

$conn = new mysqli($servername, $username, $password, $database);
$file = fopen('debugs.txt', 'a');

if ($conn->connect_error) {
    fwrite($file, "Connection Fail: " . $conn->connect_error . "\n");
    exit;
}

define('SHOPIFY_CLIENT_SECRET', '410d39376edc7923f251df94fceb3b98');

function verify_webhook($data, $hmac_header) {
    $calculated_hmac = base64_encode(hash_hmac('sha256', $data, SHOPIFY_CLIENT_SECRET, true));
    return hash_equals($calculated_hmac, $hmac_header);
}

$hmac_header = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];
$data = file_get_contents('php://input');
$array_data = json_decode($data, true);

error_log('Webhook received: ' . $data);

$verified = verify_webhook($data, $hmac_header);
if (!$verified) {
    error_log('Webhook verification failed.');
    exit;
}

if (!isset($array_data['myshopify_domain'])) {
    fwrite($file, "myshopify_domain not found in webhook data.\n");
    exit;
}

$shop_url = $conn->real_escape_string($array_data['myshopify_domain']);
$DeleteQuery = "DELETE FROM `shops` WHERE shop_url='$shop_url'";

$result = $conn->query($DeleteQuery);
if (!$result) {
    fwrite($file, "Delete Query Failed: " . $conn->error . "\n");
} else {
    fwrite($file, "Record deleted successfully for shop: $shop_url\n");
}

fclose($file);
$conn->close();
?>