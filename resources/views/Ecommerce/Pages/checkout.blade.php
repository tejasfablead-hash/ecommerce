@extends('Ecommerce.Layout.index')
@section('container')
    <style>
        .payment-buttons {
            display: flex;
            flex-direction: column;
            gap: 12px;
            /* 👈 yahin se spacing control */
        }
    </style> <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Checkout</h1>
                    <nav class="d-flex align-items-center"> <a href="javascript:void(0)">Home<span
                                class="lnr lnr-arrow-right"></span></a> <a href="javascript:void(0)">Checkout</a> </nav>
                </div>
            </div>
        </div>
    </section> <!-- End Banner Area --> <!--================Checkout Area =================-->
    <section class="checkout_area section_gap">
        <div class="container">
            <div class="billing_details">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row align-items-center mb-3">
                            <div class="col-md-8">
                                <h2 class="mb-3" style="border-bottom-style: none;">Billing Details</h2>
                            </div>
                            <div class="col-md-4 text-end"> <a href="javascript:void(0)" id="continueShopping"
                                    class="gray_btn primary-btn" style="background:#7c8e93;color:white"> Continue Shopping
                                </a> </div>
                        </div>
                        <hr>
                        <form class="row contact_form" id="orderform"> @csrf <input type="hidden" class="form-control"
                                id="id" name="userid" value="{{ Auth::user()->id }}"> <small
                                class="text-danger error" id="id_error"></small>
                            <div class="col-md-6 form-group p_star"> <input type="hidden" class="form-control"
                                    id="first" name="firstname" value="{{ Auth::user()->name }}"
                                    placeholder="First name"> <small class="text-danger error" id="firstname_error"></small>
                            </div>
                            <div class="col-md-6 form-group p_star"> <input type="hidden" class="form-control"
                                    id="number" name="phone" value="{{ Auth::user()->phone }}"
                                    placeholder="Phone number"> <small class="text-danger error" id="phone_error"></small>
                            </div>
                            <div class="col-md-6 form-group p_star"> <input type="hidden" class="form-control"
                                    placeholder="Email Address" value="{{ Auth::user()->email }}" name="email"> <small
                                    class="text-danger error" id="email_error"></small> </div>
                            <div class="col-md-12 form-group p_star"> Address : <input type="text" class="form-control"
                                    id="city" name="address" placeholder="Address/Town/City"> <small
                                    class="text-danger error" id="address_error"></small> </div>

                            <div class="col-md-12 form-group"> Pincode : <input type="text" class="form-control"
                                    id="zip" name="postcode" placeholder="Postcode/ZIP"> <small
                                    class="text-danger error" id="postcode_error"></small> </div>
                    </div>
                    <div class="col-lg-4 text-capitalize">
                        <div class="order_box">
                            <h2>Your Order</h2>
                            @if (isset($cart) && $cart->count() > 0)
                                <table class="table table-borderless">
                                    <thead>
                                        <tr style="color:#3f3e3e;">
                                            <th>Product</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($cart as $item)
                                            <tr>
                                                <td style="max-width:150px;"> {{ Str::limit($item->getproduct->name, 12) }}
                                                </td>
                                                <td class="text-center"> {{ $item->qty }} </td>
                                                <td class="text-end"> ₹{{ number_format($item->qty * $item->price, 2) }}
                                                </td>
                                        </tr> @empty @php session([ 'subtotal' => 0, 'gstvalue' => 0, 'discountvalue' => 0, 'discountprice' => 0, 'grandtotal' => 0, ]); @endphp <tr>
                                                <td colspan="3" class="text-center py-3 text-muted"> 🛒 Your cart is
                                                    empty </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <hr>
                                <table class="table table-borderless ">
                                    <tbody>
                                        <tr>
                                            <td>Sub Total</td>
                                            <td></td>
                                            <td class="text-end">₹{{ session('subtotal') ?? 0 }}</td>
                                        </tr>
                                        <tr>
                                            <td>GST (18%)</td>
                                            <td></td>
                                            <td class="text-end">₹{{ session('gstvalue') ?? 0 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Discount (%)</td>
                                            <td></td>
                                            @if (session('discountvalue') > 0)
                                                <td class="text-end">{{ session('discountvalue') ?? 0 }}%</td>
                                            @else
                                                <td class="text-end">-</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>Discount Price</td>
                                            <td></td>
                                            @if (session('discountprice') > 0)
                                                <td class="text-end">₹{{ session('discountprice') ?? 0 }}</td>
                                            @else
                                                <td class="text-end">-</td>
                                            @endif
                                        </tr>
                                        <tr class="fw-bold">
                                            <td style="color:#050505;">Total</td>
                                            <td></td>
                                            <td style="color:#0c0c0c;" class="text-end">₹{{ session('grandtotal') ?? 0 }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="payment_item active">
                                    <p id="billingdetails" class="d-none mt-2 text-danger"></p>
                                </div>
                                {{-- <div class="creat_account"> <input type="checkbox" id="f-option4" name="selector">
                                    <label for="f-option4">I’ve read and accept the </label>
                                    <p style="color: rgb(243, 81, 81)">terms & conditions</p>
                                </div> --}}
                                <div class="creat_account payment-buttons">
                                    <button type="submit" class="primary-btn w-100 mb-2 border-0" id="placeOrderBtn">
                                        Confirm Your Order
                                    </button>

                                    <button class="primary-btn w-100 d-none border-0" id="payWithCOD">
                                        Cash on Delivery
                                    </button>
                                    <!-- Payment Buttons -->
                                    <button type="button" class="primary-btn w-100  d-none  border-0"
                                        id="payWithPaypal">
                                        Pay with PayPal
                                    </button>

                                    <button type="button" class="primary-btn w-100 d-none  border-0"
                                        id="payWithRazorpay">
                                        Pay with Razorpay
                                    </button>
                                    <button type="button" class="primary-btn w-100 mb-2 d-none border-0"
                                        id="payWithStripe">
                                        Pay with Card (Stripe)
                                    </button>


                                    <div id="paypal-button-container" class="mt-2 d-none"></div>
                                </div>
                            @else
                                <tr>
                                    <p class="text-danger text-center mt-4"> 🛒 Your cart is empty </p> <a
                                        href="{{ route('UserProductPage') }}" class="primary-btn mt-4"> Please Add
                                        Product
                                    </a>
                                </tr>
                            @endif
                        </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>
    <script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency=USD"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script src="{{ asset('ajax.js') }}"></script>

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Payment Cancelled',
                text: "{{ session('error') }}"
            });
        </script>
    @endif
    <script>
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('stripe') === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Payment Successful',
                    text: 'Your Stripe payment has been completed!',
                    timer: 2500,
                    showConfirmButton: false
                });

                setTimeout(() => {
                    window.location.href = "{{ route('UserConfirmPage') }}";
                }, 2500);
            }
        });
    </script>
