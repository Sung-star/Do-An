<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ======================
        // Thống kê tổng quan
        // ======================
        $totalProducts  = Product::count();
        $totalOrders    = Order::count();
        $totalCustomers = Customer::count();

        // ======================
        // Doanh thu hôm nay (tính từ order_items)
        // ======================
        $todayRevenue = Order::where('status', 'Hoàn thành')
            ->whereDate('created_at', Carbon::today())
            ->with('items') // load luôn items để tính
            ->get()
            ->sum(function ($order) {
                return $order->items->sum(function ($item) {
                    return $item->quantity * $item->price;
                });
            });

        // ======================
        // Dữ liệu bảng hiển thị
        // ======================
        $latestProducts = Product::latest()->take(5)->get();

        $latestOrders = Order::with('customer')
            ->latest()
            ->take(5)
            ->get();

        $pendingOrders = Order::with('customer')
            ->where('status', 'Chờ xử lý')
            ->latest()
            ->take(5)
            ->get();

        // ======================
        // Doanh thu theo tháng (năm hiện tại) – tính từ order_items
        // ======================
        $monthlyRevenue = Order::where('status', 'Hoàn thành')
            ->whereYear('created_at', Carbon::now()->year)
            ->with('items')
            ->get()
            ->groupBy(function ($order) {
                return $order->created_at->format('m'); // nhóm theo tháng
            })
            ->map(function ($orders) {
                return $orders->sum(function ($order) {
                    return $order->items->sum(function ($item) {
                        return $item->quantity * $item->price;
                    });
                });
            });

        // ======================
        // Trả về view dashboard
        // ======================
        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalCustomers',
            'todayRevenue',
            'latestProducts',
            'latestOrders',
            'pendingOrders',
            'monthlyRevenue'
        ));
    }
}
