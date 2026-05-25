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

    /* ── Action Back Pill Button ── */
    .btn-back-to-orders {
        background: #111;
        color: #fff;
        border: none;
        padding: 10px 24px;
        border-radius: 50px; /* Pill! */
        font-family: 'Inter', sans-serif;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        transition: all 0.2s ease;
        display: inline-block;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .btn-back-to-orders:hover {
        background: #2d3748;
        color: #fff;
        text-decoration: none;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }

    /* ── Info Cards ── */
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

    .info-card-header {
        border-bottom: 1px solid #edf2f7;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }

    .info-card-header h6 {
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
        width: 130px;
        flex-shrink: 0;
    }

    .detail-value {
        color: #2d3748;
        font-weight: 500;
    }

    /* ── Status Badges (Pill) ── */
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

    /* ── Ordered Items Table ── */
    .table-details-wrapper {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        margin-top: 15px;
    }

    .table-details {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        color: #2d3748;
        background: #fff;
    }

    .table-details thead th {
        background: #ffffff;
        color: #a0aec0;
        font-weight: 700;
        font-size: 11px;
        padding: 18px 24px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        border-bottom: 2px solid #e2e8f0;
    }

    .table-details tbody td {
        padding: 18px 24px;
        vertical-align: middle;
        border-bottom: 1px solid #edf2f7;
    }

    .table-details tbody tr:last-child td {
        border-bottom: none;
    }

    .table-details tfoot {
        background: #f7fafc;
        border-top: 2px solid #e2e8f0;
    }

    .table-details tfoot th {
        padding: 14px 24px;
        font-weight: 700;
        color: #718096;
        text-align: right;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .table-details tfoot td {
        padding: 14px 24px;
        font-weight: 600;
        color: #111;
        text-align: right;
        font-size: 14px;
    }

    .table-details tfoot tr.total-row th {
        font-size: 13px;
        font-weight: 800;
        color: #111;
        padding-top: 18px;
        padding-bottom: 18px;
    }

    .table-details tfoot tr.total-row td {
        font-size: 18px;
        font-weight: 800;
        color: #111; /* Strong bold black total */
        padding-top: 18px;
        padding-bottom: 18px;
    }

    /* ── Action Pill Buttons ── */
    .btn-cancel-order {
        background: #fff;
        color: #e53e3e;
        border: 1px solid #fed7d7;
        padding: 12px 30px;
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: all 0.2s ease;
        cursor: pointer;
        display: inline-block;
        outline: none;
    }

    .btn-cancel-order:hover {
        background: #fff5f5;
        border-color: #e53e3e;
        color: #e53e3e;
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

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-5">
                        <div class="ac-section-title">Order #{{ $order->Order_ID }}</div>
                        <a href="{{ route('user.orders') }}" class="btn-back-to-orders">Back to Orders</a>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <div class="info-card">
                                <div class="info-card-header">
                                    <h6>Shipping Address</h6>
                                </div>
                                <div class="info-card-body">
                                    @if($address)
                                    <div class="address-details-list">
                                        <div class="detail-row">
                                            <span class="detail-label">Recipient</span>
                                            <span class="detail-value">{{ $order->user->name ?? 'Unknown' }}</span>
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
                                            <span class="detail-label">Label</span>
                                            <span class="detail-value">{{ $address->address_type }}</span>
                                        </div>
                                    </div>
                                    @else
                                    <p class="mb-0 text-muted">No address mapped.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card">
                                <div class="info-card-header">
                                    <h6>Order Info</h6>
                                </div>
                                <div class="info-card-body">
                                    <div class="address-details-list">
                                        <div class="detail-row">
                                            <span class="detail-label">Date</span>
                                            <span class="detail-value">{{ $order->created_at->format('M d Y h:i A') }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Status</span>
                                            <span class="detail-value">
                                                @if($order->order_status == 'ordered')
                                                    <span class="badge-status badge-ordered">Placed</span>
                                                @elseif($order->order_status == 'delivered')
                                                    <span class="badge-status badge-delivered">Delivered</span>
                                                @else
                                                    <span class="badge-status badge-canceled">Canceled</span>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Method</span>
                                            <span class="detail-value">{{ $order->payment_mode == 'greenpay' ? 'GreenPay' : strtoupper($order->payment_mode) }}</span>
                                        </div>
                                        @if($order->payment_reference_number)
                                        <div class="detail-row">
                                            <span class="detail-label">Reference #</span>
                                            <span class="detail-value">{{ $order->payment_reference_number }}</span>
                                        </div>
                                        @endif
                                        <div class="detail-row">
                                            <span class="detail-label">Payment</span>
                                            <span class="detail-value">{{ ucfirst($order->payment_status) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($order->note)
                    <div class="info-card mb-4">
                        <div class="info-card-header">
                            <h6>Customer Message / Note</h6>
                        </div>
                        <div class="info-card-body">
                            <span class="detail-value" style="font-style: italic; color: #4a5568;">"{{ $order->note }}"</span>
                        </div>
                    </div>
                    @endif

                    <div class="info-card mb-4">
                        <div class="info-card-header">
                            <h6>Ordered Items</h6>
                        </div>
                        <div class="table-details-wrapper">
                            <div class="table-responsive">
                                <table class="table-details">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th style="text-align: center;">Price</th>
                                            <th style="text-align: center;">Quantity</th>
                                            <th style="text-align: right;">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orderItems as $item)
                                        <tr>
                                            <td style="font-weight: 700; color: #111;">{{ $item->product->product_name ?? 'Deleted Product' }}</td>
                                            <td style="text-align: center; font-weight: 500;">₱{{ number_format($item->price, 2) }}</td>
                                            <td style="text-align: center; color: #718096;">{{ $item->quantity }}</td>
                                            <td style="text-align: right; font-weight: 700; color: #111;">₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3">Subtotal</th>
                                            <td>₱{{ number_format($order->subtotal, 2) }}</td>
                                        </tr>
                                        @if($order->discount > 0)
                                        <tr>
                                            <th colspan="3">Discount</th>
                                            <td style="color: #e53e3e;">-₱{{ number_format($order->discount, 2) }}</td>
                                        </tr>
                                        @endif
                                        <tr class="total-row">
                                            <th colspan="3">Total Due</th>
                                            <td>₱{{ number_format($order->total, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if($order->order_status == 'ordered')
                    <div class="d-flex justify-content-end mb-2">
                        <form action="{{ route('user.order.cancel') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="order_id" value="{{ $order->Order_ID }}">
                            <button type="submit" class="btn-cancel-order" onclick="return confirm('Are you sure you want to cancel this order?')">Cancel Order</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
