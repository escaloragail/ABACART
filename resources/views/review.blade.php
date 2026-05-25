@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    body {
        background: #ffffff !important;
        font-family: 'Inter', sans-serif;
        color: #111;
    }
    
    /* ── Content Area ── */
    .ac-white-content {
        background: #ffffff !important;
        padding-top: 40px;
        padding-bottom: 100px;
        min-height: 80vh;
    }

    /* ── Steps Header ── */
    .ac-steps-wrapper {
        display: flex;
        justify-content: space-between;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 50px;
        padding-bottom: 0;
    }
    .ac-step {
        flex: 1;
        text-align: left;
        padding: 0 0 20px 0;
        border-bottom: 2px solid transparent;
        text-decoration: none;
        color: #a0aec0;
        transition: 0.3s;
    }
    .ac-step.active {
        color: #111;
        border-bottom: 2px solid #111;
    }
    .ac-step h6 {
        font-size: 12px;
        font-weight: 800;
        margin: 0 0 5px 0;
        color: inherit;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }
    .ac-step p {
        font-size: 11px;
        margin: 0;
        color: #a0aec0;
    }

    /* ── Section Decoration ── */
    .ac-section-title { 
        display: flex;
        align-items: center;
        gap: 12px; 
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.15em; 
        color: #111;
        text-transform: uppercase;
        margin-bottom: 25px; 
    }
    .ac-section-title::before {
        content: "";
        width: 24px;
        height: 2px;
        background: #111;
        display: inline-block;
    }

    /* ── Review Card ── */
    .ac-review-card {
        background: #fff;
        border-radius: 16px;
        padding: 35px;
        margin-bottom: 30px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }
    .ac-label-tiny {
        font-size: 10px;
        font-weight: 800;
        color: #a0aec0;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 8px;
    }
    .ac-data-text {
        font-size: 15px;
        color: #2d3748;
        line-height: 1.6;
        margin-bottom: 0;
    }

    /* ── Product Rows ── */
    .product-row {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 20px 0;
        border-bottom: 1px solid #edf2f7;
    }
    .product-row:last-child {
        border-bottom: none;
    }

    /* ── Sidebar Summary ── */
    .ac-summary-pane { 
        background: #fff;
        border-radius: 16px;
        padding: 40px; 
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        position: sticky;
        top: 40px; 
    }
    .ac-summary-label {
        font-size: 11px;
        font-weight: 800;
        color: #a0aec0;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }
    .ac-summary-value {
        font-size: 15px;
        font-weight: 700;
        color: #111;
    }
    
    .ac-btn-black {
        background: #111;
        color: #fff;
        border: none;
        border-radius: 50px;
        padding: 20px;
        width: 100%;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        transition: 0.2s;
        display: block;
        text-align: center;
        text-decoration: none;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .ac-btn-black:hover {
        background: #2d3748;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }
    .payment-options { display: grid; gap: 12px; margin-bottom: 18px; }
    .payment-radio { display: none; }
    .payment-card {
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px;
        cursor: pointer;
        display: flex;
        gap: 12px;
        align-items: flex-start;
        transition: 0.2s ease;
        background: #fff;
    }
    .payment-radio:checked + .payment-card {
        border-color: #15803d;
        background: #f0fdf4;
        box-shadow: 0 8px 20px rgba(21, 128, 61, 0.08);
    }
    .payment-icon {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        background: #edf2f7;
        color: #111;
        flex-shrink: 0;
    }
    .payment-radio:checked + .payment-card .payment-icon { background: #15803d; color: #fff; }
    .payment-card-title {
        display: block;
        font-size: 13px;
        font-weight: 800;
        color: #111;
        margin: 0 0 3px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }
    .payment-card-text { display: block; font-size: 12px; color: #718096; margin: 0; line-height: 1.4; }
    .greenpay-reference { display: none; margin-bottom: 18px; }
    .greenpay-reference input,
    .greenpay-reference select {
        width: 100%;
        border: 1px solid #d8e7dd;
        border-radius: 12px;
        padding: 13px 15px;
        font-size: 13px;
        outline: none;
        background: #fff;
        margin-bottom: 10px;
    }
    .greenpay-reference input:focus,
    .greenpay-reference select:focus {
        border-color: #15803d;
        box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.1);
    }
    .greenpay-new-fields { display: none; }
    .greenpay-hint {
        font-size: 11px;
        color: #4b6b58;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 10px;
        padding: 10px 12px;
        margin-bottom: 10px;
        line-height: 1.4;
    }
    .field-error {
        color: #c62828;
        background: #ffebee;
        border-radius: 8px;
        padding: 9px 11px;
        font-size: 11px;
        font-weight: 600;
        margin-top: 8px;
    }
</style>

<div class="ac-white-content">
    <div class="container">
        
        <div class="row mb-5">
            <div class="col-12">
                <div class="ac-steps-wrapper">
                    <div class="ac-step"> 
                        <h6>01 SHOPPING BAG</h6>
                        <p>Manage Your Items List</p>
                    </div>
                    <div class="ac-step"> 
                        <h6>02 SHIPPING AND CHECKOUT</h6>
                        <p>Delivery Details</p>
                    </div>
                    <div class="ac-step active"> 
                        <h6>03 CONFIRMATION</h6>
                        <p>Review And Submit Your Order</p>
                    </div>
                </div>
            </div>
        </div>

        <form id="placeOrderForm" action="{{ route('cart.place_order') }}" method="POST">
            @csrf
            <input type="hidden" name="address_id" value="{{ request('address_id') }}">
            <input type="hidden" name="note" value="{{ $note }}">
            
            @if(request('address_id') == 'new')
                <input type="hidden" name="address_type" value="{{ $selectedAddress->address_type }}">
                <input type="hidden" name="Zone_Street_HouseNumber" value="{{ $selectedAddress->Zone_Street_HouseNumber }}">
                <input type="hidden" name="Barangay" value="{{ $selectedAddress->Barangay }}">
                <input type="hidden" name="City" value="{{ $selectedAddress->City }}">
                <input type="hidden" name="Province" value="{{ $selectedAddress->Province }}">
            @endif
        </form>

            <div class="row gx-5">
                <div class="col-lg-8">
                    <div class="ac-section-title">1. Delivery Details</div>
                    <div class="ac-review-card mb-5">
                        <div class="row">
                            <div class="col-md-7 border-end">
                                <div class="ac-label-tiny">Shipping To</div>
                                <h6 class="fw-bold text-uppercase mb-1" style="font-size: 13px; letter-spacing: 0.05em; color: #111;">{{ $selectedAddress->address_type }}</h6>
                                <p class="ac-data-text">
                                    {{ $selectedAddress->Zone_Street_HouseNumber }}, {{ $selectedAddress->Barangay }}<br>
                                    {{ $selectedAddress->City }}, {{ $selectedAddress->Province }}
                                </p>
                            </div>
                            <div class="col-md-5 ps-md-4">
                                <div class="ac-label-tiny">Payment Method</div>
                                <p class="ac-data-text fw-bold" style="color: #111;">Choose below before placing your order</p>
                                <div class="ac-label-tiny mt-4">Notes</div>
                                <p class="ac-data-text" style="font-style: italic; color: #718096;">"{{ $note ?? 'No special instructions.' }}"</p>
                            </div>
                        </div>
                    </div>

                    <div class="ac-section-title">2. Your Bag</div>
                    <div class="ac-review-card">
                        @foreach($cartItems as $item)
                            <div class="product-row d-flex justify-content-between align-items-center mb-3">
                                <div class="product-info">
                                    <h5 style="font-size: 14px; font-weight: 700; text-transform: uppercase; color: #111; letter-spacing: 0.05em; margin-bottom: 4px;">{{ $item->product->product_name }}</h5>
                                    <p style="font-size: 12px; color: #a0aec0; margin: 0;">Quantity: {{ $item->quantity }}</p>
                                </div>
                                <div class="text-end">
                                    <span style="font-size: 15px; font-weight: 700; color: #111;">₱{{ number_format($item->subtotal, 2) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div> 
                
                <div class="col-lg-4">
                    <div class="ac-summary-pane">
                        <div class="ac-section-title">Order Summary</div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="ac-summary-label">SUBTOTAL</span>
                            <span class="ac-summary-value">₱{{ number_format($subtotal, 2) }}</span>
                        </div>

                        @if(Session::has('coupon'))
                        <div class="d-flex justify-content-between mb-3">
                            <span class="ac-summary-label text-danger">DISCOUNT ({{ Session::get('coupon')['code'] }})</span>
                            <span class="ac-summary-value text-danger">-₱{{ number_format($discount, 2) }}</span>
                        </div>
                        @endif

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

                        <hr style="border-color: #e2e8f0; margin-bottom: 25px;">

                        <div class="ac-section-title">Payment Options</div>
                        <div class="payment-options">
                            <div>
                                <input form="placeOrderForm" type="radio" name="payment_mode" id="payment_cod" value="cod" class="payment-radio" {{ old('payment_mode', $paymentMode) !== 'greenpay' ? 'checked' : '' }}>
                                <label for="payment_cod" class="payment-card">
                                    <span class="payment-icon"><i class="fa fa-truck"></i></span>
                                    <span>
                                        <span class="payment-card-title">Cash on Delivery</span>
                                        <span class="payment-card-text">Pay when your order arrives.</span>
                                    </span>
                                </label>
                            </div>

                            <div>
                                <input form="placeOrderForm" type="radio" name="payment_mode" id="payment_greenpay" value="greenpay" class="payment-radio" {{ old('payment_mode', $paymentMode) === 'greenpay' ? 'checked' : '' }}>
                                <label for="payment_greenpay" class="payment-card">
                                    <span class="payment-icon"><i class="fa fa-credit-card"></i></span>
                                    <span>
                                        <span class="payment-card-title">GreenPay Manual Payment</span>
                                        <span class="payment-card-text">Choose saved GreenPay info or add a new one.</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div id="greenpayReferenceBox" class="greenpay-reference">
                            <div class="greenpay-hint">
                                Select your GreenPay information. If this is your first time, choose "Add new GreenPay information" and complete the fields below.
                            </div>

                            <select form="placeOrderForm" name="greenpay_account_id" id="greenpayAccountSelect">
                                @foreach($greenpayAccounts as $account)
                                    <option value="{{ $account->id }}" {{ old('greenpay_account_id') == $account->id ? 'selected' : '' }}>
                                        {{ $account->fullname }} - {{ $account->mobile_number }} - {{ $account->email }}
                                    </option>
                                @endforeach
                                <option value="new" {{ old('greenpay_account_id', $greenpayAccounts->isEmpty() ? 'new' : '') === 'new' ? 'selected' : '' }}>
                                    Add new GreenPay information
                                </option>
                            </select>
                            @error('greenpay_account_id')
                                <div class="field-error">{{ $message }}</div>
                            @enderror

                            <div id="greenpayNewFields" class="greenpay-new-fields">
                                <input form="placeOrderForm" type="text" name="greenpay_fullname" value="{{ old('greenpay_fullname', Auth::user()->name ?? '') }}" placeholder="GreenPay Full Name">
                                @error('greenpay_fullname')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror

                                <input form="placeOrderForm" type="text" name="greenpay_mobile_number" value="{{ old('greenpay_mobile_number', Auth::user()->phone_number ?? Auth::user()->mobile ?? '') }}" placeholder="GreenPay Mobile Number">
                                @error('greenpay_mobile_number')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror

                                <input form="placeOrderForm" type="email" name="greenpay_email" value="{{ old('greenpay_email', Auth::user()->email ?? '') }}" placeholder="GreenPay Email Address">
                                @error('greenpay_email')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <input form="placeOrderForm" type="text" name="payment_reference_number" value="{{ old('payment_reference_number') }}" placeholder="Enter GreenPay reference number">
                            @error('payment_reference_number')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <span class="fw-bold" style="font-size: 12px; letter-spacing: 0.1em; text-transform: uppercase; color: #111;">GRAND TOTAL</span>
                            <span style="font-size: 24px; font-weight: 800; color: #111;">₱{{ number_format($total, 2) }}</span>
                        </div>
                        <button type="submit" form="placeOrderForm" class="ac-btn-black">Place Order Now</button>

                        <p class="text-center mt-4 mb-0" style="font-size: 10px; color: #a0aec0; line-height: 1.5; font-weight: 500;">
                            By clicking "Place Order Now", you agree to our <br><strong>Terms of Service</strong> and <strong>Refund Policy</strong>.
                        </p>
                    </div>
                </div> 
            </div> 
    </div> 
</div> 

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cod = document.getElementById('payment_cod');
        const greenpay = document.getElementById('payment_greenpay');
        const referenceBox = document.getElementById('greenpayReferenceBox');
        const referenceInput = referenceBox.querySelector('input[name="payment_reference_number"]');
        const accountSelect = document.getElementById('greenpayAccountSelect');
        const newFields = document.getElementById('greenpayNewFields');
        const newFieldInputs = newFields.querySelectorAll('input');

        function toggleReference() {
            const showReference = greenpay.checked;
            referenceBox.style.display = showReference ? 'block' : 'none';
            referenceInput.required = showReference;
            toggleNewFields();
        }

        function toggleNewFields() {
            const showNewFields = greenpay.checked && accountSelect.value === 'new';
            newFields.style.display = showNewFields ? 'block' : 'none';
            newFieldInputs.forEach(input => input.required = showNewFields);
        }

        cod.addEventListener('change', toggleReference);
        greenpay.addEventListener('change', toggleReference);
        accountSelect.addEventListener('change', toggleNewFields);
        toggleReference();
    });
</script>

@endsection
