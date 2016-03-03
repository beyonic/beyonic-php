<?php

require_once( dirname(__FILE__) .  '/Endpoint_Wrapper.php');

/*
  The Beyonic_Account class provides access to the Account API.
*/
class Beyonic_Account extends Beyonic_Endpoint_Wrapper {

  protected static $endpoint = 'accounts';

}
?>
