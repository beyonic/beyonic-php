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

    $endpointObject = json_decode( $responseArray['responseJSON'] );

    if( $endpointObject != NULL )
      if( is_array( $endpointObject ) )
        foreach( $endpointObject as $index => $object )
          $endpointObject[$index] = new Beyonic_Response( $object, $endpoint );
      else
          $endpointObject = new Beyonic_Response( $endpointObject, $endpoint );

    return( $endpointObject );
  }
}
?>
