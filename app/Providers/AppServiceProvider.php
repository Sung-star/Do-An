<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Brand;
use Dotenv\Dotenv;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // ✅ Nếu file .env.local tồn tại, tự động load (khi chạy php artisan serve)
        $localEnv = base_path('.env.local');
        if (file_exists($localEnv)) {
            $dotenv = Dotenv::createImmutable(base_path(), '.env.local');
            $dotenv->load();
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ✅ Truyền biến $brands cho mọi view
        View::composer('*', function ($view) {
            $view->with('brands', Brand::orderBy('brandname')->get());
        });
    }
}
