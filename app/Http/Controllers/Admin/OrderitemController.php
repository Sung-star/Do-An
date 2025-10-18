<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderitemController extends Controller
{
    // 📦 Hiển thị danh sách chi tiết đơn hàng
    public function index()
    {
        $orderitems = OrderItem::with(['order', 'product'])->get();
        return view('admin.orderitems.index', compact('orderitems'));
    }

    // ➕ Form thêm mới
    public function create()
    {
        $orders = Order::all();
        $products = Product::all();
        return view('admin.orderitems.create', compact('orders', 'products'));
    }

    // 💾 Lưu chi tiết đơn hàng
    public function store(Request $request)
    {
        $request->validate([
            'orderid' => 'required|exists:orders,id',
            'productid' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'color' => 'nullable|string|max:50',
            'version' => 'nullable|string|max:50',
        ]);

        OrderItem::create([
            'orderid' => $request->orderid,
            'productid' => $request->productid,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'color' => $request->color,
            'version' => $request->version,
        ]);

        return redirect()->route('ad.orderitems.index')->with('success', 'Đã thêm chi tiết đơn hàng thành công!');
    }

    // ✏️ Form chỉnh sửa
    public function edit($id)
    {
        $item = OrderItem::findOrFail($id);
        $orders = Order::all();
        $products = Product::all();
        return view('admin.orderitems.edit', compact('item', 'orders', 'products'));
    }

    // 🔁 Cập nhật chi tiết đơn hàng
    public function update(Request $request, $id)
    {
        $item = OrderItem::findOrFail($id);

        $request->validate([
            'orderid' => 'required|exists:orders,id',
            'productid' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'color' => 'nullable|string|max:50',
            'version' => 'nullable|string|max:50',
        ]);

        $item->update([
            'orderid' => $request->orderid,
            'productid' => $request->productid,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'color' => $request->color,
            'version' => $request->version,
        ]);

        return redirect()->route('ad.orderitems.index')->with('success', 'Đã cập nhật chi tiết đơn hàng!');
    }

    // ❌ Xóa chi tiết đơn hàng
    public function destroy($id)
    {
        OrderItem::destroy($id);
        return redirect()->route('ad.orderitems.index')->with('success', 'Đã xóa chi tiết đơn hàng!');
    }
}
