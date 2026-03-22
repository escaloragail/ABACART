@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
      <h2 class="page-title">Shipping and Checkout</h2>
      
      @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
      @endif
      <div class="checkout-steps">
        <a href="{{ route('cart.index') }}" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">01</span>
          <span class="checkout-steps__item-title">
            <span>Shopping Bag</span>
            <em>Manage Your Items List</em>
          </span>
        </a>
        <a href="{{ route('cart.checkout') }}" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">02</span>
          <span class="checkout-steps__item-title">
            <span>Shipping and Checkout</span>
            <em>Checkout Your Items List</em>
          </span>
        </a>
        <a href="#" class="checkout-steps__item">
          <span class="checkout-steps__item-number">03</span>
          <span class="checkout-steps__item-title">
            <span>Confirmation</span>
            <em>Review And Submit Your Order</em>
          </span>
        </a>
      </div>
      <form name="checkout-form" action="{{ route('cart.place.order') }}" method="POST">
        @csrf
        <div class="checkout-form">
          <div class="billing-info__wrapper">
            <div class="row">
              <div class="col-12">
                <h4>1. SELECT SHIPPING ADDRESS</h4>
                <div class="saved-addresses mb-4 mt-3">
                    @forelse($addresses as $addr)
                        <div class="form-check p-3 border rounded mb-2 address-item" style="cursor: pointer;">
                            <input class="form-check-input" type="radio" name="address_id" id="address_{{ $addr->Address_ID }}" value="{{ $addr->Address_ID }}" {{ $loop->first ? 'checked' : '' }} style="margin-left: 0;">
                            <label class="form-check-label w-100 ms-4" for="address_{{ $addr->Address_ID }}">
                                <strong>{{ $addr->address_type }}</strong><br>
                                {{ $addr->Zone_Street_HouseNumber }}, {{ $addr->Barangay }}, {{ $addr->City }}, {{ $addr->Province }}
                            </label>
                        </div>
                    @empty
                        <p class="text-muted">No saved addresses found. Please add a new one below.</p>
                    @endforelse
                    
                    <div class="form-check p-3 border rounded mb-2 address-item" style="cursor: pointer;">
                        <input class="form-check-input" type="radio" name="address_id" id="address_new" value="new" {{ $addresses->isEmpty() ? 'checked' : '' }} style="margin-left: 0;">
                        <label class="form-check-label w-100 ms-4" for="address_new">
                            <strong>Add New Address</strong>
                        </label>
                    </div>
                </div>
              </div>
            </div>

            <div id="new_address_form" style="{{ $addresses->isNotEmpty() ? 'display: none;' : '' }}">
                <div class="row mt-3">
                  <div class="col-md-6">
                    <div class="form-floating my-3">
                      <input type="text" class="form-control" name="Zone_Street_HouseNumber" value="{{ old('Zone_Street_HouseNumber') }}">
                      <label for="Zone_Street_HouseNumber">Zone / Street / House Number *</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating my-3">
                      <input type="text" class="form-control" name="Barangay" value="{{ old('Barangay') }}">
                      <label for="Barangay">Barangay *</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating my-3">
                      <input type="text" class="form-control" name="City" value="{{ old('City') }}">
                      <label for="City">Town / City *</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating my-3">
                      <input type="text" class="form-control" name="Province" value="{{ old('Province') }}">
                      <label for="Province">Province *</label>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-floating my-3">
                      <select name="address_type" class="form-control">
                          <option value="Home">Home</option>
                          <option value="Work">Work</option>
                      </select>
                      <label for="address_type">Address Type *</label>
                    </div>
                  </div>
                </div>
            </div>
            
            <hr class="my-5">

            <div class="row">
              <div class="col-12">
                <h4>2. MESSAGE FOR ADMIN (Optional)</h4>
                <div class="form-floating mt-3">
                  <textarea class="form-control" name="note" style="height: 100px" placeholder="Leave a message for the admin"></textarea>
                  <label for="note">Instructions or Note</label>
                </div>
              </div>
            </div>

            <hr class="my-5">
            
            <div class="row">
              <div class="col-6">
                <h4>3. PAYMENT MODE</h4>
              </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                     <div class="form-check">
                      <input class="form-check-input" type="radio" name="payment_mode" id="payment_cod" value="cod" checked>
                      <label class="form-check-label" for="payment_cod">
                        Cash on Delivery (COD)
                      </label>
                    </div>
                </div>
            </div>

          </div>
          <div class="checkout__totals-wrapper">
            <div class="sticky-content">
              <div class="checkout__totals">
                <h3>4. REVIEW ORDER</h3>
                <table class="checkout-cart-items">
                  <thead>
                    <tr>
                      <th>PRODUCT</th>
                      <th class="text-right">SUBTOTAL</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach(Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->content() as $item)
                        <tr>
                            <td>
                                {{ $item->name }} x {{ $item->qty }}
                            </td>
                            <td class="text-right">
                                ${{ $item->subtotal() }}
                            </td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
                <table class="checkout-totals">
                  <tbody>
                    @if(Session::has('coupon'))
                        <tr>
                        <th>SUBTOTAL</th>
                        <td class="text-right">${{ Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->subtotal() }}</td>
                        </tr>
                        <tr>
                        <th>DISCOUNT ({{ Session::get('coupon')['code'] }})</th>
                        <td class="text-right">-${{ Session::get('discounts')['discount'] }}</td>
                        </tr>
                        <tr>
                        <th>SUBTOTAL AFTER DISCOUNT</th>
                        <td class="text-right">${{ Session::get('discounts')['subtotal'] }}</td>
                        </tr>
                        <tr>
                        <th>TAX</th>
                        <td class="text-right">${{ Session::get('discounts')['tax'] }}</td>
                        </tr>
                        <tr>
                        <th>TOTAL</th>
                        <td class="text-right">${{ Session::get('discounts')['total'] }}</td>
                        </tr>
                    @else
                        <tr>
                        <th>SUBTOTAL</th>
                        <td class="text-right">${{ Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->subtotal() }}</td>
                        </tr>
                        <tr>
                        <th>TAX</th>
                        <td class="text-right">${{ Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->tax() }}</td>
                        </tr>
                        <tr>
                        <th>TOTAL</th>
                        <td class="text-right">${{ Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->total() }}</td>
                        </tr>
                    @endif
                  </tbody>
                </table>
              </div>
              @if (Session::has('success'))
                  <div class="alert alert-success mt-3">
                      {{ Session::get('success') }}
                  </div>
              @endif
              @if (Session::has('error'))
                  <div class="alert alert-danger mt-3">
                      {{ Session::get('error') }}
                  </div>
              @endif
              <button type="submit" class="btn btn-primary btn-checkout">PLACE ORDER</button>
            </div>
          </div>
        </div>
      </form>
    </section>
  </main>
@endsection

@push('scripts')
<script>
    $(function(){
        $('input[name="address_id"]').on('change', function(){
            if($(this).val() == 'new') {
                $('#new_address_form').slideDown();
            } else {
                $('#new_address_form').slideUp();
            }
        });

        $('.address-item').on('click', function(){
            $(this).find('input[name="address_id"]').prop('checked', true).trigger('change');
        });
    });
</script>
@endpush
