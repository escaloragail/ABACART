@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Order Details</h2>
        <div class="row">
            <div class="col-lg-3">
                @include('user.account-nav')
            </div>
            <div class="col-lg-9">
                @if (Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                <div class="page-content my-account__order-details">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5>Order #{{ $order->Order_ID }}</h5>
                        <a href="{{ route('user.orders') }}" class="btn btn-primary btn-sm">Back to Orders</a>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Shipping Address</h6>
                                </div>
                                <div class="card-body">
                                    @if($address)
                                    <p class="mb-1"><strong>Name:</strong> {{ $order->user->name ?? 'Unknown' }}</p>
                                    <p class="mb-1"><strong>Street/Zone:</strong> {{ $address->Zone_Street_HouseNumber }}</p>
                                    <p class="mb-1"><strong>Barangay:</strong> {{ $address->Barangay }}</p>
                                    <p class="mb-1"><strong>City:</strong> {{ $address->City }}</p>
                                    <p class="mb-1"><strong>Province:</strong> {{ $address->Province }}</p>
                                    <p class="mb-0"><strong>Address Type:</strong> {{ $address->address_type }}</p>
                                    @else
                                    <p>No address mapped.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Order Info.</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-1"><strong>Date:</strong> {{ $order->created_at->format('M d Y h:i A') }}</p>
                                    <p class="mb-1"><strong>Status:</strong> 
                                        @if($order->order_status == 'ordered') <span class="badge bg-warning">Placed</span>
                                        @elseif($order->order_status == 'delivered') <span class="badge bg-success">Delivered</span>
                                        @else <span class="badge bg-danger">Canceled</span> @endif
                                    </p>
                                    @if($transaction)
                                    <p class="mb-1"><strong>Payment Mode:</strong> {{ strtoupper($transaction->payment_mode) }}</p>
                                    <p class="mb-0"><strong>Payment Status:</strong> {{ ucfirst($transaction->status) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($order->note)
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Customer Message / Note</h6>
                        </div>
                        <div class="card-body">
                            {{ $order->note }}
                        </div>
                    </div>
                    @endif

                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Ordered Items</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orderItems as $item)
                                        <tr>
                                            <td>{{ $item->product->product_name ?? 'Deleted Product' }}</td>
                                            <td class="text-center">${{ $item->price }}</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-right">${{ $item->price * $item->quantity }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-right">Subtotal</th>
                                            <th class="text-right">${{ $order->subtotal }}</th>
                                        </tr>
                                        @if($order->discount > 0)
                                        <tr>
                                            <th colspan="3" class="text-right">Discount</th>
                                            <th class="text-right">-${{ $order->discount }}</th>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th colspan="3" class="text-right">Tax</th>
                                            <th class="text-right">${{ $order->tax }}</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="text-right">Total</th>
                                            <th class="text-right">${{ $order->total }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if($order->order_status == 'ordered')
                    <div class="text-right">
                        <form action="{{ route('user.order.cancel') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="order_id" value="{{ $order->Order_ID }}">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this order?')">Cancel Order</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
