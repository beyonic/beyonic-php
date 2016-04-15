<?php

/* Require the lib/Beyonic.php to included to access the interface objects */
require( 'lib/Beyonic.php' );

/* Set the API Key to be used in all requests */
Beyonic::setApiKey( 'PLACE_YOUR_KEY_HERE' );

/* Show the current callbacks */
echo "**********\n";
echo "Getting All Webhooks\n";
$resp = Beyonic_Webhook::getAll();
$results = $resp['results'];
echo 'Get Webhook Response Code: ' . Beyonic::$lastResult['httpResponseCode'] . "\n";
foreach( $results as $index => $hook )
  echo "Webhook $hook->id calls $hook->target on event $hook->event.\n";

echo "**********\n\n";

/* Get a single callback */
echo "**********\n";
echo "Getting Webhook for " . $results[0]->id . "\n";
$hook = Beyonic_Webhook::get( $results[0]->id );
echo 'Get by Id Webhook Response Code: ' . Beyonic::$lastResult['httpResponseCode'] . "\n";
echo "Webhook $hook->id calls $hook->target on event $hook->event.\n";
echo "**********\n\n";

/* Test Error */
echo "**********\n";
echo "Generating Error by getting Webhook of id 10000\n";
try {
	$hook = Beyonic_Webhook::get( 10000 );
} catch (Beyonic_Exception $e) {
	echo "{$e}\n";
	echo "{$e->responseBody}\n";
}

echo "**********\n\n";

/* Add a new callback */
echo "**********\n";
echo "Creating new Webhook\n";
$callbackValues = array(
    'event' => 'payment.status.changed',
    'target' => 'https://mysite.com/callbacks/payment'
);
$resp = Beyonic_Webhook::create( $callbackValues );
echo 'Create Webhook Response Code: ' . Beyonic::$lastResult['httpResponseCode'] . "\n";
$newWebhook = $resp;
echo "Webhook $newWebhook->id calls $newWebhook->target on event $newWebhook->event.\n";
echo "**********\n\n";

/* Update the new callback */
echo "**********\n";
echo "Updating Webhook\n";
$newWebhook->target = 'https://mysite.com/callbacks/v2/payment';
$updatedWebhook = $newWebhook->send();
echo "Creating new Webhook\n";
echo 'Update Webhook Response Code: ' . Beyonic::$lastResult['httpResponseCode'] . "\n";
echo "Webhook $updatedWebhook->id calls $updatedWebhook->target on event $updatedWebhook->event.\n";

$resp = Beyonic_Webhook::getAll();
$results = $resp['results'];
foreach( $results as $index => $hook )
  echo "Webhook $hook->id calls $hook->target on event $hook->event \n";
echo "**********\n\n";

/* Delete the new callback */
echo "**********\n";
echo "Deleting Webhook $newWebhook->id\n";
$resp = Beyonic_Webhook::delete( $newWebhook->id );
echo 'Delete Webhook Response Code: ' . Beyonic::$lastResult['httpResponseCode'] . "\n";

$resp = Beyonic_Webhook::getAll();
$results = $resp['results'];
foreach( $results as $index => $hook )
  echo "Webhook $hook->id calls $hook->target on event $hook->event.\n";
echo "**********\n\n";

/* Create a Payment */
echo "**********\n";
echo "Create Payment\n";
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
$resp = Beyonic_Payment::create( $paymentValues );
echo 'Create Payment Response Code: ' . Beyonic::$lastResult['httpResponseCode'] . "\n";
foreach( $resp as $key => $value )
  if( is_object( $value ) || is_array( $value ) ) {
    echo "Key: $key\n";
    foreach( $value as $k => $v )
      echo "\tKey: $k\tValue: $v\n";
  }
  else
    echo "Key: $key\tValue: $value\n";
echo "**********\n\n";

/* Get the available Collections */
$resp = Beyonic_Collection::getAll();
$results = $resp['results'];
echo 'GetAll Collections Response Code: ' . Beyonic::$lastResult['httpResponseCode'] . "\n";
foreach( $results as $key => $value )
  if( is_object( $value ) || is_array( $value ) ) {
    echo "Key: $key\n";
    foreach( $value as $k => $v )
      echo "\tKey: $k\tValue: $v\n";
  }
  else
    echo "Key: $key\tValue: $value\n";
echo "**********\n\n";

/* Get the available Collection Requests */
$resp = Beyonic_Collection_Request::getAll();
$results = $resp['results'];
echo 'GetAll CollectionRequests Response Code: ' . Beyonic::$lastResult['httpResponseCode'] . "\n";
foreach( $results as $key => $value )
  if( is_object( $value ) || is_array( $value ) ) {
    echo "Key: $key\n";
    foreach( $value as $k => $v )
      echo "\tKey: $k\tValue: $v\n";
  }
  else
    echo "Key: $key\tValue: $value\n";
echo "**********\n\n";

/* Get the Account Balances */
$resp = Beyonic_Account::getAll();
$results = $resp['results'];
echo 'GetAll Account Balances Response Code: ' . Beyonic::$lastResult['httpResponseCode'] . "\n";
foreach( $results as $key => $value )
  if( is_object( $value ) || is_array( $value ) ) {
    echo "Key: $key\n";
    foreach( $value as $k => $v )
      echo "\tKey: $k\tValue: $v\n";
  }
  else
    echo "Key: $key\tValue: $value\n";
echo "**********\n\n";

?>
