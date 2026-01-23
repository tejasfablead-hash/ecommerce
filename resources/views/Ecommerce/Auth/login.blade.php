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

    <!--================Login Box Area =================-->
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
                            <a class="primary-btn" href="{{ route('UserRegisterPage') }}">Create an Account</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login_form_inner">
                        <h3>Log in to enter</h3>
                        <form class="row login_form" action="" method="" id="Loginform"
                            novalidate="novalidate">
                            @csrf
                            <div class="col-md-12 form-group">
                                <input type="email" class="form-control" name="email" placeholder="Email Address">
                                <small class="text-danger error" id="email_error"></small>
                            </div>

                            <div class="col-md-12 form-group">
                                <input type="password" class="form-control" name="password" placeholder="Password">
                                <small class="text-danger error" id="password_error"></small>
                            </div>
                            <div class="col-md-12 form-group">
                                <div class="d-flex align-items-center justify-content-between">

                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="rememberMe">
                                        <label class="custom-control-label" for="rememberMe">
                                            Remember Me
                                        </label>
                                    </div>
                                    <a href="" class="text-dark mb-3">
                                        Forgot password?
                                    </a>

                                </div>
                            </div>

                            <div class="col-md-12 form-group">
                                <input type="submit" class="primary-btn w-100" value="Login">
                            </div>

                        </form>
                        <br>
                        <div class="d-flex justify-content-center align-item-center gap-4">
                            <!-- Facebook -->
                            <a href="" class="social-btn facebook" title="Login with Facebook">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            &nbsp;
                            &nbsp;
                            &nbsp;
                            &nbsp;
                            &nbsp;
                            <!-- Google -->
                            <a href="{{route('GoggleLoginPage')}}" class="social-btn google" title="Login with Google">
                                <i class="fa-brands fa-google"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Login Box Area =================-->



    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('ajax.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('#Loginform').submit(function(e) {
                e.preventDefault();

                var data = $('#Loginform')[0];
                var formData = new FormData(data);
                $('.error').text('');
                var url = "{{ route('LoginMatchPage') }}";
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
                                title: response.message || "Login successfully"
                            });
                            setTimeout(function() {
                                window.location.href = "{{ route('HomePage') }}";
                            }, 2000);

                        } else {
                            Toast.fire({
                                icon: "error",
                                title: response.message || "Something went wrong"
                            });
                            $('#Loginform')[0].reset();
                        }
                    },
                    function(error) {
                        console.log('error', error);
                    });
            });

        });
    </script>
</body>

</html>
