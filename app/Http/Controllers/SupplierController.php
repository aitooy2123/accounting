<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{

    public function index()
    {
        $data = Supplier::latest()->get();
        return view('suppliers.index', compact('data'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required'
        ]);

        Supplier::create([
            'supplier_code' => $request->supplier_code,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address
        ]);

        return redirect()->route('suppliers.index');
    }

    public function edit($id)
    {
        $row = Supplier::findOrFail($id);
        return view('suppliers.edit', compact('row'));
    }

    public function update(Request $request, $id)
    {

        $row = Supplier::findOrFail($id);

        $row->update([
            'supplier_code' => $request->supplier_code,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address
        ]);

        return redirect()->route('suppliers.index');
    }

    public function destroy($id)
    {
        Supplier::destroy($id);
        return redirect()->route('suppliers.index');
    }
}
