@extends('Ecommerce.Layout.index')
@section('container')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Shopping Cart</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="category.html">Cart</a>
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
                                                    <a href="{{ route('UserProductdetailsPage', $item->id) }}"><img
                                                            src="{{ asset('/storage/' . $firstImage) }}" height="50px"
                                                            width="50px" alt="{{ $item->name }}" class=""></a>
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <p>{{ $item->getproduct->name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h5>{{ $item->getproduct->price }}</h5>
                                    </td>
                                    <td>
                                        <div class="product_count">
                                            <input type="number" class="input-text qty qty-input" value="1"
                                                min="1" data-price="{{ $item->getproduct->price }}">
                                        </div>
                                    </td>

                                    <td>
                                        <h5 class="item-total">
                                            ₹{{ number_format($item->getproduct->price, 2) }}
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

                            <tr class="bottom_button">
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <h5>SubTotal</h5>
                                </td>
                                <td>
                                    <h5 id="subtotal">$0.00</h5>
                                </td>
                            </tr>
                            <tr class="shipping_area">
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <h5>Shipping</h5>
                                </td>
                                <td>
                                    <div class="shipping_box">
                                        <ul class="list">
                                            <li><a href="#">Flat Rate: $5.00</a></li>
                                            <li><a href="#">Free Shipping</a></li>
                                            <li><a href="#">Flat Rate: $10.00</a></li>
                                            <li class="active"><a href="#">Local Delivery: $2.00</a></li>
                                        </ul>
                                        <h6>Calculate Shipping <i class="fa fa-caret-down" aria-hidden="true"></i></h6>
                                        <select class="shipping_select">
                                            <option value="1">Bangladesh</option>
                                            <option value="2">India</option>
                                            <option value="4">Pakistan</option>
                                        </select>
                                        <select class="shipping_select">
                                            <option value="1">Select a State</option>
                                            <option value="2">Select a State</option>
                                            <option value="4">Select a State</option>
                                        </select>
                                        <input type="text" placeholder="Postcode/Zipcode">
                                        <a class="gray_btn" href="#">Update Details</a>
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
                                        <a class="gray_btn" href="#">Continue Shopping</a>
                                        <a class="primary-btn" href="#">Proceed to checkout</a>
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
                    let qty = parseInt($(this).val()) ||1;
                    let price = parseFloat($(this).data('price'))||0;

                    let itemtotal = qty * price;
                    subtotal += itemtotal;

                    $(this).closest('tr').find('.item-total')
                        .text('₹' + itemtotal.toFixed(2));
                });
                $('#subtotal').text('₹' + subtotal.toFixed(2));
            }
            calculate();

            $(document).on('input', '.qty-input', function() {
                calculate();
            });

        });
    </script>
@endsection
