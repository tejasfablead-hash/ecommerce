@extends('Admin.Pages.index')
@section('container')
    <main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Product</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item">Create</li>
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

                            <a href="{{ route('ProductViewPage') }}" class="btn btn-primary ">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Back</span>
                            </a>
                        </div>
                    </div>
                    <div class="d-md-none d-flex align-items-center">
                        <a href="javascript:void(0)" class="page-header-right-open-toggle">
                            <i class="feather-align-right fs-20"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- [ page-header ] end -->
            <!-- [ Main Content ] start -->

            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-body general-info">
                                <div class="mb-5 d-flex align-items-center justify-content-between">
                                    <h5 class="fw-bold mb-0 me-4">
                                        <span class="d-block mb-2">Create Product :</span>
                                        <span class="fs-12 fw-normal text-muted text-truncate-1-line">General
                                            information
                                            for product</span>
                                    </h5>
                                    {{-- <a href="javascript:void(0);" class="btn btn-sm btn-light-brand">Edit Lead</a> --}}
                                </div>
                                <form action="" id="productform" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row mb-4 align-items-center">
                                                <label for="fullnameInput" class="fw-semibold">Category: </label>
                                                <div class="col-lg-12">
                                                    <div class="input-group">
                                                        <select name="category" class="form-control" id="category">
                                                            <option value="">Select Category</option>
                                                            @foreach ($category as $item)
                                                                <option value="{{ $item->id }}">{{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <small class="text-danger error " id="category_error"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row mb-4 align-items-center">
                                                <label for="fullnameInput" class="fw-semibold">Product Name: </label>
                                                <div class="col-lg-12">
                                                    <div class="input-group">
                                                        <input type="text" name="product" class="form-control"
                                                            placeholder="Productname">
                                                    </div>
                                                    <small class="text-danger error " id="product_error"></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row mb-4 align-items-center">
                                                <label for="fullnameInput" class="fw-semibold">Price: </label>
                                                <div class="col-lg-12">
                                                    <div class="input-group">
                                                        <input type="text" name="price" class="form-control"
                                                            placeholder="Price">
                                                    </div>
                                                    <small class="text-danger error " id="price_error"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row mb-4 align-items-center">
                                                <label for="fullnameInput" class="fw-semibold">Qty: </label>
                                                <div class="col-lg-12">
                                                    <div class="input-group">
                                                        <input type="text" name="qty" class="form-control"
                                                            placeholder="Qty">
                                                    </div>
                                                    <small class="text-danger error " id="qty_error"></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row mb-4 align-items-center">
                                                <label for="fullnameInput" class="fw-semibold">Description: </label>
                                                <div class="col-lg-12">
                                                    <div class="input-group">
                                                        <textarea type="text" name="description" class="form-control" placeholder="Description"></textarea>
                                                    </div>
                                                    <small class="text-danger error " id="description_error"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row mb-4 align-items-center">

                                                <label for="mailInput" class="fw-semibold">Image: </label>

                                                <div class="col-lg-12">
                                                    <div class="input-group">
                                                        <input type="file" name="image[]" class="form-control"
                                                            id="mailInput" multiple>
                                                    </div>
                                                    <small class="text-danger error" id="image_error"></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-2">
                                            <div class="input-group">
                                                <input type="submit" class="btn btn-primary form-control"
                                                    value="Create Product">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Footer ] start -->
        @include('Admin.Pages.footer')
        <!-- [ Footer ] end -->
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.js" crossorigin="anonymous"></script>
    <script src="{{ asset('ajax.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#productform').submit(function(e) {

                e.preventDefault();

                var data = $('#productform')[0];
                var formData = new FormData(data);
                $('.error').text('');
                var url = "{{ route('ProductAddPage') }}";
                reusableAjaxCall(url, 'POST', formData, function(response) {
                    console.log(response);
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
                            title: response.message || "Product added successfully"
                        });
                        setTimeout(() => {
                            window.location.href = "{{ route('ProductViewPage') }}";
                        }, 3000);
                    } else {
                        Toast.fire({
                            icon: "error",
                            title: response.message || "Something went wrong"
                        });
                    }
                    $('#productform')[0].reset();
                }, function(error) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Server error, please try again!"
                    });
                    console.log(error);
                });
            });
        });
    </script>
@endsection
