<?php

namespace Beyonic;

use Beyonic\Endpoint\Wrapper;
use Beyonic\Exceptions\BeyonicException;
use Beyonic\Exceptions\NotFoundException;

/**
 * The Beyonic class provides manages the requests to the Beyonic endpoint.
 * @author Hamidouh Semix <semix.hamidouh@gmail.com>
 * @package Beyonic
 */
class Beyonic 
{
    const CLIENT_VERSION = "0.0.6";
    protected $apiKey = null;
    protected $apiURL = 'https://app.beyonic.com/api';
    protected $apiVersion = null;
    protected $lastResult = null;
    protected $wrapper;

    protected static $instance;
    protected $methods = [
        'request', 
        'payment', 
        'contact', 
        'contact', 
        'collection', 
        'account', 
        'webHook', 
        'transaction'
    ];

    /**
     * @author Hamidouh Semix <semix.hamidouh@gmail.com>
     * @param string|null $apiKey
     * @param string $apiUri
     * @param string|null $lastResult
     * @param string|null $apiVersion
     */
    public function __construct($apiKey = null, $apiUri = 'https://app.beyonic.com/api', $lastResult = null, $apiVersion = null)
    {
        $this->apiKey       = $apiKey;
        $this->apiURL       = $apiUri;
        $this->apiVersion   = $apiVersion;
        $this->lastResult   = $lastResult;
        $this->wrapper = new Wrapper();
        if (!static::$instance) {
            static::$instance = $this;
        }
    }

