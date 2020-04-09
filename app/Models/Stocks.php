<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    protected $table   = 'stocks';
    protected $guarded = array('id');
    protected $dates   = ['created_at', 'updated_at'];
    protected $hidden  = ['id','productId','created_at', 'updated_at'];

    public function location()
    {
        return $this->belongsTo('\App\Models\Locations', 'locationId', 'id');
    }

    public function toArray()
    {
        return [
            'location' => $this->location->name,
            'stock' => $this->stock,
        ];
    }
}
