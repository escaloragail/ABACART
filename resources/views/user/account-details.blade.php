@extends('layouts.app')
@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    body {
        background: #ffffff !important;
        font-family: 'Inter', sans-serif;
        color: #111;
    }

    .orders-wrapper {
        background: #ffffff;
        min-height: 100vh;
        padding: 60px 0;
    }

    .orders-container {
        max-width: 1600px;
        margin: 0 auto;
        padding: 0 40px;
    }

    /* ── Sidebar Styles ── */
    .account-sidebar-card {
        background: #fff;
        border-radius: 16px;
        padding: 35px 30px;
        border: 1px solid #e2e8f0;
        height: 100%;
    }

    .sidebar-heading {
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        font-weight: 800;
        color: #111;
        margin-bottom: 35px;
        text-transform: uppercase;
        letter-spacing: 0.15em;
    }

    .account-nav-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .account-nav-list li {
        margin-bottom: 22px;
    }

    .account-nav-link {
        font-family: 'Inter', sans-serif;
        font-size: 12px;
        font-weight: 700;
        color: #a0aec0;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        transition: all 0.2s ease;
        display: block;
    }

    .account-nav-link:hover,
    .account-nav-link.active {
        color: #111;
        text-decoration: none;
        transform: translateX(3px);
    }

    /* ── Content Area ── */
    .orders-content-card {
        background: #fff;
        border-radius: 16px;
        padding: 40px;
        border: 1px solid #e2e8f0;
        min-height: 500px;
    }

    /* ── Section Title ── */
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

    /* ── Form Inputs ── */
    .form-control {
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 14px !important;
        color: #111 !important;
        background-color: #fff !important;
        transition: all 0.2s ease !important;
    }

    .form-control:focus {
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
    .form-floating > .form-control:not(:placeholder-shown) ~ label {
        color: #111 !important;
    }

    .form-control:disabled,
    .form-control[disabled] {
        background-color: #f7fafc !important;
        color: #a0aec0 !important;
        cursor: not-allowed !important;
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

    /* ── Primary Action Pill Button ── */
    .btn-save-details {
        background: #111;
        color: #fff;
        border: none;
        padding: 14px 40px;
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        transition: all 0.2s ease;
        cursor: pointer;
        display: inline-block;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .btn-save-details:hover {
        background: #2d3748;
        color: #fff;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }

    /* ── Profile Pic Styles ── */
    .profile-image-container {
        border: 2px solid #e2e8f0;
        padding: 4px;
        border-radius: 50%;
        display: inline-block;
        margin-bottom: 15px;
    }

    .profile-image-label {
        font-family: 'Inter', sans-serif;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #a0aec0;
        display: block;
        margin-bottom: 8px;
    }

    .profile-image-input {
        max-width: 250px;
        margin: 0 auto;
        font-size: 12px;
        height: auto;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }

    @media (max-width: 992px) {
        .orders-container {
            padding: 0 20px;
        }
        .sidebar-column {
            margin-bottom: 30px;
        }
    }
</style>

<main class="orders-wrapper">
    <div class="orders-container">
        <div class="row">
            {{-- ── Sidebar ── --}}
            <div class="col-lg-3 sidebar-column">
                <div class="account-sidebar-card">
                    <h2 class="sidebar-heading">My Account</h2>
                    @include('user.account-nav')
                </div>
            </div>

            {{-- ── Main Content ── --}}
            <div class="col-lg-9">
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

                    <form action="{{ route('user.account.update') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            {{-- Profile Image Section --}}
                            <div class="col-md-12 mb-5">
                                <div class="text-center">
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
                            </div>

                            {{-- General Information --}}
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" placeholder="Name" name="name" value="{{ $user->name }}" required>
                                    <label for="name">Name *</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" placeholder="Phone Number" name="phone_number" value="{{ $user->phone_number }}" required>
                                    <label for="phone_number">Phone Number *</label>
                                </div>
                            </div>
                            <div class="col-md-12 mb-5">
                                <div class="form-floating">
                                    <input type="email" class="form-control" placeholder="Email Address" name="email" value="{{ old('email', $user->email) }}" required>
                                    <label for="email">Email Address *</label>
                                </div>
                            </div>

                            {{-- Password Change Section --}}
                            <div class="col-md-12 mb-4">
                                <div style="border-bottom: 1px solid #edf2f7; padding-bottom: 10px; margin-bottom: 25px;">
                                    <h6 class="text-uppercase fw-bold mb-1" style="font-size: 11px; letter-spacing: 0.1em; color: #111;">Password Change</h6>
                                    <p class="text-muted mb-0" style="font-size: 12px;">Leave blank to keep your current password.</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" minlength="6" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9]).{6,}" placeholder="New password" title="Password must be at least 6 characters and include uppercase, lowercase, and a symbol.">
                                    <label for="password">New password</label>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <div class="form-floating">
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm new password">
                                    <label for="password_confirmation">Confirm new password</label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn-save-details">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
