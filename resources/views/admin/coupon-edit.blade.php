@extends('layouts.admin')
@section('content')

<style>
    /* ── Edit Coupon Compact Layout ── */
    .coupon-add-card {
        background: #fff;
        border-radius: 16px;
        padding: 30px 40px;
        border: 1px solid #e2e8f0;
        margin-top: 10px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-grid-full {
        grid-column: 1 / -1;
    }

    /* ── Form Inputs ── */
    .form-floating {
        position: relative;
    }
    
    .form-control, .form-select {
        border: 1px solid #e2e8f0 !important;
        border-radius: 10px !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 13px !important;
        color: #111 !important;
        background-color: #fff !important;
        transition: all 0.2s ease !important;
        height: 52px !important;
        padding: 1.5rem 1rem 0.5rem !important;
        width: 100%;
        display: block;
        box-shadow: none !important;
    }

    .form-select {
        padding-top: 1.25rem !important;
        padding-bottom: 0.25rem !important;
    }

    .form-control:focus, .form-select:focus {
        border-color: #111 !important;
        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05) !important;
        outline: none !important;
    }

    .form-floating > label {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        padding: 1rem 1rem;
        pointer-events: none;
        transform-origin: 0 0;
        font-family: 'Inter', sans-serif !important;
        font-size: 11px !important;
        color: #a0aec0 !important;
        transition: opacity .1s ease-in-out,transform .1s ease-in-out !important;
        text-transform: uppercase !important;
        font-weight: 700 !important;
        letter-spacing: 0.05em !important;
    }

    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label,
    .form-floating > .form-select ~ label {
        color: #111 !important;
        transform: scale(.85) translateY(-0.5rem) translateX(0.15rem);
    }

    /* ── Save Button ── */
    .btn-save-coupon {
        background: #111;
        color: #fff;
        border: none;
        padding: 14px 40px;
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        transition: all 0.2s ease;
        cursor: pointer;
        display: inline-block;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        width: 100%;
        margin-top: 10px;
    }

    .btn-save-coupon:hover {
        background: #2d3748;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }
    
    .ac-section-title { 
        display: flex;
        align-items: center;
        gap: 12px; 
        font-family: 'Inter', sans-serif;
        font-size: 13px;
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
</style>

<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Edit Coupon</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="{{ route('admin.coupons') }}"><div class="text-tiny">Coupons</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Edit coupon</div></li>
            </ul>
        </div>
        
        <div class="coupon-add-card">
            <div class="ac-section-title">Coupon Details</div>

            @if ($errors->any())
                <div class="alert alert-danger" style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:8px; margin-bottom:20px; font-size:12px;">
                    <ul class="mb-0" style="margin-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.coupon.update', ['id' => $coupon->Coupon_ID]) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-grid">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="code" placeholder="Coupon Code" value="{{ $coupon->code }}" required>
                        <label>Coupon Code *</label>
                    </div>

                    <div class="form-floating">
                        <select class="form-select" name="type" required>
                            <option value="fixed" {{ $coupon->type == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                            <option value="percent" {{ $coupon->type == 'percent' ? 'selected' : '' }}>Percentage</option>
                        </select>
                        <label>Coupon Type *</label>
                    </div>
                </div>

                <div class="form-grid-3">
                    <div class="form-floating">
                        <input type="number" class="form-control" name="value" placeholder="Discount Value" value="{{ $coupon->value }}" required>
                        <label>Discount Value *</label>
                    </div>

                    <div class="form-floating">
                        <input type="number" class="form-control" name="cart_value" placeholder="Cart Value" value="{{ $coupon->cart_value }}" required>
                        <label>Cart Value (Min) *</label>
                    </div>

                    <div class="form-floating">
                        <input type="date" class="form-control" name="expiry_date" placeholder="Expiry Date" value="{{ \Carbon\Carbon::parse($coupon->expiry_date)->format('Y-m-d') }}" required>
                        <label>Expiry Date *</label>
                    </div>
                </div>

                <button class="btn-save-coupon" type="submit">Update Coupon</button>
            </form>
        </div>
    </div>
</div>
@endsection
