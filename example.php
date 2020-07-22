<?php

/* Require the lib/Beyonic.php to included to access the interface objects */
require( 'lib/Beyonic.php' );

/* Set the API Key to be used in all requests */
Beyonic::setApiKey( 'PLACE_YOUR_KEY_HERE' );

/* Show the current callbacks */
echo "**********<br/>";
echo "Getting All Webhooks<br/>";
$resp = Beyonic_Webhook::getAll();
$results = $resp['results'];
echo 'Get Webhook Response Code: ' . Beyonic::$lastResult['httpResponseCode'] . "<br/>";
foreach( $results as $index => $hook )
  echo "Webhook $hook->id calls $hook->target on event $hook->event.<br/>";

echo "**********<br/><br/>";

/* Get a single callback */
echo "**********<br/>";
echo "Getting Webhook for " . $results[0]->id . "<br/>";
$hook = Beyonic_Webhook::get( $results[0]->id );
echo 'Get by Id Webhook Response Code: ' . Beyonic::$lastResult['httpResponseCode'] . "<br/>";
echo "Webhook $hook->id calls $hook->target on event $hook->event.<br/>";
echo "**********<br/><br/>";

/* Test Error */
echo "**********<br/>";
echo "Generating Error by getting Webhook of id 10000<br/>";
try {
	$hook = Beyonic_Webhook::get( 10000 );
} catch (Beyonic_Exception $e) {
	echo "{$e}<br/>";
	echo "{$e->responseBody}<br/>";
}

echo "**********<br/><br/>";

/* Add a new callback */
echo "**********<br/>";
echo "Creating new Webhook<br/>";
$callbackValues = array(
    'event' => 'payment.status.changed',
    'target' => 'https://mysite.com/callbacks/payment'
);
$resp = Beyonic_Webhook::create( $callbackValues );
echo 'Create Webhook Response Code: ' . Beyonic::$lastResult['httpResponseCode'] . "<br/>";
$newWebhook = $resp;
echo "Webhook $newWebhook->id calls $newWebhook->target on event $newWebhook->event.<br/>";
echo "**********<br/><br/>";

/* Update the new callback */
echo "**********<br/>";
echo "Updating Webhook<br/>";
$newWebhook->target = 'https://mysite.com/callbacks/v2/payment';
$updatedWebhook = $newWebhook->send();
echo "Creating new Webhook<br/>";
echo 'Update Webhook Response Code: ' . Beyonic::$lastResult['httpResponseCode'] . "<br/>";
echo "Webhook $updatedWebhook->id calls $updatedWebhook->target on event $updatedWebhook->event.<br/>";

$resp = Beyonic_Webhook::getAll();
$results = $resp['results'];
foreach( $results as $index => $hook )
  echo "Webhook $hook->id calls $hook->target on event $hook->event <br/>";
echo "**********<br/><br/>";

/* Delete the new callback */
echo "**********<br/>";
echo "Deleting Webhook $newWebhook->id<br/>";
$resp = Beyonic_Webhook::delete( $newWebhook->id );
echo 'Delete Webhook Response Code: ' . Beyonic::$lastResult['httpResponseCode'] . "<br/>";

$resp = Beyonic_Webhook::getAll();
$results = $resp['results'];
foreach( $results as $index => $hook )
  echo "Webhook $hook->id calls $hook->target on event $hook->event.<br/>";
echo "**********<br/><br/>";

/* Create a Payment */
echo "**********<br/>";
echo "Create Payment<br/>";
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
echo 'Create Payment Response Code: ' . Beyonic::$lastResult['httpResponseCode'] . "<br/>";
foreach( $resp as $key => $value )
  if( is_object( $value ) || is_array( $value ) ) {
    echo "Key: $key<br/>";
    foreach( $value as $k => $v )
      echo "\tKey: $k\tValue: $v<br/>";
  }
  else
    echo "Key: $key\tValue: $value<br/>";
echo "**********<br/><br/>";

/* Get the available Collections */
$resp = Beyonic_Collection::getAll();
$results = $resp['results'];
echo 'GetAll Collections Response Code: ' . Beyonic::$lastResult['httpResponseCode'] . "<br/>";
foreach( $results as $key => $value )
  if( is_object( $value ) || is_array( $value ) ) {
    echo "Key: $key<br/>";
    foreach( $value as $k => $v )
      echo "\tKey: $k\tValue: $v<br/>";
  }
  else
    echo "Key: $key\tValue: $value<br/>";
echo "**********<br/><br/>";

/* Get the available Collection Requests */
$resp = Beyonic_Collection_Request::getAll();
$results = $resp['results'];
echo 'GetAll CollectionRequests Response Code: ' . Beyonic::$lastResult['httpResponseCode'] . "<br/>";
foreach( $results as $key => $value )
  if( is_object( $value ) || is_array( $value ) ) {
    echo "Key: $key<br/>";
    foreach( $value as $k => $v )
      echo "\tKey: $k\tValue: $v<br/>";
  }
  else
    echo "Key: $key\tValue: $value<br/>";
echo "**********<br/><br/>";

/* Get the Account Balances */
$resp = Beyonic_Account::getAll();
$results = $resp['results'];
echo 'GetAll Account Balances Response Code: ' . Beyonic::$lastResult['httpResponseCode'] . "<br/>";
foreach( $results as $key => $value )
  if( is_object( $value ) || is_array( $value ) ) {
    echo "Key: $key<br/>";
    foreach( $value as $k => $v )
      echo "\tKey: $k\tValue: $v<br/>";
  }
  else
    echo "Key: $key\tValue: $value<br/>";
echo "**********<br/><br/>";

?>
