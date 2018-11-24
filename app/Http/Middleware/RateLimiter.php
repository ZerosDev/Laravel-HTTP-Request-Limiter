<?php

namespace App\Http\Middleware;

use Closure, ZerosRateLimiter;

class RateLimiter
{
    public function handle($request, Closure $next)
    {
        $rl = ZerosRateLimiter::limit(3)->delay(1)->bind($request); // 3 Requests per 1 Second
        
        if( !$rl->allowed() ) {
            abort(429, 'Too Many Request');
        }
        
        return $next($request);
    }
}

?>