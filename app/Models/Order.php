<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'Order_ID';

    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'Coupon_ID');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'Order_ID');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'Order_ID');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'Address_ID');
    }
}
