<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // -------------------------
        // 1️⃣ Khởi tạo query chính
        // -------------------------
        $query = Product::query();

        // 2️⃣ Lọc theo danh mục
        if ($request->filled('cateid')) {
            $query->where('cateid', $request->cateid);
        }

        // 3️⃣ Lọc theo thương hiệu
        if ($request->filled('brandid')) {
            $query->where('brandid', $request->brandid);
        }

        // 4️⃣ Lọc theo khoảng giá
        if ($request->filled('price_range')) {
            [$min, $max] = explode('-', $request->price_range);
            $query->whereBetween('price', [(int)$min, (int)$max]);
        }

        // 5️⃣ Sắp xếp
        if ($request->filled('sort')) {
            match ($request->sort) {
                'price_asc' => $query->orderBy('price', 'asc'),
                'price_desc' => $query->orderBy('price', 'desc'),
                'newest' => $query->latest('id'),
                'bestseller' => $query->orderBy('sold', 'desc'),
                default => null,
            };
        }

        // 6️⃣ Phân trang thật (12 sản phẩm mỗi trang)
        $products = $query->paginate(12)->withQueryString();

        // 7️⃣ Sản phẩm nổi bật (lấy ngẫu nhiên 8 cái có ảnh)
        $listpro = Product::whereNotNull('fileName')
            ->inRandomOrder()
            ->take(8)
            ->get();

        // 8️⃣ Danh mục & Thương hiệu
        $categories = Category::orderBy('catename')->get();
        $brands = Brand::orderBy('brandname')->get();

        // 9️⃣ Trả về view
        return view('client.home', compact('products', 'listpro', 'categories', 'brands'));
    }
}
