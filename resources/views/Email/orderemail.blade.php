<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 650px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .header {
            background: #f5752c;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 25px;
            color: #333;
            line-height: 1.6;
        }

        .order-box {
            background: #f9fafb;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: #eee;
            padding: 10px;
            text-align: left;
        }

        .table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
        }

        .gst {
            font-size: 12px;
            text-align: right;
            color: #eb640b;
        }

        .footer {
            background: #f1f1f1;
            padding: 15px;
            text-align: center;
            font-size: 13px;
            color: #666;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            color: #fff;
            font-size: 12px;
        }

        .cod {
            background: #ff9800;
        }

        .online {
            background: #28a745;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🛒 Order Confirmed</h1>
            <p>Thank you for shopping with Ecommerce Karma</p>
        </div>

        <div class="content">
            <h2>Hello <span style="color:#080808;" class="text-capitalize">{{ strtoupper($order->customer_name) }}</span>
            </h2>

            @if ($order->payment_method === 'cod')
                <p>✅ Your order has been <b>confirmed successfully</b> with <b>Cash On Delivery</b>.</p>
            @else
                <p>✅ Your payment via <b>{{ strtoupper($order->payment_method) }}</b> has been completed successfully.
                </p>
            @endif

            <div class="order-box">
                <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                <p>
                    <strong>Payment Method:</strong>
                    @if ($order->payment_method === 'cod')
                        <span class="badge cod">COD</span>
                    @else
                        <span class="badge online">{{ strtoupper($order->payment_method) }}</span>
                    @endif
                </p>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>SubTotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderitem as $item)
                            <tr>
                                <td>{{ strtoupper($item->product->name) }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>₹{{ number_format($item->price, 0) }}</td>
                                <td>₹{{ number_format($item->qty * $item->price, 0) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <p class="gst">
                    GST (18%): ₹{{ number_format($order->gst_amount, 0) }}
                </p>
                <p class="discount" style="font-size: 12px; text-align: right; color: #03f724;">
                    Discount ({{ (int) $order->discount_percent ?? '0' }}%):
                    ₹{{ number_format($order->discount_amount, 0) }}
                </p>
                <p class="total">
                    Total Amount: ₹{{ number_format($order->grand_total, 0) }}
                </p>
            </div>
            @if ($order->payment_method === 'cod')
                <p style="color:#f08d36;">
                    Please keep the cash ready at the time of delivery.
                </p>
            @endif
            @if ($order->payment_method !== 'cod')
                <p style="color:#28a745;">
                    💳 Your payment has been successfully processed. No further action is required.
                </p>
            @endif
            <p>
                You can track your order anytime from your account dashboard.
            </p>
            <p>
                Thank you for choosing <strong>Ecommerce Karma</strong>
            </p>
            
            <p>
                <a href="{{ route('UserOrderPdf', $order->id) }}"
                    style="background:#ff5304;color:#fff;padding:10px 20px;text-decoration:none;border-radius:5px;">
                    📄 Download Invoice PDF
                </a>
            </p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} Ecommerce Karma. All Rights Reserved.</p>
        </div>
    </div>
</body>

</html>
