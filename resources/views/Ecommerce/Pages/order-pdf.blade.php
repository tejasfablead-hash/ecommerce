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
    </style>
</head>

<body>

    <h2>Order Confirmation</h2>
    <p><strong>Thank you. Your order has been received.</strong></p>

    <hr>

    <!-- ORDER INFO -->
    <h3>Order Info</h3>
    <table class="no-border">
        <tr>
            <td><strong>Transaction ID:</strong> {{ $order->transactionId }}</td>
            <td><strong>Order Number:</strong> {{ $order->order_number }}</td>
        </tr>
        <tr>
            <td><strong>Date:</strong> {{ $order->updated_at->format('d M Y') }}</td>
            <td><strong>Total:</strong> ₹{{ number_format($order->grand_total, 2) }}</td>
        </tr>
    </table>

    <hr>

    <!-- CUSTOMER INFO -->
    <h3>Customer Details</h3>
    <table class="no-border">
        <tr>
            <td class="text-capitalize"><strong>Name:</strong> {{ ucfirst($order->customer_name) }}</td>
            <td><strong>Email:</strong> {{ $order->email }}</td>
        </tr>
        <tr>
            <td><strong>Phone:</strong> {{ $order->phone }}</td>
            <td><strong>Pincode:</strong> {{ $order->pincode }}</td>
        </tr>
        <tr>
            <td colspan="2" class="text-capitalize"><strong>Address:</strong> {{ $order->address }}</td>
        </tr>
    </table>

    <hr>

    <!-- PAYMENT INFO -->
    <h3>Payment Details</h3>
    <table class="no-border">
        <tr class="text-capitalize">
            <td><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</td>
            <td><strong>Order Status:</strong> {{ ucfirst($order->order_status) }}</td>
            <td><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</td>
        </tr>
    </table>

    <hr>

    <!-- ORDER ITEMS -->
    <h3>Order Details</h3>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Price</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody class="text-capitalize">
            @foreach ($order->orderitem as $item)
                <tr>
                    <td class="text-capitalize">
                        {{ ucfirst($item->product->name) }}
                    </td>
                    <td class="text-right">{{ $item->qty }}</td>
                    <td class="text-right">₹{{ number_format($item->price, 2) }}</td>
                    <td class="text-right">₹{{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TOTAL SUMMARY -->
    <table>
        <tr>
            <td colspan="3" class="text-right"><strong>Subtotal</strong></td>
            <td class="text-right">₹{{ number_format($order->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td colspan="3" class="text-right">
                <strong>GST ({{ (int) $order->gst_percent }}%)</strong>
            </td>
            <td class="text-right">₹{{ number_format($order->gst_amount, 2) }}</td>
        </tr>
        <tr>
            <td colspan="3" class="text-right">
                <strong>Discount ({{ (int) $order->discount_percent }}%)</strong>
            </td>
            <td class="text-right">₹{{ number_format($order->discount_amount, 2) }}</td>
        </tr>
        <tr>
            <td colspan="3" class="text-right"><strong>Grand Total</strong></td>
            <td class="text-right"><strong>₹{{ number_format($order->grand_total, 2) }}</strong></td>
        </tr>
    </table>

</body>

</html>
