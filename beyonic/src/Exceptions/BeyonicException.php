<?php

namespace Beyonic\Exceptions;

use Exception;
/**
 * The BeyonicException class provides information on errors that may arise when using the Beyonic interface.
 */
class BeyonicException extends Exception 
{
    /**
     * @var string
     */
    public $requestURL;
    /**
     * @var string
     */
    public $requestMethod;

    /**
     * @var string
     */
    public $responseBody;

    /**
     * @param $message
     * @param $code
     * @param $requestURL
     * @param $requestMethod
     * @param $responseBody
     * @param Exception $previous
     * 
     * @return null
     */
    public function __construct($message, $code, $requestURL, $requestMethod, $responseBody, Exception $previous = null) 
    {
        parent::__construct($message, $code, $previous);
        $this->requestURL = $requestURL;
        $this->responseBody = $responseBody;
        $this->requestMethod = $requestMethod;
    }

    /**
     * Custom string representation of object
     */
    public function __toString() 
    {
        return __CLASS__ . " Error {$this->code}: {$this->message} when sending {$this->requestMethod} to {$this->requestURL}\n";
    }
}