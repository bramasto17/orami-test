<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    protected $table   = 'locations';
    protected $guarded = array('id');
    protected $dates   = ['created_at', 'updated_at'];
    protected $hidden  = ['created_at', 'updated_at'];
}
