<?php

namespace App\Modules\Middleware;

use Closure;

class ServerHeader
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $response->header('Server', 'X-Engine');
        $response->header('X-Powered-By', 'umroh.com');

        return $response;
    }
}
