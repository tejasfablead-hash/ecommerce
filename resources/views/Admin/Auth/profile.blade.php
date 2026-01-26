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
                          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                          <li class="breadcrumb-item">View</li>
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

                              <a href="customers-create.html" class="btn btn-primary">
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
                      <div class="col-xxl-4 col-xl-6">
                          <div class="card stretch stretch-full">
                              <div class="card-body">
                                  <div class="mb-4 text-center">
                                      <div class="wd-150 ht-150 mx-auto mb-3 position-relative">
                                          <div class="avatar-image wd-150 ht-150 border border-5 border-gray-3">
                                              @if (Auth::check())
                                                  <img src="{{ asset('storage/user/' . Auth::user()->image) }}"
                                                      alt="user-image" class="img-fluid user-avtar" />
                                              @else
                                                  <img src="{{ asset('assets/images/avatar/1.png') }}" alt="user-image"
                                                      class="img-fluid user-avtar" />
                                              @endif
                                          </div>
                                          <div class="wd-10 ht-10 text-success rounded-circle position-absolute translate-middle"
                                              style="top: 76%; right: 10px">
                                              <i class="bi bi-patch-check-fill"></i>
                                          </div>
                                      </div>
                                      <div class="mb-4">
                                          <a href="javascript:void(0);" class="text-capitalize fs-14 fw-bold d-block">
                                              {{ Auth::user()->name }}</a>
                                          <a href="javascript:void(0);"
                                              class="fs-12 fw-normal text-muted d-block">{{ Auth::user()->email ?? '' }}</a>
                                      </div>

                                  </div>
                                  <ul class="list-unstyled mb-4 ">
                                      <li class="hstack justify-content-between mb-4">
                                          <span class="text-muted fw-medium hstack gap-3"><i
                                                  class="feather-map-pin"></i>Location</span>
                                          <a href="javascript:void(0);"
                                              class="text-capitalize float-end">{{ Auth::user()->address ?? '' }}</a>
                                      </li>
                                      <li class="hstack justify-content-between mb-4">
                                          <span class="text-muted fw-medium hstack gap-3"><i
                                                  class="feather-phone"></i>Phone</span>
                                          <a href="javascript:void(0);"
                                              class="float-end">{{ Auth::user()->phone ?? '' }}</a>
                                      </li>
                                      <li class="hstack justify-content-between mb-0">
                                          <span class="text-muted fw-medium hstack gap-3"><i
                                                  class="feather-mail"></i>Email</span>
                                          <a href="javascript:void(0);"
                                              class="float-end">{{ Auth::user()->email ?? '' }}</a>
                                      </li>
                                  </ul>

                              </div>
                          </div>

                      </div>
                      <div class="col-xxl-8 col-xl-6">
                          <div class="card border-top-0">

                              <div class="tab-content">
                                  <div class="tab-pane fade show active p-4" id="overviewTab" role="tabpanel">
                                      <div class="about-section mb-5">
                                          <div class="mb-4 d-flex align-items-center justify-content-between">
                                              <h5 class="fw-bold mb-0">Profile About:</h5>
                                              {{-- <a href="javascript:void(0);" class="btn btn-sm btn-light-brand">Updates</a> --}}
                                          </div>
                                          <p>Admin is a frontend developer with over 5 years of experience creating
                                              high-quality, user-friendly websites and web applications. He has a strong
                                              understanding of web development technologies and a keen eye for design.</p>
                                          <p>Admin is proficient in languages such as HTML, CSS, and JavaScript, and is
                                              experienced in using popular frontend frameworks such as React and Angular. He
                                              is also well-versed in user experience design and uses his knowledge to create
                                              engaging and intuitive user interfaces.</p>
                                          <p>Throughout his career, John has worked on a wide range of projects for clients
                                              in various industries, including e-commerce, healthcare, and education. He
                                              takes a collaborative approach to development and enjoys working closely with
                                              clients and other developers to bring their ideas to life.</p>
                                      </div>
                                      <div class="profile-details mb-5">
                                          <div class="mb-4 d-flex align-items-center justify-content-between">
                                              <h5 class="fw-bold mb-0">Profile Details:</h5>
                                              {{-- <a href="javascript:void(0);" class="btn btn-sm btn-light-brand">Edit
                                                  Profile</a> --}}
                                          </div>
                                          <form  id="profile" enctype="multipart/form-data">
                                            @csrf
                                              <div class="row g-0 mb-4">
                                                  <div class="col-sm-6 text-muted">Full Name:</div>
                                                  <div class="col-sm-6 fw-semibold text-capitalize">
                                                      <input type="text" name="name" class="form-control"
                                                          value="{{ Auth::user()->name }}">
                                                        <input type="hidden" name="id"  class="form-control" value="{{ Auth::user()->id }}">
                                                      <small class="text-danger error" id="name_error"></small>
                                                  </div>
                                              </div>
                                              <div class="row g-0 mb-4">
                                                  <div class="col-sm-6 text-muted">Mobile Number:</div>
                                                  <div class="col-sm-6 fw-semibold"> <input type="text" name="phone"
                                                          class="form-control" value="{{ Auth::user()->phone }}">
                                                      <small class="text-danger error" id="phone_error"></small>
                                                  </div>
                                              </div>
                                              <div class="row g-0 mb-4">
                                                  <div class="col-sm-6 text-muted">Email Address:</div>
                                                  <div class="col-sm-6 fw-semibold"> <input type="text" name="email"
                                                          class="form-control" value="{{ Auth::user()->email }}">
                                                      <small class="text-danger error" id="email_error"></small>
                                                  </div>
                                              </div>
                                              <div class="row g-0 mb-4">
                                                  <div class="col-sm-6 text-muted">Location:</div>
                                                  <div class="col-sm-6 fw-semibold"> <input type="text" name="address"
                                                          class="form-control" value="{{ Auth::user()->address }}">
                                                      <small class="text-danger error" id="address_error"></small>
                                                  </div>
                                              </div>
                                              <div class="row g-0 mb-4">
                                                  <div class="col-sm-6 text-muted">Profile Image:</div>
                                                  <div class="col-sm-6">
                                                      <input type="file" name="image" value="{{ Auth::user()->image }}" class="form-control">
                                                      <small class="text-danger error" id="image_error"></small>
                                                  </div>
                                              </div>
                                              <div class="row g-0 mb-4">
                                                  <div class="col-sm-6 text-muted"></div>
                                                  <div class="col-sm-6">
                                                      <input type="submit" name="submit" value="Update Profile"
                                                          class="form-control btn btn-primary w-50">
                                                  </div>
                                              </div>

                                      </div>
                                      <div class="alert alert-dismissible mb-4 p-4 d-flex alert-soft-warning-message profile-overview-alert"
                                          role="alert">
                                          <div class="me-4 d-none d-md-block">
                                              <i class="feather feather-alert-triangle fs-1"></i>
                                          </div>
                                          <div>
                                              <p class="fw-bold  text-truncate-1-line">Your profile has not been
                                                  updated yet!!!</p>
                                              <p class="fs-10 fw-medium text-uppercase text-truncate-1-line">Last Update:
                                                  <strong>{{ (Auth::user()->created_at ?? '')->format('d M Y') }}</strong>
                                              </p>
                                            
                                              <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                  aria-label="Close"></button>
                                          </div>
                                      </div>
                                      </form>

                                  </div>

                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <!-- [ Main Content ] end -->
          </div>
          <!-- [ Footer ] start -->
          @include('Admin.Pages.footer')
          <!-- [ Footer ] end -->
      </main>

         <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="{{ asset('ajax.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#profile').submit(function(e) {
                e.preventDefault();
                var data = $('#profile')[0];
                var formData = new FormData(data);
                $('.error').text('');
                let url = "{{ route('ProfilesUpdatePage') }}";
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
                                title: response.message || "Profile Updated Successfully"
                            });
                            setTimeout(function() {
                                window.location.href = "{{ route('ProfilesPage') }}";
                            }, 2000);

                        } else {
                            Toast.fire({
                                icon: "error",
                                title: response.message || "Profile Not Updated"
                            });
                        }
                        $('#profile')[0].reset();
                    },
                    function(error) {
                        console.log('error', error);
                    });
            });
               });
    </script>
  @endsection
