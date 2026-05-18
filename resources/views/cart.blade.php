@extends('layouts.app')
@section('content')


<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">


<style>
    /* ── Header Area (Off-White) ── */
    .ac-page-header { background: #FCF9F6; padding: 60px 0 30px; text-align: center; border-bottom: 1px solid #efeae4; }
    .ac-page-title { font-family: 'Playfair Display', serif; font-size: 36px; color: #353b3e; margin-bottom: 8px; }
    .ac-page-breadcrumb { font-size: 11px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: #a3aab2; }


    /* ── Content Area (Pure White) ── */
    .ac-white-content { background: #ffffff !important; padding-top: 40px; padding-bottom: 100px; min-height: 80vh; }
   
    /* ── Steps Header ── */
    .ac-steps-wrapper { display: flex; justify-content: space-between; border-bottom: 1px solid #efeae4; margin-bottom: 40px; padding-bottom: 0; }
    .ac-step { flex: 1; text-align: left; padding: 0 0 20px 0; border-bottom: 2px solid transparent; text-decoration: none; color: #a3aab2; transition: 0.3s; margin-right: 20px; }
    .ac-step.active { color: #212529; border-bottom: 2px solid #212529; }
    .ac-step h6 { font-size: 14px; font-weight: 700; margin: 0 0 8px 0; color: inherit; }
    .ac-step p { font-size: 11px; margin: 0; color: #a3aab2; }


    /* ── Cart Items (Rounded Card Style) ── */
    .ac-section-title {
        display: flex; align-items: center; gap: 12px;
        font-size: 11px; font-weight: 800; letter-spacing: 0.15em;
        color: #333; text-transform: uppercase; margin-bottom: 30px;
    }
    .ac-section-title::before { content: ""; width: 24px; height: 2px; background: #333; display: inline-block; }


    .ac-product-card {
        background: #fff; border-radius: 20px; padding: 25px 30px;
        margin-bottom: 15px; border: 1.5px solid #eee;
        transition: all 0.3s ease; box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        display: flex; align-items: center; justify-content: space-between; gap: 20px;
    }
    .ac-product-card:hover { border-color: #111; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }


    .ac-product-info { display: flex; align-items: center; gap: 20px; flex: 1; }
    .ac-product-img { width: 80px; height: 80px; border-radius: 12px; object-fit: cover; background: #f9f9f9; }
    .ac-product-name { font-size: 14px; font-weight: 700; color: #111; text-decoration: none; text-transform: uppercase; }


    /* ── Quantity Controls ── */
    .ac-qty-container { display: flex; align-items: center; border: 1.5px solid #eee; border-radius: 12px; overflow: hidden; }
    .ac-qty-container button { width: 35px; height: 40px; background: transparent; border: none; font-size: 16px; cursor: pointer; transition: 0.2s; }
    .ac-qty-container button:hover { background: #f8f8f8; }
    .ac-qty-container input { width: 40px; text-align: center; border: none; font-size: 14px; font-weight: 700; background: transparent; }


    /* ── Summary Pane ── */
    .ac-summary-pane { background: #fff; border-radius: 30px; padding: 40px; border: 1.5px solid #eee; box-shadow: 0 10px 40px rgba(0,0,0,0.03); position: sticky; top: 40px; }
    .ac-summary-row { display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 14px; }
    .ac-summary-label { color: #888; font-weight: 700; text-transform: uppercase; font-size: 10px; letter-spacing: 0.1em; }
   
    .ac-btn-black { background: #111; color: #fff; border: none; border-radius: 50px; padding: 20px; width: 100%; font-size: 11px; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; transition: 0.3s; display: block; text-align: center; text-decoration: none; }
    .ac-btn-black:hover { background: #333; color: #fff; transform: translateY(-2px); }
</style>


<div class="ac-page-header" style="background: #FCF9F6; padding: 60px 0 30px; text-align: center; border-bottom: 1px solid #efeae4;">
    <h1 class="ac-page-title" style="font-family: 'Playfair Display', serif; font-size: 36px; color: #353b3e; margin-bottom: 8px;">Shopping Cart</h1>
    <div class="ac-page-breadcrumb" style="font-size: 11px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: #a3aab2;">
        <a href="{{ route('home.index') }}" style="color: #634d3a; text-decoration: none;">Home</a> 
        <span class="sep" style="margin: 0 8px; color: #d4cfc9;">></span> 
        <span style="color: #3c4245;">Your Shopping Bag</span>
    </div>
</div>

<div class="ac-white-content" style="background: #ffffff !important; padding-top: 40px; padding-bottom: 100px;">
    <div class="container">
        
        <div class="ac-steps-wrapper" style="display: flex; justify-content: space-between; border-bottom: 1px solid #efeae4; margin-bottom: 40px; padding-bottom: 0;">
            <a href="{{ route('cart.index') }}" class="ac-step active" style="flex: 1; text-align: left; padding: 0 0 20px 0; border-bottom: 2px solid #212529; text-decoration: none; color: #212529;">
                <h6 style="font-size: 14px; font-weight: 700; margin: 0 0 8px 0; color: inherit;">01 SHOPPING BAG</h6>
                <p style="font-size: 11px; margin: 0; color: #a3aab2;">Manage Your Items List</p>
            </a>
            <div class="ac-step" style="flex: 1; text-align: left; padding: 0 0 20px 0; color: #ccc;">
                <h6 style="font-size: 14px; font-weight: 700; margin: 0 0 8px 0;">02 SHIPPING AND CHECKOUT</h6>
                <p style="font-size: 11px; margin: 0; color: #bbb;">Delivery Details</p>
            </div>
            <div class="ac-step" style="flex: 1; text-align: left; padding: 0 0 20px 0; color: #ccc;">
                <h6 style="font-size: 14px; font-weight: 700; margin: 0 0 8px 0;">03 CONFIRMATION</h6>
                <p style="font-size: 11px; margin: 0; color: #bbb;">Review And Submit Your Order</p>
            </div>
        </div>

        @if($items->count() > 0)
        <div class="row gx-5">
            <div class="col-lg-8">
                <div style="display: flex; align-items: center; gap: 12px; font-size: 11px; font-weight: 800; letter-spacing: 0.15em; color: #333; text-transform: uppercase; margin-bottom: 20px;">
                    <span style="width: 24px; height: 2px; background: #333; display: inline-block;"></span>
                    Your Bag Items
                </div>
                
                <table style="width: 100%; border-collapse: separate; border-spacing: 0 15px;">
                    <thead>
                        <tr>
                            <th style="text-align: left; padding: 0 10px 10px; font-size: 11px; font-weight: 800; letter-spacing: 0.1em; color: #111;">PRODUCT</th>
                            <th style="text-align: center; padding: 0 10px 10px; font-size: 11px; font-weight: 800; letter-spacing: 0.1em; color: #111;">PRICE</th>
                            <th style="text-align: center; padding: 0 10px 10px; font-size: 11px; font-weight: 800; letter-spacing: 0.1em; color: #111;">QUANTITY</th>
                            <th style="text-align: right; padding: 0 10px 10px; font-size: 11px; font-weight: 800; letter-spacing: 0.1em; color: #111;">SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr style="background: #fff; box-shadow: 0 4px 20px rgba(0,0,0,0.02); transition: 0.3s;">
                            <td style="padding: 25px 20px; border-top: 1.5px solid #eee; border-bottom: 1.5px solid #eee; border-left: 1.5px solid #eee; border-top-left-radius: 20px; border-bottom-left-radius: 20px;">
                                <div style="display: flex; align-items: center; gap: 20px;">
                                    <img src="{{ asset('uploads/products/' . $item->product->main_product_image) }}" style="width: 70px; height: 70px; border-radius: 12px; object-fit: cover;">
                                    <div>
                                        <div style="font-size: 13px; font-weight: 800; text-transform: uppercase; color: #111;">{{ $item->product->product_name }}</div>
                                        <div style="font-size: 11px; color: #aaa; margin-top: 4px;">₱{{ number_format($item->effective_price, 2) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: center; padding: 25px 10px; border-top: 1.5px solid #eee; border-bottom: 1.5px solid #eee; font-size: 14px; font-weight: 600; color: #777;">
                                ₱{{ number_format($item->effective_price, 2) }}
                            </td>
                            <td style="text-align: center; padding: 25px 10px; border-top: 1.5px solid #eee; border-bottom: 1.5px solid #eee;">
                                <div style="display: flex; align-items: center; border: 1.5px solid #eee; border-radius: 12px; overflow: hidden; width: fit-content; margin: 0 auto;">
                                    <form method="POST" action="{{ route('cart.decrease', $item->Cart_Item_ID) }}" style="margin:0;">
                                        @csrf @method('PUT')
                                        <button type="submit" style="width: 35px; height: 40px; background: transparent; border: none; cursor: pointer;">-</button>
                                    </form>
                                    <input type="text" value="{{ $item->quantity }}" readonly style="width: 40px; text-align: center; border: none; font-size: 14px; font-weight: 700; background: transparent;">
                                    <form method="POST" action="{{ route('cart.increase', $item->Cart_Item_ID) }}" style="margin:0;">
                                        @csrf @method('PUT')
                                        <button type="submit" style="width: 35px; height: 40px; background: transparent; border: none; cursor: pointer;">+</button>
                                    </form>
                                </div>
                            </td>
                            <td style="text-align: right; padding: 25px 20px; border-top: 1.5px solid #eee; border-bottom: 1.5px solid #eee; border-right: 1.5px solid #eee; border-top-right-radius: 20px; border-bottom-right-radius: 20px;">
                                <div style="display: flex; align-items: center; justify-content: flex-end; gap: 15px;">
                                    <span style="font-weight: 800; font-size: 16px; color: #111;">₱{{ number_format($item->subtotal, 2) }}</span>
                                    <form method="POST" action="{{ route('cart.remove', $item->Cart_Item_ID) }}" style="margin:0;">
                                        @csrf @method('DELETE')
                                        <button type="submit" style="background:none; border:none; color:#ccc; font-size:20px; cursor:pointer;">&times;</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <form method="POST" action="{{ route('cart.empty') }}" class="mt-4">
                    @csrf @method('DELETE')
                    <button type="submit" style="background:none; border:none; color:#888; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; cursor:pointer;">Clear All Items</button>
                </form>
            </div>

            <div class="col-lg-4">
                <div class="ac-summary-pane" style="background: #fff; border-radius: 30px; padding: 40px; border: 1.5px solid #eee; box-shadow: 0 10px 40px rgba(0,0,0,0.03); position: sticky; top: 40px;">
                    <div style="font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 30px; color: #111;">Order Summary</div>
                    
                    <div class="ac-summary-row" style="display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 14px;">
                        <span style="color: #888; font-weight: 700; text-transform: uppercase; font-size: 10px; letter-spacing: 0.1em;">Subtotal</span>
                        <span style="color: #111; font-weight: 500;">₱{{ number_format($subtotal, 2) }}</span>
                    </div>

                    @if(Session::has('coupon'))
                    <div class="ac-summary-row" style="display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 14px;">
                        <span style="color: #d9534f; font-weight: 700; text-transform: uppercase; font-size: 10px; letter-spacing: 0.1em;">Discount ({{ Session::get('coupon')['code'] }})</span>
                        <span style="color: #d9534f; font-weight: 500;">-₱{{ number_format($discount, 2) }}</span>
                    </div>
                    @endif

                    <div class="ac-summary-row" style="display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 14px;">
                        <span style="color: #888; font-weight: 700; text-transform: uppercase; font-size: 10px; letter-spacing: 0.1em;">Tax</span>
                        <span style="color: #111; font-weight: 500;">₱{{ number_format($tax, 2) }}</span>
                    </div>

                    <!-- Coupon Box -->
                    <div class="coupon-section" style="margin-top: 25px; margin-bottom: 25px;">
                        @if(Session::has('coupon_success'))
                            <div style="font-size: 11px; color: #2e7d32; background: #e8f5e9; padding: 10px; border-radius: 8px; margin-bottom: 12px; font-weight: 500;">
                                {{ Session::get('coupon_success') }}
                            </div>
                        @elseif(Session::has('success'))
                            <div style="font-size: 11px; color: #2e7d32; background: #e8f5e9; padding: 10px; border-radius: 8px; margin-bottom: 12px; font-weight: 500;">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        @if(Session::has('error'))
                            <div style="font-size: 11px; color: #c62828; background: #ffebee; padding: 10px; border-radius: 8px; margin-bottom: 12px; font-weight: 500;">
                                {{ Session::get('error') }}
                            </div>
                        @endif

                        @if(!Session::has('coupon'))
                            <form action="{{ route('cart.coupon.apply') }}" method="POST" style="display: flex; gap: 8px; margin: 0;">
                                @csrf
                                <input type="text" name="coupon_code" placeholder="Enter coupon code" required style="flex: 1; border: 1px solid #dfd8d1; border-radius: 50px; padding: 12px 18px; font-size: 12px; outline: none; background: #fcfbfa; font-family: 'Inter', sans-serif;">
                                <button type="submit" style="background: #111; color: #fff; border: none; border-radius: 50px; padding: 0 20px; font-size: 10px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='#333'" onmouseout="this.style.background='#111'">Apply</button>
                            </form>
                        @else
                            <div style="display: flex; align-items: center; justify-content: space-between; background: #FAF7F2; border: 1.5px dashed #dfd8d1; border-radius: 12px; padding: 12px 18px;">
                                <div>
                                    <div style="font-size: 10px; font-weight: 800; color: #8c7e73; letter-spacing: 0.05em;">COUPON APPLIED</div>
                                    <div style="font-size: 13px; font-weight: 700; color: #634d3a;">{{ Session::get('coupon')['code'] }}</div>
                                </div>
                                <form action="{{ route('cart.coupon.remove') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; color: #d9534f; font-size: 18px; font-weight: 700; cursor: pointer;">&times;</button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <hr style="margin: 25px 0; border-color: #eee;">

                    <div class="ac-summary-row" style="display: flex; justify-content: space-between; margin-bottom: 30px;">
                        <span style="color:#111; font-size:12px; font-weight: 800; text-transform: uppercase;">Total</span>
                        <span style="font-size: 20px; font-weight: 800; color: #111;">₱{{ number_format($total, 2) }}</span>
                    </div>

                    <a href="{{ route('cart.checkout') }}" class="ac-btn-black" style="background: #111; color: #fff; border: none; border-radius: 50px; padding: 20px; width: 100%; font-size: 11px; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; transition: 0.3s; display: block; text-align: center; text-decoration: none;">PROCEED TO CHECKOUT</a>
                </div>
            </div>
        </div>
        @else
        <div style="text-align: center; padding: 100px 0;">
            <p style="color: #7a8288; font-size: 16px; margin-bottom: 30px;">Your bag is currently empty.</p>
            <a href="{{ route('shop.index') }}" class="ac-btn-black" style="display: inline-block; width: auto; background: #111; color: #fff; border-radius: 50px; padding: 18px 60px; font-size: 11px; font-weight: 700; text-decoration: none; text-transform: uppercase;">Return to Shop</a>
        </div>
        @endif
    </div>
</div>

@endsection

