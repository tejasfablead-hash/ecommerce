
<header class="header_area sticky-header">
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light main_box">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <a class="navbar-brand logo_h" href="{{ route('HomePage') }}"><img src="{{ asset('img/logo.png') }}"
                        alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav ml-auto">
                       <li class="nav-item"><a class="nav-link" href="{{ route('UserProductPage') }}">Product
                                       </a></li>
                        {{-- <li class="nav-item active"><a class="nav-link" href="{{route('HomePage')}}">Home</a></li> --}}
                        <li class="nav-item submenu dropdown">
                             
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-haspopup="true" aria-expanded="false">Shop</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="nav-link" href="{{ route('UserCategoryPage') }}">Shop
                                        Category</a></li>
                                          <li class="nav-item"><a class="nav-link" href="{{ route('WishlistPage') }}">
                                        Wishlist</a></li>
                                        <li class="nav-item"><a class="nav-link" href="{{ route('UserCartPage') }}">Shopping
                                                Cart</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('UserCheckoutPage') }}">Product
                                        Checkout</a></li>
                                <li class="nav-item"><a class="nav-link"
                                        href="{{ route('UserConfirmPage') }}">Confirmation</a></li>
                            </ul>
                        </li>
                      
                        <li class="nav-item submenu dropdown">
                            <a href="{{ route('UserContactPage') }}" class="nav-link dropdown-toggle" role="button"
                                aria-haspopup="true" aria-expanded="false">Contact</a>
                        </li>


                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-haspopup="true" aria-expanded="false">Profile</a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class="nav-link"
                                        href="{{ route('UserProfilePage') }}">Profile</a></li>
                                <li class="nav-item"><a class="nav-link" id="logout" href="javascript:void(0);">Sign
                                        Out </a></li>
                            </ul>
                        </li>

                    </ul>
                    <ul class="nav navbar-nav navbar-right prd-bottom">

                        <li class="nav-item">
                            @auth
                                <a href="{{ route('WishlistPage') }}" class="social-info wishlist-icon">
                                    <span class="lnr lnr-heart"></span>
                                        <span class="wishlist-count"></span>
                                </a>
                            @endauth

                            @guest
                                <a href="{{ route('UserLoginPage') }}" class="social-info wishlist-icon">
                                    <span class="lnr lnr-heart"></span>
                                </a>
                            @endguest
                        </li>
                        <li class="nav-item"><a href="{{ route('UserCartPage') }}" class="cart"><span class="ti-bag"></span></a></li>
                        <li class="nav-item">
                            <button class="search"><span class="lnr lnr-magnifier" id="search"></span></button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="search_input" id="search_input_box">
        <div class="container">
            <form class="d-flex justify-content-between">
                <input type="text" class="form-control" id="search_input" placeholder="Search Here">
                <button type="submit" class="btn"></button>
                <span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
            </form>
        </div>
    </div>
</header>


<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script src="{{ asset('ajax.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#logout').click(function(e) {
            e.preventDefault();
            var url = "{{ route('LogoutPage') }}"
            reusableAjaxCall(url, 'POST', null, function(response) {
                console.log('response', response);
                if (response.status == true) {
                    window.location.href = "/user/login";
                }
            });
        });
    });
</script>
