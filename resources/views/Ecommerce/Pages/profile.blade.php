@extends('Ecommerce.Layout.index')
@section('container')
    <style>
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
            color: #f8a710;
        }
    </style>

    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Profile Info </h1>
                    <nav class="d-flex align-items-center">
                        <a href="javascript:void(0)">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="javascript:void(0)">Shop<span class="lnr lnr-arrow-right"></span></a>
                        <a href="javascript:void(0)">Profile</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <section class="profile_area section_gap py-5 bg-light">
        <div class="container">
            <div class="row">

                <!-- ================= Profile Sidebar ================= -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm border-0 rounded-4 p-4">
                        <div class="text-center">
                            <img src="{{ asset('storage/user/' . Auth::user()->image) }}" class="rounded-circle mb-3"
                                width="120" height="120" alt="Profile">

                            <h4 class="fw-bold text-capitalize">{{ Auth::user()->name }}</h4>
                            <p class="text-muted mb-1">{{ Auth::user()->email }}</p>
                            <p class="text-muted">{{ Auth::user()->phone ?? '' }}</p>
                            <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                        </div>

                        <div class="d-grid mt-3 text-center">
                            <a href="javascript:void(0)" class="primary-btn btn-sm text-center" style="border:none;"
                                data-bs-toggle="modal" data-bs-target="#updateProfileModal">
                                Update Profile
                            </a>

                        </div>
                    </div>
                </div>

                <!-- ================= Update Profile Modal ================= -->
                <!-- ================= Update Profile Modal ================= -->
                <div class="modal fade" id="updateProfileModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-md">
                        <div class="modal-content border-0 rounded-4 overflow-hidden">
                            <form id="updateprofileform" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header border-0">
                                    <h5 class="modal-title fw-bold">Update Profile</h5> <button type="button"
                                        class="btn-close border-0 bg-white" data-bs-dismiss="modal">X</button>
                                </div>
                                <!-- Top Header / Avatar -->
                                <div class="bg-light text-center py-4">
                                    <img src="{{ asset('storage/user/' . Auth::user()->image) }}"
                                        class="rounded-circle shadow-sm mb-2" width="110" height="110" alt="Profile">
                                </div>

                                <!-- Close Button -->
                                <!-- Form -->

                                <div class="modal-body px-2 py-2">
                                    <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                                    <div class="row g-3">
                                        <!-- Name -->
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Name</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ Auth::user()->name }}">
                                            <small class="text-danger error" id="name_error"></small>

                                        </div>

                                        <!-- Email -->
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Email</label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ Auth::user()->email }}">
                                            <small class="text-danger error" id="email_error"></small>

                                        </div>

                                        <!-- Phone -->
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Phone</label>
                                            <input type="text" name="phone" class="form-control"
                                                value="{{ Auth::user()->phone }}">
                                            <small class="text-danger error" id="phone_error"></small>

                                        </div>

                                        <!-- Image Upload -->
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Profile Image</label>
                                            <input type="file" name="image" class="form-control">
                                            <small class="text-danger error" id="image_error"></small>

                                        </div>
                                    </div>
                                </div>

                                <!-- Footer Actions -->
                                <div class="modal-footer border-0 px-4 pb-4">
                                    <button type="button" class="btn btn-dark rounded-pill px-4" data-bs-dismiss="modal">
                                        Cancel
                                    </button>
                                    <input type="submit" style="background-color:#f58122;" name="submit" value="Save Changes"
                                        class="btn text-white  rounded-pill px-4">

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- ================= End Modal ================= -->

                <!-- ================= End Modal ================= -->


                <!-- ================= Profile Content ================= -->
                <div class="col-lg-8">
                    <!-- Orders Card -->
                    <div class="card shadow-sm border-0 rounded-4 mb-4">
                        <div class="card-body">
                            <h4 class="fw-bold mb-4">My Orders</h4>
                            @if (isset($orders))
                                @if ($orders->count())
                                    <div class="table-responsive">
                                        <table class="table align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Products</th>
                                                    <th>Date</th>
                                                    <th>Total</th>
                                                    <th>Status</th>
                                                    <th class="text-end">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($orders as $order)
                                                    <tr>
                                                        <!-- Order ID -->
                                                        <td>
                                                            <strong>#{{ $order->order_number }}</strong>
                                                        </td>

                                                        <!-- Products -->
                                                        <td>
                                                            @foreach ($order->orderitem as $item)
                                                                <div class="d-flex align-items-center ">
                                                                    <span class="text-capitalize">
                                                                        {{ \Illuminate\Support\Str::limit($item->product->name, 6, '...') }}
                                                                    </span>
                                                                </div>
                                                            @endforeach
                                                        </td>

                                                        <!-- Date -->
                                                        <td>
                                                            {{ $order->created_at->format('d M Y') }}
                                                        </td>

                                                        <!-- Total -->
                                                        <td>
                                                            ₹{{ number_format($order->grand_total, 2) }}
                                                        </td>

                                                        <!-- Status -->
                                                        <td>
                                                            <span
                                                                class="
                                        @if ($order->order_status == 'confirmed') @elseif ($order->order_status == 'delivered') 
                                        @elseif ($order->order_status == 'cancelled')
                                        @else @endif">
                                                                {{ ucfirst($order->order_status) }}
                                                            </span>
                                                        </td>

                                                        <!-- Action -->
                                                        <td class="text-end card_area">
                                                            <a href="{{ route('UserConfirmPage', $order->id) }}"
                                                                class="btn btn-sm btn-dark cart-info">
                                                                View
                                                            </a>
                                                             <a href="{{ route('UserOrderPdf', $order->id) }}" style="background-color:#f8a528;"
                                                                 class="btn btn-sm text-white cart-info">
                                                                PDF
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <p class="text-muted mb-0">You haven’t placed any orders yet.</p>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-5">
                                    <p class="text-muted mb-0">You haven’t placed any orders yet.</p>
                                </div>
                            @endif

                        </div>
                    </div>
                    <!-- Optional: Feedback Card -->
                    {{-- @if ($feedbackOrder )
                        <div class="card shadow-sm border-0 rounded-4">
                            <div class="card-body ">
                                <h4 class="fw-bold mb-4">Send Feedback</h4>
                                <form id="feedback" action="" class="contact_form" novalidate="novalidate">
                                    @csrf
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <input type="hidden" name="order_id" value="{{ $feedbackOrder->id }}">
                                            <input type="text" name="name" class="form-control form-control-lg"
                                                value="" placeholder="name">
                                            <small class="text-danger error" id="name_error"></small>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="email" name="email" class="form-control form-control-lg"
                                                value="" placeholder="email">
                                            <small class="text-danger error" id="email_error"></small>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <textarea name="message" class="form-control form-control-lg" rows="2" placeholder="Message"></textarea>
                                        <small class="text-danger error" id="message_error"></small>
                                    </div>
                                    <div class="mb-3">
                                        <div class="rating">
                                            <input type="radio" name="subject" id="star5" value="5"><label
                                                for="star5">★</label>
                                            <input type="radio" name="subject" id="star4" value="4"><label
                                                for="star4">★</label>
                                            <input type="radio" name="subject" id="star3" value="3"><label
                                                for="star3">★</label>
                                            <input type="radio" name="subject" id="star2" value="2"><label
                                                for="star2">★</label>
                                            <input type="radio" name="subject" id="star1" value="1"><label
                                                for="star1">★</label>
                                        </div>
                                        <small class="text-danger error" id="subject_error"></small>
                                    </div>

                                    <input type="submit" value="Submit Feedback" class=" mt-2  primary-btn btn-sm"
                                        style="border:none;">
                                </form>
                            </div>
                        </div>
                    @else
                         <div class="alert alert-dark card shadow-sm border-0 rounded-4">
                            Feedback Already Send.
                        </div>
                    @endif --}}
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="{{ asset('ajax.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#updateprofileform').submit(function(e) {
                e.preventDefault();
                var data = $('#updateprofileform')[0];
                var formData = new FormData(data);
                $('.error').text('');
                let url = "{{ route('UserEditProfilePage') }}";

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
                        if (response.status == true) {
                            Toast.fire({
                                icon: "success",
                                title: response.message || "Profile Updated Successfully"
                            });
                            $('#updateProfileModal').modal('hide');
                            setTimeout(function() {
                                window.location.href = "{{ route('UserProfilePage') }}";
                            }, 2000);

                            $('#updateprofileform')[0].reset();
                        }
                    },
                    function(error) {
                        console.log(error);
                    }
                );
            });

            // $('#feedback').submit(function(e) {
            //     e.preventDefault();
            //     var data = $('#feedback')[0];
            //     var formData = new FormData(data);
            //     $('.error').text('');
            //     let url = "{{ route('UserFeedbackPage') }}";
            //     reusableAjaxCall(url, 'POST', formData, function(response) {
            //             console.log('response', response);
            //             const Toast = Swal.mixin({
            //                 toast: true,
            //                 position: "top-end",
            //                 showConfirmButton: false,
            //                 timer: 3000,
            //                 timerProgressBar: true,
            //                 didOpen: (toast) => {
            //                     toast.onmouseenter = Swal.stopTimer;
            //                     toast.onmouseleave = Swal.resumeTimer;
            //                 }
            //             });
            //             if (response.status === true) {
            //                 Toast.fire({
            //                     icon: "success",
            //                     title: response.message || "Feedback Send Successfully"
            //                 });
            //                   $('#feedback').closest('.card').fadeOut();
            //                 setTimeout(function() {
            //                     window.location.href = "{{ route('UserConfirmPage') }}";
            //                 }, 2000);

            //             } else {
            //                 Toast.fire({
            //                     icon: "error",
            //                     title: response.message || "Feedback not Sent"
            //                 });
            //             }
            //             $('#feedback')[0].reset();
            //         },
            //         function(error) {
            //             console.log('error', error);
            //         });
            // });
        });
    </script>

@endsection
