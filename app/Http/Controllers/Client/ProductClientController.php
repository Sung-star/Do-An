<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductClientController extends Controller
{
    // Chi tiết sản phẩm
    public function detail($id)
    {
        $product = Product::findOrFail($id);
        return view('client.products.detail', compact('product'));
    }

    // 🔍 Tìm kiếm sản phẩm (có phân trang)
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $products = Product::where('proname', 'like', "%$keyword%")
            ->paginate(12)
            ->withQueryString();

        return view('client.products.search', compact('products', 'keyword'));
    }

    // Danh sách sản phẩm (có lọc & phân trang)
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('price_range')) {
            [$min, $max] = explode('-', $request->price_range);
            $query->whereBetween('price', [(int)$min, (int)$max]);
        }

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
                $query->orderBy('sold', 'desc');
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        // ✅ Giới hạn 12 sản phẩm / trang
        $products = $query->paginate(12)->withQueryString();

        return view('client.products.index', compact('products'));
    }
}
