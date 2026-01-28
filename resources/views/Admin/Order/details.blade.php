@extends('Admin.Pages.index')

@section('container')
    <main class="nxl-container">
        <div class="nxl-content">

            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Order Details</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Order Details</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex d-md-none">
                            <a href="javascript:void(0)" class="page-header-right-close-toggle">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Back</span>
                            </a>
                        </div>
                        <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                            <a href="{{ route('OrderViewPage') }}" class="btn btn-primary ">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Back</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CUSTOMER INFO -->
            <div class="main-content">
                <div class="card mb-3">
                    <div class="card-body">
                        <h6>Customer Details</h6>
                        <p class="text-capitalize"><strong>Name : </strong> {{ $order->getcustomer->name }}</p>
                        <p><strong>Email : </strong> {{ $order->email }}</p>
                        <p><strong>Phone : </strong> {{ $order->phone }}</p>
                        <p class="text-capitalize"><strong>Address : </strong> {{ $order->address }}</p>
                        <p class="text-capitalize"><strong>Pincode : </strong> {{ $order->pincode }}</p>
                    </div>
                </div>

                <!-- ORDER INFO -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h6>Order Info</h6>
                        <p><strong>Order ID:</strong> {{ $order->order_number }}</p>
                        <p><strong>Payment:</strong> {{ ucfirst($order->payment_method) }}</p>
                        <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
                        <p><strong>Order Status:</strong> {{ ucfirst($order->order_status) }}</p>
                        <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                <!-- PRODUCT LIST -->
                <div class="card">
                    <div class="card-body">
                        <h6>Products</h6>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderitem as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>₹{{ number_format($item->price, 2) }}</td>
                                        <td>₹{{ number_format($item->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-end mt-3">
                            <table class="table table-borderless w-auto text-end mb-0">
                                   <tr>
                                    <td class="fw-medium pe-3">Sub Total :</td>
                                    <td class="text-success">₹{{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-medium pe-3">GST ({{ (int) $order->gst_percent }}%):</td>
                                    <td class="text-primary">₹{{ number_format($order->gst_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-medium pe-3">Discount ({{ (int) $order->discount_percent }}%) :</td>
                                    <td class="text-danger">
                                        - ₹{{ number_format($order->discount_amount, 2) }}
                                    </td>
                                </tr>
                                <tr class="border-top">
                                    <td class="fw-bold pe-3">Grand Total:</td>
                                    <td class="fw-bold ">
                                        ₹{{ number_format($order->grand_total, 2) }}
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection
