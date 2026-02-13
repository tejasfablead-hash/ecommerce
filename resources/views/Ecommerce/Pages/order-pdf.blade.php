<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #000;
        }

        h2,
        h3 {
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            vertical-align: middle;
        }

        th {
            background-color: #f5f5f5;
        }

        .no-border td {
            border: none;
            padding: 3px 0;
        }

        .text-right {
            text-align: right;
        }

        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border: 1px solid #ddd;
        }

        .fixed-width {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-block;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <table class="no-border">
        <tr>
            <td> <img src="{{ public_path('Karma Shop-doc/img/logo.png') }}" width="120"> </td>
            <td class="text-right">
                <h2>Order Confirmation</h2>
                <p><strong>Thank you. Your order has been received.</strong></p>
            </td>
        </tr>
    </table>

    <hr>

    {{-- ORDER INFO --}}
    <h3>Order Info</h3>
    <table class="no-border">
        <tr>
            <td>
                <strong>Transaction ID:</strong>
                {{ $order->transactionId ?? '-' }}
            </td>
            <td><strong>Date:</strong> {{ $order->updated_at->format('d M Y') }}</td>
            <td><strong>Total:</strong> ₹{{ number_format($order->grand_total, 2) }}</td>
        </tr>
    </table>

    <hr>

    {{-- CUSTOMER INFO --}}
    <h3>Customer Details</h3>
    <table class="no-border">
        <tr>
            <td><strong>Name:</strong> {{ ucfirst($order->customer_name) }}</td>
            <td><strong>Email:</strong> {{ $order->email }}</td>
        </tr>
        <tr>
            <td><strong>Phone:</strong> {{ $order->phone }}</td>
            <td><strong>Pincode:</strong> {{ $order->pincode }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Address:</strong> {{ $order->address }}</td>
        </tr>
    </table>

    <hr>

    {{-- PAYMENT INFO --}}
    <h3>Payment Details</h3>
    <table class="no-border">
        <tr>
            <td><strong>Order Number:</strong> {{ $order->order_number }}</td>
        </tr>
        <tr>
            <td><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</td>
        </tr>
        <tr>
            <td><strong>Order Status:</strong> {{ ucfirst($order->order_status) }}</td>
        </tr>
        <tr>
            <td><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</td>
        </tr>

    </table>

    <hr>

    {{-- ORDER ITEMS WITH IMAGE --}}
    <h3>Order Details</h3>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Price</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($order->orderitem as $item)
                <tr>
                    @php
                        $images = json_decode($item->product->image, true);
                    @endphp
                    <td>
                        @if ($images)
                            @foreach ($images as $img)
                                <img src="{{ public_path('storage/' . $img) }}" class=" product-img"
                                    style="margin-top:20px;gap:10px">
                            @endforeach
                        @else
                            <span>N/A</span>
                        @endif
                    </td>
                    <td>{{ ucfirst($item->product->name) }}</td>
                    <td class="text-right">{{ $item->qty }}</td>
                    <td class="text-right">₹{{ number_format($item->price, 2) }}</td>
                    <td class="text-right">₹{{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TOTAL SUMMARY --}}
    <table>
        <tr>
            <td colspan="4" class="text-right"><strong>Subtotal</strong></td>
            <td class="text-right">
                ₹{{ number_format($order->subtotal, 0) }}
            </td>
        </tr>

        <tr>
            <td colspan="4" class="text-right">
                <strong>GST ({{ (int) $order->gst_percent }}%)</strong>
            </td>
            <td class="text-right">
                ₹{{ number_format($order->gst_amount, 0) }}
            </td>
        </tr>

        <tr>
            <td colspan="4" class="text-right">
                <strong>Discount ({{ (int) $order->discount_percent }}%)</strong>
            </td>
            <td class="text-right">
                ₹{{ number_format($order->discount_amount, 0) }}
            </td>
        </tr>

        <tr>
            <td colspan="4" class="text-right"><strong>Grand Total</strong></td>
            <td class="text-right">
                <strong>₹{{ number_format($order->grand_total, 0) }}</strong>
            </td>
        </tr>
    </table>


</body>

</html>
