<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $size = $request->query('size') ? $request->query('size') : 12;
        $order = $request->query('order') ? $request->query('order') : -1;

        $o_column = 'Product_ID';
        $o_order = 'DESC';

        switch ($order) {
            case 1:
                $o_column = 'created_at';
                $o_order = 'DESC';
                break;
            case 2:
                $o_column = 'created_at';
                $o_order = 'ASC';
                break;
            case 3:
                $o_column = 'sale_price';
                $o_order = 'ASC';
                break;
            case 4:
                $o_column = 'sale_price';
                $o_order = 'DESC';
                break;
        }

        $categories = Category::orderBy('category_name', 'ASC')->get();

        $q_categories = $request->query('categories');

        $products = Product::where('is_active', 1)
            ->when($q_categories, function ($query, $q_categories) {
                $query->whereIn('Category_ID', explode(',', $q_categories));
            })
            ->orderBy($o_column, $o_order)
            ->paginate($size);

        return view('shop', compact('products', 'size', 'order', 'categories', 'q_categories'));
    }

    public function product_details($slug)
    {
        $product = Product::where('product_slug', $slug)->where('is_active', 1)->first();
        if (!$product) {
            abort(404);
        }

        $rproducts = Product::where('product_slug', '!=', $slug)
            ->where('Category_ID', $product->Category_ID)
            ->where('is_active', 1)
            ->get()->take(8);

        return view('details', compact('product', 'rproducts'));
    }
}
