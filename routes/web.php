<?php
// trigger artisan cache clear

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\Brand2Controller;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\Category2Controller;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\Product2Controller;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Client\CategoryClientController;
use App\Http\Controllers\Client\ProductClientController;
use App\Http\Controllers\Client\BrandClientController;
use App\Http\Controllers\Client\AboutController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\CouponController;
use App\Http\Controllers\ReviewController;

use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Client\AuthController;
//Cart
Route::get('/cart/delete/{key}', [CartController::class, 'del'])->name('cartdel');
Route::post('/cart/update/{key}', [CartController::class, 'updateQty'])->name('cart.updateQty');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');

// Xử lý gửi dữ liệu đăng ký
Route::post('/register', [AuthController::class, 'register'])->name('register');

// đánh giá sao
Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])
    ->name('products.reviews.store');

//check login client
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index']);
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/revenue', [ReportController::class, 'revenue'])->name('report.revenue');
});



Route::middleware(['web', 'auth'])
    ->prefix('admin')
    ->name('ad.')
    ->group(function () {
        // Resource CRUD cho đơn hàng
        Route::resource('orders', OrderController::class);

        // Route tùy chỉnh để cập nhật trạng thái
        Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');
    });


// ============================================
// THÊM VÀO CUỐI FILE routes/web.php
// ============================================

// ROUTES CHO CHECKOUT - THANH TOÁN
Route::prefix('checkout')->name('checkout.')->group(function () {
    // Trang điền thông tin đặt hàng
    Route::get('/', [CheckoutController::class, 'index'])->name('index');

    // Xử lý đặt hàng (submit form)
    Route::post('/process', [CheckoutController::class, 'process'])->name('process');

    // Trang hiển thị QR MoMo
    Route::get('/momo-payment/{orderId}', [CheckoutController::class, 'momoPayment'])
        ->name('momo-payment');


    // Xác nhận đã thanh toán MoMo
    Route::post('/confirm-momo/{orderId}', [CheckoutController::class, 'confirmMomoPayment'])->name('confirm-momo');

    // Kiểm tra trạng thái thanh toán (AJAX)
    Route::get('/check-payment/{orderId}', [CheckoutController::class, 'checkPaymentStatus'])->name('check-payment-status');

    // Trang đặt hàng thành công
    Route::get('/success/{orderId}', [CheckoutController::class, 'success'])->name('success');
});

// ROUTES CHO MÃ GIẢM GIÁ
Route::prefix('coupon')->name('coupon.')->group(function () {
    // Áp dụng mã giảm giá
    Route::post('/apply', [CouponController::class, 'apply'])->name('apply');

    // Xóa mã giảm giá
    Route::post('/remove', [CouponController::class, 'remove'])->name('remove');
});

// Routes for the About pages
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/about/team', [AboutController::class, 'team'])->name('about.team');
Route::get('/about/contact', [AboutController::class, 'contact'])->name('about.contact');

Route::get('/admin', function () {
    return view('layout.admin');
})->middleware('auth');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/cart/update-qty/{id}', [CartController::class, 'updateQty'])->name('cart.updateQty');

Route::get('/Trang-chu', [HomeController::class, 'index'])->name('homepage');
Route::post('/cartadd/{id}', [CartController::class, 'add'])->name('cartadd');
Route::get('/cartdel/{id}', [CartController::class, 'del'])->name('cartdel');
Route::post('/cartsave', [CartController::class, 'save'])->name('cartsave');
Route::get('/cartshow', function () {
    return view('client.cart.cartshow');
})->name('cartshow');
Route::get('/cartcheckout', function () {
    return view('client.cart.checkout');
})->name('checkout');

Route::get('/category/{id}', [CategoryClientController::class, 'detail'])->name('category');
Route::get('/brand/{id}', [BrandClientController::class, 'detail'])->name('brand');

Route::get('/san-pham', [ProductController::class, 'index'])->name('client.products.index');

Route::prefix('products')->name('client.products.')->group(function () {
    Route::get('/', [ProductClientController::class, 'index'])->name('index');
    Route::get('/detail/{id}', [ProductClientController::class, 'detail'])->name('detail');
    Route::get('/search', [ProductClientController::class, 'search'])->name('search');
});


Route::get('/admin/login', [UserController::class, 'login'])->name('ad.login');
Route::post('/admin/login', [UserController::class, 'loginpost'])->name('ad.loginpost');

Route::get('/admin/forgotpass', [UserController::class, 'forgotpassform'])->name('ad.forgotpass');
Route::post('/admin/forgotpass', [UserController::class, 'forgotpass'])->name('ad.forgotpasspost');

Route::get('/admin/resetpass/{id}', [UserController::class, 'showResetForm'])->name('ad.reset.form');
Route::post('/admin/resetpass/{id}', [UserController::class, 'handleReset'])->name('ad.reset');




