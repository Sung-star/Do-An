<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Throwable;

class Product2Controller extends Controller
{
    public function index($perpage = 5)
    {
        $list = Product::with(['category', 'brand'])
            ->select('id', 'proname as productname', 'price', 'cateid', 'brandid', 'description', 'fileName', 'has_version')
            ->paginate($perpage);

        return view('admin.products-2.index', compact('list', 'perpage'));
    }

    public function create()
    {
        $categories = Category::orderBy('catename')->get();
        $brands = Brand::orderBy('brandname')->get();

        return view('admin.products-2.create', compact('categories', 'brands'));
    }

    public function store(ProductRequest $request)
    {
        $fileName = null;

        if ($request->hasFile('fileName')) {
            $file = $request->file('fileName');
            $fileName = Str::slug($request->proname) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('products', $fileName, 'public');
        }

        try {
            Product::create([
                'proname' => $request->proname,
                'price' => $request->price,
                'cateid' => $request->cateid,
                'brandid' => $request->brandid,
                'description' => $request->description,
                'fileName' => $fileName,
                'has_version' => $request->has('has_version'), // ✅ thêm
            ]);

            $message = 'Thêm thành công';
        } catch (Throwable $th) {
            $message = 'Thêm thất bại - Lỗi: ' . $th->getMessage();
        }

        return redirect()->route('pro2.create')->withInput()->with('message', $message);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('catename')->get();
        $brands = Brand::orderBy('brandname')->get();

        return view('admin.products-2.edit', compact('product', 'categories', 'brands'));
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $fileName = $product->fileName;

        if ($request->hasFile('fileName')) {
            $file = $request->file('fileName');
            if ($fileName && file_exists(storage_path('app/public/products/' . $fileName))) {
                unlink(storage_path('app/public/products/' . $fileName));
            }

            $fileName = Str::slug($request->proname) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('products', $fileName, 'public');
        }

        try {
            $product->update([
                'proname' => $request->proname,
                'price' => $request->price,
                'cateid' => $request->cateid,
                'brandid' => $request->brandid,
                'description' => $request->description,
                'fileName' => $fileName,
                'has_version' => $request->has('has_version'), // ✅ thêm
            ]);

            $message = 'Cập nhật thành công';
        } catch (Throwable $th) {
            $message = 'Cập nhật thất bại - Lỗi: ' . $th->getMessage();
        }

        return redirect()->route('pro2.edit', $id)->withInput()->with('message', $message);
    }

    public function delete($id)
    {
        try {
            $rowaffect = Product::where('id', $id)->delete();
            $message = $rowaffect ? 'Xóa thành công' : 'Không có bản ghi nào được xóa';
        } catch (Throwable $th) {
            $message = 'Xóa thất bại - Lỗi: ' . $th->getMessage();
        }

        return redirect()->route('pro2.index')->with('message', $message);
    }
}
