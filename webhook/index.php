<?php
$webhook_data_create = json_decode('
{
    "webhook":{
        "topic": "app/uninstalled",     
        "address": "'.$_NGROK_URL.'/webhook/event/app-uninstall.php",
        "format": "json"
    }
}
', TRUE);


$webhook_create = $shopify->rest_api('/admin/api/2024-01/webhooks.json', $webhook_data_create, 'POST');
$responce_create = json_decode($webhook_create['response'], TRUE);
    // After the merchant accepts the charge, Shopify will redirect back to the return URL with the charge_id
    // if(isset($_GET['charge_id'])) {
    //     if($stor_data['charge_id']!=NULL){
            
    //     }
    //     else{
    //         $charge_id = $_GET['charge_id'];
            
    //         $array_charge_id = json_decode('
    //         {
    //             "recurring_application_charge": {
    //                 "id": "$charge_id",
    //                 "name": "$_APP_Name",
    //                 "api_client_id": '.rand(100000,9999999).',
    //                 "price": "9",
    //                 "return_url": "https://'.$shopify_url.'/admin/apps/'.$_APP_Handle.'/",
    //                 "trial_days": "14",
    //                 "test": true,
    //                 "billing_on": null,
    //                 "activated_on": null,
    //                 "trial_ends_on": null,
    //                 "cancelled_on": null,
    //                 "decorated_return_url": "https://'.$shopify_url.'/admin/apps/'.$_APP_Handle.'/?charge_id='.$charge_id.'"
    //             }
    //         }
    //         ', true);
    
    //         $charge_id_api = $shopify->rest_api('/admin/api/2024-01/recurring_application_charges/'.$charge_id.'/activate.json', $array_charge_id,'POST');
    //         $responce_charge = json_decode($charge_id_api['response'],TRUE);
           
    //         $charge_api_query="UPDATE `shops` SET `charge_id`=$charge_id WHERE shop_url='$shopify_url'";
    //         $charge_api_result = $conn->query($charge_api_query);
            
    //         if ($charge_api_result AND isset($responce_charge['recurring_application_charge']['return_url'])) {
    //             echo "<script> top.window.location = '".$responce_charge['recurring_application_charge']['return_url']."'; </script>";
    //             exit;
    //         } else {
    //             echo 'some proble';die;
    //         }

            
    //     }
    // }
    // else{
    //     if(!empty($stor_data['charge_id']) or $stor_data['charge_id'] != NULL){
    //         $charge_id_data = $stor_data['charge_id'];
            
    //         $charge_id_api_data = $shopify->rest_api('/admin/api/2024-01/recurring_application_charges/'.$charge_id_data.'.json');
    //         $responce_charge_data = json_decode($charge_id_api_data['response'],TRUE);
    //         if (isset($responce_charge_data['recurring_application_charge']) && $responce_charge_data['recurring_application_charge']['status'] == 'active') {
                
    //         } else {
    //             $charge_api_querys="UPDATE `shops` SET `charge_id`=NULL WHERE shop_url='$shopify_url'";
    //             $charge_api_results = $conn->query($charge_api_querys);
    //             if($charge_api_results){
    //                 echo "<script> location.reload(); </script>";
    //                 exit;
    //             }
    //         }

    //     }
    //     else{
    //         $recurring_application_charge = json_decode('
    //         {
    //             "recurring_application_charge": {
    //                 "name": "$_APP_Name",
    //                 "price": "9",
    //                 "return_url": "https://'.$shopify_url.'/admin/apps/'.$_APP_Handle.'/",
    //                 "trial_days": "14",
    //                 "test": true
    //             }
    //         }
    //         ', true);

    //         $application_charge = $shopify->rest_api('/admin/api/2024-01/recurring_application_charges.json', $recurring_application_charge, 'POST');
    //         $responce_application_charge = json_decode($application_charge['response'], true);
    //         // echo "<pre>";
    //         // var_dump($recurring_application_charge);
    //         if(isset($responce_application_charge['recurring_application_charge']['confirmation_url'])) {
    //             $confirmation_url = $responce_application_charge['recurring_application_charge']['confirmation_url'];
    //             // Redirect the merchant to the confirmation URL for them to accept the charge
    //             echo "<script> top.window.location = '".$confirmation_url."'; </script>";
    //             exit;
    //         } else {
    //             echo "<script>console.log('Error creating charge: " . json_encode($application_charge, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) . "');</script>";
    //             // echo json_encode($application_charge);
    //         }
    //     }
        
    // }