<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'coupon_id',
        'customerid',
        'order_status_id',
        'order_approved_at',
        'order_delivered_carrier_date',
        'order_delivered_customer_date',
        'created_at',
        'updated_by',
        'payment_method',
        'status',
        'total_amount',
        'description',
        // ✅ Thêm thông tin khách hàng snapshot
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_address',
    ];

    // ✅ Quan hệ khách hàng
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerid', 'id');
    }

    // ✅ Quan hệ sản phẩm
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'orderid', 'id');
    }

    // ✅ Tổng tiền
    public function getTotalAmountAttribute()
    {
        return $this->items->sum(fn($item) => $item->quantity * $item->price);
    }
}
