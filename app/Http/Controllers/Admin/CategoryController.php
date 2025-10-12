<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $list = DB::table("categories")->orderBy('catename')->paginate(8);
        if ($request->ajax()) {
            return view("admin.categories.list", compact("list"));
        }
        return view("admin.categories.index", compact("list"));
    }

    public function create()
    {
        return view("admin.categories.create");
    }

    public function store(Request $request)
    {
        $message = null;
        try {
            $data = [
                'catename' => $request->catename,
                'code' => $request->code,
            ];

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('categories', 'public');
            }

            DB::table('categories')->insert($data);
            $message = 'Thêm thành công';
        } catch (Throwable $th) {
            $message = 'Thêm thất bại - Lỗi: ' . $th->getMessage();
        }

        return redirect()->route('cate.create')->withInput()->with('message', $message);
    }

    public function edit($id)
    {
        $category = DB::table('categories')->where('cateid', $id)->first();
        return view('admin.categories.edit', compact('category'));
    }

    public function update($id, Request $request)
    {
        $message = null;
        try {
            $data = [
                'catename' => $request->catename,
                'code' => $request->code,
            ];

            if ($request->hasFile('image')) {
                $old = DB::table('categories')->where('cateid', $id)->first();
                if ($old && $old->image) {
                    Storage::disk('public')->delete($old->image);
                }

                $data['image'] = $request->file('image')->store('categories', 'public');
            }

            DB::table('categories')->where('cateid', $id)->update($data);
            $message = 'Cập nhật thành công';
        } catch (Throwable $th) {
            $message = 'Cập nhật thất bại - Lỗi: ' . $th->getMessage();
        }

        return redirect()->route('cate.edit', $id)->withInput()->with('message', $message);
    }

    public function delete($id)
    {
        $message = null;

        try {
            $used = DB::table('products')->where('cateid', $id)->exists();

            if ($used) {
                $message = 'Không thể xóa: Danh mục đang được sử dụng trong bảng sản phẩm.';
            } else {
                $category = DB::table('categories')->where('cateid', $id)->first();
                if ($category && $category->image) {
                    Storage::disk('public')->delete($category->image);
                }

                $rowaffect = DB::table('categories')->where('cateid', $id)->delete();
                $message = $rowaffect > 0 ? 'Xóa thành công' : 'Không có bản ghi nào được xóa';
            }
        } catch (Throwable $th) {
            $message = 'Xóa thất bại - Lỗi: ' . $th->getMessage();
        }

        return redirect()->route('cate.index')->with('message', $message);
    }
}
