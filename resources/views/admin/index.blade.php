@extends('layouts.admin')
@section('content')

<div class="main-content-inner">
    <div class="main-content-wrap">

        <!-- ===== TOP STAT CARDS ROW ===== -->
        <div class="dash-stats-row">
            <div class="dash-stat-card">
                <div class="dash-stat-icon" style="background: #f3e8ff; color: #9333ea;">
                    <i class="icon-users" style="font-size: 20px;"></i>
                </div>
                <div class="dash-stat-info">
                    <span class="dash-stat-value">{{ $total_customers }}</span>
                    <span class="dash-stat-label">Total Customers</span>
                </div>
            </div>
            <div class="dash-stat-card">
                <div class="dash-stat-icon" style="background: #fef3c7; color: #d97706;">
                    <i class="icon-package" style="font-size: 20px;"></i>
                </div>
                <div class="dash-stat-info">
                    <span class="dash-stat-value">{{ $total_products }}</span>
                    <span class="dash-stat-label">Total Products</span>
                </div>
            </div>
            <div class="dash-stat-card">
                <div class="dash-stat-icon" style="background: #dbeafe; color: #2563eb;">
                    <i class="icon-shopping-bag" style="font-size: 20px;"></i>
                </div>
                <div class="dash-stat-info">
                    <span class="dash-stat-value">{{ $total_orders }}</span>
                    <span class="dash-stat-label">Total Orders</span>
                </div>
            </div>
            <div class="dash-stat-card">
                <div class="dash-stat-icon" style="background: #dcfce7; color: #16a34a;">
                    <i class="icon-dollar-sign" style="font-size: 20px;"></i>
                </div>
                <div class="dash-stat-info">
                    <span class="dash-stat-value">₱{{ number_format($total_amount, 2) }}</span>
                    <span class="dash-stat-label">Total Sales</span>
                </div>
            </div>
        </div>

        <!-- ===== SALES TREND CHART ===== -->
        <div class="dash-chart-section">
            <div class="dash-chart-card dash-chart-wide">
                <div class="dash-chart-header">
                    <h6 class="dash-chart-title">Sales Trend</h6>
                    <div class="dash-chart-legend">
                        <span class="dash-legend-item"><span class="dash-legend-dot" style="background:#7c3aed;"></span> Total</span>
                        <span class="dash-legend-item"><span class="dash-legend-dot" style="background:#ef4444;"></span> Delivered</span>
                    </div>
                </div>
                <div id="line-chart-8"></div>
            </div>
            <div class="dash-chart-card dash-chart-narrow">
                <div class="dash-chart-header">
                    <h6 class="dash-chart-title">Earnings revenue</h6>
                </div>
                <div id="bar-chart-status"></div>
            </div>
        </div>

        <!-- ===== RECENT ORDERS TABLE ===== -->
        <div class="dash-orders-section">
            <div class="dash-orders-card wg-box" style="padding: 0; overflow: hidden; margin-top: 20px;">
                <div class="dash-orders-header" style="padding: 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                    <h6 class="dash-chart-title" style="margin: 0;">Recent Orders</h6>
                    <a href="{{ route('admin.orders') }}" class="dash-view-all" style="font-size: 13px; font-weight: 600; color: #111;">View All</a>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive modern-table-wrap">
                        <table class="table modern-table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer Name</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recent_orders as $order)
                                <tr>
                                    <td class="td-id">#{{ $order->Order_ID }}</td>
                                    <td><strong>{{ $order->user->name ?? 'Guest' }}</strong></td>
                                    <td>{{ $order->created_at->format('M d Y') }}</td>
                                    <td class="td-price">₱{{ number_format($order->total, 2) }}</td>
                                    <td>
                                        @if($order->order_status == 'delivered')
                                            <span class="modern-badge bg-success-soft">Delivered</span>
                                        @elseif($order->order_status == 'canceled')
                                            <span class="modern-badge bg-danger-soft">Canceled</span>
                                        @else
                                            <span class="modern-badge bg-warning-soft">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.order.details', ['order_id' => $order->Order_ID]) }}" class="btn-action-pill">
                                                VIEW DETAILS
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    (function ($) {
        // Sales Trend Line Chart
        var salesOptions = {
            series: [{
                name: 'Total',
                data: {!! json_encode($monthlyTotals) !!}
            }, {
                name: 'Delivered',
                data: {!! json_encode($monthlyDelivered) !!}
            }],
            chart: {
                type: 'area',
                height: 260,
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif',
            },
            colors: ['#7c3aed', '#ef4444'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2.5 },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                labels: { style: { colors: '#94a3b8', fontSize: '11px' } },
                axisBorder: { show: false },
                axisTicks: { show: false },
            },
            yaxis: {
                labels: {
                    style: { colors: '#94a3b8', fontSize: '11px' },
                    formatter: function(val) { return '₱' + val.toLocaleString(); }
                }
            },
            grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
            legend: { show: false },
            tooltip: {
                y: { formatter: function (val) { return "₱" + val.toLocaleString(); } }
            }
        };

        // Order Status Bar Chart
        var statusOptions = {
            series: [{
                name: 'Pending',
                data: {!! json_encode($monthlyPending) !!}
            }, {
                name: 'Delivered',
                data: {!! json_encode($monthlyDelivered) !!}
            }, {
                name: 'Canceled',
                data: {!! json_encode($monthlyCanceled) !!}
            }],
            chart: {
                type: 'bar',
                height: 260,
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif',
            },
            plotOptions: {
                bar: { columnWidth: '45%', borderRadius: 4 }
            },
            colors: ['#7c3aed', '#3b82f6', '#f87171'],
            dataLabels: { enabled: false },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                labels: { style: { colors: '#94a3b8', fontSize: '10px' } },
                axisBorder: { show: false },
                axisTicks: { show: false },
            },
            yaxis: { show: false },
            grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
            legend: { show: false },
            tooltip: {
                y: { formatter: function (val) { return "₱" + val.toLocaleString(); } }
            }
        };

        $(window).on("load", function () {
            if ($("#line-chart-8").length > 0) {
                new ApexCharts(document.querySelector("#line-chart-8"), salesOptions).render();
            }
            if ($("#bar-chart-status").length > 0) {
                new ApexCharts(document.querySelector("#bar-chart-status"), statusOptions).render();
            }
        });
    })(jQuery);
</script>
@endpush