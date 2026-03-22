@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Add Coupon</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><a href="{{ route('admin.coupons') }}"><div class="text-tiny">Coupons</div></a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><div class="text-tiny">Add coupon</div></li>
                </ul>
            </div>
            
            <div class="wg-box">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="form-new-product form-style-1" action="{{ route('admin.coupon.store') }}" method="POST">
                    @csrf
                    
                    <fieldset class="name">
                        <div class="body-title mb-10">Coupon Code <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter coupon code" name="code" tabindex="0" value="{{ old('code') }}" aria-required="true" required="">
                    </fieldset>

                    <fieldset class="category">
                        <div class="body-title mb-10">Coupon Type <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select class="" name="type" required>
                                <option value="">Choose type</option>
                                <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                                <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Percentage</option>
                            </select>
                        </div>
                    </fieldset>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Discount Value <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Value" name="value" tabindex="0" value="{{ old('value') }}" aria-required="true" required="">
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">Cart Value (Minimum) <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Minimum cart value" name="cart_value" tabindex="0" value="{{ old('cart_value') }}" required="">
                        </fieldset>
                    </div>

                    <fieldset class="name">
                        <div class="body-title mb-10">Expiry Date <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="date" name="expiry_date" tabindex="0" value="{{ old('expiry_date') }}" aria-required="true" required="">
                    </fieldset>

                    <div class="bot">
                        <button class="tf-button w208" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
