<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Invoice;
use DB;

class DashboardController extends Controller
{

    public function index()
    {
        $income = Income::sum('amount');
        $expense = Expense::sum('amount');
        $profit = $income - $expense;
        $unpaid = Invoice::whereRaw('total > paid')
            ->sum(DB::raw('total - paid'));

        return view('dashboard', compact('income', 'expense', 'profit', 'unpaid'));
    }
}
