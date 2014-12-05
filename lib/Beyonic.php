<?php

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
require_once(dirname(__FILE__) . '/Beyonic/Beyonic_Exception.php');
