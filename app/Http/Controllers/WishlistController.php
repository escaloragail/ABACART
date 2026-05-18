<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;

class WishlistController extends Controller
{
    public function index()
    {
        $items = CartItem::where('User_ID', Auth::user()->User_ID)
            ->where('instance', 'wishlist')
            ->with('product')
            ->get();
        return view('wishlist', compact('items'));
    }

    public function add_to_wishlist(Request $request)
    {
        $userId = Auth::user()->User_ID;
        $productId = $request->id;

        $existing = CartItem::where('User_ID', $userId)
            ->where('Product_ID', $productId)
            ->where('instance', 'wishlist')
            ->first();

        if (!$existing) {
            CartItem::create([
                'User_ID' => $userId,
                'Product_ID' => $productId,
                'quantity' => 1,
                'instance' => 'wishlist',
            ]);
        }

        return response()->json(['status' => 200, 'message' => 'Success! Item successfully added to your wishlist.']);
    }

    public function remove_item($id)
    {
        CartItem::where('Cart_Item_ID', $id)
            ->where('User_ID', Auth::user()->User_ID)
            ->delete();
        return redirect()->back();
    }

    public function empty_wishlist()
    {
        CartItem::where('User_ID', Auth::user()->User_ID)
            ->where('instance', 'wishlist')
            ->delete();
        return redirect()->back();
    }

    public function move_to_cart($id)
    {
        $item = CartItem::where('Cart_Item_ID', $id)
            ->where('User_ID', Auth::user()->User_ID)
            ->where('instance', 'wishlist')
            ->firstOrFail();

        // Check if product already in cart
        $existing = CartItem::where('User_ID', Auth::user()->User_ID)
            ->where('Product_ID', $item->Product_ID)
            ->where('instance', 'cart')
            ->first();

        if ($existing) {
            $existing->quantity += 1;
            $existing->save();
        } else {
            CartItem::create([
                'User_ID' => Auth::user()->User_ID,
                'Product_ID' => $item->Product_ID,
                'quantity' => 1,
                'instance' => 'cart',
            ]);
        }

        $item->delete();
        return redirect()->back()->with('success', 'Item has been moved to cart!');
    }
}
