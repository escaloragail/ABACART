<?php

namespace App\Http\Controllers;

use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;

class AdminController extends Controller
{
    public function index()
    {
        $orders = \App\Models\Order::all();
        $total_orders = $orders->count();
        $total_amount = $orders->sum('total');
        $total_products = Product::where('is_active', 1)->count();
        $total_customers = \App\Models\User::where('utype', 'USR')->count();

        $pending_orders = \App\Models\Order::where('order_status', 'ordered')->get();
        $pending_count = $pending_orders->count();
        $pending_amount = $pending_orders->sum('total');

        $delivered_orders = \App\Models\Order::where('order_status', 'delivered')->get();
        $delivered_count = $delivered_orders->count();
        $delivered_amount = $delivered_orders->sum('total');

        $canceled_orders = \App\Models\Order::where('order_status', 'canceled')->get();
        $canceled_count = $canceled_orders->count();
        $canceled_amount = $canceled_orders->sum('total');

        $recent_orders = \App\Models\Order::orderBy('created_at', 'DESC')->limit(10)->get();

        // Real-time monthly chart data
        $currentYear = date('Y');
        $monthlyData = \App\Models\Order::selectRaw("MONTH(created_at) as month, order_status, SUM(total) as total_amount")
            ->whereYear('created_at', $currentYear)
            ->groupBy('month', 'order_status')
            ->get();

        $monthlyTotals = array_fill(0, 12, 0);
        $monthlyPending = array_fill(0, 12, 0);
        $monthlyDelivered = array_fill(0, 12, 0);
        $monthlyCanceled = array_fill(0, 12, 0);

        foreach ($monthlyData as $data) {
            $idx = $data->month - 1;
            $monthlyTotals[$idx] += floatval($data->total_amount);
            if ($data->order_status == 'ordered') $monthlyPending[$idx] = floatval($data->total_amount);
            elseif ($data->order_status == 'delivered') $monthlyDelivered[$idx] = floatval($data->total_amount);
            elseif ($data->order_status == 'canceled') $monthlyCanceled[$idx] = floatval($data->total_amount);
        }

        return view('admin.index', compact(
            'total_orders', 'total_amount', 'total_products', 'total_customers',
            'pending_count', 'pending_amount',
            'delivered_count', 'delivered_amount',
            'canceled_count', 'canceled_amount',
            'recent_orders',
            'monthlyTotals', 'monthlyPending', 'monthlyDelivered', 'monthlyCanceled'
        ));
    }


    
    public function categories()
    {
            $categories = Category::orderBy('Category_ID', 'desc')->paginate(10);
            return view('admin.categories', compact('categories'));   
    }
    public function category_add()
    {
        return view('admin.category-add');
    }
    public function category_store(Request $request)
    {
        $request->merge([
            'slug' => Str::slug($request->slug)
        ]);
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,category_slug',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $category = new Category();
        $category->category_name = $request->name;
        $category->category_slug = $request->slug;
        $image = $request->file('image');
        $file_extention = $request->file('image')->extension();
        $file_name = Carbon :: now()->timestamp.'.'.$file_extention;
        $this->GenerateCategoryThumbailsImage($image,$file_name);
        $category->image = $file_name;
        $category->save();
        return redirect()->route('admin.categories')->with('status','Category has been added succesfully!');        
    }
    public function GenerateCategoryThumbailsImage($image, $imagename)
    {
        $destinationPath = public_path('uploads/categories');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $img = Image::read($image->path());
        $img->cover(124, 124, "top");
        $img->resize(124, 124, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imagename);
    }

    public function category_edit($id)
    {
        $category = Category::find($id);
        return view('admin.category-edit', compact('category'));
    }

    public function category_update(Request $request, $id)
    {
        $request->merge([
            'slug' => Str::slug($request->slug)
        ]);
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,category_slug,' . $id . ',Category_ID',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category = Category::find($id);
        $category->category_name = $request->name;
        $category->category_slug = $request->slug;

        if ($request->hasFile('image')) {
            if (File::exists(public_path('uploads/categories/' . $category->image))) {
                File::delete(public_path('uploads/categories/' . $category->image));
            }

            $image = $request->file('image');
            $file_extention = $image->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extention;
            $this->GenerateCategoryThumbailsImage($image, $file_name);
            $category->image = $file_name;
        }

        $category->save();
        return redirect()->route('admin.categories')->with('success', 'Category has been updated successfully.');
    }

    public function category_delete($id)
    {
        $category = Category::find($id);
        if (File::exists(public_path('uploads/categories/' . $category->image))) {
            File::delete(public_path('uploads/categories/' . $category->image));
        }
        $category->delete();
        return redirect()->route('admin.categories')->with('success', 'Category has been deleted successfully.');
    }

