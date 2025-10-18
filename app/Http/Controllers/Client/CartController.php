<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;

class CartController extends Controller
{
    public function add(Request $req)
    {
        $id = $req->route('id');
        $product = Product::findOrFail($id);
        $cart = Session::get('cart', []);

        $qty     = max(1, (int) $req->input('qty', 1));
        $color   = $req->input('color');
        $version = $req->input('version');

        // ✅ Khóa duy nhất cho mỗi biến thể
        $variantKey = $id . '|' . ($color ?? '') . '|' . ($version ?? '');

        $finalPrice = $product->sale > 0
            ? (int) round($product->price * (100 - $product->sale) / 100)
            : (int) $product->price;

        if (isset($cart[$variantKey])) {
            $cart[$variantKey]['quantity'] += $qty;
        } else {
            $cart[$variantKey] = [
                'key'       => $variantKey,
                'productid' => $product->id,
                'proname'   => $product->proname,
                'price'     => $finalPrice,
                'quantity'  => $qty,
                'fileName'  => $product->fileName ?? '',
                'color'     => $color,
                'version'   => $version,
            ];
        }

        Session::put('cart', $cart);

        if ($req->has('redirect') && $req->redirect === 'checkout') {
            return redirect()->route('checkout');
        }

        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    // ✅ Sửa: xóa sản phẩm theo key (đúng biến thể)
    public function del(Request $req)
    {
        $key = $req->key ?? $req->route('key');
        $cart = Session::get('cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]);
            Session::put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng');
    }

    public function save(Request $req)
    {
        $cart = Session::get('cart');
        if (empty($cart)) {
            return redirect()->back()->with('mess', 'Không tồn tại giỏ hàng');
        }

        $customer = Customer::where('tel', $req->tel)
            ->orWhere('email', $req->email)
            ->first();

        if (!$customer) {
            $customer = Customer::create([
                'fullname' => $req->fullname,
                'tel' => $req->tel,
                'email' => $req->email,
                'address' => $req->address,
            ]);
        }

        $order = Order::create([
            'customerid' => $customer->id,
            'description' => $req->description ?? '',
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'orderid'   => $order->id,
                'productid' => $item['productid'],
                'price'     => $item['price'],
                'quantity'  => $item['quantity'],
                'color'     => $item['color'] ?? null,
                'version'   => $item['version'] ?? null,
            ]);
        }

        Session::forget('cart');

        return redirect()->route('order.success', ['id' => $order->id]);
    }

    // ✅ updateQty dùng key thay vì productid
    public function updateQty(Request $request, $key)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            if ($request->input('action') === 'increase') {
                $cart[$key]['quantity'] += 1;
            } elseif ($request->input('action') === 'decrease') {
                $cart[$key]['quantity'] = max(1, $cart[$key]['quantity'] - 1);
            }

            session()->put('cart', $cart);
        }

        return redirect()->back();
    }
}
