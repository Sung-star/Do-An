<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Trang báo cáo /admin/report
     */
    public function index()
    {
        $orders = Order::with(['customer', 'items'])
            ->orderByDesc('created_at')
            ->get();

        // Doanh thu hôm nay (chỉ tính đơn hoàn thành)
        $todayRevenue = $orders
            ->where('status', 'Hoàn thành')
            ->where('created_at', '>=', Carbon::today())
            ->sum(fn($order) => $order->total_amount);

        // Tổng doanh thu (chỉ tính đơn hoàn thành)
        $totalRevenue = $orders
            ->where('status', 'Hoàn thành')
            ->sum(fn($order) => $order->total_amount);

        // Số đơn đã hoàn thành
        $completedOrders = $orders->where('status', 'Hoàn thành')->count();

        return view('admin.report.revenue', compact(
            'orders',
            'todayRevenue',
            'totalRevenue',
            'completedOrders'
        ));
    }

    /**
     * Trang phụ /admin/report/revenue (nếu cần)
     */
    public function revenue()
    {
        return $this->index(); // Dùng lại logic của index
    }
}
