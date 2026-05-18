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
    }
    .ac-section-title::before {
        content: "";
        width: 24px;
        height: 2px;
        background: #111;
        display: inline-block;
    }

    .subtitle-text {
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        color: #718096;
        margin-top: 6px;
        margin-bottom: 0;
    }

    /* ── Primary Action Pill Button ── */
    .btn-add-address {
        background: #111;
        color: #fff;
        border: none;
        padding: 12px 30px;
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        transition: all 0.2s ease;
        display: inline-block;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .btn-add-address:hover {
        background: #2d3748;
        color: #fff;
        text-decoration: none;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
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

    /* ── Address Cards ── */
    .info-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        height: 100%;
        overflow: hidden;
        transition: all 0.2s ease;
        padding: 30px;
    }

    .info-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
    }

    .address-card-header {
        border-bottom: 1px solid #edf2f7;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }

    .address-type-label {
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        font-weight: 800;
        color: #111;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin: 0;
    }

    .address-details-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 25px;
    }

    .detail-row {
        display: flex;
        align-items: baseline;
        font-size: 13px;
        font-family: 'Inter', sans-serif;
    }

    .detail-label {
        font-weight: 700;
        color: #a0aec0;
        text-transform: uppercase;
        font-size: 10px;
        letter-spacing: 0.05em;
        width: 110px;
        flex-shrink: 0;
    }

    .detail-value {
        color: #2d3748;
        font-weight: 500;
    }

    /* ── Action Pill Buttons ── */
    .btn-delete-address {
        background: #fff;
        color: #e53e3e;
        border: 1px solid #fed7d7;
        padding: 8px 18px;
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: all 0.2s ease;
        cursor: pointer;
        outline: none;
        display: inline-block;
    }

    .btn-delete-address:hover {
        background: #fff5f5;
        border-color: #e53e3e;
        color: #e53e3e;
    }

    .empty-text {
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        color: #a0aec0;
        text-align: center;
        padding: 50px 0;
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
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-5">
                        <div>
                            <div class="ac-section-title">Addresses</div>
                            <p class="subtitle-text">The following addresses will be used on the checkout page.</p>
                        </div>
                        <a href="{{ route('user.address.add') }}" class="btn-add-address">Add New Address</a>
                    </div>

                    @if(Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif

                    <div class="row">
                        @forelse($addresses as $address)
                        <div class="col-md-6 mb-4">
                            <div class="info-card">
                                <div class="address-card-header d-flex justify-content-between align-items-center">
                                    <h5 class="address-type-label">{{ $address->address_type }}</h5>
                                    
                                    <form action="{{ route('user.address.delete', ['id' => $address->Address_ID]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this address?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete-address" title="Delete Address">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                                
                                <div class="address-details-list">
                                    <div class="detail-row">
                                        <span class="detail-label">Recipient</span>
                                        <span class="detail-value">{{ Auth::user()->name }}</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Street</span>
                                        <span class="detail-value">{{ $address->Zone_Street_HouseNumber }}</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Barangay</span>
                                        <span class="detail-value">{{ $address->Barangay }}</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">City</span>
                                        <span class="detail-value">{{ $address->City }}</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Province</span>
                                        <span class="detail-value">{{ $address->Province }}</span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="detail-label">Phone</span>
                                        <span class="detail-value">{{ Auth::user()->phone_number }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-md-12">
                            <div class="empty-text">
                                <i class="fa fa-map-marker-alt" style="font-size: 36px; display: block; margin-bottom: 15px; opacity: 0.25;"></i>
                                You have not set up any shipping addresses yet. You can add one by clicking the "Add New Address" button above.
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
