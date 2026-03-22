@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-md-1 pb-md-3"></div>
    <section class="product-single container">
        <div class="row">
            <div class="col-lg-7">
                <div class="product-single__media" data-qnt="1">
                    <div class="product-single__image">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide product-single__image-item">
                                    <img loading="lazy" class="h-auto w-100" src="{{ asset('uploads/products') }}/{{ $product->main_product_image }}" width="674" height="674" alt="{{ $product->product_name }}" />
                                </div>
                                @if($product->sub_product_images)
                                    @foreach(explode(',', $product->sub_product_images) as $img)
                                    <div class="swiper-slide product-single__image-item">
                                        <img loading="lazy" class="h-auto w-100" src="{{ asset('uploads/products') }}/{{ $img }}" width="674" height="674" alt="{{ $product->product_name }}" />
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="d-flex justify-content-between mb-4 pb-md-2">
                    <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                        <a href="{{ route('home.index') }}" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                        <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                        <a href="{{ route('shop.index') }}" class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
                        <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                        <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">{{ $product->product_name }}</a>
                    </div>
                </div>
                <h1 class="product-single__name">{{ $product->product_name }}</h1>
                <div class="product-single__price">
                    @if($product->is_on_sale == 1 && $product->sale_price)
                        <span class="current-price">${{ $product->sale_price }}</span>
                        <span class="old-price">${{ $product->regular_price }}</span>
                    @else
                        <span class="current-price">${{ $product->regular_price }}</span>
                    @endif
                </div>
                <div class="product-single__short-desc">
                    <p>{{ $product->short_description }}</p>
                </div>
                <div class="product-single__stock mb-3">
                    @if($product->quantity > 0)
                        <span class="badge bg-success p-2">In Stock: {{ $product->quantity }} left</span>
                    @else
                        <span class="badge bg-danger p-2">Out of Stock</span>
                    @endif
                </div>
                
                @if($product->quantity <= 0)
                    <div class="alert alert-danger">This item is currently out of stock.</div>
                @elseif(Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->content()->where('id', $product->Product_ID)->count() > 0)
                    <div class="product-single__addtocart">
                        <a href="{{ route('cart.index') }}" class="btn btn-warning btn-lg mb-3">Go to Cart</a>
                    </div>
                @else
                    <form name="addtocart" method="POST" action="{{ route('cart.add') }}">
                        @csrf
                        <div class="product-single__addtocart">
                            <div class="qty-control position-relative">
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->quantity }}" class="qty-control__number text-center">
                                <div class="qty-control__reduce">-</div>
                                <div class="qty-control__increase">+</div>
                            </div>
                            <input type="hidden" name="id" value="{{ $product->Product_ID }}">
                            <input type="hidden" name="name" value="{{ $product->product_name }}">
                            <input type="hidden" name="price" value="{{ $product->is_on_sale == 1 && $product->sale_price ? $product->sale_price : $product->regular_price }}">
                            <!-- Use a normal submit button -->
                            <button type="submit" class="btn btn-primary btn-addtocart mt-3">Add to Cart</button>
                        </div>
                    </form>
                @endif
                
                <div class="product-single__meta-info mt-4">
                    <div class="meta-item">
                        <label>SKU:</label>
                        <span>{{ $product->SKU }}</span>
                    </div>
                    <div class="meta-item">
                        <label>Categories:</label>
                        <span>{{ $product->category->category_name }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="product-single__details-tab">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link nav-link_underscore active" id="tab-description-tab" data-bs-toggle="tab" href="#tab-description" role="tab" aria-controls="tab-description" aria-selected="true">Description</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-description" role="tabpanel" aria-labelledby="tab-description-tab">
                    <div class="product-single__description">
                        {{ $product->product_description }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="products-carousel container">
        <h2 class="h3 text-uppercase mb-4 pb-xl-2 mb-xl-4">Related <strong>Products</strong></h2>

        <div id="related_products" class="position-relative">
            <div class="swiper-container js-swiper-slider" data-settings='{"autoplay": false, "slidesPerView": 4, "slidesPerGroup": 4, "effect": "none", "loop": false}'>
                <div class="swiper-wrapper">
                    @foreach($rproducts as $rproduct)
                    <div class="swiper-slide product-card">
                        <div class="pc__img-wrapper">
                            <a href="{{ route('shop.product.details', ['slug' => $rproduct->product_slug]) }}">
                                <img loading="lazy" src="{{ asset('uploads/products') }}/{{ $rproduct->main_product_image }}" width="330" height="400" alt="{{ $rproduct->product_name }}" class="pc__img">
                            </a>
                            @if(Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->content()->where('id', $rproduct->Product_ID)->count() > 0)
                                <a href="{{ route('cart.index') }}" class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium" title="Go to Cart">Go to Cart</a>
                            @else
                                <form name="addtocart" method="POST" action="{{ route('cart.add') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $rproduct->Product_ID }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="name" value="{{ $rproduct->product_name }}">
                                    <input type="hidden" name="price" value="{{ $rproduct->sale_price == '' ? $rproduct->regular_price : $rproduct->sale_price }}">
                                    <button type="submit" class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium" title="Add To Cart">Add To Cart</button>
                                </form>
                            @endif
                        </div>

                        <div class="pc__info position-relative">
                            <p class="pc__category">{{ $rproduct->category->category_name }}</p>
                            <h6 class="pc__title"><a href="{{ route('shop.product.details', ['slug' => $rproduct->product_slug]) }}">{{ $rproduct->product_name }}</a></h6>
                            <div class="product-card__price d-flex">
                                @if($rproduct->is_on_sale && $rproduct->sale_price)
                                <span class="money price price-old">${{ $rproduct->regular_price }}</span>
                                <span class="money price price-sale">${{ $rproduct->sale_price }}</span>
                                @else
                                <span class="money price">${{ $rproduct->regular_price }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
