<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductClientController extends Controller
{
    // Hiển thị chi tiết sản phẩm
    public function detail($id)
    {
        $product = Product::findOrFail($id);
        return view('client.products.detail', compact('product'));
    }

    // Tìm kiếm sản phẩm
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $products = Product::where('proname', 'like', '%' . $keyword . '%')->get();

        return view('client.products.search', compact('products', 'keyword'));
    }

    // Hiển thị tất cả sản phẩm kèm sắp xếp
    public function index(Request $request)
    {
        $query = Product::query();

        // Lọc theo khoảng giá
        if ($request->filled('price_range')) {
            [$min, $max] = explode('-', $request->price_range);
            $query->whereBetween('price', [(int)$min, (int)$max]);
        }

        // Sắp xếp
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
                $query->orderBy('sold', 'desc'); // giả sử có cột 'sold'
                break;

            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $products = $query->paginate(12);

        return view('client.products.index', compact('products'));
    }
}
