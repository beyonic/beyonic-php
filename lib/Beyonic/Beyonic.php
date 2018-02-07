<?php

require_once( dirname(__FILE__) . '/Beyonic_Exception.php' );

/*
  The Beyonic class provides manages the requests to the Beyonic endpoint.
*/
class Beyonic {

  public static $apiKey = null;
  public static $apiURL = 'https://app.beyonic.us/api';
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
   * getClientVersion - Get the client version
   */
  public static function getClientVersion() {
  	return BEYONIC_CLIENT_VERSION;
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
    if( $parameters != null ){
      $metadata = [];
      foreach($parameters as $key => $value){
        // if the key starts with 'metadata.', transform it to array notation
        if(strpos($key, 'metadata.') === 0){
          $metadata[explode('.', $key)[1]] = $value;
          unset($parameters[$key]);
        }
      }
      if($metadata){
        $parameters = array_merge($parameters, array('metadata'=>$metadata));
      }
      $jsonData = json_encode( $parameters );
    }

    $httpHeaders = array(
			'Content-Type: application/json',
			'Content-Language:en-US',
      		'Authorization: Token ' . self::$apiKey,
    		'Beyonic-Client: Php',
    		'Beyonic-Client-Version: ' . BEYONIC_CLIENT_VERSION
    );

    if( self::$apiVersion != null )
      $httpHeaders[] = 'Beyonic-Version: ' . self::$apiVersion;

		$ch = curl_init();
    switch ($method) {
      case 'GET':     if ( $parameters != null ) {
      					$requestURL .= "?";
      					foreach($parameters as $key=>$value) {
      						$requestURL .= $key . "=" . urlencode($value) . "&";
      					}
      				  }
      		          break;
      case 'POST':    curl_setopt($ch, CURLOPT_POST, 1);
                      if( $jsonData != null ) {
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                        $httpHeaders[] = 'Content-Length:' . strlen( $jsonData );
                      }
                      break;
      case 'PATCH':     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
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
    $responseArray['requestURL'] = $requestURL;
    $responseArray['httpResponseCode'] = curl_getinfo( $ch, CURLINFO_HTTP_CODE);

    $headerSize = curl_getinfo( $ch, CURLINFO_HEADER_SIZE);
    $responseArray['responseHeader'] = substr( $response, 0, $headerSize);
    $responseArray['responseBody'] = substr($response, $headerSize);

    self::$lastResult = $responseArray;

    if( $responseArray['httpResponseCode'] >= 400 ) {
      $headerArray = preg_split( "/\n/", $responseArray['responseHeader'] );
      throw new Beyonic_Exception( substr($headerArray[0],0,strlen($headerArray[0]) - 1 ),
                              $responseArray['httpResponseCode'],
                              $requestURL,
                              $method,
                              $responseArray['responseBody']
                    );
    }

    $endpointObject = json_decode( $responseArray['responseBody'] );

    return( $endpointObject );
  }
}
?>
