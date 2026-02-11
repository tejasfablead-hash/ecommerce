<?php

use App\Http\Controllers\AdminPasswordController;
use App\Http\Controllers\AIChatController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\ScraperController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\UserChatController;
use App\Http\Controllers\WishlistsController;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Route;

Route::get('/index', function () {
    return view('Admin.Pages.index');
});

Route::get('/', [AuthController::class, 'login'])->name('LoginPage');
Route::post('/login', [AuthController::class, 'loginmatch'])->name('LoginMatchPage');

Route::get('/user/login', [AuthController::class, 'user_login'])->name('UserLoginPage');
Route::get('/user/register', [AuthController::class, 'user_register'])->name('UserRegisterPage');
Route::post('/user/registration', [AuthController::class, 'registration'])->name('RegistrationPage');

Route::post('/logout', [AuthController::class, 'logout'])->name('LogoutPage');
Route::get('/user/index', [HomeController::class, 'index'])->name('IndexPage');

Route::get('/auth/google', [SocialLoginController::class, 'redirect'])->name('GoggleLoginPage');
Route::get('/auth/google/callback', [SocialLoginController::class, 'callback']);


Route::get('admin/forgot-password', [AdminPasswordController::class, 'index'])->name('AdminForgotPage');
Route::post('admin/forgot-password', [AdminPasswordController::class, 'forgotPassword'])->name('AdminForgotPasswordPage');

Route::get('admin/reset-password/{token}', [AdminPasswordController::class, 'showResetForm'])->name('AdminResetPasswordPage');
Route::post('admin/reset-password', [AdminPasswordController::class, 'resetPassword'])->name('AdminResetPasswordPostPage');


Route::get('forgot-password', [PasswordController::class, 'showForgotForm'])->name('ForgotPage');
Route::post('forgot-password', [PasswordController::class, 'sendResetLink'])->name('ForgotPasswordPage');

Route::get('reset-password/{token}', [PasswordController::class, 'showResetForm'])->name('ResetPasswordPage');
Route::post('reset-password', [PasswordController::class, 'resetPassword'])->name('ResetPasswordPostPage');


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('DashboardPage');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('ProfilesPage');
    Route::post('/profile-update', [DashboardController::class, 'update'])->name('ProfilesUpdatePage');
    Route::get('/category', [CategoryController::class, 'index'])->name('CategoryPage');
    Route::post('/category-add', [CategoryController::class, 'store'])->name('CategoryAddPage');
    Route::get('/category-view', [CategoryController::class, 'view'])->name('CategoryViewPage');
    Route::get('/category-edit/{id}', [CategoryController::class, 'edit'])->name('CategoryEditPage');
    Route::post('/category-update', [CategoryController::class, 'Update'])->name('CategoryUpdatePage');
    Route::delete('/category-delete/{id}', [CategoryController::class, 'delete'])
        ->name('CategoryDeletePage');


    Route::get('/product', [ProductController::class, 'index'])->name('ProductPage');
    Route::post('/product-add', [ProductController::class, 'store'])->name('ProductAddPage');
    Route::get('/product-view', [ProductController::class, 'view'])->name('ProductViewPage');
    Route::get('/product-edit/{id}', [ProductController::class, 'edit'])->name('ProductEditPage');
    Route::get('/product-details/{id}', [ProductController::class, 'detail'])->name('ProductDetailsPage');
    Route::post('/product-update', [ProductController::class, 'Update'])->name('ProductUpdatePage');
    Route::delete('/product-delete/{id}', [ProductController::class, 'delete'])->name('ProductDeletePage');
    Route::get('/wishlist', [WishlistsController::class, 'view'])->name('WishlistViewPage');

    Route::get('/customer', [OrderController::class, 'customer'])->name('CustomerPage');
    Route::get('/order-view', [OrderController::class, 'view'])->name('OrderViewPage');
    Route::post('/order-status', [OrderController::class, 'updateorder'])->name('OrderUpdateOrderPage');
    Route::get('/order-details/{id}', [OrderController::class, 'details'])->name('OrderDetailViewPage');
    Route::get('/orders/notifications', [OrderController::class, 'getNotifications'])->name('OrdernotificationsPage');

    Route::get('/chat', [DashboardController::class, 'chat'])->name('AdminChatPage');
    Route::get('/chat/{chatId}', [DashboardController::class, 'show'])->name('AdminchatShow');
    Route::post('/chat/send', [DashboardController::class, 'send'])->name('AdminchatSend');
    Route::get('/chat/unread-count', [DashboardController::class, 'unreadCount']);
    Route::post('/chat/update', [DashboardController::class, 'updatechat'])
        ->name('AdminchatUpdate');
    Route::post('/chat/delete', [DashboardController::class, 'delete'])
        ->name('AdminchatDelete');
    Route::get('/search', [DashboardController::class, 'Search'])->name('AdminSearch');
    Route::get('/view-feedback', [ProfileController::class, 'viewfeedback'])->name('FeedbackviewPage');


    Route::get('/event', [EventController::class, 'index'])->name('EventPage');
    Route::post('/calendar', [EventController::class, 'store'])->name('EventStorePage');
    Route::get('/events/fetch', [EventController::class, 'fetchEvents'])->name('EventFetchPage');

    Route::get('/scrape-product', [ScraperController::class, 'index'])->name('Scrapepage');
    Route::post('/scrape-products', [ScraperController::class, 'scrapeProducts'])->name('ScrapeproductPage');
});

