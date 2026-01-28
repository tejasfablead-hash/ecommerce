@extends('Admin.Pages.index')
@section('container')
    <main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Category</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Edit</li>
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

                            <a href="{{route('CategoryViewPage')}}" class="btn btn-primary ">
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
                                        <span class="d-block mb-2">Update Category :</span>
                                        <span class="fs-12 fw-normal text-muted text-truncate-1-line">General
                                            information
                                            for category</span>
                                    </h5>
                                    {{-- <a href="javascript:void(0);" class="btn btn-sm btn-light-brand">Edit Lead</a> --}}
                                </div>
                                <form action="" id="categoryform" enctype="multipart/form-data">
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-4">
                                            <label for="fullnameInput" class="fw-semibold">Category: </label>
                                        </div>
                                        <input type="hidden" name="id" value="{{ $single->id }}"
                                            class="form-control" placeholder="Sub category">
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <select name="category" class="form-control" id="category">
                                                    <option value="">Select Category</option>
                                                    @foreach ($category as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ isset($single) && $item->id == $single->parent_id ? 'selected' : '' }}>
                                                            {{ $item->category }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <small class="text-danger error " id="category_error"></small>
                                        </div>
                                    </div>
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-4">
                                            <label for="fullnameInput" class="fw-semibold">Sub Category: </label>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <input type="text" name="subcategory" value="{{ $single->name }}"
                                                    class="form-control" placeholder="Sub category">

                                            </div>
                                            <small class="text-danger error " id="subcategory_error"></small>
                                        </div>
                                    </div>
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-4">
                                            <label for="mailInput" class="fw-semibold">Image: </label>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <input type="file" name="image" class="form-control" id="mailInput">
                                            </div>
                                            <small class="text-danger error " id="image_error"></small><br>
                                            <img src="{{ asset('storage/category/' . $single->image) }}"
                                                height="50px "width="50px" class="rounded" alt="">
                                        </div>
                                    </div>
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-4">
                                            <label for="mailInput" class="fw-semibold"></label>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="input-group">
                                                <input type="submit" class="btn btn-primary form-control"
                                                    value="Update Category">
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
            $('#categoryform').submit(function(e) {
                e.preventDefault();

                var data = $('#categoryform')[0];
                var formData = new FormData(data);
                $('.error').text('');
                var url = "{{ route('CategoryUpdatePage') }}";
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
                            title: response.message || "Category Updated successfully"
                        });
                        setTimeout(() => {
                            window.location.href = "{{route('CategoryViewPage')}}";
                        }, 3000);
                     } else {
                        Toast.fire({
                            icon: "error",
                            title: response.message || "Something went wrong"
                        });
                    }
                    $('#categoryform')[0].reset();
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
