<?php

namespace Beyonic\Endpoint;

use Beyonic\Beyonic;

/**
 * The Wrapper class provides common routines needed by all interface classses.
 * @author Hamidouh Semix <semix.hamidouh@gmail.com>
 * @package Beyonic
 */
class Wrapper
{
  protected static $beyonic;
  protected $endpoint = null;
  protected static $instances;
  
  /**
   * @author Hamidouh Semix <semix.hamidouh@gmail.com>
   * @param string|null $jsonObject
   * @param Beyonic|null $beyonic
   */
  public function __construct($jsonObject = null, Beyonic $beyonic = null) 
  {
    static::$beyonic = $beyonic;
    if ($jsonObject != null)
      foreach ($jsonObject as $prop => $value)
        $this->$prop = $value;
  }
  /**
   * Return an Instance of the endpoint Object
   * 
   * @author Hamidouh Semix <semix.hamidouh@gmail.com>
   * @param null
   * @return static
   */
  final public static function instance()
  {
		$className = get_called_class();
		if (!isset(static::$instances[$className]))
			static::$instances[$className] = new $className(null, Beyonic::getInstance());

		return static::$instances[$className];
	}

  /**
   * Send any changes made as a PATCH Request
   * 
   * @author Hamidouh Semix <semix.hamidouh@gmail.com>
   * @param null
   * @return static
   */
  public function send() 
  {

    $values = array();
    foreach( $this as $prop => $value )
        $values[$prop] = $value;

    return $this->update($this->id, $values);
  }

  /**
   * Get the associated object with $id
   * 
   * @param int $id
   * @param array|null $parameters
   * 
   * @return static
   */
  public function get($id, array $parameters = null) 
  {
    return new static( 
      Beyonic::sendRequest(static::instance()->endpoint, 'GET', $id, $parameters),
      static::getBeyonic()
    );
  }


  /**
   * Get all of the associated object. Use $parameters (when available) to search for a subset
   * 
   * @param array|null $parameters
   */
  public function getAll(array $parameters = null) 
  {
    $resp = Beyonic::sendRequest(static::instance()->endpoint, 'GET', null, $parameters);
	  $all = array();
    $all["count"] = $resp->count;
    $all["next"] = $resp->next;
    $all["previous"] = $resp->previous;
   	$all["results"] = array();
    foreach ($resp->results as $index => $json)
      $all["results"][] = new static($json, static::getBeyonic());

    return($all);
  }

  /**
   * Create the new object based on the $parameters
   * 
   * @author Hamidouh Semix <semix.hamidouh@gmail.com>
   * @param array $parameters
   * @return static
   */
  public function create($parameters) 
  {
    return new static(
      Beyonic::sendRequest(static::instance()->endpoint, 'POST', null, $parameters),
      static::getBeyonic()
    );
  }

  /**
   * Return a static Beyonic object instance
   * 
   * @author Hamidouh Semix <semix.hamidouh@gmail.com>
   * @param null
   * @return Beyonic $beyonic
   */

  public function getBeyonic()
  {
    return static::$beyonic;
  }

  /**
   * Update the object associated with $id using $parameters
   * 
   * @author Hamidouh Semix <semix.hamidouh@gmail.com>
   * @param int $id
   * @param array $parameters
   * @return static
   */
  public function update($id, array $parameters)
  {
    return new static(
      Beyonic::sendRequest(static::instance()->endpoint, 'PATCH', $id, $parameters),
      static::getBeyonic()
    );
  }

  /**
   * Delete the object associated with $id
   * 
   * @author Hamidouh Semix <semix.hamidouh@gmail.com>
   * @param int $id
   * @return static
   */
  public function delete($id) 
  {
    new static(Beyonic::sendRequest(static::instance()->endpoint, 'DELETE', $id));
  }
}