<script>
    $(document).ready(function() {
        let paypalRendered = false;
        $('#orderform').submit(function(e) {
            e.preventDefault();
            var data = $('#orderform')[0];
            var formData = new FormData(data);
            $('.error').text('');
            $('#billingdetails').addClass('d-none').text('');
            var url = "{{ route('UserOrderPage') }}";
            reusableAjaxCall(url, 'POST', formData, function(response) {
                console.log('response', response);
                if (response.status === true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Order Confirmed to Check Payment',
                        text: 'Choose payment method',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    $('#placeOrderBtn').hide();
                    $('#payWithCOD,#payWithPaypal,#payWithRazorpay,#payWithStripe')
                        .removeClass('d-none');

                    window.ORDER_ID = response.order_id;
                    $('#orderform')[0].reset();
                }
            }, function(xhr) {
                let res = xhr.responseJSON;
                if (res && res.message) {
                    $('#billingdetails').removeClass('d-none').hide().html(res.message).fadeIn(
                        300);
                }
            });
        });
        $('#payWithCOD').on('click', function() {
            let formData = new FormData();
            formData.append('order_id', window.ORDER_ID);
            formData.append('payment_method', 'cod');
            var url = "{{ route('CODOrderPlace') }}";
            reusableAjaxCall(url, 'POST', formData, function(res) {
                if (res.status === true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Order Confirmed with COD',
                        timer: 3000,
                        showConfirmButton: false
                    });
                    setTimeout(() => {
                        window.location.href = "{{ route('UserConfirmPage') }}";
                    }, 2000);
                }
            });
        });

        $('#payWithPaypal').on('click', function() {
            $('#paypal-button-container').removeClass('d-none');

            if (!paypalRendered) {
                renderPaypal();
                paypalRendered = true;
            }
        });

        $('#payWithStripe').on('click', function() {

            if (!window.ORDER_ID) {
                Swal.fire({
                    icon: 'error',
                    title: 'Order not created',
                    text: 'Please confirm order first'
                });
                return;
            }

            var formData = new FormData();
            formData.append('order_id', window.ORDER_ID);

            let url = "{{ route('stripe.create') }}";

            reusableAjaxCall(url, 'POST', formData, function(res) {
                console.log('Stripe Create Response:', res);
                window.location.href = res.checkout_url;
            });
        });


        $('#payWithRazorpay').on('click', function() {

            var formData = new FormData();
            formData.append('order_id', window.ORDER_ID);
            var url = "{{ route('Razorpayorder') }}";
            reusableAjaxCall(url, 'POST', formData, function(res) {
                let options = {
                    "key": "{{ config('services.razorpay.key') }}",
                    "amount": res.amount,
                    "currency": "INR",
                    "name": "Ecommerce",
                    "description": "Order Payment",
                    "order_id": res.razorpay_order_id,
                    "handler": function(response) {

                        var formData = new FormData();
                        formData.append('order_id', window.ORDER_ID);
                        formData.append('razorpay_payment_id', response
                            .razorpay_payment_id);
                        formData.append('razorpay_order_id', response
                            .razorpay_order_id);
                        formData.append('payment_method', 'razorpay');
                        var url = "{{ route('Razorpaysuccess') }}";
                        reusableAjaxCall(url, 'POST', formData, function(res) {
                            if (res.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Payment Successful',
                                    timer: 2500,
                                    showConfirmButton: false
                                });

                                setTimeout(() => {
                                    window.location
                                        .href =
                                        "{{ route('UserConfirmPage') }}";
                                }, 2500);
                            }
                        });
                    }
                };

                let rzp = new Razorpay(options);
                rzp.open();
            });
        });

        function renderPaypal() {
            paypal.Buttons({
                createOrder: (data, actions) => {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: "{{ session('grandtotal') }}"
                            }
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        console.log(details);
                        let transactionId = details.purchase_units[0].payments.captures[0]
                            .id;

                        var formData = new FormData();
                        formData.append('paypal_order_id', data.orderID);
                        formData.append('payment_status', details.status);
                        formData.append('transaction_id', transactionId);
                        formData.append('payment_method', 'paypal');
                        var url = "{{ route('PaypalSuccessPage') }}";
                        reusableAjaxCall(url, 'POST', formData, function(res) {
                            if (res.status === true) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Payment Successfull',
                                    text: 'Please checked the OrderDetails...',
                                    timer: 3000,
                                    showConfirmButton: false
                                });
                                setTimeout(() => {
                                    window.location.href =
                                        "{{ route('UserConfirmPage') }}";
                                }, 3000);
                            }
                        });
                    });
                },
                onCancel: () => {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Payment Cancelled',
                        text: 'You can try again'
                    });
                },
                onError: () => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Payment Failed',
                        text: 'Please try again later'
                    });
                }
            }).render('#paypal-button-container');
        }

        $('#continueShopping').on('click', function() {
            window.location.href = "{{ route('UserContinueShopping') }}";
        });
    });
</script> @endsection
