<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table   = 'products';
    protected $guarded = array('id');
    protected $dates   = ['created_at', 'updated_at'];
    protected $hidden  = ['created_at', 'updated_at', 'stocks'];

    public function stocks()
    {
        return $this->hasMany('\App\Models\Stocks', 'productId', 'id');
    }

    public function toArray()
    {
    	return [
    		'productName' => $this->name,
    		'stocks' => [
    			'total' => $this->stocks->sum('stock'),
    			'detail' => $this->stocks->toArray()
    		]
    	];
    }

}
