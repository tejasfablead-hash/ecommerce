<style>
    /* Right navbar items alignment */
    .navbar-right .nav-item {
        display: flex;
        align-items: center;
    }

    /* Bell wrapper */
    .notification-bell {
        position: relative;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        color: #333;
        cursor: pointer;
    }

    /* Bell icon */
    .notification-bell i {
        font-size: 16px;
        line-height: 1;
    }

    /* Badge – top right corner */
    .bell-badge {
        position: absolute;
        top: -3px;
        right: -3px;
        background: #ff3b3b;
        color: #fff;
        font-size: 9px;
        min-width: 16px;
        height: 16px;
        border-radius: 50%;
        display: none;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }

    /* Dropdown UI */
    .notification-dropdown {
        width: 280px;
        padding: 0;
        margin-top: 10px;
        border-radius: 6px;
    }

    .notification-dropdown .dropdown-header {
        font-weight: 600;
        padding: 10px;
        background-color:  #f8ba10;
    }

    .chat-notification-item {
        padding: 10px;
        cursor: pointer;
        border-bottom: 1px solid #f1f1f1;
    }

    .chat-notification-item:hover {
        background: #fafaf8;
       
    }
</style>
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
                                <li class="nav-item"><a class="nav-link logout-btn"
                                        data-redirect="{{ route('UserLoginPage') }}" href="javascript:void(0);">Sign
                                        Out </a></li>
                            </ul>
                        </li>

                    </ul>
                    <ul class="nav navbar-nav navbar-right prd-bottom">
                        <li class="nav-item dropdown">
    <a href="{{ route('ChatPage') }}"
       class="notification-bell"
       id="chatBell">

        <i class="ti-bell"></i>

        <!-- Badge -->
        <span id="chatNotify" class="bell-badge">0</span>
    </a>

    <!-- Dropdown -->
    <div class="dropdown-menu dropdown-menu-right notification-dropdown">
        <div class="dropdown-header text-center text-white">
            Messages
        </div>

        <div id="chatNotificationList">
            <p class="text-center text-muted m-2">No new messages</p>
        </div>
    </div>
</li>


                        <li class="nav-item pr-2">
                            @auth
                                <a href="{{ route('WishlistPage') }}" class="social-info wishlist-icon mt-1">
                                    <i class="ti-heart" style="color: black"></i>
                                    <span class="wishlist-count"></span>
                                </a>
                            @endauth

                            @guest
                                <a href="{{ route('UserLoginPage') }}" class="social-info wishlist-icon">
                                   <i class="ti-heart" style="color: black"></i>
                                </a>
                            @endguest
                        </li>
                        <li class="nav-item "><a href="{{ route('UserCartPage') }}" class="cart"><span
                                    class="ti-bag"></span></a></li>
                        <li class="nav-item pl-2">
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{ asset('ajax.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function () {
          $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
         });

         $(document).on('click', '.logout-btn', function(e) {
             e.preventDefault();
             let redirectUrl = $(this).data('redirect');
             var url = "{{ route('LogoutPage') }}"
             reusableAjaxCall(url, 'POST', null, function(response) {
                 console.log('response', response);
                 if (response.status == true) {
                     Swal.fire({
                         toast: true,
                         position: "top-end",
                         icon: "success",
                         title: response.message,
                         showConfirmButton: false,
                         timer: 3000
                     });
                     setTimeout(() => {
                         window.location.href = redirectUrl;
                     }, 1500);
                 }
             });
         });

    const AUTH_ID = {{ auth()->check() ? auth()->id() : 'null' }};

    function loadChatNotification() {
        if (!AUTH_ID) return;

        $.get("{{ route('ChatUnreadPage') }}", function(res) {
            if (res.count > 0) {
                $('#chatNotify').text(res.count).css('display', 'flex');

                loadChatMessagesList();
            } else {
                $('#chatNotify').hide();
                $('#chatNotificationList').html(
                    '<p class="text-center text-muted m-2">No new messages</p>'
                );
            }
        });
    }

    function loadChatMessagesList() {
        $.get("{{ route('ChatUnreadMessages') }}", function(data) {
            let html = '';

            if (data.length === 0) {
                html = '<p class="text-center text-muted m-2">No new messages</p>';
            } else {
                data.forEach(msg => {
                    html += `
                    <div class="chat-notification-item" data-id="${msg.id}">
                        <small>${msg.message}</small>
                    </div>
                `;
                });
            }

            $('#chatNotificationList').html(html);
        });
    }

    $(document).on('click', '.chat-notification-item', function() {
        if (typeof toggleChat === "function") {
            toggleChat();
        }
        $('#chatNotify').hide();
    });

    $(document).ready(function() {
        loadChatNotification();
        setInterval(loadChatNotification, 5000);
    });
        });
</script>
