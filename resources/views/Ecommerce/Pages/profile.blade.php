@extends('Ecommerce.Layout.index')
@section('container')
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-between">
            <div class="col-first">
                <h1 class="fw-bold">Profile Page</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ url('/') }}">Home <span class="lnr lnr-arrow-right"></span></a>
                    <a href="javascript:void(0)">Profile</a>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!--================Profile Area =================-->
<section class="profile_area section_gap py-5 bg-light">
    <div class="container">
        <div class="row">
            <!-- Profile Sidebar -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 rounded-4 p-3">
                    <div class="text-center">
                        <img src="{{ asset('storage/user/' . Auth::user()->image) }}" class="rounded-circle mb-3" 
                             width="120" height="120" alt="Profile Picture">
                        <h4 class="fw-bold text-capitalize">{{ Auth::user()->name }}</h4>
                        <p class="text-muted">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="d-grid mt-3 text-center">
                        <a href="" class="primary-btn btn-sm " style="border:none;">
                            Update Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- Profile Content -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-4 p-4">
                    <h4 class="fw-bold mb-4">Send Feedback</h4>
                    <form method="POST" action="">
                        @csrf
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control form-control-lg" 
                                       placeholder="Enter Name" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control form-control-lg" 
                                       placeholder="Enter Email" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="subject" class="form-control form-control-lg" 
                                   placeholder="Subject" required>
                        </div>
                        <div class="mb-3">
                            <textarea name="message" class="form-control form-control-lg" rows="6" 
                                      placeholder="Message" required></textarea>
                        </div>
                        <button type="submit" class="primary-btn btn-sm " style="border:none;">Submit Feedback</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================Profile Area =================-->
@endsection
