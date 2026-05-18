@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* ── Hide default layout footer ── */
    footer.footer_type_2, .footer-mobile, hr.mt-5 { display: none !important; }
    body { margin: 0; padding: 0; background: #FAF7F2; font-family: 'Inter', sans-serif; overflow-x: hidden; }

    /* ═══════════════════════════════════
       PANEL 1 — HERO
    ═══════════════════════════════════ */
    .ac-hero {
        display: flex; align-items: center; padding: 40px 48px 60px;
        min-height: calc(100vh - 80px); gap: 60px; background: #FAF7F2;
    }
    .ac-hero-left { flex: 1; padding-right: 20px; }
    .ac-hero-heading {
        font-family: 'Playfair Display', serif; font-size: 62px; line-height: 1.08;
        color: #634d3a; font-weight: 700; text-transform: uppercase; margin: 0 0 24px 0;
    }
    .ac-hero-sub {
        font-size: 15px; color: #7a6e63; line-height: 1.7; max-width: 380px; margin: 0 0 36px 0;
    }
    .ac-hero-actions { display: flex; gap: 16px; }
    .btn-shop {
        background: #634d3a; color: #fff; padding: 14px 32px; border-radius: 28px;
        font-size: 12px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase;
        text-decoration: none; border: 2px solid #634d3a; transition: all 0.3s;
    }
    .btn-shop:hover {
        background: #4d3b2c; border-color: #4d3b2c; color: #fff; text-decoration: none;
        transform: translateY(-2px); box-shadow: 0 8px 24px rgba(99,77,58,0.25);
    }
    .btn-learn {
        background: transparent; color: #2c2420; padding: 14px 32px; border-radius: 28px;
        font-size: 12px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase;
        text-decoration: none; border: 2px solid #2c2420; transition: all 0.3s;
    }
    .btn-learn:hover {
        background: #2c2420; color: #fff; text-decoration: none;
        transform: translateY(-2px); box-shadow: 0 8px 24px rgba(44,36,32,0.2);
    }
    .ac-hero-right { flex: 0 0 50%; max-width: 50%; }
    .ac-hero-right img {
        width: 100%; height: 480px; object-fit: cover; border-radius: 8px; display: block;
    }

    /* ═══════════════════════════════════
       PANEL 2 — BEST SELLING / CATEGORIES
    ═══════════════════════════════════ */
    .ac-bestselling {
        background: #FAF7F2; padding: 80px 48px 90px; text-align: center;
    }
    .ac-bestselling-brand {
        font-family: 'Playfair Display', serif; font-size: 56px; font-weight: 600;
        color: #634d3a; letter-spacing: 0.06em; margin: 0 0 60px 0;
    }
    .ac-bestselling-body {
        display: flex; align-items: flex-start; gap: 40px;
    }
    .ac-bestselling-left {
        flex: 0 0 220px; text-align: left; padding-top: 10px;
    }
    .ac-bestselling-left h3 {
        font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 700;
        font-style: italic; color: #2c2420; line-height: 1.2; margin: 0 0 16px 0;
    }
    .ac-bestselling-left p {
        font-size: 13px; color: #7a6e63; line-height: 1.7; margin: 0 0 24px 0;
    }
    .btn-see-more {
        display: inline-block; background: #634d3a; color: #fff; padding: 12px 28px;
        border-radius: 28px; font-size: 11px; font-weight: 600; letter-spacing: 0.1em;
        text-transform: uppercase; text-decoration: none; transition: all 0.3s;
    }
    .btn-see-more:hover {
        background: #4d3b2c; color: #fff; text-decoration: none;
        transform: translateY(-2px); box-shadow: 0 6px 20px rgba(99,77,58,0.25);
    }
    .ac-bestselling-grid {
        flex: 1; display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px;
    }
    .ac-cat-card { text-align: center; }
    .ac-cat-card-img {
        width: 100%; aspect-ratio: 1; object-fit: cover;
        border-radius: 12px; display: block; transition: transform 0.5s ease;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    .ac-cat-card:hover .ac-cat-card-img { transform: scale(1.03); }
    .ac-cat-card h5 {
        font-size: 12px; font-weight: 700; letter-spacing: 0.18em;
        text-transform: uppercase; color: #2c2420; margin: 16px 0 4px;
    }
    .ac-cat-card p {
        font-size: 12px; font-style: italic; color: #a09890; margin: 0;
    }

    /* ═══════════════════════════════════
       PANEL 3 — SHOP BY CATEGORY
    ═══════════════════════════════════ */
    .ac-shopcat {
        background: #FAF7F2; padding: 80px 48px 90px; text-align: center;
    }
    .ac-shopcat-title {
        font-family: 'Playfair Display', serif; font-size: 36px; font-weight: 600;
        color: #634d3a; text-transform: uppercase; margin: 0 0 50px 0;
    }
    .ac-shopcat-grid {
        display: grid; grid-template-columns: repeat(4, 1fr); gap: 32px;
        max-width: 1000px; margin: 0 auto;
    }
    .ac-shopcat-card {
        background: #fff; border-radius: 8px; aspect-ratio: 1;
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        text-decoration: none; color: inherit;
        transition: all 0.35s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid rgba(0,0,0,0.05);
    }
    .ac-shopcat-card:hover {
        text-decoration: none; color: inherit;
        transform: translateY(-6px); box-shadow: 0 12px 30px rgba(99,77,58,0.1);
    }
    .ac-shopcat-icon {
        width: 44px; height: 44px; margin-bottom: 20px;
        display: flex; align-items: center; justify-content: center;
        color: #8a7e74;
    }
    .ac-shopcat-icon svg {
        width: 100%; height: 100%; stroke: #8a7e74; fill: none;
        stroke-width: 1.2; stroke-linecap: round; stroke-linejoin: round;
    }
    .ac-shopcat-card h5 {
        font-size: 11px; font-weight: 700; letter-spacing: 0.15em;
        text-transform: uppercase; color: #4d4642; margin: 0;
    }

    /* ═══════════════════════════════════
       PANEL 4 — MEET THE ABACART + FOOTER
    ═══════════════════════════════════ */
    .ac-meet {
        background: #FAF7F2; padding: 80px 48px 60px;
    }
    .ac-meet-inner {
        display: flex; align-items: center; gap: 60px;
        max-width: 900px; margin: 0 auto;
    }
    .ac-meet-left { flex: 1; text-align: center; }
    .ac-meet-left h2 {
        font-family: 'Playfair Display', serif; font-size: 48px; font-style: italic;
        font-weight: 400; color: #634d3a; line-height: 1.15; margin: 0 0 24px 0;
    }
    .ac-meet-left p {
        font-size: 11px; letter-spacing: 0.18em; text-transform: uppercase;
        color: #8a7e74; line-height: 1.9; max-width: 280px; margin: 0 auto;
    }
    .ac-meet-right { flex: 1; }
    .ac-meet-right img {
        width: 100%; max-width: 400px; border-radius: 8px; display: block;
        box-shadow: 0 16px 48px rgba(99,77,58,0.12); margin: 0 auto;
    }

    /* ── Full Footer ── */
    .ac-full-footer {
        background: #EDE8E1; padding: 50px 48px 40px;
        border-top: 1px solid rgba(99,77,58,0.1);
    }
    .ac-footer-inner {
        display: flex; justify-content: space-between; align-items: flex-start;
        max-width: 1100px; margin: 0 auto;
    }
    .ac-footer-brand { max-width: 280px; }
    .ac-footer-brand h3 {
        font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 600;
        color: #634d3a; text-transform: uppercase; letter-spacing: 0.05em; margin: 0 0 10px 0;
    }
    .ac-footer-brand p {
        font-size: 12px; color: #8a7e74; line-height: 1.7; margin: 0 0 24px 0;
        text-transform: uppercase; letter-spacing: 0.05em;
    }
    .ac-footer-brand .copyright {
        font-size: 9px; color: #b0a89e; letter-spacing: 0.15em; text-transform: uppercase;
    }
    .ac-footer-cols {
        display: flex; gap: 60px;
    }
    .ac-footer-col h6 {
        font-size: 11px; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase;
        color: #634d3a; margin: 0 0 16px 0;
    }
    .ac-footer-col ul {
        list-style: none; margin: 0; padding: 0;
    }
    .ac-footer-col li { margin-bottom: 10px; }
    .ac-footer-col a {
        font-size: 12px; color: #8a7e74; text-decoration: none;
        text-transform: uppercase; letter-spacing: 0.08em; transition: color 0.3s;
    }
    .ac-footer-col a:hover { color: #634d3a; }

    /* ═══════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════ */
    @media (max-width: 992px) {
        .ac-hero { flex-direction: column; padding: 30px 24px 40px; gap: 30px; }
        .ac-hero-left { padding-right: 0; text-align: center; }
        .ac-hero-heading { font-size: 40px; }
        .ac-hero-sub { margin: 0 auto 30px; }
        .ac-hero-actions { justify-content: center; }
        .ac-hero-right { flex: none; max-width: 100%; }
        .ac-hero-right img { height: 320px; }
        .ac-bestselling { padding: 50px 24px 60px; }
        .ac-bestselling-body { flex-direction: column; }
        .ac-bestselling-left { flex: none; text-align: center; }
        .ac-bestselling-left h3 { text-align: center; }
        .ac-bestselling-grid { grid-template-columns: repeat(3, 1fr); }
        .ac-shopcat { padding: 50px 24px 60px; }
        .ac-shopcat-grid { grid-template-columns: repeat(2, 1fr); }
        .ac-meet { padding: 50px 24px; }
        .ac-meet-inner { flex-direction: column; gap: 30px; }
        .ac-full-footer { padding: 40px 24px 30px; }
        .ac-footer-inner { flex-direction: column; gap: 30px; }
        .ac-footer-cols { gap: 36px; }
    }
    @media (max-width: 576px) {
        .ac-hero-heading { font-size: 32px; }
        .ac-bestselling-brand { font-size: 36px; }
        .ac-bestselling-grid { grid-template-columns: 1fr; gap: 24px; }
        .ac-shopcat-grid { grid-template-columns: 1fr 1fr; gap: 16px; }
        .ac-footer-cols { flex-direction: column; gap: 24px; }
    }
</style>

{{-- ═══════════════════════════════════
     PANEL 1 — HERO
═══════════════════════════════════ --}}
<section class="ac-hero">
    <div class="ac-hero-left">
        <h1 class="ac-hero-heading">Abaca Handicraft Products</h1>
        <p class="ac-hero-sub">Handcrafted quality directly from our local artisans to your home.</p>
        <div class="ac-hero-actions">
            <a href="{{ route('shop.index') }}" class="btn-shop">Shop Now</a>
            <a href="{{ route('home.about') }}" class="btn-learn">Learn More</a>
        </div>
    </div>
    <div class="ac-hero-right">
        <img src="{{ asset('images/handicraft-hero.png') }}" alt="Abaca Handicraft Products">
    </div>
</section>

{{-- ═══════════════════════════════════
     PANEL 2 — BEST SELLING PRODUCTS
═══════════════════════════════════ --}}
<section class="ac-bestselling">
    <h2 class="ac-bestselling-brand">ABACART</h2>

    <div class="ac-bestselling-body">
        <div class="ac-bestselling-left">
            <h3>Best Selling<br>Products</h3>
            <p>Easiest way to upgrade your lifestyle by buying your favorite abaca pieces.</p>
            <a href="{{ route('shop.index') }}" class="btn-see-more">See More →</a>
        </div>

        <div class="ac-bestselling-grid">
            <div class="ac-cat-card">
                <a href="{{ route('shop.index') }}">
                    <img src="{{ asset('images/abaca-baskets.png') }}" alt="Abaca Basket" class="ac-cat-card-img">
                </a>
                <h5>Abaca Basket</h5>
                <p>Sustainable home storage solutions.</p>
            </div>
            <div class="ac-cat-card">
                <a href="{{ route('shop.index') }}">
                    <img src="{{ asset('images/abaca-bags.png') }}" alt="Abaca Bags" class="ac-cat-card-img">
                </a>
                <h5>Abaca Bags</h5>
                <p>Artisanal fashion for everyday use.</p>
            </div>
            <div class="ac-cat-card">
                <a href="{{ route('shop.index') }}">
                    <img src="{{ asset('images/abaca-handfans.png') }}" alt="Abaca Hand Fan" class="ac-cat-card-img">
                </a>
                <h5>Abaca Hand Fan</h5>
                <p>Tradition in the palm of your hand.</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════
     PANEL 3 — SHOP BY CATEGORY
═══════════════════════════════════ --}}
<section class="ac-shopcat">
    <h2 class="ac-shopcat-title">Shop By Category</h2>
    <div class="ac-shopcat-grid">
        <a href="{{ route('shop.index') }}" class="ac-shopcat-card">
            <div class="ac-shopcat-icon">
                <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
            </div>
            <h5>Bags</h5>
        </a>
        <a href="{{ route('shop.index') }}" class="ac-shopcat-card">
            <div class="ac-shopcat-icon">
                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg>
            </div>
            <h5>Home Decor</h5>
        </a>
        <a href="{{ route('shop.index') }}" class="ac-shopcat-card">
            <div class="ac-shopcat-icon">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="3"/><line x1="12" y1="11" x2="12" y2="22"/><line x1="8" y1="16" x2="16" y2="16"/></svg>
            </div>
            <h5>Accessories</h5>
        </a>
        <a href="{{ route('shop.index') }}" class="ac-shopcat-card">
            <div class="ac-shopcat-icon">
                <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/><polyline points="3.27,6.96 12,12.01 20.73,6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
            </div>
            <h5>Souvenirs</h5>
        </a>
    </div>
</section>

{{-- ═══════════════════════════════════
     PANEL 4 — MEET THE ABACART + FOOTER
═══════════════════════════════════ --}}
<section class="ac-meet">
    <div class="ac-meet-inner">
        <div class="ac-meet-left">
            <h2>Meet The<br>Abacart</h2>
            <p>Small changes can make a big impact. We're here for your body and the planet.</p>
        </div>
        <div class="ac-meet-right">
            <img src="{{ asset('images/abacart-artisans.png') }}" alt="Meet The Abacart Artisans">
        </div>
    </div>
</section>

<footer class="ac-full-footer">
    <div class="ac-footer-inner">
        <div class="ac-footer-brand">
            <h3>ABACART</h3>
            <p>Your trusted online shopping destination for quality abaca products at great price.</p>
            <span class="copyright">© {{ date('Y') }} All Rights Reserved. Abacart</span>
        </div>
        <div class="ac-footer-cols">
            <div class="ac-footer-col">
                <h6>Information</h6>
                <ul>
                    <li><a href="{{ route('home.about') }}">About</a></li>
                    <li><a href="{{ route('shop.index') }}">Product</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>
            <div class="ac-footer-col">
                <h6>Company</h6>
                <ul>
                    <li><a href="#">Community</a></li>
                    <li><a href="#">Career</a></li>
                    <li><a href="{{ route('home.about') }}">Our Story</a></li>
                </ul>
            </div>
            <div class="ac-footer-col">
                <h6>Contact</h6>
                <ul>
                    <li><a href="{{ route('home.contact') }}">Support</a></li>
                    <li><a href="#">Pricing</a></li>
                    <li><a href="#">Resources</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

@endsection