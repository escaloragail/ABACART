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
        margin-bottom: 30px; 
    }
    .ac-section-title::before {
        content: "";
        width: 24px;
        height: 2px;
        background: #111;
        display: inline-block;
    }

    /* ── Cards & Inputs (Darker Borders) ── */
    .ac-card-option {
        background: #fff;
        border-radius: 16px;
        padding: 25px 30px;
        margin-bottom: 15px; 
        cursor: pointer;
        border: 1px solid #e2e8f0;
        transition: all 0.25s ease;
        display: flex;
        align-items: flex-start;
        gap: 20px;
        width: 100%;
    }
    .ac-radio-input {
        display: none;
    }
    .ac-radio-circle {
        width: 22px;
        height: 22px;
        border: 1px solid #cbd5e1;
        border-radius: 50%;
        flex-shrink: 0;
        margin-top: 2px;
        position: relative;
        transition: all 0.2s ease;
    }
    
    .ac-radio-input:checked + .ac-card-option {
        border-color: #111 !important;
        background: #fafafa;
    }
    .ac-radio-input:checked + .ac-card-option .ac-radio-circle {
        border-color: #111;
        background: #111;
    }
    .ac-radio-input:checked + .ac-card-option .ac-radio-circle::after {
        content: "";
        width: 8px;
        height: 8px;
        background: #fff;
        border-radius: 50%;
        position: absolute;
        top: 6px;
        left: 6px;
    }

    /* ── Form Inputs ── */
    .form-control, .form-select {
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 14px !important;
        color: #111 !important;
        background-color: #fff !important;
        transition: all 0.2s ease !important;
    }

    .form-control:focus, .form-select:focus {
        border-color: #111 !important;
        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05) !important;
        color: #111 !important;
        outline: none !important;
    }

    .form-floating > label {
        font-family: 'Inter', sans-serif !important;
        font-size: 12px !important;
        color: #a0aec0 !important;
        transition: all 0.2s ease !important;
        text-transform: uppercase !important;
        font-weight: 700 !important;
        letter-spacing: 0.05em !important;
    }

    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label,
    .form-floating > .form-select ~ label {
        color: #111 !important;
    }

    .ac-textarea {
        height: 120px !important;
        border-radius: 16px !important;
        padding: 18px !important;
    }

    /* ── Large Button ── */
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
        
        <div class="ac-steps-wrapper">
            <div class="ac-step"><h6>01 SHOPPING BAG</h6><p>Manage Your Items List</p></div>
            <div class="ac-step active"><h6>02 SHIPPING AND CHECKOUT</h6><p>Delivery Details</p></div>
            <div class="ac-step"><h6>03 CONFIRMATION</h6><p>Review And Submit Your Order</p></div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-7"> 
                <form action="{{ route('cart.review') }}" method="GET">
                    
                    <div class="ac-section-title">1. Select Delivery Address</div>
                    
                    <div class="address-options mb-4">
                        @forelse($addresses as $addr)
                            <div class="w-100 mb-3">
                                <input type="radio" name="address_id" id="addr_{{ $addr->Address_ID }}" value="{{ $addr->Address_ID }}" class="ac-radio-input" {{ $loop->first ? 'checked' : '' }} onchange="toggleNewAddress(false)">
                                <label class="ac-card-option" for="addr_{{ $addr->Address_ID }}">
                                    <div class="ac-radio-circle"></div>
                                    <div class="ac-card-content">
                                        <h6 class="fw-bold mb-1 text-uppercase" style="font-size: 13px; letter-spacing: 0.05em; color: #111;">{{ $addr->address_type }}</h6>
                                        <p class="mb-1" style="font-size: 14px; font-weight: 600; color: #111;">{{ Auth::user()->name }} <span class="text-muted fw-normal mx-1">|</span> {{ Auth::user()->phone_number ?? Auth::user()->mobile }}</p>
                                        <p class="mb-0 text-muted" style="font-size: 14px; line-height: 1.5;">{{ $addr->Zone_Street_HouseNumber }}, {{ $addr->Barangay }}, {{ $addr->City }}</p>
                                    </div>
                                </label>
                            </div>
                        @empty
                        @endforelse
                        
                        <div class="w-100 mb-3">
                            <input type="radio" name="address_id" id="addr_new" value="new" class="ac-radio-input" {{ $addresses->isEmpty() ? 'checked' : '' }} onchange="toggleNewAddress(true)">
                            <label class="ac-card-option" for="addr_new">
                                <div class="ac-radio-circle"></div>
                                <div class="ac-card-content">
                                    <h6 class="fw-bold mb-1 text-uppercase" style="font-size: 13px; letter-spacing: 0.05em; color: #111;">+ Add New Address</h6>
                                    <p class="mb-0 text-muted" style="font-size: 14px; line-height: 1.5;">Enter a different delivery location</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div id="new_address_form" style="{{ $addresses->isNotEmpty() ? 'display: none;' : '' }} background: #fff; padding: 40px; border-radius: 25px; margin-bottom: 30px; border: 1px solid #e2e8f0;">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="Zone_Street_HouseNumber" placeholder="Street" value="{{ old('Zone_Street_HouseNumber') }}">
                                    <label>Street / House No. *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="Barangay" placeholder="Barangay" value="{{ old('Barangay') }}">
                                    <label>Barangay *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="City" placeholder="City" value="{{ old('City') }}">
                                    <label>City / Town *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="Province" placeholder="Province" value="{{ old('Province') }}">
                                    <label>Province *</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <select class="form-select" name="address_type">
                                        <option value="Home">Home</option>
                                        <option value="Work">Work</option>
                                    </select>
                                    <label>Address Label</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ac-section-title mt-5">2. Instructions</div>
                    <div class="form-floating mb-5">
                        <textarea class="form-control ac-textarea" name="note" placeholder="Special Instructions (Optional)">{{ old('note') }}</textarea>
                        <label>Special Instructions (Optional)</label>
                    </div>

                    <input type="hidden" name="payment_mode" value="cod">

                    <div class="text-center">
                        <button type="submit" class="ac-btn-black animate-button" style="max-width: 450px; margin: 0 auto;">
                            Continue to Review
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleNewAddress(show) {
        document.getElementById('new_address_form').style.display = show ? 'block' : 'none';
    }
</script>

@endsection