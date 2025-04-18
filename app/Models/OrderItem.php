<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id',
        'product_id',
        'quantity',
        'price',
        'total'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id'); // Sử dụng product_id nếu trường này tồn tại
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
