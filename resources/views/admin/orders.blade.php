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
                                        <form action="{{ route('admin.order.update_status') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="order_id" value="{{ $order->Order_ID }}">
                                            <div class="status-wrap">
                                                <select
                                                    name="order_status"
                                                    onchange="this.form.submit()"
                                                    class="status-select status-{{ $order->order_status }}"
                                                    {{ $order->order_status == 'delivered' ? 'disabled' : '' }}
                                                >
                                                    <option value="ordered"   {{ $order->order_status == 'ordered'   ? 'selected' : '' }}>Ordered</option>
                                                    <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                </select>
                                            </div>
                                        </form>
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
    <style>
    .status-wrap {
        display: flex;
        justify-content: center;
    }
    .status-select {
        border: none;
        border-radius: 20px;
        padding: 3px 8px;
        font-size: 11px;
        font-weight: 800;
        cursor: pointer;
        outline: none;
        appearance: none;
        -webkit-appearance: none;
        text-align: center;
        text-align-last: center;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        width: auto;
    }
    .status-select.status-ordered   { background-color: #ffc107; color: #5a3e00; }
    .status-select.status-delivered { background-color: #198754; color: #ffffff; }
    .status-select.status-canceled  { background-color: #dc3545; color: #ffffff; }
    .status-select:disabled         { opacity: 0.75; cursor: not-allowed; }
</style>
@endsection
