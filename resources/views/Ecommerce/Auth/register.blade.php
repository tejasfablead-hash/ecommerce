<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Karma Shop | Register</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <style>
        .login_form_inner h3 {
            margin-bottom: 30px;
        }

        .login_form .form-control {
            height: 45px;
        }

        .error {
            font-size: 13px;
        }
    </style>
</head>

<body>

    <!--================Register Box Area =================-->
    <section class="login_box_area section_gap">
        <div class="container">
            <div class="row ">

                <!-- LEFT IMAGE -->
                <div class="col-lg-6">
                    <div class="login_box_img">
                        <img class="img-fluid" src="{{ asset('img/login.jpg') }}" alt="">
                        <div class="hover">
                            <h4>Already have an account?</h4>
                            <p>Login to continue shopping with us</p>
                            <a class="primary-btn" href="{{ route('UserLoginPage') }}">Login</a>
                        </div>
                    </div>
                </div>

                <!-- REGISTER FORM -->
                <div class="col-lg-6">
                    <div class="login_form_inner">
                        <h3>Create an Account</h3>

                        <form class="row login_form" id="registerForm" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" name="username" placeholder="Username">
                                <small class="text-danger error" id="username_error"></small>
                            </div>

                            <div class="col-md-12 form-group">
                                <input type="email" class="form-control" name="email" placeholder="Email Address">
                                <small class="text-danger error" id="email_error"></small>
                            </div>

                            <div class="col-md-12 form-group">
                                <input type="password" class="form-control" name="password" placeholder="Password">
                                <small class="text-danger error" id="password_error"></small>
                            </div>

                            <div class="col-md-12 form-group">
                                <input type="password" class="form-control" name="password_confirmation"
                                    placeholder="Confirm Password">
                                <small class="text-danger error" id="password_confirmation_error"></small>
                            </div>

                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" name="phone" placeholder="Phone Number">
                                <small class="text-danger error" id="phone_error"></small>
                            </div>

                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" name="address" placeholder="Address">
                                <small class="text-danger error" id="address_error"></small>
                            </div>

                            <div class="col-md-12 form-group">
                                <input type="file" class="form-control" name="image">
                                <small class="text-danger error" id="image_error"></small>
                            </div>

                            <div class="col-md-12 form-group">
                                <div class="creat_account">
                                    <input type="checkbox" id="terms">
                                    <label for="terms">
                                        I agree to the Terms & Conditions
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-12 form-group">
                                <input type="submit" class="primary-btn w-100" value="Register">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--================End Register Box Area =================-->

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/vendor/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('ajax.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('#registerForm').submit(function(e) {
                e.preventDefault();

                var data = $('#registerForm')[0];
                var formData = new FormData(data);
                $('.error').text('');
                var url = "{{ route('RegistrationPage') }}";
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
                                title: response.message || "Registration successfully"
                            });
                            setTimeout(function() {
                                window.location.href = "{{ route('UserLoginPage') }}";
                            }, 2000);

                        } else {
                            Toast.fire({
                                icon: "error",
                                title: response.message || "Something went wrong"
                            });
                            $('#registerForm')[0].reset();
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
