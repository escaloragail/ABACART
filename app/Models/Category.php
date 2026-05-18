<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'Category_ID';

    public function products()
    {
        return $this->hasMany(Product::class, 'Category_ID');
    }
}
