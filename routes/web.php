<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    BrandController, Brand2Controller, CategoryController, Category2Controller,
    DashboardController, ProductController, Product2Controller,
    UserController, CustomerController, OrderController, ReportController, OrderitemController
};
use App\Http\Controllers\Client\{
    HomeController, CartController, CategoryClientController, ProductClientController,
    BrandClientController, AboutController, CheckoutController, CouponController, AuthController
};
use App\Http\Controllers\ReviewController;

// ===============================
// CLIENT ROUTES

// ---- Aliases for homepage/home to avoid missing route errors ----
Route::get('/', [HomeController::class, 'index'])->name('homepage');
Route::get('/home', function () { return redirect()->route('homepage'); })->name('home');

// ===============================

// Trang chủ


// Đăng ký / đăng nhập client
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Giỏ hàng
Route::prefix('cart')->group(function () {
    Route::post('/update-qty/{id}', [CartController::class, 'updateQty'])->name('cart.updateQty');
    Route::post('/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/delete/{id}', [CartController::class, 'del'])->name('cart.del');
    Route::post('/save', [CartController::class, 'save'])->name('cart.save');
    Route::get('/show', fn() => view('client.cart.cartshow'))->name('cart.show');
    Route::get('/checkout', fn() => view('client.cart.checkout'))->name('cart.checkout');
});

// Danh mục / thương hiệu / sản phẩm




// ---- Compatibility single routes expected by Blade components ----
Route::get('/category/{id}', [CategoryClientController::class, 'detail'])->name('category'); // legacy name
Route::get('/brand/{id}', [BrandClientController::class, 'detail'])->name('brand'); // legacy name

