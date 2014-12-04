<?php

require_once( dirname(__FILE__) . '/Endpoint_Wrapper.php' );

/*
  The BeyonicWebhook class provides access to list, create, add & delete
  Webhook callbacks.
*/
class Beyonic_Webhook extends Beyonic_Endpoint_Wrapper {

  protected static $endpoint = 'webhooks';

}
?>
