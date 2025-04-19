<?php
try {
    include "include/shopify-data.php";
    include "include/db.php";

    // Validate incoming data
    if (!isset($_GET['hmac'], $_GET['shop'], $_GET['code'])) {
        throw new Exception('Missing parameters');
    }

    $params = $_GET;
    $hmac = $params['hmac'];
    $shop_url = $params['shop'];

    // Remove hmac from params
    $params = array_diff_key($params, array('hmac' => ''));
    ksort($params);

    $computed_hmac = hash_hmac('sha256', http_build_query($params), $_API_SECRET);

    // Compare HMACs
    if (!hash_equals($hmac, $computed_hmac)) {
        throw new Exception('This request is NOT from Shopify!');
    }

    // Set variables for our request
    $query = array(
        "client_id" => $_API_KEY,
        "client_secret" => $_API_SECRET,
        "code" => $params['code']
    );

    $access_token_url = "https://" . $params['shop'] . "/admin/oauth/access_token";

    // Configure curl client and execute request
    $ch = curl_init();
    if ($ch === false) {
        throw new Exception('Failed to initialize cURL session');
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $access_token_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
    $result = curl_exec($ch);

    if ($result === false) {
        throw new Exception('cURL Error: ' . curl_error($ch));
    }
    curl_close($ch);

    // Debugging: Print the API response before further processing
    echo "<pre>";    print_r(json_decode($result, true)); // Show Shopify response

    print_r(json_decode($result, true)); // Show Shopify response
    echo "</pre>";
    // die(); // Stop execution for debugging

    // Store the access token
    $result = json_decode($result, true);

    if (!isset($result['access_token'])) {
        throw new Exception('Access token not found');
    }

    $access_token = $result['access_token'];
        print_r(json_decode($access_token, true)); // Show Shopify response

    
    $time = date("Y-m-d H:i:s");

    $store = "SELECT * FROM `shops` WHERE shop_url='" . $conn->real_escape_string($shop_url) . "' LIMIT 1";
    $store_result = $conn->query($store);

    if ($store_result === false) {
        throw new Exception('Error executing query: ' . $conn->error);
    }

    if ($store_result->num_rows < 1) {
        $status = 1;
        $querys = "INSERT INTO `shops`(`shop_url`, `access_token`, `hmac`, `install_date`, `status`) 
                VALUES ('$shop_url', '$access_token', '$hmac', '$time' ,'$status') 
                ON DUPLICATE KEY UPDATE access_token='$access_token', hmac='$hmac'";
        if ($conn->query($querys) === false) {
            throw new Exception('Error executing query: ' . $conn->error);
        }
    } else {
        $queryss = "UPDATE `shops` SET `status`='1',`access_token`='$access_token',`hmac`='$hmac',`install_date`='$time' WHERE shop_url='$shop_url'";

        if ($conn->query($queryss) === false) {
            throw new Exception('Error executing query: ' . $conn->error);
        }
    }

    header("Location: https://$shop_url/admin/apps/".$_SHOPIFY_ADMIN_APP);
    exit();
} catch (Exception $e) {
    // Handle exceptions by logging the error and displaying a user-friendly message
    error_log($e->getMessage());
    die('An error occurred: ' . htmlspecialchars($e->getMessage()));
}
?>
