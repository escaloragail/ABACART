<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\CartItem;
use App\Models\Coupon;
use Carbon\Carbon;

class CartController extends Controller
{
    /**
     * Helper: get the cart subtotal from DB for the current user (only selected items).
     */
    private function getCartSubtotal()
    {
        $items = CartItem::where('User_ID', Auth::user()->User_ID)
            ->where('instance', 'cart')
            ->where('is_selected', true)
            ->whereHas('product', function($query) {
                $query->where('is_active', 1);
            })
            ->with('product')
            ->get();

        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item->subtotal;
        }
        return round($subtotal, 2);
    }

    public function index()
    {
        $items = CartItem::where('User_ID', Auth::user()->User_ID)
            ->where('instance', 'cart')
            ->whereHas('product', function($query) {
                $query->where('is_active', 1);
            })
            ->with('product')
            ->get();

        // Calculate subtotal for SELECTED items only
        $selectedItems = $items->filter(function($item) {
            return $item->is_selected;
        });
        
        $subtotal = $selectedItems->sum('subtotal');
        
        // Dynamic discount recalculation
        $this->calculateDiscount();

        $discount = 0;
        if (Session::has('discounts')) {
            $totals = Session::get('discounts');
            $discount = floatval($totals['discount']);
            $tax = floatval($totals['tax']);
            $total = floatval($totals['total']);
        } else {
            $tax = 0;
            $total = round($subtotal, 2);
        }

        return view('cart', compact('items', 'subtotal', 'discount', 'tax', 'total'));
    }

    public function add_to_cart(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in first before adding items to your cart.');
        }

        $userId = Auth::user()->User_ID;
        $productId = $request->id;

        // Check if already in cart — increment qty instead
        $existing = CartItem::where('User_ID', $userId)
            ->where('Product_ID', $productId)
            ->where('instance', 'cart')
            ->first();

        if ($existing) {
            $existing->quantity += $request->quantity ?? 1;
            $existing->save();
        } else {
            CartItem::create([
                'User_ID' => $userId,
                'Product_ID' => $productId,
                'quantity' => $request->quantity ?? 1,
                'instance' => 'cart',
            ]);
        }

        return redirect()->back()->with('success', 'Item has been added to cart!');
    }

    public function increase_cart_quantity($id)
    {
        $item = CartItem::where('Cart_Item_ID', $id)
            ->where('User_ID', Auth::user()->User_ID)
            ->firstOrFail();
        $item->quantity += 1;
        $item->save();

        $this->calculateDiscount();
        return redirect()->back();
    }

    public function decrease_cart_quantity($id)
    {
        $item = CartItem::where('Cart_Item_ID', $id)
            ->where('User_ID', Auth::user()->User_ID)
            ->firstOrFail();

        if ($item->quantity > 1) {
            $item->quantity -= 1;
            $item->save();
        } else {
            $item->delete();
        }

        $this->calculateDiscount();
        return redirect()->back();
    }

    public function remove_item($id)
    {
        CartItem::where('Cart_Item_ID', $id)
            ->where('User_ID', Auth::user()->User_ID)
            ->delete();

        $this->calculateDiscount();
        return redirect()->back();
    }

    public function empty_cart()
    {
        CartItem::where('User_ID', Auth::user()->User_ID)
            ->where('instance', 'cart')
            ->delete();

        Session::forget('coupon');
        Session::forget('discounts');
        return redirect()->back();
    }

    public function apply_coupon(Request $request)
    {
        $coupon_code = $request->coupon_code;
        if (isset($coupon_code)) {
            $cart_subtotal = $this->getCartSubtotal();
            $coupon = Coupon::where('code', $coupon_code)
                ->where('expiry_date', '>=', Carbon::today())
                ->where('cart_value', '<=', $cart_subtotal)
                ->first();

            if (!$coupon) {
                return redirect()->back()->with('error', 'Invalid coupon code or cart value is less than coupon minimum value');
            }

            Session::put('coupon', [
                'code' => $coupon->code,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'cart_value' => $coupon->cart_value
            ]);
            $this->calculateDiscount();
            return redirect()->back()->with('success', 'Coupon has been applied!');
        }
    }

    public function calculateDiscount()
    {
        $discount = 0;
        if (Session::has('coupon')) {
            $cart_subtotal = $this->getCartSubtotal();

            // Safety limit: if the cart is empty or falls below the coupon minimum value, auto-remove coupon
            if ($cart_subtotal <= 0 || $cart_subtotal < Session::get('coupon')['cart_value']) {
                Session::forget('coupon');
                Session::forget('discounts');
                return;
            }

            if (Session::get('coupon')['type'] == 'fixed') {
                $discount = Session::get('coupon')['value'];
            } else {
                $discount = ($cart_subtotal * Session::get('coupon')['value']) / 100;
            }

            // Cap the discount so it never exceeds the subtotal
            if ($discount > $cart_subtotal) {
                $discount = $cart_subtotal;
            }

            $subtotalAfterDiscount = $cart_subtotal - $discount;
            $taxAfterDiscount = 0;
            $totalAfterDiscount = $subtotalAfterDiscount;

            Session::put('discounts', [
                'discount' => number_format(floatval($discount), 2, '.', ''),
                'subtotal' => number_format(floatval($subtotalAfterDiscount), 2, '.', ''),
                'tax' => number_format(floatval($taxAfterDiscount), 2, '.', ''),
                'total' => number_format(floatval($totalAfterDiscount), 2, '.', '')
            ]);
        }
    }

    public function remove_coupon()
    {
        Session::forget('coupon');
        Session::forget('discounts');
        return redirect()->back()->with('success', 'Coupon has been removed!');
    }

    public function update_selection(Request $request)
    {
        $item = CartItem::where('Cart_Item_ID', $request->item_id)
            ->where('User_ID', Auth::user()->User_ID)
            ->firstOrFail();

        $item->is_selected = $request->is_selected;
        $item->save();

        return response()->json(['success' => true]);
    }
}
