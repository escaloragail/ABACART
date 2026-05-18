<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $primaryKey = 'Order_Item_ID';

    public function product()
    {
        return $this->belongsTo(Product::class, 'Product_ID');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'Order_ID');
    }
}
