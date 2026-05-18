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

    .orders-content-card {
        background: #fff;
        border-radius: 16px;
        padding: 40px;
        border: 1px solid #e2e8f0;
        min-height: 500px;
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
    }
    .ac-section-title::before {
        content: "";
        width: 24px;
        height: 2px;
        background: #111;
        display: inline-block;
    }

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

    .alert {
        border-radius: 10px;
        border: none;
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        margin-bottom: 25px;
        padding: 16px 20px;
    }

    .btn-save-address {
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

    .btn-save-address:hover {
        background: #2d3748;
        color: #fff;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }

    .btn-cancel {
        background: transparent;
        color: #a0aec0;
        border: 1px solid #e2e8f0;
        padding: 14px 30px;
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-block;
    }

    .btn-cancel:hover {
        border-color: #111;
        color: #111;
    }

    @media (max-width: 992px) {
        .orders-container { padding: 0 20px; }
        .sidebar-column { margin-bottom: 30px; }
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
                    <div class="mb-5">
                        <div class="ac-section-title">Edit Address</div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('user.address.update', ['id' => $address->Address_ID]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="Zone_Street_HouseNumber"
                                        placeholder="Zone / Street / House No"
                                        value="{{ old('Zone_Street_HouseNumber', $address->Zone_Street_HouseNumber) }}" required>
                                    <label>Zone / Street / House No *</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="Barangay"
                                        placeholder="Barangay"
                                        value="{{ old('Barangay', $address->Barangay) }}" required>
                                    <label>Barangay *</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="City"
                                        placeholder="City"
                                        value="{{ old('City', $address->City) }}" required>
                                    <label>City *</label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="Province"
                                        placeholder="Province"
                                        value="{{ old('Province', $address->Province) }}" required>
                                    <label>Province *</label>
                                </div>
                            </div>
                            <div class="col-md-12 mb-5">
                                <div class="form-floating">
                                    <select class="form-select" name="address_type" required>
                                        <option value="Home"   {{ old('address_type', $address->address_type) == 'Home'   ? 'selected' : '' }}>Home</option>
                                        <option value="Work"   {{ old('address_type', $address->address_type) == 'Work'   ? 'selected' : '' }}>Work</option>
                                        <option value="Office" {{ old('address_type', $address->address_type) == 'Office' ? 'selected' : '' }}>Office</option>
                                        <option value="Other"  {{ old('address_type', $address->address_type) == 'Other'  ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <label>Address Label *</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-3 align-items-center">
                            <button type="submit" class="btn-save-address">Save Changes</button>
                            <a href="{{ route('user.addresses') }}" class="btn-cancel">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
