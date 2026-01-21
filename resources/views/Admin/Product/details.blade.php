@extends('Admin.Pages.index')
@section('container')

<main class="nxl-container">
    <div class="nxl-content">

        {{-- PAGE HEADER --}}
        <div class="page-header text-capitalize">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Product</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item">Product</li>
                    </ul>
                </div>
                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex d-md-none">
                            <a href="javascript:void(0)" class="page-header-right-close-toggle">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Back</span>
                            </a>
                        </div>
                        <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                            <a href="{{ route('ProductEditPage', $product->id) }}" class="btn btn-primary">
                                <i class="feather-plus me-2"></i>
                                <span>Edit Product</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        {{-- MAIN CONTENT --}}
        <div class="main-content">
        <div class="row">

            {{-- IMAGE SECTION --}}
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">

                        @php
                            $images = json_decode($product->image, true);
                        @endphp

                        {{-- MAIN IMAGE --}}
                        <div class="mb-3 text-center">
                            <img id="mainImage"
                                 src="{{ asset('storage/'.$images[0]) }}"
                                 class="img-fluid rounded border"
                                 style="max-height: 350px; object-fit: contain;">
                        </div>

                        {{-- THUMBNAILS --}}
                        <div class="d-flex flex-wrap gap-2 justify-content-center">
                            @foreach($images as $img)
                                <img src="{{ asset('storage/'.$img) }}"
                                     class="border rounded thumb-img"
                                     width="70"
                                     height="70"
                                     style="cursor:pointer; object-fit:cover"
                                     onclick="changeImage(this)">
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>

            {{-- PRODUCT INFO --}}
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body">

                        <h4 class="fw-bold mb-2">{{ $product->name }}</h4>

                        <span class="badge bg-info mb-3">
                            {{ $product->getcategory->name }}
                        </span>

                        <hr>

                        <div class="row mb-3">
                            <div class="col-6">
                                <p class="text-muted mb-1">Price</p>
                                <h6>₹ {{ number_format($product->price, 2) }}</h6>
                            </div>
                            <div class="col-6">
                                <p class="text-muted mb-1">Quantity</p>
                                <h6>{{ $product->qty }}</h6>
                            </div>
                        </div>

                        <div class="mb-3">
                            <p class="text-muted mb-1">Status</p>
                            <span class="badge {{ $product->status ? 'bg-success' : 'bg-danger' }}">
                                {{ $product->status ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <p class="text-muted mb-1">Description</p>
                            <p class="mb-0">{{ $product->description }}</p>
                        </div>

                        <hr>

                        <p class="text-muted mb-1">Created At</p>
                        <p>{{ $product->created_at->format('d M Y') }}</p>

                    </div>
                </div>
            </div>

        </div>
        </div>
    </div>

    @include('Admin.Pages.footer')
</main>

{{-- IMAGE SWITCH SCRIPT --}}
<script>
    function changeImage(el) {
        document.getElementById('mainImage').src = el.src;
    }
</script>

@endsection
