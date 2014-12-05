<?php

require_once( dirname(__FILE__) .  '/Endpoint_Wrapper.php');

/*
  The Beyonic_Payment class provides access to the Payment API.
*/
class Beyonic_Payment extends Beyonic_Endpoint_Wrapper {

  protected static $endpoint = 'payments';

}
?>
