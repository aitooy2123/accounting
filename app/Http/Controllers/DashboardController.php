<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\Expense;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // รับปีจาก query string หรือใช้ปีปัจจุบัน
        $year = $request->input('year', date('Y'));

        // รายรับรายเดือน
        $income = Income::whereYear('date', $year)
            ->selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        // รายจ่ายรายเดือน
        $expense = Expense::whereYear('date', $year)
            ->selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        // เดือนภาษาไทย
        $thaiMonths = [
            1 => 'ม.ค.', 2 => 'ก.พ.', 3 => 'มี.ค.', 4 => 'เม.ย.',
            5 => 'พ.ค.', 6 => 'มิ.ย.', 7 => 'ก.ค.', 8 => 'ส.ค.',
            9 => 'ก.ย.', 10 => 'ต.ค.', 11 => 'พ.ย.', 12 => 'ธ.ค.'
        ];

        $labels = [];
        $incomeData = [];
        $expenseData = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = $thaiMonths[$i];
            $incomeData[] = $income[$i] ?? 0;
            $expenseData[] = $expense[$i] ?? 0;
        }

        // Summary
        $totalIncome = array_sum($incomeData);
        $totalExpense = array_sum($expenseData);
        $profit = $totalIncome - $totalExpense;

        return view('dashboard', compact(
            'year',
            'labels',
            'incomeData',
            'expenseData',
            'totalIncome',
            'totalExpense',
            'profit'
        ));
    }
}
