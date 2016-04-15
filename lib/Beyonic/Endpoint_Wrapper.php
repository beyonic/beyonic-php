<?php

require_once( dirname(__FILE__) . '/Beyonic.php' );

/*
  The Beyonic_Endpoint_Wrapper class provides common routines needed by
  all interface classses.
*/
class Beyonic_Endpoint_Wrapper {

  protected static $endpoint = null;

  function __construct( $jsonObject ) {

    if( $jsonObject != null )
      foreach( $jsonObject as $prop => $value )
        $this->$prop = $value;
  }

  /* Send any changes made as a PATCH Request */
  public function send() {

    $values = array();

    foreach( $this as $prop => $value )
        $values[$prop] = $value;

    return( $this->update( $this->id, $values ) );

  }

  /* Get the associated object with $id */
  public static function get( $id, $parameters = null ) {

    return( new static( Beyonic::sendRequest( static::$endpoint, 'GET', $id, $parameters  ) ) );
  }

  /* Get all of the associated object */
  /* Use $parameters (when available) to search for a subset */
  public static function getAll( $parameters = null ) {

    $resp = Beyonic::sendRequest( static::$endpoint, 'GET', null, $parameters );
	
	$all = array();
    $all["count"] = $resp->count;
    $all["next"] = $resp->next;
    $all["previous"] = $resp->previous;
   	$all["results"] = array();
    foreach( $resp->results as $index => $json )
      $all["results"][] = new static( $json );

    return( $all );
  }

  /* Create the new object based on the $parameters */
  public static function create( $parameters ) {

    return( new static( Beyonic::sendRequest( static::$endpoint, 'POST', null, $parameters ) ) );
  }

  /* Update the object associated with $id usjing $parameters */
  public static function update( $id, $parameters  ) {

    return( new static( Beyonic::sendRequest( static::$endpoint, 'PATCH', $id, $parameters ) ) );
  }

  /* Delete the object associated with $id */
  public static function delete( $id ) {

    new static( Beyonic::sendRequest( static::$endpoint, 'DELETE', $id ) );
  }
}
?>
