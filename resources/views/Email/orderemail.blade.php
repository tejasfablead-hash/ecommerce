<h2>Hi <strong class="text-capitalize"> {{ $order->customer_name }} </strong></h2>

@if ($order->payment_method === 'cod')
    <p>✅ Your order has been confirmed successfully.</p>
@else
    <p>✅ Your order has been confirmed And Pay with {{ $order->payment_method }}.</p>
@endif

<p><strong>Order Number:</strong> {{ $order->order_number }}</p>

<p>
    <strong>Product:</strong>
    @foreach ($order->orderitem as $item)
        <p>{{ strtoupper($item->product->name) }}</p>
    @endforeach
</p>

<p>
    <strong>Total Amount:</strong>
    ₹{{ number_format($order->grand_total ?? 0, 2) }}
</p>

<p>
    <strong>Payment Method:</strong>
    {{ strtoupper($order->payment_method) }}
</p>

<hr>

<p>Thank you for shopping with us ❤️</p>
<p><strong>Ecommerce Karma Team</strong></p>
