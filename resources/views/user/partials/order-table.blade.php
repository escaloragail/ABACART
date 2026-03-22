<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Date</th>
                <th>Status</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders_list as $order)
            <tr>
                <td>{{ $order->Order_ID }}</td>
                <td>{{ $order->created_at->format('M d Y') }}</td>
                <td>
                    @if($order->order_status == 'ordered')
                        <span class="badge bg-warning">Placed</span>
                    @elseif($order->order_status == 'delivered')
                        <span class="badge bg-success">Delivered</span>
                    @elseif($order->order_status == 'canceled')
                        <span class="badge bg-danger">Canceled</span>
                    @endif
                </td>
                <td>${{ $order->total }}</td>
                <td>
                    <a href="{{ route('user.order.details', ['order_id' => $order->Order_ID]) }}" class="btn btn-sm btn-info">View Details</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No orders found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
