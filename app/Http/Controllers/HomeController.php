<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->utype == 'ADM') {
            return redirect()->route('admin.index');
        }
        $categories = \App\Models\Category::orderBy('category_name', 'asc')->get();
        $featured_products = \App\Models\Product::where('featured', 1)->where('is_active', 1)->where('quantity', '>', 0)->take(8)->get();
        $hot_deals = \App\Models\Product::where('is_on_sale', 1)->whereNotNull('sale_price')->where('is_active', 1)->where('quantity', '>', 0)->take(4)->get();
        return view('index', compact('categories', 'featured_products', 'hot_deals'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function about()
    {
        return view('about');
    }
}
