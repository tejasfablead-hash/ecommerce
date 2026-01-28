@extends('Ecommerce.Layout.index')
@section('container')
    <style>
        /* Category Card */
        .category-card {
            background: #fff;
            border-radius: 6px;
            transition: all 0.3s ease;
            height: 100%;
        }


        /* Image Box */
        .product-img-box {
            width: 100%;
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px 6px 0 0;
        }

        .product-img-box img {
            max-width: 85%;
            max-height: 85%;
            object-fit: contain;
        }

        /* Category Name */
        .category-title {
            font-size: 15px;
            /* margin: 12px 0; */
            color: #222;
        }

        /* Mobile Fix */
        @media (max-width: 768px) {
            .product-img-box {
                height: 160px;
            }
        }
    </style>
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Shop Category </h1>
                    <nav class="d-flex align-items-center">
                        <a href="javascript:void(0)">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="#">Shop<span class="lnr lnr-arrow-right"></span></a>
                        <a href="category.html">Fashion Category</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->
    <br>
    <br>
    <br>

    <div class="container text-capitalize">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-5">
                <div class="sidebar-categories">
                    <div class="head">Browse Categories</div>
                    <ul class="main-categories" id="categoryMenu">
                        @if ($category->count() && isset($category))
                            @foreach ($category as $item)
                                <li class="main-nav-list">
                                    <a data-toggle="collapse" href="#category-{{ $item->id }}" aria-expanded="false"
                                        aria-controls="category-{{ $item->id }}">
                                        <span class="lnr lnr-arrow-right"></span>{{ $item->name }}
                                        <span class="number">({{ $item->getproduct_count }})</span></a>
                                    <ul class="collapse" id="category-{{ $item->id }}" data-parent="#categoryMenu">

                                        @forelse ($item->getproduct as $product)
                                            <li class="main-nav-list child">
                                                <a href="{{ route('UserProductdetailsPage', $product->id) }}">
                                                    {{ $product->name }}
                                                </a>
                                            </li>
                                        @empty
                                            <li class="main-nav-list child text-muted">
                                                &nbsp;&nbsp;&nbsp; <span>No products</span>
                                            </li>
                                        @endforelse
                                    </ul>
                                </li>
                            @endforeach
                        @else
                            <li class="main-nav-list text-center text-muted p-3">
                                No categories found
                            </li>
                        @endif
                    </ul>
                </div>

            </div>
            <div class="col-xl-9 col-lg-8 col-md-7">
                <!-- Start Filter Bar -->

                <div class="category-header text-center mb-4">
                    <h2 class="category-heading">Categories</h2>
                </div>


                <!-- End Filter Bar -->
                <!-- Start Best Seller -->
                <section class="latest-product-area pb-40 category-list">
                    <div class="row">
                        @if ($category->count() && isset($category))
                            @foreach ($category as $item)
                                <div class="col-lg-4 col-md-6 col-sm-6 ">
                                    <div class="single-product category-card" style="margin-bottom: 0px;">
                                        <!-- Category Image -->
                                        <a href="{{ route('UserCategoryProductPage', $item->id) }}"
                                            class="product-img-box ">
                                            <img src="{{ asset('storage/category/' . $item->image) }}"
                                                alt="{{ $item->name }}">
                                        </a>
                                        <!-- Category Name -->
                                        <div class="product-details text-center">
                                            <h6 class="category-title">{{ $item->name }}</h6>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 text-center py-5">
                                <img src="{{ asset('img/logo.png') }}" style="max-width:220px" class="mb-3">

                                <h4 class="text-danger">No Categories Available</h4>
                                <p class="text-muted">Please check back later.</p>

                                <a href="{{ route('HomePage') }}" class="primary-btn">
                                    Go to Home
                                </a>
                            </div>
                        @endif

                    </div>
                </section>

            </div>
        </div>
    </div>

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
    <!-- Start related-product Area -->
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
                $allProducts = $products->take(9);
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
                                            <h6>${{ $item->price }}</h6>
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
                        <a href="#" target="_blank">
                            <img class="img-fluid d-block mx-auto" src="{{ asset('img/category/c5.jpg') }}"
                                alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- End related-product Area -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="{{ asset('ajax.js') }}"></script>
@endsection
