<?php

/**
 * Developer : ZerosDev (http://www.zeros.co.id)
 * 
 */
 
namespace ZerosDev\RateLimiter;

use Illuminate\Support\Facades\Facade;

class RateLimiterFacade extends Facade
{
	protected static function getFacadeAccessor() {
	    return 'RateLimiter';
	}
}