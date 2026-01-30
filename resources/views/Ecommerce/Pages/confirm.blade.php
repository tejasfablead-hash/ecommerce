@extends('Ecommerce.Layout.index')
@section('container')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Confirmation</h1>
                    <nav class="d-flex align-items-center">
                        <a href="">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="">Confirmation</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Order Details Area =================-->
    <section class="order_details section_gap">
        <div class="container">
            {{-- <h3 class="title_confirmation">Thank you. Your order has been received.</h3> --}}
            @if (isset($order) && $order)
                <h3 class="title_confirmation text-success d-none">
                    @if ($order->order_status === 'confirmed')
                        Thank you. Your payment was successful and order has been placed.
                    @else
                    @endif

                </h3>
                <h4>Order Info</h4>
                <hr>

                <div class="row order_d_inner">
                    <div class="col-lg-4">
                        <div class="details_item ">
                            <ul class="list text-capitalize">
                                <li><a href="#"><span>Transaction Id</span> : {{ $order->transactionId }}</a></li>
                                <li><a href="#"><span>Order number</span> : {{ $order->order_number }}</a></li>
                                <li><a href="#"><span>Date</span> : {{ $order->updated_at->format('d M Y') }}</a></li>
                                <li><a href="#"><span>Total</span> : ₹{{ $order->grand_total }}</a></li>

                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="details_item">
                            <ul class="list ">
                                <li class="text-capitalize"><a href="#"><span>Name</span> :
                                        {{ $order->customer_name }}</a></li>
                                <li><a href="#"><span>Email</span> : {{ $order->email }}</a></li>
                                <li><a href="#"><span>Phone</span> : {{ $order->phone }}</a></li>
                                <li class="text-capitalize"><a href="#"><span>Address</span> :
                                        {{ $order->address }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="details_item">
                            <ul class="list text-capitalize">
                                <li><a href="#"><span>Payment method</span> : {{ $order->payment_method }}</a></li>
                                <li><a href="#"><span>Order Status</span> : {{ $order->order_status }}</a></li>
                                <li><a href="#"><span>Postcode </span> : {{ $order->pincode }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="order_details_table">
                    <h2>Order Details</h2>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderitem as $item)
                                    <tr>
                                        <td>
                                            <p>{{ $item->product->name }}</p>
                                        </td>
                                        <td>
                                            <h5>&nbsp;&nbsp;&nbsp;&nbsp;{{ $item->qty }}</h5>
                                        </td>
                                        <td>
                                            <p>₹{{ $item->price }}</p>
                                        </td>
                                        <td>
                                            <p>₹{{ $item->total }}</p>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                    <td>
                                        <h4>Subtotal</h4>
                                    </td>
                                    <td>
                                        <p>₹{{ $order->subtotal }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5></h5>
                                    </td>
                                    <td>
                                        <h5></h5>
                                    </td>
                                    <td>
                                        <h4>GST ({{ (int) $order->gst_percent }})%</h4>
                                    </td>
                                    <td>
                                        <p>₹{{ $order->gst_amount }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5></h5>
                                    </td>
                                    <td>
                                        <h5></h5>
                                    </td>
                                    <td>
                                        <h4>Discount ({{ (int) $order->discount_percent }})%</h4>
                                    </td>
                                    <td>
                                        <p>₹{{ $order->discount_amount }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5></h5>
                                    </td>
                                    <td>
                                        <h5></h5>
                                    </td>
                                    <td>
                                        <h4>Total</h4>
                                    </td>

                                    <td>
                                        <p>₹{{ $order->grand_total }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <h2 class="text-danger"> Order Not Confirmed</h2>

                    <p class="mt-3">
                        We could not find any confirmed order.<br>
                        This may happen if payment was cancelled or failed.
                    </p>

                    <a href="{{ route('UserProductPage') }}" class=" primary-btn mt-3">
                        Try  Order Again
                    </a>
                    <a href="{{ route('HomePage') }}" class=" primary-btn mt-3" style="background:#7c8e93;color:white">
                        Go to Home
                    </a>

                </div>
            @endif
        </div>
    </section>
    <!--================End Order Details Area =================-->
@endsection
