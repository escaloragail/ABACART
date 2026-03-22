@extends('layouts.app')
@section('content')

<main>


    <div class="container mw-1620 bg-white border-radius-10">


      @if($hot_deals->count() > 0)
      <section class="hot-deals container">
        <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">On Sale</h2>
        <div class="row">
          <div class="col-md-12">
            <div class="position-relative">
              <div class="swiper-container js-swiper-slider" data-settings='{
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": 4,
                  "slidesPerGroup": 4,
                  "effect": "none",
                  "loop": false,
                  "breakpoints": {
                    "320": {
                      "slidesPerView": 2,
                      "slidesPerGroup": 2,
                      "spaceBetween": 14
                    },
                    "768": {
                      "slidesPerView": 2,
                      "slidesPerGroup": 3,
                      "spaceBetween": 24
                    },
                    "992": {
                      "slidesPerView": 3,
                      "slidesPerGroup": 1,
                      "spaceBetween": 30,
                      "pagination": false
                    },
                    "1200": {
                      "slidesPerView": 4,
                      "slidesPerGroup": 1,
                      "spaceBetween": 30,
                      "pagination": false
                    }
                  }
                }'>
                <div class="swiper-wrapper">
                  @foreach($hot_deals as $product)
                  <div class="swiper-slide product-card product-card_style3">
                    <div class="pc__img-wrapper">
                      <a href="{{ route('shop.product.details', ['slug' => $product->product_slug]) }}">
                        <img loading="lazy" src="{{ asset('uploads/products') }}/{{ $product->main_product_image }}" width="258" height="313" alt="{{ $product->product_name }}" class="pc__img">
                      </a>
                    </div>

                    <div class="pc__info position-relative">
                      <h6 class="pc__title"><a href="{{ route('shop.product.details', ['slug' => $product->product_slug]) }}">{{ $product->product_name }}</a></h6>
                      <div class="product-card__stock mb-1">
                        @if($product->quantity > 0)
                          <span class="badge bg-success">In Stock: {{ $product->quantity }}</span>
                        @else
                          <span class="badge bg-danger">Out of Stock</span>
                        @endif
                      </div>
                      <div class="product-card__price d-flex align-items-center">
                        @if($product->is_on_sale == 1 && $product->sale_price)
                          <span class="money price-old">${{ $product->regular_price }}</span>
                          <span class="money price text-secondary">${{ $product->sale_price }}</span>
                        @else
                          <span class="money price text-secondary">${{ $product->regular_price }}</span>
                        @endif
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div><!-- /.swiper-wrapper -->
              </div><!-- /.swiper-container js-swiper-slider -->
            </div><!-- /.position-relative -->
          </div>
        </div>
      </section>
      @endif

      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

      <!-- Category Banners Removed as requested -->

      <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

      <section class="products-grid container">
        <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Featured Products</h2>

        <div class="row">
          @foreach($featured_products as $product)
          <div class="col-6 col-md-4 col-lg-3">
            <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
              <div class="pc__img-wrapper">
                <a href="{{ route('shop.product.details', ['slug' => $product->product_slug]) }}">
                  <img loading="lazy" src="{{ asset('uploads/products') }}/{{ $product->main_product_image }}" width="330" height="400" alt="{{ $product->product_name }}" class="pc__img">
                </a>
              </div>

              <div class="pc__info position-relative">
                <h6 class="pc__title"><a href="{{ route('shop.product.details', ['slug' => $product->product_slug]) }}">{{ $product->product_name }}</a></h6>
                <div class="product-card__stock mb-1">
                  @if($product->quantity > 0)
                    <span class="badge bg-success">In Stock: {{ $product->quantity }}</span>
                  @else
                    <span class="badge bg-danger">Out of Stock</span>
                  @endif
                </div>
                <div class="product-card__price d-flex align-items-center">
                  @if($product->is_on_sale == 1 && $product->sale_price)
                    <span class="money price-old">${{ $product->regular_price }}</span>
                    <span class="money price text-secondary">${{ $product->sale_price }}</span>
                  @else
                    <span class="money price text-secondary">${{ $product->regular_price }}</span>
                  @endif
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div><!-- /.row -->

        <div class="text-center mt-2">
          <a class="btn-link btn-link_lg default-underline text-uppercase fw-medium" href="#">Load More</a>
        </div>
      </section>
    </div>

    <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

  </main>

@endsection 