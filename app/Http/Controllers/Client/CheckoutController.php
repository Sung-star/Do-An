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
     * Hiển thị trang checkout
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

        try {
            DB::beginTransaction();

            // Tính tổng tiền
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // Tạo description để lưu lịch sử
            $description = "Khách hàng: {$validated['name']}\n";
            $description .= "SĐT: {$validated['phone']}\n";
            $description .= "Email: {$validated['email']}\n";
            $description .= "Địa chỉ: {$validated['address']}\n";
            if (!empty($validated['note'])) {
                $description .= "Ghi chú: {$validated['note']}\n";
            }
            $description .= "Thanh toán: " . ($validated['payment_method'] === 'cod' ? 'COD' : 'MoMo') . "\n";
            $description .= "Tổng tiền: " . number_format($total, 0, ',', '.') . " VNĐ";

            // ✅ Tạo order, ghi payment_method và status
            $order = Order::create([
                'customerid'      => Auth::check() ? Auth::id() : 1,
                'orderdate'       => now(),
                'payment_method'  => $validated['payment_method'],
                'status'          => $validated['payment_method'] === 'momo' ? 'Đang chờ thanh toán' : 'Chờ xử lý',
                'description'     => $description
            ]);

            // Tạo order items
            foreach ($cart as $productId => $item) {
                OrderItem::create([
                    'orderid'   => $order->id,
                    'productid' => $productId,
                    'quantity'  => $item['quantity'],
                    'price'     => $item['price']
                ]);

                // Giảm stock
                if ($product = Product::find($productId)) {
                    $product->decrement('is_featured', $item['quantity']);
                }
            }

            DB::commit();
            session()->forget('cart');

            // Chuyển hướng theo phương thức thanh toán
            return $validated['payment_method'] === 'momo'
                ? redirect()->route('checkout.momo-payment', $order->id)
                : redirect()->route('checkout.success', $order->id)->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Trang QR MoMo
     */
    public function momoPayment($orderId)
    {
        $order = Order::findOrFail($orderId);
        $orderItems = OrderItem::where('orderid', $orderId)->get();

        $total = $orderItems->sum(fn($i) => $i->price * $i->quantity);

        // Lấy thông tin khách hàng từ description (giống hàm parse trước đây)
        $customerInfo = $this->parseOrderDescription($order->description);

        // Tạo dữ liệu MoMo
        $momoInfo = [
            'phone' => '0123456789',       // SĐT MoMo
            'amount' => $total,
            'note'   => 'DH' . $order->id, // Nội dung chuyển khoản
        ];

        // QR content
        $qrContent = "2|99|{$momoInfo['phone']}|HOAISUNGSHOP|{$momoInfo['note']}|0|0|{$momoInfo['amount']}";
        $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($qrContent);

        return view('client.cart.momo-payment', compact(
            'order',
            'orderItems',
            'total',
            'customerInfo',
            'momoInfo',
            'qrCodeUrl'
        ));
    }

    /**
     * Tách thông tin khách hàng từ description
     */
    private function parseOrderDescription($description)
    {
        $info = [
            'name' => '',
            'phone' => '',
            'email' => '',
            'address' => '',
        ];

        $lines = explode("\n", $description);
        foreach ($lines as $line) {
            if (str_contains($line, 'Khách hàng:')) {
                $info['name'] = trim(str_replace('Khách hàng:', '', $line));
            }
            if (str_contains($line, 'SĐT:')) {
                $info['phone'] = trim(str_replace('SĐT:', '', $line));
            }
            if (str_contains($line, 'Email:')) {
                $info['email'] = trim(str_replace('Email:', '', $line));
            }
            if (str_contains($line, 'Địa chỉ:')) {
                $info['address'] = trim(str_replace('Địa chỉ:', '', $line));
            }
        }

        return $info;
    }


    /**
     * Xác nhận đã thanh toán MoMo
     */
    public function confirmMomoPayment($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->update([
            'status' => 'Đã thanh toán',
            'description' => $order->description . "\n[ĐÃ THANH TOÁN MOMO - " . now()->format('Y-m-d H:i:s') . "]"
        ]);

        return redirect()->route('checkout.success', $order->id)->with('success', 'Thanh toán thành công!');
    }

    /**
     * Trang đặt hàng thành công
     */
    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);
        $orderItems = OrderItem::where('orderid', $orderId)->get();

        return view('client.cart.checkout-success', compact('order', 'orderItems'));
    }
}
