<?php

require_once( dirname(__FILE__) .  '/Endpoint_Wrapper.php');

/*
  The Beyonic_Currency class provides access to the Currencies API.
*/
class Beyonic_Currency extends Beyonic_Endpoint_Wrapper {

  protected static $endpoint = 'currencies';

}
?>