    public function products(Request $request)
    {
        $show = $request->query('show', 'active');
        if ($show == 'inactive') {
            $products = Product::where('is_active', 0)->orderBy('Product_ID', 'desc')->paginate(10);
        } else {
            $products = Product::where('is_active', 1)->orderBy('Product_ID', 'desc')->paginate(10);
        }
        $activeCount = Product::where('is_active', 1)->count();
        $inactiveCount = Product::where('is_active', 0)->count();
        return view('admin.products', compact('products', 'show', 'activeCount', 'inactiveCount'));
    }

    public function product_quantity_update(Request $request, $id)
    {
        $product = Product::find($id);
        if($request->action == 'increase') {
            $product->quantity += 1;
        } else if($request->action == 'decrease' && $product->quantity > 0) {
            $product->quantity -= 1;
        }
        $product->save();
        return back()->with('success', 'Quantity updated successfully');
    }

    public function product_add()
    {
        $categories = Category::orderBy('category_name', 'asc')->get();
        return view('admin.product-add', compact('categories'));
    }

    public function product_store(Request $request)
    {
        $request->merge([
            'product_slug' => Str::slug($request->product_slug)
        ]);
        $request->validate([
            'product_name' => 'required',
            'product_slug' => 'required|unique:products,product_slug',
            'short_description' => 'required',
            'product_description' => 'required',
            'regular_price' => 'required',
            'SKU' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'Category_ID' => 'required',
            'main_product_image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_on_sale' => 'boolean'
        ]);

        $product = new Product();
        $product->product_name = $request->product_name;
        $product->product_slug = $request->product_slug;
        $product->short_description = $request->short_description;
        $product->product_description = $request->product_description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->Category_ID = $request->Category_ID;
        $product->is_on_sale = $request->is_on_sale;

        if ($request->hasFile('main_product_image')) {
            $image = $request->file('main_product_image');
            $imageName = \Carbon\Carbon::now()->timestamp . '.' . $image->extension();
            $this->GenerateProductThumbnailImage($image, $imageName);
            $product->main_product_image = $imageName;
        }

        $gallery_arr = array();
        if ($request->hasFile('sub_product_images')) {
            $allowedfileExtension = ['jpg', 'png', 'jpeg', 'gif', 'svg'];
            $files = $request->file('sub_product_images');
            foreach ($files as $index => $file) {
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $gFileName = \Carbon\Carbon::now()->timestamp . '-' . $index . '.' . $extension;
                    $this->GenerateProductThumbnailImage($file, $gFileName);
                    array_push($gallery_arr, $gFileName);
                }
            }
            $product->sub_product_images = implode(',', $gallery_arr);
        }

