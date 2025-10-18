<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    /**
     * Trang Checkout
     */
    public function index()
    {
        $cart = session('cart', []);
        return view('client.checkout', compact('cart'));
    }

    /**
     * Xử lý đặt hàng
     */
    public function process(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'phone'           => 'required|string|max:15',
            'email'           => 'required|email|max:255',
            'address'         => 'required|string|max:500',
            'note'            => 'nullable|string|max:1000',
            'payment_method'  => 'required|in:cod,momo'
        ], [
            'name.required'           => 'Vui lòng nhập họ tên',
            'phone.required'          => 'Vui lòng nhập số điện thoại',
            'email.required'          => 'Vui lòng nhập email',
            'address.required'        => 'Vui lòng nhập địa chỉ',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán'
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Giỏ hàng trống, không thể thanh toán.');
        }

        try {
            DB::beginTransaction();

            // ✅ Tính tổng tiền
            $total = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);

            // ✅ Chuẩn bị mô tả đơn hàng
            $desc = "Khách hàng: {$validated['name']} | SĐT: {$validated['phone']} | Email: {$validated['email']} | Địa chỉ: {$validated['address']}";
            if (!empty($validated['note'])) $desc .= " | Ghi chú: {$validated['note']}";
            $desc .= " | Thanh toán: " . strtoupper($validated['payment_method']);
            $desc .= " | Tổng: " . number_format($total, 0, ',', '.') . " VNĐ";

            // ✅ Tạo đơn hàng
            $order = Order::create([
                'customerid'       => Auth::check() ? Auth::id() : 1, // 👈 thêm 1 giá trị fallback
                'payment_method'   => $validated['payment_method'],
                'status'           => $validated['payment_method'] === 'momo' ? 'Đang chờ thanh toán' : 'Chờ xử lý',
                'description'      => $desc,
                'total_amount'     => $total,
                'customer_name'    => $validated['name'],
                'customer_phone'   => $validated['phone'],
                'customer_email'   => $validated['email'],
                'customer_address' => $validated['address'],
            ]);

            // ✅ Chi tiết sản phẩm
            foreach ($cart as $item) {
                OrderItem::create([
                    'orderid'   => $order->id,
                    'productid' => $item['productid'] ?? null,
                    'quantity'  => $item['quantity'],
                    'price'     => $item['price'],
                    'color'     => $item['color'] ?? null,
                    'version'   => $item['version'] ?? null,
                ]);

                // ✅ Giảm tồn kho nếu cần
                if (isset($item['productid'])) {
                    $product = Product::find($item['productid']);
                    if ($product && $product->is_featured > 0) {
                        $product->decrement('is_featured', $item['quantity']);
                    }
                }
            }

            DB::commit();
            session()->forget('cart');

            return $validated['payment_method'] === 'momo'
                ? redirect()->route('checkout.momo-payment', $order->id)
                : redirect()->route('checkout.success', $order->id)->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Lỗi khi đặt hàng: ' . $e->getMessage());
        }
    }

    /**
     * Trang QR MoMo
     */
    public function momoPayment($orderId)
    {
        $order = Order::findOrFail($orderId);
        $orderItems = $order->items;

        $total = $orderItems->sum(fn($i) => $i->price * $i->quantity);
        $momoInfo = [
            'phone' => '0123456789',
            'amount' => $total,
            'note'   => 'DH' . $order->id,
        ];

        $qrContent = "2|99|{$momoInfo['phone']}|HOAISUNGSHOP|{$momoInfo['note']}|0|0|{$momoInfo['amount']}";
        $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($qrContent);

        return view('client.cart.momo-payment', compact('order', 'orderItems', 'total', 'momoInfo', 'qrCodeUrl'));
    }

    /**
     * Xác nhận thanh toán MoMo
     */
    public function confirmMomoPayment($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->update([
            'status' => 'Đã thanh toán',
            'description' => $order->description . " | [ĐÃ THANH TOÁN MOMO - " . now()->format('Y-m-d H:i:s') . "]"
        ]);

        return redirect()->route('checkout.success', $order->id)->with('success', 'Thanh toán thành công!');
    }

    /**
     * Trang đặt hàng thành công
     */
    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);
        $orderItems = $order->items;
        return view('client.cart.checkout-success', compact('order', 'orderItems'));
    }
}
