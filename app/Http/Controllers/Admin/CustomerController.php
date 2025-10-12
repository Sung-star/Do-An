<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::withCount('orders')->get();
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'tel' => 'required|string|max:20|unique:customers,tel',
            'address' => 'required|string|max:255',
        ]);

        Customer::create($request->only(['fullname', 'tel', 'address']));

        return redirect()->route('ad.customers.index')->with('success', 'Thêm khách hàng thành công');
    }


    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'tel' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $customer->update($request->only(['fullname', 'tel', 'address']));

        return redirect()->route('ad.customers.index')->with('success', 'Cập nhật khách hàng thành công');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('ad.customers.index')->with('success', 'Xóa khách hàng thành công');
    }
}
