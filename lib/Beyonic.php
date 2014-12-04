<?php

/*
  The Beyonic class provides manages the requests to the Beyonic endpoint.
*/
class Beyonic {

  public static $apiKey = null;
  public static $apiURL = 'https://staging.beyonic.com/api';
  public static $apiVersion = null;
  public static $lastResult = null;

  /*
    setAPIKey - Sets the API Key for this client / developer.
  */
  public static function setApiKey( $newApiKey ) {

    self::$apiKey = $newApiKey;
  }

  /*
    setAPIVersion - Sets the API Version for this client / developer.
  */
  public static function setApiVersion( $newApiVersion ) {

    self::$apiVersion = $newApiVersion;
  }

  /*
    sendRequest - Sends a REST request to the Beyonic API endpoint.
      $endpoint is the endpoint that is the target of the request.
      $method is one of GET, POST, PUT or DELETE.
      $id is used to identify the target of a GET, PUT or DELETE request.
      $parameters is used for POST and PUT, are content is based on the request.
  */
  public static function sendRequest( $endpoint, $method = 'GET', $id = null, $parameters = null) {

    $requestURL = self::$apiURL . '/' . $endpoint;
    if( $id != null )
      $requestURL .= '/' . $id;

    $jsonData = null;
    if( $parameters != null )
      $jsonData = json_encode( $parameters );

    $httpHeaders = array(
			'Content-Type: application/json',
			'Content-Language:en-US',
      'Authorization: Token ' . self::$apiKey,
    );

    if( self::$apiVersion != null )
      $httpHeaders[] = 'Beyonic-Version: ' . self::$apiVersion;

		$ch = curl_init();
    switch ($method) {
      case 'GET':     if( $id != null ) $requestURL .= '/' . $id;
                      break;
      case 'POST':    curl_setopt($ch, CURLOPT_POST, 1);
                      if( $jsonData != null ) {
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                        $httpHeaders[] = 'Content-Length:' . strlen( $jsonData );
                      }
                      break;
      case 'PUT':     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                      if( $jsonData != null ) {
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                        $httpHeaders[] = 'Content-Length:' . strlen( $jsonData );
                      }
                      break;
      case 'DELETE':  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                      break;
    }


    curl_setopt($ch, CURLOPT_URL, $requestURL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeaders);

    $response = curl_exec($ch);

    $responseArray = array();
    $responseArray['httpResponseCode'] = curl_getinfo( $ch, CURLINFO_HTTP_CODE);

    $headerSize = curl_getinfo( $ch, CURLINFO_HEADER_SIZE);
    $responseArray['responseJSON'] = substr($response, $headerSize);

    self::$lastResult = $responseArray;

    return( json_decode( $responseArray['responseJSON'] ) );
  }
}

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

/*
  The BeyonicWebhook class provides access to list, create, add & delete
  Webhook callbacks.
*/
class Beyonic_Webhook extends Beyonic_Endpoint_Wrapper {

  protected static $endpoint = 'webhooks';

}

/*
  The BeyonicPayment class provides access to the Payment API.
*/
class Beyonic_Payment extends Beyonic_Endpoint_Wrapper {

  protected static $endpoint = 'payments';

}
?>
