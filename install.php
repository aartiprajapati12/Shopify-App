<?php

class test{
    public $shop_url;
    public $api_key;
    public function get_and_redirect_auth_url($shop_url, $url, $api_key)
    {
        
        $this->shop_url = $shop_url;
        $this->api_key = $api_key;
        $scopes = [
            'read_customers',
            'read_orders',
            'read_products',
            'write_script_tags',
            'read_merchant_managed_fulfillment_orders',
            'read_third_party_fulfillment_orders'
        ];

        $local_url = $url.'/token.php';
        
    

        // Ensure the URL is correctly built and safe
        $redirect = $this->getAuthUrl($scopes, $local_url);
        // echo $redirect; die;
        // Set security-related headers
        header("Content-Security-Policy: frame-ancestors https://$shop_url https://admin.shopify.com;");
        header("Access-Control-Allow-Origin: *");
        echo '
        <!DOCTYPE html>
        <html>
            <head>
                <title>Redirecting, please wait...</title>
                <script src="https://unpkg.com/@shopify/app-bridge@2"></script>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        var redirectUri = "' . htmlspecialchars($local_url) . '";
                        var permissionURL = "'.$redirect.'";

                        if (window.top == window.self) {
                            // Redirect if not in iframe
                            window.location.assign(permissionURL);
                        } else {
                            var AppBridge = window["app-bridge"];
                            var createApp = AppBridge.default;
                            var Redirect = AppBridge.actions.Redirect;

                            const app = createApp({
                                apiKey: "' . $this->api_key . '",
                                forceRedirect: true,
                                host: new URLSearchParams(location.search).get("host")
                            });
                            Redirect.create(app).dispatch(Redirect.Action.REMOTE, permissionURL);
                        }
                    });
                </script>
            </head>
            <body>
                <div class="gif" style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);"><img src="images/loading.gif"></div>
            </body>
        </html>
        ';

        // die();
    }

    public function getAuthUrl($scopes, $redirect_uri)
    {
        $nonce = bin2hex(random_bytes(12));
        $access_mode = 'pre-user';
        $scope = implode(',', $scopes);
        return "https://".$this->shop_url."/admin/oauth/authorize?".
            "client_id={$this->api_key}&".
            "scope={$scope}&".
            "redirect_uri=".urlencode($redirect_uri).
            "&state=".$nonce."&grant_options[]=".$access_mode;
}
}