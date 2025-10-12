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
        $product = Product::find($id);
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
        } else {
            $fileName = $product->fileName ?? '';

            $cart[$id] = [
                'productid' => $product->id,
                'proname'   => $product->proname,
                'price'     => $product->price,
                'quantity'  => 1,
                'fileName'  => $fileName,
            ];
        }

        Session::put('cart', $cart);

        // 👉 Nếu bấm Mua Ngay thì chuyển thẳng sang checkout
        if ($req->has('redirect') && $req->redirect === 'checkout') {
            return redirect()->route('checkout');
        }

        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }


    public function del($id)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
        }
        Session::put('cart', $cart);
        return redirect()->back();
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
                'orderid' => $order->id,
                'productid' => $item['productid'],
                'price' => $item['price'],
                'quantity' => $item['quantity']
            ]);
        }

        Session::forget('cart');

        return redirect()->back()
            ->withInput()
            ->with('mess', 'Đặt hàng thành công. Anh/chị vui lòng đợi nhân viên liên hệ để xác nhận.');
    }

    public function updateQty(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($request->input('action') === 'increase') {
                $cart[$id]['quantity'] += 1;
            } elseif ($request->input('action') === 'decrease') {
                $cart[$id]['quantity'] = max(1, $cart[$id]['quantity'] - 1);
            }

            session()->put('cart', $cart);
        }

        return redirect()->back();
    }
}
