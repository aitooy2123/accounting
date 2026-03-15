<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
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
        $request->validate([
            'invoice_no' => 'required',
            'customer_id' => 'required|exists:customers,id',
            'due_date' => 'required|date',
            'items' => 'required|array'
        ]);

        $total = 0;

        foreach ($request->items as $item) {

            $qty = $item['qty'] ?? 0;
            $price = $item['price'] ?? 0;

            $total += $qty * $price;
        }

        Invoice::create([
            'invoice_no' => $request->invoice_no,
            'customer_id' => $request->customer_id,
            'total' => $total,
            'paid' => 0,
            'due_date' => $request->due_date,
            'status' => 0
        ]);

        return redirect()->route('invoice.index')
            ->with('success', 'สร้างใบแจ้งหนี้สำเร็จ');
    }

    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $customers = Customer::latest()->get();

        return view('invoice.edit', compact('invoice', 'customers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'invoice_no' => 'required',
            'due_date' => 'required|date'
        ]);

        $invoice = Invoice::findOrFail($id);

        $invoice->update([
            'invoice_no' => $request->invoice_no,
            'due_date' => $request->due_date
        ]);

        return redirect()->route('invoice.index')
            ->with('success', 'อัปเดตใบแจ้งหนี้สำเร็จ');
    }

    public function destroy($id)
    {
        Invoice::findOrFail($id)->delete();
        return back()->with('success', 'ลบข้อมูลสำเร็จ');
    }
}
