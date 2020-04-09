<?php

namespace App\Modules\Middleware;

use Closure;

use Illuminate\Http\Request;

class XSSProtection
{
    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();
        
        array_walk_recursive($input, function (&$input) {
            $input = strip_tags($input);
        });
        
        $request->merge($input);
        
        return $next($request);
    }
}