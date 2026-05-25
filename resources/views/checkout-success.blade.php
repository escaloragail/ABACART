@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    body {
        background: #ffffff !important;
        font-family: 'Inter', sans-serif;
        color: #111;
    }
    
    .ac-white-content {
        background: #ffffff !important;
        padding-top: 40px;
        padding-bottom: 60px;
        min-height: 50vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .success-container {
        text-align: center;
        max-width: 600px;
        margin: 0 auto;
        padding: 30px 40px;
        background: #fff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 40px rgba(0,0,0,0.03);
    }

    .success-icon {
        width: 80px;
        height: 80px;
        background: #111;
        color: #fff;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        margin-bottom: 30px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .success-title {
        font-family: 'Playfair Display', serif;
        font-size: 32px;
        font-weight: 600;
        color: #111;
        margin-bottom: 15px;
    }

    .success-subtitle {
        font-size: 15px;
        color: #718096;
        line-height: 1.6;
        margin-bottom: 40px;
    }

    .ac-btn-outline {
        background: transparent;
        color: #111;
        border: 2px solid #111;
        border-radius: 50px;
        padding: 18px 35px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        transition: 0.3s;
        display: inline-block;
        text-decoration: none;
        cursor: pointer;
        margin: 0 10px;
    }
    .ac-btn-outline:hover {
        background: #f7fafc;
        transform: translateY(-2px);
    }

    .ac-btn-black {
        background: #111;
        color: #fff;
        border: 2px solid #111;
        border-radius: 50px;
        padding: 18px 35px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        transition: 0.3s;
        display: inline-block;
        text-decoration: none;
        cursor: pointer;
        margin: 0 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .ac-btn-black:hover {
        background: #2d3748;
        border-color: #2d3748;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }
</style>

<div class="ac-white-content">
    <div class="container">
        <div class="success-container">
            @if(session('success'))
                <div class="alert alert-success mb-4" style="border-radius: 14px; font-size: 13px; font-weight: 700;">
                    {{ session('success') }}
                </div>
            @endif
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            <h1 class="success-title">Order Placed Successfully!</h1>
            <p class="success-subtitle">
                Thank you for your purchase. We've received your order and are getting it ready for delivery. Your items have been deducted from your shopping cart.
            </p>
            
            <div class="d-flex justify-content-center flex-wrap gap-3">
                <a href="{{ route('shop.index') }}" class="ac-btn-outline">Continue Shopping</a>
                <a href="{{ route('cart.index') }}" class="ac-btn-black">Back to Cart</a>
            </div>
        </div>
    </div>
</div>

@endsection
