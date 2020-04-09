<?php

namespace App\Modules\Middleware;

use Closure;

class PublicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $headers = [
            'Authorization' => $request->header('Authorization'),
            'Accept'        => 'application/json'
        ];
        
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->get(config('app.auth_api') . '/v1/auth/user', [
                'headers' => $headers,
                'http_errors' => false
            ]);

            if ($response->getStatusCode() == 200) {
                $request->merge(['user' => json_decode($response->getBody())]);
            }
            
        } catch (Exception $e) {
            
        }
        


        return $next($request);
    }
}
