<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductsService;

class ProductsController extends Controller
{
    private $productsService;

    public function __construct(ProductsService $productsService)
    {
        $this->productsService = $productsService;
    }

    public function getAll(Request $request)
    {
        $attributes = $request->all();
        $res = $this->productsService->getAll($attributes, $request);

        return response($res);
    }
}
