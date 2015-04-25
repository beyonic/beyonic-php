<?php

require_once( dirname(__FILE__) .  '/Endpoint_Wrapper.php');

/*
  The Beyonic_Collection class provides access to the Collection API.
*/
class Beyonic_Collection extends Beyonic_Endpoint_Wrapper {

  protected static $endpoint = 'collections';

  public static function claim( $amount, $phonenumber, $remote_transaction_id ) {

    $claim_parameters = array (
      'claim'         => 'true',
      'amount'        => $amount,
      'phonenumber'   => $phonenumber,
      'remote_transaction_id' => $remote_transaction_id
    );

    return self::getAll( $claim_parameters );
  }

}
?>