Route::middleware(['auth', 'user'])->group(function () {

    Route::get('/user/home', [HomeController::class, 'home'])->name('HomePage');
    Route::get('/user/contact', [HomeController::class, 'contact'])->name('UserContactPage');

    Route::get('/user/category', [CategoryController::class, 'category'])->name('UserCategoryPage');

    Route::get('/user/product/{id}', [ProductController::class, 'product'])->name('UserCategoryProductPage');
    Route::get('/user/peoduct-details/{id}', [ProductController::class, 'productdetail'])->name('UserProductdetailsPage');
    Route::get('/user/product', [ProductController::class, 'products'])->name('UserProductPage');

    Route::get('/user/wishlist', [WishlistsController::class, 'index'])->name('WishlistPage');
    Route::post('/user/wishlist-toggle', [WishlistsController::class, 'toggle'])->name('WishlistStorePage');
    Route::get('/user/wishlist-count', [WishlistsController::class, 'count'])
        ->name('UserWishlistCount');

    Route::get('/user/cart', [CartController::class, 'cart'])->name('UserCartPage');
    Route::post('/user/add-to-cart', [CartController::class, 'addtoCart'])->name('UserAddCartPage');
    Route::get('/user/cart-count', [CartController::class, 'cartCount'])
        ->name('UserCartCount');
    Route::get('/user/cart-delete/{id}', [CartController::class, 'delete'])->name('UserCartDeletePage');
    Route::post('/user/cart/update-qty', [CartController::class, 'update'])
        ->name('UserCartUpdatePage');
    Route::get('/continue-shopping', [CartController::class, 'continueShopping'])
        ->name('UserContinueShopping');

    Route::get('/user/checkout', [CheckOutController::class, 'checkout'])->name('UserCheckoutPage');
    Route::post('/cart/store-grand-total', [CheckoutController::class, 'storeGrandTotal'])
        ->name('UserCheckoutTotalPage');
    Route::post('/user/checkout', [OrderController::class, 'order'])->name('UserOrderPage');
    Route::get('/order-pdf/{id}', [OrderController::class, 'downloadOrderPdf'])
        ->name('UserOrderPdf');
    Route::post('/order/cod', [OrderController::class, 'placeCODOrder'])
        ->name('CODOrderPlace');

    Route::post('/paypal/success', [PaypalController::class, 'success'])
        ->name('PaypalSuccessPage');
    Route::get('/user/confirm', [PaypalController::class, 'confirm'])->name('UserConfirmPage');
    Route::get('/user/order-view/{id}', [PaypalController::class, 'confirmview'])->name('UserConfirmViewPage');

    Route::post('/razorpay/order', [RazorpayController::class, 'createRazorpayOrder'])
        ->name('Razorpayorder');
    Route::post('/razorpay/success', [RazorpayController::class, 'razorpaySuccess'])
        ->name('Razorpaysuccess');
    Route::post('/stripe/create-session', [StripeController::class, 'createSession'])
        ->name('stripe.create');
    Route::get('/stripe/success', [StripeController::class, 'success'])
        ->name('stripe.success');
        
    Route::get('/stripe/cancel', [StripeController::class, 'cancel'])->name('stripe.cancel');
    // Route::post('/stripe/webhook', [StripeController::class, 'handle']);


    Route::get('/user/profile', [ProfileController::class, 'profile'])->name('UserProfilePage');
    Route::post('/user/update-profile', [ProfileController::class, 'update'])->name('UserEditProfilePage');
    Route::post('/user/update-feedback', [ProfileController::class, 'feedback'])->name('UserFeedbackPage');

    Route::get('/user/chat', [UserChatController::class, 'index'])->name('ChatPage');;
    Route::get('/user/chat/messages', [UserChatController::class, 'fetchMessages'])->name('ChaFatchMessagePage');
    Route::post('/user/chat/send', [UserChatController::class, 'sendMessage'])->name('ChaSendMessagePage');
    Route::get('/user/chat/unread-count', [UserChatController::class, 'unreadCount'])->name('ChatUnreadPage');
    Route::get('/user/chat/unread-messages', [UserChatController::class, 'unreadMessages'])->name('ChatUnreadMessages');

    Route::post('/ai/chat', [AIChatController::class, 'ask']);
    Route::get('/weather', [ApiController::class, 'weather']);
});
