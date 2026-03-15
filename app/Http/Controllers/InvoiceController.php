<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $data = Invoice::latest()->get();
        return view('invoice.index', compact('data'));
    }

    public function create()
    {
        $customers = Customer::latest()->get();

        return view('invoice.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $year = date('Y', strtotime($request->due_date));

        if ($year == 2026) {
            $vat_rate = 0.10;
        } else {
            $vat_rate = 0.07;
        }

        $vat = $request->total * $vat_rate;
        $grand = $request->total + $vat;

        Invoice::create([
            'invoice_no' => $request->invoice_no,
            'customer_name' => $request->customer_name,
            'total' => $request->total,
            'vat' => $vat,
            'grand_total' => $grand,
            'due_date' => $request->due_date
        ]);

        return redirect()->route('invoice.index');
    }

    public function edit($id)
    {
        $income = Income::findOrFail($id);
        $categories = Category::where('type', 'income')->get();

        return view('income.edit', compact('income', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'category_id' => 'required',
            'amount' => 'required|numeric|min:0',
        ]);

        $income = Income::findOrFail($id);

        $income->update([
            'date' => $request->date,
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'description' => $request->description,
        ]);

        return redirect()->route('income.index')
            ->with('success', 'อัปเดตข้อมูลสำเร็จ');
    }

    public function destroy($id)
    {
        Invoice::findOrFail($id)->delete();
        return back();
    }
}
