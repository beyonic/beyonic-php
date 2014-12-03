<?php

/* Require the lib/Beyonic.php to included to access the interface objects */
require( 'lib/Beyonic.php' );

/* Set the API Key to be used in all requests */
Beyonic::setAPIKey( '6202349b8068b349b6e0b389be2a65cc36847c75' );

/* Show the current callbacks */
$resp = BeyonicWebhook::show();
echo "Show Webhook Response Code: $resp->httpResponseCode\n";
foreach( $resp->result as $index => $hook )
  echo "Webhook $hook->id calls $hook->target on event $hook->event.\n";

/* Add a new callback */
$resp = BeyonicWebhook::add( 'payment.status.changed', 'https://mysite.com/callbacks/payment' );
echo "Add Webhook Response Code: $resp->httpResponseCode\n";
$newWebhook = $resp->result;
echo "Webhook $newWebhook->id calls $newWebhook->target on event $newWebhook->event.\n";

/* Update the new callback */
$resp = BeyonicWebhook::update( $newWebhook->id, 'payment.status.changed', 'https://mysite.com/callbacks/v2/payment' );
echo "Update Webhook Response Code: $resp->httpResponseCode\n";
$updatedWebhook = $resp->result;
echo "Webhook $updatedWebhook->id calls $updatedWebhook->target on event $updatedWebhook->event.\n";

/* Delete the new callback */
$resp = BeyonicWebhook::delete( $newWebhook->id );
echo "Deleted Webhook Response Code: $resp->httpResponseCode\n";

/* Show the current callbacks */
$resp = BeyonicWebhook::show();
echo "Show Webhook Response Code: $resp->httpResponseCode\n";
foreach( $resp->result as $index => $hook )
  echo "Webhook $hook->id calls $hook->target on event $hook->event.\n";

/* Create a Payment */
$paymentValues = array(
    'phonenumber' => '+15555551212',
    'amount'      => '1.09',
    'currency'    => 'UGX',
    'description' => 'OptiGrab Refund',
    'metadata'    => "{ 'appId': 'my-application', 'xactId': '1' }"
);
echo json_encode( $paymentValues ) . "\n";
$resp = BeyonicPayment::create( $paymentValues );
echo "Create Payment Response Code: $resp->httpResponseCode\n";
var_dump( $resp );
?>
