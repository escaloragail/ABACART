@extends('layouts.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
    /* ── Hide default footer for auth pages ── */
    footer.footer_type_2, .footer-mobile, hr.mt-5 {
        display: none !important;
    }

    body {
        margin: 0;
        padding: 0;
        background: #fff;
    }

    /* ── Auth Layout ── */
    .auth-wrapper {
        display: flex;
        height: calc(100vh - 84px);
        width: 100%;
        overflow: hidden;
    }

    .auth-image-side {
        flex: 0 0 45%;
        max-width: 45%;
        position: relative;
        overflow: hidden;
    }

    .auth-image-side img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .auth-form-side {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 20px 40px;
        background: #fff;
        position: relative;
        overflow-y: auto;
    }

    .auth-form-container {
        width: 100%;
        max-width: 480px;
    }

    /* ── Branding ── */
    .auth-brand {
        font-family: 'Playfair Display', serif;
        font-size: 36px;
        font-weight: 600;
        color: #634d3a;
        text-align: center;
        margin-bottom: 30px;
        letter-spacing: 0.06em;
    }

    /* ── Form Row Grid ── */
    .auth-fields-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0 20px;
    }

    /* ── Form Fields ── */
    .auth-field {
        position: relative;
        margin-bottom: 20px;
        border-bottom: 1px solid #d4cfc9;
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 4px;
    }

    .auth-field-icon {
        color: #a09890;
        font-size: 16px;
        flex-shrink: 0;
        width: 20px;
        text-align: center;
    }

    .auth-field input {
        flex: 1;
        border: none;
        outline: none;
        background: transparent;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        color: #2c2420;
        padding: 10px 0;
        letter-spacing: 0.02em;
        width: 100%;
    }

    .auth-field input::placeholder {
        color: #b0a89e;
        font-weight: 400;
    }

    .auth-field input:focus {
        outline: none;
        box-shadow: none;
    }

    .auth-field.has-error {
        border-bottom-color: #dc3545;
        margin-bottom: 30px;
    }

    .auth-field .invalid-feedback {
        display: block;
        position: absolute;
        bottom: -22px;
        left: 0;
        font-family: 'Inter', sans-serif;
        font-size: 11px;
        color: #dc3545;
        font-weight: 500;
    }

    /* ── Submit Button ── */
    .auth-submit-btn {
        width: 100%;
        padding: 15px;
        background: #634d3a;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        font-weight: 500;
        letter-spacing: 0.05em;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 10px;
        margin-bottom: 24px;
    }

    .auth-submit-btn:hover {
        background: #4d3b2c;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(99, 77, 58, 0.25);
    }

    /* ── Switch Link ── */
    .auth-switch {
        text-align: center;
        font-family: 'Inter', sans-serif;
        font-size: 11px;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #8a7e74;
    }

    .auth-switch a {
        color: #634d3a;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.3s;
    }

    .auth-switch a:hover {
        color: #8B6914;
    }

    /* ── Footer Terms ── */
    .auth-terms {
        position: absolute;
        bottom: 30px;
        left: 0;
        right: 0;
        text-align: center;
        font-family: 'Inter', sans-serif;
        font-size: 9px;
        font-weight: 600;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: #b0a89e;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .auth-image-side {
            display: none;
        }

        .auth-form-side {
            padding: 40px 24px;
        }

        .auth-brand {
            font-size: 36px;
            margin-bottom: 36px;
        }

        .auth-fields-row {
            grid-template-columns: 1fr;
            gap: 0;
        }
    }
</style>

<div class="auth-wrapper">
    {{-- Left Image Side --}}
    <div class="auth-image-side">
        <img src="{{ asset('images/handicraft-hero.png') }}" alt="Abacart Handicrafts">
    </div>

    {{-- Right Form Side --}}
    <div class="auth-form-side">
        <div class="auth-form-container">
            <div class="auth-brand">ABACART</div>

            <form method="POST" action="{{ route('register') }}" name="register-form" class="needs-validation" novalidate="">
                @csrf

                <div class="auth-fields-row">
                    <div class="auth-field @error('name') has-error @enderror">
                        <input name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Full Name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="auth-field @error('mobile') has-error @enderror">
                        <input id="mobile" type="text" name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile" placeholder="Phone Number">
                        @error('mobile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="auth-fields-row">
                    <div class="auth-field @error('email') has-error @enderror">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="auth-field @error('password') has-error @enderror">
                        <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="auth-field">
                    <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                </div>

                <button type="submit" class="auth-submit-btn">Create Account</button>

                <div class="auth-switch">
                    Already have an account? <a href="{{ route('login') }}">Login</a>
                </div>
            </form>
        </div>

        <div class="auth-terms">Abacart Terms & Conditions</div>
    </div>
</div>

@endsection
