@extends('layouts.admin')
@section('content')
<style>
    /* ── Minimalist Black & White Cards ── */
    .bw-card {
        background: #fff;
        border-radius: 16px;
        padding: 30px;
        border: 1px solid #e2e8f0;
        margin-bottom: 24px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.02);
    }
    
    .bw-section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        font-weight: 800;
        letter-spacing: 0.1em;
        color: #111;
        text-transform: uppercase;
        margin-bottom: 20px;
    }
    .bw-section-title::before {
        content: "";
        width: 16px;
        height: 2px;
        background: #111;
        display: inline-block;
    }

    /* ── Info Grid (Replaces old tables) ── */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }
    
    .info-item {
        background: #f8fafc;
        padding: 16px;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
    }
    .info-label {
        font-family: 'Inter', sans-serif;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 6px;
    }
    .info-value {
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        font-weight: 600;
        color: #111;
    }

    /* ── Modern Table for Items ── */
    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 8px;
    }
    .modern-table th {
        font-family: 'Inter', sans-serif;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        padding: 0 16px 12px;
        border: none;
        text-align: left;
    }
    .modern-table td {
        background: #f8fafc;
        padding: 16px;
        border: none;
        vertical-align: middle;
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        color: #111;
    }
    .modern-table td:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }
    .modern-table td:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    /* ── Badges ── */
    .bw-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .bw-badge.warning { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .bw-badge.success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .bw-badge.danger { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
    .bw-badge.secondary { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }

    /* ── Form Updates ── */
    .form-select, .btn-update-status {
        border-radius: 10px;
        height: 48px;
        font-family: 'Inter', sans-serif;
        font-size: 13px;
    }
    .form-select {
        border: 1px solid #e2e8f0;
        padding: 0 16px;
        background-color: #f8fafc;
        font-weight: 600;
    }
    .form-select:focus {
        border-color: #111;
        box-shadow: 0 0 0 3px rgba(0,0,0,0.05);
        outline: none;
    }
    .btn-update-status {
        background: #111;
        color: #fff;
        border: none;
        padding: 0 24px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: all 0.2s ease;
        width: 100%;
    }
    .btn-update-status:hover {
        background: #2d3748;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
</style>

<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Order Details</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{route('admin.index')}}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="{{route('admin.orders')}}"><div class="text-tiny">Orders</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Order Details</div></li>
            </ul>
        </div>

        @if (Session::has('success'))
            <p class="alert alert-success" style="border-radius:12px; font-size:13px; font-family:'Inter',sans-serif;">{{ Session::get('success') }}</p>
        @endif
        @if (Session::has('error'))
            <p class="alert alert-danger" style="border-radius:12px; font-size:13px; font-family:'Inter',sans-serif;">{{ Session::get('error') }}</p>
        @endif

        <!-- Order Description -->
        <div class="bw-card">
            <div class="bw-section-title">Order Information (#{{ $order->Order_ID }})</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Order Date</div>
                    <div class="info-value">{{ $order->created_at->format('M d Y h:i A') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Mobile</div>
                    <div class="info-value">{{ $order->user->phone_number ?? 'N/A' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Order Status</div>
                    <div class="info-value mt-1">
                        @if($order->order_status == 'ordered') <span class="bw-badge warning">Ordered</span>
                        @elseif($order->order_status == 'delivered') <span class="bw-badge success">Delivered</span>
                        @else <span class="bw-badge danger">Canceled</span> @endif
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Delivered Date</div>
                    <div class="info-value">{{ $order->date_delivery ? \Carbon\Carbon::parse($order->date_delivery)->format('M d Y h:i A') : '--' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Canceled Date</div>
                    <div class="info-value">{{ $order->date_cancelled ? \Carbon\Carbon::parse($order->date_cancelled)->format('M d Y h:i A') : '--' }}</div>
                </div>
            </div>
        </div>

        <!-- Ordered Items -->
        <div class="bw-card">
            <div class="bw-section-title">Ordered Items</div>
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>SKU</th>
                            <th>Options</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderItems as $item)
                        <tr>
                            <td><strong>{{ $item->product->product_name ?? 'Product Deleted' }}</strong></td>
                            <td>{{ $item->product->SKU ?? 'N/A' }}</td>
                            <td>
                                @if ($item->options)
                                    @foreach (unserialize($item->options) as $key => $value)
                                        <span style="font-size:11px; color:#64748b; background:#fff; padding:2px 8px; border-radius:4px; border:1px solid #e2e8f0;">{{ $key }}: {{ $value }}</span>
                                    @endforeach
                                @else
                                    --
                                @endif
                            </td>
                            <td>₱{{ number_format($item->price, 2) }}</td>
                            <td><strong>x{{ $item->quantity }}</strong></td>
                            <td><strong>₱{{ number_format($item->price * $item->quantity, 2) }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $orderItems->links('pagination::bootstrap-5') }}
            </div>
        </div>

        <!-- Layout for Summary, Shipping, and Payment -->
        <div class="row">
            <!-- Left Column: Shipping & Notes -->
            <div class="col-md-7">
                <div class="bw-card h-100 mb-0">
                    <div class="bw-section-title">Shipping Address</div>
                    @if($address)
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Recipient Name</div>
                            <div class="info-value">{{ $order->user->name ?? 'Unknown' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Address Type</div>
                            <div class="info-value">{{ $address->address_type }}</div>
                        </div>
                        <div class="info-item" style="grid-column: 1 / -1;">
                            <div class="info-label">Zone / Street / House No</div>
                            <div class="info-value">{{ $address->Zone_Street_HouseNumber }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Barangay</div>
                            <div class="info-value">{{ $address->Barangay }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">City</div>
                            <div class="info-value">{{ $address->City }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Province</div>
                            <div class="info-value">{{ $address->Province }}</div>
                        </div>
                    </div>
                    @else
                        <p style="font-size:13px; color:#64748b;">No specific shipping address found.</p>
                    @endif

                    @if($order->note)
                    <div class="bw-section-title mt-4">Customer Note</div>
                    <div class="info-item" style="background:#fffbeb; border-color:#fef3c7;">
                        <div class="info-value" style="color:#b45309; font-weight:400; font-size:13px; font-style:italic;">
                            "{{ $order->note }}"
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Summary, Payment & Status -->
            <div class="col-md-5 d-flex flex-column gap-4">
                <!-- Order Summary -->
                <div class="bw-card mb-0">
                    <div class="bw-section-title">Order Summary</div>
                    <div class="d-flex justify-content-between mb-2">
                        <span style="font-size:13px; color:#64748b;">Subtotal</span>
                        <span style="font-size:14px; font-weight:600; color:#111;">₱{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span style="font-size:13px; color:#64748b;">Tax</span>
                        <span style="font-size:14px; font-weight:600; color:#111;">₱{{ number_format($order->tax, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                        <span style="font-size:13px; color:#64748b;">Discount</span>
                        <span style="font-size:14px; font-weight:600; color:#111;">- ₱{{ number_format($order->discount, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span style="font-size:14px; font-weight:700; color:#111; text-transform:uppercase;">Total</span>
                        <span style="font-size:18px; font-weight:800; color:#111;">₱{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="bw-card mb-0">
                    <div class="bw-section-title">Payment Info</div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span style="font-size:13px; color:#64748b; text-transform:uppercase; font-weight:700;">Mode</span>
                        <span style="font-size:14px; font-weight:800; color:#111;">{{ strtoupper($order->payment_mode) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span style="font-size:13px; color:#64748b; text-transform:uppercase; font-weight:700;">Status</span>
                        @if($order->payment_status == 'pending') <span class="bw-badge warning">Pending</span>
                        @elseif($order->payment_status == 'approved') <span class="bw-badge success">Approved</span>
                        @elseif($order->payment_status == 'declined') <span class="bw-badge danger">Declined</span>
                        @elseif($order->payment_status == 'refunded') <span class="bw-badge secondary">Refunded</span>
                        @endif
                    </div>
                </div>

                <!-- Update Status -->
                <div class="bw-card mb-0">
                    <div class="bw-section-title">Update Status</div>
                    <form action="{{ route('admin.order.update_status') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="order_id" value="{{ $order->Order_ID }}" />
                        <div class="d-flex flex-column gap-3">
                            <select name="order_status" class="form-select">
                                <option value="ordered" {{ $order->order_status == 'ordered' ? 'selected' : '' }}>Ordered</option>
                                <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="canceled" {{ $order->order_status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                            <button type="submit" class="btn-update-status">Save Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
