@extends('Ecommerce.Layout.index')
@section('container')
    <style>
        .s_Product_carousel .single-prd-item {
            height: 420px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f7f7f7;
            overflow: hidden;
        }

        .product-detail-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            /* product full visible */
        }

        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }

        .rating input {
            display: none;
        }

        .rating label {
            font-size: 48px;
            color: #ddd;
            cursor: pointer;
        }

        .rating input:checked~label,
        .rating label:hover,
        .rating label:hover~label {
            color: #f8ce10;
        }
    </style>

    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Product Details </h1>
                    <nav class="d-flex align-items-center">
                        <a href="javascript:void(0)">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="javascript:void(0)">Shop<span class="lnr lnr-arrow-right"></span></a>
                        <a href="javascript:void(0)">product-details</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    @if ($product)
        @php
            $images = json_decode($product->image, true);

        @endphp

        <!--================Single Product Area =================-->
        <div class="product_image_area">
            <div class="container">
                <div class="row s_product_inner">
                    <div class="col-lg-6">
                        <div class="s_Product_carousel">
                            @if (is_array($images) && count($images) > 0)
                                @foreach ($images as $img)
                                    <div class="single-prd-item">
                                        <img class="img-fluid product-detail-img" src="{{ asset('storage/' . $img) }}"
                                            alt="{{ $product->name }}">
                                    </div>
                                @endforeach
                            @else
                                <div class="single-prd-item">
                                    <img class="img-fluid" src="{{ asset('img/no-image.png') }}" alt="No Image">
                                </div>
                            @endif
                        </div>

                    </div>
                    <div class="col-lg-5 offset-lg-1">
                        <div class="s_product_text text-capitalize">
                            <h3>{{ $product->name }}</h3>

                            <h2 class="mt-2">${{ $product->discount_value }}</h2>
                            @if ($product->discount > 0)
                                <span class="text-muted "
                                    style="text-decoration-line: line-through;margin-bottom:10px">${{ $product->price }}
                                </span>
                                &nbsp;<span class="text-success fw-bold">
                                    {{ (int) $product->discount }}% Off</span>
                            @endif

                            <ul class="list">
                                <li><a class="active" href="#"><span>Category</span> :
                                        {{ $product->getcategory->name }}</a></li>
                                @if ($product->qty == 0)
                                    <li><a href="javascript:void(0)"><span>Availibility</span> : No Stock
                                            ({{ $product->qty }})</a>
                                    </li>
                                @else
                                    <li><a href="javascript:void(0)"><span>Availibility</span> : In Stock
                                            ({{ $product->qty }}) </a>
                                    </li>
                                @endif
                            </ul>
                            <p>{{ $product->description }}</p>

                            <div class="card_area d-flex align-items-center">
                                @if ($product->qty > 0)
                                    <a href="javascript:void(0)" class=" primary-btn cart-info"
                                        data-cart-id="{{ $product->id }}">Add to Cart</a>
                                @else
                                    <a href="javascript:void(0)" class=" primary-btn cart-info disabled-cart">Out of
                                        Stock</a>
                                @endif

                                {{-- <a class="icon_btn" href="#"><i class="lnr lnr lnr-diamond"></i></a> --}}
                                <a class="icon_btn  wishlist-btn" href="javascript:void(0)"
                                    data-product-id="{{ $product->id }}"><i class="lnr lnr lnr-heart"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">

                    <img src="{{ asset('img/logo.png') }}" alt="No product" style="max-width:220px" class="mb-4">

                    <h3 class="text-danger">No Product Available</h3>

                    <p class="text-muted mb-4">
                        This product may have been removed or does not exist.
                    </p>

                    <a href="{{ route('HomePage') }}" class="primary-btn">
                        Continue Shopping
                    </a>

                </div>
            </div>
        </div>
    @endif

    <!--================End Single Product Area =================-->

    <!--================Product Description Area =================-->
    <section class="product_description_area">
        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                        aria-controls="home" aria-selected="true">Description</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                        aria-controls="contact" aria-selected="false">Comments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " id="review-tab" data-toggle="tab" href="#review" role="tab"
                        aria-controls="review" aria-selected="false">Reviews</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <p>{{ $product->description }}</p>
                </div>
                {{-- <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        <h5>Width</h5>
                                    </td>
                                    <td>
                                        <h5>128mm</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Height</h5>
                                    </td>
                                    <td>
                                        <h5>508mm</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Depth</h5>
                                    </td>
                                    <td>
                                        <h5>85mm</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Weight</h5>
                                    </td>
                                    <td>
                                        <h5>52gm</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Quality checking</h5>
                                    </td>
                                    <td>
                                        <h5>yes</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Freshness Duration</h5>
                                    </td>
                                    <td>
                                        <h5>03days</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>When packeting</h5>
                                    </td>
                                    <td>
                                        <h5>Without touch of hand</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Each Box contains</h5>
                                    </td>
                                    <td>
                                        <h5>60pcs</h5>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> --}}
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="comment_list">
                                <div class="review_item">
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="{{ asset('img/product/review-1.png') }}" alt="">
                                        </div>
                                        <div class="media-body">
                                            <h4>Blake Ruiz</h4>
                                            <h5>12th Feb, 2018 at 05:56 pm</h5>
                                            <a class="reply_btn" href="#">Reply</a>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et
                                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                        laboris nisi ut aliquip ex ea
                                        commodo</p>
                                </div>
                                <div class="review_item reply">
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="{{ asset('img/product/review-2.png') }}" alt="">
                                        </div>
                                        <div class="media-body">
                                            <h4>Blake Ruiz</h4>
                                            <h5>12th Feb, 2018 at 05:56 pm</h5>
                                            <a class="reply_btn" href="#">Reply</a>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et
                                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                        laboris nisi ut aliquip ex ea
                                        commodo</p>
                                </div>
                                <div class="review_item">
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="{{ asset('img/product/review-3.png') }}" alt="">
                                        </div>
                                        <div class="media-body">
                                            <h4>Blake Ruiz</h4>
                                            <h5>12th Feb, 2018 at 05:56 pm</h5>
                                            <a class="reply_btn" href="#">Reply</a>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et
                                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                        laboris nisi ut aliquip ex ea
                                        commodo</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="review_box">
                                <h4>Post a comment</h4>
                                <form class="row contact_form" action="contact_process.php" method="post"
                                    id="contactForm" novalidate="novalidate">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Your Full name">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Email Address">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="number" name="number"
                                                placeholder="Phone Number">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea class="form-control" name="message" id="message" rows="1" placeholder="Message"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-right">
                                        <button type="submit" value="submit" class="btn primary-btn">Submit Now</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row total_rate">
                                <div class="col-6">
                                    <div class="box_total">
                                        <h5>Overall</h5>
                                        <h4>4.0</h4>
                                        <h6>(03 Reviews)</h6>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="rating_list">
                                        <h3>Based on 3 Reviews</h3>
                                        <ul class="list">
                                            <li><a href="javascript:void(0)">5 Star <i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
                                            <li><a href="javascript:void(0)">4 Star <i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
                                            <li><a href="javascript:void(0)">3 Star <i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
                                            <li><a href="javascript:void(0)">2 Star <i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
                                            <li><a href="javascript:void(0)">1 Star <i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @if (isset($feedba  ck))
                                @foreach ($feedback as $item)
                                <div class="review_list">
                                    <div class="review_item">
                                        <div class="media">
                                            <div class="d-flex">
                                                <img src="{{ asset('img/product/review-1.png') }}" alt="">
                                            </div>
                                            <div class="media-body">
                                                <h4>{{ ucfirst($item->name) }}</h4>
                                                <div class="rating">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $item->subject)
                                                            <i class="fa fa-star "></i>
                                                        @else
                                                            {{-- <i class="fa fa-star text-muted"></i> --}}
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        <p>{{ $item->message }}</p>
                                    </div>

                                </div>
                            @endforeach
                            @else
                                 <div class="review_list">
                                    <div class="review_item">
                                        <div class="media">
                                            <div class="d-flex">
                                                <img src="{{ asset('img/product/review-1.png') }}" alt="">
                                            </div>
                                            <div class="media-body">
                                                <h4>Ajit Pawar</h4>
                                                <div class="rating">
                                                            <i class="fa fa-star "></i>
                                                            <i class="fa fa-star "></i>
                                                            <i class="fa fa-star "></i>
                                                            <i class="fa fa-star "></i>
                                                            <i class="fa fa-star "></i>
                                                </div>
                                            </div>
                                        </div>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nemo, inventore? Suscipit unde, aspernatur dolor ipsa sint ullam reiciendis ex saepe earum impedit aut fuga fugiat animi quas magni, in veniam?</p>
                                    </div>

                                </div>
                            @endif
                            

                        </div>
                        <div class="col-lg-6">
                            @if ($feedbackOrder)
                                <div class="review_box">
                                    <h4>Add a Review</h4>
                                    <p>Your Rating:</p>
                                    <ul class="list">
                                        <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                        <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                        <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                        <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                        <li><a href="javascript:void(0)"><i class="fa fa-star"></i></a></li>
                                    </ul>
                                    <p>Outstanding</p>
                                    <form id="feedback" action="" class="contact_form " novalidate="novalidate">
                                        @csrf
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="hidden" name="order_id" value="{{ $feedbackOrder->id }}">
                                                <input type="hidden" class="form-control" id="name"
                                                    value="{{ Auth::user()->name }}" name="name"
                                                    placeholder="Your Full name" onfocus="this.placeholder = ''"
                                                    onblur="this.placeholder = 'Your Full name'">
                                                <small class="text-danger error" id="name_error"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="hidden" class="form-control" id="email" name="email"
                                                    placeholder="Email Address" value="{{ Auth::user()->email }}"
                                                    onfocus="this.placeholder = ''"
                                                    onblur="this.placeholder = 'Email Address'">
                                                <small class="text-danger error" id="email_error"></small>

                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea class="form-control" name="message" id="message" rows="1" placeholder="Review"
                                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Review'"></textarea></textarea>
                                                <small class="text-danger error" id="message_error"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="rating">
                                                <input type="radio" name="subject" id="star5"
                                                    value="5"><label for="star5">★</label>
                                                <input type="radio" name="subject" id="star4"
                                                    value="4"><label for="star4">★</label>
                                                <input type="radio" name="subject" id="star3"
                                                    value="3"><label for="star3">★</label>
                                                <input type="radio" name="subject" id="star2"
                                                    value="2"><label for="star2">★</label>
                                                <input type="radio" name="subject" id="star1"
                                                    value="1"><label for="star1">★</label>
                                            </div>
                                            <small class="text-danger error" id="subject_error"></small>
                                        </div>
                                        <div class="col-md-12 text-right">
                                            <input type="submit" class="primary-btn" value="Submit Now">
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Product Description Area =================-->



    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="{{ asset('ajax.js') }}"></script>
    @if ($product)
        <script>
            $(document).ready(function() {
                $('.wishlist-btn').click(function() {
                    let productId = $(this).data('product-id');
                    let url = "{{ route('WishlistStorePage') }}";
                    let formData = new FormData();
                    formData.append('product_id', productId);

                    reusableAjaxCall(url, 'POST', formData, function(response) {
                        if (response.status == true) {
                            loadWishlistCount();
                            if (response.type === 'added') {
                                $('.wishlist-count').remove();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Added to Wishlist',
                                    text: 'Check to wishlist...',
                                    timer: 3000,
                                    showConfirmButton: false
                                });
                                // setTimeout(() => {
                                //     window.location.href = "{{ route('WishlistPage') }}";
                                // }, 3000);

                            } else if (response.type === 'exists') {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Removed from Wishlist',
                                    text: 'Product removed from your wishlist',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }

                        }
                    });
                });
                $('.cart-info').click(function() {
                    let cartId = $(this).data('cart-id');
                    let formData = new FormData();
                    formData.append('product_id', cartId);
                    let url = "{{ route('UserAddCartPage') }}";

                    reusableAjaxCall(url, 'POST', formData, function(response) {
                        if (response.status == true) {
                            loadCartCount();
                            Swal.fire({
                                icon: 'success',
                                title: 'Added to Cart',
                                text: 'Check to your Cart...',
                                timer: 3000,
                                showConfirmButton: false
                            });
                            // setTimeout(() => {
                            //     window.location.href = "{{ route('UserCartPage') }}";
                            // }, 3000);
                        }
                    });
                });
                $('#feedback').submit(function(e) {
                    e.preventDefault();
                    var data = $('#feedback')[0];
                    var formData = new FormData(data);
                    $('.error').text('');
                    let url = "{{ route('UserFeedbackPage') }}";
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
                                    title: response.message || "Feedback Send Successfully"
                                });
                                $('#feedback').closest('.card').fadeOut();
                                setTimeout(function() {
                                    window.location.href = "{{ route('UserConfirmPage') }}";
                                }, 2000);

                            } else {
                                Toast.fire({
                                    icon: "error",
                                    title: response.message || "Feedback not Sent"
                                });
                            }
                            $('#feedback')[0].reset();
                        },
                        function(error) {
                            console.log('error', error);
                        });
                });
            });
        </script>
    @endif
@endsection
