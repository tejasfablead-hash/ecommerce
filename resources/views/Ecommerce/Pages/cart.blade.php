@extends('Ecommerce.Layout.index')
@section('container')

    <style>
        .qty-circle-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Circle buttons */
        .qty-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid #ddd;
            background: #fff;
            font-size: 18px;
            font-weight: 600;
            line-height: 1;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qty-circle:hover {
            background: #f5f5f5;
        }

        /* Middle input box */
        .qty-box {
            width: 40px;
            height: 32px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
            font-size: 14px;
            font-weight: 500;
        }

        /* Remove arrows */
        .qty-box::-webkit-inner-spin-button,
        .qty-box::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .qty-box {
            -moz-appearance: textfield;
        }
    </style>


    <!-- Start Banner Area -->

    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Shopping Cart</h1>
                    <nav class="d-flex align-items-center">
                        <a href="javascript:void(0)">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="javascript:void(0)">Cart</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-capitalize">
                            @php $grandTotal = 0; @endphp
                            @if (isset($cartItems) && $cartItems->count() > 0)
                                @forelse ($cartItems as $item)
                                    <tr>
                                        <td>
                                            <div class="media">
                                                <div class="d-flex">
                                                    @php
                                                        $images = json_decode($item->getproduct->image, true);
                                                    @endphp
                                                    @if (is_array($images) && count($images) > 0)
                                                        @php
                                                            $firstImage = $images[0];
                                                        @endphp
                                                        <a
                                                            href="{{ route('UserProductdetailsPage', $item->getproduct->id) }}"><img
                                                                src="{{ asset('/storage/' . $firstImage) }}" height="50px"
                                                                width="50px" alt="{{ $item->name }}" class=""></a>
                                                    @endif
                                                </div>
                                                <div class="media-body">
                                                    <h5 style="color: black">{{ $item->getproduct->name }}</h5>
                                                    @if ($item->getproduct->discount > 0)
                                                        <p class="text-success">{{ (int) $item->getproduct->discount }}% Off
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <h5>₹{{ $item->getproduct->discount_value }}</h5>
                                            @if ($item->getproduct->discount > 0)
                                                <p style="text-decoration-line: line-through;">
                                                    ₹{{ $item->getproduct->price }}
                                                </p>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="qty-circle-wrapper">
                                                <button type="button" class="qty-circle qty-minus">−</button>

                                                <input type="number" class="qty-box qty-input" value="{{ $item->qty }}"
                                                    min="1" data-old="{{ $item->qty }}"
                                                    data-cart-id="{{ $item->id }}"
                                                    data-price="{{ $item->getproduct->discount_value }}">

                                                <button type="button" class="qty-circle qty-plus">+</button>
                                            </div>
                                        </td>

                                        <td>
                                            <h5 class="item-total">
                                                ₹{{ number_format($item->getproduct->discount_value, 2) }}
                                            </h5>
                                        </td>
                                        <td>
                                            <a href="" class="remove-cart remove-cart-item"
                                                data-id="{{ $item->id }}">
                                                <i class="fa fa-trash-o" style="font-size:20px;color:red"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <h4>Your cart is empty 🛒</h4>
                                            <a href="{{ route('UserProductPage') }}" class="primary-btn mt-3">
                                                Continue Shopping
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            @else
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <h4>Your cart is empty 🛒</h4>
                                        <a href="{{ route('UserProductPage') }}" class="primary-btn mt-3">
                                            Continue Shopping
                                        </a>
                                    </td>
                                </tr>
                            @endif

                            <tr class="bottom_button">
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <h5>SubTotal :</h5>
                                </td>
                                <td>
                                    <h5 id="subtotal"></h5>
                                    <input type="hidden" id="subtotalInput">

                                </td>

                            </tr>

                            <tr>
                                <td colspan="5">
                                    <div style="float:right; width:320px;">
                                        <div class="d-flex align-items-center  mb-2 justify-content-between">
                                            <h5 class="mb-0">GST (18%) :</h5>

                                            <div class="confirm-switch">
                                                <input type="checkbox" id="confirm-switch" checked>
                                                <label for="confirm-switch"></label>
                                            </div>

                                            <h5 class="mb-0 ms-auto" id="gst"></h5>
                                            <input type="hidden" id="gstInput">

                                        </div>

                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <h5 class="mt-2">Discount (%) :</h5>
                                            <input type="number" id="discount" value="" min="0"
                                                class="form-control text-end" style="width:100px;">
                                            <input type="hidden" id="discountInput">

                                        </div>
                                        <div class="d-flex justify-content-between mt-2 mb-2">
                                            <h5>Discount Price :</h5>
                                            <h5 id="discountprice"></h5>
                                            <input type="hidden" id="discountpriceInput">
                                        </div>



                                        <hr>

                                        <div class="d-flex justify-content-between">
                                            <h5><strong>Grand Total :</strong></h5>
                                            <h5 id="grand-total"><strong></strong></h5>
                                            <input type="hidden" id="grandTotalInput">
                                        </div>

                                    </div>
                                </td>
                            </tr>


                            <tr class="out_button_area">
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <div class="checkout_btn_inner d-flex align-items-center">
                                        <a class="gray_btn primary-btn  " href="{{ route('UserProductPage') }}"
                                            style="background:#7c8e93;color: white">Continue Shopping</a>
                                        <a class="primary-btn" id="checkoutBtn" href="#">Proceed to checkout</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('ajax.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.qty-plus', function() {
                let input = $(this).closest('.qty-circle-wrapper').find('.qty-input');
                let currentQty = parseInt(input.val()) || 1;
                input.val(currentQty + 1).trigger('change');
            });

            $(document).on('click', '.qty-minus', function() {
                let input = $(this).closest('.qty-circle-wrapper').find('.qty-input');
                let currentQty = parseInt(input.val()) || 1;

                if (currentQty > 1) {
                    input.val(currentQty - 1).trigger('change');
                }
            });

            $(document).on('click', '.remove-cart', function(e) {

                e.preventDefault();
                let id = $(this).data('id');
                let row = $(this).closest('tr');

                let url = '/user/cart-delete/' + id;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This item will be removed from your cart!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, remove it',
                }).then((result) => {

                    if (result.isConfirmed) {

                        reusableAjaxCall(url, 'GET', {}, function(response) {
                            if (response.status === true) {
                                row.fadeOut(300, function() {
                                    $(this).remove();
                                    calculate();
                                    loadCartCount();
                                    if ($('tbody tr').length === 0) {
                                        $('tbody').html(`
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <h4>Your cart is empty 🛒</h4>
                                        <a href="{{ route('UserProductPage') }}" class="primary-btn mt-3">
                                            Continue Shopping
                                        </a>
                                    </td>
                                </tr>
                            `);
                                    }
                                });

                                Swal.fire('Removed!', 'Item removed successfully.',
                                    'success');

                            } else {
                                Swal.fire('Error!', response.message, 'error');
                            }

                        }, function(error) {
                            Swal.fire(
                                'Error!',
                                'Server error. Please try again.',
                                'error'
                            );
                        });
                    }
                });
            });

            function calculate() {
                let subtotal = 0;
                $('.qty-input').each(function() {
                    let qty = parseInt($(this).val()) || 1;
                    let price = parseFloat($(this).data('price')) || 0;

                    let itemtotal = qty * price;
                    subtotal += itemtotal;

                    $(this).closest('tr').find('.item-total')
                        .text('₹' + itemtotal.toFixed(2));
                });
                $('#subtotal').text('₹' + subtotal.toFixed(2));

                let discount = parseFloat($('#discount').val()) || 0;
                let discountamount = (subtotal * discount) / 100;

                $('#discountprice').text('₹' + discountamount.toFixed(2));

                let afterdiscount = subtotal - discountamount;

                let gst = 0;
                if ($('#confirm-switch').is(':checked')) {
                    gst = (afterdiscount * 18) / 100;
                    $('#gst').text('₹' + gst.toFixed(2));
                } else {
                    $('#gst').text('₹0.00');
                }

                let grandTotal = afterdiscount + gst;
                $('#grand-total').text('₹' + grandTotal.toFixed(2));
                $('#grandTotalInput').val(grandTotal.toFixed(2));
                $('#discountpriceInput').val(discountamount.toFixed(2));
                $('#gstInput').val(gst.toFixed(2));
                $('#discountInput').val(discount);
                $('#subtotalInput').val(subtotal.toFixed(2));

            }

            calculate();

            $(document).on('change', '.qty-input', function() {

                let input = $(this);
                let qty = parseInt(input.val()) || 1;
                let oldQty = input.data('old');
                let cartId = input.data('cart-id');

                if (qty < 1) {
                    input.val(oldQty);
                    return;
                }

                let formData = new FormData();
                formData.append('qty', qty);
                formData.append('cartId', cartId);

                reusableAjaxCall("{{ route('UserCartUpdatePage') }}", 'POST', formData,
                    function(response) {

                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 2000
                        });

                        if (response.status === true) {
                            input.data('old', qty);
                            calculate();
                            loadCartCount();

                            Toast.fire({
                                icon: "success",
                                title: response.message || "Quantity updated"
                            });

                        } else {
                            input.val(oldQty);
                            calculate();

                            Toast.fire({
                                icon: "error",
                                title: response.message || "Stock not available"
                            });
                        }
                    }
                );
            });
            $(document).on('input', '#discount', function() {
                calculate();
            });
            $(document).on('change', '#confirm-switch', function() {
                calculate();
            });

            $('#checkoutBtn').on('click', function(e) {
                let cartItemCount = $('.qty-input').length;

                if (cartItemCount === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Cart is empty',
                        text: 'Please add at least one product to proceed checkout.',
                        confirmButtonColor: '#3085d6'
                    });
                    return false;
                }
                e.preventDefault();
                let grandTotal = $('#grandTotalInput').val();
                let discountprice = $('#discountpriceInput').val();
                let gstvalue = $('#gstInput').val();
                let discountvalue = $('#discountInput').val();
                let subtotal = $('#subtotalInput').val();


                var formData = new FormData();
                formData.append('grandTotal', grandTotal);
                formData.append('discountprice', discountprice);
                formData.append('gstvalue', gstvalue);
                formData.append('discountvalue', discountvalue);
                formData.append('subtotal', subtotal);

                var url = "{{ route('UserCheckoutTotalPage') }}";
                reusableAjaxCall(url, 'POST', formData, function(response) {
                    window.location.href = "{{ route('UserCheckoutPage') }}";
                });

            });


        });
    </script>
@endsection
