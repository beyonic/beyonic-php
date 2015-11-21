<?php

require_once( dirname(__FILE__) .  '/Endpoint_Wrapper.php');

/*
  The Beyonic_Contact class provides access to the Contact API.
*/
class Beyonic_Contact extends Beyonic_Endpoint_Wrapper {

  protected static $endpoint = 'contacts';

}
?>
