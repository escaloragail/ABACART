<div class="table-responsive">
    <table class="table-custom">
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
                <td style="font-weight: 700; color: #111;">#{{ $order->Order_ID }}</td>
                <td style="color: #4a5568;">{{ $order->created_at->format('M d Y') }}</td>
                <td>
                    @if($order->order_status == 'ordered')
                        <span class="badge-status badge-ordered">Placed</span>
                    @elseif($order->order_status == 'delivered')
                        <span class="badge-status badge-delivered">Delivered</span>
                    @elseif($order->order_status == 'canceled')
                        <span class="badge-status badge-canceled">Canceled</span>
                    @endif
                </td>
                <td style="font-weight: 700; color: #111;">₱{{ number_format($order->total, 2) }}</td>
                <td>
                    <a href="{{ route('user.order.details', ['order_id' => $order->Order_ID]) }}" class="btn-view-details">View Details</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center" style="padding: 60px 0; color: #a0aec0;">
                    <i class="fa fa-shopping-bag" style="font-size: 40px; display: block; margin-bottom: 15px; opacity: 0.25;"></i>
                    No orders found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
