<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $primaryKey = 'Cart_Item_ID';

    protected $fillable = [
        'User_ID', 'Product_ID', 'quantity', 'instance'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'User_ID');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'Product_ID');
    }

    /**
     * Get the effective price for this cart item (sale price if on sale, otherwise regular price).
     */
    public function getEffectivePriceAttribute()
    {
        if ($this->product && $this->product->is_on_sale && $this->product->sale_price) {
            return floatval($this->product->sale_price);
        }
        return floatval($this->product->regular_price ?? 0);
    }

    /**
     * Get the subtotal for this cart item (price * quantity).
     */
    public function getSubtotalAttribute()
    {
        return $this->effective_price * $this->quantity;
    }
}
