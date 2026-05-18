@extends('layouts.app')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* ── Reset and Page Setup ── */
body { background: #FAF7F2 !important; font-family: 'Inter', sans-serif; }
.product-single { max-width: 1100px; margin: 40px auto; padding: 0 20px; }

/* ── LEFT: GALLERY ── */
.ac-dt-main-img {
    background: #e1dfda; border-radius: 12px; padding: 24px;
    width: 100%; aspect-ratio: 1; display: flex; align-items: center; justify-content: center;
    margin-bottom: 16px;
}
.ac-dt-main-img img { max-width: 100%; max-height: 100%; object-fit: contain; mix-blend-mode: multiply; }
.ac-dt-thumbs { display: flex; gap: 12px; }
.ac-dt-thumb {
    width: 64px; height: 64px; border-radius: 8px; background: #e1dfda;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    padding: 6px; border: 2px solid transparent; transition: border-color 0.2s;
}
.ac-dt-thumb.active { border-color: #5d4a3d; }
.ac-dt-thumb img { max-width: 100%; max-height: 100%; object-fit: contain; mix-blend-mode: multiply; }

/* ── RIGHT: DETAILS ── */
.ac-dt-info { padding-left: 40px; }
.ac-dt-title { font-family: 'Playfair Display', serif; font-size: 34px; font-weight: 500; color: #353b3e; margin-bottom: 8px; }
.ac-dt-breadcrumb { font-size: 10px; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase; color: #a3aab2; margin-bottom: 24px; }
.ac-dt-breadcrumb a { color: #634d3a; text-decoration: none; }
.ac-dt-breadcrumb span.sep { margin: 0 8px; color: #dfd8d1; }
.ac-dt-meta { margin-bottom: 24px; display: flex; flex-wrap: wrap; gap: 16px; align-items: center; }
.ac-dt-sku { font-size: 11px; font-weight: 600; color: #8c98a4; letter-spacing: 0.1em; text-transform: uppercase; margin: 0; }
.ac-dt-desc { font-size: 12px; color: #7a8288; line-height: 1.6; margin-bottom: 30px; max-width: 440px; }
.ac-dt-price { margin-bottom: 30px; }
.ac-dt-price span.current-price { font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 600; color: #5d4a3d; }
.ac-dt-price span.old-price { font-family: 'Playfair Display', serif; font-size: 20px; color: #a3aab2; text-decoration: line-through; margin-left: 12px; }

/* ── FORM ELEMENTS ── */
.ac-dt-qty-label { font-size: 10px; font-weight: 700; color: #a3aab2; letter-spacing: 0.15em; text-transform: uppercase; margin-bottom: 12px; }
.ac-dt-qty-wrap { display: inline-flex; align-items: center; background: #ffffff; border-radius: 4px; border: 1px solid #dfd8d1; margin-bottom: 24px; padding: 4px 8px; }
.ac-dt-qty-wrap button { background: none; border: none; font-size: 18px; color: #5d4a3d; cursor: pointer; padding: 4px 12px; outline: none; }
.ac-dt-qty-wrap input { width: 36px; text-align: center; border: none; font-size: 13px; font-weight: 600; color: #3c4245; background: transparent; outline: none; }

.ac-dt-actions { display: flex; flex-direction: column; gap: 12px; max-width: 340px; margin-bottom: 40px;}
.ac-btn-outline { background: transparent; border: 1px solid #5d4a3d; color: #5d4a3d; font-size: 10px; font-weight: 700; letter-spacing: 0.2em; text-transform: uppercase; padding: 16px; border-radius: 4px; cursor: pointer; transition: all 0.3s ease; width: 100%; }
.ac-btn-solid { background: #634d3a; border: 1px solid #634d3a; color: #ffffff; font-size: 10px; font-weight: 700; letter-spacing: 0.2em; text-transform: uppercase; padding: 16px; border-radius: 4px; cursor: pointer; transition: all 0.3s ease; width: 100%; text-decoration: none; display: block; text-align: center;}

/* ── MINIMALIST POP-UP STYLING ── */
.demure-modal {
    width: 320px !important;
    padding: 30px 24px !important;
    border-radius: 16px !important;
    background: #FAF7F2 !important;
    border: 1px solid #dfd8d1 !important;
    box-shadow: 0 20px 50px rgba(99, 77, 58, 0.12) !important;
}
.demure-title {
    font-family: 'Playfair Display', serif !important;
    font-size: 20px !important;
    font-weight: 600 !important;
    color: #5d4a3d !important;
    margin-top: 15px !important;
    letter-spacing: 0.05em !important;
}
.demure-text {
    font-family: 'Inter', sans-serif !important;
    font-size: 11px !important;
    color: #8c7e73 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.1em !important;
    margin-bottom: 20px !important;
}
.demure-button {
    font-family: 'Inter', sans-serif !important;
    font-size: 10px !important;
    font-weight: 700 !important;
    letter-spacing: 0.2em !important;
    padding: 14px 28px !important;
    border-radius: 50px !important;
    background-color: #634d3a !important;
    color: #ffffff !important;
    text-transform: uppercase !important;
    border: none !important;
    transition: all 0.3s ease !important;
    box-shadow: 0 4px 12px rgba(99, 77, 58, 0.2) !important;
}
.demure-button:hover {
    background-color: #4e3c2d !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 16px rgba(99, 77, 58, 0.3) !important;
}
.demure-button-secondary {
    font-family: 'Inter', sans-serif !important;
    font-size: 10px !important;
    font-weight: 700 !important;
    letter-spacing: 0.2em !important;
    padding: 14px 28px !important;
    border-radius: 50px !important;
    background-color: transparent !important;
    color: #634d3a !important;
    text-transform: uppercase !important;
    border: 1px solid #634d3a !important;
    margin-left: 10px !important;
    transition: all 0.3s ease !important;
    cursor: pointer !important;
}
.demure-button-secondary:hover {
    background-color: rgba(99, 77, 58, 0.05) !important;
    transform: translateY(-2px) !important;
}
#wishlistHeartBtn:hover {
    transform: scale(1.08);
    box-shadow: 0 6px 20px rgba(0,0,0,0.12);
}

@media(max-width: 991px) { .ac-dt-info { padding-left: 0; margin-top: 40px; } }
</style>

<main class="pt-4">
    <section class="product-single container mt-4">
        <div class="row align-items-start">
            <div class="col-lg-6">
                <div class="ac-dt-main-img" id="mainImageWrap" style="position: relative;">
                    <!-- Wishlist Floating Heart Button -->
                    @php
                        $inWishlist = false;
                        if(Auth::check()) {
                            $inWishlist = \App\Models\CartItem::where('User_ID', Auth::user()->User_ID)
                                        ->where('instance', 'wishlist')
                                        ->where('Product_ID', $product->Product_ID)->exists();
                        }
                    @endphp
                    <button type="button" id="wishlistHeartBtn" onclick="toggleWishlist({{ $product->Product_ID }})" style="position: absolute; top: 20px; right: 20px; border: none; background: #ffffff; width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(0,0,0,0.08); cursor: pointer; transition: all 0.3s ease; z-index: 5;">
                        <svg id="heartSvg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22" style="transition: fill 0.3s ease, stroke 0.3s ease;">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" 
                                  fill="{{ $inWishlist ? '#e05c5c' : 'none' }}" 
                                  stroke="{{ $inWishlist ? '#e05c5c' : '#222222' }}" 
                                  stroke-width="2"/>
                        </svg>
                    </button>

                    <img id="mainProductImage" src="{{ asset('uploads/products') }}/{{ $product->main_product_image }}" alt="{{ $product->product_name }}">
                </div>
                <div class="ac-dt-thumbs">
                    <div class="ac-dt-thumb active" onclick="swapImage(this, '{{ asset('uploads/products') }}/{{ $product->main_product_image }}')">
                        <img src="{{ asset('uploads/products') }}/{{ $product->main_product_image }}" alt="Thumb">
                    </div>
                    @if($product->sub_product_images)
                        @foreach(explode(',', $product->sub_product_images) as $img)
                        <div class="ac-dt-thumb" onclick="swapImage(this, '{{ asset('uploads/products') }}/{{ $img }}')">
                            <img src="{{ asset('uploads/products') }}/{{ $img }}" alt="Thumb">
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="col-lg-5 offset-lg-1">
                <div class="ac-dt-info">
                    <div class="ac-dt-breadcrumb">
                        <a href="{{ route('home.index') }}">Home</a> <span class="sep">/</span> 
                        <a href="{{ route('shop.index') }}">The Shop</a> <span class="sep">/</span> 
                        <span style="color: #634d3a;">{{ $product->product_name }}</span>
                    </div>

                    <h1 class="ac-dt-title">{{ $product->product_name }}</h1>
                    
                    <div class="ac-dt-meta">
                        <span class="ac-dt-sku">SKU: {{ $product->SKU ?? 'N/A' }}</span>
                        <span class="ac-dt-sku" style="opacity: 0.3;">|</span>
                        <span class="ac-dt-sku">Category: {{ $product->category->category_name ?? 'N/A' }}</span>
                        @if($product->quantity > 0)
                            <span class="ac-dt-sku" style="opacity: 0.3;">|</span>
                            <span class="ac-dt-sku" style="color: #6da252;">In Stock: {{ $product->quantity }}</span>
                        @endif
                    </div>

                    <div class="ac-dt-desc">
                        <p>{{ $product->short_description }}</p>
                    </div>

                    <div class="ac-dt-price">
                        @if($product->is_on_sale == 1 && $product->sale_price)
                            <span class="current-price">₱{{ $product->sale_price }}</span>
                            <span class="old-price">₱{{ $product->regular_price }}</span>
                        @else
                            <span class="current-price">₱{{ $product->regular_price }}</span>
                        @endif
                    </div>

                    @php
                        $inCart = false;
                        if(Auth::check()) {
                            $inCart = \App\Models\CartItem::where('User_ID', Auth::user()->User_ID)
                                        ->where('instance', 'cart')
                                        ->where('Product_ID', $product->Product_ID)->exists();
                        }
                    @endphp

                    @if($product->quantity <= 0)
                        <div class="alert alert-danger mb-4">Out of Stock</div>
                    @else
                        <form id="productDetailsForm" method="POST" action="{{ route('cart.add') }}">
                            @csrf
                            <div class="ac-dt-qty-label">Select Quantity</div>
                            <div class="ac-dt-qty-wrap">
                                <button type="button" onclick="document.getElementById('qtyInput').stepDown()">-</button>
                                <input type="number" id="qtyInput" name="quantity" value="1" min="1" max="{{ $product->quantity }}">
                                <button type="button" onclick="document.getElementById('qtyInput').stepUp()">+</button>
                            </div>

                            <input type="hidden" name="id" value="{{ $product->Product_ID }}">
                            <input type="hidden" name="name" value="{{ $product->product_name }}">
                            <input type="hidden" name="price" value="{{ $product->is_on_sale == 1 && $product->sale_price ? $product->sale_price : $product->regular_price }}">
                            
                            <div class="ac-dt-actions">
                                <button type="button" id="addToCartBtn" class="ac-btn-outline">ADD TO CART</button>
                                <button type="button" id="buyNowBtn" class="ac-btn-solid">BUY NOW</button>

                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    function swapImage(thumbElem, imgUrl) {
        document.getElementById('mainProductImage').src = imgUrl;
        document.querySelectorAll('.ac-dt-thumb').forEach(el => el.classList.remove('active'));
        thumbElem.classList.add('active');
    }

    const form = document.getElementById('productDetailsForm');

    // --- BUY NOW LOGIC (Direct to Cart) ---
    document.getElementById('buyNowBtn')?.addEventListener('click', function() {
        const formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        }).then(() => {
            window.location.href = "{{ route('cart.index') }}";
        });
    });

    // --- ADD TO CART LOGIC (Minimal Pop-up) ---
    document.getElementById('addToCartBtn')?.addEventListener('click', function() {
        const formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        }).then(() => {
            Swal.fire({
                title: 'ADDED TO BASKET',
                text: 'Selection saved to your collection',
                icon: 'success',
                iconColor: '#634d3a',
                showConfirmButton: true,
                confirmButtonText: 'CONTINUE SHOPPING',
                background: '#FAF7F2',
                buttonsStyling: false,
                customClass: {
                    popup: 'demure-modal',
                    title: 'demure-title',
                    htmlContainer: 'demure-text',
                    confirmButton: 'demure-button'
                }
            }).then(() => {
                window.location.reload();
            });
        });
    });

    // --- WISHLIST TOGGLE LOGIC ---
    window.toggleWishlist = function(productId) {
        @if(!Auth::check())
            window.location.href = "{{ route('login') }}";
            return;
        @endif

        const heartSvg = document.getElementById('heartSvg');
        const heartPath = heartSvg.querySelector('path');

        fetch("{{ route('wishlist.add') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify({ id: productId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 200) {
                if (data.added) {
                    heartPath.setAttribute('fill', '#e05c5c');
                    heartPath.setAttribute('stroke', '#e05c5c');

                    // Show premium SweetAlert confirmation
                    Swal.fire({
                        title: 'WISHLIST UPDATED',
                        text: 'Product added to your saved favorites',
                        icon: 'success',
                        iconColor: '#634d3a',
                        showConfirmButton: true,
                        confirmButtonText: 'VIEW WISHLIST',
                        showCancelButton: true,
                        cancelButtonText: 'CONTINUE SHOPPING',
                        background: '#FAF7F2',
                        buttonsStyling: false,
                        customClass: {
                            popup: 'demure-modal',
                            title: 'demure-title',
                            htmlContainer: 'demure-text',
                            confirmButton: 'demure-button',
                            cancelButton: 'demure-button-secondary'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('wishlist.index') }}";
                        } else {
                            window.location.reload();
                        }
                    });
                } else {
                    heartPath.setAttribute('fill', 'none');
                    heartPath.setAttribute('stroke', '#222222');

                    // Show premium SweetAlert removal confirmation
                    Swal.fire({
                        title: 'WISHLIST REMOVED',
                        text: 'Product removed from your saved favorites',
                        icon: 'success',
                        iconColor: '#634d3a',
                        showConfirmButton: true,
                        confirmButtonText: 'CONTINUE SHOPPING',
                        background: '#FAF7F2',
                        buttonsStyling: false,
                        customClass: {
                            popup: 'demure-modal',
                            title: 'demure-title',
                            htmlContainer: 'demure-text',
                            confirmButton: 'demure-button'
                        }
                    }).then(() => {
                        window.location.reload();
                    });
                }
            }
        });
    }
</script>

@endsection