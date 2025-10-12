<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $list = DB::table("brands")->orderBy('brandname')->paginate(8);

        if ($request->ajax()) {
            return view("admin.brands.list", compact("list"));
        }
        return view("admin.brands.index", compact("list"));
    }

    public function create()
    {
        return view("admin.brands.create");
    }

    public function store(Request $request)
    {
        $message = null;
        try {
            $data = [
                'brandname' => $request->brandname,
                'code' => $request->code,
            ];

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('brands', 'public');
            }

            DB::table('brands')->insert($data);
            $message = 'Thêm thành công';
        } catch (Throwable $th) {
            $message = 'Thêm thất bại - Lỗi: ' . $th->getMessage();
        }

        return redirect()->route('brand.create')->withInput()->with('message', $message);
    }

    public function edit($id)
    {
        $brand = DB::table('brands')->where('id', $id)->first();
        return view('admin.brands.edit', compact('brand'));
    }

    public function update($id, Request $request)
    {
        $message = null;
        try {
            $data = [
                'brandname' => $request->brandname,
                'code' => $request->code,
            ];

            if ($request->hasFile('image')) {
                $old = DB::table('brands')->where('id', $id)->first();
                if ($old && $old->image) {
                    Storage::disk('public')->delete($old->image);
                }

                $data['image'] = $request->file('image')->store('brands', 'public');
            }

            DB::table('brands')->where('id', $id)->update($data);
            $message = 'Cập nhật thành công';
        } catch (Throwable $th) {
            $message = 'Cập nhật thất bại - Lỗi: ' . $th->getMessage();
        }

        return redirect()->route('brand.edit', $id)->withInput()->with('message', $message);
    }

    public function delete($id)
    {
        $message = null;
        try {
            $brand = DB::table('brands')->where('id', $id)->first();
            if ($brand && $brand->image) {
                Storage::disk('public')->delete($brand->image);
            }

            $rowaffect = DB::table('brands')->where('id', $id)->delete();
            $message = $rowaffect > 0 ? 'Xóa thành công' : 'Không có bản ghi nào được xóa';
        } catch (Throwable $th) {
            $message = 'Xóa thất bại - Lỗi: ' . $th->getMessage();
        }

        return redirect()->route('brand.index')->with('message', $message);
    }
}
