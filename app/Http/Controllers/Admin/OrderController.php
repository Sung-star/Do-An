<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Danh sách trạng thái đơn hàng hợp lệ
     */
    protected $allowedStatuses = [
        'Chờ xử lý',
        'Đang xử lý',
        'Hoàn thành',
        'Đã hủy',
    ];

    /**
     * Hiển thị danh sách tất cả đơn hàng
     */
    public function index()
    {
        $orders = Order::with(['customer', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Hiển thị chi tiết 1 đơn hàng
     */
    public function show($id)
    {
        $order = Order::with(['customer', 'items.product'])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (! in_array($value, $this->allowedStatuses, true)) {
                        $fail('Trạng thái không hợp lệ.');
                    }
                },
            ],
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();

        return redirect()
            ->route('ad.orders.show', $order->id)
            ->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }

    /**
     * (Tuỳ chọn) Cập nhật phương thức thanh toán của đơn hàng
     */
    public function updatePaymentMethod(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|in:cod,momo',
        ]);

        $order = Order::findOrFail($id);
        $order->payment_method = $request->input('payment_method');
        $order->save();

        return redirect()
            ->route('ad.orders.show', $order->id)
            ->with('success', 'Cập nhật phương thức thanh toán thành công!');
    }
}
