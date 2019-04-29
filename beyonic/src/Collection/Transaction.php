<?php

namespace Beyonic\Collection;

use Beyonic\Endpoint\Wrapper;

/**
 * The Transaction class provides access to the Transactions API.
 * 
 * @author Hamidouh Semix <semix.hamidouh@gmail.com>
 * @package Beyonic
 */
class Transaction extends Wrapper 
{
  protected $endpoint = 'transactions';
}
