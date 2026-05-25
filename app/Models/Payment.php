<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'fullname',
        'mobile_number',
        'email',
        'reference_number',
        'amount',
        'proof_image',
        'notes',
    ];
}
