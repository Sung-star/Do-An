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
            ->with('items')
            ->get()
            ->sum(function ($order) {
                return $order->items->sum(fn($item) => $item->quantity * $item->price);
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
        // Doanh thu theo tháng (năm hiện tại)
        // ======================
        $monthlyRevenue = Order::where('status', 'Hoàn thành')
            ->whereYear('created_at', Carbon::now()->year)
            ->with('items')
            ->get()
            ->groupBy(fn($order) => $order->created_at->format('m'))
            ->map(function ($orders) {
                return $orders->sum(function ($order) {
                    return $order->items->sum(fn($item) => $item->quantity * $item->price);
                });
            });

        // ======================
        // 🔢 Tính tăng trưởng % so với tháng trước
        // ======================
        $thisMonth = Carbon::now()->month;
        $lastMonth = Carbon::now()->subMonth()->month;
        $year = Carbon::now()->year;

        // 1️⃣ Sản phẩm tạo trong tháng
        $productThisMonth = Product::whereYear('created_at', $year)->whereMonth('created_at', $thisMonth)->count();
        $productLastMonth = Product::whereYear('created_at', $year)->whereMonth('created_at', $lastMonth)->count();
        $growthProducts = $this->calcGrowth($productThisMonth, $productLastMonth);

        // 2️⃣ Đơn hàng trong tháng
        $orderThisMonth = Order::whereYear('created_at', $year)->whereMonth('created_at', $thisMonth)->count();
        $orderLastMonth = Order::whereYear('created_at', $year)->whereMonth('created_at', $lastMonth)->count();
        $growthOrders = $this->calcGrowth($orderThisMonth, $orderLastMonth);

        // 3️⃣ Khách hàng mới trong tháng
        $customerThisMonth = Customer::whereYear('created_at', $year)->whereMonth('created_at', $thisMonth)->count();
        $customerLastMonth = Customer::whereYear('created_at', $year)->whereMonth('created_at', $lastMonth)->count();
        $growthCustomers = $this->calcGrowth($customerThisMonth, $customerLastMonth);

        // 4️⃣ Doanh thu tháng này vs tháng trước
        $revenueThisMonth = Order::where('status', 'Hoàn thành')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $thisMonth)
            ->with('items')
            ->get()
            ->sum(fn($order) => $order->items->sum(fn($item) => $item->quantity * $item->price));

        $revenueLastMonth = Order::where('status', 'Hoàn thành')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $lastMonth)
            ->with('items')
            ->get()
            ->sum(fn($order) => $order->items->sum(fn($item) => $item->quantity * $item->price));

        $growthRevenue = $this->calcGrowth($revenueThisMonth, $revenueLastMonth);

        $growthData = [
            'products' => $growthProducts,
            'orders' => $growthOrders,
            'customers' => $growthCustomers,
            'revenue' => $growthRevenue
        ];

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
            'monthlyRevenue',
            'growthData' // ✅ truyền sang view
        ));
    }

    /**
     * Hàm tính phần trăm tăng trưởng
     */
    private function calcGrowth($current, $previous)
    {
        if ($previous == 0 && $current > 0) return 100; // tăng đột biến
        if ($previous == 0 && $current == 0) return 0;
        $change = (($current - $previous) / $previous) * 100;
        return round($change, 1);
    }
}
