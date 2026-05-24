@extends('layouts.admin')
@section('content')
<style>
    /* ── Sales Page Styles (matches existing B&W aesthetic) ── */
    .sales-summary-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .sales-stat-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 20px 24px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .sales-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }
    .sales-stat-label {
        font-family: 'Inter', sans-serif;
        font-size: 11px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 6px;
    }
    .sales-stat-value {
        font-family: 'Inter', sans-serif;
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }

    /* Filter Bar */
    .sales-filter-bar {
        background: #ffffff;
        border-radius: 14px;
        padding: 20px 24px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        margin-bottom: 24px;
    }
    .sales-filter-bar form {
        display: flex;
        align-items: flex-end;
        gap: 16px;
        flex-wrap: wrap;
    }
    .sales-filter-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .sales-filter-group label {
        font-family: 'Inter', sans-serif;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .sales-filter-group input[type="date"] {
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        font-weight: 600;
        color: #0f172a;
        padding: 10px 14px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: #f8fafc;
        outline: none;
        transition: border-color 0.2s ease;
    }
    .sales-filter-group input[type="date"]:focus {
        border-color: #111;
        box-shadow: 0 0 0 3px rgba(0,0,0,0.05);
    }
    .btn-filter-apply {
        font-family: 'Inter', sans-serif;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 11px 24px;
        background: #111;
        color: #fff;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-filter-apply:hover {
        background: #2d3748;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .btn-filter-reset {
        font-family: 'Inter', sans-serif;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 11px 24px;
        background: transparent;
        color: #64748b;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }
    .btn-filter-reset:hover {
        background: #f1f5f9;
        color: #475569;
    }
    .btn-print-report {
        font-family: 'Inter', sans-serif;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 11px 24px;
        background: transparent;
        color: #0f172a;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-left: auto;
    }
    .btn-print-report:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    /* Print styles */
    @media print {
        .section-menu-left, .header-dashboard, .sales-filter-bar,
        .btn-print-report, .modern-filter-tabs, .wgp-pagination,
        .breadcrumbs, .no-print {
            display: none !important;
        }
        .section-content-right {
            margin-left: 0 !important;
            width: 100% !important;
        }
        .main-content {
            padding: 0 !important;
        }
        .sales-summary-row {
            break-inside: avoid;
        }
        .wg-box {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
        body {
            zoom: 100% !important;
        }
    }

    @media (max-width: 768px) {
        .sales-summary-row {
            grid-template-columns: 1fr;
        }
        .sales-filter-bar form {
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>

<div class="main-content-inner">
    <div class="main-content-wrap">
        {{-- Header --}}
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Sales</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Sales</div></li>
            </ul>
        </div>

        {{-- Summary Cards --}}
        <div class="sales-summary-row">
            <div class="sales-stat-card">
                <div class="sales-stat-label">Total Sales Revenue</div>
                <div class="sales-stat-value">₱{{ number_format($total_sales, 2) }}</div>
            </div>
            <div class="sales-stat-card">
                <div class="sales-stat-label">Total Transactions</div>
                <div class="sales-stat-value">{{ $total_transactions }}</div>
            </div>
            <div class="sales-stat-card">
                <div class="sales-stat-label">Total Discounts Given</div>
                <div class="sales-stat-value">₱{{ number_format($total_discount, 2) }}</div>
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="sales-filter-bar no-print">
            <form method="GET" action="{{ route('admin.sales') }}">
                <div class="sales-filter-group">
                    <label>Date From</label>
                    <input type="date" name="date_from" value="{{ $date_from }}">
                </div>
                <div class="sales-filter-group">
                    <label>Date To</label>
                    <input type="date" name="date_to" value="{{ $date_to }}">
                </div>
                <input type="hidden" name="status" value="{{ $status_filter }}">
                <button type="submit" class="btn-filter-apply">Filter</button>
                <a href="{{ route('admin.sales') }}" class="btn-filter-reset">Reset</a>
                <button type="button" class="btn-print-report" onclick="window.print()">
                    <i class="icon-printer"></i> Print Report
                </button>
            </form>
        </div>

        {{-- Sales Table --}}
        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap mb-20 no-print">
                <div class="modern-filter-tabs">
                    <a href="{{ route('admin.sales', array_merge(request()->only(['date_from', 'date_to']), ['status' => 'delivered'])) }}" class="modern-tab {{ $status_filter == 'delivered' ? 'active' : '' }}">Completed <span class="count-badge">{{ $counts['delivered'] }}</span></a>
                    <a href="{{ route('admin.sales', array_merge(request()->only(['date_from', 'date_to']), ['status' => 'ordered'])) }}" class="modern-tab {{ $status_filter == 'ordered' ? 'active' : '' }}">Pending <span class="count-badge">{{ $counts['ordered'] }}</span></a>
                    <a href="{{ route('admin.sales', array_merge(request()->only(['date_from', 'date_to']), ['status' => 'canceled'])) }}" class="modern-tab {{ $status_filter == 'canceled' ? 'active' : '' }}">Canceled <span class="count-badge">{{ $counts['canceled'] }}</span></a>
                    <a href="{{ route('admin.sales', array_merge(request()->only(['date_from', 'date_to']), ['status' => 'all'])) }}" class="modern-tab {{ $status_filter == 'all' ? 'active' : '' }}">All <span class="count-badge">{{ $counts['all'] }}</span></a>
                </div>
            </div>
            <div class="wg-table table-all-user">
                <div class="table-responsive modern-table-wrap">
                    <table class="table modern-table">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Payment Mode</th>
                                <th>Payment Status</th>
                                <th>Subtotal</th>
                                <th>Discount</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sales as $sale)
                            <tr>
                                <td class="td-id">#{{ $sale->Order_ID }}</td>
                                <td><strong>{{ $sale->user->name ?? 'Unknown' }}</strong></td>
                                <td>{{ $sale->created_at->format('M d, Y') }}</td>
                                <td>
                                    <span style="font-weight:700; text-transform:uppercase; font-size:12px;">{{ $sale->payment_mode ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    @if($sale->payment_status == 'pending') <span class="modern-badge bg-warning-soft">Pending</span>
                                    @elseif($sale->payment_status == 'approved') <span class="modern-badge bg-success-soft">Approved</span>
                                    @elseif($sale->payment_status == 'declined') <span class="modern-badge bg-danger-soft">Declined</span>
                                    @elseif($sale->payment_status == 'refunded') <span class="modern-badge bg-secondary-soft">Refunded</span>
                                    @else <span class="modern-badge bg-secondary-soft">N/A</span>
                                    @endif
                                </td>
                                <td>₱{{ number_format($sale->subtotal, 2) }}</td>
                                <td>₱{{ number_format($sale->discount, 2) }}</td>
                                <td class="td-price">₱{{ number_format($sale->total, 2) }}</td>
                                <td>
                                    @if($sale->order_status == 'ordered') <span class="modern-badge bg-warning-soft">Ordered</span>
                                    @elseif($sale->order_status == 'delivered') <span class="modern-badge bg-success-soft">Delivered</span>
                                    @else <span class="modern-badge bg-danger-soft">Canceled</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.order.details', ['order_id' => $sale->Order_ID]) }}" class="btn-action-pill">
                                        VIEW
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" style="text-align:center; padding:40px 20px; color:#94a3b8; font-size:14px;">
                                    No sales records found for the selected filters.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{ $sales->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
