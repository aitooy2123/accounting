<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Category;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Income::with('category');

        // 🔍 ค้นหาหมวด
        if ($request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->category . '%');
            });
        }

        // 📅 ช่วงวันที่
        if ($request->date_from) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        // 💰 จำนวนเงิน
        if ($request->amount) {
            $query->where('amount', $request->amount);
        }

        $data = $query->latest()->paginate(10)->withQueryString();

        return view('income.index', compact('data'));
    }

    public function create()
    {
        $categories = Category::where('type', 'income')->get();
        return view('income.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'date' => 'required|date',
            'category_id' => 'required',
            'amount' => 'required|numeric|min:0'
        ]);

        Income::create($request->all());

        return redirect()->route('income.index')
            ->with('success', 'บันทึกสำเร็จ');
    }


    public function edit($id)
    {
        $income = Income::findOrFail($id);
        $categories = Category::where('type', 'income')->get();

        // dd($id, $income->id);

        return view('income.edit', compact('income', 'categories'));
    }


    public function update(Request $request, $id)
    {
        $data = Income::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('income.index')->with('success', 'อัปเดตข้อมูลสำเร็จ');
    }

    public function destroy($id)
    {
        Income::findOrFail($id)->delete();
        return back();
    }
}
