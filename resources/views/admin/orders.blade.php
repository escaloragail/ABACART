@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Orders</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{route('admin.index')}}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><div class="text-tiny">Orders</div></li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap mb-20">
                    <div class="modern-filter-tabs">
                        <a href="{{ route('admin.orders') }}" class="modern-tab {{ !$status ? 'active' : '' }}">All Orders <span class="count-badge">{{ $counts['all'] }}</span></a>
                        <a href="{{ route('admin.orders', ['status' => 'ordered']) }}" class="modern-tab {{ $status == 'ordered' ? 'active' : '' }}">Ordered <span class="count-badge">{{ $counts['ordered'] }}</span></a>
                        <a href="{{ route('admin.orders', ['status' => 'delivered']) }}" class="modern-tab {{ $status == 'delivered' ? 'active' : '' }}">Delivered <span class="count-badge">{{ $counts['delivered'] }}</span></a>
                        <a href="{{ route('admin.orders', ['status' => 'canceled']) }}" class="modern-tab {{ $status == 'canceled' ? 'active' : '' }}">Canceled <span class="count-badge">{{ $counts['canceled'] }}</span></a>
                    </div>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive modern-table-wrap">
                        @if (Session::has('success'))
                            <p class="alert alert-success">{{ Session::get('success') }}</p>
                        @endif
                        <table class="table modern-table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>User</th>
                                    <th>Subtotal</th>
                                    <th>Discount</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Order Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <td class="td-id">#{{ $order->Order_ID }}</td>
                                    <td><strong>{{ $order->user->name ?? 'Unknown' }}</strong></td>
                                    <td>₱{{ $order->subtotal }}</td>
                                    <td>₱{{ $order->discount }}</td>
                                    <td class="td-price">₱{{ $order->total }}</td>
                                    <td>
                                        @if($order->order_status == 'ordered') <span class="modern-badge bg-warning-soft">Ordered</span>
                                        @elseif($order->order_status == 'delivered') <span class="modern-badge bg-success-soft">Delivered</span>
                                        @else <span class="modern-badge bg-danger-soft">Canceled</span> @endif
                                    </td>
                                    <td>{{ $order->created_at->format('M d Y') }}</td>
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
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
