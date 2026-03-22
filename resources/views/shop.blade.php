@extends('layouts.app')
@section('content')
<main class="pt-90">
    <section class="shop-main container d-flex pt-4 pt-xl-5">
        <div class="shop-sidebar side-sticky bg-body" id="shopFilter">
            <div class="aside-header d-flex d-lg-none align-items-center">
                <h3 class="text-uppercase fs-6 mb-0">Filter By</h3>
                <button class="btn-close-lg js-close-aside btn-close-aside ms-auto"></button>
            </div>

            <div class="pt-4 pt-lg-0"></div>

            <div class="accordion" id="categories-list">
                <div class="accordion-item mb-4 pb-3">
                    <h5 class="accordion-header" id="accordion-heading-1">
                        <button class="accordion-button p-0 border-0 fs-5 text-uppercase" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-filter-1" aria-expanded="true" aria-controls="accordion-filter-1">
                            Product Categories
                            <svg class="accordion-button__icon type2" viewBox="0 0 10 6" xmlns="http://www.w3.org/2000/svg">
                                <g aria-hidden="true" stroke="none" fill-rule="evenodd">
                                    <path d="M5.35668 0.159286C5.16235 -0.053094 4.83769 -0.0530941 4.64287 0.159286L0.147611 5.05963C-0.0392673 5.26334 -0.0512242 5.56245 0.124695 5.7704C0.282511 5.9569 0.546951 6.00288 0.749081 5.86476L5 1.92801L9.25032 5.86476C9.45659 6.0084 9.73031 5.95111 9.87889 5.72895C9.97022 5.59253 9.97022 5.41872 9.88607 5.2823L5.35668 0.159286Z"/>
                                </g>
                            </svg>
                        </button>
                    </h5>
                    <div id="accordion-filter-1" class="accordion-collapse collapse show border-0" aria-labelledby="accordion-heading-1" data-bs-parent="#categories-list">
                        <div class="accordion-body px-0 pb-0 pt-3">
                            <ul class="list list-inline mb-0">
                                @foreach($categories as $category)
                                <li class="list-item">
                                    <a href="{{ route('shop.index', ['categories' => $category->Category_ID]) }}" class="menu-link py-1">{{ $category->category_name }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="shop-list flex-grow-1">
            <div class="d-flex justify-content-between mb-4 pb-md-2">
                <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                    <a href="{{ route('home.index') }}" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                    <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                    <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
                </div>
            </div>

            <div class="products-grid row row-cols-2 row-cols-md-3" id="products-grid">
                @foreach($products as $product)
                <div class="product-card-wrapper">
                    <div class="product-card mb-3 mb-md-4 mb-xxl-5">
                        <div class="pc__img-wrapper">
                            <a href="{{ route('shop.product.details', ['slug' => $product->product_slug]) }}">
                                <img loading="lazy" src="{{ asset('uploads/products') }}/{{ $product->main_product_image }}" width="330" height="400" alt="{{ $product->product_name }}" class="pc__img">
                            </a>
                            @if(Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->content()->where('id', $product->Product_ID)->count() > 0)
                                <a href="{{ route('cart.index') }}" class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium" title="Go to Cart">Go to Cart</a>
                            @else
                                <form name="addtocart" method="POST" action="{{ route('cart.add') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product->Product_ID }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="name" value="{{ $product->product_name }}">
                                    <input type="hidden" name="price" value="{{ $product->is_on_sale == 1 && $product->sale_price ? $product->sale_price : $product->regular_price }}">
                                    <button type="submit" class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium" title="Add To Cart">Add To Cart</button>
                                </form>
                            @endif
                        </div>

                        <div class="pc__info position-relative">
                            <p class="pc__category">{{ $product->category->category_name }}</p>
                            <h6 class="pc__title"><a href="{{ route('shop.product.details', ['slug' => $product->product_slug]) }}">{{ $product->product_name }}</a></h6>
                            <div class="product-card__stock mb-1">
                                @if($product->quantity > 0)
                                    <span class="badge bg-success">In Stock: {{ $product->quantity }}</span>
                                @else
                                    <span class="badge bg-danger">Out of Stock</span>
                                @endif
                            </div>
                            <div class="product-card__price d-flex">
                                @if($product->is_on_sale == 1 && $product->sale_price)
                                <span class="money price price-old">${{ $product->regular_price }}</span>
                                <span class="money price price-sale">${{ $product->sale_price }}</span>
                                @else
                                <span class="money price">${{ $product->regular_price }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <nav class="shop-pages d-flex justify-content-between mt-3" aria-label="Page navigation">
                {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
            </nav>
        </div>
    </section>
</main>
@endsection
