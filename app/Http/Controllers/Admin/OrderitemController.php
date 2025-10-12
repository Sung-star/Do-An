<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orderitem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderitemController extends Controller
{
    public function index()
    {
        $orderitems = Orderitem::with(['order', 'product'])->get();
        return view('admin.orderitems.index', compact('orderitems'));
    }

    public function create()
    {
        $orders = Order::all();
        $products = Product::all();
        return view('admin.orderitems.create', compact('orders', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'orderid' => 'required|exists:orders,id',
            'productid' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        Orderitem::create($request->all());
        return redirect()->route('ad.orderitems.index')->with('success', 'Đã thêm chi tiết đơn hàng!');
    }

    public function edit($id)
    {
        $item = Orderitem::findOrFail($id);
        $orders = Order::all();
        $products = Product::all();
        return view('admin.orderitems.edit', compact('item', 'orders', 'products'));
    }

    public function update(Request $request, $id)
    {
        $item = Orderitem::findOrFail($id);

        $request->validate([
            'orderid' => 'required|exists:orders,id',
            'productid' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $item->update($request->all());
        return redirect()->route('ad.orderitems.index')->with('success', 'Đã cập nhật!');
    }

    public function destroy($id)
    {
        Orderitem::destroy($id);
        return redirect()->route('ad.orderitems.index')->with('success', 'Đã xóa!');
    }
}
