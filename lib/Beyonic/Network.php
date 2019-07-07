<?php

require_once( dirname(__FILE__) .  '/Endpoint_Wrapper.php');

/*
  The Beyonic_Network class provides access to the Networks API.
*/
class Beyonic_Network extends Beyonic_Endpoint_Wrapper {

  protected static $endpoint = 'networks';

}
?>
