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
        // Tổng quan
        $totalProducts  = Product::count();
        $totalOrders    = Order::count();
        $totalCustomers = Customer::count();

        // Doanh thu hôm nay
        $todayRevenue = Order::where('status', 'Hoàn thành')
            ->whereDate('created_at', Carbon::today())
            ->with('items')
            ->get()
            ->sum(fn($order) => $order->items->sum(fn($item) => $item->quantity * $item->price));

        // Dữ liệu hiển thị
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

        // Doanh thu theo tháng
        $monthlyRevenue = Order::where('status', 'Hoàn thành')
            ->whereYear('created_at', Carbon::now()->year)
            ->with('items')
            ->get()
            ->groupBy(fn($order) => $order->created_at->format('m'))
            ->map(fn($orders) => $orders->sum(
                fn($order) => $order->items->sum(fn($item) => $item->quantity * $item->price)
            ));

        // Tăng trưởng %
        $thisMonth = Carbon::now()->month;
        $lastMonth = Carbon::now()->subMonth()->month;
        $year = Carbon::now()->year;

        $growthData = [
            'products'  => $this->calcGrowth(
                Product::whereYear('created_at', $year)->whereMonth('created_at', $thisMonth)->count(),
                Product::whereYear('created_at', $year)->whereMonth('created_at', $lastMonth)->count()
            ),
            'orders'    => $this->calcGrowth(
                Order::whereYear('created_at', $year)->whereMonth('created_at', $thisMonth)->count(),
                Order::whereYear('created_at', $year)->whereMonth('created_at', $lastMonth)->count()
            ),
            'customers' => $this->calcGrowth(
                Customer::whereYear('created_at', $year)->whereMonth('created_at', $thisMonth)->count(),
                Customer::whereYear('created_at', $year)->whereMonth('created_at', $lastMonth)->count()
            ),
            'revenue'   => $this->calcGrowth(
                $this->getRevenue($year, $thisMonth),
                $this->getRevenue($year, $lastMonth)
            )
        ];

        // Cards
        $cards = [
            ['title' => 'Tổng sản phẩm', 'value' => $totalProducts,  'icon' => 'bi-box-seam', 'color' => 'primary', 'growth' => $growthData['products'],  'route' => 'pro2.index'],
            ['title' => 'Tổng đơn hàng', 'value' => $totalOrders,    'icon' => 'bi-receipt',  'color' => 'success', 'growth' => $growthData['orders'],    'route' => 'ad.orders.index'],
            ['title' => 'Tổng khách hàng', 'value' => $totalCustomers, 'icon' => 'bi-people-fill', 'color' => 'warning', 'growth' => $growthData['customers'], 'route' => 'ad.customers.index'],
            ['title' => 'Doanh thu hôm nay', 'value' => $todayRevenue, 'icon' => 'bi-graph-up-arrow', 'color' => 'danger', 'growth' => $growthData['revenue'], 'route' => 'report.revenue'],
        ];

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalCustomers',
            'todayRevenue',
            'latestProducts',
            'latestOrders',
            'pendingOrders',
            'monthlyRevenue',
            'growthData',
            'cards'
        ));
    }

    private function calcGrowth($current, $previous)
    {
        if ($previous == 0 && $current > 0) return 100;
        if ($previous == 0 && $current == 0) return 0;
        return round((($current - $previous) / $previous) * 100, 1);
    }

    private function getRevenue($year, $month)
    {
        return Order::where('status', 'Hoàn thành')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->with('items')
            ->get()
            ->sum(fn($order) => $order->items->sum(fn($item) => $item->quantity * $item->price));
    }
}
