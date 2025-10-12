<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class Category2Controller extends Controller
{
    public function index(Request $request)
    {
        $list = Category::with(['products'])->orderBy('catename')->paginate(5);
        if ($request->ajax()) {
            return view("admin.categories-2.list", compact("list"));
        }
        return view("admin.categories-2.index", compact("list"));
    }

    public function create()
    {
        return view("admin.categories-2.create");
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'catename' => 'required|min:10|max:100|unique:categories,catename',
            ],
            [
                'catename.required' => ':attribute không được để trống',
                'catename.min' => ':attribute có ít nhất :min ký tự',
                'catename.max' => ':attribute không vượt quá :max ký tự',
                'catename.unique' => ':attribute đã tồn tại trong hệ thống',
            ],
            [
                'catename' => 'Tên loại sản phẩm/danh mục'
            ]
        );

        $message = null;

        try {
            $data = [
                'catename' => $request->catename,
                'description' => $request->description,
                'code' => $request->code,
            ];

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('categories', 'public');
            }

            Category::create($data);

            $message = 'Thêm thành công';
        } catch (Throwable $th) {
            $message = 'Thêm thất bại - Lỗi: ' . $th->getMessage();
        }

        return redirect()->route('cate2.create')->withInput()->with('message', $message);
    }

    public function edit($id)
    {
        $category = Category::where('cateid', $id)->first();
        return view('admin.categories-2.edit', compact('category'));
    }

    public function update($id, Request $request)
    {
        $request->validate(
            [
                'catename' => 'required|min:10|max:100|unique:categories,catename,' . $id . ',cateid',
            ],
            [
                'catename.required' => ':attribute không được để trống',
                'catename.min' => ':attribute có ít nhất :min ký tự',
                'catename.max' => ':attribute không vượt quá :max ký tự',
                'catename.unique' => ':attribute đã tồn tại trong hệ thống',
            ],
            [
                'catename' => 'Tên loại sản phẩm/danh mục'
            ]
        );

        $message = null;

        try {
            $category = Category::where('cateid', $id)->first();

            $data = [
                'catename' => $request->catename,
                'description' => $request->description,
                'code' => $request->code,
            ];

            if ($request->hasFile('image')) {
                // Xóa ảnh cũ nếu có
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }

                $data['image'] = $request->file('image')->store('categories', 'public');
            }

            $rowaffect = Category::where('cateid', $id)->update($data);
            $message = $rowaffect > 0 ? 'Cập nhật thành công' : 'Không có bản ghi nào được cập nhật';
        } catch (Throwable $th) {
            $message = 'Cập nhật thất bại - Lỗi: ' . $th->getMessage();
        }

        return redirect()->route('cate2.edit', $id)->withInput()->with('message', $message);
    }

    public function delete($id)
    {
        $message = null;

        try {
            $isUsed = \App\Models\Product::where('cateid', $id)->exists();

            if ($isUsed) {
                $message = 'Không thể xóa: Danh mục đang được sử dụng trong bảng sản phẩm.';
            } else {
                $category = Category::where('cateid', $id)->first();

                if ($category && $category->image) {
                    Storage::disk('public')->delete($category->image);
                }

                $rowaffect = Category::where('cateid', $id)->delete();
                $message = $rowaffect > 0 ? 'Xóa thành công' : 'Không có bản ghi nào được xóa';
            }
        } catch (Throwable $th) {
            $message = 'Xóa thất bại - Lỗi: ' . $th->getMessage();
        }

        return redirect()->route('cate2.index')->with('message', $message);
    }
}
