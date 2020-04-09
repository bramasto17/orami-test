<?php

namespace App\Services;

use App\Models\Products;

class ProductsService extends \App\Services\BaseService
{
    public function __construct()
    {
    }

    public function getAll($attributes = [], $request)
    {
        $results = $this->queryBuilder(Products::class, $attributes, []);

        $results = $results->get()->toArray();

        return $results;
    }
}
