<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'stock',
        'image',
        'description',
    ];

    // product -> belongs to category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // product -> many order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // product -> suppliers
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // product -> discount (optional)
    public function discount()
    {
        return $this->hasMany(Discount::class);
    }
}
