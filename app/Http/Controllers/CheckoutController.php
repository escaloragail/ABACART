<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\Product;
use App\Models\Coupon;

class CheckoutController extends Controller
{
    // STEP 02: Shipping Details
    public function index()
    {
        $cartItems = CartItem::where('User_ID', Auth::user()->User_ID)
            ->where('instance', 'cart')
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index');
        }

        $addresses = Address::where('User_ID', Auth::user()->User_ID)->get();
        return view('checkout', compact('addresses', 'cartItems'));
    }

            // STEP 03: Order Review (The new "Confirmation" step)
        // STEP 03: Order Review (The new "Confirmation" step)
        public function review(Request $request)
        {
            $userId = Auth::user()->User_ID;
            $cartItems = CartItem::where('User_ID', $userId)
                ->where('instance', 'cart')
                ->with('product')
                ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index');
            }

    // Capture address choice from Step 02
    $addressId = $request->query('address_id');
    $paymentMode = $request->query('payment_mode', 'cod');
    $note = $request->query('note');

    // Fetch address details for the summary
    $selectedAddress = null;
    if ($addressId && $addressId !== 'new') {
        $selectedAddress = Address::find($addressId);
    } else {
        // FIX: Include 'address_type' and provide defaults to prevent "Undefined property"
        $selectedAddress = (object) [
            'address_type'            => $request->query('address_type', 'New Address'),
            'Zone_Street_HouseNumber' => $request->query('Zone_Street_HouseNumber'),
            'Barangay'                => $request->query('Barangay'),
            'City'                    => $request->query('City'),
            'Province'                => $request->query('Province'),
        ];
    }

    $subtotal = $cartItems->sum('subtotal');
        $taxRate = 12; // Standard Philippine VAT

        if (Session::has('discounts')) {
            $totals = Session::get('discounts');
            // Using floatval to ensure math safety
            $discount = floatval($totals['discount']);
            $tax = floatval($totals['tax']);
            $total = floatval($totals['total']);
        } else {
            $discount = 0;
            // VAT Calculation: Subtotal * 0.12
            $tax = round($subtotal * ($taxRate / 100), 2);
            $total = round($subtotal + $tax, 2);
        }

    return view('review', compact(
        'cartItems', 
        'selectedAddress', 
        'paymentMode', 
        'subtotal', 
        'tax', 
        'total', 
        'discount',
        'note',
        'addressId' // Pass this so your final "Place Order" form knows if it's new or existing
    ));
    }

        public function place_order(Request $request) 
    {
        // 1. Setup Data
        $userId = Auth::user()->id; 
        $cartItems = CartItem::where('User_ID', $userId)->where('instance', 'cart')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        // 2. Calculations (Prevents "Variable not found" errors)
        $subtotal = $cartItems->sum('subtotal');
        $tax = round($subtotal * 0.12, 2); 
        $discount = Session::get('discounts')['discount'] ?? 0;
        $total = ($subtotal + $tax) - $discount;
        $addressId = $request->address_id;

        // 3. Save the Main Order
        $order = new Order();
        $order->User_ID = $userId;
        $order->Address_ID = $addressId;
        $order->subtotal = $subtotal;
        $order->tax = $tax;
        $order->discount = $discount;
        $order->total = $total;
        $order->note = $request->note;
        $order->order_status = 'ordered';
        $order->payment_mode = $request->payment_mode ?? 'cod';
        $order->payment_status = 'pending';
        $order->save();

        // 4. Save Items & Deduct Stock
        foreach ($cartItems as $item) {
            $orderItem = new OrderItem();
            $orderItem->Order_ID = $order->Order_ID; 
            $orderItem->Product_ID = $item->Product_ID;
            $orderItem->price = $item->product->product_price;
            $orderItem->quantity = $item->quantity;
            
            // Handle 'options' as seen in your DB screenshot
            $orderItem->options = is_array($item->options) ? json_encode($item->options) : $item->options;
            
            $orderItem->save();

            // Stock Deduction
            $product = Product::find($item->Product_ID);
            if ($product) {
                $product->decrement('quantity', $item->quantity);
            }
        }

        // 5. SUCCESS: Clear Cart & Session
        CartItem::where('User_ID', $userId)->where('instance', 'cart')->delete();
        Session::forget(['coupon', 'discounts']);

        // 6. Redirect to Dashboard (Prevents White Screen)
        return redirect()->route('user.index')->with('success', 'Order placed! Your bag has been cleared.');
    }
    
}