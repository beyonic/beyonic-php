<?php

require_once( dirname(__FILE__) .  '/Endpoint_Wrapper.php');

/*
  The Beyonic_Collection class provides access to the Collection API.
*/
class Beyonic_Collection extends Beyonic_Endpoint_Wrapper {

  protected static $endpoint = 'collections';

}
?>
