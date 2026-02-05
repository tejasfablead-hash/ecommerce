@extends('Ecommerce.Layout.index')
@section('container')
    <style>
        /* Wishlist Card */
        .single-product.card {
            border: 0.5px solid #eee;
            border: none;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .single-product.card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        /* Fixed Image Box */
        .product-img {
            width: 100%;
            height: 220px;
            background: #f8f8f8;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Image Fit */
        .product-img img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            /* 👈 keeps full image */
            padding: 10px;

        }

        /* Card Footer */
        .card-footer {
            padding: 12px;
            display: flex;
            gap: 8px;
            justify-content: center;
        }
    </style>
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Wishlist </h1>
                    <nav class="d-flex align-items-center">
                        <a href="javascript:void(0)">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="javascript:void(0)">Shop<span class="lnr lnr-arrow-right"></span></a>
                        <a href="javascript:void(0)">Product Wishlist</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="wishlist_area section_gap">
        <div class="container">
            <div class="section-title text-center">
                <h2>My Wishlist</h2>
                <p>Your favourite products saved here </p>
            </div>

            @if (isset($wishlists) && $wishlists->count() > 0)
                <div class="row text-capitalize">
                    @foreach ($wishlists as $item)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3 wishlist-card"
                            id="wishlist-card-{{ $item->product->id }}">

                            <div class="single-product card h-100">

                                <div class="product-img">
                                    @php
                                        $images = json_decode($item->product->image, true);
                                    @endphp
                                    @if (is_array($images) && count($images))
                                        <a href="{{ route('UserProductdetailsPage', $item->product->id) }}">
                                            <img src="{{ asset('storage/' . $images[0]) }}"
                                                alt="{{ $item->product->name }}">
                                        </a>
                                    @endif
                                </div>

                                <div class=" text-center">
                                    <h6 class="card-title">{{ $item->product->name }}</h6>
                                    <div class="price">
                                        <h6>₹{{ $item->product->discount_value }}</h6>
                                    </div>
                                </div>

                                <div class="card-footer bg-white border-0">
                                    <a href="{{ route('UserProductdetailsPage', $item->product->id) }}"
                                        class="genric-btn primary">
                                        View
                                    </a>

                                    <button class="genric-btn danger remove-wishlist" data-id="{{ $item->product->id }}">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            @else
                {{-- Empty Wishlist --}}
                <div class="text-center mt-5">
                    <img src="{{ asset('/img/fav.png') }}" width="100">
                    <h4 class="mt-3">Your wishlist is empty</h4>
                    <a href="{{ route('HomePage') }}" class="primary-btn mt-3">
                        Continue Shopping
                    </a>
                </div>
            @endif

        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="{{ asset('ajax.js') }}"></script>
    <script>
        $(document).ready(function() {

            $(document).on('click', '.remove-wishlist', function() {

                let btn = $(this);
                let productId = btn.data('id');
                let card = $('#wishlist-card-' + productId);

                let formData = new FormData();
                formData.append('product_id', productId);

                let url = "{{ route('WishlistStorePage') }}";

                reusableAjaxCall(url, 'POST', formData, function(response) {

                    if (response.status === true) {
                        loadWishlistCount();
                        card.fadeOut(400, function() {
                            $(this).remove();
                            if ($('.wishlist-card').length === 0) {
                                $('.wishlist_area .row').remove();
                                $('.wishlist_area .container').append(`
                            <div class="text-center mt-5 wishlist-empty">
                                <img src="{{ asset('/img/fav.png') }}" width="100">
                                <h4 class="mt-3">Your wishlist is empty</h4>
                                <a href="{{ route('HomePage') }}" class="primary-btn mt-3">
                                    Continue Shopping
                                </a>
                            </div>
                        `);
                            }
                        });

                        Swal.fire({
                            icon: 'success',
                            title: 'Removed from Wishlist',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            });

        });
    </script>


@endsection
