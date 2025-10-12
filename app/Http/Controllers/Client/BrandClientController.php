<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Support\Facades\Log;
use Throwable;

class BrandClientController extends Controller
{
    // Hiển thị các sản phẩm thuộc thương hiệu
    public function detail($id)
    {
        try {
            $brand = Brand::with('products')->findOrFail($id);
            return view('client.brands.detail', compact('brand'));
        } catch (Throwable $th) {
            // Ghi log để dễ debug
            Log::error('Lỗi khi lấy chi tiết brand: ' . $th->getMessage());

            // Có thể trả về 404 hoặc view lỗi tùy bạn
            return redirect()
                ->route('brand.index') // hoặc route bạn đặt cho danh sách thương hiệu
                ->with('message', 'Không tìm thấy thương hiệu hoặc có lỗi xảy ra.');
        }
    }
}
