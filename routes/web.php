<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    BrandController,
    Brand2Controller,
    CategoryController,
    Category2Controller,
    DashboardController,
    ProductController,
    Product2Controller,
    UserController,
    CustomerController,
    OrderController,
    ReportController,
    OrderitemController
};
use App\Http\Controllers\Client\{
    HomeController,
    CartController,
    CategoryClientController,
    ProductClientController,
    BrandClientController,
    AboutController,
    CheckoutController,
    CouponController
};
use App\Http\Controllers\ReviewController;

// ===============================
// CLIENT ROUTES
// ===============================

// Trang chủ
// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home')->name('homepage');


// Giỏ hàng
Route::post('/cart/update-qty/{id}', [CartController::class, 'updateQty'])->name('cart.updateQty');
Route::post('/cartadd/{id}', [CartController::class, 'add'])->name('cartadd');
Route::get('/cartdel/{id}', [CartController::class, 'del'])->name('cartdel');
Route::post('/cartsave', [CartController::class, 'save'])->name('cartsave');
Route::get('/cartshow', fn() => view('client.cart.cartshow'))->name('cartshow');
Route::get('/cartcheckout', fn() => view('client.cart.checkout'))->name('checkout');

// Danh mục / thương hiệu / sản phẩm
Route::get('/category/{id}', [CategoryClientController::class, 'detail'])->name('category');
Route::get('/brand/{id}', [BrandClientController::class, 'detail'])->name('brand');

Route::prefix('products')->name('client.products.')->group(function () {
    Route::get('/', [ProductClientController::class, 'index'])->name('index');
    Route::get('/detail/{id}', [ProductClientController::class, 'detail'])->name('detail');
    Route::get('/search', [ProductClientController::class, 'search'])->name('search');
});

// Đánh giá sản phẩm
Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('products.reviews.store');

// About pages
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/about/team', [AboutController::class, 'team'])->name('about.team');
Route::get('/about/contact', [AboutController::class, 'contact'])->name('about.contact');

// Checkout
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');
    Route::get('/momo-payment/{orderId}', [CheckoutController::class, 'momoPayment'])->name('momo-payment');
    Route::post('/confirm-momo/{orderId}', [CheckoutController::class, 'confirmMomoPayment'])->name('confirm-momo');
    Route::get('/check-payment/{orderId}', [CheckoutController::class, 'checkPaymentStatus'])->name('check-payment-status');
    Route::get('/success/{orderId}', [CheckoutController::class, 'success'])->name('success');
});

// Coupon
Route::prefix('coupon')->name('coupon.')->group(function () {
    Route::post('/apply', [CouponController::class, 'apply'])->name('apply');
    Route::post('/remove', [CouponController::class, 'remove'])->name('remove');
});

// ===============================
// ADMIN ROUTES
// ===============================

// Đăng nhập, quên mật khẩu, reset
Route::get('/admin/login', [UserController::class, 'login'])->name('ad.login');
Route::post('/admin/login', [UserController::class, 'loginpost'])->name('ad.loginpost');
Route::get('/admin/forgotpass', [UserController::class, 'forgotpassform'])->name('ad.forgotpass');
Route::post('/admin/forgotpass', [UserController::class, 'forgotpass'])->name('ad.forgotpasspost');
Route::get('/admin/resetpass/{id}', [UserController::class, 'showResetForm'])->name('ad.reset.form');
Route::post('/admin/resetpass/{id}', [UserController::class, 'handleReset'])->name('ad.reset');

// Khu vực quản trị chính
Route::middleware(['auth'])->prefix('admin')->name('ad.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout & đổi mật khẩu
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/changepass', [UserController::class, 'showChangePassForm'])->name('changepass.form');
    Route::post('/changepass', [UserController::class, 'changepass'])->name('changepass');

    // Báo cáo
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/revenue', [ReportController::class, 'revenue'])->name('report.revenue');

    // Customer
    Route::resource('customers', CustomerController::class);

    // Order
    Route::resource('orders', OrderController::class);
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Order items
    Route::resource('orderitems', OrderitemController::class);

    // Category CRUD
    Route::prefix('categories')->name('cate.')->middleware('roles:1')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::post('/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [CategoryController::class, 'delete'])->name('delete');
    });

    // Category2 CRUD
    Route::prefix('categories-2')->name('cate2.')->middleware('roles:1')->group(function () {
        Route::get('/', [Category2Controller::class, 'index'])->name('index');
        Route::get('/create', [Category2Controller::class, 'create'])->name('create');
        Route::post('/store', [Category2Controller::class, 'store'])->name('store');
        Route::get('/{id}/edit', [Category2Controller::class, 'edit'])->name('edit');
        Route::post('/{id}', [Category2Controller::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [Category2Controller::class, 'delete'])->name('delete');
    });

    // Brand CRUD
    Route::prefix('brands')->name('brand.')->middleware('roles:1')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('index');
        Route::get('/create', [BrandController::class, 'create'])->name('create');
        Route::post('/store', [BrandController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [BrandController::class, 'edit'])->name('edit');
        Route::post('/{id}', [BrandController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [BrandController::class, 'delete'])->name('delete');
    });

    // Brand2 CRUD
    Route::prefix('brands-2')->name('brand2.')->middleware('roles:1')->group(function () {
        Route::get('/', [Brand2Controller::class, 'index'])->name('index');
        Route::get('/create', [Brand2Controller::class, 'create'])->name('create');
        Route::post('/store', [Brand2Controller::class, 'store'])->name('store');
        Route::get('/{id}/edit', [Brand2Controller::class, 'edit'])->name('edit');
        Route::post('/{id}', [Brand2Controller::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [Brand2Controller::class, 'delete'])->name('delete');
    });

    // Product CRUD
    Route::prefix('products')->name('pro.')->middleware('roles:1')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::post('/{id}', [ProductController::class, 'update'])->name('update');
        Route::post('/{id}/delete', [ProductController::class, 'delete'])->name('delete');
    });

    // Product2 CRUD
    Route::prefix('products-2')->name('pro2.')->middleware('roles:1')->group(function () {
        Route::get('/', [Product2Controller::class, 'index'])->name('index');
        Route::get('/create', [Product2Controller::class, 'create'])->name('create');
        Route::post('/store', [Product2Controller::class, 'store'])->name('store');
        Route::get('/{id}/edit', [Product2Controller::class, 'edit'])->name('edit');
        Route::post('/{id}', [Product2Controller::class, 'update'])->name('update');
        Route::post('/{id}/delete', [Product2Controller::class, 'delete'])->name('delete');
    });

    // User CRUD
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
});
