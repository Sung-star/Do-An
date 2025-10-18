<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    // ✅ Bảng trong database
    protected $table = 'orderitems';

    // ✅ Cho phép gán hàng loạt các trường
    protected $fillable = [
        'orderid',
        'productid',
        'quantity',
        'price',
        'color',
        'version',
    ];

    // 🔗 Quan hệ với bảng Orders
    public function order()
    {
        return $this->belongsTo(Order::class, 'orderid', 'id');
    }

    // 🔗 Quan hệ với bảng Products
    public function product()
    {
        return $this->belongsTo(Product::class, 'productid', 'id');
    }
}
