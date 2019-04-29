<?php

namespace Beyonic\Collection;

use Beyonic\Endpoint\Wrapper;

/**
 * The WebHook class provides access to list, create, add & delete WebHook callbacks.
 * 
 * @author Hamidouh Semix <semix.hamidouh@gmail.com>
 * @package Beyonic
 */
class WebHook extends Wrapper
{
  protected $endpoint = 'webhooks';
}
