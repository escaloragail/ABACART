<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $primaryKey = 'Address_ID';

    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID');
    }
}
