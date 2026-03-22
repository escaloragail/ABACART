<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $primaryKey = 'Transaction_ID';

    public function order()
    {
        return $this->belongsTo(Order::class, 'Order_ID');
    }
}
