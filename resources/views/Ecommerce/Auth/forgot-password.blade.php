<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/fav.png">
    <!-- Author Meta -->
    <meta name="author" content="CodePixar">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->

    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Site Title -->
    <title>Karma Shop</title>

    <!--
  CSS
  ============================================= -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" />

    <link rel="stylesheet" href="{{ asset('css/linearicons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nouislider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ion.rangeSlider.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/ion.rangeSlider.skinFlat.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <style>
        .social-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 1px solid #070707;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            transition: all 0.3s ease;
            font-size: 16px;

        }

        .social-btn.facebook i {
            color: #1877f2;
        }

        .social-btn.google i {
            color: #db4437;
        }
    </style>
</head>

<body>
    <section class="login_box_area section_gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login_box_img">
                        <img class="img-fluid" src="{{ asset('img/login.jpg') }}" alt="">
                        <div class="hover">
                            <h4>Don't have an Account?</h4>
                            <p>There are advances being made in science and technology everyday, and a good example of
                                this is the</p>
                            {{-- <a class="primary-btn" href="{{ route('UserRegisterPage') }}">Create an Account</a> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login_form_inner">
                        <h3>Forgot Password</h3>
                        <form id="ForgotPasswordForm" class="row login_form" novalidate="novalidate">
                            @csrf
                            <div class="col-md-12 form-group">
                                <input type="email" class="form-control" name="email" placeholder="Email Address">
                                <small class="text-danger error" id="email_error"></small>
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="submit" class="primary-btn w-100" value="Send Reset Link">
                            </div>
                            <div class="col-md-12 mt-3 ">
                                <a href="{{ route('UserLoginPage') }}" style="color: #070707">Back to Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('ajax.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#ForgotPasswordForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $('.error').text('');
                var url = "{{ route('ForgotPasswordPage') }}";
                reusableAjaxCall(url, 'POST', formData, function(response) {
                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: response.message,
                            timer: 3000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = response.link;
                        });
                        $('#ForgotPasswordForm')[0].reset();
                    }
                }, function(error) {
                    if (error.responseJSON && error.responseJSON.errors) {
                        let errors = error.responseJSON.errors;
                        if (errors.email) {
                            $('#email_error').text(errors.email[0]);
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!'
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>
