<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductController extends Controller
{
    public function index()
    {
        $list = DB::table("products as p")
            ->select(
                'p.id',
                'p.proname as productname',
                'p.price',
                'c.cateid',
                'c.catename'
            )
            ->join('categories as c', 'p.cateid', 'c.cateid')
            ->orderBy('proname')
            ->paginate(8);
        return view("admin.products.index", compact("list"));
    }

    public function index2()
    {
        $list = DB::table("products as p")
            ->select(
                'p.id',
                'p.proname as productname',
                'p.price',
                'c.cateid',
                'c.catename',
                'b.brandname'
            )
            ->join('categories as c', 'p.cateid', 'c.cateid')
            ->leftJoin('brands as b', 'p.brandid', 'b.id')
            ->get();
        return view("admin.products.index2", compact("list"));
    }

    public function index3()
    {
        $list = DB::table("products as p")
            ->select(
                'p.id',
                'p.proname as productname',
                'p.price',
                'c.cateid',
                'c.catename',
                'b.brandname'
            )
            ->join('categories as c', 'p.cateid', 'c.cateid')
            ->leftJoin('brands as b', 'p.brandid', 'b.id')
            ->paginate(7);
        return view("admin.products.index3", compact("list"));
    }

    public function index4($perpage = 5)
    {
        $list = DB::table("products as p")
            ->select(
                'p.id',
                'p.proname as productname',
                'p.price',
                'c.cateid',
                'c.catename',
                'b.brandname'
            )
            ->join('categories as c', 'p.cateid', 'c.cateid')
            ->leftJoin('brands as b', 'p.brandid', 'b.id')
            ->paginate($perpage);
        return view("admin.products.index4", compact("list", "perpage"));
    }

    public function index5(Request $request, $perpage = 5)
    {
        $list = DB::table("products as p")
            ->select(
                'p.id',
                'p.proname as productname',
                'p.price',
                'c.cateid',
                'c.catename',
                'b.brandname'
            )
            ->join('categories as c', 'p.cateid', 'c.cateid')
            ->leftJoin('brands as b', 'p.brandid', 'b.id')
            ->paginate($perpage);
        if ($request->ajax()) {
            return view("admin.products.pro-list", compact("list", "perpage"));
        }
        return view("admin.products.index5", compact("list", "perpage"));
    }

    public function create()
    {
        $brands = DB::table('brands')->orderBy('brandname')->get();
        $categories = DB::table('categories')->orderBy('catename')->get();

        return view("admin.products.create", compact("brands", "categories"));
    }

    public function store(Request $request)
    {
        $message = null;
        try {
            DB::table('products')->insert([
                'proname' => $request->input('proname'),
                'price' => $request->input('price'),
                'brandid' => $request->input('brandid'),
                'cateid' => $request->input('cateid'),
                'description' => $request->input('description'),
            ]);
            $message = 'Thêm thành công';
        } catch (Throwable $th) {
            $message = 'Thêm thất bại - Lỗi' . $th->getMessage();
        }
        return redirect()->route('pro.create')->withInput()->with('message', $message);
    }

    public function edit($id)
    {

        $product = DB::table('products')->where('id', $id)->first();

        $brands = DB::table('brands')->orderBy('brandname')->get();
        $categories = DB::table('categories')->orderBy('catename')->get();

        return view('admin.products.edit', compact('product', 'brands', 'categories'));
    }

    public function update(Request $request, $id)
    {

        $message = null;
        try {
            $rowaffect = DB::table('products')->where('id', $id)->update([
                'proname' => $request->input('proname'),
                'price' => $request->input('price'),
                'brandid' => $request->input('brandid'),
                'cateid' => $request->input('cateid'),
            ]);
            $message = $rowaffect > 0 ? 'Cập nhật thành công' : 'Không có bản ghi nào được cập nhật';
        } catch (Throwable $th) {
            $message = 'Cập nhật thất bại - Lỗi' . $th->getMessage();
        }

        return redirect()->route('pro.edit', $id)->withInput()->with('message', $message);
    }

    public function delete($id)
    {
        $message = null;
        try {
            $rowaffect = DB::table('products')->where('id', $id)->delete();
            $message = $rowaffect > 0 ? 'Xóa thành công' : 'Không có bản ghi nào được xóa';
        } catch (Throwable $th) {
            $message = 'Xóa thất bại - Lỗi' . $th->getMessage();
        }

        return redirect()->route('pro.index3')->with('message', $message);
    }
}
