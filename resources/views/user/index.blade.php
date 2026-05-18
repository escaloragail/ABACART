@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    body {
        background: #FAF7F2 !important;
        font-family: 'Inter', sans-serif;
        color: #111;
    }

    /* ── Dashboard Theme ── */
    .dashboard-wrapper {
        background: #FAF7F2;
        min-height: 100vh;
        padding-top: 30px;
    }

    /* ── Hero Welcome Banner ── */
    .dashboard-hero {
        background: #FAF7F2;
        padding: 60px 0 40px;
        position: relative;
        overflow: hidden;
    }

    .dashboard-hero-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 40px;
        display: flex;
        align-items: center;
        gap: 60px;
    }

    .dashboard-hero-left {
        flex: 1;
        min-width: 0;
    }

    .dashboard-hero-right {
        flex: 0 0 480px;
        max-width: 480px;
    }

    .dashboard-hero-right img {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    }

    .welcome-label {
        font-family: 'Inter', sans-serif;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: #a0aec0;
        margin-bottom: 16px;
        display: block;
    }

    .welcome-heading {
        font-family: 'Inter', sans-serif;
        font-size: 42px;
        line-height: 1.1;
        color: #111;
        margin-bottom: 5px;
        text-transform: uppercase;
        font-weight: 800;
    }

    .welcome-name {
        font-family: 'Inter', sans-serif;
        font-size: 42px;
        line-height: 1.1;
        color: #111;
        text-transform: uppercase;
        font-weight: 800;
        margin-bottom: 20px;
    }

    .welcome-subtitle {
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        color: #718096;
        line-height: 1.7;
        max-width: 440px;
        margin-bottom: 32px;
    }

    .hero-actions {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }

    .btn-hero-primary {
        background: #111;
        color: #fff;
        padding: 14px 36px;
        border-radius: 50px; /* Pill! */
        font-family: 'Inter', sans-serif;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        text-decoration: none;
        border: 1px solid #111;
        transition: all 0.2s ease;
        cursor: pointer;
        display: inline-block;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .btn-hero-primary:hover {
        background: #2d3748;
        border-color: #2d3748;
        color: #fff;
        text-decoration: none;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }

    .btn-hero-outline {
        background: transparent;
        color: #111;
        padding: 14px 36px;
        border-radius: 50px; /* Pill! */
        font-family: 'Inter', sans-serif;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        text-decoration: none;
        border: 1px solid #111;
        transition: all 0.2s ease;
        cursor: pointer;
        display: inline-block;
    }

    .btn-hero-outline:hover {
        background: #111;
        color: #fff;
        text-decoration: none;
    }

    /* ── Dashboard Cards Grid ── */
    .dashboard-cards-section {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 40px 60px;
    }

    .ac-section-title { 
        display: flex;
        align-items: center;
        gap: 12px; 
        font-family: 'Inter', sans-serif;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.15em; 
        color: #111;
        text-transform: uppercase;
        margin-bottom: 35px;
    }
    .ac-section-title::before {
        content: "";
        width: 24px;
        height: 2px;
        background: #111;
        display: inline-block;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-bottom: 40px;
    }

    .dash-card {
        background: #fff;
        border-radius: 16px;
        padding: 32px 28px;
        text-decoration: none;
        color: inherit;
        transition: all 0.25s ease;
        border: 1px solid #e2e8f0;
        position: relative;
        overflow: hidden;
    }

    .dash-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: #111;
        transform: scaleX(0);
        transition: transform 0.25s ease;
        transform-origin: left;
    }

    .dash-card:hover {
        text-decoration: none;
        color: inherit;
        border-color: #cbd5e1;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
    }

    .dash-card:hover::before {
        transform: scaleX(1);
    }

    .dash-card-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        background: #f7fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        font-size: 20px;
        color: #111;
        transition: all 0.2s ease;
    }

    .dash-card:hover .dash-card-icon {
        background: #111;
        color: #fff;
    }

    .dash-card-title {
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 14px;
        color: #111;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .dash-card-desc {
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        color: #718096;
        line-height: 1.6;
        margin: 0;
    }

    .dash-card-arrow {
        position: absolute;
        bottom: 28px;
        right: 28px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #f7fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        color: #111;
        opacity: 0;
        transform: translateX(-10px);
        transition: all 0.2s ease;
    }

    .dash-card:hover .dash-card-arrow {
        opacity: 1;
        transform: translateX(0);
    }

    /* ── Logout Card ── */
    .dash-card-logout {
        background: #111;
        color: #fff;
        border-color: #111;
    }

    .dash-card-logout .dash-card-icon {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .dash-card-logout:hover .dash-card-icon {
        background: rgba(255, 255, 255, 0.25);
        color: #fff;
    }

    .dash-card-logout .dash-card-title {
        color: #fff;
    }

    .dash-card-logout .dash-card-desc {
        color: #a0aec0;
    }

    .dash-card-logout .dash-card-arrow {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .dash-card-logout::before {
        background: #ffffff;
    }

    /* ── Responsive ── */
    @media (max-width: 992px) {
        .dashboard-hero-inner {
            flex-direction: column;
            text-align: center;
            gap: 40px;
            padding: 0 24px;
        }

        .dashboard-hero-right {
            flex: none;
            max-width: 100%;
            width: 100%;
        }

        .dashboard-hero-right img {
            height: 300px;
        }

        .welcome-heading,
        .welcome-name {
            font-size: 38px;
        }

        .welcome-subtitle {
            margin-left: auto;
            margin-right: auto;
        }

        .hero-actions {
            justify-content: center;
        }

        .dashboard-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .dashboard-cards-section {
            padding: 0 24px 40px;
        }
    }

    @media (max-width: 576px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }

        .welcome-heading,
        .welcome-name {
            font-size: 30px;
        }

        .dashboard-hero {
            padding: 40px 0 24px;
        }
    }
</style>

<main class="dashboard-wrapper">
    {{-- ── Hero Welcome Section ── --}}
    <section class="dashboard-hero">
        <div class="dashboard-hero-inner">
            <div class="dashboard-hero-left">
                <span class="welcome-label">My Account Dashboard</span>
                <h1 class="welcome-heading">Welcome Back,</h1>
                <div class="welcome-name">{{ Auth::user()->name }}</div>
                <p class="welcome-subtitle">
                    From your account dashboard you can view your recent orders, manage shipping addresses, and edit your account details.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('user.orders') }}" class="btn-hero-primary">My Orders</a>
                    <a href="{{ route('shop.index') }}" class="btn-hero-outline">Shop Now</a>
                </div>
            </div>
            <div class="dashboard-hero-right">
                @if(Auth::user()->image && file_exists(public_path('uploads/profiles/' . Auth::user()->image)))
                    <img src="{{ asset('uploads/profiles/' . Auth::user()->image) }}" alt="{{ Auth::user()->name }}" style="object-position: center top;">
                @else
                    <img src="{{ asset('assets/images/shop/shop_banner3.jpg') }}" alt="Abaca Handicraft Products">
                @endif
            </div>
        </div>
    </section>

    {{-- ── Quick Access Cards ── --}}
    <section class="dashboard-cards-section">
        <div class="ac-section-title">Quick Access</div>

        <div class="dashboard-grid">
            {{-- Orders --}}
            <a href="{{ route('user.orders') }}" class="dash-card">
                <div class="dash-card-icon">
                    <i class="fa fa-shopping-bag"></i>
                </div>
                <div class="dash-card-title">Orders</div>
                <p class="dash-card-desc">View and track your recent orders, check delivery status, and manage returns.</p>
                <div class="dash-card-arrow"><i class="fa fa-arrow-right"></i></div>
            </a>

            {{-- Addresses --}}
            <a href="{{ route('user.addresses') }}" class="dash-card">
                <div class="dash-card-icon">
                    <i class="fa fa-map-marker"></i>
                </div>
                <div class="dash-card-title">Addresses</div>
                <p class="dash-card-desc">Manage your shipping addresses for faster and easier checkout experience.</p>
                <div class="dash-card-arrow"><i class="fa fa-arrow-right"></i></div>
            </a>

            {{-- Account Details --}}
            <a href="{{ route('user.account.details') }}" class="dash-card">
                <div class="dash-card-icon">
                    <i class="fa fa-user"></i>
                </div>
                <div class="dash-card-title">Account Details</div>
                <p class="dash-card-desc">Update your personal information, email address, and change your password.</p>
                <div class="dash-card-arrow"><i class="fa fa-arrow-right"></i></div>
            </a>

            {{-- Wishlist --}}
            <a href="{{ route('wishlist.index') }}" class="dash-card">
                <div class="dash-card-icon">
                    <i class="fa fa-heart"></i>
                </div>
                <div class="dash-card-title">Wishlist</div>
                <p class="dash-card-desc">Browse your saved items and move them to your cart when you're ready.</p>
                <div class="dash-card-arrow"><i class="fa fa-arrow-right"></i></div>
            </a>

            {{-- Shop --}}
            <a href="{{ route('shop.index') }}" class="dash-card">
                <div class="dash-card-icon">
                    <i class="fa fa-th-large"></i>
                </div>
                <div class="dash-card-title">Browse Shop</div>
                <p class="dash-card-desc">Explore our handcrafted abaca products made by local artisans.</p>
                <div class="dash-card-arrow"><i class="fa fa-arrow-right"></i></div>
            </a>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}" id="dashboard-logout-form" style="display:contents;">
                @csrf
                <a href="{{ route('logout') }}" class="dash-card dash-card-logout"
                   onclick="event.preventDefault(); document.getElementById('dashboard-logout-form').submit();">
                    <div class="dash-card-icon">
                        <i class="fa fa-sign-out"></i>
                    </div>
                    <div class="dash-card-title">Logout</div>
                    <p class="dash-card-desc">Sign out of your account securely.</p>
                    <div class="dash-card-arrow"><i class="fa fa-arrow-right"></i></div>
                </a>
            </form>
        </div>
    </section>
</main>

@endsection