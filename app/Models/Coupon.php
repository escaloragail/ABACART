<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $primaryKey = 'Coupon_ID';

    public function orders()
    {
        return $this->hasMany(Order::class, 'Coupon_ID');
    }
}
