<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    public function index()
    {
        $data = Expense::with('category')->latest()->get();
        return view('expense.index', compact('data'));
    }

    public function create()
    {
        $categories = Category::where('type', 'expense')->get();
        return view('expense.create', compact('categories'));
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'date' => 'required',
            'amount' => 'required|numeric',
            'category_id' => 'required',
            'description' => 'nullable|max:255'
        ]);

        $data['date'] = Carbon::createFromFormat('d/m/Y', $data['date'])->format('Y-m-d');

        Expense::create($data);

        return redirect()->route('expense.index')
            ->with('success', 'เพิ่มรายจ่ายสำเร็จ');
    }

    public function edit($id)
    {
        $data = Expense::findOrFail($id);
        $categories = Category::where('type', 'expense')->get();
        return view('expense.edit', compact('data', 'categories'));
    }

    public function update(Request $request, $id)
    {

        $data = $request->validate([
            'date' => 'required',
            'amount' => 'required|numeric',
            'category_id' => 'required',
            'description' => 'nullable|max:255'
        ]);

        $data['date'] = Carbon::createFromFormat('d/m/Y', $data['date'])->format('Y-m-d');

        $expense = Expense::findOrFail($id);

        $expense->update($data);

        return redirect()->route('expense.index')
            ->with('success', 'แก้ไขรายจ่ายสำเร็จ');
    }

    public function destroy($id)
    {
        Expense::findOrFail($id)->delete();
        return back();
    }
}
