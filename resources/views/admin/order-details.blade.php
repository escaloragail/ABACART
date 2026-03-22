@extends('layouts.admin')
@section('content')
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

            <div class="wg-box mb-20">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Order Description (#{{ $order->Order_ID }})</h5>
                    </div>
                </div>
                @if (Session::has('success'))
                    <p class="alert alert-success mt-3">{{ Session::get('success') }}</p>
                @endif
                @if (Session::has('error'))
                    <p class="alert alert-danger mt-3">{{ Session::get('error') }}</p>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mt-3">
                        <tr>
                            <th>Order ID</th>
                            <td>{{ $order->Order_ID }}</td>
                            <th>Mobile</th>
                            <td>{{ $order->user->phone_number ?? 'N/A' }}</td>
                            <th>ZipCode</th>
                            <td>N/A</td> <!-- Database schema doesn't have zipcode on Address/User -->
                        </tr>
                        <tr>
                            <th>Order Date</th>
                            <td>{{ $order->created_at->format('M d Y h:i A') }}</td>
                            <th>Delivered Date</th>
                            <td>{{ $order->date_delivery ? \Carbon\Carbon::parse($order->date_delivery)->format('M d Y h:i A') : 'N/A' }}</td>
                            <th>Canceled Date</th>
                            <td>{{ $order->date_cancelled ? \Carbon\Carbon::parse($order->date_cancelled)->format('M d Y h:i A') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Order Status</th>
                            <td colspan="5">
                                @if($order->order_status == 'ordered') <span class="badge bg-warning">Ordered</span>
                                @elseif($order->order_status == 'delivered') <span class="badge bg-success">Delivered</span>
                                @else <span class="badge bg-danger">Canceled</span> @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="wg-box mb-20">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Ordered Items</h5>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">SKU</th>
                                <th class="text-center">Options</th>
                                <th class="text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderItems as $item)
                            <tr>
                                <td>
                                    <div class="shopping-cart__product-item">
                                        <div class="shopping-cart__product-item__detail">
                                            <h4>{{ $item->product->product_name ?? 'Product Deleted' }}</h4>
                                        </div>
                                    </div>
                                </td>
                                <td>${{ $item->price }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-center">{{ $item->product->SKU ?? 'N/A' }}</td>
                                <td class="text-center">
                                    @if ($item->options)
                                        @foreach (unserialize($item->options) as $key => $value)
                                            <strong>{{ $key }}:</strong> {{ $value }}<br>
                                        @endforeach
                                    @else
                                        None
                                    @endif
                                </td>
                                <td class="text-center">${{ $item->price * $item->quantity }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $orderItems->links('pagination::bootstrap-5') }}
                </div>
            </div>

            <div class="wg-box mb-20">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Order Summary</h5>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mt-3">
                        <tr>
                            <th>Subtotal</th>
                            <td>${{ $order->subtotal }}</td>
                        </tr>
                        <tr>
                            <th>Tax</th>
                            <td>${{ $order->tax }}</td>
                        </tr>
                        <tr>
                            <th>Discount</th>
                            <td>${{ $order->discount }}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td>${{ $order->total }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($order->note)
            <div class="wg-box mb-20">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Customer Message / Note</h5>
                    </div>
                </div>
                <div class="mt-3 p-3 border rounded bg-light">
                    {{ $order->note }}
                </div>
            </div>
            @endif
            
            <div class="wg-box mb-20">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Shipping Address</h5>
                    </div>
                </div>
                <div class="table-responsive">
                    @if($address)
                    <table class="table table-striped table-bordered mt-3">
                        <tr>
                            <th>Name</th>
                            <td>{{ $order->user->name ?? 'Unknown' }}</td>
                            <th>Address Type</th>
                            <td>{{ $address->address_type }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $order->user->phone_number ?? 'Unknown' }}</td>
                            <th>Zone / Street / House No</th>
                            <td>{{ $address->Zone_Street_HouseNumber }}</td>
                        </tr>
                        <tr>
                            <th>Barangay</th>
                            <td>{{ $address->Barangay }}</td>
                            <th>City</th>
                            <td>{{ $address->City }}</td>
                        </tr>
                        <tr>
                            <th>Province</th>
                            <td>{{ $address->Province }}</td>
                            <th></th>
                            <td></td>
                        </tr>
                    </table>
                    @else
                        <p class="mt-3">No specific shipping address found.</p>
                    @endif
                </div>
            </div>
            
            <div class="wg-box mb-20">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Transaction</h5>
                    </div>
                </div>
                <div class="table-responsive">
                    @if($transaction)
                    <table class="table table-striped table-bordered mt-3">
                        <tr>
                            <th>Payment Mode</th>
                            <td>{{ strtoupper($transaction->payment_mode) }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($transaction->status == 'pending') <span class="badge bg-warning">Pending</span>
                                @elseif($transaction->status == 'approved') <span class="badge bg-success">Approved</span>
                                @elseif($transaction->status == 'declined') <span class="badge bg-danger">Declined</span>
                                @elseif($transaction->status == 'refunded') <span class="badge bg-secondary">Refunded</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                    @else
                        <p class="mt-3">No transaction details found.</p>
                    @endif
                </div>
            </div>
            
            <div class="wg-box mb-20">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Update Order Status</h5>
                    </div>
                </div>
                <form action="{{ route('admin.order.update_status') }}" method="POST" class="mt-3">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="order_id" value="{{ $order->Order_ID }}" />
                    <div class="row">
                        <div class="col-md-3">
                            <select name="order_status" class="form-control">
                                <option value="ordered" {{ $order->order_status == 'ordered' ? 'selected' : '' }}>Ordered</option>
                                <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="canceled" {{ $order->order_status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary tf-button w208">Update Status</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
