<?php

require_once( dirname(__FILE__) .  '/Endpoint_Wrapper.php');

/*
  The Beyonic_Collection_Request class provides access to the Collection Request API.
*/
class Beyonic_Collection_Request extends Beyonic_Endpoint_Wrapper {

  protected static $endpoint = 'collectionrequests';

}
?>
