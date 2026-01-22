<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";
    protected $fillable = [
        'user_id',
        'order_number',
        'subtotal',
        'discount_percent',
        'discount_amount',
        'gst_percent',
        'gst_amount',
        'grand_total',
        'payment_method',
        'payment_status',
        'order_status',
        'customer_name',
        'email',
        'phone',
        'address',
        'pincode'
    ];

    public function getcustomer()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

     public function orderitem()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
}
