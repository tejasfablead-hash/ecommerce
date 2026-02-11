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

        .filter-sidebar {
            background: #fff;
            border-radius: 10px;
        }

        .filter-sidebar h5 {
            font-weight: 600;
            margin-bottom: 10px;
        }

      .filter-control {
    width: 100%;
    height: 45px;
    padding: 0 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    background: #fff;
    transition: 0.3s;
}

.filter-control:focus {
    border-color: #6b6b6b;
    box-shadow: 0 0 5px rgba(255,106,0,0.2);
    outline: none;
}

.filter-btn {
    height: 45px;
    border-radius: 6px;
    background: #ff7b00;
    color: #fff;
    border: none;
    font-weight: 500;
    transition: 0.3s;
}

.filter-btn:hover {
    background: #e55b00;
}

    </style>
    <!-- start banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Shop Product </h1>
                    <nav class="d-flex align-items-center">
                        <a href="javascript:void(0)">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="javascript:void(0)">Shop<span class="lnr lnr-arrow-right"></span></a>
                        <a href="javascript:void(0)">Fashion Product</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- End banner Area -->

       @php
        $saleProducts = $product->where('status', 'active')->take(2);

        $latestProducts = $product->where('status', 'active')->take(8);

        $comingProducts = $product->where('status', 'active')->skip(8);
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
            <div class="container mb-4">
    <div class="filter-bar shadow-sm bg-white rounded p-3">
        <form method="GET" action="{{ route('UserProductPage') }}">
            <div class="row g-3 align-items-center">

                <!-- CATEGORY -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <select name="category" class="filter-control">
                        <option value="">Category</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->name }}"
                                {{ request('category') == $cat->name ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- MIN PRICE -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <input type="number" name="min_price"
                        class="filter-control"
                        placeholder="Min Price"
                        value="{{ request('min_price') }}">
                </div>

                <!-- MAX PRICE -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <input type="number" name="max_price"
                        class="filter-control"
                        placeholder="Max Price"
                        value="{{ request('max_price') }}">
                </div>

                <!-- DISCOUNT -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <select name="discount" class="filter-control">
                        <option value="">Discount</option>
                        <option value="10" {{ request('discount') == 10 ? 'selected' : '' }}>10% +</option>
                        <option value="20" {{ request('discount') == 20 ? 'selected' : '' }}>20% +</option>
                        <option value="30" {{ request('discount') == 30 ? 'selected' : '' }}>30% +</option>
                    </select>
                </div>

                <!-- SORT -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <select name="sort_by" class="filter-control">
                        <option value="">Sort By</option>
                        <option value="price_low_high"
                            {{ request('sort_by') == 'price_low_high' ? 'selected' : '' }}>
                            Price: Low → High
                        </option>
                        <option value="price_high_low"
                            {{ request('sort_by') == 'price_high_low' ? 'selected' : '' }}>
                            Price: High → Low
                        </option>
                        <option value="newest"
                            {{ request('sort_by') == 'newest' ? 'selected' : '' }}>
                            Newest
                        </option>
                        <option value="oldest"
                            {{ request('sort_by') == 'oldest' ? 'selected' : '' }}>
                            Oldest
                        </option>
                        <option value="discount_high"
                            {{ request('sort_by') == 'discount_high' ? 'selected' : '' }}>
                            Highest Discount
                        </option>
                    </select>
                </div>

                <!-- BUTTON -->
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <button type="submit" class="filter-btn  w-100">
                        Apply
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>


                <div class="row">
                    <!-- single product -->
                    @if (isset($latestProducts))
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

                                        <h6 class="mb-1">
                                            {{ $item->name }}
                                            @if ($item->discount > 0)
                                                <span class="text-success fw-bold ms-1">
                                                    {{ number_format($item->discount, 0) }}% OFF
                                                </span>
                                            @endif
                                        </h6>

                                        <div class="price d-flex align-items-center gap-2">
                                            <h6 class="mb-0 fw-bold text-dark">
                                                $ {{ number_format($item->discount_value, 2) }}
                                            </h6>

                                            @if ($item->discount > 0)
                                                <h6 class="mb-0 text-muted l-through">
                                                    $ {{ number_format($item->price, 2) }}
                                                </h6>
                                            @endif
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
                    @else
                        <div class="col-md-12">
                            <div class="no-product-box text-center">
                                <h4>No Products Available</h4>
                                <p class="text-muted">
                                    We’re working on adding new items.
                                    Please check back soon!
                                </p>
                            </div>
                        </div>
                    @endif
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
                    @if (isset($comingProducts))
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
                                                    src="{{ asset('/storage/' . $firstImage) }}"
                                                    alt="{{ $item->name }}" class="img-fluid"></a>
                                        @endif
                                    </div>
                                    <div class="product-details mt-2">

                                        <h6 class="mb-1">
                                            {{ $item->name }}
                                            @if ($item->discount > 0)
                                                <span class="text-success fw-bold ms-1">
                                                    {{ number_format($item->discount, 0) }}% OFF
                                                </span>
                                            @endif
                                        </h6>

                                        <div class="price d-flex align-items-center gap-2">
                                            <h6 class="mb-0 fw-bold text-dark">
                                                $ {{ number_format($item->discount_value, 2) }}
                                            </h6>

                                            @if ($item->discount > 0)
                                                <h6 class="mb-0 text-muted l-through">
                                                    $ {{ number_format($item->price, 2) }}
                                                </h6>
                                            @endif
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

                                            <a href="{{ route('UserProductdetailsPage', $item->id) }}"
                                                class="social-info">
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
                    @else
                        <div class="col-md-12">
                            <div class="no-product-box text-center">
                                <h4>No Products Available</h4>
                                <p class="text-muted">
                                    We’re working on adding new items.
                                    Please check back soon!
                                </p>
                            </div>
                        </div>
                    @endif
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
                    <a href="javascript:void(0)" class="primary-btn">Shop Now</a>
                </div>
                <div class="col-lg-6 no-padding exclusive-right">
                    <div class="active-exclusive-product-slider">
                        <!-- single exclusive carousel -->
                        @if (isset($saleProducts) && $saleProducts->count())
                            @forelse ($saleProducts as $item)
                                <div class="single-exclusive-slider">
                                    @php
                                        $images = json_decode($item->image, true);
                                    @endphp
                                    @if (is_array($images) && count($images) > 0)
                                        @php
                                            $firstImage = $images[0];
                                        @endphp
                                        <a href="{{ route('UserProductdetailsPage', $item->id) }}"
                                            class="exclusive-img-box">
                                            <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $item->name }}">
                                        </a>
                                    @endif
                                    <div class="product-details">
                                        <div class="price ">
                                            <h6 class="mt-1">${{ $item->discount_value }}</h6>
                                            <h6 class="l-through">${{ $item->price }}</h6>
                                        </div>
                                        <h4>{{ $item->name }}</h4>

                                        <div class="add-bag d-flex align-items-center justify-content-center">
                                            @if ($item->qty > 0)
                                                <a class="add-btn cart-info" href="javascript:void(0)"
                                                    data-cart-id="{{ $item->id }}"><span class="ti-bag"></span></a>
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
                            @empty
                                <div class="single-exclusive-slider">
                                    <div class="product-details">
                                        <div class="add-bag d-flex align-items-center justify-content-center">

                                            <img src="{{ asset('img/logo.png') }}" style="max-width:200px"
                                                class="mb-4">

                                            <h4 class="text-danger">No Sale Products Available</h4>
                                            <p class="text-muted">
                                                Exclusive deals are coming soon.
                                                Please check back later!
                                            </p>

                                            <a href="{{ route('UserCategoryPage') }}" class="primary-btn mt-3">
                                                Browse Products
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        @else
                            <div class="single-exclusive-slider">
                                <div class="product-details">
                                    <div class="add-bag d-flex align-items-center justify-content-center">

                                        <img src="{{ asset('img/logo.png') }}" style="max-width:200px" class="mb-4">

                                        <h4 class="text-danger">No Sale Products Available</h4>
                                        <p class="text-muted">
                                            Exclusive deals are coming soon.
                                            Please check back later!
                                        </p>

                                        <a href="{{ route('UserCategoryPage') }}" class="primary-btn mt-3">
                                            Browse Products
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
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
    <section class="related-product-area section_gap_bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="section-title">
                        <h1>Deals of the Week</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore
                            magna aliqua.</p>
                    </div>
                </div>
            </div>

            @php
                $allProducts = $product->take(9);
            @endphp
            <div class="row">
                <div class="col-lg-9">
                    <div class="row">
                        @forelse ($allProducts as $item)
                            <div class="col-lg-4 col-md-4 col-sm-6 mb-20">
                                <div class="single-related-product d-flex">
                                    @php
                                        $images = json_decode($item->image, true);
                                    @endphp
                                    @if (is_array($images) && count($images) > 0)
                                        @php
                                            $firstImage = $images[0];
                                        @endphp
                                        <a href="{{ route('UserProductdetailsPage', $item->id) }}"><img
                                                src="{{ asset('/storage/' . $firstImage) }}" height="60px"
                                                width="75px" alt="{{ $item->name }}" class="img-fluid"></a>
                                    @endif
                                    <div class="desc">
                                        <a href="{{ route('UserProductdetailsPage', $item->id) }}"
                                            class="title">{{ Str::limit($item->name, 10) }}</a>
                                        <div class="price">

                                            <h6>${{ $item->discount_value }}</h6>
                                            @if ($item->discount > 0)
                                                <br>
                                                <h6 class="l-through">${{ $item->price }}</h6>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center text-muted py-4">
                                No related products found
                            </div>
                        @endforelse

                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ctg-right">
                        <a href="javascript:void(0)" target="_blank">
                            <img class="img-fluid d-block mx-auto" src="{{ asset('img/category/c5.jpg') }}"
                                alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>


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
        });
    </script>
@endsection
