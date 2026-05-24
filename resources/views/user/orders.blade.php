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

    /* ── Tabs Styling (Pill Tabs) ── */
    .order-tabs-wrapper {
        margin-top: 30px;
        margin-bottom: 35px;
    }

    .nav-tabs-custom {
        display: flex;
        gap: 12px;
        border: none;
        flex-wrap: wrap;
    }

    .nav-tabs-custom .nav-link {
        font-family: 'Inter', sans-serif;
        font-size: 12px;
        font-weight: 700;
        color: #718096;
        background: #f7fafc;
        border: 1px solid #e2e8f0;
        padding: 10px 24px;
        border-radius: 50px; /* Pill! */
        transition: all 0.2s ease;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .nav-tabs-custom .nav-link:hover {
        background: #edf2f7;
        color: #111;
    }

    .nav-tabs-custom .nav-link.active {
        background: #111;
        color: #fff;
        border-color: #111;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    /* ── Table Custom ── */
    .table-custom {
        width: 100%;
        border-collapse: collapse;
    }

    .table-custom thead th {
        background: #ffffff;
        color: #a0aec0;
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        font-size: 11px;
        padding: 18px 15px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        border-bottom: 2px solid #e2e8f0;
        text-align: left;
    }

    .table-custom tbody tr {
        background: #fff;
        border-bottom: 1px solid #edf2f7;
    }

    .table-custom tbody tr:last-child {
        border-bottom: none;
    }

    .table-custom tbody td {
        padding: 20px 15px;
        vertical-align: middle;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        color: #2d3748;
    }

    /* ── Status Badges (Pills) ── */
    .badge-status {
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: inline-block;
    }

    .badge-ordered {
        background: #fef3c7;
        color: #d97706;
    }

    .badge-delivered {
        background: #d1fae5;
        color: #059669;
    }

    .badge-canceled {
        background: #fee2e2;
        color: #dc2626;
    }

    /* ── Action Pill Button ── */
    .btn-view-details {
        background: #fff;
        color: #111;
        border: 1px solid #e2e8f0;
        padding: 8px 18px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: all 0.2s ease;
        display: inline-block;
        white-space: nowrap;
        text-decoration: none;
    }

    .btn-view-details:hover {
        background: #111;
        color: #fff;
        border-color: #111;
        text-decoration: none;
    }

    /* ── Pagination Custom ── */
    .custom-pagination {
        margin-top: 35px;
    }

    .pagination {
        margin-bottom: 0;
        display: flex;
        gap: 6px;
    }

    .pagination .page-link {
        border: 1px solid #e2e8f0 !important;
        background: #fff !important;
        color: #718096 !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 12px !important;
        font-weight: 700 !important;
        padding: 10px 16px !important;
        border-radius: 8px !important;
        transition: all 0.2s ease !important;
    }

    .pagination .page-link:hover {
        border-color: #cbd5e1 !important;
        color: #111 !important;
    }

    .pagination .page-item.active .page-link {
        background: #111 !important;
        border-color: #111 !important;
        color: #fff !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05) !important;
    }

    /* ── Alert Styles ── */
    .alert {
        border-radius: 10px;
        border: none;
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        margin-bottom: 25px;
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
                    @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif

                    <div class="ac-section-title">My Orders</div>

                    <div class="order-tabs-wrapper">
                        <ul class="nav nav-tabs nav-tabs-custom" id="orderTabs" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button">All Orders</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="ordered-tab" data-bs-toggle="tab" data-bs-target="#ordered" type="button">Ordered</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="delivered-tab" data-bs-toggle="tab" data-bs-target="#delivered" type="button">Delivered</button>
                            </li>
                            <!-- <li class="nav-item">
                                <button class="nav-link" id="canceled-tab" data-bs-toggle="tab" data-bs-target="#canceled" type="button">Canceled</button>
                            </li> -->
                        </ul>
                    </div>

                    <div class="tab-content" id="orderTabsContent">
                        <!-- All Orders -->
                        <div class="tab-pane fade show active" id="all" role="tabpanel">
                            @include('user.partials.order-table', ['orders_list' => $orders])
                            <div class="custom-pagination">
                                {{ $orders->links('pagination::bootstrap-5') }}
                            </div>
                        </div>

                        <!-- Ordered -->
                        <div class="tab-pane fade" id="ordered" role="tabpanel">
                            @include('user.partials.order-table', ['orders_list' => $ordered_orders])
                        </div>

                        <!-- Delivered -->
                        <div class="tab-pane fade" id="delivered" role="tabpanel">
                            @include('user.partials.order-table', ['orders_list' => $delivered_orders])
                        </div>

                        <!-- Canceled
                        <div class="tab-pane fade" id="canceled" role="tabpanel">
                            @include('user.partials.order-table', ['orders_list' => $canceled_orders])
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
