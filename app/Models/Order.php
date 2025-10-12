<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Các trường được gán hàng loạt
    protected $fillable = [
        'customerid',
        'description',
        'status',   // Trạng thái đơn
        'payment_method',   // 👈 thêm dòng này

    ];

    /**
     * Quan hệ tới khách hàng
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerid', 'id');
    }

    /**
     * Quan hệ tới các sản phẩm trong đơn hàng
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'orderid', 'id');
    }

    /**
     * Accessor: tính tổng tiền từ các item
     * -> $order->total_amount sẽ trả về tổng
     */
    public function getTotalAmountAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    }
}
