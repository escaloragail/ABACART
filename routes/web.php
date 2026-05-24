<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

// ── Public Routes ──
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/about-us', [HomeController::class, 'about'])->name('home.about');
Route::get('/contact-us', [HomeController::class, 'contact'])->name('home.contact');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/product/{slug}', [ShopController::class, 'product_details'])->name('shop.product.details');

// ── Authenticated User Routes ──
Route::middleware(['auth'])->group(function(){
    
    // Cart Logic
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add_to_cart'])->name('cart.add');
    Route::put('/cart/increase/{id}', [CartController::class, 'increase_cart_quantity'])->name('cart.increase');
    Route::put('/cart/decrease/{id}', [CartController::class, 'decrease_cart_quantity'])->name('cart.decrease');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove_item'])->name('cart.remove');
    Route::delete('/cart/empty', [CartController::class, 'empty_cart'])->name('cart.empty');
    Route::post('/cart/coupon/apply', [CartController::class, 'apply_coupon'])->name('cart.coupon.apply');
    Route::delete('/cart/coupon/remove', [CartController::class, 'remove_coupon'])->name('cart.coupon.remove');
    Route::post('/cart/update-selection', [CartController::class, 'update_selection'])->name('cart.update.selection');

    // Wishlist Logic
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add', [WishlistController::class, 'add_to_wishlist'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove_item'])->name('wishlist.remove');
    Route::delete('/wishlist/empty', [WishlistController::class, 'empty_wishlist'])->name('wishlist.empty');
    Route::post('/wishlist/move-to-cart/{id}', [WishlistController::class, 'move_to_cart'])->name('wishlist.move.to.cart');

    // ── Checkout Flow (The 3-Step Split) ──
    // Step 02: Shipping Details
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('cart.checkout');
    
    // Step 03: Order Review & Confirmation
    Route::get('/checkout/review', [CheckoutController::class, 'review'])->name('cart.review');
    
    // Final Action: Place Order
    Route::post('/checkout/place-order', [CheckoutController::class, 'place_order'])->name('cart.place_order');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

    // User Dashboard & Account
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
    Route::get('/dashboard/orders', [UserController::class, 'orders'])->name('user.orders');
    Route::get('/dashboard/order/{order_id}', [UserController::class, 'order_details'])->name('user.order.details');
    Route::put('/dashboard/order/cancel', [UserController::class, 'order_cancel'])->name('user.order.cancel');
    Route::get('/dashboard/account-details', [UserController::class, 'account_details'])->name('user.account.details');
    Route::put('/dashboard/account-update', [UserController::class, 'account_update'])->name('user.account.update');
    Route::get('/dashboard/addresses', [UserController::class, 'addresses'])->name('user.addresses');
    Route::get('/dashboard/address/add', [UserController::class, 'address_add'])->name('user.address.add');
    Route::post('/dashboard/address/store', [UserController::class, 'address_store'])->name('user.address.store');
    Route::get('/dashboard/address/edit/{id}', [UserController::class, 'address_edit'])->name('user.address.edit');
    Route::put('/dashboard/address/update/{id}', [UserController::class, 'address_update'])->name('user.address.update');
    Route::delete('/dashboard/address/delete/{id}', [UserController::class, 'address_delete'])->name('user.address.delete');
});

// ── Admin Routes ──
Route::middleware(['auth', AuthAdmin::class])->group(function(){
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    // Categories
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/category/add', [AdminController::class, 'category_add'])->name('admin.category.add');
    Route::post('/admin/category/store', [AdminController::class, 'category_store'])->name('admin.category.store');
    Route::get('/admin/category/edit/{id}', [AdminController::class, 'category_edit'])->name('admin.category.edit');
    Route::put('/admin/category/update/{id}', [AdminController::class, 'category_update'])->name('admin.category.update');
    Route::delete('/admin/category/delete/{id}', [AdminController::class, 'category_delete'])->name('admin.category.delete');

    // Products
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/product/add', [AdminController::class, 'product_add'])->name('admin.product.add');
    Route::post('/admin/product/store', [AdminController::class, 'product_store'])->name('admin.product.store');
    Route::get('/admin/product/edit/{id}', [AdminController::class, 'product_edit'])->name('admin.product.edit');
    Route::put('/admin/product/update/{id}', [AdminController::class, 'product_update'])->name('admin.product.update');
    Route::delete('/admin/product/delete/{id}', [AdminController::class, 'product_delete'])->name('admin.product.delete');
    Route::put('/admin/product/reactivate/{id}', [AdminController::class, 'product_reactivate'])->name('admin.product.reactivate');
    Route::put('/admin/product/quantity/update/{id}', [AdminController::class, 'product_quantity_update'])->name('admin.product.quantity.update');

    // Coupons
    Route::get('/admin/coupons', [AdminController::class, 'coupons'])->name('admin.coupons');
    Route::get('/admin/coupon/add', [AdminController::class, 'coupon_add'])->name('admin.coupon.add');
    Route::post('/admin/coupon/store', [AdminController::class, 'coupon_store'])->name('admin.coupon.store');
    Route::get('/admin/coupon/edit/{id}', [AdminController::class, 'coupon_edit'])->name('admin.coupon.edit');
    Route::put('/admin/coupon/update/{id}', [AdminController::class, 'coupon_update'])->name('admin.coupon.update');
    Route::delete('/admin/coupon/delete/{id}', [AdminController::class, 'coupon_delete'])->name('admin.coupon.delete');

    // Orders
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/admin/order/{order_id}', [AdminController::class, 'order_details'])->name('admin.order.details');
    Route::put('/admin/order/update-status', [AdminController::class, 'update_order_status'])->name('admin.order.update_status');

    // Sales
    Route::get('/admin/sales', [AdminController::class, 'sales'])->name('admin.sales');

    // Users Management
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::put('/admin/users/{id}/update-role', [AdminController::class, 'user_update_role'])->name('admin.users.update_role');
    Route::put('/admin/users/{id}/toggle-status', [AdminController::class, 'user_toggle_status'])->name('admin.users.toggle_status');

    // Admin Account
    Route::get('/admin/account-details', [AdminController::class, 'account_details'])->name('admin.account.details');
    Route::put('/admin/account-update', [AdminController::class, 'account_update'])->name('admin.account.update');
});