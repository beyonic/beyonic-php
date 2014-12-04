<?php

require_once( dirname(__FILE__) . '/Beyonic.php' );

/*
  The BeyonicEndpointWrapper class provides common routines needed by
  all interface classses.
*/
class Beyonic_Endpoint_Wrapper {

  protected static $endpoint = null;

  /* Get the associated object with $id */
  public static function get( $id ) {

    return( Beyonic::sendRequest( static::$endpoint, 'GET', $id ) );
  }

  /* Get all of the associated object with $id */
  public static function getAll( ) {

    return( Beyonic::sendRequest( static::$endpoint, 'GET', null ) );
  }

  /* Create the new object based on the $parameters */
  public static function create( $parameters ) {

    return( Beyonic::sendRequest( static::$endpoint, 'POST', null, $parameters ) );
  }

  /* Update the object associated with $id usjing $parameters */
  public static function update( $id, $parameters  ) {

    return( Beyonic::sendRequest( static::$endpoint, 'PUT', $id, $parameters ) );
  }

  /* Delete the object associated with $id */
  public static function delete( $id ) {

    return( Beyonic::sendRequest( static::$endpoint, 'DELETE', $id ) );
  }
}
?>
