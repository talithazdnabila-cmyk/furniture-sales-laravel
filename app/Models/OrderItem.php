<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'price',
    ];

    // order_item -> belongs to order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // order_item -> belongs to product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
