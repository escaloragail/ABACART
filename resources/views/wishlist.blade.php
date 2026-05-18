@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
      <h2 class="page-title">Wishlist</h2>
      <div class="checkout-steps">
        <a href="{{ route('shop.index') }}" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">01</span>
          <span class="checkout-steps__item-title">
            <span>Shop</span>
            <em>Browse More Products</em>
          </span>
        </a>
        <a href="{{ route('wishlist.index') }}" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">02</span>
          <span class="checkout-steps__item-title">
            <span>Wishlist</span>
            <em>Manage Your Saved Items List</em>
          </span>
        </a>
      </div>
      <div class="shopping-cart">
        @if($items->count() > 0)
        <div class="cart-table__wrapper">
          <table class="cart-table">
            <thead>
              <tr>
                <th>Product</th>
                <th></th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Action</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($items as $item)
              <tr>
                <td>
                  <div class="shopping-cart__product-item">
                    <img loading="lazy" src="{{ asset('uploads/products') }}/{{ $item->product->main_product_image }}" width="120" height="120" alt="{{ $item->product->product_name }}" />
                  </div>
                </td>
                <td>
                  <div class="shopping-cart__product-item__detail">
                    <h4>{{ $item->product->product_name }}</h4>
                  </div>
                </td>
                <td>
                  <span class="shopping-cart__product-price">${{ number_format($item->effective_price, 2) }}</span>
                </td>
                <td>
                  <span class="shopping-cart__subtotal">{{ $item->quantity }}</span>
                </td>
                <td>
                    <form method="POST" action="{{ route('wishlist.move.to.cart', ['id' => $item->Cart_Item_ID]) }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary">Move to Cart</button>
                    </form>
                </td>
                <td>
                    <form method="POST" action="{{ route('wishlist.remove', ['id' => $item->Cart_Item_ID]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger remove-cart">
                            Remove
                        </button>
                    </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="cart-table-footer">
            <form method="POST" action="{{ route('wishlist.empty') }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-light" type="submit">CLEAR WISHLIST</button>
            </form>
          </div>
        </div>
        @else
            <div class="row">
                <div class="col-md-12 text-center pt-5 pb-5">
                    <p>No item found in your wishlist</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-info">Shop Now</a>
                </div>
            </div>
        @endif
      </div>
    </section>
</main>
@endsection
