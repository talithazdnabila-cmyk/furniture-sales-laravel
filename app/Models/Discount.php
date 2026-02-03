<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'category_id',
        'type',
        'value',
        'start_date',
        'end_date',
    ];

    // discount -> belongs to product (optional)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // discount -> belongs to category (optional)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
