<div class="ac-grid">
    <div class="ac-card">
        <div class="label">Orders Placed</div>
        <div class="value">{{ $stats['orders_count'] }}</div>
    </div>
    <div class="ac-card">
        <div class="label">Wishlist</div>
        <div class="value">{{ $stats['wishlist_count'] }}</div>
    </div>
    <div class="ac-card">
        <div class="label">In Cart</div>
        <div class="value">{{ $stats['cart_count'] }}</div>
    </div>
    @if(get_setting('wallet_system') == 1)
        <div class="ac-card">
            <div class="label">Wallet Balance</div>
            <div class="value">{{ single_price($stats['wallet_balance']) }}</div>
        </div>
    @endif
</div>

@if($completeness < 100)
    <div class="ac-panel">
        <h3>Complete your profile</h3>
        <div class="bar"><i style="width: {{ $completeness }}%"></i></div>
        <p style="color:#6b7280;font-size:13px;margin:10px 0 0;">
            Your profile is {{ $completeness }}% complete.
            <a href="{{ route($role . '.profile') }}" style="color:#c0392b;font-weight:600;">Finish it &rarr;</a>
        </p>
    </div>
@endif

<div class="ac-panel">
    <h3>Recent orders</h3>
    @if($recentOrders->isEmpty())
        <p style="color:#6b7280;font-size:14px;margin:0;">
            No orders yet. <a href="{{ route('home') }}" style="color:#c0392b;font-weight:600;">Browse artworks &rarr;</a>
        </p>
    @else
        <table class="ac-table">
            <thead>
                <tr><th>Order code</th><th>Amount</th><th>Payment</th><th>Delivery</th><th>Placed</th></tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                    <tr>
                        <td>{{ $order->code }}</td>
                        <td>{{ single_price($order->grand_total) }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $order->delivery_status)) }}</td>
                        <td>{{ $order->created_at?->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p style="margin:14px 0 0;"><a href="{{ route('purchase_history.index') }}" style="color:#c0392b;font-weight:600;">View all orders &rarr;</a></p>
    @endif
</div>
