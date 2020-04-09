<?php

namespace App\Services;

use Closure;

class BaseService
{
    public function __construct()
    {
        
    }

    protected function atomic(Closure $callback)
    {
        return \DB::transaction($callback);
    }

    protected function dataWrapper($data)
    {
        $results = [];

        $results['data'] = $data['data'];

        unset($data['data']);

        $results['meta'] = $data;

        return $results;
    }

    protected function queryBuilder($baseQuery, $attributes, $includes = [])
    {
        if (is_string($baseQuery)) {
            $baseQuery = ($baseQuery)::query();
        }

        $sort = (@$attributes['sort']) ? $attributes['sort'] : null;
        $sortRule = (@$attributes['sort_rule']) ? $attributes['sort_rule'] : null;

        $baseQuery = $baseQuery->with($includes);

        return $baseQuery;
    }

    protected function call($method, $url, $data, $token = null)
    {

        $headers = [
            'Authorization' => $token,
            'Accept'        => 'application/json'
        ];

        $client = new \GuzzleHttp\Client();

        if ($method == 'GET')
        {
            $parameters = [
                'headers' => $headers
            ];
        }
        else
        {
            $parameters = [
                'auth'        => [ config('app.package_user'), config('app.package_pass') ],
                'headers'     => $headers, 
                'form_params' => $data
            ];
        }

        $response = $client->request($method, $url, $parameters);

        if ($response->getStatusCode() != 200) 
        {
            return response('Unauthorized.', 401);
        }

        return json_decode($response->getBody());
    }
}
