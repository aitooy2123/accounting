<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\RefBank;
use Illuminate\Http\Request;

class BankController extends Controller
{

    public function index()
    {
        $banks = Bank::with('refBank')
            ->orderBy('id','desc')
            ->get();

        return view('banks.index', compact('banks'));
    }


    public function create()
    {
        $refBanks = RefBank::orderBy('name')->get();
        return view('banks.create', compact('refBanks'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'ref_bank_id' => 'required|exists:ref_banks,id',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50'
        ]);

        Bank::create($data);

        return redirect()->route('banks.index')->with('success', 'เพิ่มบัญชีธนาคารสำเร็จ');
    }


    public function edit($id)
    {
        $bank = Bank::findOrFail($id);
        $refBanks = RefBank::orderBy('name')->get();

        return view('banks.edit', compact('bank', 'refBanks'));
    }


    public function update(Request $request, $id)
    {
        $bank = Bank::findOrFail($id);

        $data = $request->validate([
            'ref_bank_id' => 'required|exists:ref_banks,id',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50'
        ]);

        $bank->update($data);

        return redirect()->route('banks.index')->with('success', 'แก้ไขบัญชีธนาคารสำเร็จ');
    }


    public function destroy($id)
    {
        $bank = Bank::findOrFail($id);
        $bank->delete();

        return redirect()->route('banks.index')->with('success', 'ลบบัญชีธนาคารแล้ว');
    }
}
