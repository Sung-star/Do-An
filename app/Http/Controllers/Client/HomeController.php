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
        // 1. Khởi tạo query chính
        // -------------------------
        $query = Product::query();

        // -------------------------
        // 2. Lọc theo danh mục
        // -------------------------
        if ($request->filled('cateid')) {
            $query->where('cateid', $request->input('cateid'));
        }

        // -------------------------
        // 3. Lọc theo thương hiệu
        // -------------------------
        if ($request->filled('brandid')) {
            $query->where('brandid', $request->input('brandid'));
        }

        // -------------------------
        // 4. Lọc theo khoảng giá
        // -------------------------
        if ($request->filled('price_range')) {
            $parts = explode('-', $request->price_range);
            if (count($parts) === 2 && is_numeric($parts[0]) && is_numeric($parts[1])) {
                $min = (int) $parts[0];
                $max = (int) $parts[1];
                $query->whereBetween('price', [$min, $max]);
            }
        }

        // -------------------------
        // 5. Sắp xếp sản phẩm
        // -------------------------
        switch ($request->input('sort')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;

            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;

            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;

            case 'bestseller':
                // Nếu có cột sold thì sort theo sold
                if (Schema::hasColumn('products', 'sold')) {
                    $query->orderBy('sold', 'desc');
                } else {
                    $query->orderBy('id', 'desc');
                }
                break;

            default:
                $query->orderBy('id', 'desc');
                break;
        }

        // -------------------------
        // 6. Phân trang sản phẩm
        // -------------------------
        $products = $query->paginate(12);

        // -------------------------
        // 7. Lấy sản phẩm nổi bật
        //    -> KHÔNG phụ thuộc stock
        // -------------------------
        if (Schema::hasColumn('products', 'is_featured')) {
            $listpro = Product::where('is_featured', 1)
                ->orderBy('updated_at', 'desc')
                ->take(4) // chỉ lấy 4 sản phẩm
                ->get();
        } else {
            // fallback nếu không có cột is_featured
            $listpro = Product::orderBy('created_at', 'desc')
                ->take(4)
                ->get();
        }

        // -------------------------
        // 8. Lấy danh mục & thương hiệu
        // -------------------------
        $categories = Category::orderBy('catename')->get();
        $brands     = Brand::orderBy('brandname')->get();

        // -------------------------
        // 9. Trả về view
        // -------------------------
        return view('client.home', compact('products', 'listpro', 'categories', 'brands'));
    }
}
