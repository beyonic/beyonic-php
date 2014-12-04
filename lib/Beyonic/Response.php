<?php

/*
  The BeyonicPayment class provides access to the Payment API.
*/
class Beyonic_Response {

  private $endpoint;

  function __construct( $jsonObject, $endpoint ) {

    foreach( $jsonObject as $prop => $value )
      $this->$prop = $value;

    $this->endpoint = $endpoint;
  }

  public function send() {

    $values = array();

    foreach( $this as $prop => $value )
      if( $prop != 'endpoint' )
        $values[$prop] = $value;

    return( Beyonic::sendRequest( $this->endpoint, 'PUT', $this->id, $values ) );

  }
}
?>
