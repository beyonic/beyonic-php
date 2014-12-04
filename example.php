<?php

/* Require the lib/Beyonic.php to included to access the interface objects */
require( 'lib/Beyonic.php' );

/* Set the API Key to be used in all requests */
Beyonic::setAPIKey( '6202349b8068b349b6e0b389be2a65cc36847c75' );

/* Show the current callbacks */
$resp = BeyonicWebhook::get();
echo 'Get Webhook Response Code: ' . Beyonic::$lastResult['httpResponseCode'] . "\n";
foreach( $resp as $index => $hook )
  echo "Webhook $hook->id calls $hook->target on event $hook->event.\n";

/* Add a new callback */
$resp = BeyonicWebhook::create( 'payment.status.changed', 'https://mysite.com/callbacks/payment' );
echo 'Create Webhook Response Code: ' . Beyonic::$lastResult['httpResponseCode'] . "\n";
$newWebhook = $resp;
echo "Webhook $newWebhook->id calls $newWebhook->target on event $newWebhook->event.\n";

/* Update the new callback */
$resp = BeyonicWebhook::update( $newWebhook->id, 'payment.status.changed', 'https://mysite.com/callbacks/v2/payment' );
echo 'Update Webhook Response Code: ' . Beyonic::$lastResult['httpResponseCode'] . "\n";
$updatedWebhook = $resp;
echo "Webhook $updatedWebhook->id calls $updatedWebhook->target on event $updatedWebhook->event.\n";

/* Delete the new callback */
$resp = BeyonicWebhook::delete( $newWebhook->id );
echo 'Delete Webhook Response Code: ' . Beyonic::$lastResult['httpResponseCode'] . "\n";

/* Show the current callbacks */
$resp = BeyonicWebhook::get();
echo 'Get Webhook Response Code: ' . Beyonic::$lastResult['httpResponseCode'] . "\n";
foreach( $resp as $index => $hook )
  echo "Webhook $hook->id calls $hook->target on event $hook->event.\n";

/* Create a Payment */
$paymentValues = array(
    /* Phone number being charged */
    'phonenumber' => '+15555551212',
    /* Amount being charged */
    'amount'      => '1.09',
    /* Currency being charged */
    'currency'    => 'UGX',
    /* Description of Transaction */
    'description' => 'OptiGrab',
    /* Information used by application to identify transaction */
    'metadata'    => "{ 'appId': 'my-application', 'xactId': '1' }"
);
$resp = BeyonicPayment::create( $paymentValues );
echo 'Create Payment Response Code: ' . Beyonic::$lastResult['httpResponseCode'] . "\n";
foreach( $resp as $key => $value )
  if( is_object( $value ) || is_array( $value ) ) {
    echo "Key: $key\n";
    foreach( $value as $k => $v )
      echo "\tKey: $k\tValue: $v\n";
  }
  else
    echo "Key: $key\tValue: $value\n"
?>
