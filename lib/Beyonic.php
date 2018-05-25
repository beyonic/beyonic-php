<?php
define("BEYONIC_CLIENT_VERSION", "0.0.9");

if (!function_exists('curl_init')) {
  throw new Exception('Beyonic requires the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
  throw new Exception('Beyonic requires the JSON PHP extension.');
}

// Beyonic Primary Interface
require_once(dirname(__FILE__) . '/Beyonic/Beyonic.php');

// Beyonic API endpoints
require_once(dirname(__FILE__) . '/Beyonic/Endpoint_Wrapper.php');
require_once(dirname(__FILE__) . '/Beyonic/Webhook.php');
require_once(dirname(__FILE__) . '/Beyonic/Payment.php');
require_once(dirname(__FILE__) . '/Beyonic/Collection.php');
require_once(dirname(__FILE__) . '/Beyonic/Collection_Request.php');
require_once(dirname(__FILE__) . '/Beyonic/Contact.php');
require_once(dirname(__FILE__) . '/Beyonic/Account.php');
require_once(dirname(__FILE__) . '/Beyonic/Transaction.php');
require_once(dirname(__FILE__) . '/Beyonic/Beyonic_Exception.php');