    /**
     * Return a static instance of the Beyonic object through out the request
     * 
     * @author Hamidouh Semix <semix.hamidouh@gmail.com>
     * @param null
     * @return static $instance
     */

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            throw new NotFoundException(sprintf("No instance of %s was found, create one to proceed", static::class));
        }
        return static::$instance;
    }

    /**
     * setAPIKey - Sets the API Key for this client / developer
     * 
     * @author Hamidouh Semix <semix.hamidouh@gmail.com>
     * @param string|null $newApiKey
     * @return void
     */
    public function setApiKey($newApiKey = null) 
    {
        $this->apiKey = $newApiKey;
    }

    /**
     * Return the apiKey that was set
     * 
     * @author Hamidouh Semix <semix.hamidouh@gmail.com>
     * @param null
     * @return string|null $apiKey
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * setAPIVersion - Sets the API Version for this client / developer.
     * 
     * @author Hamidouh Semix <semix.hamidouh@gmail.com>
     * @param string|null $newApiVersion
     * @return void
     */
    public function setApiVersion($newApiVersion = null) 
    {
        $this->apiVersion = $newApiVersion;
    }
    /**
     * Return the apiVersion that was set
     * 
     * @author Hamidouh Semix <semix.hamidouh@gmail.com>
     * @param null
     * @return string|null $apiVersion
     */
    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    /**
     * Return the client version
     * 
     * @author Hamidouh Semix <semix.hamidouh@gmail.com>
     * @param null
     * @return string
     */
    public static function getClientVersion() 
    {
        return self::CLIENT_VERSION;
    }

    /**
     * sendRequest - Sends a REST request to the Beyonic API endpoint.
     * $endpoint is the endpoint that is the target of the request.
     * $method is one of GET, POST, PUT or DELETE.
     * $id is used to identify the target of a GET, PUT or DELETE request.
     * $parameters is used for POST and PUT, are content is based on the request.
     * 
     * @author Hamidouh Semix <semix.hamdiouh@gmail.com>
     * @param string $endpoint
     * @param string $method
     * @param int|null $id
     * @param array|null $parameters
     * @return mixed $endpointObject
     */
    public function sendRequest($endpoint, $method = 'GET', $id = null, array $parameters = null) 
    {
        $beyonic = static::getInstance();
        $requestURL = $beyonic->apiURL . '/' . $endpoint;
        if( $id != null )
            $requestURL .= '/' . $id;

        $jsonData = null;
        if ($parameters != null ) {
            $metadata = [];
            foreach($parameters as $key => $value) {
                // if the key starts with 'metadata.', transform it to array notation
                if (strpos($key, 'metadata.') === 0) {
                    $metadata[explode('.', $key)[1]] = $value;
                    unset($parameters[$key]);
                }
            }
            if ($metadata) {
                $parameters = array_merge($parameters, ['metadata'=>$metadata]);
            }
            $jsonData = json_encode($parameters);
        }

        $httpHeaders = [
            'Content-Type: application/json',
            'Content-Language:en-US',
            'Authorization: Token ' . $beyonic->apiKey,
            'Beyonic-Client: Php',
            'Beyonic-Client-Version: ' . self::CLIENT_VERSION
        ];

        if ($beyonic->apiVersion != null)
            $httpHeaders[] = 'Beyonic-Version: ' . $beyonic->apiVersion;

        $ch = curl_init();
        switch ($method) {
            case 'GET':     
                if ($parameters != null) {
                    $requestURL .= "?";
                    foreach($parameters as $key=>$value) {
                        $requestURL .= $key . "=" . urlencode($value) . "&";
                    }
                }
                break;
            case 'POST':    
                curl_setopt($ch, CURLOPT_POST, 1);
                if ($jsonData != null) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                    $httpHeaders[] = 'Content-Length:' . strlen( $jsonData );
                }
                break;
            case 'PATCH':     
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                if ($jsonData != null) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                    $httpHeaders[] = 'Content-Length:' . strlen( $jsonData );
                }
                break;
            case 'DELETE':  
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }

        $endpointObject = $beyonic->send($ch, $requestURL, $httpHeaders, $method);

        return $endpointObject;
    }

    /**
     * Send a request to an endpoint
     * 
     * @author Hamidouh Semix <semix.hamidouh@gmail.com>
     * @param string $ch
     * @param string $requestURL
     * @param array $httpHeaders
     * @param string $method
     * @return string json
     */
    protected function send($ch, $requestURL, $httpHeaders, $method)
    {
        curl_setopt($ch, CURLOPT_URL, $requestURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeaders);

        $response                           = curl_exec($ch);
        $responseArray                      = [];
        $responseArray['requestURL']        = $requestURL;
        $responseArray['httpResponseCode']  = curl_getinfo( $ch, CURLINFO_HTTP_CODE);
        $headerSize                         = curl_getinfo( $ch, CURLINFO_HEADER_SIZE);
        $responseArray['responseHeader']    = substr( $response, 0, $headerSize);
        $responseArray['responseBody']      = substr($response, $headerSize);

        $this->lastResult = $responseArray;

        if( $responseArray['httpResponseCode'] >= 400 ) {
            $headerArray = preg_split( "/\n/", $responseArray['responseHeader'] );
            throw new BeyonicException(
                substr($headerArray[0],0,strlen($headerArray[0]) - 1),
                $responseArray['httpResponseCode'],
                $requestURL,
                $method,
                $responseArray['responseBody']
            );
        }

        return json_decode($responseArray['responseBody']);
    }

    /**
     * Return all endpoints to be accessed as methods for a bridge
     * to the endpoint objects
     * 
     * @author Hamidouh Semix <semix.hamidouh@gmail.com>
     * @param null
     * @return array $methods
     */

    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * Build Dynamic methods to simplify the acces of all endpoints of the api
     * And make all methods accessible with a class instance
     * 
     * @author Hamidouh Semix <semix.hamidouh@gmail.com>
     * @param string $method
     * @param mixed $parameters
     * @return \Beyonic\Endpoint\Wrapper
     * @throws \Beyonic\Exceptions\NotFoundException
     */
    public function __call($method, $parameters)
    {
        if (in_array($method, $this->getMethods())) {
            $endPoint = '\\Beyonic\\Collection\\'. ucfirst($method);
            return $this->wrapper = new $endPoint(null, $this);
        }
        throw new NotFoundException(sprintf("The method: %s doesn't exist in class: %s", $method, static::class));
    }

    /**
     * Build Dynamic methods to simplify the acces of all endpoints of the api
     * And make all methods accessible statically, i.e no need for a class instance
     * 
     * @author Hamidouh Semix <semix.hamidouh@gmail.com>
     * @param string $method
     * @param mixed $parameters
     * @return \Beyonic\Endpoint\Wrapper
     * @throws \Beyonic\Exceptions\NotFoundException
     */
    public static function __callStatic($method, $parameters)
    {
        $instance = static::getInstance();
        if (in_array($method, $instance->getMethods())) {
            $endPoint = '\\Beyonic\\Collection\\'. ucfirst($method);  
            return $instance->wrapper = new $endPoint(null, $instance);
        }
        throw new NotFoundException(sprintf("The method: %s doesn't exist in class: %s", $method, static::class));
    }
}