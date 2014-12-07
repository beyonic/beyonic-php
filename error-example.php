<?php

/* Require the lib/Beyonic.php to included to access the interface objects */
require( 'lib/Beyonic.php' );

/* Set the API Key to be used in all requests */
Beyonic::setApiKey( '6202349b8068b349b6e0b389be2a65cc36847c75' );

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

?>
