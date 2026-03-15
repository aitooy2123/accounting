<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index()
    {
        $data = Customer::latest()->paginate(10);
        return view('customers.index', compact('data'));
    }

   public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_code' => 'nullable|max:20',
            'name' => 'required|max:255',
            'phone' => 'nullable|max:20',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable'
        ]);

        Customer::create([
            'customer_code' => $request->customer_code,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'เพิ่มลูกค้าสำเร็จ');
    }

    public function edit($id)
    {
        $row = Customer::findOrFail($id);
        return view('customers.edit', compact('row'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_code' => 'nullable|max:20',
            'name' => 'required|max:255',
            'phone' => 'nullable|max:20',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable'
        ]);

        $row = Customer::findOrFail($id);

        $row->update([
            'customer_code' => $request->customer_code,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'แก้ไขข้อมูลสำเร็จ');
    }

    public function destroy($id)
    {
        Customer::destroy($id);

        return redirect()->route('customers.index')
            ->with('success', 'ลบข้อมูลสำเร็จ');
    }
}
