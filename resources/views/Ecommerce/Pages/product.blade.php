@extends('Ecommerce.Layout.index')
@section('container')
    <style>
        /* Fix product image size */
        .single-product .product-img-wrapper {
            width: 100%;
            height: 240px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f7f7f7;
            overflow: hidden;
        }

        .single-product .product-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .exclusive-img-box {
            width: 100%;
            height: 425px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .exclusive-img-box img {
            max-width: 100%;
            max-height: 100%;
        }

        .out-of-stock {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #dc3545;
            color: #fff;
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 4px;
            z-index: 9;
            text-transform: uppercase;
            font-weight: 600;
        }
    </style>
    <!-- start banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Shop Product </h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="#">Shop<span class="lnr lnr-arrow-right"></span></a>
                        <a href="category.html">Fashion Product</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End banner Area -->

    @php
        $saleProducts = $product->take(2);
        $latestProducts = $product->take(8);
        $comingProducts = $product->skip(8);
    @endphp

    <!-- start product Area -->
    <section class="owl-carousel active-product-area section_gap">
        <!-- single product slide -->
        <div class="single-product-slider">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 text-center">
                        <div class="section-title">
                            <h1>Latest Products</h1>
                            <p>A well-designed product detail page is essential to your marketing strategy since it is the
                                page that leads directly to a sale.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- single product -->
                    @forelse  ($latestProducts as $item)
                        <div class="col-lg-3 col-md-6">
                            <div class="single-product ">
                                <div class="product-img-wrapper">
                                    @if ($item->qty == 0)
                                        <span class="out-of-stock">Out of Stock</span>
                                    @endif
                                    @php
                                        $images = json_decode($item->image, true);
                                    @endphp
                                    @if (is_array($images) && count($images) > 0)
                                        @php
                                            $firstImage = $images[0];
                                        @endphp
                                        <a href="{{ route('UserProductdetailsPage', $item->id) }}"><img
                                                src="{{ asset('/storage/' . $firstImage) }}" alt="{{ $item->name }}"
                                                class="img-fluid"></a>
                                    @endif
                                </div>

                                <div class="product-details mt-2">
                                    <h6>{{ $item->name }}</h6>
                                    <div class="price">
                                        <h6>${{ $item->price }}</h6>
                                        {{-- <h6 class="l-through">$210.00</h6> --}}
                                    </div>
                                    <div class="prd-bottom">
                                        @if ($item->qty > 0)
                                            <a href="javascript:void(0)" class="social-info cart-info"
                                                data-cart-id="{{ $item->id }}">
                                                <span class="ti-bag"></span>
                                                <p class="hover-text">add to bag</p>
                                            </a>
                                        @else
                                            <a href="javascript:void(0)" class="social-info disabled-cart">
                                                <span class="ti-bag"></span>
                                                <p class="hover-text">out of stock</p>
                                            </a>
                                        @endif

                                        <a href="javascript:void(0)" class="social-info wishlist-btn"
                                            data-product-id="{{ $item->id }}">
                                            <span class="lnr lnr-heart"></span>
                                            <p class="hover-text">Wishlist</p>
                                        </a>
                                        <a href="{{ route('UserProductdetailsPage', $item->id) }}" class="social-info">
                                            <span class="lnr lnr-move"></span>
                                            <p class="hover-text">view more</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12">
                            <div class="no-product-box text-center">
                                <h4>No Products Available</h4>
                                <p class="text-muted">
                                    We’re working on adding new items.
                                    Please check back soon!
                                </p>
                                <a href="{{ route('UserCategoryPage') }}" class="primary-btn mt-4">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
        <!-- single product slide -->
        <div class="single-product-slider">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 text-center">
                        <div class="section-title">
                            <h1>Coming Soon Products</h1>
                            <p>A well-designed product detail page is essential to your marketing strategy since it is the
                                page that leads directly to a sale..</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- single product -->
                    @forelse  ($comingProducts as $item)
                        <div class="col-lg-3 col-md-6">
                            <div class="single-product ">
                                <div class="product-img-wrapper">
                                    @if ($item->qty == 0)
                                        <span class="out-of-stock">Out of Stock</span>
                                    @endif
                                    @php
                                        $images = json_decode($item->image, true);
                                    @endphp
                                    @if (is_array($images) && count($images) > 0)
                                        @php
                                            $firstImage = $images[0];
                                        @endphp
                                        <a href="{{ route('UserProductdetailsPage', $item->id) }}"><img
                                                src="{{ asset('/storage/' . $firstImage) }}" alt="{{ $item->name }}"
                                                class="img-fluid"></a>
                                    @endif
                                </div>
                                <div class="product-details mt-2">
                                    <h6>{{ $item->name }}</h6>
                                    <div class="price">
                                        <h6>${{ $item->price }}</h6>
                                        {{-- <h6 class="l-through">$210.00</h6> --}}
                                    </div>
                                    <div class="prd-bottom">
                                        @if ($item->qty > 0)
                                            <a href="javascript:void(0)" class="social-info cart-info"
                                                data-cart-id="{{ $item->id }}">
                                                <span class="ti-bag"></span>
                                                <p class="hover-text">add to bag</p>
                                            </a>
                                        @else
                                            <a href="javascript:void(0)" class="social-info disabled-cart">
                                                <span class="ti-bag"></span>
                                                <p class="hover-text">out of stock</p>
                                            </a>
                                        @endif

                                        <a href="javascript:void(0)" class="social-info wishlist-btn"
                                            data-product-id="{{ $item->id }}">
                                            <span class="lnr lnr-heart"></span>
                                            <p class="hover-text">Wishlist</p>
                                        </a>
                                        <a href="{{ route('UserProductdetailsPage', $item->id) }}" class="social-info">
                                            <span class="lnr lnr-move"></span>
                                            <p class="hover-text">view more</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="no-product-box text-center">
                                <h4>No Products Available</h4>
                                <p class="text-muted">
                                    We’re working on adding new items.
                                    Please check back soon!
                                </p>
                                <a href="{{ route('HomePage') }}" class="primary-btn mt-4">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    <!-- end product Area -->

    <!-- Start exclusive deal Area -->
    <section class="exclusive-deal-area">
        <div class="container-fluid">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6 no-padding exclusive-left">
                    <div class="row clock_sec clockdiv" id="clockdiv">
                        <div class="col-lg-12">

                            <h1>Exclusive Hot Deal Ends Soon!</h1>
                            <p>Who are in extremely love with eco friendly system.</p>
                        </div>
                        <div class="col-lg-12">
                            <div class="row clock-wrap">
                                <div class="col clockinner1 clockinner">
                                    <h1 class="days">150</h1>
                                    <span class="smalltext">Days</span>
                                </div>
                                <div class="col clockinner clockinner1">
                                    <h1 class="hours">23</h1>
                                    <span class="smalltext">Hours</span>
                                </div>
                                <div class="col clockinner clockinner1">
                                    <h1 class="minutes">47</h1>
                                    <span class="smalltext">Mins</span>
                                </div>
                                <div class="col clockinner clockinner1">
                                    <h1 class="seconds">59</h1>
                                    <span class="smalltext">Secs</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="" class="primary-btn">Shop Now</a>
                </div>
                <div class="col-lg-6 no-padding exclusive-right">
                    <div class="active-exclusive-product-slider">
                        <!-- single exclusive carousel -->
                        @foreach ($saleProducts as $item)
                            <div class="single-exclusive-slider">
                                @php
                                    $images = json_decode($item->image, true);
                                @endphp
                                @if (is_array($images) && count($images) > 0)
                                    @php
                                        $firstImage = $images[0];
                                    @endphp
                                    <a href="{{ route('UserProductdetailsPage', $item->id) }}" class="exclusive-img-box">
                                        <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $item->name }}">
                                    </a>
                                @endif
                                <div class="product-details">
                                    <div class="price">
                                        <h6>${{ $item->price }}</h6>
                                        {{-- <h6 class="l-through">$210.00</h6> --}}
                                    </div>
                                    <h4>{{ $item->name }}</h4>

                                    <div class="add-bag d-flex align-items-center justify-content-center">
                                        @if ($item->qty > 0)
                                            <a class="add-btn" href=""><span class="ti-bag"></span></a>
                                            <span class="add-text text-uppercase">Add to Bag</span>
                                        @else
                                            <a href="javascript:void(0)" class="add-btn disabled-cart">
                                                <span class="ti-bag"></span>
                                            </a>
                                            <span class="add-text text-uppercase text-danger">Out of Stock</span>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End exclusive deal Area -->

    <!-- Start brand Area -->
    <section class="brand-area section_gap">
        <div class="container">
            <div class="row">
                <a class="col single-img" href="javascript:void(0)">
                    <img class="img-fluid d-block mx-auto" src="{{ asset('img/brand/1.png') }}" alt="">
                </a>
                <a class="col single-img" href="javascript:void(0)">
                    <img class="img-fluid d-block mx-auto" src="{{ asset('img/brand/2.png') }}" alt="">
                </a>
                <a class="col single-img" href="javascript:void(0)">
                    <img class="img-fluid d-block mx-auto" src="{{ asset('img/brand/3.png') }}" alt="">
                </a>
                <a class="col single-img" href="javascript:void(0)">
                    <img class="img-fluid d-block mx-auto" src="{{ asset('img/brand/4.png') }}" alt="">
                </a>
                <a class="col single-img" href="javascript:void(0)">
                    <img class="img-fluid d-block mx-auto" src="{{ asset('img/brand/5.png') }}" alt="">
                </a>
            </div>
        </div>
    </section>
    <!-- End brand Area -->


    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="{{ asset('ajax.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.wishlist-btn').click(function() {
                let productId = $(this).data('product-id');
                let url = "{{ route('WishlistStorePage') }}";
                let formData = new FormData();
                formData.append('product_id', productId);

                reusableAjaxCall(url, 'POST', formData, function(response) {
                    if (response.status == true) {
                        if (response.count > 0) {
                            $('.wishlist-count').remove();
                            Swal.fire({
                                icon: 'success',
                                title: 'Added to Wishlist',
                                text: 'Redirecting to wishlist...',
                                timer: 3000,
                                showConfirmButton: false
                            });
                            setTimeout(() => {
                                window.location.href = "{{ route('WishlistPage') }}";
                            }, 3000);

                        } else {
                            $('.wishlist-count').remove();

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
                        Swal.fire({
                            icon: 'success',
                            title: 'Added to Cart',
                            text: 'Redirecting to your Cart...',
                            timer: 3000,
                            showConfirmButton: false
                        });
                        setTimeout(() => {
                            window.location.href = "{{ route('UserCartPage') }}";
                        }, 3000);


                    }
                });


            });
        });
    </script>
@endsection
