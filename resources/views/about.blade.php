@extends('layouts.app')

@section('content')
<style>
    body { background: #FAF7F2 !important; }

    .ac-about-hero {
        display: flex; align-items: center; justify-content: center;
        padding: 120px 8% 100px; gap: 80px; max-width: 1300px; margin: 0 auto;
    }
    .ac-about-left {
        flex: 1; text-align: center; max-width: 480px; display: flex; flex-direction: column; align-items: center;
    }
    .ac-about-left h1 {
        font-family: 'Playfair Display', serif; font-size: 64px; font-weight: 500;
        color: #5d4a3d; line-height: 1.1; margin: 0 0 30px 0; letter-spacing: -0.02em;
    }
    .ac-about-left p.subtext {
        font-family: 'Inter', sans-serif; font-size: 10px; font-weight: 700;
        letter-spacing: 0.22em; text-transform: uppercase; color: #8a7e74;
        line-height: 2; max-width: 320px; margin: 0;
    }

    .ac-about-right {
        flex: 1.2; display: flex; justify-content: center;
    }
    .ac-about-img-frame {
        background: #ffffff; padding: 16px; border-radius: 4px;
        box-shadow: 0 24px 60px rgba(93, 74, 61, 0.12);
        max-width: 600px;
        transition: transform 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
    }
    .ac-about-img-frame:hover {
        transform: scale(1.02);
    }
    .ac-about-img-frame img {
        width: 100%; height: auto; display: block; border-radius: 2px;
    }

    /* ═══════════════════════════════════
       BRAND STORY / VALUES (OUR MISSION)
    ═══════════════════════════════════ */
    .ac-brand-story {
        padding: 0 8% 120px; max-width: 1300px; margin: 0 auto; text-align: center;
    }
    .ac-brand-story h3 {
        font-family: 'Playfair Display', serif; font-size: 40px; font-style: italic;
        color: #5d4a3d; margin-bottom: 30px;
    }
    .ac-brand-intro-text {
        font-family: 'Inter', sans-serif; font-size: 15px; color: #7a6e63;
        line-height: 1.8; margin: 0 auto 60px; max-width: 800px; text-align: center;
    }
    
    .ac-values {
        display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; text-align: left;
    }
    .ac-value-box {
        background: #ffffff; padding: 60px 40px; border-radius: 12px;
        border: 1px solid rgba(0,0,0,0.03);
        box-shadow: 0 10px 40px rgba(93, 74, 61, 0.05);
        transition: transform 0.3s ease;
    }
    .ac-value-box:hover {
        transform: translateY(-8px);
    }
    .ac-value-box h5 {
        font-family: 'Inter', sans-serif; font-size: 14px; font-weight: 700;
        letter-spacing: 0.15em; text-transform: uppercase; color: #5d4a3d; margin-bottom: 20px;
    }
    .ac-value-box p {
        font-size: 14px; color: #8a7e74; line-height: 1.8; margin: 0;
    }

    /* ═══════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════ */
    @media (max-width: 991px) {
        .ac-about-hero { flex-direction: column; padding: 60px 24px; gap: 50px; text-align: center; }
        .ac-about-left h1 { font-size: 48px; }
        .ac-about-left { max-width: 100%; }
        .ac-values { grid-template-columns: 1fr; }
        .ac-brand-story { padding: 40px 24px 80px; }
        .ac-value-box { padding: 40px 30px; }
        .ac-brand-intro-text { margin-bottom: 40px; }
    }
</style>

<div class="ac-about-hero">
    <div class="ac-about-left">
        <h1>Meet The<br>Abacart</h1>
        <p class="subtext">Handmade quality for your everyday life. Crafted with care, built to last.</p>
    </div>
    
    <div class="ac-about-right">
        <div class="ac-about-img-frame">
            <img src="{{ asset('images/abacart-artisans.png') }}" alt="Abacart Artisans Crafting" onerror="this.src='https://via.placeholder.com/800x500/E5DED5/5d4a3d?text=Abacart+Artisans'">
        </div>
    </div>
</div>

<div class="ac-brand-story">
    <h3>Our Mission</h3>
    <p class="ac-brand-intro-text">
        Abacart PH was born from a deep appreciation for Filipino craftsmanship and sustainable materials. 
        We partner directly with local artisans to bring you meticulously handwoven abaca products that merge 
        timeless tradition with modern aesthetics. Every piece tells a story of heritage, care, and a 
        steadfast commitment to the environment.
    </p>

    <div class="ac-values">
        <div class="ac-value-box">
            <h5>01. Sustainability</h5>
            <p>From the sourcing of natural abaca fibers to our packaging, we prioritize earth-conscious choices that protect our planet for future generations.</p>
        </div>
        <div class="ac-value-box">
            <h5>02. Empowerment</h5>
            <p>We work exclusively with local weaving communities, ensuring fair wages and providing a global platform for their incredible talent.</p>
        </div>
        <div class="ac-value-box">
            <h5>03. Authenticity</h5>
            <p>We celebrate the raw, imperfect beauty of handmade items. No two products are exactly alike, making each piece uniquely yours.</p>
        </div>
    </div>
</div>

@endsection
