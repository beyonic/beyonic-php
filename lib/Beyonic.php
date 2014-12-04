<?php

/*
  The Beyonic class provides manages the requests to the Beyonic endpoint.
*/
class Beyonic {

  public static $apiKey = null;
  public static $apiURL = 'https://staging.beyonic.com/api';
  public static $apiVersion = 'v1';
  public static $lastResult = null;

  /*
    setAPIKey - Sets the API Key for this client / developer.
  */
  public static function setAPIKey( $newAPIKey ) {

    self::$apiKey = $newAPIKey;
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
      'Beyonic-Version: ' . self::$apiVersion
    );

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
      case 'PUT':     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
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
class BeyonicEndpointWrapper {

  protected static $endpoint = null;

  /* Make a GET request with the classes endpoint */
  protected static function getRequest( $id = null ) {

    return( Beyonic::sendRequest( static::$endpoint, 'GET', $id ) );
  }

  /* Make a POST request with the classes endpoint */
  protected static function postRequest( $parameters ) {

    return( Beyonic::sendRequest( static::$endpoint, 'POST', null, $parameters ) );
  }

  /* Make a PUT request with the classes endpoint */
  protected static function putRequest( $id, $parameters  ) {

    return( Beyonic::sendRequest( static::$endpoint, 'PUT', $id, $parameters ) );
  }

  /* Make a DELETE request with the classes endpoint */
  protected static function deleteRequest( $id = null ) {

    return( Beyonic::sendRequest( static::$endpoint, 'DELETE', $id ) );
  }
}

/*
  The BeyonicWebhook class provides access to list, create, add & delete
  Webhook callbacks.
*/
class BeyonicWebhook extends BeyonicEndpointWrapper {

  protected static $endpoint = 'webhooks';

  /* Add a new Webhook for the specified $event for the given $target */
  public static function create( $event, $target ) {

    $array = array( 'event' => $event, 'target' => $target );
    return( self::postRequest( $array ) );
  }

  /* Update the Webhook $id with $event and $target */
  public static function update( $id, $event, $target ) {

    $array = array( 'event' => $event, 'target' => $target );
    return( self::putRequest( $id, $array ) );
  }

  /* Delete the Webhook $id */
  public static function delete( $id ) {

    return( self::deleteRequest( $id ) );
  }

  /* Show all Webhooks or the one identified by $id */
  public static function get( $id = null ) {

    return( self::getRequest( $id ) );
  }
}

/*
  The BeyonicPayment class provides access to the Payment API.
*/
class BeyonicPayment extends BeyonicEndpointWrapper {

  protected static $endpoint = 'payments';

  /* Create a payment using the values provided in $array */
  public static function create( $array ) {

    return( self::postRequest( $array ) );
  }

}
?>
