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

        <form action="{{ route('cart.place_order') }}" method="POST">
            @csrf
            <input type="hidden" name="address_id" value="{{ request('address_id') }}">
            <input type="hidden" name="payment_mode" value="{{ $paymentMode }}">
            <input type="hidden" name="note" value="{{ $note }}">
            
            @if(request('address_id') == 'new')
                <input type="hidden" name="address_type" value="{{ $selectedAddress->address_type }}">
                <input type="hidden" name="Zone_Street_HouseNumber" value="{{ $selectedAddress->Zone_Street_HouseNumber }}">
                <input type="hidden" name="Barangay" value="{{ $selectedAddress->Barangay }}">
                <input type="hidden" name="City" value="{{ $selectedAddress->City }}">
                <input type="hidden" name="Province" value="{{ $selectedAddress->Province }}">
            @endif

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
                                <p class="ac-data-text fw-bold" style="color: #111;">Cash on Delivery</p>
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
                        <div class="d-flex justify-content-between mb-4">
                            <span class="ac-summary-label">TAX (12%)</span>
                            <span class="ac-summary-value">₱{{ number_format($tax, 2) }}</span>
                        </div>
                        <hr style="border-color: #e2e8f0; margin-bottom: 25px;">
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <span class="fw-bold" style="font-size: 12px; letter-spacing: 0.1em; text-transform: uppercase; color: #111;">TOTAL DUE</span>
                            <span style="font-size: 24px; font-weight: 800; color: #111;">₱{{ number_format($total, 2) }}</span>
                        </div>
                        <button type="submit" class="ac-btn-black">Place Order Now</button>

                        <p class="text-center mt-4 mb-0" style="font-size: 10px; color: #a0aec0; line-height: 1.5; font-weight: 500;">
                            By clicking "Place Order Now", you agree to our <br><strong>Terms of Service</strong> and <strong>Refund Policy</strong>.
                        </p>
                    </div>
                </div> 
            </div> 
        </form>
    </div> 
</div> 

@endsection