<?php

namespace Beyonic\Collection;
/**
 * The BeyonicPayment class provides access to the Payment API.
 * 
 * @author Hamidouh Semix <semix.hamidouh@gmail.com>
 * @package Beyonic
 */
class Response
{
  private $endpoint;
  
  /**
   * @author Hamidouh Semix <semix.hamidouh@gmail.com>
   * @param $jsonObject
   * @param $endpoint
   */
  public function __construct($jsonObject, $endpoint) 
  {
    $this->endpoint = $endpoint;
    foreach ($jsonObject as $prop => $value)
      $this->$prop = $value;
  }

  /**
   * Return the Beyonic->sendRequest Object
   * 
   * @author Hamidouh Semix <semix.hamidouh@gmail.com>
   * @param null
   * @return mixed
   */
  
  public function send() 
  {
    $values = [];
    foreach ($this as $prop => $value)
      if ($prop != 'endpoint')
        $values[$prop] = $value;

    return Beyonic::sendRequest($this->endpoint, 'PUT', $this->id, $values);
  }
}