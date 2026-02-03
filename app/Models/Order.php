<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_price',
        'payment_type',
        'status',
        'order_date',
    ];

    // order -> belongs to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // order -> many order items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
