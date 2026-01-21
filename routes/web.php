<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistsController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

Route::get('/index', function () {
    return view('Admin.Pages.index');
});


Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('DashboardPage');
Route::get('/', [AuthController::class, 'login'])->name('LoginPage');
Route::post('/admin/login', [AuthController::class, 'loginmatch'])->name('LoginMatchPage');

Route::get('/user/login', [AuthController::class, 'user_login'])->name('UserLoginPage');
Route::get('/user/register', [AuthController::class, 'user_register'])->name('UserRegisterPage');
Route::post('/user/registration', [AuthController::class, 'registration'])->name('RegistrationPage');
Route::post('/logout', [AuthController::class, 'logout'])->name('LogoutPage');

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



Route::get('/user/index', [HomeController::class, 'index'])->name('IndexPage');
Route::get('/user/home', [HomeController::class, 'home'])->name('HomePage');
Route::get('/user/product', [HomeController::class, 'products'])->name('UserProductPage');
Route::get('/user/product/{id}', [HomeController::class, 'product'])->name('UserCategoryProductPage');
Route::get('/user/category', [HomeController::class, 'category'])->name('UserCategoryPage');
Route::get('/user/peoduct-details/{id}', [HomeController::class, 'detail'])->name('UserProductdetailsPage');

Route::get('/user/confirm', [HomeController::class, 'confirm'])->name('UserConfirmPage');
Route::get('/user/blog', [HomeController::class, 'blog'])->name('UserBlogPage');
Route::get('/user/contact', [HomeController::class, 'contact'])->name('UserContactPage');
Route::get('/user/profile', [HomeController::class, 'profile'])->name('UserProfilePage');


Route::get('/user/wishlist', [WishlistsController::class, 'index'])->name('WishlistPage');
Route::post('/user/wishlist-toggle', [WishlistsController::class, 'toggle'])->name('WishlistStorePage');


Route::get('/user/cart', [CartController::class, 'cart'])->name('UserCartPage');
Route::post('/user/add-to-cart', [CartController::class, 'addtoCart'])->name('UserAddCartPage');
Route::get('/user/cart-delete/{id}', [CartController::class, 'delete'])->name('UserCartDeletePage');
Route::post('/user/cart/update-qty', [CartController::class, 'update'])
    ->name('UserCartUpdatePage');
    Route::get('/continue-shopping', [CartController::class, 'continueShopping'])
    ->name('UserContinueShopping');



Route::get('/user/checkout', [CheckOutController::class, 'checkout'])->name('UserCheckoutPage');
Route::post('/cart/store-grand-total', [CheckoutController::class, 'storeGrandTotal'])
    ->name('UserCheckoutTotalPage');

    
Route::post('/user/checkout', [OrderController::class, 'order'])->name('UserOrderPage');
