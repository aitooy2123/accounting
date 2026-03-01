<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $data = Expense::with('category')->latest()->get();
        return view('expense.index', compact('data'));
    }

    public function create()
    {
        $categories = Category::where('type','expense')->get();
        return view('expense.create', compact('categories'));
    }

    public function store(Request $request)
    {
        Expense::create($request->all());
        return redirect()->route('expense.index');
    }

    public function edit($id)
    {
        $data = Expense::findOrFail($id);
        $categories = Category::where('type','expense')->get();
        return view('expense.edit', compact('data','categories'));
    }

    public function update(Request $request, $id)
    {
        $data = Expense::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('expense.index');
    }

    public function destroy($id)
    {
        Expense::findOrFail($id)->delete();
        return back();
    }
}
