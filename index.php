<?php
echo "hello world";

include "include/db.php";
include "include/shopify.php";
include "include/shopify-data.php";
include "install.php";


// echo "hello world"; die();
session_start();

$query = "SELECT * FROM `shops` WHERE shop_url='" . $_GET['shop'] . "' LIMIT 1";

$result = $conn->query($query);

if ($result->num_rows < 1) {
    $test = new Test();
    $test->get_and_redirect_auth_url($_GET['shop'], $_NGROK_URL , $_API_KEY);
    exit();
}

// die;
$stor_data = $result->fetch_assoc();

if ($stor_data['status'] != '1') {
    $test = new Test();
    $test->get_and_redirect_auth_url($_GET['shop'], $_NGROK_URL , $_API_KEY);
    exit();
}
$access_token = $stor_data['access_token'];
$shopify_url = $stor_data['shop_url'];


$_SESSION['shop_url'] = $shopify_url;
// echo $_SESSION['shop_url'];
$shopify = new Shopify();
$shopify->set_url($shopify_url);
$shopify->set_token($access_token);

include "webhook/index.php";
echo '<script>
        setTimeout(function() {
            window.location.href = "form-builder.php";
        }, 100);
      </script>';
?>


