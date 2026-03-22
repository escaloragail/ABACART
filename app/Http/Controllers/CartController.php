<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        if(\Illuminate\Support\Facades\Auth::check())
        {
            Cart::instance('cart')->restore(\Illuminate\Support\Facades\Auth::user()->User_ID);
        }
        $items = Cart::instance('cart')->content();
        return view('cart', compact('items'));
    }

    public function add_to_cart(Request $request)
    {
        Cart::instance('cart')->add($request->id, $request->name, $request->quantity, $request->price)->associate('App\Models\Product');
        if(\Illuminate\Support\Facades\Auth::check())
        {
            Cart::instance('cart')->store(\Illuminate\Support\Facades\Auth::user()->User_ID);
        }
        return redirect()->back()->with('success', 'Item has been added to cart!');
    }

    public function increase_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId, $qty);
        if(\Illuminate\Support\Facades\Auth::check())
        {
            Cart::instance('cart')->store(\Illuminate\Support\Facades\Auth::user()->User_ID);
        }
        $this->calculateDiscount();
        return redirect()->back();
    }

    public function decrease_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        Cart::instance('cart')->update($rowId, $qty);
        if(\Illuminate\Support\Facades\Auth::check())
        {
            Cart::instance('cart')->store(\Illuminate\Support\Facades\Auth::user()->User_ID);
        }
        $this->calculateDiscount();
        return redirect()->back();
    }

    public function remove_item($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        if(\Illuminate\Support\Facades\Auth::check())
        {
            Cart::instance('cart')->store(\Illuminate\Support\Facades\Auth::user()->User_ID);
        }
        $this->calculateDiscount();
        return redirect()->back();
    }

    public function empty_cart()
    {
        Cart::instance('cart')->destroy();
        if(\Illuminate\Support\Facades\Auth::check())
        {
            Cart::instance('cart')->store(\Illuminate\Support\Facades\Auth::user()->User_ID);
        }
        \Illuminate\Support\Facades\Session::forget('coupon');
        \Illuminate\Support\Facades\Session::forget('discounts');
        return redirect()->back();
    }

    public function apply_coupon(Request $request)
    {
        $coupon_code = $request->coupon_code;
        if(isset($coupon_code))
        {
            $cart_subtotal = floatval(str_replace(',', '', Cart::instance('cart')->subtotal()));
            $coupon = \App\Models\Coupon::where('code', $coupon_code)
                ->where('expiry_date', '>=', \Carbon\Carbon::today())
                ->where('cart_value', '<=', $cart_subtotal)
                ->first();
                
            if(!$coupon)
            {
                return redirect()->back()->with('error', 'Invalid coupon code or cart value is less than coupon minimum value');
            }
            else
            {
                \Illuminate\Support\Facades\Session::put('coupon', [
                    'code' => $coupon->code,
                    'type' => $coupon->type,
                    'value' => $coupon->value,
                    'cart_value' => $coupon->cart_value
                ]);
                $this->calculateDiscount();
                return redirect()->back()->with('success', 'Coupon has been applied!');
            }
        }
    }

    public function calculateDiscount()
    {
        $discount = 0;
        if(\Illuminate\Support\Facades\Session::has('coupon'))
        {
            $cart_subtotal = floatval(str_replace(',', '', Cart::instance('cart')->subtotal()));
            
            if(\Illuminate\Support\Facades\Session::get('coupon')['type'] == 'fixed')
            {
                $discount = \Illuminate\Support\Facades\Session::get('coupon')['value'];
            }
            else
            {
                $discount = ($cart_subtotal * \Illuminate\Support\Facades\Session::get('coupon')['value'])/100;
            }

            $subtotalAfterDiscount = $cart_subtotal - $discount;
            $taxAfterDiscount = ($subtotalAfterDiscount * config('cart.tax', 21))/100;
            $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;

            \Illuminate\Support\Facades\Session::put('discounts', [
                'discount' => number_format(floatval($discount), 2, '.', ''),
                'subtotal' => number_format(floatval($subtotalAfterDiscount), 2, '.', ''),
                'tax' => number_format(floatval($taxAfterDiscount), 2, '.', ''),
                'total' => number_format(floatval($totalAfterDiscount), 2, '.', '')
            ]);
        }
    }

    public function remove_coupon()
    {
        \Illuminate\Support\Facades\Session::forget('coupon');
        \Illuminate\Support\Facades\Session::forget('discounts');
        return redirect()->back()->with('success', 'Coupon has been removed!');
    }
}