Route::prefix('products')->name('client.products.')->group(function () {
    
    Route::get('/detail/{id}', [ProductClientController::class, 'detail'])->name('detail');
    Route::get('/search', [ProductClientController::class, 'search'])->name('search');
    Route::post('/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// About pages
Route::prefix('about')->group(function () {
    
    Route::get('/team', [AboutController::class, 'team'])->name('about.team');
    Route::get('/contact', [AboutController::class, 'contact'])->name('about.contact');
});

// Checkout
Route::prefix('checkout')->name('checkout.')->group(function () {
    
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

// Đăng nhập / reset mật khẩu admin
Route::prefix('admin')->group(function () {
    Route::get('/login', [UserController::class, 'login'])->name('ad.login');
    Route::post('/login', [UserController::class, 'loginpost'])->name('ad.loginpost');
    Route::get('/forgotpass', [UserController::class, 'forgotpassform'])->name('ad.forgotpass');
    Route::post('/forgotpass', [UserController::class, 'forgotpass'])->name('ad.forgotpasspost');
    Route::get('/resetpass/{id}', [UserController::class, 'showResetForm'])->name('ad.reset.form');
    Route::post('/resetpass/{id}', [UserController::class, 'handleReset'])->name('ad.reset');
});

// Admin area (cần đăng nhập)
Route::middleware(['auth'])->prefix('admin')->name('ad.')->group(function () {

    // Dashboard & logout
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/changepass', [UserController::class, 'showChangePassForm'])->name('changepass.form');
    Route::post('/changepass', [UserController::class, 'changepass'])->name('changepass');

    // Báo cáo
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/revenue', [ReportController::class, 'revenue'])->name('report.revenue');

    // Customer / Orders / Order Items
    Route::resource('customers', CustomerController::class);
    Route::resource('orders', OrderController::class);
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::resource('orderitems', OrderitemController::class);

    // Category CRUD
    Route::prefix('categories')->name('cate.')->middleware('roles:1')->group(function () {
        
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::post('/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [CategoryController::class, 'delete'])->name('delete');
    });

    // Category2 CRUD (đã chuẩn hóa thành ad.cate2.*)
    Route::prefix('categories-2')->name('cate2.')->middleware('roles:1')->group(function () {
        
        Route::get('/create', [Category2Controller::class, 'create'])->name('create');
        Route::post('/store', [Category2Controller::class, 'store'])->name('store');
        Route::get('/{id}/edit', [Category2Controller::class, 'edit'])->name('edit');
        Route::post('/{id}', [Category2Controller::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [Category2Controller::class, 'delete'])->name('delete');
    });

    // Brand CRUD
    Route::prefix('brands')->name('brand.')->middleware('roles:1')->group(function () {
        
        Route::get('/create', [BrandController::class, 'create'])->name('create');
        Route::post('/store', [BrandController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [BrandController::class, 'edit'])->name('edit');
        Route::post('/{id}', [BrandController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [BrandController::class, 'delete'])->name('delete');
    });

    // Brand2 CRUD
    Route::prefix('brands-2')->name('brand2.')->middleware('roles:1')->group(function () {
        
        Route::get('/create', [Brand2Controller::class, 'create'])->name('create');
        Route::post('/store', [Brand2Controller::class, 'store'])->name('store');
        Route::get('/{id}/edit', [Brand2Controller::class, 'edit'])->name('edit');
        Route::post('/{id}', [Brand2Controller::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [Brand2Controller::class, 'delete'])->name('delete');
    });

    // Product CRUD
    Route::prefix('products')->name('pro.')->middleware('roles:1')->group(function () {
        
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::post('/{id}', [ProductController::class, 'update'])->name('update');
        Route::post('/{id}/delete', [ProductController::class, 'delete'])->name('delete');
    });

    // Product2 CRUD
    Route::prefix('products-2')->name('pro2.')->middleware('roles:1')->group(function () {
        
        Route::get('/create', [Product2Controller::class, 'create'])->name('create');
        Route::post('/store', [Product2Controller::class, 'store'])->name('store');
        Route::get('/{id}/edit', [Product2Controller::class, 'edit'])->name('edit');
        Route::post('/{id}', [Product2Controller::class, 'update'])->name('update');
        Route::post('/{id}/delete', [Product2Controller::class, 'delete'])->name('delete');
    });

    // User
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
});


// ---- Aliases without 'ad.' prefix for categories-2 (to match views using cate2.*) ----
Route::middleware(['auth','roles:1'])->prefix('admin')->group(function () {
    Route::get('/categories-2', [Category2Controller::class, 'index'])->name('cate2.index');
    Route::get('/categories-2/create', [Category2Controller::class, 'create'])->name('cate2.create');
    Route::post('/categories-2/store', [Category2Controller::class, 'store'])->name('cate2.store');
    Route::get('/categories-2/{id}/edit', [Category2Controller::class, 'edit'])->name('cate2.edit');
    Route::post('/categories-2/{id}', [Category2Controller::class, 'update'])->name('cate2.update');
    Route::delete('/categories-2/{id}/delete', [Category2Controller::class, 'delete'])->name('cate2.delete');
});




// ---- Aliases without 'ad.' for categories (cate.*) ----
Route::middleware(['auth','roles:1'])->prefix('admin')->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('cate.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('cate.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('cate.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('cate.edit');
    Route::post('/categories/{id}', [CategoryController::class, 'update'])->name('cate.update');
    Route::delete('/categories/{id}/delete', [CategoryController::class, 'delete'])->name('cate.delete');
});



// ---- Aliases without 'ad.' for brands (brand.*) ----
Route::middleware(['auth','roles:1'])->prefix('admin')->group(function () {
    Route::get('/brands', [BrandController::class, 'index'])->name('brand.index');
    Route::get('/brands/create', [BrandController::class, 'create'])->name('brand.create');
    Route::post('/brands/store', [BrandController::class, 'store'])->name('brand.store');
    Route::get('/brands/{id}/edit', [BrandController::class, 'edit'])->name('brand.edit');
    Route::post('/brands/{id}', [BrandController::class, 'update'])->name('brand.update');
    Route::delete('/brands/{id}/delete', [BrandController::class, 'delete'])->name('brand.delete');
});



// ---- Aliases without 'ad.' for brands-2 (brand2.*) ----
Route::middleware(['auth','roles:1'])->prefix('admin')->group(function () {
    Route::get('/brands-2', [Brand2Controller::class, 'index'])->name('brand2.index');
    Route::get('/brands-2/create', [Brand2Controller::class, 'create'])->name('brand2.create');
    Route::post('/brands-2/store', [Brand2Controller::class, 'store'])->name('brand2.store');
    Route::get('/brands-2/{id}/edit', [Brand2Controller::class, 'edit'])->name('brand2.edit');
    Route::post('/brands-2/{id}', [Brand2Controller::class, 'update'])->name('brand2.update');
    Route::delete('/brands-2/{id}/delete', [Brand2Controller::class, 'delete'])->name('brand2.delete');
});



// ---- Aliases without 'ad.' for products (pro.*) ----
Route::middleware(['auth','roles:1'])->prefix('admin')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('pro.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('pro.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('pro.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('pro.edit');
    Route::post('/products/{id}', [ProductController::class, 'update'])->name('pro.update');
    Route::post('/products/{id}/delete', [ProductController::class, 'delete'])->name('pro.delete');
});



// ---- Aliases without 'ad.' for products-2 (pro2.*) ----
Route::middleware(['auth','roles:1'])->prefix('admin')->group(function () {
    Route::get('/products-2', [Product2Controller::class, 'index'])->name('pro2.index');
    Route::get('/products-2/create', [Product2Controller::class, 'create'])->name('pro2.create');
    Route::post('/products-2/store', [Product2Controller::class, 'store'])->name('pro2.store');
    Route::get('/products-2/{id}/edit', [Product2Controller::class, 'edit'])->name('pro2.edit');
    Route::post('/products-2/{id}', [Product2Controller::class, 'update'])->name('pro2.update');
    Route::post('/products-2/{id}/delete', [Product2Controller::class, 'delete'])->name('pro2.delete');
});
