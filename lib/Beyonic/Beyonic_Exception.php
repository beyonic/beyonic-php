<?php

/*
  The Beyonic_Exception class provides information on errors that may arise
  when using the Beyonic interface.
*/

class Beyonic_Exception extends Exception {

  public $requestURL;
  public $requestMethod;
  public $responseBody;

  public function __construct($message, $code, $requestURL, $requestMethod, $responseBody, Exception $previous = null) {

    parent::__construct($message, $code, $previous);

    $this->requestURL = $requestURL;
    $this->responseBody = $responseBody;
    $this->requestMethod = $requestMethod;

  }

  // custom string representation of object
  public function __toString() {
    return __CLASS__ . " Error {$this->code}: {$this->message} when sending {$this->requestMethod} to {$this->requestURL}.\nError Details: {$this->responseBody}\n";
  }
}
?>
