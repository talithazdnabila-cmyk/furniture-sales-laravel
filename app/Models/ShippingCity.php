<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingCity extends Model
{
    protected $fillable = [
        'city_name',
        'shipping_cost'
    ];
}
