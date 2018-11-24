<?php

/**
 * Developer : ZerosDev (http://www.zeros.co.id)
 * 
 */
 
namespace ZerosDev\RateLimiter;

use Illuminate\Http\Request;
use Exception;

class RateLimiter
{
    protected $limit = 1;
    protected $second = 1;
    protected $allowed = false;
    protected $lastHit = 0;
    protected $releaseTime = 0;
    protected $hitCount = 0;
    protected $hit = 0;
    protected $time = 0;
    
    public function __construct()
    {
        
    }
    
    public function limit($limit = 1)
    {
        $this->limit = $limit;
        return $this;
    }
    
    public function delay($second = 1)
    {
        $this->second = $second;
        return $this;
    }
    
    public function bind(Request $request)
    {
        $ip = $request->ip();
        
        if( empty($ip) ) {
            $this->allowed = false;
            return $this;
        }
        
        if( !filter_var($ip, FILTER_VALIDATE_IP) ) {
            $this->allowed = false;
            return $this;
        }
        
        $this->hitCount = @intval($request->session()->get('__zeros_rate_limiter__'));
        $this->lastHit = @intval($request->session()->get('__zeros_rate_limiter_last_hit__'));
        $this->releaseTime = $this->lastHit + $this->second;
        $this->time = time();
        
        if( empty($this->hitCount) ) {
            $this->hit = $this->limit > 1 ? 1 : $this->limit;
            $request->session()->put('__zeros_rate_limiter__', $this->hit);
            $request->session()->put('__zeros_rate_limiter_last_hit__', $this->time);
            $request->session()->save();
            $this->allowed = true;
            return $this;
        }
        elseif( $this->hitCount < $this->limit ) {
            $this->hit = $this->hitCount+1;
            $request->session()->put('__zeros_rate_limiter__', $this->hit);
            $request->session()->put('__zeros_rate_limiter_last_hit__', $this->time);
            $request->session()->save();
            $this->allowed = true;
            return $this;
        }
        elseif( $this->hitCount >= $this->limit ) {
            if( $this->time < $this->releaseTime )
            {
                $this->allowed = false;
            }
            else
            {
                $this->hit = $this->limit > 1 ? 1 : $this->limit;
                $request->session()->put('__zeros_rate_limiter__', $this->hit);
                $request->session()->put('__zeros_rate_limiter_last_hit__', $this->time);
                $request->session()->save();
                $this->allowed = true;
            }
            return $this;
        }
        else {
            $this->allowed = false;
            return $this;
        }
    }
    
    public function allowed()
    {
        if( $this->allowed ) {
            return true;
        }
        
        return false;
    }
    
    public function get()
    {
        return $this;
    }
}