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
                    <div class="flex items-center gap10 flex-wrap">
                        <a href="{{ route('admin.orders') }}" class="tf-button style-1 {{ !$status ? 'bg-primary text-white' : 'btn-outline-primary' }}">All ({{ $counts['all'] }})</a>
                        <a href="{{ route('admin.orders', ['status' => 'ordered']) }}" class="tf-button style-1 {{ $status == 'ordered' ? 'bg-warning text-dark' : 'btn-outline-warning' }}">Ordered ({{ $counts['ordered'] }})</a>
                        <a href="{{ route('admin.orders', ['status' => 'delivered']) }}" class="tf-button style-1 {{ $status == 'delivered' ? 'bg-success text-white' : 'btn-outline-success' }}">Delivered ({{ $counts['delivered'] }})</a>
                        <a href="{{ route('admin.orders', ['status' => 'canceled']) }}" class="tf-button style-1 {{ $status == 'canceled' ? 'bg-danger text-white' : 'btn-outline-danger' }}">Canceled ({{ $counts['canceled'] }})</a>
                    </div>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        @if (Session::has('success'))
                            <p class="alert alert-success">{{ Session::get('success') }}</p>
                        @endif
                        <table class="table table-striped table-bordered">
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
                                    <td>{{ $order->Order_ID }}</td>
                                    <td>{{ $order->user->name ?? 'Unknown' }}</td>
                                    <td>${{ $order->subtotal }}</td>
                                    <td>${{ $order->discount }}</td>
                                    <td>${{ $order->total }}</td>
                                    <td>
                                        @if($order->order_status == 'ordered') <span class="badge bg-warning">Ordered</span>
                                        @elseif($order->order_status == 'delivered') <span class="badge bg-success">Delivered</span>
                                        @else <span class="badge bg-danger">Canceled</span> @endif
                                    </td>
                                    <td>{{ $order->created_at->format('M d Y') }}</td>
                                    <td>
                                        <div class="list-icon-function">
                                            <a href="{{ route('admin.order.details', ['order_id' => $order->Order_ID]) }}">
                                                <div class="item edit">
                                                    <i class="icon-eye"></i>
                                                </div>
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
