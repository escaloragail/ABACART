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
use App\Models\GreenpayAccount;

class CheckoutController extends Controller
{
    // STEP 02: Shipping Details
    public function index()
    {
        $cartItems = CartItem::where('User_ID', Auth::user()->User_ID)
            ->where('instance', 'cart')
            ->where('is_selected', true)
            ->whereHas('product', function($query) {
                $query->where('is_active', 1);
            })
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
                ->where('is_selected', true)
                ->whereHas('product', function($query) {
                    $query->where('is_active', 1);
                })
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
        $greenpayAccounts = GreenpayAccount::where('User_ID', $userId)
            ->orderBy('created_at', 'DESC')
            ->get();

        if (Session::has('discounts')) {
            $totals = Session::get('discounts');
            // Using floatval to ensure math safety
            $discount = floatval($totals['discount']);
            $tax = 0;
            $total = max(round($subtotal - $discount, 2), 0);
        } else {
            $discount = 0;
            $tax = 0;
            $total = round($subtotal, 2);
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
        'addressId',
        'greenpayAccounts'
    ));
    }

        public function place_order(Request $request) 
    {
        $request->validate([
            'address_id' => ['required'],
            'payment_mode' => ['required', 'in:cod,greenpay'],
            'payment_reference_number' => [
                'nullable',
                'string',
                'max:100',
                'required_if:payment_mode,greenpay',
                'unique:orders,payment_reference_number',
            ],
            'greenpay_account_id' => ['nullable', 'required_if:payment_mode,greenpay'],
            'greenpay_fullname' => ['nullable', 'required_if:greenpay_account_id,new', 'string', 'max:255'],
            'greenpay_mobile_number' => ['nullable', 'required_if:greenpay_account_id,new', 'string', 'max:20'],
            'greenpay_email' => ['nullable', 'required_if:greenpay_account_id,new', 'email', 'max:255'],
        ], [
            'payment_reference_number.required_if' => 'Please enter the GreenPay reference number.',
            'payment_reference_number.unique' => 'This payment reference number has already been used.',
            'greenpay_account_id.required_if' => 'Please choose or add GreenPay information.',
            'greenpay_fullname.required_if' => 'Please enter the GreenPay account name.',
            'greenpay_mobile_number.required_if' => 'Please enter the GreenPay mobile number.',
            'greenpay_email.required_if' => 'Please enter the GreenPay email address.',
        ]);

        // 1. Setup Data
        $userId = Auth::user()->User_ID; 
        $cartItems = CartItem::where('User_ID', $userId)
            ->where('instance', 'cart')
            ->where('is_selected', true)
            ->whereHas('product', function($query) {
                $query->where('is_active', 1);
            })
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        // 2. Calculations (Prevents "Variable not found" errors)
        $subtotal = $cartItems->sum('subtotal');
        if (Session::has('discounts')) {
            $totals = Session::get('discounts');
            $discount = floatval($totals['discount']);
            $tax = 0;
            $total = max(round($subtotal - $discount, 2), 0);
        } else {
            $discount = 0;
            $tax = 0;
            $total = round($subtotal, 2);
        }
        $addressId = $request->address_id;

        if ($addressId === 'new') {
            $newAddress = new Address();
            $newAddress->User_ID = $userId;
            $newAddress->address_type = $request->address_type ?? 'New Address';
            $newAddress->Zone_Street_HouseNumber = $request->Zone_Street_HouseNumber;
            $newAddress->Barangay = $request->Barangay;
            $newAddress->City = $request->City;
            $newAddress->Province = $request->Province;
            $newAddress->is_default = 0;
            $newAddress->save();

            $addressId = $newAddress->Address_ID;
        }

        // 3. Save the Main Order
        $couponId = null;
        if (Session::has('coupon')) {
            $coupon = Coupon::where('code', Session::get('coupon')['code'])->first();
            if ($coupon) {
                $couponId = $coupon->Coupon_ID;
            }
        }

        $greenpayAccount = null;
        if ($request->payment_mode === 'greenpay') {
            if ($request->greenpay_account_id === 'new') {
                $greenpayAccount = GreenpayAccount::create([
                    'User_ID' => $userId,
                    'fullname' => $request->greenpay_fullname,
                    'mobile_number' => $request->greenpay_mobile_number,
                    'email' => $request->greenpay_email,
                ]);
            } else {
                $greenpayAccount = GreenpayAccount::where('User_ID', $userId)
                    ->where('id', $request->greenpay_account_id)
                    ->firstOrFail();
            }
        }

        $order = new Order();
        $order->User_ID = $userId;
        $order->Address_ID = $addressId;
        $order->Coupon_ID = $couponId;
        $order->subtotal = $subtotal;
        $order->tax = $tax;
        $order->discount = $discount;
        $order->total = $total;
        $order->note = $request->note;
        $order->order_status = 'ordered';
        $order->payment_mode = $request->payment_mode ?? 'cod';
        $order->payment_status = 'pending';
        $order->payment_reference_number = $request->payment_mode === 'greenpay'
            ? $request->payment_reference_number
            : null;
        $order->greenpay_account_id = $greenpayAccount?->id;
        $order->greenpay_fullname = $greenpayAccount?->fullname;
        $order->greenpay_mobile_number = $greenpayAccount?->mobile_number;
        $order->greenpay_email = $greenpayAccount?->email;
        $order->save();

        // 4. Save Items & Deduct Stock
        foreach ($cartItems as $item) {
            $orderItem = new OrderItem();
            $orderItem->Order_ID = $order->Order_ID; 
            $orderItem->Product_ID = $item->Product_ID;
            $orderItem->price = $item->effective_price;
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

        // 6. Redirect to Success Page
        $message = $order->payment_mode === 'greenpay'
            ? 'Order placed successfully. Your GreenPay payment is pending admin verification.'
            : 'Order placed successfully. Your Cash on Delivery order is now pending.';

        return redirect()->route('checkout.success')->with('success', $message);
    }

    // STEP 04: Order Success Confirmation
    public function success()
    {
        return view('checkout-success');
    }
    
}
