<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GreenpayAccount extends Model
{
    protected $fillable = [
        'User_ID',
        'fullname',
        'mobile_number',
        'email',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID');
    }
}
