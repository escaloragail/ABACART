@extends('layouts.admin')
@section('content')

<style>
    /* ── Content Area ── */
    .orders-content-card {
        background: #fff;
        border-radius: 16px;
        padding: 40px;
        border: 1px solid #e2e8f0;
        min-height: 500px;
        margin-top: 20px;
    }

    /* ── Section Title ── */
    .ac-section-title { 
        display: flex;
        align-items: center;
        gap: 12px; 
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        font-weight: 800;
        letter-spacing: 0.15em; 
        color: #111;
        text-transform: uppercase;
        margin-bottom: 40px;
    }
    .ac-section-title::before {
        content: "";
        width: 24px;
        height: 2px;
        background: #111;
        display: inline-block;
    }

    /* ── CSS Grid for Layout ── */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
        margin-bottom: 25px;
    }
    .form-grid-full {
        grid-column: span 2;
    }

    /* ── Form Inputs ── */
    .form-floating {
        position: relative;
    }
    
    .form-control {
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 14px !important;
        color: #111 !important;
        background-color: #fff !important;
        transition: all 0.2s ease !important;
        height: 58px !important;
        padding: 1.625rem 1rem 0.625rem !important;
        width: 100%;
        display: block;
    }

    .form-control:focus {
        border-color: #111 !important;
        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05) !important;
        color: #111 !important;
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
        font-size: 12px !important;
        color: #a0aec0 !important;
        transition: opacity .1s ease-in-out,transform .1s ease-in-out !important;
        text-transform: uppercase !important;
        font-weight: 700 !important;
        letter-spacing: 0.05em !important;
    }

    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label {
        color: #111 !important;
        transform: scale(.85) translateY(-0.5rem) translateX(0.15rem);
    }

    .form-control[disabled] {
        background-color: #f7fafc !important;
        color: #a0aec0 !important;
    }

    /* ── Alert Styles ── */
    .alert {
        border-radius: 10px;
        border: none;
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        margin-bottom: 25px;
        padding: 16px 20px;
    }
    .alert-success { background: #dcfce7; color: #166534; }
    .alert-danger { background: #fee2e2; color: #991b1b; }

    /* ── Primary Action Pill Button ── */
    .btn-save-details {
        background: #111;
        color: #fff;
        border: none;
        padding: 16px 45px;
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
        margin-top: 15px;
    }

    .btn-save-details:hover {
        background: #2d3748;
        color: #fff;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }

    /* ── Profile Pic Styles ── */
    .profile-image-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-bottom: 40px;
    }

    .profile-image-container {
        border: 2px solid #e2e8f0;
        padding: 4px;
        border-radius: 50%;
        display: inline-block;
        margin-bottom: 15px;
    }

    .profile-image-label {
        font-family: 'Inter', sans-serif;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #a0aec0;
        display: block;
        margin-bottom: 10px;
        text-align: center;
    }

    .profile-image-input {
        max-width: 280px;
        margin: 0 auto;
        font-size: 13px;
        height: auto;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        display: block;
    }
</style>

<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Account Settings</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Account Settings</div>
                </li>
            </ul>
        </div>

        <div class="orders-content-card">
            <div class="ac-section-title">Account Details</div>

            @if (Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.account.update') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="profile-image-section">
                    <div class="profile-image-container">
                        @if($user->image)
                            <img src="{{ asset('uploads/profiles/' . $user->image) }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <img src="{{ asset('assets/images/avatar/user-1.png') }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                        @endif
                    </div>
                    <div class="form-group mt-2">
                        <label for="image" class="profile-image-label">Change Profile Image</label>
                        <input type="file" class="profile-image-input" name="image" id="image">
                    </div>
                </div>

                {{-- General Information --}}
                <div class="form-grid">
                    <div class="form-floating">
                        <input type="text" class="form-control" placeholder="Name" name="name" value="{{ $user->name }}" required>
                        <label for="name">Name *</label>
                    </div>
                    
                    <div class="form-floating">
                        <input type="text" class="form-control" placeholder="Phone Number" name="phone_number" value="{{ $user->phone_number }}" required>
                        <label for="phone_number">Phone Number *</label>
                    </div>
                    
                    <div class="form-floating form-grid-full">
                        <input type="email" class="form-control" placeholder="Email Address" name="email" value="{{ $user->email }}" required>
                        <label for="email">Email Address *</label>
                    </div>
                </div>

                {{-- Password Change Section --}}
                <div style="border-bottom: 1px solid #edf2f7; padding-bottom: 10px; margin-bottom: 25px; margin-top: 15px;">
                    <h6 class="text-uppercase fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.1em; color: #111;">Password Change</h6>
                    <p class="text-muted mb-0" style="font-size: 12px;">Leave blank to keep your current password.</p>
                </div>
                
                <div class="form-grid">
                    <div class="form-floating">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" minlength="6" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9]).{6,}" placeholder="New password" title="Password must be at least 6 characters and include uppercase, lowercase, and a symbol.">
                        <label for="password">New password</label>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-floating">
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm new password">
                        <label for="password_confirmation">Confirm new password</label>
                    </div>
                </div>

                <div class="form-grid-full">
                    <button type="submit" class="btn-save-details">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
