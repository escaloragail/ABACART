@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
/* ── Color Palette matching your reference image ── */
body { background: #FCF9F6 !important; font-family: 'Inter', sans-serif; color: #333; }
.shop-main { max-width: 1400px; margin: 0 auto; gap: 60px; }

/* ── SIDEBAR CATEGORIES ── */
.shop-sidebar { background: transparent !important; width: 220px; border: none; }
.ac-sidebar-all {
    display: flex; align-items: center; gap: 10px;
    font-size: 11px; font-weight: 700; letter-spacing: 0.12em;
    color: #444; text-decoration: none; text-transform: uppercase; margin-bottom: 30px;
}
.ac-sidebar-all .ac-line { width: 20px; height: 1.5px; background: #333; }

.ac-sidebar-menu { list-style: none; padding: 0; margin: 0; }
.ac-sidebar-menu li { margin-bottom: 18px; }
.ac-sidebar-menu a {
    font-size: 10px; font-weight: 600; letter-spacing: 0.1em;
    color: #999; text-decoration: none; text-transform: uppercase;
    transition: all 0.2s ease;
    display: inline-block;
}
.ac-sidebar-menu a:hover, .ac-sidebar-menu a.active-cat { color: #333; }

/* ── PRODUCT GRID ── */
#products-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); 
    gap: 40px; width: 100%;
}

/* ── PRODUCT CARD ── */
.ac-product-card {
    background: #ffffff; border-radius: 20px; padding: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    border: none;
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
}
.ac-product-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.07); }

.ac-product-img-wrap {
    background: #F7F3EF; border-radius: 15px; width: 100%; aspect-ratio: 1;
    overflow: hidden; position: relative;
    display: flex; align-items: center; justify-content: center;
}
.ac-product-img-wrap img {
    width: 90%; height: 90%; object-fit: contain;
    transition: transform 0.6s ease;
}

/* ── ADJUSTED: View Details Overlay ── */
.ac-view-details-btn {
    position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%) translateY(10px);
    opacity: 0; background: #fff; color: #111; border: none; border-radius: 50px;
    padding: 12px 24px; font-size: 10px; font-weight: 700; letter-spacing: 0.1em;
    text-transform: uppercase; box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease; text-decoration: none;
}
.ac-product-card:hover .ac-view-details-btn { opacity: 1; transform: translateX(-50%) translateY(0); }

.ac-product-info { padding: 20px 5px 10px; text-align: left; }
.ac-product-title a { font-size: 14px; font-weight: 500; color: #111; text-decoration: none; }

.ac-price { font-family: 'Playfair Display', serif; font-size: 28px; color: #111; margin-top: 10px; display: block; }
.ac-price-old { font-size: 18px; color: #bbb; text-decoration: line-through; margin-right: 10px; }
.ac-price-sale { color: #8B4513; }

@media (max-width: 991px) { .shop-main { flex-direction: column; } .shop-sidebar { width: 100%; } }
</style>

<main class="pt-4">
    <section class="shop-main container d-flex mt-5">
        <aside class="shop-sidebar">
            <a href="{{ route('shop.index') }}" class="ac-sidebar-all">
                <span class="ac-line"></span> CATEGORIES
            </a>

            <ul class="ac-sidebar-menu">
                @foreach($categories as $category)
                <li>
                    <a href="{{ route('shop.index', ['categories' => $category->Category_ID]) }}" 
                       class="{{ request('categories') == $category->Category_ID ? 'active-cat' : '' }}">
                        {{ $category->category_name }}
                    </a>
                </li>
                @endforeach
            </ul>
        </aside>
        
        <div class="shop-list flex-grow-1">
            <div id="products-grid">
                @foreach($products as $product)
                <div class="ac-product-card">
                    <div class="ac-product-img-wrap">
                        <a href="{{ route('shop.product.details', ['slug' => $product->product_slug]) }}">
                            <img loading="lazy" src="{{ asset('uploads/products') }}/{{ $product->main_product_image }}" alt="{{ $product->product_name }}">
                        </a>
                        
                        <a href="{{ route('shop.product.details', ['slug' => $product->product_slug]) }}" class="ac-view-details-btn">
                            View Details
                        </a>
                    </div>

                    <div class="ac-product-info">
                        <h6 class="ac-product-title">
                            <a href="{{ route('shop.product.details', ['slug' => $product->product_slug]) }}">{{ $product->product_name }}</a>
                        </h6>
                        
                        <div class="ac-product-price">
                            @if($product->is_on_sale == 1 && $product->sale_price)
                                <span class="ac-price">
                                    <span class="ac-price-old">₱{{ number_format($product->regular_price) }}</span>
                                    <span class="ac-price-sale">₱{{ number_format($product->sale_price) }}</span>
                                </span>
                            @else
                                <span class="ac-price">₱{{ number_format($product->regular_price) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-5">
                {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </section>
</main>
@endsection