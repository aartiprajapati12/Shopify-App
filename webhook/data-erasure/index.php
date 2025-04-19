<?php
include "include/shopify-data.php";
// Define your Shopify shared secret
$shared_secret = $_API_SECRET;

// Retrieve the request body
$request_body = file_get_contents('php://input');

// Retrieve the HMAC header
$hmac_header = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];

// Compute the HMAC
$computed_hmac = base64_encode(hash_hmac('sha256', $request_body, $shared_secret, true));

// Compare the computed HMAC with the HMAC header
if (hash_equals($computed_hmac, $hmac_header)) {
    // HMAC is valid, process the webhook request
    http_response_code(200);
    echo 'Webhook received and validated';
} else {
    // HMAC is invalid, reject the request
    http_response_code(401);
    echo 'Invalid HMAC';
}
?>
