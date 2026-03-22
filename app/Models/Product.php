<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'Product_ID';
    protected $fillable = [
        'Category_ID', 'product_name', 'product_slug', 'short_description', 
        'product_description', 'regular_price', 'sale_price', 'SKU', 
        'stock_status', 'featured', 'quantity', 'main_product_image', 'sub_product_images', 'is_on_sale'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'Category_ID');
    }


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
