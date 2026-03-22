<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        if(Cart::instance('cart')->count() == 0)
        {
            return redirect()->route('cart.index');
        }

        $addresses = \App\Models\Address::where('User_ID', Auth::user()->User_ID)->orderBy('Address_ID', 'DESC')->get();
        return view('checkout', compact('addresses'));
    }

    public function place_order(Request $request)
    {
        $user_id = Auth::user()->User_ID;

        if ($request->address_id == 'new' || !$request->has('address_id')) {
            $request->validate([
                'Zone_Street_HouseNumber' => 'required',
                'Barangay' => 'required',
                'City' => 'required',
                'Province' => 'required',
                'address_type' => 'required'
            ]);

            // Save New Address
            $address = new \App\Models\Address();
            $address->User_ID = $user_id;
            $address->Zone_Street_HouseNumber = $request->Zone_Street_HouseNumber;
            $address->Barangay = $request->Barangay;
            $address->City = $request->City;
            $address->Province = $request->Province;
            $address->address_type = $request->address_type;
            $address->save();
        } else {
            $request->validate([
                'address_id' => 'required|exists:addresses,Address_ID'
            ]);
            $address = \App\Models\Address::find($request->address_id);
            if (!$address || $address->User_ID != $user_id) {
                return back()->with('error', 'Selected address is invalid.');
            }
        }

        // Calculate Totals
        $subtotal = floatval(str_replace(',', '', Cart::instance('cart')->subtotal()));
        $tax = floatval(str_replace(',', '', Cart::instance('cart')->tax()));
        $total = floatval(str_replace(',', '', Cart::instance('cart')->total()));
        $discount = 0;

        if(Session::has('coupon')) {
            $discount = floatval(Session::get('discounts')['discount']);
            $subtotal = floatval(Session::get('discounts')['subtotal']);
            $tax = floatval(Session::get('discounts')['tax']);
            $total = floatval(Session::get('discounts')['total']);
        }

        // Validate Stock
        foreach(Cart::instance('cart')->content() as $item) {
            $product = \App\Models\Product::find($item->id);
            if(!$product || $product->quantity < $item->qty) {
                return redirect()->back()->with('error', 'Product ' . ($product ? $product->product_name : 'Unknown') . ' does not have enough stock!');
            }
        }

        // Save Order
        $order = new \App\Models\Order();
        $order->User_ID = $user_id;
        $order->Address_ID = $address->Address_ID;
        if(Session::has('coupon')) {
            $coupon = \App\Models\Coupon::where('code', Session::get('coupon')['code'])->first();
            $order->Coupon_ID = $coupon ? $coupon->Coupon_ID : null;
        } else {
            $order->Coupon_ID = null;
        }
        $order->subtotal = $subtotal;
        $order->discount = $discount;
        $order->tax = $tax;
        $order->total = $total;
        $order->note = $request->note; // Save message for admin
        $order->order_status = 'ordered';
        $order->is_shipping_different = false;
        $order->save();

        // Save Order Items and Deduct Stock
        foreach(Cart::instance('cart')->content() as $item) {
            $orderItem = new \App\Models\OrderItem();
            $orderItem->Order_ID = $order->Order_ID;
            $orderItem->Product_ID = $item->id;
            $orderItem->price = $item->price;
            $orderItem->quantity = $item->qty;
            $orderItem->options = $item->options ? serialize($item->options) : null;
            $orderItem->save();

            // Deduct Stock
            $product = \App\Models\Product::find($item->id);
            if ($product) {
                $product->quantity = $product->quantity - $item->qty;
                $product->save();
            }
        }

        // Save Transaction
        $transaction = new \App\Models\Transaction();
        $transaction->Order_ID = $order->Order_ID;
        $transaction->payment_mode = $request->payment_mode ?? 'cod';
        $transaction->status = 'pending';
        $transaction->save(); 

        // Clear Cart & Session
        Cart::instance('cart')->destroy();
        Session::forget('coupon');
        Session::forget('discounts');

        return redirect()->route('user.index')->with('success', 'Your order has been placed successfully!');
    }
}
