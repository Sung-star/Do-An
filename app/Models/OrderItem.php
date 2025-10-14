<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    // ✅ Khai báo tên bảng thực tế trong DB
    protected $table = 'orderitems';

    protected $fillable = [
        'orderid',
        'productid',
        'quantity',
        'price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderid', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'productid', 'id');
    }
}