Route::prefix('ad')->as('ad.')->middleware(['auth', 'roles:1'])->group(function () {
    Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class);
});



Route::prefix('ad')->as('ad.')->middleware(['auth', 'roles:1'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
});


Route::prefix('ad')->middleware(['auth', 'roles:1'])->name('ad.')->group(function () {
    Route::resource('orderitems', \App\Http\Controllers\Admin\OrderitemController::class);
});

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('ad.dashboard');









Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('admin/products', ProductController::class)->names([
        'index' => 'product.index',
        'create' => 'product.create',
        'store' => 'product.store',
        'show' => 'product.show',
        'edit' => 'product.edit',
        'update' => 'product.update',
        'destroy' => 'product.destroy',
    ]);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('ad.dashboard');

    Route::name('ad.')->group(function () {
        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        // Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        // Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

        Route::post('/logout', [UserController::class, 'logout'])->name('logout');
        Route::get('/changepass', [UserController::class, 'showChangePassForm'])->name('changepass.form');
        Route::post('/changepass', [UserController::class, 'changepass'])->name('changepass');
    });


    Route::name('cate.')->middleware('roles:1')->group(function () {
        Route::get('/categories', [CategoryController::class, 'index'])->name('index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/categories/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::post('/categories/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/categories/{id}/delete', [CategoryController::class, 'delete'])->name('delete');
    });

    //Eloquent ORM - Categories
    Route::name('cate2.')->middleware('roles:1')->group(function () {
        Route::get('/categories-2', [Category2Controller::class, 'index'])->name('index');
        Route::get('/categories-2/create', [Category2Controller::class, 'create'])->name('create');
        Route::post('/categories-2/store', [Category2Controller::class, 'store'])->name('store');
        Route::get('/categories-2/{id}/edit', [Category2Controller::class, 'edit'])->name('edit');
        Route::post('/categories-2/{id}', [Category2Controller::class, 'update'])->name('update');
        Route::delete('/categories-2/{id}/delete', [Category2Controller::class, 'delete'])->name('delete');
    });

    Route::name('brand.')->middleware('roles:1')->group(function () {
        Route::get('/brands', [BrandController::class, 'index'])->name('index');
        Route::get('/brands/create', [BrandController::class, 'create'])->name('create');
        Route::post('/brands/store', [BrandController::class, 'store'])->name('store');
        Route::get('/brands/{id}/edit', [BrandController::class, 'edit'])->name('edit');
        Route::post('/brands/{id}', [BrandController::class, 'update'])->name('update');
        Route::delete('/brands/{id}/delete', [BrandController::class, 'delete'])->name('delete');
    });

    //Eloquent ORM - Brands
    Route::name('brand2.')->middleware('roles:1')->group(function () {
        Route::get('/brands-2', [Brand2Controller::class, 'index'])->name('index');
        Route::get('/brands-2/create', [Brand2Controller::class, 'create'])->name('create');
        Route::post('/brands-2/store', [Brand2Controller::class, 'store'])->name('store');
        Route::get('/brands-2/{id}/edit', [Brand2Controller::class, 'edit'])->name('edit');
        Route::post('/brands-2/{id}', [Brand2Controller::class, 'update'])->name('update');
        Route::delete('/brands-2/{id}/delete', [Brand2Controller::class, 'delete'])->name('delete');
    });

    Route::get('/products', [ProductController::class, 'index'])->name('pro.index');
    Route::get('/products2', [ProductController::class, 'index2'])->name('pro.index2');
    Route::get('/products-3', [ProductController::class, 'index3'])->name('pro.index3');
    Route::get('/products-4/{perpage?}', [ProductController::class, 'index4'])->name('pro.index4');
    Route::get('/products-5/{perpage?}', [ProductController::class, 'index5'])->name('pro.index5');
    Route::get('/products/create', [ProductController::class, 'create'])->name('pro.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('pro.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('pro.edit');
    Route::post('/products/{id}', [ProductController::class, 'update'])->name('pro.update');
    Route::post('/products/{id}/delete', [ProductController::class, 'delete'])->name('pro.delete');

    //Eloquent ORM - Products
    Route::get('/products-2/create', [Product2Controller::class, 'create'])->name('pro2.create');
    Route::post('/products-2/store', [Product2Controller::class, 'store'])->name('pro2.store');
    Route::get('/products-2/{id}/edit', [Product2Controller::class, 'edit'])->name('pro2.edit');
    Route::post('/products-2/{id}', [Product2Controller::class, 'update'])->name('pro2.update');
    Route::post('/products-2/{id}/delete', [Product2Controller::class, 'delete'])->name('pro2.delete');
    Route::get('/products-2/{perpage?}', [Product2Controller::class, 'index'])->name('pro2.index');

    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
});
