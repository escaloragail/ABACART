@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* ── Header Area (Off-White - Matches Cart) ── */
    .ac-page-header { background: #FCF9F6; padding: 60px 0 30px; text-align: center; border-bottom: 1px solid #efeae4; }
    .ac-page-title { font-family: 'Playfair Display', serif; font-size: 36px; color: #353b3e; margin-bottom: 8px; }
    .ac-page-breadcrumb { font-size: 11px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: #a3aab2; }

    /* ── Content Area ── */
    .ac-white-content { background: #ffffff !important; padding-top: 50px; padding-bottom: 100px; min-height: 80vh; }

    /* ── Action Buttons ── */
    .ac-btn-black { background: #111; color: #fff; border: none; border-radius: 50px; padding: 12px 30px; font-size: 10px; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; transition: 0.3s; display: inline-block; text-align: center; text-decoration: none; cursor: pointer; }
    .ac-btn-black:hover { background: #333; color: #fff; transform: translateY(-1px); }
</style>

<div class="ac-page-header">
    <h1 class="ac-page-title">My Wishlist</h1>
    <div class="ac-page-breadcrumb">
        <a href="{{ route('home.index') }}" style="color: #634d3a; text-decoration: none;">Home</a> 
        <span class="sep" style="margin: 0 8px; color: #d4cfc9;">></span> 
        <span style="color: #3c4245;">Wishlist</span>
    </div>
</div>

<div class="ac-white-content">
    <div class="container">

        @if($items->count() > 0)
        <div class="row">
            <div class="col-12">
                <div style="display: flex; align-items: center; gap: 12px; font-size: 11px; font-weight: 800; letter-spacing: 0.15em; color: #111; text-transform: uppercase; margin-bottom: 25px;">
                    <span style="width: 24px; height: 2px; background: #111; display: inline-block;"></span>
                    Your Wishlist Items ({{ $items->count() }})
                </div>
                
                <table style="width: 100%; border-collapse: separate; border-spacing: 0 15px;">
                    <thead>
                        <tr>
                            <th style="text-align: left; padding: 0 10px 10px; font-size: 11px; font-weight: 800; letter-spacing: 0.1em; color: #111;">PRODUCT</th>
                            <th style="text-align: center; padding: 0 10px 10px; font-size: 11px; font-weight: 800; letter-spacing: 0.1em; color: #111;">PRICE</th>
                            <th style="text-align: center; padding: 0 10px 10px; font-size: 11px; font-weight: 800; letter-spacing: 0.1em; color: #111;">QUANTITY</th>
                            <th style="text-align: right; padding: 0 10px 10px; font-size: 11px; font-weight: 800; letter-spacing: 0.1em; color: #111;">ACTIONS</th>
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
                                        <div style="font-size: 11px; color: #aaa; margin-top: 4px;">Category: {{ $item->product->category->category_name ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: center; padding: 25px 10px; border-top: 1.5px solid #eee; border-bottom: 1.5px solid #eee; font-size: 14px; font-weight: 600; color: #111;">
                                ₱{{ number_format($item->effective_price, 2) }}
                            </td>
                            <td style="text-align: center; padding: 25px 10px; border-top: 1.5px solid #eee; border-bottom: 1.5px solid #eee; font-size: 14px; font-weight: 600; color: #777;">
                                {{ $item->quantity }}
                            </td>
                            <td style="text-align: right; padding: 25px 20px; border-top: 1.5px solid #eee; border-bottom: 1.5px solid #eee; border-right: 1.5px solid #eee; border-top-right-radius: 20px; border-bottom-right-radius: 20px;">
                                <div style="display: flex; align-items: center; justify-content: flex-end; gap: 15px;">
                                    <form method="POST" action="{{ route('wishlist.move.to.cart', ['id' => $item->Cart_Item_ID]) }}" style="margin: 0;">
                                        @csrf
                                        <button type="submit" class="ac-btn-black">Move to Cart</button>
                                    </form>
                                    <form method="POST" action="{{ route('wishlist.remove', ['id' => $item->Cart_Item_ID]) }}" style="margin:0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background:none; border:none; color:#ccc; font-size:20px; cursor:pointer;" title="Remove from Wishlist">&times;</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <form method="POST" action="{{ route('wishlist.empty') }}" class="mt-4">
                    @csrf @method('DELETE')
                    <button type="submit" style="background:none; border:none; color:#888; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; cursor:pointer; transition:0.2s;" onmouseover="this.style.color='#d9534f'" onmouseout="this.style.color='#888'">Clear Wishlist Collection</button>
                </form>
            </div>
        </div>
        @else
        <div style="text-align: center; padding: 120px 0;">
            <p style="color: #7a8288; font-size: 16px; margin-bottom: 35px;">Your wishlist is currently empty.</p>
            <a href="{{ route('shop.index') }}" class="ac-btn-black" style="padding: 18px 60px;">Explore Collection</a>
        </div>
        @endif
    </div>
</div>

@endsection
