<?php

require_once( dirname(__FILE__) .  '/Endpoint_Wrapper.php');

/*
  The Beyonic_Transaction class provides access to the Transactions API.
*/
class Beyonic_Transaction extends Beyonic_Endpoint_Wrapper {

  protected static $endpoint = 'transactions';

}
?>