        $product->save();
        return redirect()->route('admin.products')->with('success', 'Product has been created successfully');
    }

    public function GenerateProductThumbnailImage($image, $imageName)
    {
        $destinationPathThumbnail = public_path('uploads/products/thumbnails');
        $destinationPath = public_path('uploads/products');

        if (!file_exists($destinationPathThumbnail)) {
            mkdir($destinationPathThumbnail, 0755, true);
        }
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Original image
        $image->move($destinationPath, $imageName);

        // Thumbnail image
        $img = \Intervention\Image\Laravel\Facades\Image::read($destinationPath . '/' . $imageName);
        $img->cover(104, 104, "top");
        $img->resize(104, 104, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPathThumbnail . '/' . $imageName);
    }

    public function product_edit($id)
    {
        $product = Product::find($id);
        $categories = Category::orderBy('category_name', 'asc')->get();
        return view('admin.product-edit', compact('product', 'categories'));
    }

    public function product_update(Request $request, $id)
    {
        $request->merge([
            'product_slug' => Str::slug($request->product_slug)
        ]);
        $request->validate([
            'product_name' => 'required',
            'product_slug' => 'required|unique:products,product_slug,' . $id . ',Product_ID',
            'short_description' => 'required',
            'product_description' => 'required',
            'regular_price' => 'required',
            'SKU' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'Category_ID' => 'required',
            'is_on_sale' => 'boolean'
        ]);

        $product = Product::find($id);
        $product->product_name = $request->product_name;
        $product->product_slug = $request->product_slug;
        $product->short_description = $request->short_description;
        $product->product_description = $request->product_description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->Category_ID = $request->Category_ID;
        $product->is_on_sale = $request->is_on_sale;

        if ($request->hasFile('main_product_image')) {
            if (File::exists(public_path('uploads/products/' . $product->main_product_image))) {
                File::delete(public_path('uploads/products/' . $product->main_product_image));
            }
            if (File::exists(public_path('uploads/products/thumbnails/' . $product->main_product_image))) {
                File::delete(public_path('uploads/products/thumbnails/' . $product->main_product_image));
            }
            $image = $request->file('main_product_image');
            $imageName = \Carbon\Carbon::now()->timestamp . '.' . $image->extension();
            $this->GenerateProductThumbnailImage($image, $imageName);
            $product->main_product_image = $imageName;
        }

        if ($request->hasFile('sub_product_images')) {
            $gallery_arr = array();
            $allowedfileExtension = ['jpg', 'png', 'jpeg', 'gif', 'svg'];
            $files = $request->file('sub_product_images');
            foreach ($files as $index => $file) {
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $gFileName = \Carbon\Carbon::now()->timestamp . '-' . $index . '.' . $extension;
                    $this->GenerateProductThumbnailImage($file, $gFileName);
                    array_push($gallery_arr, $gFileName);
                }
            }
            $product->sub_product_images = implode(',', $gallery_arr);
        }

        $product->save();
        return redirect()->route('admin.products')->with('success', 'Product has been updated successfully');
    }

    public function product_delete($id)
    {
        $product = Product::find($id);
        $product->is_active = 0;
        $product->save();
        return redirect()->route('admin.products')->with('success', 'Product has been deactivated successfully');
    }

    public function product_reactivate($id)
    {
        $product = Product::find($id);
        $product->is_active = 1;
        $product->save();
        return redirect()->route('admin.products', ['show' => 'inactive'])->with('success', 'Product has been reactivated successfully');
    }

    public function coupons()
    {
        $coupons = \App\Models\Coupon::orderBy('Coupon_ID', 'desc')->paginate(10);
        return view('admin.coupons', compact('coupons'));
    }

    public function coupon_add()
    {
        return view('admin.coupon-add');
    }

    public function coupon_store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code',
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required|date'
        ]);

        $coupon = new \App\Models\Coupon();
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();

        return redirect()->route('admin.coupons')->with('success', 'Coupon has been added successfully!');
    }

    public function coupon_edit($id)
    {
        $coupon = \App\Models\Coupon::find($id);
        return view('admin.coupon-edit', compact('coupon'));
    }

    public function coupon_update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code,' . $id,
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required|date'
        ]);

        $coupon = \App\Models\Coupon::find($id);
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();

        return redirect()->route('admin.coupons')->with('success', 'Coupon has been updated successfully!');
    }

    public function coupon_delete($id)
    {
        $coupon = \App\Models\Coupon::find($id);
        $coupon->delete();
        return redirect()->route('admin.coupons')->with('success', 'Coupon has been deleted successfully!');
    }

    public function orders(Request $request)
    {
        $status = $request->query('status');
        $query = \App\Models\Order::query();

        if ($status && in_array($status, ['ordered', 'delivered', 'canceled'])) {
            $query->where('order_status', $status);
        }

        $orders = $query->orderBy('created_at', 'DESC')->paginate(12);

        // Fetch counts for tabs
        $counts = [
            'all' => \App\Models\Order::count(),
            'ordered' => \App\Models\Order::where('order_status', 'ordered')->count(),
            'delivered' => \App\Models\Order::where('order_status', 'delivered')->count(),
            'canceled' => \App\Models\Order::where('order_status', 'canceled')->count(),
        ];

        return view('admin.orders', compact('orders', 'counts', 'status'));
    }

    public function order_details($order_id)
    {
        $order = \App\Models\Order::find($order_id);
        $orderItems = \App\Models\OrderItem::where('Order_ID', $order_id)->orderBy('Order_Item_ID')->paginate(12);
        $address = \App\Models\Address::where('User_ID', $order->User_ID)->where('Address_ID', $order->Address_ID ?? 0)->first();
        if(!$address) {
             $address = \App\Models\Address::where('User_ID', $order->User_ID)->orderBy('Address_ID', 'DESC')->first();
        }
        return view('admin.order-details', compact('order', 'orderItems', 'address'));
    }

    public function update_order_status(Request $request)
    {
        $order = \App\Models\Order::find($request->order_id);
        
        // Status Lock: Cannot change status if already delivered or canceled
        if ($order->order_status == 'delivered' || $order->order_status == 'canceled') {
            return back()->with('error', 'Status cannot be changed once it is ' . $order->order_status . '.');
        }

        $old_status = $order->order_status;
        $order->order_status = $request->order_status;

        if($request->order_status == 'delivered')
        {
            $order->date_delivery = \Carbon\Carbon::now();
        }
        else if($request->order_status == 'canceled')
        {
            $order->date_cancelled = \Carbon\Carbon::now();
            
            // Restore Stock
            $orderItems = \App\Models\OrderItem::where('Order_ID', $order->Order_ID)->get();
            foreach($orderItems as $item) {
                $product = \App\Models\Product::find($item->Product_ID);
                if($product) {
                    $product->quantity = $product->quantity + $item->quantity;
                    $product->save();
                }
            }
        }
        $order->save();

        if($request->order_status == 'delivered')
        {
            $order->payment_status = 'approved';
            $order->save();
        }
        return back()->with('success', 'Status has been updated successfully!');
    }

    public function sales(Request $request)
    {
        $date_from = $request->query('date_from');
        $date_to = $request->query('date_to');
        $status_filter = $request->query('status', 'delivered'); // default to delivered (completed sales)

        $query = \App\Models\Order::query();

        // Filter by status
        if ($status_filter && $status_filter !== 'all') {
            $query->where('order_status', $status_filter);
        }

        // Filter by date range
        if ($date_from) {
            $query->whereDate('created_at', '>=', $date_from);
        }
        if ($date_to) {
            $query->whereDate('created_at', '<=', $date_to);
        }

        $sales = $query->orderBy('created_at', 'DESC')->paginate(15)->appends($request->query());

        // Summary stats (for the filtered results)
        $statsQuery = \App\Models\Order::query();
        if ($status_filter && $status_filter !== 'all') {
            $statsQuery->where('order_status', $status_filter);
        }
        if ($date_from) {
            $statsQuery->whereDate('created_at', '>=', $date_from);
        }
        if ($date_to) {
            $statsQuery->whereDate('created_at', '<=', $date_to);
        }

        $total_sales = $statsQuery->sum('total');
        $total_transactions = $statsQuery->count();
        $total_discount = $statsQuery->sum('discount');

        // Status counts (within date range)
        $countQuery = \App\Models\Order::query();
        if ($date_from) {
            $countQuery->whereDate('created_at', '>=', $date_from);
        }
        if ($date_to) {
            $countQuery->whereDate('created_at', '<=', $date_to);
        }

        $counts = [
            'all' => (clone $countQuery)->count(),
            'delivered' => (clone $countQuery)->where('order_status', 'delivered')->count(),
            'ordered' => (clone $countQuery)->where('order_status', 'ordered')->count(),
            'canceled' => (clone $countQuery)->where('order_status', 'canceled')->count(),
        ];

        return view('admin.sales', compact(
            'sales', 'total_sales', 'total_transactions', 'total_discount',
            'date_from', 'date_to', 'status_filter', 'counts'
        ));
    }

    public function account_details()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        return view('admin.account-details', compact('user'));
    }

    public function account_update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . \Illuminate\Support\Facades\Auth::user()->User_ID . ',User_ID',
            'phone_number' => 'required|string|max:15',
            'password' => 'nullable|string|min:8|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $user = \App\Models\User::find(\Illuminate\Support\Facades\Auth::user()->User_ID);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;

        if ($request->hasFile('image')) {
            if ($user->image && \Illuminate\Support\Facades\File::exists(public_path('uploads/profiles/' . $user->image))) {
                \Illuminate\Support\Facades\File::delete(public_path('uploads/profiles/' . $user->image));
            }
            $image = $request->file('image');
            $imageName = \Carbon\Carbon::now()->timestamp . '.' . $image->extension();
            $this->GenerateProfileImage($image, $imageName);
            $user->image = $imageName;
        }

        if ($request->password) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }
        $user->save();

        return back()->with('success', 'Account details updated successfully!');
    }

    public function users(Request $request)
    {
        $search = $request->query('search');
        $role = $request->query('role');
        $status = $request->query('status');

        $query = \App\Models\User::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        if ($role && $role !== 'all') {
            $query->where('utype', $role);
        }

        if ($status !== null && $status !== 'all') {
            $query->where('is_active', $status == 'active');
        }

        $users = $query->orderBy('User_ID', 'DESC')->paginate(15)->appends($request->query());

        return view('admin.users', compact('users', 'search', 'role', 'status'));
    }

    public function user_update_role(Request $request, $id)
    {
        $request->validate([
            'utype' => 'required|in:ADM,USR',
        ]);

        $user = \App\Models\User::findOrFail($id);

        if ($user->User_ID === \Illuminate\Support\Facades\Auth::user()->User_ID) {
            return back()->with('error', 'You cannot change your own role!');
        }

        $user->utype = $request->utype;
        $user->save();

        return back()->with('success', 'User role updated successfully!');
    }

    public function user_toggle_status(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);

        if ($user->User_ID === \Illuminate\Support\Facades\Auth::user()->User_ID) {
            return back()->with('error', 'You cannot deactivate your own account!');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $statusStr = $user->is_active ? 'reactivated' : 'deactivated';
        return back()->with('success', "User account {$statusStr} successfully!");
    }

    public function GenerateProfileImage($image, $imageName)
    {
        $destinationPath = public_path('uploads/profiles');

        if (!\Illuminate\Support\Facades\File::exists($destinationPath)) {
            \Illuminate\Support\Facades\File::makeDirectory($destinationPath, 0755, true);
        }

        $img = \Intervention\Image\Laravel\Facades\Image::read($image->path());
        $img->cover(124, 124, "top");
        $img->resize(124, 124, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . '/' . $imageName);
    }
}
