@extends('Ecommerce.Layout.index')
@section('container')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Checkout</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="single-product.html">Checkout</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Checkout Area =================-->
    <section class="checkout_area section_gap">
        <div class="container">

            <div class="billing_details">
                <div class="row">
                    <div class="col-lg-8">
                        <h3>Billing Details</h3>
                        <form class="row contact_form" id="orderform">
                            @csrf
                            <input type="hidden" class="form-control" id="id" name="userid"
                                value="{{ Auth::user()->id }}">
                            <small class="text-danger error" id="id_error"></small>

                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control" id="first" name="firstname"
                                    placeholder="First name">
                                <small class="text-danger error" id="firstname_error"></small>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control" id="last" name="lastname"
                                    placeholder="Last name">
                                <small class="text-danger error" id="lastname_error"></small>
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <input type="text" class="form-control" id="number" name="phone"
                                    placeholder="Phone number">
                                <small class="text-danger error" id="phone_error"></small>

                            </div>
                            <div class="col-md-6 form-group p_star">
                                <input type="email" class="form-control" placeholder="Email Address" name="email">
                                <small class="text-danger error" id="email_error"></small>
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <input type="text" class="form-control" id="city" name="address"
                                    placeholder="Address/Town/City">
                                <small class="text-danger error" id="address_error"></small>
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" id="zip" name="postcode"
                                    placeholder="Postcode/ZIP">
                                <small class="text-danger error" id="postcode_error"></small>

                            </div>
                            <a class="gray_btn primary-btn  " href="{{ route('UserContinueShopping') }}"
                                style="background:#7c8e93;color: white">Continue Shopping</a>
                    </div>
                    <div class="col-lg-4 text-capitalize">
                        <div class="order_box">
                            <h2>Your Order</h2>
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
                                            <td style="max-width:150px;">
                                                {{ Str::limit($item->getproduct->name, 12) }}
                                            </td>

                                            <td class="text-center">
                                                {{ $item->qty }}
                                            </td>

                                            <td class="text-end">
                                                ₹{{ number_format($item->qty * $item->price, 2) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-3 text-muted">
                                                🛒 Your cart is empty
                                            </td>
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
                                        <td class="text-end">{{ session('discountvalue') ?? 0 }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Discount Price</td>
                                        <td></td>
                                        <td class="text-end">₹{{ session('discountprice') ?? 0 }}</td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td style="color:#050505;">Total</td>
                                        <td></td>
                                        <td style="color:#0c0c0c;" class="text-end">₹{{ session('grandtotal') ?? 0 }}</td>
                                    </tr>
                                </tbody>
                            </table>


                            <div class="payment_item active">
                                <div class="radion_btn">
                                    <input type="radio" id="f-option6" name="selector">
                                    <label for="f-option6">Paypal </label>
                                    <img src="{{ asset('img/product/card.jpg') }}" alt="">
                                    <div class="check"></div>
                                </div>
                                <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal
                                    account.</p>
                                <p id="billingdetails" class="d-none mt-2 text-danger"></p>
                            </div>
                            <div class="creat_account">
                                <input type="checkbox" id="f-option4" name="selector">
                                <label for="f-option4">I’ve read and accept the </label>
                                <p style="color: rgb(243, 81, 81)">terms & conditions</p>
                            </div>
                            <div class="creat_account">
                                <input type="submit" class="primary-btn w-100" style="border:none" name="submit"
                                    value="Proceed to Paypal">
                            </div>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>
    <script src="{{ asset('ajax.js') }}"></script>
    <script>
        $(document).ready(function() {

                    $('#orderform').submit(function(e) {
                            e.preventDefault();
                            var data = $('#orderform')[0];
                            var formData = new FormData(data);
                            $('.error').text('');
                            var url = "{{ route('UserOrderPage') }}";
                            reusableAjaxCall(url, 'POST', formData, function(response) {
                                    console.log('response', response);
                                    const Toast = Swal.mixin({
                                        toast: true,
                                        position: "top-end",
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true,
                                        didOpen: (toast) => {
                                            toast.onmouseenter = Swal.stopTimer;
                                            toast.onmouseleave = Swal.resumeTimer;
                                        }
                                    });
                                    if (response.status === true) {
                                        Toast.fire({
                                            icon: "success",
                                            title: response.message || "Order Completed successfully"
                                        });
                                        setTimeout(function() {
                                            window.location.href = "{{ route('UserCheckoutPage') }}";
                                        }, 2000);

                                    } else {
                                        Toast.fire({
                                            icon: "error",
                                            title: response.message || "Something went wrong"
                                        });
                                        $('#orderform')[0].reset();
                                    }
                                },
                                function(xhr) {
                                    let res = xhr.responseJSON;
                                    let html = '';
                                    
                                    $('#billingdetails')
                                        .removeClass('d-none')
                                        .html(res.message);
                                });

                            });
                    });
    </script>
@endsection
